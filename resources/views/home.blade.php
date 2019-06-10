@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                @foreach($links as $key => $value)
                <a href="{{ $value }}" class="btn btn-primary m-2 p-2 pl-3 pr-3">{{ $key }}</a>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
