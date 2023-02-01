<x-mail::message>
# Dear {{$user->name}}

<div>
    <img src="{{asset('assets/images/f.jpeg')}}" alt="LPC" width="100%" height="250px">
</div>

This is a confirmation of your booking on {{$body->event_date}} Seat number: {{$body->seat_number}} for the members hospitality viewing Terrace.

See you soon!<br>
{{ config('app.name') }}
</x-mail::message>
