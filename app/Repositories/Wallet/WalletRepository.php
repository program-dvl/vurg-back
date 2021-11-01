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
                $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coin['id'], false);
                $bitgo->walletId = $wallet->wallet_id;
                $wallet = $bitgo->getWallet($coin['id']);
                $lable = explode("-",$wallet['label']);
                $allWallets[$coin['id']] = [
                    'walletName' => $lable[0],
                    'coin' => $wallet['coin'],
                    'balance' => $wallet['balance']/100000000,
                    'address' => $wallet['receiveAddress']['address']
                ];
            }
        }
        return $allWallets;
    }

    /**
     * get user wallet by coin id.
     *
     * @return array
     */
    public function getUserWallet($user_id, $coin_id)
    {
        return $this->userWallet->where('user_id', $user_id)->where('coin_id', $coin_id)->latest('created_at')->first();
    }

    /**
     * get bitgo wallet by wallet id and coin id.
     *
     * @return array
     */
    public function getBitgoWallet($wallet_id, $coin_id)
    {
        $coin = $this->getCoin()[$coin_id];
        $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coin['id'], false);
        $bitgo->walletId = $wallet_id;
        return $bitgo->getWallet($coin_id);
    }


    public function allCoins() {
        return [
            [
                'id' => CurrencyCode::BITCOIN,
                'name' => 'Bitcoin',
                'coin_vurg_id' => 1
            ]
        ];
    }

    public function getCoinAddress($id) {
        $coins = $this->getCoin();
        if (!empty($coins[$id])) {
            $coin = $coins[$id];
            $wallet = $this->userWallet->where('user_id', Auth::id())->where('coin_id', $id)->latest('created_at')->first();
            if (!empty($wallet)) {
                $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coin['id'], false);
                $bitgo->walletId = $wallet->wallet_id;
                $wallet = $bitgo->getWallet($coin['id']);
                return [
                    'coin' => $wallet['coin'],
                    'address' => $wallet['receiveAddress']['address'],
                    'created' => $wallet['startDate'],
                ];
            }
        }
        return false;
    }

    public function getTransactions($id) {
        
        $coins = $this->getCoin();
        $coin = $coins[$id];
        if (!empty($coins[$id])) {
            $wallet = $this->userWallet->where('user_id', Auth::id())->where('coin_id', $id)->latest('created_at')->first();
            if (!empty($wallet)) {
                $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coin['id'], false);
                $bitgo->walletId = $wallet->wallet_id;
                $transactions = $bitgo->listWalletTransfers();
                $respone = [];
                if (!empty($transactions['transfers'])) {
                    foreach ($transactions['transfers'] as $key => $value) {
                        $respone[$key]['crypt_amount'] = $value['value']/100000000;
                        $respone[$key]['state'] = $value['state'];
                        $respone[$key]['transaction_type'] = ($value['type'] == 'receive') ? 'Received' : 'Sent Out';
                        $respone[$key]['sent_to'] = $value['wallet'];
                        $respone[$key]['transaction_id'] = $value['id'];
                        $respone[$key]['date'] = $value['date'];
                    }
                }
                return $respone;
            }
        }
        return false;
    }

    public function getCoin() {
        return [
            "1" => [
                'id' => CurrencyCode::BITCOIN,
                'name' => 'Bitcoin',
                'coin_vurg_id' => 1
            ]
        ];
    }

}
