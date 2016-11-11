@extends('layouts.app')

@section('content')
<style>
  #map {
    width: 100%;
    height: 580px;
    box-shadow: 5px 5px 5px #888;
 }
</style>
<div class="container">
  <div class="col-md-12">

    <div class="box box-default">

        <div class="box-body">

        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#home">Localización de Vehiculos</a></li>
          <li><a data-toggle="tab" href="#menu1">Enviar GPS</a></li>
          <li><a data-toggle="tab" href="#menu2">Reporte 2</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" class="tab-pane fade in active">
            {{-- <div class="jumbotron"> --}}
              <h2> Mapa</h2>
              <div id="map" width="100%" height="580px">

              </div>

            {{-- </div> --}}

          </div>
          <div id="menu1" class="tab-pane fade">
            <div class="jumbotron">
              <h2>Enviar datos GPS-GEOJSON</h2>

            </div>

          </div>
          <div id="menu2" class="tab-pane fade">
            <div class="jumbotron">
              <h2>Paso 3: Llenar formato</h2>

            </div>

          </div>
        </div>

      </div>

    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

   var map = L.map('map').setView([4.747221199999999, -75.91162889999998],12);
   L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
   attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
   maxZoom: 18
   }).addTo(map);

   L.control.scale().addTo(map);

   var markers = new L.layerGroup();

    // L.marker([4.772836568611501, -75.95535278320311]).addTo(map);

   function main() {

     $.getJSON("js/plugins/map.geojson",function(data){
         // add GeoJSON layer to the map once the file is loaded

            var _data = data['features'];
            markers.clearLayers();
            // console.log(_data[0].geometry.coordinates);
            for (var i = 0; i < _data.length; i++) {
                // console.log(_data);
                var marker = L.marker(_data[i].geometry.coordinates).addTo(map);
                marker.bindPopup("<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.</p><p>Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque.</p>", {
                    showOnMouseOver: true
                });

                markers.addLayer(marker);
            }

            // marker.addTo(map);



            map.addLayer(markers);


        // geojsonLayer = L.geoJson();
        // geojsonLayer.clearLayers();
        // geojsonLayer.addData(jdata);
        // geojsonLayer.addData(data);
        // geojsonLayer.addTo(map);

     });

   }

  //  map.eachLayer(function (layer) {
  //     map.removeLayer(layer);
  // });


  setInterval(main, 3000);
});
  // var mrk = new L.marker(marcadores).addTo(map);
  // // L.marker([40.66, -4.71],{draggable: false}).addTo(map);


  // codigo para GPS
  // initialize the map
  // var map = L.map('map').setView([4.747221199999999, -75.91162889999998], 13);
  //
  // // load a tile layer
  // L.tileLayer('http://tiles.mapc.org/basemap/{z}/{x}/{y}.png',
  //   {
  //     attribution: 'Tiles by <a href="http://mapc.org">MAPC</a>, Data by <a href="http://mass.gov/mgis">MassGIS</a>',
  //     maxZoom: 17,
  //     minZoom: 9
  //   }).addTo(map);

  // load GeoJSON from an external file
//  $.ajax({ type: "GET",
//           dataType: "json",
//           url : "https://things.ubidots.com/api/v1.6/variables/5801500576254235e1c09467",
//           headers: {
//              'X-Auth-Token' : 'JtJ0Cc3aOUe5T0dTa6B8avYmCR6R3B'
//          },
//          success: function(data){
//              console.log(data);
//           }
//  });
  // load GeoJSON from an external file

  // });

</script>
@endsection
