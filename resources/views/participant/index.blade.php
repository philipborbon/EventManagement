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
    
    @if (count($events))
        @foreach($events as $event)
        <div class="row mt-3">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Activities For {{$event->name}}</div>

                    @if (count($event->activities))
                    <ul class="list-group list-group-flush">
                        @foreach($event->activities as $activity)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-8">
                                    <div>{{ $activity->name }}</div>
                                    <div class="font-italic">{{ $activity->location }}</div>
                                    <div>{{ $activity->schedule->format('M d, Y | h:i A') }}</div>
                                    <div>{{ $activity->description }}</div>
                                </div>
                                <div class="col-2">
                                    <form action="{{action('ParticipantController@register')}}" method="post">
                                      {{csrf_field()}}
                                      <input name="userid" type="hidden" value="{{ $user->id }}">
                                      <input name="activityid" type="hidden" value="{{ $activity->id }}">
                                      <button class="btn btn-primary" type="submit">Register</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="card-body">No scheduled activities.</div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    @else
    <div class="row mt-3">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Activities</div>
                <div class="card-body">No scheduled activities.</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection