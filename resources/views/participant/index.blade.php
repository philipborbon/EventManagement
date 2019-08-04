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
    
    @if ($errors->has('userid'))
      <div class="alert alert-warning">
          <p>{{ $errors->first('userid') }}</strong>
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
                                @php
                                $contains = $activity->participants->contains('userid', $user->id);

                                $accepted = $activity->participants->contains(function($value) use ($user)
                                {
                                    if($value->userid == $user->id && $value->accepted == 1){
                                        return true;
                                    }
                                });

                                $denied = $activity->participants->contains(function($value) use ($user)
                                {
                                    if($value->userid == $user->id && $value->denied == 1){
                                        return true;
                                    }
                                });
                                @endphp

                                @if ($accepted == 0 && $denied == 0 && $contains)
                                <span class="font-weight-bold text-warning">Registration Pending.</span>
                                @endif

                                @if ($accepted == 1 && $denied == 0 && $contains)
                                <span class="font-weight-bold text-success">Registration Accepted.</span>
                                @endif

                                @if ($accepted == 0 && $denied == 1 && $contains)
                                <span class="font-weight-bold text-danger">Registration Denied.</span>
                                @endif
                                <span>

                                @if (!$contains)
                                <form method="POST" action="{{ url(sprintf("activities/%d/participants", $activity->id)) }}">
                                    {{ csrf_field() }}

                                    <input name="userid" type="hidden" value="{{ $user->id }}">
                                    <input name="activityid" type="hidden" value="{{ $activity->id }}">
                                    <button class="btn btn-primary" type="submit">Register</button>
                                </form>
                                @endif
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