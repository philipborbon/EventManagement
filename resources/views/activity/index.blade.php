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
        <div class="m-1 text-right"><a href="{{action('ActivityController@create')}}" class="btn btn-primary">Add Activity</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Event</th>
              <th scope="col">Name</th>
              <th scope="col">Location</th>
              <th scope="col">Schedule</th>
              <th scope="col" colspan="3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($activities as $activity)
            <tr>
              <th scope="row">{{$activity->id}}</th>
              <td>{{$activity->event->name}}</td>
              <td>{{$activity->name}}</td>
              <td>{{$activity->location}}</td>
              <td>{{ date('M d, Y H:i', strtotime($activity->schedule)) }}</td>
              <td><a href="{{action('ActivityController@edit', $activity['id'])}}" class="btn btn-warning">Edit</a></td>
              <td><a href="{{action('ActivityController@participants', $activity['id'])}}" class="btn btn-primary">Participants</a></td>
              <td>
                <form action="{{action('ActivityController@destroy', $activity['id'])}}" method="post">
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