<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Offers
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class Offers extends Model
{
//    use SoftDeletes;

    public $table = 'offers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cryptocurreny_type',
        'offer_type',
        'payment_method',
        'preferred_currency',
        'trade_price_type',
        'offer_time_limit',
        'offer_terms',
        'trade_instruction',
        'offer_margin_percentage',
        'offer_margin_fixed_price',
        'minimum_offer_trade_limits',
        'maximum_offer_trade_limits',
        'offer_label',
        'offer_terms',
        'require_verified_id',
        'target_country',
        'offer_visibility',
        'minimum_trade_required',
        'limit_for_new_users',
        'user_id',
        'status'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function offerTags() {
        return $this->hasMany('App\Models\UserOfferTags','offer_id');
    }

    public function userDetails() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function paymentMethod() {
        return $this->belongsTo('App\Models\PaymentMethods','payment_method');
    }

    public function preferredCurrency() {
        return $this->belongsTo('App\Models\Currency','preferred_currency');
    }

    public function targetCountry() {
        return $this->belongsTo('App\Models\Country','target_country');
    }
}
