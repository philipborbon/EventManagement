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

        @if ($user->usertype == 'admin')
        <div class="m-1 text-right"><a href="{{action('MonthlyPayoutController@create')}}" class="btn btn-primary">Generate Payslips</a></div>
        @endif

        <form method="GET" action="{{ action('MonthlyPayoutController@index') }}">
          <div class="form-group row">
              @if ($user->usertype == 'admin')
              <div class="col-lg-4">
                &nbsp;
                <input class="form-control" name="keyword" placeholder="Search..." type="text" value="{{$keyword}}">
              </div>
              @endif
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
                @if ($user->usertype == 'admin')
                <input class="btn btn-primary" type="submit" value="Search">
                @else
                <input class="btn btn-primary" type="submit" value="Go">
                @endif
              </div>
          </div>
        </form>

        <table class="table">
          <thead class="thead-dark">
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="col">Name</th>
              @endif

              <th scope="col">For Month Of</th>
              <th scope="col">Salary</th>
              <th scope="col">Salary After Deductions</th>
              <th scope="col">Date Available</th>
              <th scope="col">Date Collected</th>

              @if ($user->usertype == 'admin')
              <th scope="col" colspan="3">Action</th>
              @else
              <th scope="col" colspan="1">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($payouts as $payout)
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="row">{{$payout->user->getFullname()}}</th>
              @endif
              <td>{{$payout->month->format('F Y')}}</th>
              <td>Php {{number_format($payout->payout, 2)}}</td>
              <td>Php {{number_format($payout->actualpayout, 2)}}</td>
              <td>{{$payout->dateavailable->format('M d, Y')}}</td>
              <td>{{$payout->datecollected ? $payout->datecollected->format('M d, Y') : '--'}}</td>

              @if ($user->usertype == 'admin')
              <td><a href="{{action('MonthlyPayoutController@edit', $payout['id'])}}" class="btn btn-warning">View</a></td>
              <td>
                <form action="{{action('MonthlyPayoutController@destroy', $payout['id'])}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </td>
              @endif
              <td><a href="{{action('MonthlyPayoutController@print', $payout['id'])}}" class="btn btn-primary" target="_blank">Print</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection