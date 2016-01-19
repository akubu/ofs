
<style>
    pre.ui-coordinates {
        position: absolute;
        bottom: 10px;
        left: 10px;
        padding: 5px 10px;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        font-size: 11px;
        line-height: 18px;
        border-radius: 3px;
    }


</style>


<div width="30%" height="100%">
    <div id='map' height="300" width="300"></div>

    <div>
        <form action="registerAddress" method="post">

            <pre id='coordinates' class='ui-coordinates'>

                <div align="right">

                    <h3><font color="#a52a2a"> Choose a different address </font></h3>

                </div>p

            </pre>


            <input type="text" name="shipment_id" value="{{ $shipment_id }}" hidden />

            <input type="text"  name="runner_id" value="{{ $runner_id }}" hidden />

            <input type="text"  name="runner_id" value="{{ $vehicle_number }}" hidden />




            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="submit" value="select this as delivery location" name="submit">

        </form>


        <div align="right">

            <h3><font color="#a52a2a"> Choose a different address </font></h3>

        </div>
    </div>


    <script>
        L.mapbox.accessToken = 'pk.eyJ1IjoidHJhY2tpbmdzeXN0ZW0iLCJhIjoiY2lnaXYwcGIzMDAwZnR0bHVjZDBzaTIxdCJ9.aliNjFl4j53TSh88hLE-dQ';
        var map = L.mapbox.map('map', 'mapbox.streets')
                .setView([{{ $estimatedLat }}, {{ $estimatedLong }}], 11);

        var coordinates = document.getElementById('coordinates');

        var marker = L.marker([{{ $estimatedLat }}, {{ $estimatedLong }}], {
            icon: L.mapbox.marker.icon({
                'marker-color': '#f86767'
            }),
            draggable: true
        }).addTo(map);

        // every time the marker is dragged, update the coordinates container
        marker.on('dragend', ondragend);

        // Set the initial marker coordinate on load.
        ondragend();

        function ondragend() {
            var m = marker.getLatLng();

            address_string = '1600 Pennsylvania Avenue NW Washington, DC 20500';
//
//                    var geocoder = new google.maps.Geocoder;
//                    var latlng = {lat: m.lat, lng: m.lng};
//
//                    geocoder.geocode({'location': latlng}, function(results, status) {
//                        if (status === google.maps.GeocoderStatus.OK) {
//                            if (results[1]) {
//
//                                alert(results[1].formatted_address);
//
//                            } else {
//                                window.alert('No results found');
//                            }
//                        } else {
//                            window.alert('Geocoder failed due to: ' + status);
//                        }


            coordinates.innerHTML = '<input type="text" name="end_lat" value=" ' + m.lat + '" ><br><input type="text" name="end_long" value=" ' + m.lng + '" ><input type="submit" value="select" >';
        }
    </script>