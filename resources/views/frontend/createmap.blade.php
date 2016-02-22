<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="refresh" content="180">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>plotting whats provided </title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #map {
            height: 100%;
            float: left;
            width: 100%;
            height: 100%;
        }
        #right-panel {
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }

        #right-panel select, #right-panel input {
            font-size: 15px;
        }

        #right-panel select {
            width: 100%;
        }

        #right-panel i {
            font-size: 12px;
        }

        #right-panel {
            margin: 20px;
            border-width: 2px;
            width: 20%;
            float: left;
            text-align: left;
            padding-top: 20px;
        }
        #directions-panel {
            margin-top: 20px;
            background-color: #FFEE77;
            padding: 10px;
        }
    </style>
</head>
<body onload="initialize();">



<div id="map"  width="100%"></div>

<script>

    var geocoder;
    var map;

    var marker;



    function initialize()
    {
        var latlng = new google.maps.LatLng( {{ $startLat }}, {{ $startLong }} );
        var myOptions = {
            zoom: 9,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.TERRAIN
        };
        map = new google.maps.Map(document.getElementById("map"), myOptions);

        var rendererOptions = { map: map };
        directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

        directionsDisplay.setOptions( { suppressMarkers: true } );

        var point1 = new google.maps.LatLng({{ $currentLat }}, {{ $currentLong }});
        var org = new google.maps.LatLng ( {{ $startLat }}, {{ $startLong }} );
        var dest = new google.maps.LatLng ( {{ $endLat }} , {{ $endLong }}  );

        var wps = [{ location: point1,
            stopover: true

                    }];


        var request = {
            origin: org,
            destination: dest,
            waypoints: wps,
            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING

        };

        directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);

                google.maps.event.trigger(map, 'resize')
            }
            else
                alert ('failed to get directions');
        });

            var truckImage = '{{ $baseURL }}/ls/truck.png';
        var startImage = '{{ $baseURL }}/ls/warehouse.png';
        var endImage = '{{ $baseURL }}/ls/destination.png';


         var infoStart = "start location";
         var infoCurrent = "current location";
         var infoEnd = "end location";



        var contentStringCurrent = "Current position of truck";

        var contentStringDestination = "Delivery location of Shipment";

        var contentStringStart = "Start location of Shipment";




        var infowindowCurrent = new google.maps.InfoWindow({
            content: contentStringCurrent
        });
        var infowindowDestination = new google.maps.InfoWindow({
            content: contentStringDestination
        });
        var infowindowStart = new google.maps.InfoWindow({
            content: contentStringStart
        });






        var markerCurrent = new google.maps.Marker({
            position: point1,
            map: map,
            icon: truckImage,
            title: 'Current locations'

        });

        var markerDestination = new google.maps.Marker({
            position: dest,
            map: map,
            icon: endImage,
            title: 'Delivery location (approx. ) '

        });

        var markerStart = new google.maps.Marker({
            position: org,
            map: map,
            icon: startImage,
            title: 'Start locations'

        });


        markerCurrent.addListener('click', function() {
            infowindowCurrent.open(map, markerCurrent);
        });

        markerDestination.addListener('click', function() {
            infowindowDestination.open(map, markerDestination);
        });

        markerStart.addListener('click', function() {
            infowindowStart.open(map, markerStart);
        });




    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXxkYt5TxoLuIxJZSDjSd0v--rrbC-b3s&signed_in=true&callback=initMap" ></script>
</body>
</html>