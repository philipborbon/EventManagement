@extends('layouts.jquery')

@section('content')
<div class="container">
  <h1>Create New Payment</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <form method="POST" action="{{ url('payments') }}">
    {{ csrf_field() }}

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
            <label for="userid" class="control-label">Investor</label>

            <select id="userid" class="form-control" name="userid" autofocus>
              @foreach($investors as $investor)
                <option value="{{ $investor->id }}" {{ old('userid') == $investor->id ? 'selected' : '' }}>{{ $investor->getFullname() }}</option>
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
        <div class="form-group{{ $errors->has('rentalspaceid') ? ' has-error' : '' }}">
            <label for="rentalspaceid" class="control-label">Rental Space</label>

            <select id="rentalspaceid" class="form-control" name="rentalspaceid" autofocus>
              @foreach($spaces as $space)
                <option value="{{ $space->id }}" {{ old('rentalspaceid') == $space->id ? 'selected' : '' }}>{{ $space->name }}</option>
              @endforeach
            </select>

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

                <input id="amount" type="number" step="0.01" min="0" class="form-control" name="amount" value="{{ old('amount', count($spaces) ? $spaces[0]->amount : 0) }}" required autofocus readonly>

                @if ($errors->has('amount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('verified') ? ' has-error' : '' }}">
            <label for="verified" class="control-label">Verified</label>

            <select id="verified" class="form-control" name="verified" autofocus>
                <option value="1" {{ old('verified', 1) == 1 ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('verified', 1) == 0 ? 'selected' : '' }}>No</option>
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
            Save
        </button>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
    var investors = @php echo json_encode($spaces) @endphp;

    function getInvestor(id){
        var investor = null;
        $.each(investors, function(index, value){
            if (value.id == id){
                investor = value;
                return false;
            }
        });

        return investor;
    }

    $('#rentalspaceid').change(function(){
        var id = $(this).val();
        var investor = getInvestor(id);

        $('#amount').val(investor.amount);
    });
</script>
@endsection
