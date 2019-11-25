@extends('layouts.report')

@section('content')
<div class="container">
  <h1 class="text-center mt-5">Activities</h1>

  <table class="table mt-5">
    <thead class="thead">
        <th scope="col">Event</th>
        <th scope="col">Activity</th>
        <th scope="col">Location</th>
        <th scope="col">Schedule</th>
      </tr>
    </thead>
    <tbody>
      @foreach($activities as $activity)
      <tr>
        <td>{{$activity->event->name}}</td>
        <td>{{$activity->name}}</td>
        <td>{{$activity->location}}</td>
        <td>{{ date('M d, Y H:i', strtotime($activity->schedule)) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  window.print();
</script>
@endsection