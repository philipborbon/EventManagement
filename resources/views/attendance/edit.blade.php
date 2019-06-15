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
    <div class="col-6">
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
    </div>

    <div class="row">
        <div class="col-3">
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
        <div class="col-2">
            <div class="form-group{{ $errors->has('overtime') ? ' has-error' : '' }}">
                <label for="overtime" class="control-label">Overtime (Hrs)</label>

                <input id="overtime" type="number" min="0" step="0.01" class="form-control" name="overtime" value="{{ old('overtime', $attendance->overtime) }}" autofocus>

                @if ($errors->has('overtime'))
                    <span class="help-block">
                        <strong>{{ $errors->first('overtime') }}</strong>
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
    </div>

    <div class="row">
    <div class="col-3">
    <div class="form-group{{ $errors->has('ishalfday') ? ' has-error' : '' }}">
        <label for="ishalfday" class="control-label">Is Half Day</label>

        <select id="ishalfday" class="form-control" name="ishalfday" autofocus>
            <option value="1" {{ old('ishalfday', $attendance->ishalfday) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('ishalfday', $attendance->ishalfday) == '0' ? 'selected' : '' }}>No</option>
        </select>

        @if ($errors->has('ishalfday'))
            <span class="help-block">
                <strong>{{ $errors->first('ishalfday') }}</strong>
            </span>
        @endif
    </div>
    </div>
    <div class="col-3">
    <div class="form-group{{ $errors->has('doublepay') ? ' has-error' : '' }}">
        <label for="doublepay" class="control-label">Is Double Pay</label>

        <select id="doublepay" class="form-control" name="doublepay" autofocus>
            <option value="1" {{ old('doublepay', $attendance->doublepay) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('doublepay', $attendance->doublepay) == '0' ? 'selected' : '' }}>No</option>
        </select>

        @if ($errors->has('ishalfday'))
            <span class="help-block">
                <strong>{{ $errors->first('ishalfday') }}</strong>
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
