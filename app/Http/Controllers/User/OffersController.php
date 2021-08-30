<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Offers;
use App\Models\OfferTags;
use Illuminate\Http\Response;
use Validator;
use App\Repositories\User\OfferRepository;

class OffersController extends Controller
{
    /**
     * @var App\Repositories\User\UserRepository
     */
    private $userRepository;

    public function __construct(
        Request $request,
        OfferRepository $offerRepository
    ) {
        $this->request = $request;
        $this->offerRepository = $offerRepository;
    }
    
    /**
     * fetch logged in user offers.
     * POST|HEAD /index
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        try {
            $input = $request->only(['page_number', 'per_page', 'currency_type', 'offer_type']);
            $rules = [
                'page_number' => 'required|numeric|min:1',
                'per_page' => 'required|numeric|min:1',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $skip = ($input['page_number'] - 1) * $input['per_page'];
            $take = $input['per_page'];

            $offerType = $input['offer_type'];
            $currencyType = !empty($input['currency_type']) ? $input['currency_type'] : 0;

            $offers = $this->offerRepository->getOfferDetails(Auth::id(), $offerType, $currencyType, $skip, $take);
            return $this->sendSuccess($offers, 'Offers fetched successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }
}
