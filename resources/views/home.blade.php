@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <ul class="list-group list-group-flush">
                @foreach($links as $group)
                    <li class="list-group-item">
                    @foreach($group as $key => $value)
                    <a href="{{ $value }}" class="btn btn-primary m-2 p-2 pl-3 pr-3">{{ $key }}</a>
                    @endforeach
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
