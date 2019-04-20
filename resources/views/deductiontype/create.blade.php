@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- <div class="col-md-8 col-md-offset-2"> -->
            <!-- <div class="panel panel-default"> -->
                <h1>Add New Deduction Type</h1>
                <!-- <div class="panel-body"> -->
                  @if (Session::has('success'))
                  <div class="alert alert-success">
                      <p>{{ Session::get('success') }}</p>
                  </div><br />
                  @endif
                    <form method="POST" action="{{ url('deductiontype') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">Name</label>

                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="control-label">Description</label>

                            <textarea id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" autofocus></textarea>

                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </form>
                <!-- </div> -->
            <!-- </div> -->
        <!-- </div> -->
    </div>
</div>
@endsection
