@extends('layouts.jquery')

@section('content')
<div class="container">
    <h1>User Identification</h1>

    @if (Session::has('success'))
    <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
    </div><br />
    @endif

    <div>
      <div class="d-flex flex-row">
        @if  ( $user->usertype == 'admin' )
        <div class="p-2">
        <form action="{{action('UserIdentificationController@verify', $identification['id'])}}" method="post">
        {{csrf_field()}}
        <input name="_method" type="hidden" value="PATCH">

        @if ( $identification->verified )
        <input type="hidden" name="verified" value="0">
        <button class="btn btn-warning" type="submit">Undo Verification</button>
        @else
        <input type="hidden" name="verified" value="1">
        <button class="btn btn-warning" type="submit">Verify</button>
        @endif
        </form>
        </div>
        @endif

        <div class="p-2">
        <form action="{{action('UserIdentificationController@destroy', $identification['id'])}}" method="post">
            {{csrf_field()}}
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
        </form>
        </div>
      </div>
      <div class="mt-2">Verified: <b>{{ $identification->verified ? 'Yes' : 'No' }}</b></div>
      <div>Document Type: {{ $identification->documentType->name }}</div>
      <div>
          <img src="{{ asset('/storage/' . $identification->attachment ) }}" class="img-fluid">
      </div>
    </div>
</div>
@endsection