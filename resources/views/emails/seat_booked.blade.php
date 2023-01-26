<x-mail::message>
# Hi, {{$user->name}}

<div>
    <img src="{{asset('assets/images/f.jpeg')}}" alt="LPC" width="100%" height="250px">
</div>

Your seat has been booked successfully.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
