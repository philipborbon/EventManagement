@extends('layouts.jquery')

@section('content')
<div class="container">
    <h1>User Identification</h1>

    @if (Session::has('success'))
    <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
    </div><br />
    @endif

    <div class="m-3">
      <div class="d-flex flex-row">
        <div class="p-2">
            <form action="{{action('PaymentController@destroyProof', array('id' => $id, 'proofId' => $proof->id))}}" method="post">
              {{csrf_field()}}
              <input name="_method" type="hidden" value="DELETE">
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
        </div>
      </div>
      <div>Document Type: <b>{{ $proof->documentType->name }}</b></div>
      <div class="mt-2">
          <img src="{{ asset('/storage/' . $proof->attachment ) }}" class="img-fluid">
      </div>
    </div>
</div>
@endsection