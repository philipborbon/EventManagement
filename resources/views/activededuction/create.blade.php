@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Employee Deduction</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ url('activedeductions') }}">
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
    <div class="col-6">
    <div class="form-group{{ $errors->has('typeid') ? ' has-error' : '' }}">
        <label for="typeid" class="control-label">Deduction Type</label>

        <select id="typeid" class="form-control" name="typeid" autofocus>
          @foreach($types as $type)
            <option value="{{ $type->id }}" {{ old('typeid') == $employee->id ? 'selected' : '' }}>{{ $type->name }}</option>
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

    <div class="row">
        <div class="col-2">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                <label for="amount" class="control-label">Amount</label>

                <input id="amount" type="number" min="0" step="0.01" class="form-control" name="amount" value="{{ old('amount') }}" autofocus>

                @if ($errors->has('amount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amount') }}</strong>
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
