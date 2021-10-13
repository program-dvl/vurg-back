<?php

namespace App\Repositories\Transaction;

use App\Models\User;
use App\Services\BitGoSDK;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;
use neto737\BitGoSDK\Enum\CurrencyCode;

class TransactionRepository
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

    public function getPreTransactionDetails($amount) {
        $user = User::with('currency')->find(Auth::id());
        
        $flatAmount = $this->getPriceConverted("BTC", "USD", $amount);
        $feeAmount = 0.0004;
        
        if ($flatAmount <= 9.99) {
            $feeAmount = 0.00008;
        } else if ($flatAmount >= 10 && $flatAmount <= 19.99) {
            $feeAmount = 0.00016;
        }

        $currencyCode = 'USD';
        if (!empty($user->currency) && !empty($$user->currency->currency_code)) {
            $currencyCode = $user->currency->currency_code;
        }

        $sendingBitcoin = $amount - $feeAmount;
        $sendingBitcoinInCurrency = $this->getPriceConverted("BTC", $currencyCode, $sendingBitcoin);
        $feeAmountInCurrency = $this->getPriceConverted("BTC", $currencyCode, $feeAmount);
        $userCurrency = $currencyCode; 

        return [
            'sending_bitcoin' => $sendingBitcoin,
            'sending_bitcoin_in_user_currency' => $sendingBitcoinInCurrency,
            'bitcon_network_handling_fee' => $feeAmount,
            'bitcon_network_handling_fee_in_user_currency' => $feeAmountInCurrency,
            'in_total_decution' => $amount,
            'in_total_deduction_in_user_currency' => $flatAmount,
            'user_currency' => $userCurrency
        ];
    }

    public function isHavingSufficientFunds($amount) {
        $coinId = CurrencyCode::BITCOIN_TESTNET;
        $wallet = $this->userWallet->where('user_id', Auth::id())->where('coin_id', 1)->latest('created_at')->first();
        if (!empty($wallet)) {
            
            $bitgo = new BitGoSDK(env('BITGO_ACCESS_TOKEN'), $coinId, true);
            $bitgo->walletId = $wallet->wallet_id;
            $wallet = $bitgo->getWallet($coinId);
            $balance = $wallet['balance']/100000000; 
            $flag = ($amount <= $balance) ? true : false;
            // Entered amount is less then wallet balance retun insuffecient fund
            if (!$flag) {
                return $flag;
            }

            // Entered amount is less minimum vurg transaction fee balance retun insuffecient fund
            // Vurg transactions fees are : 
            // $0 - $9.99 = 0.00008 BTC fee
            // $10 - $19.99 = 0.00016 BTC fee
            // $20+ = 0.0004 BTC fee	
            if ($amount <= 0.00008) {
                return false;
            }


            return true;
            
        }
        return false;
    }

    function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);
        if ($contents) return $contents;
        else return FALSE;
    }

    public function getPriceConverted($from, $to, $amount) {
        $url = "https://api.coinlayer.com/convert?access_key=10d4b8fafb97d00c1f8a1830caf3cfab&from=".$from."&to=".$to."&amount=".$amount;
        $json = json_decode($this->curl_get_file_contents($url), true);
        return $json['result'];
    }
    
}