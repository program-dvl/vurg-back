<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
     /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @var App\Helpers\ResponseHelper
     */
    private $responseHelper;

    /**
     * @var App\Repositories\Auth\AuthRepository
     */
    private $authRepository;

    /**
     * @var App\Repositories\User\UserRepository;
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param Illuminate\Http\ResponseHelper $responseHelper
     * @param App\Repositories\Auth\AuthRepository $authRepository
     * @param App\Repositories\User\UserRepository $userRepository
     * @return void
     */
    public function __construct(
        Request $request,
        ResponseHelper $responseHelper,
        AuthRepository $authRepository,
        UserRepository $userRepository
    ) {
        $this->request = $request;
        $this->responseHelper = $responseHelper;
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    public function register(Request $request): JsonResponse
    {
        // Server side validations
        $validation = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,NULL,deleted_at',
            'password' => 'required'
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
        
        $requestData = [
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'name' => $request->name,
            'username' => substr(str_replace(' ','',strtolower($request->name)), 0, 5).rand(1,100000)
        ];

        // Store user
        $user = $this->authRepository->store($requestData);

        event(new Registered($user));

        Auth::login($user);

        // Set response data
        $apiStatus = Response::HTTP_OK;
        $apiMessage = 'User created successfully.';
        $apiData = $user->toArray();

        return $this->responseHelper->success($apiStatus, $apiMessage, $apiData);
    }

    public function login(Request $request):JsonResponse
    {        
        // Server side validations
        $validation = [
            'email' => 'required|exists:users,email,deleted_at,NULL',
            'password' => 'required'
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

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = $this->userRepository->userDetailsByEmail($request->email);
            // Set response data
            $apiStatus = Response::HTTP_OK;
            $apiMessage = 'User logged in successfully.';
            $apiData = $user->toArray();

            return $this->responseHelper->success($apiStatus, $apiMessage, $apiData);
        }

        // Set response data
        $apiStatus = Response::HTTP_NOT_FOUND;
        $apiMessage = 'The provided credentials do not match our records.';

        return $this->responseHelper->success($apiStatus, $apiMessage);
    }
}
