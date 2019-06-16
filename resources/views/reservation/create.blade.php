@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create Reservation</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('rentaspace') }}">
    {{ csrf_field() }}

    <input type="hidden" name="userid" value="{{ $user->id }}">

    <div class="form-group{{ $errors->has('rentalspaceid') ? ' has-error' : '' }}">
        <label for="rentalspaceid" class="control-label">Rental Space</label>
        <div class="font-weight-bold">{{ $space->name }}</div>

        <input type="hidden" name="rentalspaceid" value="{{ $space->id }}">

        @if ($errors->has('rentalspaceid'))
            <span class="help-block">
                <strong>{{ $errors->first('rentalspaceid') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Create Reservation
        </button>
    </div>
  </form>
</div>
@endsection
