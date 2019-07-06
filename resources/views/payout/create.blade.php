@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Generate Payslips</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ action('MonthlyPayoutController@generate') }}">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-3">
            <div class="form-group{{ $errors->has('month') ? ' has-error' : '' }}">
                <label for="month" class="control-label">Month</label>

                <select id="month" class="form-control" name="month" autofocus>
                  @foreach(config('enums.months') as $key => $value)
                    <option value="{{ $key }}" {{ old('month', date_format(now(), 'm')) == $key ? 'selected' : '' }}>{{ $value }}</option>
                  @endforeach
                </select>

                @if ($errors->has('month'))
                    <span class="help-block">
                        <strong>{{ $errors->first('month') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-3">
            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                <label for="year" class="control-label">Year</label>
                <input id="year" type="number" class="form-control" name="year" value="{{ old('year', date_format(now(), 'Y')) }}" required autofocus>

                @if ($errors->has('year'))
                    <span class="help-block">
                        <strong>{{ $errors->first('year') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group{{ $errors->has('dateavailable') ? ' has-error' : '' }}">
                <label for="dateavailable" class="control-label">Date To Be Available</label>
                <input id="dateavailable" type="date" class="form-control" name="dateavailable" value="{{ old('dateavailable', date_format(now(), 'Y-m-d')) }}" required autofocus>

                @if ($errors->has('dateavailable'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dateavailable') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Generate
        </button>
    </div>
  </form>
</div>
@endsection
