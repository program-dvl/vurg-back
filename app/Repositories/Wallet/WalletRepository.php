<?php

namespace App\Repositories\Wallet;

use App\Models\UserWallet;
use App\Services\BitGoSDK;
use Illuminate\Support\Facades\Auth;
use neto737\BitGoSDK\Enum\CurrencyCode;

class WalletRepository
{
    /**
     * @var App\Models\UserWallet
     */
    private $userWallet;

    /**
     * Create a new user repository instance.
     *
     * @param  App\Models\User $state
     * @return void
     */
    public function __construct(
        UserWallet $userWallet
    ) {
        $this->userWallet = $userWallet;
    }

    /**
     * get user wallets.
     *
     * @return array
     */
    public function getUserWallets(): array
    {
        $allWallets = [];
        $allCoins = $this->allCoins();
        foreach ($allCoins as $key => $coin) {
            $wallet = $this->userWallet->where('user_id', Auth::id())->where('coin_id', $coin['coin_vurg_id'])->latest('created_at')->first();
            if (!empty($wallet)) {
                $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coin['id'], true);
                $bitgo->walletId = $wallet->wallet_id;
                $wallet = $bitgo->getWallet($coin['id']);
                $allWallets[$coin['id']] = [
                    'walletName' => $wallet['label'],
                    'coin' => $wallet['coin'],
                    'balance' => $wallet['balance'],
                    'address' => $wallet['receiveAddress']['address']
                ];
            }
        }
        return $allWallets;
    }

    public function allCoins() {
        return [
            [
                'id' => CurrencyCode::BITCOIN_TESTNET,
                'name' => 'Bitcoin',
                'coin_vurg_id' => 1
            ]
        ];
    }

}
