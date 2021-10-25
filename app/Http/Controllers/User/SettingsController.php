<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\UserSettings;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        foreach($settings as $key => $setting) {
            $userSetting = UserSettings::where('setting_id', $setting->id)->where('user_id', Auth::id())->first();
            
            if(!empty($userSetting)) {
                $settings[$key]['web'] = $userSetting->web;
                $settings[$key]['email'] = $userSetting->email;
                $settings[$key]['telegram'] = $userSetting->telegram;
                $settings[$key]['app'] = $userSetting->app;
                $settings[$key]['other_setting'] = $userSetting->other_setting;
            } else {
                $settings[$key]['web'] = $settings[$key]['email'] = $settings[$key]['telegram'] = $settings[$key]['app'] = $settings[$key]['other_setting'] = 0;
            }
            
        }
        return $this->sendSuccess($settings, 'Settings fetched successfully');
    }
}
