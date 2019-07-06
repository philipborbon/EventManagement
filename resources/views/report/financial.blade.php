@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $title }}</h1>

    @if (Session::has('message'))
      <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
    @endif
    @if (Session::has('success'))
    <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger">
      <p>{{ Session::get('error') }}</p>
    </div>
    @endif
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Payment ID</th>
          <th scope="col">Date</th>
          <th scope="col">From</th>
          <th scope="col">Space</th>
          <th scope="col">Amount</th>
        </tr>
      </thead>
      <tbody>
        @php 
          $total = 0;  
        @endphp
        @foreach($reports as $report)
        @php 
          $total += $report->amount;
        @endphp
        <tr>
          <th scope="row">{{$report->id}}</th>
          <td>{{$report->date}}</td>
          <td>{{$report->lastname . ', ' . $report->firstname}}</td>
          <td>{{$report->spacename}}</td>
          <td>Php {{number_format($report->amount, 2)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="h3"><span class="font-weight-bold">Total :</span> Php {{number_format($total, 2)}}</div>
</div>
@endsection