@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Payout</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ action('MonthlyPayoutController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="row">
        <div class="col-2">
            <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
                <label for="userid" class="control-label">Employee</label>
                <div class="font-weight-bold">{{ $payout->user->getFullname() }}</div>
                
                <input type="hidden" name="userid" value="{{ $payout->userid }}">

                @if ($errors->has('userid'))
                    <span class="help-block">
                        <strong>{{ $errors->first('userid') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            <div class="form-group{{ $errors->has('payout') ? ' has-error' : '' }}">
                <label for="payout" class="control-label">Payout</label>
                <div class="font-weight-bold">Php {{ number_format($payout->payout, 2) }}</div>
                
                <input type="hidden" name="payout" value="{{ $payout->payout }}">

                @if ($errors->has('payout'))
                    <span class="help-block">
                        <strong>{{ $errors->first('payout') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-3">
            <div class="form-group{{ $errors->has('actualpayout') ? ' has-error' : '' }}">
                <label for="actualpayout" class="control-label">Actual Payout</label>
                <div class="font-weight-bold">Php {{ number_format($payout->actualpayout, 2) }}</div>
                
                <input type="hidden" name="payout" value="{{ $payout->actualpayout }}">

                @if ($errors->has('actualpayout'))
                    <span class="help-block">
                        <strong>{{ $errors->first('actualpayout') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-4">
            <div>Deductions</div>
            @foreach($payout->deductions as $deduction)
            <div><b>{{ $deduction->type->name }}</b>: {{ $deduction->amount }}</div>
            @endforeach
            <div>Total: {{ $payout->deductionTotal() }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('dateavailable') ? ' has-error' : '' }}">
                <label for="dateavailable" class="control-label">Date To Be Available</label>
                <div class="font-weight-bold">{{ $payout->dateavailable->format('M d, Y') }}</div>
                
                <input type="hidden" name="dateavailable" value="{{ $payout->dateavailable->format('Y-m-d') }}">

                @if ($errors->has('dateavailable'))
                    <span class="help-block">
                        <strong>{{ $errors->first('dateavailable') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group{{ $errors->has('datecollected') ? ' has-error' : '' }}">
                <label for="datecollected" class="control-label">Date Collected</label>
                <input id="datecollected" type="date" class="form-control" name="datecollected" value="{{ old('datecollected', $payout->datecollected ? $payout->datecollected->format('Y-m-d') : date_format(now(), 'Y-m-d')) }}" required autofocus>

                @if ($errors->has('datecollected'))
                    <span class="help-block">
                        <strong>{{ $errors->first('datecollected') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </div>
  </form>
</div>
@endsection
