<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlockedUserApiController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\Contact\ContactSectionController;
use App\Http\Controllers\Api\Contact\ContactSubmissionController;
use App\Http\Controllers\Api\Faq\FaqController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\FollowApiController;
use App\Http\Controllers\Api\Footer\FooterController;
use App\Http\Controllers\Api\Gallery\GalleryController;
use App\Http\Controllers\Api\HeroSectionController;
use App\Http\Controllers\Api\Navbar\NavbarController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\ProcessStep\ProcessStepController;
use App\Http\Controllers\Api\ReportUserApiController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ServicePackages\ServicePackageController;
use App\Http\Controllers\Api\TagApiController;
use App\Http\Controllers\Api\Testimonial\TestimonialController;
use App\Http\Controllers\Api\TruckManageApiController;
use App\Http\Controllers\Api\UserNotificationSettingController;
use App\Http\Controllers\Api\WhyUsPanel\WhyUsPanelController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    // user login and logout
    Route::post('/user-login', 'login');
    Route::post('/user-signup', 'signup');
    Route::post('/user-logout', 'logout');
    // user otp verify
    Route::post('/send-otp', 'sendOtp');
    Route::post('/verify-otp', 'checkOtp');
    Route::post('/password/create', 'PasswordCreate');
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('verify/email_otp', [AuthController::class, 'verifyEmailOtp']);
    // user profile
    Route::post('/update-user', [AuthController::class, 'updateUser']);
    Route::post('/delete-account', [AuthController::class, 'deleteSelfAccount'])->middleware('auth:api');
    Route::post('/user/profile/reset-password', [AuthController::class, 'userResetPassword'])->middleware('auth:api');

    Route::post('forget/password', 'forgetPassword');
    Route::post('otp/check', 'checkOtp');
    Route::post('reset/password', 'resetPassword');
    Route::post('/resend/otp', 'resendOtp');

});

Route::middleware('auth:api')->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('/user/profile/set', 'userProfileSet');
        Route::post('/profile/image/update', 'ProfileImageUpdate');

    });

});

Route::prefix('admin')->group(function () {
    Route::get('navbar', [NavbarController::class, 'show']);

    Route::get('hero-section/{key?}', [HeroSectionController::class, 'show']);
    Route::post('hero-section/{key?}', [HeroSectionController::class, 'update']);

    Route::get('service-packages', [ServicePackageController::class, 'index']);
    Route::post('service-packages', [ServicePackageController::class, 'store']);  // <--- Add this line
    Route::get('service-packages/{id}', [ServicePackageController::class, 'show']);
    Route::put('service-packages/{id}', [ServicePackageController::class, 'update']);
    Route::delete('service-packages/{id}', [ServicePackageController::class, 'destroy']);

    Route::get('why-us-panels', [WhyUsPanelController::class, 'index']);

    Route::get('process-steps', [ProcessStepController::class, 'index']);

    Route::get('gallery', [GalleryController::class, 'index']);

    Route::get('testimonials', [TestimonialController::class, 'index']);

    Route::get('faqs', [FaqController::class, 'index']);

    Route::get('contact-section', [ContactSectionController::class, 'index']);
    Route::post('contact-submit', [ContactSubmissionController::class, 'store']);
    Route::delete('admin/contact-fields/{id}', [ContactSectionController::class, 'destroy'])->name('contact-fields.destroy');

    Route::get('footer', [FooterController::class, 'index']);
});
