@extends('layouts.app')

@section('content')
<div class="container">
        <h1>Proof Of Payment Of {{ $payment->user->getFullname() }} For {{ $payment->rentalSpace->name }}</h1>
        @if (Session::has('message'))
          <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
        </div>
        @endif

        <div class="m-1 text-right"><a href="{{action('PaymentController@createProof', $id)}}" class="btn btn-primary">Add Proof Of Payment</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Document Type</th>
              <th scope="col">Attachment</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($proofs as $proof)
            <tr>
              <th scope="row">{{ $proof->id }}</th>
              <td>{{ $proof->documentType->name }}</td>
              <td>
                <div style="width: 200px; height: 100px; overflow: hidden;">
                  <img src="{{ asset('/storage/' . $proof->attachment ) }}" class="img-fluid">
                </div>
              </td>
              <td>
                  <a href="{{action('PaymentController@showProof', array('id' => $id, 'proofId' => $proof['id']))}}" class="btn btn-warning">View</a>
              </td>
              <td>
                <form action="{{action('PaymentController@destroyProof', array('id' => $id, 'proofId' => $proof['id']))}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection