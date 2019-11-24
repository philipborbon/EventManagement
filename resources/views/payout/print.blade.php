@extends('layouts.report')

@section('content')
<div class="container mt-5">
  <h1 class="text-center">{{ $payout->dateavailable->format('F') }} Payslip</h1>

  <div class="row">
    <div class="mt-3 col-4">
      Employee Name
      <div><b>{{ $payout->user->getFullname() }}</b></div>
    </div>

    <div class="mt-3 col-4">
      Total Work Days
      <div><b>Unknown</b></div>
    </div>
  </div>

  <div class="mt-3">
    Date Collected
    <div><b>{{$payout->datecollected ? $payout->datecollected->format('M d, Y') : '--'}}</b></div>
  </div>

  <table class="table mt-3">
  <tr>
    <td>Salary</td>
    <td>Php {{number_format($payout->payout, 2)}}</td>
  </tr>  
  @foreach($payout->deductions as $deduction)
  <tr>
    <td>{{ $deduction->type->name }} Deduction</td>
    <td>Php {{number_format($deduction->amount, 2)}}</td>
  </tr>
  @endforeach
  <tr>
    <td><b>Salary After Deductions</b></td>
    <td><b>Php {{number_format($payout->actualpayout, 2)}}</b></td>
  </tr>  
  </table>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  window.print();
</script>
@endsection