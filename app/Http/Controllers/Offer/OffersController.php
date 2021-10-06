<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OfferTags;
use App\Models\PaymentMethods;
use App\Models\PaymentMethodCategory;
use Illuminate\Http\Response;
use Validator;
use App\Repositories\Offer\OfferRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Offer\OfferTradeFeedbackRepository;

class OffersController extends Controller
{
    /**
     * @var App\Repositories\User\UserRepository
     */
    private $userRepository;

    public function __construct(
        Request $request,
        OfferRepository $offerRepository,
        UserRepository $userRepository,
        OfferTradeFeedbackRepository $offerTradeFeedbackRepository
    ) {
        $this->request = $request;
        $this->offerRepository = $offerRepository;
        $this->userRepository = $userRepository;
        $this->offerTradeFeedbackRepository = $offerTradeFeedbackRepository;
        
    }
    
    /**
     * fetch logged in user offers.
     * POST|HEAD /index
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        try {
            $input = $request->only(['page_number', 'per_page', 'currency_type', 'offer_type', 'user_id']);
            $rules = [
                'page_number' => 'required|numeric|min:1',
                'per_page' => 'required|numeric|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $skip = ($input['page_number'] - 1) * $input['per_page'];
            $take = $input['per_page'];

            $offerType = $input['offer_type'];
            $currencyType = !empty($input['currency_type']) ? $input['currency_type'] : 0;
            $userId = !empty($input['user_id']) ? $input['user_id'] : Auth::id();

            $offers = $this->offerRepository->getOfferDetails($userId, $offerType, $currencyType, $skip, $take);
            return $this->sendSuccess($offers, 'Offers fetched successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }

    public function createOffer(Request $request) {
        $rules = [
            'cryptocurreny_type' => 'required',
            'offer_type' => 'required',
            'payment_method' => 'required',
            'preferred_currency' => 'required',
            'trade_price_type' => 'required',
            'offer_time_limit' => 'required',
            'offer_terms' => 'required',
            'trade_instruction' => 'required',            
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->sendValidationError($validator->messages());
        }

        $input = $request->all();
        $userDetails = $this->userRepository->userDetails(Auth::id());

        if(empty($userDetails)) {
            return $this->sendError("User details not found");
        }

        $dataInsertOrUpdate = [
            'cryptocurreny_type' => $input['cryptocurreny_type'],
            'offer_type' => $input['offer_type'],
            'payment_method' => $input['payment_method'],
            'preferred_currency' => $input['preferred_currency'],
            'trade_price_type' => $input['trade_price_type'],
            'offer_time_limit' => $input['offer_time_limit'],
            'offer_terms' => $input['offer_terms'],
            'trade_instruction' => $input['trade_instruction'],
            'offer_margin_percentage' => !empty($input['offer_margin_percentage']) ? $input['offer_margin_percentage'] : 0,
            'offer_margin_fixed_price' => !empty($input['offer_margin_fixed_price']) ? $input['offer_margin_fixed_price'] : 0,
            'minimum_offer_trade_limits' => !empty($input['minimum_offer_trade_limits']) ? $input['minimum_offer_trade_limits'] : $input['fixed_offer_trade'],
            'maximum_offer_trade_limits' => !empty($input['maximum_offer_trade_limits']) ? $input['maximum_offer_trade_limits'] : $input['fixed_offer_trade'],
            'offer_label' => !empty($input['offer_label']) ? $input['offer_label'] : '',
            'offer_terms' => !empty($input['offer_terms']) ? $input['offer_terms'] : '',
            'require_verified_id' => !empty($input['require_verified_id']) ? $input['require_verified_id'] : 0,
            'target_country' => !empty($input['target_country']) ? $input['target_country'] : 0,
            'offer_visibility' => !empty($input['offer_visibility']) ? $input['offer_visibility'] : 0,
            'minimum_trade_required' => !empty($input['minimum_trade_required']) ? $input['minimum_trade_required'] : 0,
            'limit_for_new_users' => !empty($input['limit_for_new_users']) ? $input['limit_for_new_users'] : 0,
            'user_id' => Auth::id()
        ];


        // Create or Update Offers
        $offerId = !empty($input['offer_id']) ? $input['offer_id'] : 0;
        $offers = $this->offerRepository->createOrUpdateOfferDetails($dataInsertOrUpdate, $offerId);

        // Save or Update offer Tags
        $this->offerRepository->deleteOfferTags($offers->id);
        if(!empty($input['offer_tags'])) {
            foreach($input['offer_tags'] as $offerTag) {
                $dataInsert = ["offer_id" => $offers->id, "offer_tag_id" => $offerTag];
                $this->offerRepository->saveOfferTags($dataInsert);
            }
        }

        $displayFullName = !empty($input['display_full_name']) ? $input['display_full_name'] : 0; // overright existing settings
        if($displayFullName == 1) {
            $this->userRepository->updateDisplayNameSetting(Auth::id());
        }

        $offers = $this->offerRepository->getOfferDetailsByOfferId($offers->id);
        return $this->sendSuccess($offers, 'Offer tags fetched successfully');
    }

    /**
     * Display a listing of the Offer Tags.
     * POST|HEAD /offer/tags
     *
     * @param Request $request
     * @return Response
     */

    public function getOfferTags(Request $request)
    {
        $offerTags = $this->offerRepository->getOfferTags();
        return $this->sendSuccess($offerTags, 'Offer tags fetched successfully');
    }

    /**
     * Display a listing of the payment methods.
     * POST|HEAD /offer/paymentMethod
     *
     * @param Request $request
     * @return Response
     */

    public function getPaymentMethods(Request $request)
    {
        $paymentMethods = $this->offerRepository->getPaymentMethods();
        return $this->sendSuccess($paymentMethods, 'Payment methods fetched successfully');
    }


    public function viewOffer(Request $request, $offerId)
    {
        $updateViewCount = $this->offerRepository->updateViewCount($offerId);
        $offers = $this->offerRepository->getOfferDetailsByOfferId($offerId);
        
        return $this->sendSuccess($offers, 'Offer fetched successfully');
    }

    public function changeOfferStatus(Request $request)
    {
        $input = $request->all();
        if(isset($input['offer_id'])) {
            $offers = $this->offerRepository->createOrUpdateOfferDetails(['status' => $input['status']], $input['offer_id']);
        } else if(isset($input['turn_all'])) {
            $offers = $this->offerRepository->changeOfferStatus(Auth::id(),['status' => $input['status']]);
        }
        return $this->sendSuccess([], 'Offer status changed successfully');
    }

    public function viewFeedbackByOfferId(Request $request, $offerId)
    {
        $input = $request->all();
        $feedbackType = !empty($input['feedback_type']) ? $input['feedback_type'] : 0;

        $offers = $this->offerTradeFeedbackRepository->getOfferFeedbackByOfferId($offerId, $feedbackType);
        return $this->sendSuccess($offers, 'Feedback fetched successfully.');
    }

    public function getAllByOrSellOffers(Request $request) {
        try {
            $input = $request->all();
            $rules = [
                'page_number' => 'required|numeric|min:1',
                'per_page' => 'required|numeric|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $skip = ($input['page_number'] - 1) * $input['per_page'];
            $take = 500;

            $offers = $this->offerRepository->getAllOffers($input, $skip, $take);
            return $this->sendSuccess($offers, 'Offers fetched successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }

    public function addToFavourite(Request $request) {
        try {
            $input = $request->all();
            $this->offerRepository->addToFavourite($input['offer_id'], Auth::id());
            return $this->sendSuccess([], 'Offers added in favourite.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }

    public function removeFavourite(Request $request) {
        try {
            $input = $request->all();
            $this->offerRepository->removeFromFavourite($input['offer_id'], Auth::id());
            return $this->sendSuccess([], 'Offers removed from favourite.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }
}
