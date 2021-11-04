<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Services\AddressValidator;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{

    /**
     * Create a new user wallet controller instance.
     *
     * @param  App\Models\User $state
     * @return void
     */
    public function __construct(
        TransactionRepository $transactionRepository
    ) {
        $this->transactionRepository = $transactionRepository;
    }

    public function getPreTransactionDetails(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'address' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $isValidAddress = AddressValidator::isValid($request->address);
            if (!$isValidAddress) {
                $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
                $apiMessage = 'Invalid wallet address';
                return $this->sendError($apiMessage, $apiStatus);
            }
            
            $isSufficientFunds = $this->transactionRepository->isHavingSufficientFunds($request->amount);
            if (!$isSufficientFunds) {
                $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
                $apiMessage = 'Insufficient funds';
                return $this->sendError($apiMessage, $apiStatus);
            }

            $preTransactionDetails = $this->transactionRepository->getPreTransactionDetails($request->amount);
            if (!$preTransactionDetails) {
                $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
                $apiMessage = 'Insufficient funds';
                return $this->sendError($apiMessage, $apiStatus);
            }
            return $this->sendSuccess($preTransactionDetails, 'Pre transaction details listed successfully');
        } catch (\Exception $e) {
            return $this->sendError();
        }
    }

    public function getConvertedCurrency(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'from' => 'required',
                'to' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $getConvertedCUrrency = $this->transactionRepository->getPriceConverted($request->from, $request->to, $request->amount);
            return $this->sendSuccess($getConvertedCUrrency, 'Data converted successfully');
        } catch (\Exception $e) {
            return $this->sendError();
        }
    }

    public function sendCointoAddress(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'feeAmount' => 'required',
                'password' => 'required',
                'address' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            // $isValidAddress = AddressValidator::isValid($request->address);
            // if (!$isValidAddress) {
            //     $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
            //     $apiMessage = 'Invalid wallet address';
            //     return $this->sendError($apiMessage, $apiStatus);
            // }

            $credentials = [
                'email' => Auth::user()->email,
                'password' => $request->password
            ];

            if (!auth('api')->attempt($credentials)) {
                $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
                $apiMessage = 'Invalid Password';
                return $this->sendError($apiMessage, $apiStatus);
            }
            $status = $this->transactionRepository->transferCoinToAddress(
                $request->amount,
                $request->feeAmount,
                $request->address
            );
            if (!$status) {
                $apiStatus = Response::HTTP_UNPROCESSABLE_ENTITY;
                $apiMessage = 'Failed to send the coins';
                return $this->sendError($apiMessage, $apiStatus);
            }
            return $this->sendSuccess([], 'Coin transfered successfully');
        } catch (\Exception $e) { dd($e->getMessage());
            return $this->sendError();
        }
    }

}