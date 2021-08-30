<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Twilio\Rest\Client;
use Validator;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function __construct(
        ResponseHelper $responseHelper
    ) {
        $this->twilio = new Client(env("TWILIO_ACCOUNT_SID", "AC1e542184f426879f19c494343d1d25a6"), 
        env("TWILIO_AUTH_TOKEN", "846d6e2cf7440097be3da08b289be2ba"));
        $this->responseHelper = $responseHelper;
    }
    
    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(["msg" => "Invalid/Expired url provided."], 401);
        }
    
        $user = User::findOrFail($user_id);
        
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    
        return redirect()->to(config('site.SPA_URL').'dashboard');
    }
    
    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], 400);
        }
    
        auth()->user()->sendEmailVerificationNotification();
    
        return response()->json(["msg" => "Email verification link sent on your email id"]);
    }

    public function sendOTP(Request $request): JsonResponse
    {

        // Server side validations
        $validation = [
            'phone' => 'required',
            'phone_code' => 'required'
        ];

       $user = $request->user();
       User::where("id", Auth::id())->update(['phone_code' => $request->phone_code]);
        
        $validator = Validator::make($request->all(), $validation);

        // If request parameter have any error
        if ($validator->fails()) {
            return $this->responseHelper->error(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
                $validator->errors()->first()
            );
        }

        $verification = $this->twilio->verify->v2->services(env("TWILIO_VERIFICATION_SID"))
                            ->verifications
                            ->create($request->phone, "sms");          
        // Set response data

        $apiStatus = Response::HTTP_OK;
        $apiMessage = 'OTP sent on your mobile successfully.';

        return $this->responseHelper->success($apiStatus, $apiMessage);

    }

    public function verifyOTP(Request $request): JsonResponse
    {
        // Server side validations
        $validation = [
            'code' => 'required|digits:4',
            'phone' => 'required'
        ];

        $validator = Validator::make($request->all(), $validation);

        // If request parameter have any error
        if ($validator->fails()) {
            return $this->responseHelper->error(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
                $validator->errors()->first()
            );
        }

        $verification_check = $this->twilio->verify->v2->services(env("TWILIO_VERIFICATION_SID"))
            ->verificationChecks
            ->create($request->code, ["to" => $request->phone]);

        if (!$verification_check->valid) {
            // Set response data
            $apiMessage = 'OTP verification failed.';
            return $this->responseHelper->error(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
                $apiMessage
            );
        }

        $apiStatus = Response::HTTP_OK;
        $apiMessage = 'OTP verified successfully.';

        return $this->responseHelper->success($apiStatus, $apiMessage);
            

    }
}
