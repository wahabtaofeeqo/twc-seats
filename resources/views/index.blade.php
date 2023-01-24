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
                <div class="col-lg-5">
                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 5px;">
                        @for ($i = 0; $i < 20; $i++)
                            @php
                                $seat = $seats[$i];
                            @endphp
                            <div class="col pointer {{in_array($seat->id, $bookeds) ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="white">
                                <div class="p-1 py-2 bg-secondary rounded box text-center">
                                    <i class="fa-solid fa-chair fa-2xl {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-white'}}"></i>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <hr class="text-white">
            
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 mb-4 px-0">
                        <h1 class="text-center text-white">A</h1>
                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">
                            @php
                                $counter = 0;
                            @endphp

                            @for ($i = 41; $i < 62; $i++)
                                @php
                                    $counter++;
                                    $seat = $seats[$i];
                                @endphp

                                <div class="pointer {{in_array($seat->id, $bookeds) ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="blue" data-number="{{$counter}}">
                                    <div class="p-1 py-2 bg-white rounded box text-center">
                                        <p class="mb-2 small">{{$counter}}</p>
                                        <i class="fa-solid fa-chair fa-2xl {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-primary'}}"></i>
                                    </div>
                                </div>

                                @php
                                    if($counter % 7 == 0) $counter += 7
                                @endphp
                            @endfor
                        </div>
                    </div>

                    <hr class="text-white d-lg-none">

                    <div class="col-lg-5 ms-auto px-0">
                        <h1 class="text-center text-white">B</h1>
                        <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">
                            @php
                                $counter = 7;
                            @endphp

                            @for ($i = 20; $i < 41; $i++)
                                @php
                                    $counter++;
                                    $seat = $seats[$i];
                                @endphp

                                <div class="pointer {{in_array($seat->id, $bookeds) ? 'booked' : 'available'}}" data-id="{{$seat->id}}" data-type="blue" data-number="{{$counter}}">
                                    <div class="p-1 py-2 bg-white rounded box text-center">
                                        <p class="mb-2 small">{{$counter}}</p>
                                        <i class="fa-solid fa-chair fa-2xl {{in_array($seat->id, $bookeds) ? 'text-danger' : 'text-primary'}}"></i>
                                    </div>
                                </div>

                                @php
                                    if($counter % 7 == 0) $counter += 7
                                @endphp
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
