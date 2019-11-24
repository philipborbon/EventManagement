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
        <div class="m-1 text-right"><a href="{{action('UserController@create')}}" class="btn btn-primary">Add User</a></div>
        <div>

          <form method="GET" action="{{ action('UserController@index') }}">
            <div class="form-group row">
                <div class="col-lg-6">
                  <input class="form-control" name="keyword" placeholder="Search..." type="text" value="{{$keyword}}">
                </div>
                <div class="col-lg-2">
                  <select id="usertype" class="form-control" name="usertype">
                    <option value="%" {{ $usertype == '%' ? 'selected' : '' }}>All User Type</option>

                    @foreach(config('enums.usertype') as $key => $value)
                      <option value="{{ $key }}" {{ $usertype == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-lg-4">
                  <input class="btn btn-primary" type="submit" value="Search">
                </div>
            </div>
          </form>

        </div>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">E-mail</th>
              <th scope="col">Name</th>
              <th scope="col">User Type</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <th scope="row">{{$user->id}}</th>
              <td>{{$user->email}}</td>
              <td>{{$user->getFullname()}}</td>
              <td>{{$user->getUserType()}}</td>
              <td><a href="{{action('UserController@edit', $user['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('UserController@destroy', $user['id'])}}" method="post">
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