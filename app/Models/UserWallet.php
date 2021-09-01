<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserWallet
 * @package App\Models
 * @version July 10, 2020, 4:29 am UTC
 *
 */
class UserWallet extends Model
{
    use SoftDeletes;

    public $table = 'user_wallet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'lable',
        'passphrase',
        'wallet_id',
        'coin_id',
        'created_at',
        'updated_at'
    ];
}
