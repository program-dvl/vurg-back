<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ContactUs
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class ContactUs extends Model
{
//    use SoftDeletes;

    public $table = 'contact_us';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'message',
        'email'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
