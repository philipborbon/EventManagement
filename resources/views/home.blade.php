@extends('layouts.home')

@section('content')
<div class="container">
    <div class="row mt-3">
        <div class="col-md-10 offset-md-1">
            <div id="notification-box"></div>
            <div class="card">
                <div class="card-header">Dashboard</div>

                <ul class="list-group list-group-flush">
                @foreach($links as $group)
                    <li class="list-group-item">
                    @foreach($group as $key => $value)
                    <a href="{{ $value }}" class="btn btn-primary m-2 p-2 pl-3 pr-3">{{ $key }}</a>
                    @endforeach
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    function getNotification(){
        $.ajax({
            url: '/notifications/onhold',
            success: function(data){
                $('#notification-box').html('');

                $.each(data, function(index, value){
                    var notification = $('<div class="alert alert-warning" role="alert"/>')
                        .html('Space ' + value.rental_space.name + ' has been reserved and is on hold.');

                    $('#notification-box').append(notification);
                });
            }
        });
    }

    getNotification();

    setInterval(function(){ 
        getNotification();
    }, 10000);
</script>
@endsection
