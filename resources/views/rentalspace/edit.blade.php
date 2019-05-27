@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Rental Space</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ action('RentalSpaceController@update', $id) }}">
      {{ csrf_field() }}

      <input name="_method" type="hidden" value="PATCH">

      <div class="row">
        <div class="col-6">
          <div class="form-group{{ $errors->has('eventid') ? ' has-error' : '' }}">
              <label for="eventid" class="control-label">Event</label>

              <select id="eventid" class="form-control" name="eventid" autofocus>
                @foreach($events as $event)
                  <option value="{{ $event->id }}" {{ $space->eventid == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                @endforeach
              </select>

              @if ($errors->has('eventid'))
                  <span class="help-block">
                      <strong>{{ $errors->first('eventid') }}</strong>
                  </span>
              @endif
          </div>
        </div>

        <div class="col-6">
          <div class="form-group{{ $errors->has('typeid') ? ' has-error' : '' }}">
              <label for="typeid" class="control-label">Type</label>

              <select id="typeid" class="form-control" name="typeid" autofocus>
                @foreach($types as $type)
                  <option value="{{ $type->id }}" {{ $space->typeid == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
              </select>

              @if ($errors->has('typeid'))
                  <span class="help-block">
                      <strong>{{ $errors->first('typeid') }}</strong>
                  </span>
              @endif
          </div>
        </div>
      </div>

      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
          <label for="name" class="control-label">Name</label>

          <input id="name" type="text" class="form-control" name="name" value="{{ $space->name }}" required autofocus>

          @if ($errors->has('name'))
              <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>
    
      <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
          <label for="location" class="control-label">Location</label>

          <input id="location" type="text" class="form-control" name="location" value="{{ $space->location }}" required autofocus>

          @if ($errors->has('location'))
              <span class="help-block">
                  <strong>{{ $errors->first('location') }}</strong>
              </span>
          @endif
      </div>

      <div class="row">
        <div class="col-6">
          <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
              <label for="area" class="control-label">Area (sq. m&sup2;)</label>

              <input id="area" type="number" step="0.01" min="0" class="form-control" name="area" value="{{ $space->area }}" required autofocus>

              @if ($errors->has('area'))
                  <span class="help-block">
                      <strong>{{ $errors->first('area') }}</strong>
                  </span>
              @endif
          </div>
        </div>

        <div class="col-6">
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
              <label for="amount" class="control-label">Amount</label>

              <input id="amount" type="number" step="0.01" min="0" class="form-control" name="amount" value="{{ $space->amount }}" required autofocus>

              @if ($errors->has('amount'))
                  <span class="help-block">
                      <strong>{{ $errors->first('amount') }}</strong>
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
                @foreach(config('enums.spacestatus') as $key => $value)
                  <option value="{{ $key }}" {{ $space->status == $key ? 'selected' : '' }}>{{ $value }}</option>
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
