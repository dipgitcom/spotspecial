<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\Comment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    use ApiResponse;
    public function  allBlog(Request $request)
    {
        $blogs = Blog::where('status', 1)->select('id', 'title', 'image', 'description')->get();
        collect($blogs)->each(function ($blog) {
            $blog->image = asset($blog->image);
        });
        if ($blogs->count() > 0) {
            return $this->success($blogs, 'All  Blogs retrieved successfully', 200);
        }
        return $this->success([], ' Blogs not available', 200);
    }

    public function blogDetails(Request $request)
    {
        $blog = Blog::where('status', 1)->where('id', $request->blog_id)->select('id', 'title', 'image', 'description', 'created_at')->first();
        if (!$blog) {
            return $this->error([], 'Blog not found', 404);
        }
        $blog->image = asset($blog->image);


        if ($blog->count() > 0) {
            return $this->success($blog, 'Blogs Details retrieved successfully', 200);
        }
        return $this->success([], ' Blogs not available', 200);
    }


    public function commentStore(Request $request)
    {

        $userId  = Auth::guard('api')->user()->id;

        $validator = Validator::make($request->all(), [
            'blog_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 'Validation Error', 400);
        }


        if ($userId == null) {
            return $this->error([], 'UnAuthorized for Comment', 400);
        }

        Comment::create([
            'blog_id' => $request->blog_id,
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment
        ]);

        return $this->success($request->all(), 'Blogs Details retrieved successfully', 200);
    }

    public function getComment(Request $request)
    {
        $comments = Comment::where('blog_id', $request->blog_id)->with('user')->get();

        if ($comments->count() > 0) {
            $commentData = $comments->map(function ($comment) {
                return [
                    'id'         => $comment->id,
                    'user_id'    => $comment->user_id,
                    'blog_id'    => $comment->blog_id,
                    'name'       => $comment->name ?? optional($comment->user)->name,
                    'comment'    => $comment->comment,
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                ];
            });

            return $this->success($commentData, 'Comments retrieved successfully', 200);
        }

        return $this->success([], 'Comments not found', 200);
    }
}
