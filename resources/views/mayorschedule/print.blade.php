@extends('layouts.report')

@section('content')
<div class="container">
    <h1 class="text-center mt-5">Mayor's Schedule</h1>

    <table class="table mt-5">
      <thead class="thead">
        <tr>
          <th scope="col">Schedule</th>
          <th scope="col">Name</th>
          <th scope="col">Location</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($schedules as $schedule)
        <tr>
          <td>{{ date('M d, Y H:i', strtotime($schedule->schedule)) }}</td>
          <td>{{$schedule->name}}</td>
          <td>{{$schedule->location}}</td>
          <td>{{$schedule->getStatus()}}</td>
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