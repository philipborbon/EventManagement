<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
</head>
<body>
<div id="app">
    @include('layouts.partials.nav')    

    <div class="container mt-3 mb-3">
        <a href="/">Home</a> >
        <?php $link = "" ?>
        @for($i = 1; $i <= count(Request::segments()); $i++)
            @if($i < count(Request::segments()) & $i > 0)

            <?php $link .= "/" . Request::segment($i); ?>
            <?php 
                $text = ucwords(str_replace('-',' ',Request::segment($i)));
                if (is_numeric($text)) { continue; }
            ?>
            <a href="<?= $link ?>">{{ $text }}</a> >
            @else {{ucwords(str_replace('-',' ',Request::segment($i)))}}
            @endif
        @endfor
	</div>

    @yield('content')
</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    @yield('scripts')

</body>
</html>
