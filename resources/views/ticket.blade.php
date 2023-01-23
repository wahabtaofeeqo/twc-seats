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
                    <h4>Tickets</h4>
                    <button class="btn btn-info px-4 d-none" type="button" data-bs-toggle="modal" data-bs-target="#bookModal">Book Seat</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Day</th>
                                <th scope="col">Tickets</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $row)
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
                                        {{$row->day}}
                                    </td>
                                    <td>
                                        {{$row->total}}
                                    </td>
                                    <td>
                                        @if ($row->confirmed)
                                            <button class="btn btn-sm btn-success">Confirmed</button>
                                        @else
                                            <button class="btn btn-sm btn-danger confirm" data-id="{{$row->id}}" data-type="ticket">Confirm</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$tickets->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
