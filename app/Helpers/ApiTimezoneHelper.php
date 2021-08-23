<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

Class ApiTimezoneHelper
{

    /**
     * @param $datetime
     * @param string $toFormat
     * @param string $fromFormat
     * @param $tz
     * @return Carbon|false|string
     */
    public static function localToUTC($datetime , $fromFormat = GLOBAL_DATE_FORMAT, $toFormat = GLOBAL_DATE_FORMAT, $tz = null)
    {
        if(!Auth::check()){
            return $datetime;
        }
        if(empty($tz)){
            $tz = Auth::user()->timezone;
        }
        return Carbon::createFromFormat($fromFormat, $datetime, $tz)->tz('UTC')->format($toFormat);
    }


    /**
     * @param $datetime
     * @param string $toFormat
     * @param string $fromFormat
     * @param null $tz
     * @return Carbon|false|string
     */
    public static function UTCToLocal($datetime ,  $fromFormat = GLOBAL_DATE_FORMAT, $toFormat = GLOBAL_DATE_FORMAT, $tz = null)
    {
        if(!Auth::check()){
            return $datetime;
        }
        if(empty($tz)){
            $tz = Auth::user()->timezone;
        }
        return Carbon::createFromFormat($fromFormat, $datetime)->tz($tz)->format($toFormat);
    }

}
