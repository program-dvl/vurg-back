<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use App\StateMachines\StatusStateMachine; 

class Trade extends Model
{
    Use HasStateMachines;

    public $stateMachines = [
        'trade_status' => TradeStatusStateMachine::class
    ];   

    public $table = 'trade';

    protected $fillable = [
        'id',
        'offer_id',
        'user_id',
        'status',
        'start_time',
        'currency_amount',
        'crypto_amount',
        'market_rate',
        'fee_amount',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getIncrementing()
    {
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trade) {
            $trade->id = (string) Str::uuid();
        });
    }
}
