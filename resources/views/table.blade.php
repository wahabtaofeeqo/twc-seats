@extends('layouts.app')

@section('content')
<div class="body bg-white">
    <div class="py-5">
        <div class="container">

            <h4 class="text-white"><strong>Lagos Polo Club ({{date('Y')}})</strong></h4>
            <p class="mb-5 text-white">
                Join us in celebrating 120 years of Polo, with an exceptional calibre of members, at The Lagos Polo Club the premier sporting Polo Club in Nigeria.
            </p>

            <div class="mb-4">
                <img src="{{asset('assets/images/table.jpeg')}}" class="rounded" style="width: 100%; height: 400px;" alt="">
            </div>

            <h4 class="text-white mb-4"><strong>Book a Table on The Veuve Terrace</strong></h4>
            <div class="row">
                @for ($i = 0; $i < 15; $i++)
                    <div class="col-4 mb-4">
                        <div class="card bg-light border-2 {{in_array($i + 1, $couch) ? 'border-danger' : 'border-primary'}}">
                            <div class="pointer couch p-1" data-number="{{$i + 1}}" data-type="couch" data-color="blue">
                                <p class="mb-0 small"><strong>{{$i + 1}}</strong></p>
                                <img src="{{asset('assets/images/table.png')}}" alt="" width="100%">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
