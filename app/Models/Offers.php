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
    // protected $fillable = [
    //     'first_name',
    //     'last_name',
    //     'message',
    //     'email'
    // ];

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
