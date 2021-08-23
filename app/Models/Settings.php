<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Settings
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class Settings extends Model
{
//    use SoftDeletes;

    public $table = 'settings';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
