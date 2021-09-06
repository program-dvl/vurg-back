<?php

namespace App\Repositories\Offer;

use App\Models\Offers;
use App\Models\OfferTags;
use App\Models\UserOfferTags;
use App\Models\PaymentMethods;
use App\Models\PaymentMethodCategory;

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

    public function getOfferTags()
    {
        return OfferTags::where('is_active' , OFFER_ACTIVE)->get();
    }

    public function getPaymentMethods() {
        $getAllCategories = PaymentMethodCategory::where('is_active' , PAYMENT_METHOD_CATEGORY_ACTIVE)->get();

        $finalPaymentMethod = array();

        $finalPaymentMethod['all_payment_modes'] = PaymentMethods::where('is_active' , PAYMENT_METHOD_ACTIVE)->orderBy('name', 'ASC')->get();
        if(!empty($getAllCategories)) {
            foreach($getAllCategories as $category) {
                $getPopularMethods = PaymentMethods::where('is_active' , PAYMENT_METHOD_ACTIVE)->where('payment_category_id', $category->id)->where('is_popular', POPULAR)->orderBy('name', 'ASC')->get();
                $getAllMethods = PaymentMethods::where('is_active' , PAYMENT_METHOD_ACTIVE)->where('payment_category_id', $category->id)->orderBy('name', 'ASC')->get();

                $finalPaymentMethod[$category->name]['popular'] = $getPopularMethods;
                $finalPaymentMethod[$category->name]['all'] = $getAllMethods;
            }
        }

        return $finalPaymentMethod;
    }


    public function createOrUpdateOfferDetails($dataUpdate, $offerId)
    {
        $checkRecord = $offerId == 0 ? array('id' => 0) : array('id' => $offerId);
        return Offers::updateOrCreate($checkRecord, $dataUpdate);
    }

    public function saveOfferTags($dataInsert)
    {
        return UserOfferTags::create($dataInsert);
    }

    public function deleteOfferTags($offerId) {
        return UserOfferTags::where("offer_id", $offerId)->delete();
    }

    public function getOfferDetailsByOfferId($offerId)
    {
        $offers = Offers::with(['offerTags', 'userDetails', 'paymentMethod', 'preferredCurrency', 'targetCountry'])->where("id", $offerId)->first();
        return $offers;
    }

    public function changeOfferStatus($userId, $status) {
        return Offers::where('user_id', $userId)->update($status);
    }

}
