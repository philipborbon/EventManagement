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


        <div class="container mt-5 mb-2">
            <div class="row mb-2">
                <div class="col-md-8 offset-md-2 title text-center">Welcome To {{ env('APP_NAME') }}!</div>
            </div>

            <div class="mt-5">
                @if (count($announcements))
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">Announcements</div>

                            <ul class="list-group list-group-flush">
                                @foreach($announcements as $announcement)
                                <li class="list-group-item">
                                    <div class="font-weight-bold">{{ $announcement->headline }}</div>
                                    <div>{{ $announcement->description }}</div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                @if (count($events))
                    @foreach($events as $event)
                    <div class="row mt-3">
                        <div class="col-md-8 offset-md-2">
                            <div class="card">
                                <div class="card-header">Activities For {{$event->name}}</div>

                                @if (count($event->activities))
                                <ul class="list-group list-group-flush">
                                    @foreach($event->activities as $activity)
                                    <li class="list-group-item">
                                        <div>{{ $activity->name }}</div>
                                        <div>{{ $activity->schedule->format('M d, Y | h:i A') }}</div>
                                        <div>{{ $activity->description }}</div>
                                    </li>
                                    @endforeach
                                </ul>
                                @else
                                <div class="card-body">No scheduled activities.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="row mt-3">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">Activities</div>
                            <div class="card-body">No scheduled activities.</div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
