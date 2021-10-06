<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OfferViews
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class OfferViews extends Model
{
    public $table = 'offer_views';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'offer_id',
        'created_at',
        'updated_at'
    ];
}
