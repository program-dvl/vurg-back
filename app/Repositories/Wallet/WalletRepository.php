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
        $userWallet = $this->userWallet->where('user_id', Auth::id())->latest('created_at')->first();
        $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), CurrencyCode::BITCOIN_TESTNET, true);
        $bitgo->walletId = $userWallet->wallet_id;
        $wallet = $bitgo->getWallet(CurrencyCode::BITCOIN_TESTNET, 'Bitcoin');
        return [
            [
                'walletName' => $wallet['label'],
                'coin' => $wallet['coin'],
                'balance' => $wallet['balance'],
                'address' => $wallet['receiveAddress']['address']
            ]
        ];
    }

}
