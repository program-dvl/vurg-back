<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Timezone
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class Timezone extends Model
{
//    use SoftDeletes;

    public $table = 'timezones';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
