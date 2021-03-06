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
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Date</th>
              <th scope="col">Renter</th>
              <th scope="col">Rental Space</th>
              <th scope="col">Amount</th>
              <th scope="col">Proof Of Payment</th>
              <th scope="col">Status</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reservations as $reservation)
            <tr>
              <th scope="row">{{$reservation->id}}</th>
              <td>{{$reservation->created_at->format('M d, Y')}}</td>
              <td>{{$reservation->user->getFullname()}}</td>
              <td>{{$reservation->rentalSpace->name}}</td>
              <td>Php {{ number_format($reservation->rentalSpace->amount, 2) }}</td>
              <td>
                  @if ($reservation->payment)
                      @php
                      $proof = $reservation->payment->proofs->first();
                      @endphp

                      @if ($proof)
                      <div style="width: 200px; height: 100px; overflow: hidden;">
                        <img src="{{ asset('/storage/' . $proof->attachment ) }}" class="img-fluid">
                      </div>
                      @endif
                  @else
                  --
                  @endif
              </td>
              <td>{{ config('enums.reservationstatus')[$reservation->status] }}</td>
              <td>
                @if ($reservation->status == 'onhold')
                <form action="{{action('ReservationController@waive', $reservation['id'])}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="PATCH">
                  <button class="btn btn-warning" type="submit">Waive</button>
                </form>
                @endif
              </td>
              <td>
                <form action="{{action('ReservationController@destroy', $reservation['id'])}}" method="post">
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