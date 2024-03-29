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
    public function getOfferFeedbackByUser($userId, $offerType, $feedbackType = 0, $skip, $take)
    {
        
        $offers = OfferTradeFeedback::with(['offer', 'offer.paymentMethod' ,'fromBuyerDetails', 'fromSellerDetails']);
        if(!empty($feedbackType)) {
            if($feedbackType == 1) {
                $offers->where('positive', 1);
            } else if($feedbackType == 2) {
                $offers->where('negative', 1);
            }
        }

        if($offerType == 1) {
            $offers->where('from_buyer', $userId);
        } else if($offerType == 2){
            $offers->where('from_seller', $userId);
        } else {
            $offers->where(function($q)  use($userId) {
                $q->where('from_seller', $userId)->orWhere('from_seller', $userId);
            });
        }

        $offers = $offers->orderBy('id', 'DESC')->skip($skip)->take($take)->get();

        return $offers;
    }

    public function getOfferFeedbackByOfferId($offerId, $feedbackType) {
        $offers = OfferTradeFeedback::with(['fromBuyerDetails', 'fromSellerDetails'])->where('offer_id', $offerId);
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

    public function getTotalFedbackCount($user)
    {
        $getAllFeedback = OfferTradeFeedback::where("to_user", $user->id)->get();
        $totalPositive = $totalNegative = 0;
        if(!empty($getAllFeedback)) {
            foreach($getAllFeedback as $feedback) {
                if($feedback->positive == 1) {
                    $totalPositive++;
                } else {
                    $totalNegative++;
                }
            }
        }
        $user->positive_feedback_count = $totalPositive;
        $user->negative_feedback_count = $totalNegative;

        return $user;
    }

    public function addOfferFeedback($dataInsert)
    {
        OfferTradeFeedback::insert($dataInsert);
        return true;;
    }

}
