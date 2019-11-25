@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-8"><h1><h1>Events</h1></h1></div>
    <div class="col-4 text-right"><a href="{{action('EventController@print', ['keyword' => $keyword, 'start' => $start, 'end' => $end])}}" class="btn btn-primary" target="_blank">Print</a></div>
  </div>

  @if (Session::has('message'))
    <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
  @endif
  @if (Session::has('success'))
  <div class="alert alert-success">
    <p>{{ Session::get('success') }}</p>
  </div>
  @endif
  <div class="m-1 text-right"><a href="{{action('EventController@create')}}" class="btn btn-primary">Add Event</a></div>

  <form method="GET" action="{{ action('EventController@index') }}">
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
        <th scope="col">Start</th>
        <th scope="col">End</th>
        <th scope="col">Status</th>
        <th scope="col" colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($events as $event)
      <tr>
        <th scope="row">{{$event->id}}</th>
        <td>{{$event->name}}</td>
        <td>{{$event->startdate->format('M d, Y')}}</td>
        <td>{{$event->enddate->format('M d, Y')}}</td>
        <td>{{$event->getStatus()}}</td>
        <td><a href="{{action('EventController@edit', $event['id'])}}" class="btn btn-warning">Edit</a></td>
        <td>
          <form action="{{action('EventController@destroy', $event['id'])}}" method="post">
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