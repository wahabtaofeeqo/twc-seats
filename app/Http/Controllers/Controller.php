<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function okResponse($message, $data, $code = 200)
    {
        return response([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function errResponse($message, $code = 400, $error = null)
    {
        return response([
            'status' => false,
            'message' => $message,
            'error' => $error,
        ], $code);
    }
}
