@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Update Payment</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ action('PaymentController@update', $id) }}">
    {{ csrf_field() }}

    <input name="_method" type="hidden" value="PATCH">

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
            <label for="userid" class="control-label">Investor</label>
            <div class="font-weight-bold">{{ $payment->user->getFullname() }}</div>

            <input type="hidden" name="userid" value="{{ $payment->userid }}">

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
        <div class="form-group{{ $errors->has('reservationid') ? ' has-error' : '' }}">
            <label for="reservationid" class="control-label">Reservation ID</label>
            <div class="font-weight-bold">{{ $payment->reservationid ? $payment->reservationid : '--' }}</div>

            <input type="hidden" name="reservationid" value="{{ $payment->reservationid }}">

            @if ($errors->has('reservationid'))
                <span class="help-block">
                    <strong>{{ $errors->first('reservationid') }}</strong>
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('rentalspaceid') ? ' has-error' : '' }}">
            <label for="rentalspaceid" class="control-label">Rental Space</label>
            <div class="font-weight-bold">{{ $payment->rentalSpace->name }}</div>

            <input type="hidden" name="rentalspaceid" value="{{ $payment->rentalspaceid }}">

            @if ($errors->has('rentalspaceid'))
                <span class="help-block">
                    <strong>{{ $errors->first('rentalspaceid') }}</strong>
                </span>
            @endif
        </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                <label for="amount" class="control-label">Amount</label>
                <div class="font-weight-bold">Php {{ number_format($payment->amount, 2) }}</div>

                <input type="hidden" name="amount" value="{{ $payment->amount }}">

                @if ($errors->has('amount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
        <div class="form-group{{ $errors->has('verified') ? ' has-error' : '' }}">
            <label for="verified" class="control-label">Verified</label>

            <select id="verified" class="form-control" name="verified" autofocus>
                <option value="1" {{ old('verified', $payment->verified) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('verified', $payment->verified) == 0 ? 'selected' : '' }}>No</option>
            </select>

            @if ($errors->has('verified'))
                <span class="help-block">
                    <strong>{{ $errors->first('verified') }}</strong>
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
