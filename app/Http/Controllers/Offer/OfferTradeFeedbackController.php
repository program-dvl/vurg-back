<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OfferTradeFeedback;
use App\Models\OfferTags;
use App\Models\Offers;
use Illuminate\Http\Response;
use Validator;
use App\Repositories\Offer\OfferTradeFeedbackRepository;
use Carbon\Carbon;

class OfferTradeFeedbackController extends Controller
{
    /**
     * @var App\Repositories\User\UserRepository
     */
    private $userRepository;

    public function __construct(
        Request $request,
        OfferTradeFeedbackRepository $offerTradeFeedbackRepository
    ) {
        $this->request = $request;
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
            $input = $request->all();
            
            $validator = Validator::make($request->all(), [
                'feedback_type' => 'required',
                'offer_type' => 'required',
                'page_number' => 'required',
                'per_page' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $skip = ($input['page_number'] - 1) * $input['per_page'];
            $take = $input['per_page'];

            $offerType = $input['offer_type'];
            $feedbackType = !empty($input['feedback_type']) ? $input['feedback_type'] : 0;
            $userId = !empty($input['user_id']) ? $input['user_id'] : Auth::id();

            $offers = $this->offerTradeFeedbackRepository->getOfferFeedbackByUser($userId,$offerType, $feedbackType, $skip, $take);
            if(!empty($offers)) {
                foreach($offers as $offer) {
                    if($userId == $offer->fromBuyerDetails->id) {
                        $offer->feedback_title = "Buying - " . $offer->offer->paymentMethod->name;
                    } else {
                        $offer->feedback_title = "Selling - " . $offer->offer->paymentMethod->name;
                    }
                }
            }
            return $this->sendSuccess($offers, 'Feedback fetched successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }

    public function addFeedback(Request $request)
    {
        $input = $request->all();
            
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->messages());
        }

        $offerDetails = Offers::find($input['offer_id']);
        if($offerDetails->user_id == Auth::id()) {
            $fromUser = Auth::id();
            $toUser = $input['user_id'];

            if($offerDetails->offer_type == 1) {
                $fromBuyer = Auth::id();
                $fromSeller = $input['user_id'];
            } else {
                $fromBuyer = $input['user_id'];
                $fromSeller = Auth::id();
            }
        } else {
            $fromUser = $input['user_id'];
            $toUser = Auth::id();

            if($offerDetails->offer_type == 1) {
                $fromBuyer = $input['user_id'];
                $fromSeller = Auth::id();
            } else {
                $fromBuyer = Auth::id();
                $fromSeller = $input['user_id'];
            }
        }

        $dataInsert = [
            'from_user' => $fromUser,
            'to_user' => $toUser,
            'from_buyer' => $fromBuyer,
            'from_seller' => $fromSeller,
            'offer_id' => $input['offer_id'],
            'positive' => $input['positive'],
            'negative' => $input['negative'],
            'comment' => !empty($input['comment']) ? $input['comment'] : '',
            'created_at' => Carbon::now()
        ];

        $this->offerTradeFeedbackRepository->addOfferFeedback($dataInsert);

        return $this->sendSuccess([], 'Feedback added successfully.');
    }
}
