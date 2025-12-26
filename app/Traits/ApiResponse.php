<?php

namespace App\Traits;

trait ApiResponse
{


    public function error(Mixed $data = [], $message = null, $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }



public function success($data = [], $message = 'Success', $code = 200)
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function created($data = [], $message = 'Content created', $code = 201)
    {
       return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function errors($errors = [], $message = 'Something went wrong',  $code = 500)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }

    public function validationError($errors = [], $message = 'Validation failed',$code = 422)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors
        ], $code);
    }

    public function notFound($data=[],$message = 'Resource not found',$code = 404)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function unauthorized($data=[],$message = 'Unauthorized access',$code = 401)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function forbidden($data=[],$message = 'Forbidden',$code = 403)
    {
       return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    public function pageExpired($data=[],$message = 'Page expired. Please refresh and try again.',$code = 419)
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'data'    => $data
        ], $code);
    }




}
