@extends('layouts.app')

@section('content')
<div class="h-100 d-flex align-items-center bg-light border-0">
    <div class="col-lg-4 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="card-title">Welcome back</h4>
            </div>
            <div class="card-body">
                @if ($errors->has('error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('error') }}
                    </div>
                @endif
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="">Username</label>
                        <input type="text" name="email" class="form-control" placeholder="Username">
                    </div>

                    <div class="mb-4">
                        <label for="">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <button class="btn btn-danger px-5">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
