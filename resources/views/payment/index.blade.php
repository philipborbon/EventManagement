@extends('layouts.app')

@section('content')
<div class="container">
        @if (Session::has('message'))
          <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
        </div>
        @endif
        <div class="m-1 text-right"><a href="{{action('PaymentController@create')}}" class="btn btn-primary">Add Payment</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Rental Space</th>
              <th scope="col">Amount</th>
              <th scope="col">Verified</th>
              <th scope="col">From Reservation</th>
              <th scope="col" colspan="3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <th scope="row">{{$payment->id}}</th>
              <td>{{$payment->user->getFullname()}}</td>
              <td>{{$payment->rentalSpace->name}}</td>
              <td>Php {{ number_format($payment->amount, 2) }}</td>
              <td>{{$payment->verified ? 'Yes' : 'No'}}</td>
              <td>{{$payment->reservationid ? 'Yes' : 'No'}}</td>
              <td>
                <a href="{{action('PaymentController@edit', $payment['id'])}}" class="btn btn-warning">Edit</a> 
              </td>
              <td><a href="{{action('PaymentController@proof', $payment['id'])}}" class="btn btn-primary">POP</a></td>
              <td>
                <form action="{{action('PaymentController@destroy', $payment['id'])}}" method="post">
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