@extends('layouts.report')

@section('content')
<div class="container">
    <h1 class="text-center mt-5">{{ $title }}</h1>

    <table class="table mt-5">
      <thead class="thead">
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

@section('scripts')
<script type="text/javascript">
  window.print();
</script>
@endsection