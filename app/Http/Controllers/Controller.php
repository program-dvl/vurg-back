<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function sendSuccess ($data = [], $message = 'success', $code = 200 , $extraCode = 200){
        $res['data'] = $data;
        $res['code'] = $code;
        $res['extra_code'] = $extraCode;
        $res['message'] = $message;
        $res['success'] = GLOBAL_TRUE;
        return response()->json($res);
    }

    public function sendError ($message = GLOBAL_SOMETHING_WANTS_TO_WRONG , $code = 501, $extraCode = 501){
        $res['code'] = $code;
        $res['extra_code'] = $extraCode;
        $res['message'] = $message;
        $res['success'] = GLOBAL_FALSE;
        return response()->json($res);
    }

    static function sendValidationError($errors, $message = 'error', $code = 502){
        $res['data'] = ['errors' => $errors];
        $res['code'] = $code;
        $res['message'] = $message;
        $res['success'] = GLOBAL_FALSE;
        return response()->json($res);
    }
}
