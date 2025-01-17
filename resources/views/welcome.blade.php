@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background-image: linear-gradient(to right, #121139, #6933E1, #812DE2)">

    <div class="container d-flex flex-column py-3" style="overflow-x: hidden">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-white font-weight-bold">
                <img src="{{asset('assets/images/logo1.png')}}" class="me-2">
                PoloClub
            </div>

            <a href="/tables" class="btn btn-md btn-danger px-4 rounded-0">Book Table</a>
        </div>

        <div class="row align-items-center flex-grow-1 mt-5">
            <div class="col-md-6 mb-4">
                <h1 class="title mb-4">Lagos Polo</h1>
                <p class="mb-5 col-md-10 text-white">
                    Join us in celebrating 120 years of Polo, with an exceptional calibre of members, at The Lagos Polo Club the premier sporting Polo Club in Nigeria.
                </p>
                <div>
                    <a href="/tickets" class="p-2 border-d px-5 rounded-0 text-white me-3">Buy Ticket</a>
                    <a href="/seats" class="p-2 btn d-inline-block px-5 rounded bg-white text-black">Book a seat</a>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div style="width: 500px; height: 500px; border-radius: 50%; overflow: hidden;" class="mx-auto">
                    <img src="{{asset('assets/images/horse.jpg')}}" alt="" style="height: 100%; width: 100%">
                </div>
            </div>
       </div>

       <div class="rounded shado p-3 mt-5 gridd">
            <div class="mb-4">
                <h4>Open Cup</h4>
                <p>23rd Jan - 28th Jan</p>
            </div>
            <div class="mb-4">
                <h4>Majekodunmi</h4>
                <p>23rd Jan - 28th Jan</p>
            </div>
            <div class="mb-4">
                <h4>Low Cup</h4>
                <p>23rd Jan - 28th Jan</p>
            </div>
            <div class="mb-4">
                <h4>Silver Cup</h4>
                <p>23rd Jan - 28th Jan</p>
            </div>
        </div>
    </div>
</div>
@endsection
