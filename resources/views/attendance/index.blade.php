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
        <div class="m-1 text-right"><a href="{{action('AttendanceController@create')}}" class="btn btn-primary">Add Attendance</a></div>
        @endif

        <table class="table">
          <thead class="thead-dark">
            <tr>

              @if ($user->usertype == 'admin')
              <th scope="col">Name</th>
              @endif

              <th scope="col">Date</th>
              <th scope="col">Double Pay</th>
              <th scope="col">Status</th>

              @if ($user->usertype == 'admin')
              <th scope="col" colspan="2">Action</th>
              @endif

            </tr>
          </thead>
          <tbody>
            @foreach($attendances as $attendance)
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="row">{{$attendance->user->getFullname()}}</th>
              @endif

              <td>{{$attendance->date->format('M d, Y')}}</td>
              <td>{{$attendance->doublepay ? 'Yes' : 'No' }}</td>
              <td>{{$attendance->getStatus()}}</td>

              @if ($user->usertype == 'admin')
              <td><a href="{{action('AttendanceController@edit', $attendance['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('AttendanceController@destroy', $attendance['id'])}}" method="post">
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