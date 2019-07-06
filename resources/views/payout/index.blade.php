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
        <div class="m-1 text-right"><a href="{{action('MonthlyPayoutController@create')}}" class="btn btn-primary">Create Payout</a></div>
        @endif

        <table class="table">
          <thead class="thead-dark">
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="col">Name</th>
              @endif

              <th scope="col">Payout</th>
              <th scope="col">Actual Payout</th>
              <th scope="col">Date Available</th>
              <th scope="col">Date Collected</th>

              @if ($user->usertype == 'admin')
              <th scope="col" colspan="2">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($payouts as $payout)
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="row">{{$payout->user->getFullname()}}</th>
              @endif

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
            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection