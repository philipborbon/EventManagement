@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Attendance</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ url('attendances') }}">
    {{ csrf_field() }}

    <div class="row">
    <div class="col-6">
    <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
        <label for="userid" class="control-label">Employee</label>

        <select id="userid" class="form-control" name="userid" autofocus>
          @foreach($employees as $employee)
            <option value="{{ $employee->id }}" {{ old('userid') == $employee->id ? 'selected' : '' }}>{{ $employee->getFullname() }}</option>
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

    <div class="row">
        <div class="col-3">
            <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                <label for="date" class="control-label">Date</label>

                <input id="date" type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d', strtotime(now()))) }}" required autofocus>

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

                <input id="overtime" type="number" min="0" step="0.01" class="form-control" name="overtime" value="{{ old('overtime') }}" autofocus>

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

    <div class="row">
    <div class="col-3">
    <div class="form-group{{ $errors->has('ishalfday') ? ' has-error' : '' }}">
        <label for="ishalfday" class="control-label">Is Half Day</label>

        <select id="ishalfday" class="form-control" name="ishalfday" autofocus>
            <option value="1" {{ old('ishalfday', 0) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('ishalfday', 0) == '0' ? 'selected' : '' }}>No</option>
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
            <option value="1" {{ old('doublepay', 0) == '1' ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('doublepay', 0) == '0' ? 'selected' : '' }}>No</option>
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
