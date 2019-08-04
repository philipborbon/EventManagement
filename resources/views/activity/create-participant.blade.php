@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Add New Participant</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url(sprintf("activities/%d/participants", $id)) }}">
    {{ csrf_field() }}

    <input type="hidden" name="activityid" value="{{ $id }}">
    <input type="hidden" name="accepted" value="1">

    <div class="row">
          <div class="col-6">
          <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
              <label for="userid" class="control-label">Participant</label>

              <select id="userid" class="form-control" name="userid" autofocus>
                @foreach($users as $user)
                  @php
                  $selected = old('userid') == $user->id ? 'selected' : '' ;
                  @endphp

                  <option value="{{ $user->id }}" {{ $selected }}>{{ $user->getFullname() }}</option>
                @endforeach
              </select>

              @if ($errors->has('userid'))
                  <span class="help-block">
                      <strong>{{ $errors->first('userid') }}</strong>
                  </span>
              @endif
          </div>
          </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
  </form>
</div>
@endsection
