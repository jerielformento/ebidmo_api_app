@component('mail::message')
# Account Verification

Thank you for joining eBidMo!<br/>
For account verification click the link below:
 
@component('mail::button', ['url' => $url])
Verify Account
@endcomponent
 
Regards.<br>
{{ config('app.name') }} Team
@endcomponent