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
                'email' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->sendValidationError($validator->messages());
            }

            $input = $request->all();

            $contactUs = new ContactUs();
            $contactUs->first_name = $input['firstname'];
            $contactUs->last_name = $input['lastname'];
            $contactUs->email = $input['email'];
            $contactUs->message = !empty($input['message']) ? $input['message'] : '';
            $contactUs->Save();

            $data = array('contactUs'=>$contactUs);
            Mail::send('emails.contact_us', $data, function($message) use ($input) {
                $message->to('sam.love9093@gmail.com', 'Contact Us')->subject
                ('Contact Us form filled');
                $message->from(env('mail_from_address'),env('MAIL_FROM_NAME'));
            });

            return $this->sendSuccess([], 'Contact us form submitted');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError();
        }
    }
}
