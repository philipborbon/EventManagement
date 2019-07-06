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
        <div class="m-1 text-right"><a href="{{action('RentalSpaceController@create')}}" class="btn btn-primary">Add Rental Space</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Type</th>
              <th scope="col">Name</th>
              <th scope="col">Area Area (sq. m)</th>
              <th scope="col">Amount</th>
              <th scope="col">Status</th>
              <th scope="col" colspan="3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($spaces as $space)
            <tr>
              <th scope="row">{{$space->id}}</th>
              <td>{{$space->type->name}}</td>
              <td>{{$space->name}}</td>
              <td>{{$space->area}}</td>
              <td>{{$space->amount}}</td>
              <td>{{$space->getStatus()}}</td>
              <td><a href="{{action('RentalSpaceController@edit', $space['id'])}}" class="btn btn-warning">Edit</a></td>
              <td><a href="{{action('RentalSpaceController@spaceMap', $space['id'])}}" class="btn btn-primary">Edit Map</a></td>
              <td>
                <form action="{{action('RentalSpaceController@destroy', $space['id'])}}" method="post">
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

