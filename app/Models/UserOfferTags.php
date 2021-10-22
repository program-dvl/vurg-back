<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserOfferTags
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class UserOfferTags extends Model
{
//    use SoftDeletes;
    public $table = 'user_offer_tags';

    protected $fillable = [
        'offer_id',
        'offer_tag_id'
    ];

    public function tags() {
        return $this->belongsTo('App\Models\OfferTags','offer_tag_id');
    }
}
