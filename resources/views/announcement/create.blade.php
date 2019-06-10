@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Create New Announcement</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

  <form method="POST" action="{{ url('announcements') }}">
      {{ csrf_field() }}

    <div class="form-group{{ $errors->has('headline') ? ' has-error' : '' }}">
        <label for="headline" class="control-label">Headline</label>

        <input id="headline" type="text" class="form-control" name="headline" value="{{ old('headline') }}" required autofocus>

        @if ($errors->has('headline'))
            <span class="help-block">
                <strong>{{ $errors->first('headline') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description" class="control-label">Description</label>

        <textarea id="description" type="text" class="form-control" name="description" required autofocus>{{ old('description') }}</textarea>

        @if ($errors->has('description'))
            <span class="help-block">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
    </div>

    <div class="row">
        <div class="col-6">
        <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
            <label for="active" class="control-label">Active?</label>

            <select id="active" class="form-control" name="active" autofocus>
            <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Yes</option>
            <option value="0" {{ old('active', 1) == 0 ? 'selected' : '' }}>No</option>
            </select>

            @if ($errors->has('active'))
                <span class="help-block">
                    <strong>{{ $errors->first('active') }}</strong>
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
