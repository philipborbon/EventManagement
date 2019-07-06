@extends('layouts.app')

@section('content')
<div class="container">
        <h1>My Rented Spaces</h1>

        @if (Session::has('message'))
          <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
        </div>
        @endif
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Space ID</th>
              <th scope="col">Date</th>
              <th scope="col">Space</th>
              <th scope="col">Area</th>
              <th scope="col">Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <th scope="row">{{$payment->rentalSpace->id}}</th>
              <td>{{$payment->created_at->format('M d, Y')}}</td>
              <td>{{$payment->rentalSpace->name}}</td>
              <td>{{$payment->rentalSpace->area}}</td>
              <td>Php {{ number_format($payment->amount, 2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection