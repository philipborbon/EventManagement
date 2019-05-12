@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Add New Deduction Type</h1>
  <!-- <div class="panel-body"> -->
    @if (Session::has('success'))
    <div class="alert alert-success">
        <p>{{ Session::get('success') }}</p>
    </div><br />
    @endif
      <form method="POST" action="{{ url('salarygrades') }}">
          {{ csrf_field() }}

          <div class="row">

              <div class="col">
              <div class="form-group{{ $errors->has('userid') ? ' has-error' : '' }}">
                  <label for="userid" class="control-label">Employee</label>

                  <select id="userid" class="form-control" name="userid" autofocus>
                    @foreach($users as $user)
                      @php

                      $selected = '';
                      if (isset($grade)) {
                          $selected = $grade->userid == $user->id ? 'selected' : '';
                      } else { 
                          $selected = old('userid') == $user->id ? 'selected' : '' ;
                      }

                      @endphp

                      <option value="{{ $user->id }}" {{ $selected }}>{{ $user->getFullname() }}</option>
                    @endforeach
                  </select>

                  @if ($errors->has('userid'))
                      <span class="help-block">
                          <strong>{{ $errors->first('userid') }}</strong>
                      </span>
                  @endif
              </div>
              </div>

              <div class="col">
              <div class="form-group{{ $errors->has('dailypay') ? ' has-error' : '' }}">
                  <label for="dailypay" class="control-label">Daily Pay</label>

                  <input id="dailypay" type="text" class="form-control" name="dailypay" value="{{ isset($grade) ? $grade->dailypay : old('dailypay') }}" required autofocus>

                  @if ($errors->has('dailypay'))
                      <span class="help-block">
                          <strong>{{ $errors->first('dailypay') }}</strong>
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
