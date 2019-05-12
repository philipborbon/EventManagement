@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Event</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('events') }}">
      {{ csrf_field() }}

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description" class="control-label">Description</label>

        <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required autofocus>

        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
        <label for="location" class="control-label">Location</label>

        <input id="location" type="text" class="form-control" name="location" value="{{ old('location') }}" required autofocus>

        @if ($errors->has('location'))
            <span class="help-block">
                <strong>{{ $errors->first('location') }}</strong>
            </span>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
            <label for="date" class="control-label">Date</label>

            <input id="date" type="date" class="form-control" name="date" value="{{ old('date') }}" autofocus>

            @if ($errors->has('date'))
                <span class="help-block">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col"></div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </div>
  </form>
</div>
@endsection
