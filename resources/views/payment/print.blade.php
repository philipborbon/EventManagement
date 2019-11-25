@extends('layouts.report')

@section('content')
<div class="container">
  <h1 class="text-center mt-5">Payments</h1>

  <table class="table mt-5">
    <thead class="thead">
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Rental Space</th>
        <th scope="col">Date</th>
        <th scope="col">Amount</th>
        <th scope="col">Verified</th>
        <th scope="col">From Reservation</th>
      </tr>
    </thead>
    <tbody>
      @foreach($payments as $payment)
      <tr>
        <td>{{$payment->user->getFullname()}}</td>
        <td>{{$payment->rentalSpace->name}}</td>
        <td>{{$payment->created_at->format('M d, Y')}}</td>
        <td>Php {{ number_format($payment->amount, 2) }}</td>
        <td>{{$payment->verified ? 'Yes' : 'No'}}</td>
        <td>{{$payment->reservationid ? 'Yes' : 'No'}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  window.print();
</script>
@endsection