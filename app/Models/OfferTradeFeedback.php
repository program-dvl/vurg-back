<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OfferTradeFeedback
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class OfferTradeFeedback extends Model
{
//    use SoftDeletes;
    public $table = 'offer_trade_feedback';

    public function offer() {
        return $this->belongsTo('App\Models\Offers','offer_id');
    }

    public function fromBuyerDetails() {
        return $this->belongsTo('App\Models\User','from_buyer');
    }

    public function fromSellerDetails() {
        return $this->belongsTo('App\Models\User','from_seller');
    }
}
