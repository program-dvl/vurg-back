<?php


namespace App\Helpers;
use Illuminate\Support\Facades\Response;


class ResponseManager
{
    static function createResponse ($data = [], $code = 200 , $message = null, $success = true){
        $res['data'] = $data;
        $res['code'] = $code;
        $res['message'] = $message;
        $res['success'] = $success;
        return response()->json($res);
    }

    static function customResponseMessage ($message = null, $code = 200 , $success = true, $data = []){
        $res['message'] = $message;
        $res['code'] = $code;
        $res['success'] = $success;
        $res['data'] = $data;
        return response()->json($res);
    }

    static function sendResponse ($data = [], $code = 200 , $message = null, $success = true){
        $res['data'] = $data;
        $res['code'] = $code;
        $res['message'] = $message;
        $res['success'] = $success;
        return response()->json($res);
    }

    static function sendSuccess ($data = [], $message = 'success', $code = 200){
        $res['data'] = $data;
        $res['code'] = $code;
        $res['message'] = $message;
        $res['success'] = GLOBAL_TRUE;
        return response()->json($res);
    }

    static function sendError ($message = GLOBAL_SOMETHING_WANTS_TO_WRONG , $type = '1', $code = '501'){
        $res['data'] = [];
        $res['code'] = $code;
        $res['type'] = $type;
        $res['message'] = $message;
        $res['success'] = GLOBAL_FALSE;
        return response()->json($res);
    }

    static function sendValidationError($errors, $message = 'error', $code = ERROR_502){
        $res['data'] = ['errors' => $errors];
        $res['code'] = $code;
        $res['type'] = MESSAGE_SNACKBAR;
        $res['message'] = $message;
        $res['success'] = GLOBAL_FALSE;
        return response()->json($res);
    }

//    static function sendErrorResponseForOTP ($data = [], $code = 200 ,  $success = true){
//        $res['data'] = $data;
//        $res['code'] = $code;
//        $res['success'] = $success;
//        return response()->json($res);
//    }

//    static function customResponse ($data = [],$header_content= null,$code = 200 , $message = null, $success = true){
//        $res['data'] = $data;
//        $res['header_content'] = $header_content;
//        $res['code'] = $code;
//        $res['message'] = $message;
//        $res['success'] = $success;
//        return response()->json($res);
//    }

//    static function sendErrorResponse ($code = 200 , $message = null, $success = true){
//        $res['code'] = $code;
//        $res['message'] = $message;
//        $res['success'] = $success;
//        return response()->json($res);
//    }

//    static function customResponseForLabel ($data = [],$footer_content= null,$code = 200 , $message = null, $success = true){
//        $res['data'] = $data;
//        $res['footer_label'] = $footer_content;
//        $res['code'] = $code;
//        $res['message'] = $message;
//        $res['success'] = $success;
//        return response()->json($res);
//    }

}
