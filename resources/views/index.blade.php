@extends('layouts.app')

@section('content')
<div class="body">
    <div class="py-5">
        <div class="container">

            <h4 class="text-white"><strong>Lagos Polo Club (2023)</strong></h4>
            <p class="mb-5 text-white"> The Lagos Polo Club the premier sporting Polo Club in Nigeria, with an exceptional calibre of members.</p>

            <div class="mb-4">
                <img src="{{asset('assets/images/f.jpeg')}}" class="rounded" style="width: 100%; height: 400px;" alt="">
            </div>

            <div class="row d-none">
                <div class="col-lg-5">
                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 5px;">
                        @for ($i = 0; $i < 20; $i++)
                            @php
                                $seat = $seats[$i];
                            @endphp
                            <div class="col pointer {{in_array($seat->id, $bookeds) ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="white">
                                <div class="p-1 py-2 bg-secondary rounded box text-center">
                                    <i class="fa-solid fa-chair fa-2xl fa-rotate-180 {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-white'}}"></i>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <hr class="text-white d-none">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 mb-4 px-0">
                        <h1 class="text-center text-white">B</h1>
                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">
                            @php
                                $counter = 42;
                            @endphp

                            @for ($i = 41; $i < 62; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="pointer available" data-id="{{$seat->id}}" data-type="blue" data-number="{{$counter}}">
                                    <div class="p-1 py-2 bg-white rounded box text-center">
                                        <p class="mb-2 small">{{$counter}}</p>
                                        <i class="fa-solid fa-chair fa-2xl fa-rotate-180 {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-primary'}}"></i>
                                    </div>
                                </div>

                                @php
                                    $counter--;
                                    if($counter % 7 == 0) $counter -= 7
                                @endphp
                            @endfor
                        </div>
                    </div>

                    <hr class="text-white d-lg-none">

                    <div class="col-lg-5 ms-auto px-0">
                        <h1 class="text-center text-white">A</h1>
                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">
                            @php
                                $counter = 35;
                            @endphp

                            @for ($i = 20; $i < 41; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp

                                <div class="pointer available" data-id="{{$seat->id}}" data-type="blue" data-number="{{$counter}}">
                                    <div class="p-1 py-2 bg-white rounded box text-center">
                                        <p class="mb-2 small">{{$counter}}</p>
                                        <i class="fa-solid fa-chair fa-2xl fa-rotate-180 {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-primary'}}"></i>
                                    </div>
                                </div>

                                @php
                                    $counter--;
                                    if($counter % 7 == 0) $counter -= 7
                                @endphp
                            @endfor
                        </div>
                    </div>

                    <hr class="text-white d-lg-none">
                </div>

                <div class="row">
                    <hr class="text-white d-lg-none">
                    <div class="col-lg-5 ms-auto px-0">
                        <h1 class="text-center text-white">C</h1>
                        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 5px;">
                            @for ($i = 0; $i < 20; $i++)
                                @php
                                    $seat = $seats[$i];
                                @endphp
                                <div class="col pointer {{in_array($seat->id, $bookeds) ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="white">
                                    <div class="p-1 py-2 bg-secondary rounded box text-center">
                                        <i class="fa-solid fa-chair fa-2xl fa-rotate-180 {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-white'}}"></i>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
