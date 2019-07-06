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

    <div class="row mb-3">
        <div class="col-12">
        <div id="notification-box"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
        <div class="card">
            <div class="card-header">Rent A Space</div>

            <ul id="space-container" class="list-group list-group-flush">
            </ul>
        </div>
        </div>
        <div class="col-9"><div id="map" style="width:100%; height: 100%; min-height: 450px;"></div></div>
    </div>
</div>

<div data-role="template" style="display: none;">
<li class="list-group-item">
    <div>
        <div class="card-title">
            <h5 data-role="name"></h5>
            <div class="card-text" data-role="location"></div>
        </div>
        <div class="mb-3">
            <div>Area: <span data-role="area"></span> sq. m</div>
            <div>Amount: Php <span data-role="amount"></span></div>
            <div>Status: <span data-role="status"></span></div>
        </div>
        <div>
            <a href="#" data-role="create" class="btn btn-primary m-1">Create Reservation</a>
            <a href="javascript:void(0);" data-role="show" class="btn btn-primary m-1">Show In Map</a>
        </div>
    </div>
</li>
</div>
@endsection

@section('scripts')

<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY', '')}}&libraries=drawing,geometry"></script>
<script>
    var spaces = {!! json_encode($spaces) !!};

    function getPolygons(){
        var polygons = [];

        $.each(spaces, function(i, space){
            var coordinates = [];
            $.each(space.coordinates, function(j, coordinate){
                coordinates.push({lat: coordinate.latitude, lng: coordinate.longitude});
            });

            var color = '#4CAF50';

            switch(space.status) {
                case 'available':
                    color = '#0D47A1';
                break;
                
                case 'reserved':
                    color = '#E65100';
                break;
                
                case 'rented':
                    color = '#B71C1C';
                break;
            }

            polygons.push({
                space: space,
                color: color,
                coordinates: coordinates
            });
        });

        return polygons;
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function createCard(space, polygon){
        var card = $($('[data-role="template"]').html());
        card.find('[data-role="name"]').html(space.name);
        card.find('[data-role="location"]').html(space.location);
        card.find('[data-role="area"]').html(numberWithCommas(space.area));
        card.find('[data-role="amount"]').html(formatMoney(space.amount));
        card.find('[data-role="status"]').html(space.status.capitalize());
        card.find('[data-role="create"]').attr('href', 'rentaspace/create?spaceid=' + space.id);
        card.find('[data-role="show"]').click(function(){
            google.maps.event.trigger(polygon, 'click');
            console.log('awesome');
        });

        if (space.status != 'available') {
            card.find('[data-role="create"]').remove();
        }

        return card;
    }

    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
      try {
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
      } catch (e) {
        console.log(e)
      }
    }

    String.prototype.capitalize = function() {
        return this.charAt(0).toUpperCase() + this.slice(1);
    }

    function initMap() {
        var polygons = getPolygons();

        var start = null;
        if ( polygons.length > 0 ){
            var first = polygons[0];

            if (first.length > 0) {
                start = first[0];
            }
        }
        
        var infowindow = new google.maps.InfoWindow();

        var map = new google.maps.Map(document.getElementById('map'), {
            center: start != null ? start : {lat: 6.6250537, lng: 124.5975442},
            zoom: 18
        });

        $.each(polygons, function(index, value){
            var polygon = new google.maps.Polygon({
                paths: value.coordinates,
                fillColor: value.color,
                strokeColor: value.color,
                fillOpacity: 0.5,
                strokeWeight: 2,
                editable: false,
                zIndex: 1
            });
            polygon.setMap(map);

            var card = createCard(value.space, polygon);

            $('#space-container').append(card);

            google.maps.event.addListener(polygon, 'click', function(event) {
                var space = value.space;
                var contentString = '<div>' +
                    '<h5>' + space.name + '</h5>' +
                    '<div>Area: ' + numberWithCommas(space.area) + ' sq. m</div>' +
                    '<div>Amount: Php ' + formatMoney(space.amount) + '</div>' + 
                    '<div>Status: ' + space.status.capitalize() + '</div>' +
                    '</div>'
                ;

                infowindow.setContent(contentString);
                infowindow.setPosition(value.coordinates[0]);
                infowindow.open(map);
            });
        });

        google.maps.event.addListener(map, 'click', function() {
            infowindow.close();
        });
    }

    google.maps.event.addDomListener(window, "load", initMap);

    function getNotification(){
        $.ajax({
            url: '/notifications/awarded/{{$user->id}}',
            success: function(data){
                $('#notification-box').html('');

                $.each(data, function(index, value){
                    var notification = $('<div class="alert alert-warning" role="alert"/>')
                        .html('You reservation for space ' + value.rental_space.name + ' has been validated.');

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
