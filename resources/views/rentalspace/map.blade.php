@extends('layouts.jquery')

@section('content')

<div class="container">
<h1>Update Rental Space</h1>
    <div>
      <form method="POST" action="{{ action('RentalSpaceController@updateMap', $id) }}">
      {{ csrf_field() }}

      <input name="_method" type="hidden" value="PATCH">

      <div class="row">
        <div class="col-6">
          <div class="form-group{{ $errors->has('area') ? ' has-error' : '' }}">
              <label for="area" class="control-label">Area (sq. m)</label>

              <input id="area" type="number" step="0.01" min="0" class="form-control" name="area" value="{{ $space->area }}" required autofocus>

              @if ($errors->has('area'))
                  <span class="help-block">
                      <strong>{{ $errors->first('area') }}</strong>
                  </span>
              @endif
          </div>
        </div>
        <div class="col-6">
            <div class="row"><div class="col-12">Legend:</div></div>
            <div class="row mt-2">
                <div class="col-3"><div class="p-2 text-center" style="background-color: #0D47A1; color:white;">Available</div></div>
                <div class="col-3"><div class="p-2 text-center" style="background-color: #E65100; color:white;">Reserved</div></div>
                <div class="col-3"><div class="p-2 text-center" style="background-color: #B71C1C; color:white;">Rented</div></div>
                <div class="col-3"><div class="p-2 text-center" style="background-color: #CE93D8;">Area Type</div></div>
            </div>
            <div class="row mt-2">
                <div class="col-3"><div class="p-2 text-center" style="background-color: #AFB42B;">On Edit</div></div>
            </div>
        </div>
      </div>

      <input id="vertices" type="hidden" name="vertices">

      <div class="form-group">
          <input class="btn btn-warning" type="button" id="resetPolygon" value="Reset" />
          <button type="submit" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>

    <div id="map" class="mb-5" style="width:100%; height: 500px;"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY', '')}}&libraries=drawing,geometry"></script>
    <script>
    var otherSpaces = {!! json_encode($otherSpaces) !!};
    var space = {!! json_encode($space) !!};
    var coordinates = {!! json_encode($areas) !!};
    var types = {!! json_encode($types) !!};

    function getPolygons(){
        var polygons = [];

        $.each(otherSpaces, function(i, space){
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

    function getTypePolygons(){
        var polygons = [];

        $.each(types, function(i, type){
            var coordinates = [];
            $.each(type.coordinates, function(j, coordinate){
                coordinates.push({lat: coordinate.latitude, lng: coordinate.longitude});
            });

            polygons.push({
                type: type,
                color: '#CE93D8',
                coordinates: coordinates
            });
        });

        return polygons;
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

    // This example requires the Drawing library. Include the libraries=drawing
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: coordinates.length > 0 ? coordinates[0] : {lat: 6.6250537, lng: 124.5975442},
          zoom: 18
        });

        var drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.POLYGON,
          drawingControl: false,
          drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['polygon']
          },
          polygonOptions: {
            fillColor: '#AFB42B',
            strokeColor: '#AFB42B',
            fillOpacity: 0.5,
            strokeWeight: 5,
            editable: false,
            zIndex: 1
          }
        });
        drawingManager.setMap(map);

        if (coordinates.length > 0) {
            var polygon = new google.maps.Polygon({
                paths: coordinates,
                fillColor: '#AFB42B',
                strokeColor: '#AFB42B',
                fillOpacity: 0.5,
                strokeWeight: 5,
                editable: false,
                zIndex: 1
            });
            polygon.setMap(map);

            setSelection(polygon);
        }

        $('#resetPolygon').click(function(){
          if (selectedShape) {
              selectedShape.setMap(null);
          }
          // drawingManager.setMap(null);

          drawingManager.setMap(map);
          drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
        });

        var selectedShape;

        // function clearSelection() {
        //     if (selectedShape) {
        //       selectedShape.setEditable(false);
        //       selectedShape = null;
        //     }
        // }

        function setSelection(shape) {
          // clearSelection();
          selectedShape = shape;
          //shape.setEditable(true);

          drawingManager.setDrawingMode(null);

          var area = google.maps.geometry.spherical.computeArea(shape.getPath());

          $('#vertices').val(shape.getPath().getArray());
          $('#area').val(area.toFixed(2));
        }

        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
            if (e.type != google.maps.drawing.OverlayType.MARKER) {
              // Add an event listener that selects the newly-drawn shape when the user
              // mouses down on it.
              var newShape = e.overlay;
              newShape.type = e.type;
              google.maps.event.addListener(newShape, 'click', function() {
                setSelection(newShape);
              });
              setSelection(newShape);
            }
        });

        var polygons = getPolygons();
        var typePolygons = getTypePolygons();
        
        var infowindow = new google.maps.InfoWindow();

        $.each(typePolygons, function(index, value){
            var polygon = new google.maps.Polygon({
                paths: value.coordinates,
                fillColor: value.color,
                strokeColor: value.color,
                fillOpacity: 0.5,
                strokeWeight: 0,
                editable: false,
                zIndex: 1
            });
            polygon.setMap(map);

            google.maps.event.addListener(polygon, 'click', function(event) {
                var type = value.type;
                var contentString = '<div>' +
                    '<h5>' + type.name + ' Section</h5>' +
                    '</div>'
                ;

                infowindow.setContent(contentString);
                infowindow.setPosition(value.coordinates[0]);
                infowindow.open(map);
            });
        });

        $.each(polygons, function(index, value){
            var polygon = new google.maps.Polygon({
                paths: value.coordinates,
                fillColor: value.color,
                strokeColor: value.color,
                fillOpacity: 0.5,
                strokeWeight: 0,
                editable: false,
                zIndex: 1
            });
            polygon.setMap(map);

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
    </script>
</div>
@endsection
