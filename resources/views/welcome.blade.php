<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('layouts.partials.head')

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            body {
                background-color: #E3F2FD;
            }

            .links > a {
                color: #1976D2;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .links > a:hover,
            .links > a:visited,
            .links > a:link,
            .links > a:active {
                text-decoration: none;
            }   

            .title {
                font-size: 50px;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
            }
        </style>
    </head>
    <div id="app">
        @if (Route::has('login'))
            <div class="p-4 text-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif


        <div class="container mt-2 mb-2">
            <div class="row mb-2">
                <div class="col-md-8 offset-md-2 title text-center">Welcome To {{ env('APP_NAME') }}!</div>
            </div>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card mt-5">
                        <div class="card-header">Announcements</div>

                        @if (count($announcements))
                        <ul class="list-group list-group-flush">
                            @foreach($announcements as $announcement)
                            <li class="list-group-item">
                                <div class="font-weight-bold">{{ $announcement->headline }}</div>
                                <div>{{ $announcement->description }}</div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="card-body">There is no announcement for today.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
