@extends('layouts.app')

@section('content')
        @if (Session::has('message'))
          <div class="alert alert-info">{{ Session::get('message') }}</div><br />
        @endif
        @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
        @endif
        <div><a href="{{action('DeductionTypeController@create')}}" class="btn btn-primary">Add New Type</a></div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($types as $type)
            <tr>
              <th scope="row">{{$type->id}}</th>
              <td>{{$type->name}}</td>
              <td>{{$type->description}}</td>
              <td><a href="{{action('DeductionTypeController@edit', $type['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('DeductionTypeController@destroy', $type['id'])}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
@endsection