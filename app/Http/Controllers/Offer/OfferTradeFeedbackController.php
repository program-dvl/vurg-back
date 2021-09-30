<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\OfferTradeFeedback;
use App\Models\OfferTags;
use Illuminate\Http\Response;
use Validator;
use App\Repositories\Offer\OfferTradeFeedbackRepository;

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
            $input = $request->only(['feedback_type' , 'offer_type', 'page_number', 'per_page']);
            
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
}
