@extends('layouts.app')

@section('content')
<div class="body">
    <div class="py-5">
        <div class="container">

            <h4 class="text-white"><strong>Lagos Polo Club (2023)</strong></h4>
            <p class="mb-5 text-white"> The Lagos Polo Club the premier sporting Polo Club in Nigeria, with an exceptional calibre of members.</p>

            @if ($available && $available > 0)
                <h4 class="text-white mb-3">Book seats</h4>
            @endif

            <div class="row">
                @for ($i = 0; $i < 20; $i++)
                    @php
                        $seat = $seats[$i];
                    @endphp

                    <div class="col-2 mb-2 pointer {{$seat->user ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="white">
                        <div class="p-2 bg-secondary rounded box">
                            <i class="fa-solid fa-chair fa-2xl {{$seat->user ? 'text-danger' : 'text-white'}}"></i>
                            <span class="d-none d-md-inline float-end small text-white">{{$seat->user ? 'Booked' : 'Free'}}</span>
                        </div>
                    </div>
                @endfor
            </div>
            <hr class="text-white">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 mb-4">
                        <div class="row">
                            @for ($i = 20; $i < 41; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="col m-1 pointer {{$seat->user ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="blue">
                                    <div class="p-2 bg-white rounded box text-center">
                                        <i class="fa-solid fa-chair fa-2xl {{$seat->user ? 'text-danger' : 'text-primary'}}"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <hr class="text-white d-lg-none">

                    <div class="col-lg-5 ms-auto">
                        <div class="row">
                            @for ($i = 41; $i < 62; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="col m-1 pointer {{$seat->user ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="blue">
                                    <div class="p-2 bg-white rounded box text-center">
                                        <i class="fa-solid fa-chair fa-2xl {{$seat->user ? 'text-danger' : 'text-primary'}}"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 d-none">
                <div class="col-lg-12 p-2">
                    <div class="container-fluid">
                        <div class="row bg-light rounded py-3">
                            @for ($i = 0; $i < 22; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="col-2 mb-2 pointer {{$seat->user ? 'booked' : 'available'}}" data-id="{{$seat->id}}">
                                    <div class="p-2 bg-white rounded">
                                        <i class="fa-solid fa-chair fa-2xl {{$seat->user ? 'text-danger' : ''}}"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 p-2">
                    <div class="container-fluid">
                        <div class="row bg-light rounded py-3">
                            @for ($i = 22; $i < 42; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="col-2 mb-2 pointer {{$seat->user ? 'booked' : 'available'}}" data-id="{{$seat->id}}">
                                    <div class="p-2 bg-white rounded">
                                        <i class="fa-solid fa-chair fa-2xl {{$seat->user ? 'text-danger' : ''}}"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 p-2">
                    <div class="container-fluid">
                        <div class="row bg-light rounded py-3">
                            @for ($i = 42; $i < 62; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="col-2 mb-2 pointer {{$seat->user ? 'booked' : 'available'}}" data-id="{{$seat->id}}">
                                    <div class="p-2 bg-white rounded">
                                        <i class="fa-solid fa-chair fa-2xl {{$seat->user ? 'text-danger' : ''}}"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                @if (!$available)
                    <div class="col-lg-4 mx-auto mb-4 py-5 text-center text-white">
                        <h4 class="mb-4">No available seats for program Day: {{$day}}. Please book for another day.</h4>
                        <a href="{{route('seats') . '?day=' . $day + 1}}" class="btn btn-success px-5">Book Another Day</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
