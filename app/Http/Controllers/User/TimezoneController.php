<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timezone;
use Illuminate\Http\Response;

class TimezoneController extends Controller
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
        $timezones = Timezone::all();
        return $this->sendSuccess($timezones, 'Timezone fetched successfully');
    }
}
