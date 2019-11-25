@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Mayor's Schedule</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('mayorschedules') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="control-label">Name</label>

        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
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

            <input id="date" type="date" class="form-control" name="date" value="{{ old('date') }}" required autofocus>

            @if ($errors->has('date'))
                <span class="help-block">
                    <strong>{{ $errors->first('date') }}</strong>
                </span>
            @endif
        </div>
        </div>
        <div class="col-6">
        <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
            <label for="time" class="control-label">Time</label>

            <input id="time" type="time" class="form-control" name="time" value="{{ old('time') }}" required autofocus>

            @if ($errors->has('time'))
                <span class="help-block">
                    <strong>{{ $errors->first('time') }}</strong>
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label for="status" class="control-label">Status</label>

            <select id="status" class="form-control" name="status" autofocus>
              @foreach(config('enums.schedulestatus') as $key => $value)
                <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
              @endforeach
            </select>

            @if ($errors->has('status'))
                <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </div>
  </form>
</div>
@endsection
