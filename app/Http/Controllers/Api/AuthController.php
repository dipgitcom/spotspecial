<?php

namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpSend;

use App\Traits\ApiResponse;
use Illuminate\Support\Str;
use App\Models\SocialMedias;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Mail\ForgetPasswordMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Follow;



class AuthController extends Controller
{
    use ApiResponse;


    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        return $this->error([], 'Invalid credentials', 401);
    }

    if ($user->is_blocked) {
        return $this->error([], 'Your account is blocked. Please contact support.', 403);
    }

    if ($user->is_disabled) {
        return $this->error([], 'Your account is disabled. Please contact support.', 403);
    }

    if (! $token = JWTAuth::attempt($credentials)) {
        return $this->error([], 'Invalid credentials', 401);
    }

    return $this->success([
        'token' => $token,
        'user' => $user,
    ], 'Logged in successfully.');
}


    public function logout()
    {
        try {
            // Get token from request
            $token = JWTAuth::getToken();

            if (!$token) {
                return $this->error([], 'Token not provided', 401);
            }

            // Invalidate token
            JWTAuth::invalidate($token);

            return $this->success([], 'Successfully logged out', 200);
        } catch (JWTException $e) {
            return $this->error([], 'Failed to logout. ' . $e->getMessage(), 500);
        }
    }


   
// user signup
public function signup(Request $request)
{
    // return $this->sendOtp($request);
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255|min:3',
        'email' => [
            'required',
            'email:rfc,dns,filter',
            'max:255',
            'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
        ],
    ]);

    if ($validator->fails()) {
        return $this->error($validator->errors(), 'Validation Error', 422);
    }

    $otp = rand(100000, 999999);
    $user = User::where('email', '=', $request->email)->first();
    if (!$user) {
        $user = new User();
        $user->email = $request->email;
    }
    $user->name = $request->name;
    $user->otp = $otp;
    $user->otp_expires_at = now()->addMinutes(5);
    $user->save();

    // --- AUTO-FOLLOW OWNER LOGIC START ---
    $ownerId = 1; // Change this to your owner's user id
    if ($user->id != $ownerId) { // Prevent owner following self
        Follow::firstOrCreate([
            'follower_id' => $user->id,
            'following_id' => $ownerId,
        ], [
            'status' => 'accepted',
        ]);
    }
    // --- AUTO-FOLLOW OWNER LOGIC END ---

    Mail::to($request->email)->send(new OtpSend($user));
    return $this->success($user, 'OTP sent to your email, Please verify it.', 200);
}


   public function checkOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        try {
            $user = User::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

            if (!$user) {
                return $this->error([], 'Invalid OTP', 401);
            }

            if ($user->otp_expires_at < now()) {
                return $this->error([], 'OTP expired', 401);
            }

            $user->email_verified_at = now();
            $user->otp_verified_at = now();
            $user->reset_password_token = Str::random(60);
            $user->reset_password_token_expires_at = now()->addMinutes(5);
            $user->save();

            return $this->success($user, 'OTP verified successfully');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }


public function PasswordCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'reset_password_token'=>'required',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 422);
        }

        try {
            $user = User::where('email', $request->email)
                ->where('reset_password_token', $request->reset_password_token)
                ->first();

            if (!$user) {
                return $this->error([], 'Invalid token or email.', 401);
            }

            if ($user->reset_password_token_expires_at < now()) {
                return $this->error([], 'Token expired', 401);
            }

            $user->password = Hash::make($request->password);
            $user->email_verified_at = now();
            // $user->last_login_at = now();
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->otp_verified_at = null;
            $user->reset_password_token = null;
            $user->reset_password_token_expires_at = null;
            $user->save();
            $token = JWTAuth::fromUser($user);
            $data = [
                'id'            => $user->id,
                'name'          => $user->name ?? '',
                'email'         => $user->email,
                'token'         => $token,
            ];
            return $this->success($data, 'Account created successfully');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }


 public function userProfileSet(Request $request){
    try{
        $validator=Validator::make($request->all(),[
            'truck_id'=>'nullable|exists:truck_manages,id',
        ]);
        if($validator->fails()){
            return $this->error($validator->errors(), 'Validation Error', 422);
        }

    $id=Auth::guard('api')->user()->id;
    $user=User::where('id',$id)->first();
     if($user){
          $user->name=$request->name ?? '';
          $user->phone_number =$request->phone_number ??'';
            $user->short_bio =$request->short_bio ??'';
            $user->dob=$request->dob ??'';
            $user->address=$request->address ??'';
            $user->city=$request->city ??'';
            $user->work_information=$request->work_information ??'';
            $user->user_type=$request->user_type ??'civilian';
            if($request->user_type=='trucker'){
              $user->truck_id=$request->truck_id ??'';
               if($request->hasFile('dot_information')){
                $file = $request->file('dot_information');
                $extension = $file->Extension();
                $file_name = time() . '.' . $extension;
                $path = 'uploads/dot_information/';
                $file->move($path, $file_name);
                $user->dot_information = $path.$file_name;
               }

            }
         $user->height=$request->height ??'';
         $user->weight=$request->weight ??'';
         $user->gender=$request->gender ??'';
         $user->relationship_status=$request->relationship_status ??'';
         $user->sexual_orientation=$request->sexual_orientation ??'';
         $user->hiv_status=$request->hiv_status ??'';

       foreach($request->social_media as $media){
        $us_media = new SocialMedias();
        $us_media->user_id = $user->id;
        $us_media->link = $media ?? '';
        $us_media->save();
       }
       $user->save();
       $data=[
        'user'=>$user,
        'social_media'=>$user->social_media()->get(),
        'truck'=>$user->truck()->first()
       ];
        return $this->success($data, 'Account created successfully');
     }
    }
    catch (\Exception $e){
        return $this->error((object)[],$e->getMessage(),400);
    }
 }



public function ProfileImageUpdate(Request $request){
    $validator=Validator::make($request->all(),[
        'profile_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);
    if($validator->fails()){
        return $this->error($validator->errors(), 'Validation Error', 422);

    }

    $user=Auth::guard('api')->user();
    if($request->hasFile('profile_image')){
        $file = $request->file('profile_image');
        $extension = $file->Extension();
        $file_name = time() . '.' . $extension;
        $path = 'uploads/profile_photo/';
        $file->move($path, $file_name);
        $user->profile_image = $path.$file_name;

        if($request->hasFile('cover_image')){
            $file = $request->file('cover_image');
            $extension = $file->Extension();
            $file_name = time() . '.' . $extension;
            $path = 'uploads/cover_image/';
            $file->move($path, $file_name);
            $user->cover_image = $path.$file_name;
           }
        $user->save();
        $data=[
            'profile_image'=>asset( $user->profile_image),
            'cover_image'=>asset( $user->cover_image)??'',
        ];
        return $this->success($data, 'Profile photo updated successfully');
    }
}





 public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);

        if ($validator->fails()) {
               return $this->error($validator->errors(), 'Validation Error', 422);
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
               return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'data' => (object)[]
                ], 404);
            }

            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(2);
            $user->save();

            $user->makeHidden(['password','created_at','updated_at']);
            $user->makeVisible(['otp', 'otp_expires_at']);


            Mail::to($user->email)->send(new ForgetPasswordMail($user));




            return $this->success($user, 'OTP sent successfully');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }



    public function resetPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed',
            'email' => 'required|email',
            'reset_password_token' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors());
        }

        try {
            $user = User::where('email', $request->email)
                ->whereNotNull('otp_verified_at')
                ->where('reset_password_token', $request->reset_password_token)
                ->first();

            if (!$user) {
                return $this->error([], 'Please try again', 401);
            }

            if ($user->reset_password_token_expires_at < now()) {
                return $this->error([], 'Token expired', 401);
            }

            $user->password = Hash::make($request->password);
            $user->save();
            $logout=$this->logout();
            // dd($logout);
            return $this->success($user, 'Password reset successfully');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return $this->notFound([], 'User not found');
            }

            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->otp_expires_at = now()->addSeconds(30);
            $user->save();

            Mail::to($user->email)->send(new ForgetPasswordMail($user));

            return $this->success($user, 'OTP resent successfully');
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }

























}
