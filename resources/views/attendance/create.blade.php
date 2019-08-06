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
        <div class="col-4">
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

        <div class="col-4">
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

        <div class="col-4">
            <div class="form-group{{ $errors->has('doublepay') ? ' has-error' : '' }}">
                <label for="doublepay" class="control-label">Is Double Pay</label>

                <select id="doublepay" class="form-control" name="doublepay" autofocus>
                    <option value="1" {{ old('doublepay', 0) == '1' ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('doublepay', 0) == '0' ? 'selected' : '' }}>No</option>
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

                <input id="amin" type="time" class="form-control" name="amin" value="{{ old('amin') }}" min="00:00" max="11:59" autofocus>

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

                <input id="amout" type="time" class="form-control" name="amout" value="{{ old('amout') }}" autofocus>

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

                <input id="pmin" type="time" class="form-control" name="pmin" value="{{ old('pmin') }}" min="12:00" max="23:59" autofocus>

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

                <input id="pmout" type="time" class="form-control" name="pmout" value="{{ old('pmout') }}" min="12:00" max="23:59" autofocus>

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
