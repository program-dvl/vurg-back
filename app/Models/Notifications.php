<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notifications
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class Notifications extends Model
{

    public $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];
}
