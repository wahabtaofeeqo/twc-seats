@extends('layouts.app')

@section('content')
<div class="bg-cover">
    <div class="overlay py-5">
        <div class="container">

            <h4 class="text-white"><strong>Wristband Event</strong></h4>
            <p class="mb-5 text-white">Lorem ipsum, dolor sit amet consectetur adipisicing e</p>

            <div class="row">
                @foreach ($seats as $seat)
                    <div class="col-md-4 mb-4 pointer {{$seat->user ? '' : 'available' }}" data-id="{{$seat->id}}">
                        <div class="card border-0 shadow-sm seat-card">
                            <div class="card-body">
                                <p class="text-muted small">
                                    <strong>
                                        {{$seat->user ? 'Booked' : 'Available'}}
                                    </strong>
                                </p>

                                @if (!$seat->user)
                                    <i class="fa-solid fa-chair fa-2xl"></i>
                                @endif

                                @if ($seat->user)
                                    <i class="fa-solid fa-chair fa-2xl text-danger"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
