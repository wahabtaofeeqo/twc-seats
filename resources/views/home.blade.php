@extends('layouts.dash')

@section('content')
<div class="h-100 bg-light">
    <div class="container py-3">

        <div class="row mb-4">
            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center rounded border p-3 bg-white">
                   <div>
                        <i class="fa-solid fa-users"></i>
                        <p class="mb-0 mt-1">Total Users</p>
                   </div>
                   <h2>{{$users}}</h2>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center rounded border p-3 bg-white">
                   <div>
                        <i class="fa-solid fa-chair"></i>
                        <p class="mb-0 mt-1">Bookings</p>
                   </div>
                   <h2>{{$totalBookings}}</h2>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center rounded border p-3 bg-white">
                   <div>
                        <i class="fa-solid fa-chair"></i>
                        <p class="mb-0 mt-1">Tickets</p>
                   </div>
                   <h2>{{$totalTickets}}</h2>
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-body">
                <div class="mb-4 d-flex justify-content-between">
                    <h4>Bookings</h4>
                    <button class="btn btn-info px-4" type="button" data-bs-toggle="modal" data-bs-target="#bookModal">Book Seat</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Day</th>
                                <th scope="col">Seat Type</th>
                                <th scope="col">Seat Number</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $row)
                                <tr>
                                    <th scope="row">
                                        {{$loop->index + 1}}
                                    </th>
                                    <td>
                                        {{$row->user->name}}
                                    </td>
                                    <td>
                                        {{$row->user->email}}
                                    </td>
                                    <td>
                                        {{
                                            $row->event_date ? $row->event_date : $row->day
                                        }}
                                    </td>
                                    <td>{{$row->type}}</td>
                                    <td>{{$row->seat_number}}</td>
                                    <td>
                                        @if ($row->confirmed)
                                            <button class="btn btn-sm btn-success">Confirmed</button>
                                        @else
                                            <button class="btn btn-sm btn-info confirm" data-id="{{$row->id}}" data-type="booking">Confirm</button>
                                        @endif
                                        <button class="btn btn-sm btn-danger cancel" data-id="{{$row->id}}" data-type="booking">Cancel</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$bookings->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
