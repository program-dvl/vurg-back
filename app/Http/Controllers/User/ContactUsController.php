<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Http\Response;
use Validator;
use Mail;

class ContactUsController extends Controller
{
    
    /**
     * Display a listing of the Timezone.
     * POST|HEAD /contactus
     *
     * @param Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $input = $request->all();

            $contactUs = new ContactUs();
            $contactUs->first_name = $input['firstname'];
            $contactUs->last_name = $input['lastname'];
            $contactUs->email = $input['email'];
            $contactUs->message = $input['message'];
            $contactUs->Save();

            $data = array('contactUs'=>$contactUs);
            Mail::send('emails.contact_us', $data, function($message) use ($input) {
                $message->to('dhaval@vurg.com', 'Contact Us')->subject
                ('Contact Us form filled');
                $message->from('iris@vurg.com','Dhaval Prajapati');
            });


            return $this->sendSuccess([], 'Contact us form submitted');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }
}