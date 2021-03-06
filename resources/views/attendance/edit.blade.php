@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Attendance</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ action('AttendanceController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
                <label for="userid" class="control-label">Employee</label>
                <div class="font-weight-bold">{{ $attendance->user->getFullname() }}</div>

                <input type="hidden" name="userid" value="{{ $attendance->userid }}">

                @if ($errors->has('userid'))
                    <span class="help-block">
                        <strong>{{ $errors->first('userid') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-4">
            <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                <label for="date" class="control-label">Date</label>
                <div class="font-weight-bold">{{ $attendance->date->format('M d, Y') }}</div>

                <input type="hidden" name="date" value="{{ $attendance->date->format('Y-m-d') }}">

                @if ($errors->has('date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <label for="status" class="control-label">Status</label>

                <select id="status" class="form-control" name="status" autofocus>
                  @foreach(config('enums.attendancestatus') as $key => $value)
                    <option value="{{ $key }}" {{ old('status', $attendance->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                </select>

                @if ($errors->has('status'))
                    <span class="help-block">
                        <strong>{{ $errors->first('status') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-4">
            <div class="form-group{{ $errors->has('doublepay') ? ' has-error' : '' }}">
                <label for="doublepay" class="control-label">Is Double Pay</label>

                <select id="doublepay" class="form-control" name="doublepay" autofocus>
                    <option value="1" {{ old('doublepay', $attendance->doublepay) == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('doublepay', $attendance->doublepay) == '0' ? 'selected' : '' }}>No</option>
                </select>

                @if ($errors->has('doublepay'))
                    <span class="help-block">
                        <strong>{{ $errors->first('doublepay') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('amin') ? ' has-error' : '' }}">
                <label for="amin" class="control-label">AM In</label>

                <input id="amin" type="time" class="form-control" name="amin" value="{{ old('amin', $attendance->amin ? $attendance->getAmIn()->format('H:i') : NULL) }}" min="00:00" max="11:59" autofocus>

                @if ($errors->has('amin'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amin') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="form-group{{ $errors->has('amout') ? ' has-error' : '' }}">
                <label for="amout" class="control-label">AM Out</label>

                <input id="amout" type="time" class="form-control" name="amout" value="{{ old('amout', $attendance->amout ? $attendance->getAmOut()->format('H:i') : NULL) }}" autofocus>

                @if ($errors->has('amout'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amout') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('pmin') ? ' has-error' : '' }}">
                <label for="pmin" class="control-label">PM In</label>

                <input id="pmin" type="time" class="form-control" name="pmin" value="{{ old('pmin', $attendance->pmin ? $attendance->getPmIn()->format('H:i') : NULL) }}" min="12:00" max="23:59" autofocus>

                @if ($errors->has('pmin'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pmin') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-4">
            <div class="form-group{{ $errors->has('pmout') ? ' has-error' : '' }}">
                <label for="pmout" class="control-label">PM Out</label>

                <input id="pmout" type="time" class="form-control" name="pmout" value="{{ old('pmout', $attendance->pmout ? $attendance->getPmOut()->format('H:i') : NULL) }}" min="12:00" max="23:59" autofocus>

                @if ($errors->has('pmout'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pmout') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12"><p>Note: If status is "On Leave", in and out are ignored on saving.</p></div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </div>
  </form>
</div>
@endsection
