@extends('layouts.report')

@section('content')
<div class="container mt-5">
  <h1 class="text-center">{{ $activity->name }} Participants</h1>

  <table class="table mt-5">
    <thead class="thead">
      <tr>
        <th scope="col">Last Name</th>
        <th scope="col">First Name</th>
      </tr>
    </thead>
    <tbody>
      @foreach($participants as $participant)
      <tr>
        <td>{{$participant->user->lastname}}</td>
        <td>{{$participant->user->firstname}}</td>
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