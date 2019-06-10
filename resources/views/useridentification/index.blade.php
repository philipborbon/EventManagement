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

        @if ( $user->usertype != 'admin' )
        <div class="m-1 text-right"><a href="{{action('UserIdentificationController@create')}}" class="btn btn-primary">Add Identification</a></div>
        @endif

        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Document Type</th>
              <th scope="col">Attachment</th>
              <th scope="col">Verified</th>
              <th scope="col" colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($identifications as $identification)
            <tr>
              <th scope="row">{{ $identification->id }}</th>
              <td>{{ $identification->documentType->name }}</td>
              <td>
                <div style="width: 200px; height: 100px; overflow: hidden;">
                  <img src="{{ asset('/storage/' . $identification->attachment ) }}" class="img-fluid">
                </div>
              </td>
              <td>{{ $identification->verified ? 'Yes' : 'No' }}</td>
              <td>
                @if  ( $user->usertype == 'admin' )
                <div>
                  <form action="{{action('UserIdentificationController@verify', $identification['id'])}}" method="post">
                    {{csrf_field()}}
                    <input name="_method" type="hidden" value="PATCH">

                    @if ( $identification->verified )
                    <input type="hidden" name="verified" value="0">
                    <button class="btn btn-warning" type="submit">Undo Verification</button>
                    @else
                    <input type="hidden" name="verified" value="1">
                    <button class="btn btn-warning" type="submit">Verify</button>
                    @endif
                  </form>
                </div>

                <div class="mt-2">
                  <a href="{{action('UserIdentificationController@show', $identification['id'])}}" class="btn btn-warning">View</a>
                </div>
                @endif
              </td>
              <td>
                <form action="{{action('UserIdentificationController@destroy', $identification['id'])}}" method="post">
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