@extends('layouts.app')

@section('content')
<div class="h-100 bg-light">
    <div class="container py-3">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4>Dashboard</h4>
            <button class="btn btn-info btn-logout d-none">Logout</button>
        </div>
        <div class="row mb-4">
            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center rounded border p-3 bg-white">
                   <div>
                        <i class="fa-solid fa-chair fa-2xl"></i>
                        <p class="mb-0 mt-1">Total Seats</p>
                   </div>
                   <h2>{{$seats}}</h2>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center rounded border p-3 bg-white">
                   <div>
                        <i class="fa-solid fa-users fa-2xl"></i>
                        <p class="mb-0 mt-1">Total Users</p>
                   </div>
                   <h2>{{count($users)}}</h2>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center rounded border p-3 bg-white">
                   <div>
                        <i class="fa-solid fa-chair fa-2xl"></i>
                        <p class="mb-0 mt-1">Today Seats</p>
                   </div>
                   <h2>{{$today}}</h2>
                </div>
            </div>
        </div>

        <div class="card border-0">
            <div class="card-body">
                <div class="mb-4 d-flex justify-content-between">
                    <h4>All Users</h4>
                    <button class="btn btn-danger px-4" type="button" data-bs-toggle="modal" data-bs-target="#bookModal">Book Seat</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Seats</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">
                                        {{$loop->index + 1}}
                                    </th>
                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                    <td>
                                        1
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
