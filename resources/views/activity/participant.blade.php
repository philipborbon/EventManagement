@extends('layouts.app')

@section('content')
<div class="container">
        <h1>{{ $activity->name }} Participants</h1>

        @if (Session::has('message'))
          <div class="alert alert-info"><p>{{ Session::get('message') }}</p></div>
        @endif
        @if (Session::has('success'))
        <div class="alert alert-success">
          <p>{{ Session::get('success') }}</p>
        </div>
        @endif
        <div class="m-1 text-right"><a href="{{action('ActivityController@createParticipant', $id)}}" class="btn btn-primary">Add Participant</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($participants as $participant)
            <tr>
              <th scope="row">{{$participant->id}}</th>
              <td>{{$participant->getFullname()}}</td>
              <td><a href="{{action('ActivityController@editParticipant', ['id' => $participant['activityid'], 'participantId' => $participant['id']])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('ActivityController@destroyParticipant', ['id' => $participant['activityid'], 'participantId' => $participant['id']])}}" method="post">
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