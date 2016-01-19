
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 100%;
        }
    </style>


<div id="map"></div>
<script>

    // This example displays a marker at the center of Australia.
    // When the user clicks the marker, an info window opens.

    function initMap() {
        var uluru = {lat: {{ $response['current_lat'] }}, lng: {{ $response['current_long'] }} };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: uluru
        });

        var contentString = '<div id="content">'+
                '<div id="siteNotice">'+
                '</div>'+
                '<h1 id="firstHeading" class="firstHeading">Current Location:</h1>'+
                '<div id="bodyContent">'+
                '<p><b>{{ $response['current_address'] }}</b></p>'+
                '</div>'+
                '</div>';

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
            title: 'Device Location'
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXxkYt5TxoLuIxJZSDjSd0v--rrbC-b3s&signed_in=true&callback=initMap"></script>
