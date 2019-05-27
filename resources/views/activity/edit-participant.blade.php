@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Participant</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ action('ActivityController@updateParticipant', ['id' => $participant['activityid'], 'participantId' => $participant['id']]) }}">
      {{ csrf_field() }}

      <input name="_method" type="hidden" value="PATCH">

      <input type="hidden" name="activityid" value="{{ $id }}">

      <div class="row">

        <div class="col">
        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
            <label for="firstname" class="control-label">First Name</label>

            <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname', $participant->firstname) }}" required autofocus>

            @if ($errors->has('firstname'))
                <span class="help-block">
                    <strong>{{ $errors->first('firstname') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col">
        <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
            <label for="lastname" class="control-label">Last Name</label>

            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname', $participant->firstname) }}" required autofocus>

            @if ($errors->has('lastname'))
                <span class="help-block">
                    <strong>{{ $errors->first('lastname') }}</strong>
                </span>
            @endif
        </div>
      </div>
    </div>

    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        <label for="address" class="control-label">Address</label>

        <input id="address" type="text" class="form-control" name="address" value="{{ old('address', $participant->address) }}" autofocus>

        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>

    <div class="row">
    <div class="col-2">
    <div class="form-group{{ $errors->has('age') ? ' has-error' : '' }}">
        <label for="age" class="control-label">Age</label>

        <input id="age" type="number" class="form-control" name="age" min="0" value="{{ old('age', $participant->age) }}" autofocus>

        @if ($errors->has('age'))
            <span class="help-block">
                <strong>{{ $errors->first('age') }}</strong>
            </span>
        @endif
    </div>
    </div>

    <div class="col-2">
    <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
        <label for="sex" class="control-label">Sex</label>

        <select id="sex" class="form-control" name="sex" autofocus>
          @foreach(config('enums.sex') as $key => $value)
            <option value="{{ $key }}" {{ old('sex', $participant->sex) == $key ? 'selected' : '' }}>{{ $value }}</option>
          @endforeach
        </select>

        @if ($errors->has('sex'))
            <span class="help-block">
                <strong>{{ $errors->first('sex') }}</strong>
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
