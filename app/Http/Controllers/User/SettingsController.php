<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Illuminate\Http\Response;

class SettingsController extends Controller
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
        $settings = Settings::all();
        return $this->sendSuccess($settings, 'Settings fetched successfully');
    }
}
