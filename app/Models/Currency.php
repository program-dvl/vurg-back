<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Currency
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class Currency extends Model
{
//    use SoftDeletes;

    public $table = 'currencies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
