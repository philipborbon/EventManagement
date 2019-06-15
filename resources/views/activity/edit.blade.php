@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Activity</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ action('ActivityController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="form-group{{ $errors->has('eventid') ? ' has-error' : '' }}">
        <label for="eventid" class="control-label">Event</label>
        <div class="font-weight-bold">{{ $activity->event->name }}</div>
        <input type="hidden" name="eventid" value="{{ $activity->eventid }}">

        @if ($errors->has('eventid'))
            <span class="help-block">
                <strong>{{ $errors->first('eventid') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="control-label">Name</label>

        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $activity->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
        <label for="location" class="control-label">Location</label>

        <input id="location" type="text" class="form-control" name="location" value="{{ old('location', $activity->location) }}" required autofocus>

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

            <input id="date" type="date" class="form-control" name="date" value="{{ old('date', $activity->schedule->format('Y-m-d')) }}" required autofocus>

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

            <input id="time" type="time" class="form-control" name="time" value="{{  old('time', $activity->schedule->format('H:i'))}}" required autofocus>

            @if ($errors->has('time'))
                <span class="help-block">
                    <strong>{{ $errors->first('time') }}</strong>
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
