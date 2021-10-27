<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserNotifications
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class UserNotifications extends Model
{

    public $table = 'user_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_id',
        'notification_text',
        'is_read',
        'model_id',
        'created_at',
        'updated_at'
    ];

    public function notifications() {
        return $this->belongsTo('App\Models\Notifications','notification_id');
    }
}
