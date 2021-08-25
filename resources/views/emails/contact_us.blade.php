Hello Admin, <br><br>

Contact Us form details:<br>
First Name: {{$contactUs->first_name}}<br>
Last Name: {{$contactUs->last_name}}<br>
Email: {{$contactUs->email}}<br>
@if($contactUs->message)
Message: {{$contactUs->message}}<br>
@endif
<br>
Thank You <br>
Vurg