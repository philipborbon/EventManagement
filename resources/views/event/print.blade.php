@extends('layouts.report')

@section('content')
<div class="container">
  <h1 class="text-center mt-5">Events</h1>

  <table class="table mt-5">
    <thead class="thead">
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Start</th>
        <th scope="col">End</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($events as $event)
      <tr>
        <td>{{$event->name}}</td>
        <td>{{$event->startdate->format('M d, Y')}}</td>
        <td>{{$event->enddate->format('M d, Y')}}</td>
        <td>{{$event->getStatus()}}</td>
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