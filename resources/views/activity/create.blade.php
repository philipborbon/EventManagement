@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Activity</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('activities') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('eventid') ? ' has-error' : '' }}">
        <label for="eventid" class="control-label">Event</label>

        <select id="eventid" class="form-control" name="eventid" autofocus>
          @foreach($events as $event)
            <option value="{{ $event->id }}" {{ old('eventid') == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
          @endforeach
        </select>

        @if ($errors->has('eventid'))
            <span class="help-block">
                <strong>{{ $errors->first('eventid') }}</strong>
            </span>
        @endif
    </div>

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
        <div class="form-group{{ $errors->has('schedule') ? ' has-error' : '' }}">
            <label for="schedule" class="control-label">Schedule</label>

            <input id="schedule" type="datetime-local" class="form-control" name="schedule" value="{{ old('schedule') }}" required autofocus>

            @if ($errors->has('schedule'))
                <span class="help-block">
                    <strong>{{ $errors->first('schedule') }}</strong>
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
