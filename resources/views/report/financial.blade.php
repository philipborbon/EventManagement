@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-8"><h1>{{ $title }}</h1></div>
      <div class="col-4 text-right"><a href="{{action('ReportController@printFinancial', ['keyword' => $keyword, 'start' => $start, 'end' => $end])}}" class="btn btn-primary" target="_blank">Print</a></div>
    </div>

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

    <form method="GET" action="{{ action('ReportController@financial') }}">
      <div class="form-group row">
          <div class="col-lg-4">
            &nbsp;
            <input class="form-control" name="keyword" placeholder="Search..." type="text" value="{{$keyword}}">
          </div>
          <div class="col-lg-2">
            Start Date:
            <input type="date" name="start" value="{{$start}}" class="form-control">
          </div>
          <div class="col-lg-2">
            End Date:
            <input type="date" name="end" value="{{$end}}" class="form-control">
          </div>
          <div class="col-lg-4">
            <div>&nbsp;</div>
            <input class="btn btn-primary" type="submit" value="Search">
          </div>
      </div>
    </form>

    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Payment ID</th>
          <th scope="col">Date</th>
          <th scope="col">From</th>
          <th scope="col">Space</th>
          <th scope="col">Area</th>
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
          <td>{{$report->area}} sq. m</td>
          <td>Php {{number_format($report->amount, 2)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="h3"><span class="font-weight-bold">Total :</span> Php {{number_format($total, 2)}}</div>
</div>
@endsection