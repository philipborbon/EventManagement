@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mayor's Schedule</h1>

    @if (Session::has('message'))
      <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
    @endif
    @if (Session::has('success'))
    <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
    </div>
    @endif
    @if (Auth::user()->usertype == 'admin')
    <div class="m-1 text-right"><a href="{{action('MayorScheduleController@create')}}" class="btn btn-primary">Add Mayor's Schedule</a></div>
    @endif

    <form method="GET" action="{{ action('MayorScheduleController@index') }}">
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
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Location</th>
          <th scope="col">Schedule</th>
          <th scope="col">Status</th>
          @if (Auth::user()->usertype == 'admin')
          <th scope="col" colspan="2">Action</th>
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach($schedules as $schedule)
        <tr>
          <th scope="row">{{$schedule->id}}</th>
          <td>{{$schedule->name}}</td>
          <td>{{$schedule->location}}</td>
          <td>{{ date('M d, Y H:i', strtotime($schedule->schedule)) }}</td>
          <td>{{$schedule->getStatus()}}</td>
          @if (Auth::user()->usertype == 'admin')
          <td><a href="{{action('MayorScheduleController@edit', $schedule['id'])}}" class="btn btn-warning">Edit</a></td>
          <td>
            <form action="{{action('MayorScheduleController@destroy', $schedule['id'])}}" method="post">
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