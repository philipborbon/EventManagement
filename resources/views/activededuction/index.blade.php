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

        @if ($user->usertype == 'admin')
        <div class="m-1 text-right"><a href="{{action('EmployeeActiveDeductionController@create')}}" class="btn btn-primary">Add Employee Deduction</a></div>
        @endif

        <table class="table">
          <thead class="thead-dark">
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="col">Name</th>
              @endif

              <th scope="col">Type</th>
              <th scope="col">Amount</th>

              @if ($user->usertype == 'admin')
              <th scope="col" colspan="2">Action</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($deductions as $deduction)
            <tr>
              @if ($user->usertype == 'admin')
              <th scope="row">{{$deduction->user->getFullname()}}</th>
              @endif

              <td>{{$deduction->type->name}}</td>
              <td>Php {{number_format($deduction->amount, 2)}}</td>

              @if ($user->usertype == 'admin')
              <td><a href="{{action('EmployeeActiveDeductionController@edit', $deduction['id'])}}" class="btn btn-warning">Edit</a></td>
              <td>
                <form action="{{action('EmployeeActiveDeductionController@destroy', $deduction['id'])}}" method="post">
                  {{csrf_field()}}
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
              </td>
              @endif

            </tr>
            @endforeach
          </tbody>
        </table>
</div>
@endsection