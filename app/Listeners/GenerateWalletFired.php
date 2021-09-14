<?php

namespace App\Listeners;

use App\Events\GenerateWallet;
use App\Services\BitGoSDK;
use App\Services\BitGoExpress;
use neto737\BitGoSDK\Enum\CurrencyCode;
use App\Models\UserWallet;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Crypt;

class GenerateWalletFired
{
    const BITCOIN_ID = "1";
    const USDT_ID = "2";
    const ETHEREUM_ID = "3";

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserWallet $userWallet)
    {
        $this->hostname = 'localhost';
        $this->port = 3080;
        $this->userWallet = $userWallet;
    }

    /**
     * Handle the event.
     *
     * @param  GenerateWallet  $event
     * @return void
     */
    public function handle(GenerateWallet $event)
    {
        $user = $event->user;
        $this->generateBitCoinWallet($user);
       // $this->generateEthereumWallet($user);
        //$this->generateUSDTWallet($user);
    }

    public function generateBitCoinWallet($user) {
        $userId = $user->id;
        $coin = CurrencyCode::BITCOIN_TESTNET;
        $passPharse = 'vurg_bitcoin_'.Crypt::encryptString($userId);
        $bitgoExpress = new BitGoExpress($this->hostname, $this->port, $coin);
        $bitgoExpress->accessToken = env('BITGO_ACCESS_TOKEN');
        $wallet = $bitgoExpress->generateWallet('Bitcoin', $passPharse);
        $walletData = [
            'user_id' => $userId,
            'coin_id' => self::BITCOIN_ID,
            'lable' => 'Bitcoin',
            'passphrase' => Crypt::encryptString($passPharse),
            'wallet_id' => $wallet['id']
        ];
        $this->userWallet->create($walletData);
    }

    public function generateUSDTWallet($user) {
        $userId = $user->id;
        $coin = CurrencyCode::BITCOIN_TESTNET;
        $passPharse = 'vurg_tether_'.Crypt::encryptString($userId);
        $bitgoExpress = new BitGoExpress($this->hostname, $this->port, $coin);
        $bitgoExpress->accessToken = env('BITGO_ACCESS_TOKEN');
        $wallet = $bitgoExpress->generateWallet('Tether', $passPharse);
        $walletData = [
            'user_id' => $userId,
            'coin_id' => self::USDT_ID,
            'lable' => 'Tether',
            'passphrase' => Crypt::encryptString($passPharse),
            'wallet_id' => $wallet['id']
        ];
        $this->userWallet->create($walletData);
    }

    public function generateEthereumWallet($user) {
        $userId = $user->id;
        $coin = CurrencyCode::ETHEREUM_TESTNET;
        $passPharse = 'vurg_ethereum_'.Crypt::encryptString($userId);
        $bitgoExpress = new BitGoExpress($this->hostname, $this->port, $coin);
        $bitgoExpress->accessToken = env('BITGO_ACCESS_TOKEN');
        $wallet = $bitgoExpress->generateWallet('Ethereum', $passPharse, '61251ecce3611100067b8e2a616117e1', null, null, '61251ecce3611100067b8e2a616117e1');
        dd($wallet);
        $walletData = [
            'user_id' => $userId,
            'coin_id' => self::ETHEREUM_ID,
            'lable' => 'Ethereum',
            'passphrase' => Crypt::encryptString($passPharse),
            'wallet_id' => $wallet['id']
        ];
        $this->userWallet->create($walletData);
    }
}
