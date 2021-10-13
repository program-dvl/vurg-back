<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use App\Services\AddressValidator;
use App\Repositories\Transaction\TransactionRepository;

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
        return $this->sendSuccess($preTransactionDetails, 'Pre transaction details listed successfully');
    }

    public function getConvertedCurrency(Request $request) {
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
    }

}