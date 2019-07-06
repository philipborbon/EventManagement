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
      var coordinates = {!! json_encode($areas) !!};
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
            fillColor: '#C8E6C9',
            strokeColor: '#81C784',
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
                fillColor: '#C8E6C9',
                strokeColor: '#81C784',
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
      }

      google.maps.event.addDomListener(window, "load", initMap);
    </script>
</div>
@endsection
