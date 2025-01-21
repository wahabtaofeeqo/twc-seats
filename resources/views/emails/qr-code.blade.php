<x-mail::message>
# Congratulations!!!

<p>You have successfully purchased Ticket for PoloClub 2025</p>

Kindly find the details of your Ticket below:

<h4 style="margin-bottom: 5px">Ticket Type</h4>
<p>{{$category->name}}</p>

<strong>
    Kindly find the details of your Ticket below:
</strong>

<h4 style="margin-bottom: 5px">Entry Code</h4>
<div>
    <img src="{{ asset("qrcode/" . $user->email . "/" . $qrCode) }}" alt="QR Code">
</div>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
