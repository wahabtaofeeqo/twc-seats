@extends('layouts.app')

@section('content')
<div class="bg-cover1">
    <div class="overlay py-5">
        <div class="container">

            <h4 class="text-white"><strong>Lagos Polo Club (2023)</strong></h4>
            <p class="mb-5 text-white"> The Lagos Polo Club the premier sporting Polo Club in Nigeria, with an exceptional calibre of members.</p>

            @if ($available && $available > 0)
                <h4 class="text-white mb-3">Available Seats</h4>
            @endif

            <div class="row mb-4">
                @for ($i = 0; $i < $available; $i++)
                    <div class="col-md-4 mb-4 pointer available" data-id="{{$i}}">
                        <div class="card border-0 shadow-sm seat-card">
                            <div class="card-body box">
                                <p class="text-muted small">
                                    <strong>Available</strong>
                                </p>
                                <i class="fa-solid fa-chair fa-2xl"></i>
                            </div>
                        </div>
                    </div>
                @endfor

                @if (!$available)
                    <div class="col-lg-4 mx-auto mb-4 py-5 text-center text-white">
                        <h4 class="mb-4">No available seats for program Day: {{$day}}. Please book for another day.</h4>
                        <a href="{{route('seats') . '?day=' . $day + 1}}" class="btn btn-success px-5">Book Another Day</a>
                    </div>
                @endif
            </div>

            @if (count($bookeds))
                <h4 class="text-white">Booked Seats</h4>
                <div class="row">
                    @foreach ($bookeds as $booked)
                        <div class="col-md-4 mb-4 pointer" data-id="{{$booked->id}}">
                            <div class="card border-0 shadow-sm seat-card">
                                <div class="card-body box">
                                    <p class="text-muted small">
                                        <strong>Booked</strong>
                                    </p>
                                    <div class="caption">
                                        <i class="fa-solid fa-chair fa-2xl text-danger"></i>
                                        <strong class="float-end">{{$booked->user->name}}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
