<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OfferTags
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class OfferFavourite extends Model
{
//    use SoftDeletes;
    public $table = 'favourite_offer';

    protected $fillable = [
        'offer_id',
        'user_id'
    ];
}
