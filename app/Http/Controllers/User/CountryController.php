<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Http\Response;

class CountryController extends Controller
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
        $country = Country::all();
        return $this->sendSuccess($country, 'Currency fetched successfully');
    }
}
