<?php

namespace App\Repositories\Offer;

use App\Models\OfferTradeFeedback;
use Illuminate\Support\Facades\Auth;

class OfferTradeFeedbackRepository
{
    /**
     * get offer details.
     *
     * @param int $userId
     */
    public function getOfferFeedbackByUser($offerType, $feedbackType = 0, $skip, $take)
    {
        
        $offers = OfferTradeFeedback::with(['offer', 'userDetails']);
        if(!empty($feedbackType)) {
            if($feedbackType == 1) {
                $offers->where('positive', 1);
            } else if($feedbackType == 2) {
                $offers->where('negative', 1);
            }
        }

        if($offerType == 1) {
            $offers->where('from_buyer', Auth::id());
        } else if($offerType == 2){
            $offers->where('from_seller', Auth::id());
        }

        $offers = $offers->orderBy('id', 'DESC')->get();

        return $offers;
    }

    public function getOfferFeedbackByOfferId($offerId, $feedbackType) {
        $offers = OfferTradeFeedback::with(['userDetails'])->where('offer_id', $offerId);
        if(!empty($feedbackType)) {
            if($feedbackType == 1) {
                $offers->where('positive', 1);
            } else if($feedbackType == 2) {
                $offers->where('negative', 1);
            }
        }
        $offers = $offers->orderBy('id', 'DESC')->get();

        return $offers;
    }

}
