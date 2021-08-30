<?php

namespace App\Repositories\User;

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
            } else {
                $offers->where('negative', 1);
            }
        }

        if($offerType == 1) {
            $offers->where('from_buyer', Auth::id());
        } else {
            $offers->where('from_seller', Auth::id());
        }

        $offers = $offers->orderBy('id', 'DESC')->get();

        return $offers;
    }

}
