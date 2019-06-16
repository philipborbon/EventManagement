@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Account</h1>

  @if (Session::has('success'))
  <div class="alert alert-success">
      <p>{{ Session::get('success') }}</p>
  </div><br />
  @endif

    <div class="mb-1">
        <a href="{{action('AccountController@edit', $user['id'])}}" class="btn btn-primary">Edit</a>

        @if ( $user->usertype != 'admin' )
        <a href="{{action('UserIdentificationController@index')}}" class="btn btn-primary">Update Identifications</a>
        @endif
    </div>

    <div class="row mt-4">
        <div class="col">
            <div>
                <label for="firstname" class="control-label">Name</label>
                <div>{{ $user->firstname }} {{ $user->lastname }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div>
                <label>E-Mail Address</label>
                <div>{{ $user->email }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div>
                <label>User Type</label>
                <div>{{ config('enums.usertype')[$user->usertype] }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <label for="address" class="control-label">Address</label>
            <div>
                @if ( $user->address )
                {{ $user->address }}
                @else
                --
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-2">
            <div>
                <label for="age" class="control-label">Age</label>
                <div>
                    @if ($user->age)
                    {{ $user->age }}
                    @else
                    --
                    @endif
                </div>
            </div>
        </div>

        <div class="col-2">
            <div>
                <label for="sex" class="control-label">Sex</label>
                <div>
                    @if ( array_key_exists($user->sex, config('enums.sex')) )
                    {{ config('enums.sex')[$user->sex] }}
                    @else
                    --
                    @endif
                </div>
            </div>
        </div>

        <div class="col-2">
            <div>
                <label for="maritalstatus" class="control-label">Marital Status</label>
                <div>
                    @if ( array_key_exists($user->maritalstatus, config('enums.maritalstatus')) )
                    {{ config('enums.maritalstatus')[$user->maritalstatus] }}
                    @else
                    --
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
