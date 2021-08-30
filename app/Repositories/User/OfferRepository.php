<?php

namespace App\Repositories\User;

use App\Models\Offers;

class OfferRepository
{
    /**
     * get offer details.
     *
     * @param int $userId
     */
    public function getOfferDetails(int $userId, $offerType = 0, $currencyType = 0, $skip, $take)
    {
        
        $offers = Offers::with(['offerTags', 'userDetails', 'paymentMethod', 'preferredCurrency', 'targetCountry'])->where("user_id", $userId);
        if(!empty($offerType)) {
            $offers->where('offer_type', $offerType);
        }

        if(!empty($currencyType)) {
            $offers->where('cryptocurreny_type', $currencyType);
        }
        
        $offers = $offers->orderBy('id', 'DESC')->skip($skip)->take($take)->get();

        return $offers;
    }

}
