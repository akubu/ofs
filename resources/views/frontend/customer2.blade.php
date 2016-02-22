





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>	<meta name="author" content="Tom Horn"/> 	<meta name="keywords" content="Development,Google,Maps,Patrick O'Brian,World War Two"/>







  <script src="http://maps.google.com/maps?file=api&amp;v=2.208&amp;key=ABQIAAAAgb5KEVTm54vkPcAkU9xOvBR30EG5jFWfUzfYJTWEkWk2p04CHxTGDNV791-cU95kOnweeZ0SsURYSA" type="text/javascript"></script>




  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.3.2/mootools-yui-compressed.js"></script>








</head>










<script src="http://www.google.com/uds/api?file=uds.js&v=1.0&key=ABQIAAAAgb5KEVTm54vkPcAkU9xOvBR30EG5jFWfUzfYJTWEkWk2p04CHxTGDNV791-cU95kOnweeZ0SsURYSA" type="text/javascript"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="json2.js"></script>
<script type="text/javascript" src="https://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.3"></script>

<script type="text/javascript" srcX="http://localhost:8000/mapJs"></script>

<script>

  var geocoder;
  var map;

  var marker;

  var a1 = {{ $startLat }};
  var a2 = {{ $startLong }};


  var b1 = {{ $currentLat }};
  var b2 = {{ $currentLong }};


  var c1 = {{ $endLat }};
  var c2 = {{ $endLong }};

  function initialize()
  {
    var latlng = new google.maps.LatLng(a1, a2);
    var myOptions = {
      zoom: 9,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN
    };
    map = new google.maps.Map(document.getElementById("map"), myOptions);

    var rendererOptions = { map: map };
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

    var point1 = new google.maps.LatLng(b1,b2);


    var wps = [{ location: point1 }];

    var org = new google.maps.LatLng ( a1,a2);
    var dest = new google.maps.LatLng ( c1,c2);

    var request = {
      origin: org,
      destination: dest,
      waypoints: wps,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
    };

    directionsService = new google.maps.DirectionsService();
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
      else
        alert ('failed to get directions');
    });
  }

</script>



<body onload="initialize();" >





<div id="map" style="float: left; background: #F3EBA6; height:400px; width: 780px;" class="map"></div>


</body>

</html>
