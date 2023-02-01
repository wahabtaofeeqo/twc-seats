@extends('layouts.app')

@section('content')
<div class="h-100 bg-cover">
    <div class="overlay h-100 d-flex align-items-center">
        <div class="col-md-6 mx-auto text-white text-center">
            <h1 class="title mb-4">Lagos Polo Club (2023)</h1>
            <p class="mb-5 col-md-6 mx-auto">
                The Lagos Polo Club the premier sporting Polo Club in Nigeria, with an exceptional calibre of members.
            </p>
            <a href="/seats" class="btn btn-lg btn-danger mb-4 me-2">Book a seat</a>
            <button class="btn btn-lg btn-light mb-4 me-2 buy-ticket">Buy Tickets</button>
            <a href="/tables" class="btn btn-lg btn-danger mb-4">Book Table</a>
        </div>
    </div>
</div>
@endsection
