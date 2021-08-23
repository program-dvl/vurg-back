<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserSettings
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class UserSettings extends Model
{
//    use SoftDeletes;

    public $table = 'user_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting_id',
        'user_id',
        'web',
        'email',
        'other_setting'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
