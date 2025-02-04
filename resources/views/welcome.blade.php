@extends('layouts.app')

@section('content')
<div class="min-vh-100" style="background-image: linear-gradient(to right, #121139, #6933E1, #812DE2)">

    <div class="container d-flex flex-column py-3" style="overflow-x: hidden">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-white font-weight-bold d-flex align-items-center">
                <img src="{{asset('assets/images/polor.png')}}" class="me-2" width="34" height="34">
                PoloClub
            </div>

            <a href="/tickets" class="btn btn-md btn-danger px-4 rounded-0">Buy Ticket</a>
        </div>

        <div class="row align-items-center flex-grow-1 mt-5">
            <div class="col-md-6">
                <h1 class="title mb-4">Lagos Polo</h1>
                <p class="mb-5 col-md-10 text-white">
                    Join us in celebrating 120 years of Polo, with an exceptional calibre of members, at The Lagos Polo Club the premier sporting Polo Club in Nigeria.
                </p>
                <div class="d-none d-md-block">
                    <a href="/tickets" class="p-2 border-d px-5 rounded-0 text-white me-3">Buy Ticket</a>
                    <a href="/days" class="p-2 btn d-inline-block px-5 rounded bg-white text-black">Book a seat</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mx-auto oval">
                    <img src="{{asset('assets/images/banner25.jpg')}}" alt="cirle" style="height: 100%; width: 100%">
                </div>

                <div class="d-md-none mt-5">
                    <a href="/tickets" class="p-2 border-d px-5 rounded-0 text-white me-3">Buy Ticket</a>
                    <a href="/days" class="p-2 btn d-inline-block px-5 rounded bg-white text-black">Book a seat</a>
                </div>
            </div>
       </div>

       <div class="rounded shado p-3 mt-5 gridd d-none">
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
