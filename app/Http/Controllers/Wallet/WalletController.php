<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Http\Response;
use Validator;
use Mail;
use App\Repositories\Wallet\WalletRepository;

class WalletController extends Controller
{

    /**
     * Create a new user wallet controller instance.
     *
     * @param  App\Models\User $state
     * @return void
     */
    public function __construct(
        WalletRepository $walletRepository
    ) {
        $this->walletRepository = $walletRepository;
    }
    
    /**
     * Display a wallets
     * GET|HEAD /wallets
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        try {
            $wallets = $this->walletRepository->getUserWallets();
            return $this->sendSuccess($wallets, 'Wallets listed succcessfully');
        } catch (\Exception $e) { dd($e->getMessage());
            return $this->sendError();
        }
    }

    /**
     * List all supported coins
     * GET|HEAD /coins
     *
     * @param Request $request
     * @return Response
     */

    public function allCoins(Request $request)
    {
        try {
            $wallets = $this->walletRepository->allCoins();
            return $this->sendSuccess($wallets, 'Coins listed succcessfully');
        } catch (\Exception $e) {
            return $this->sendError();
        }
    }
}
