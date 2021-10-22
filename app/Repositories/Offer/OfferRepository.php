<?php

namespace App\Repositories\Offer;

use App\Models\Offers;
use App\Models\OfferViews;
use App\Models\OfferTags;
use App\Models\UserOfferTags;
use App\Models\OfferFavourite;
use App\Models\PaymentMethods;
use App\Models\PaymentMethodCategory;
use Illuminate\Support\Facades\Auth;

class OfferRepository
{
    /**
     * get offer details.
     *
     * @param int $userId
     */
    public function getOfferDetails(int $userId, $offerType = 0, $currencyType = 0, $skip, $take)
    {
        $offers = Offers::with(['offerTags', 'userDetails', 'paymentMethod', 'preferredCurrency', 'targetCountry', 'offerTags.tags'])->where("user_id", $userId);
        if(!empty($offerType)) {
            $offers->where('offer_type', $offerType);
        }

        if(!empty($currencyType)) {
            $offers->where('cryptocurreny_type', $currencyType);
        }
        
        $offers = $offers->orderBy('id', 'DESC')->skip($skip)->take($take)->get();

        if(!empty($offers)) {
            foreach($offers as $key => $offer) {
                $isFavourite = OfferFavourite::where("offer_id", $offer['id'])->where("user_id", Auth::id())->first();
                $offers[$key]['is_favourite'] = !empty($isFavourite) ? 1 : 0;
                $offers[$key]['current_bitcoin_price'] = $this->getBitcoinPrice($offer['preferred_currency']['currency_code']);
                if(!empty($offer->offerTags)) {
                    foreach($offer->offerTags as $keyOfferTag => $offerTag) {
                        $offer->offerTags[$keyOfferTag]['tag_name'] = $offerTag->tags->tag_name;
                        $offer->offerTags[$keyOfferTag]['tag_description'] = $offerTag->tags->tag_description;
                    }
                }
            }
        }

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
        $offers = Offers::with(['offerTags', 'userDetails', 'paymentMethod', 'preferredCurrency', 'targetCountry', 'offerTags.tags'])->where("id", $offerId)->first();
        $isFavourite = OfferFavourite::where("offer_id", $offers->id)->where("user_id", Auth::id())->first();
        $offers->is_favourite = !empty($isFavourite) ? 1 : 0;
        $offers->current_bitcoin_price = $this->getBitcoinPrice($offers->preferredCurrency->currency_code);
        if(!empty($offers->offerTags)) {
            foreach($offers->offerTags as $keyOfferTag => $offerTag) {
                $offers->offerTags[$keyOfferTag]['tag_name'] = $offerTag->tags->tag_name;
                $offers->offerTags[$keyOfferTag]['tag_description'] = $offerTag->tags->tag_description;
            }
        }
        return $offers;
    }

    public function updateViewCount($offerId) {
        $ifExist = OfferViews::where("user_id", Auth::id())->where("offer_id", $offerId)->first();
        if(!empty($ifExist)) {
            return true;
        } else {
            OfferViews::create(['user_id' => Auth::id(), "offer_id" => $offerId]);
            $offer = Offers::find($offerId);
            Offers::where("id", $offerId)->update(["total_views" => $offer->total_views +1]);
        }
    }

    public function changeOfferStatus($userId, $status) {
        return Offers::where('user_id', $userId)->update($status);
    }

    /**
     * get offer details.
     *
     * @param int $userId
     */
    public function getAllOffers($input, $skip, $take)
    {
        $offers = Offers::with(['userDetails', 'paymentMethod', 'preferredCurrency', 'targetCountry', 'offerTags' , 'offerTags.tags'])
            ->where("user_id", '!=',Auth::id())->where('status', '=', 1);
        
        // Check By or Sell
        if(!empty($input['offer_type'])) {
            $offers->where('offer_type', $input['offer_type']);
        }

        //Check Crpto currency type
        if(!empty($input['currency_type'])) {
            $offers->where('cryptocurreny_type', $input['currency_type']);
        }

        //Check Payment Method
        if(!empty($input['payment_method'])) {
            $offers->where('payment_method', $input['payment_method']);
        }

        //Check Targeted country
        if(!empty($input['target_country'])) {
            $offers->where('target_country', $input['target_country']);
        }

        //Check Amount and Currency
        if(!empty($input['spend_amount']) && !empty($input['preffered_currency'])) {
            $offers->where('minimum_offer_trade_limits', '<=',$input['spend_amount']);
            $offers->where('maximum_offer_trade_limits', '>=',$input['spend_amount']);
            $offers->where('preferred_currency', $input['preffered_currency']);
        }

        if(!empty($input['preffered_currency'])) {
            $offers->where('preferred_currency', $input['preffered_currency']);
        }

        if($input['sort_order'] == 3) {
            $offers->orderBy('offer_time_limit', 'ASC');
        } else if($input['sort_order'] == 4) {
            $offers->orderBy('offer_time_limit', 'DESC');
        }
        
        if(!empty($input['offer_tags'])) {
            $tempOffers = $offers->orderBy('id', 'DESC')->get();
            $offers = [];
            if(!empty($tempOffers)) {
                foreach($tempOffers as $tempOffer) {
                    if(!empty($tempOffer->offerTags)) {
                        foreach($tempOffer->offerTags as $offerTag) {
                            if(in_array($offerTag->id, $input['offer_tags'])) {
                                $offers[] = $tempOffer->toArray();
                            }
                        }
                    }
                }
            }
        } else {
            $offers = $offers->orderBy('id', 'DESC')->skip($skip)->take($take)->get()->toArray();
        }

        
        if($input['sort_order'] == 1 || $input['sort_order'] == 2) {
            if(!empty($offers)) {
                $getAllExchangeRate = $this->getNewExchangeRate();
                foreach($offers as $key => $offer) {
                    
                    if(!empty($getAllExchangeRate)) {
                        foreach($getAllExchangeRate as $getAllExchangeRateCuurency) {
                            if($offer['preferred_currency']['currency_code'] == $getAllExchangeRateCuurency['currency']) {
                                $offers[$key]['exchange_rate'] = $getAllExchangeRateCuurency['rate'] * $offer['minimum_offer_trade_limits'];
                                break;
                            }
                        }
                    }
                }
                
                array_multisort(array_column($offers, 'exchange_rate'),$input['sort_order'] == 2 ? SORT_DESC : SORT_ASC, $offers);
            }
        } 
            
        if(!empty($offers)) {
            foreach($offers as $key => $offer) {
                $isFavourite = OfferFavourite::where("offer_id", $offer['id'])->where("user_id", Auth::id())->first();
                $offers[$key]['is_favourite'] = !empty($isFavourite) ? 1 : 0;
                $offers[$key]['current_bitcoin_price'] = $this->getBitcoinPrice($offer['preferred_currency']['currency_code']);
                
                if(!empty($offer['offer_tags'])) {
                    foreach($offer['offer_tags'] as $keyOfferTag => $offerTag) {
                        $offers[$key]['offer_tags'][$keyOfferTag]['tag_name'] = $offerTag['tags']['tag_name'];
                        $offers[$key]['offer_tags'][$keyOfferTag]['tag_description'] = $offerTag['tags']['tag_description'];
                    }
                }
            }
        }
        
        

        return $offers;
    }

    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
    }

    public function getBitcoinPrice($currency) {
        $url = "https://api.coinlayer.com/live?access_key=10d4b8fafb97d00c1f8a1830caf3cfab&target=".$currency;
        $json = json_decode($this->curl_get_file_contents($url), true);
        return $json['rates']['BTC'];
    }

    public function getExchangeRate($currency, $amount) {
        $url = "https://free.currconv.com/api/v7/convert?q=".$currency."_INR&compact=ultra&apiKey=acd9e68b55b0ec097c3b";
        $json = json_decode($this->curl_get_file_contents($url), true);
        $convertedCurrency = $currency."_INR";
        $convertedAmount = $json[$convertedCurrency];

        return $convertedAmount * $amount;
    }


    public function getNewExchangeRate() {
        $url = "http://api.nomics.com/v1/exchange-rates?key=656dc0785146c218932c919f5c7fdb7d798ee21a";
        return json_decode($this->curl_get_file_contents($url), true);
    }

    public function addToFavourite($offerId, $userId) {
        return OfferFavourite::create(['user_id' =>$userId, 'offer_id' => $offerId]);
    }

    public function removeFromFavourite($offerId, $userId) {
        return OfferFavourite::where(['user_id' =>$userId, 'offer_id' => $offerId])->forceDelete();
    }
}
