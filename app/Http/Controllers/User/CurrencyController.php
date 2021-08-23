<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Http\Response;

class CurrencyController extends Controller
{
    
    /**
     * Display a listing of the Timezone.
     * POST|HEAD /get_timezone
     *
     * @param Request $request
     * @return Response
     */

    public function index(Request $request)
    {
        $currency = Currency::all();
        return $this->sendSuccess($currency, 'Currency fetched successfully');
    }
}
