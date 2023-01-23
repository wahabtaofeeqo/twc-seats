<x-mail::message>
# New Booking!

There is a new seat booking by {{$user->name}} and payment of #{{$body->amount}} has been made.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
