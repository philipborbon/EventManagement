@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Event</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ action('EventController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="control-label">Name</label>

        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $event->name) }}" required autofocus>

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description" class="control-label">Description</label>

        <input id="description" type="text" class="form-control" name="description" value="{{ old('description', $event->description) }}" required autofocus>

        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('startdate') ? ' has-error' : '' }}">
            <label for="startdate" class="control-label">Start Date</label>

            <input id="startdate" type="date" class="form-control" name="startdate" value="{{ old('startdate', $event->startdate->format('Y-m-d')) }}" required autofocus>

            @if ($errors->has('startdate'))
                <span class="help-block">
                    <strong>{{ $errors->first('startdate') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-6">
        <div class="form-group{{ $errors->has('enddate') ? ' has-error' : '' }}">
            <label for="enddate" class="control-label">End Date</label>

            <input id="enddate" type="date" class="form-control" name="enddate" value="{{ old('enddate', $event->enddate->format('Y-m-d')) }}" required autofocus>

            @if ($errors->has('enddate'))
                <span class="help-block">
                    <strong>{{ $errors->first('enddate') }}</strong>
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
                <option value="{{ $key }}" {{ old('status', $event->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
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
