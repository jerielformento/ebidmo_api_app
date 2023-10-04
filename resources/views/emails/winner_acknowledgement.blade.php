@component('mail::message')
# You have won!

Congratulations!

<strong>Auction Details</strong><br/>
Item: {{ $item }}<br/>
Store: {{ $store }}<br/>
Winning bid: ₱{{ $bid }}<br/>

Kindly acknolwedge this email within <strong>24 hours</strong> using the link below:
@component('mail::button', ['url' => $url])
Acknowledge
@endcomponent
 
Regards.<br>
{{ config('app.name') }} Team
@endcomponent