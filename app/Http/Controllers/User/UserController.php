<?php

namespace App\Http\Controllers\User;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\User\UserRepository;
use App\Repositories\Offer\OfferTradeFeedbackRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserSettings;
use Validator;
use File;
use neto737\BitGoSDK\BitGoSDK;
use neto737\BitGoSDK\BitGoExpress;
use neto737\BitGoSDK\Enum\CurrencyCode;

class UserController extends Controller
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
     * @var App\Repositories\User\UserRepository
     */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param Illuminate\Http\ResponseHelper $responseHelper
     * @param App\Repositories\Auth\UserRepository $userRepository
     * @return void
     */
    public function __construct(
        Request $request,
        ResponseHelper $responseHelper,
        UserRepository $userRepository,
        OfferTradeFeedbackRepository $offerTradeFeedbackRepository
    ) {
        $this->request = $request;
        $this->responseHelper = $responseHelper;
        $this->userRepository = $userRepository;
        $this->offerTradeFeedbackRepository = $offerTradeFeedbackRepository;
    }

    

    public function index(Request $request): JsonResponse
    {
        // Get user
        $user = $this->userRepository->userDetails(8);

        // Set response data
        $apiStatus = Response::HTTP_OK;
        $apiMessage = 'User details listed successfully.';
        $apiData = $user->toArray();

        return $this->responseHelper->success($apiStatus, $apiMessage, $apiData);
    }

    public function uploadAvatar(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPG,JPEG,PNG',
            ]);
    
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }
    
            $image = $request->file('profile_pic');
            $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/user_profile');
            $image->move($destinationPath, $input['imagename']);
    
            $userDetails = User::find(Auth::id());
    
            if(!empty($userDetails)) {
                if(!empty($userDetails->avatar_image)) {
                    $imagePath = public_path('/user_profile') . "/" .$userDetails->avatar_image;
                    if(File::exists($imagePath)){
                        unlink($imagePath);
                    }    
                }
                User::where('id' , Auth::id())->update(['avatar_image' => $input['imagename']]);
                // $imageUrl = public_path('/user_profile') . '/' .$input['imagename'];
                $imageUrl = asset('user_profile/'.$input['imagename']);
                return $this->sendSuccess($imageUrl, 'Avatar Image uploaded successfully');
            }
        } catch (\Exception $e) {
            return $this->sendError();
        }        
    }

    public function removeAvatar(Request $request)
    {
        try {
            $userDetails = User::find(Auth::id());

            if(empty($userDetails)) {
                return $this->sendError("User details not found");
            }
    
            if(!empty($userDetails)) {
                if(!empty($userDetails->avatar_image)) {
                    $imagePath = public_path('/user_profile') . "/" .$userDetails->avatar_image;
                    if(File::exists($imagePath)){
                        unlink($imagePath);
                        User::where('id' , Auth::id())->update(['avatar_image' => null]);
                    }
                }
                return $this->sendSuccess(array(), 'Avatar Image removed successfully');
            }
        } catch (\Exception $e) {
            return $this->sendError();
        }        
    }

    public function changeUsername(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
            ]);
    
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $input = $request->all();            
            $userDetails = User::find(Auth::id());

            if(empty($userDetails)) {
                return $this->sendError("User details not found");
            }

            if($userDetails->is_username_changed == 1) {
                return $this->sendError("You can only change username one time only.");
            }

            if($userDetails->username == $input['username']) {
                return $this->sendError("This is same as your current username. Add new username.");
            }
    
            if(!empty($userDetails)) {
                if(!empty($userDetails->username)) {
                    $isOtherUserExist = User::where('username', $input['username'])->count();

                    if($isOtherUserExist > 0) {
                        return $this->sendError("Username already exist.");
                    }

                    User::where('id' , Auth::id())->update(['username' => $input['username'], 'is_username_changed' => 1]);
                }
                return $this->sendSuccess(User::find(Auth::id()), 'Username changed sucessfully');
            }
        } catch (\Exception $e) {
            return $this->sendError();
        }        
    }

    public function updateProfile(Request $request)
    {
        try {
            $input = $request->all();
            $userDetails = User::find(Auth::id());

            if(empty($userDetails)) {
                return $this->sendError("User details not found");
            }

            $dataUpdate = [
                'bio' => !empty($input['bio']) ? $input['bio'] : '',
                'preferred_currency' => !empty($input['preferred_currency']) ? $input['preferred_currency'] : null,
                'timezone' => !empty($input['user_timezone']) ? $input['user_timezone'] : null,
                'display_name' => !empty($input['display_name']) ? $input['display_name'] : 1,
            ];

            User::where('id', Auth::id())->update($dataUpdate);
            
            if(!empty($input['settings'])) {
                foreach($input['settings'] as $setting) {
                    
                    UserSettings::updateOrCreate([
                        'setting_id' => $setting['setting_id'],
                        'user_id' => Auth::id(),
                    ],[
                        'web' => $setting['web'],
                        'email' => $setting['email'],
                        'other_setting' => !empty($setting['other_setting']) ? $setting['other_setting'] : 0
                    ]);
                }
            }
            
            return $this->sendSuccess(User::find(Auth::id()), 'Profile updated sucessfully');
        } catch (\Exception $e) {
            
            return $this->sendError();
        }        
    }

    public function getProfile(Request $request, $userId = 0)
    {
        try {
            $userId = !empty($userId) ? $userId : Auth::id();
            $user = $this->userRepository->userDetailsForProfile($userId);

            $user = $this->offerTradeFeedbackRepository->getTotalFedbackCount($user);
            return $this->sendSuccess($user, 'Profile fetched sucessfully');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }        
    }

    public function changePassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required'                
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $user = $this->userRepository->userDetails(Auth::id());

            $input = $request->all();
            
            if(!Hash::check($input['current_password'], $user->password)) {
                return $this->sendError("Invalid current password");
            }

            if($input['new_password'] != $input['confirm_password']) {
                return $this->sendError("New password and Confirm password does not match.");
            }

            $dataUpdate = ["password" => Hash::make($input['new_password'])];
            $this->userRepository->updateUserDetails(Auth::id(), $dataUpdate);

            return $this->sendSuccess($user, 'Password changed');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }        
    }

    public function add() {
       
        //$bitgo->walletId = 'YOUR_WALLET_ID_HERE';
        // $bitgo = new BitGoSDK('v2x3c0987c2b9948dfdac805a5fc88cec8f654be915a285474e6230be5bae47ad2e', 'tbtc', true);
        // $createAddress = $bitgo->createWallet(CurrencyCode::BITCOIN, 'Bitcoin');
        // dd($createAddress);

        $hostname = 'localhost';
        $port = 3080;
        $coin = CurrencyCode::BITCOIN_TESTNET; 
        $bitgoExpress = new BitGoExpress($hostname, $port, $coin);
        $bitgoExpress->accessToken = 'v2x3c0987c2b9948dfdac805a5fc88cec8f654be915a285474e6230be5bae47ad2e';
        $generateWallet = $bitgoExpress->generateWallet('Vurg_Coin','string');
 dd($generateWallet);
        //$hostname = 'app.bitgo-test.com';
        // $hostname = 'app.bitgo-test.com';
        // $port = 3080;
        // $coin = CurrencyCode::BITCOIN;
        // $bitgo = new BitGoExpress($hostname, $port, $coin);
        // $bitgo->accessToken = 'd80089ee537b24f8635af24bf9de7b074aab7145d9c5ed1ac6fad9d08faf6719';
        // $keyChain = $bitgo->createKeychain();
        // dd($keyChain);
        // // //$bitgo->walletId = 'YOUR_WALLET_ID_HERE';
        
        // $createAddress = $bitgo->addWallet('Bitcoin', 2, 3, []);
     //   dd($createAddress);
    }
 
    public function express() {
        $hostname = 'localhost';
        $port = 3080;
        $coin = CurrencyCode::BITCOIN_TESTNET;
 
        $bitgoExpress = new BitGoExpress($hostname, $port, $coin);
        $bitgoExpress->accessToken = 'v2x3c0987c2b9948dfdac805a5fc88cec8f654be915a285474e6230be5bae47ad2e';
        $keyChain = $bitgoExpress->createKeychain();
        dd($keyChain);
        //$generateWallet = $bitgoExpress->generateWallet('LABEL_HERE', 'CREATE_A_NEW_PASSPHRASE_HERE');
        //var_dump($generateWallet);
    }
}
