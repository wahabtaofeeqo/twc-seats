@extends('layouts.app')

@section('content')
<div class="h-100 bg-cover">
    <div class="overlay h-100 d-flex align-items-center">
        <div class="col-md-6 mx-auto text-white text-center">
            <h1 class="title mb-4">Lagos Polo Club ({{date('Y')}})</h1>
            <p class="mb-5 col-md-6 mx-auto">
                Join us in celebrating 120 years of Polo, with an exceptional calibre of members, at The Lagos Polo Club the premier sporting Polo Club in Nigeria.
            </p>
            <a href="/seats" class="btn btn-md btn-primary mb-4 me-2 rounded-0">Book a seat</a>
            <button class="btn btn-md btn-light mb-4 me-2 buy-ticket rounded-0 d-none">Buy Tickets</button>
            <a href="/tables" class="btn btn-md btn-danger mb-4 rounded-0">Book Table</a>
        </div>
    </div>
</div>
@endsection
