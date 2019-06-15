@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Employee Deduction</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ action('EmployeeActiveDeductionController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">
    
    <div class="row">
    <div class="col-6">
    <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
        <label for="userid" class="control-label">Employee</label>
        <div class="font-weight-bold">{{ $deduction->user->getFullname() }}</div>

        <input type="hidden" name="userid" value="{{ $deduction->userid }}">

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
        <div class="font-weight-bold">{{ $deduction->type->name }}</div>

        <input type="hidden" name="typeid" value="{{ $deduction->typeid }}">

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

                <input id="amount" type="number" min="0" step="0.01" class="form-control" name="amount" value="{{ old('amount', $deduction->amount) }}" autofocus>

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
