<?php



namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
//use Illuminate\runner;





?>


var geocoder;
var map;

var marker;

function initialize()
{
var latlng = new google.maps.LatLng(-33.897, 150.099);
var myOptions = {
zoom: 9,
center: latlng,
mapTypeId: google.maps.MapTypeId.TERRAIN
};
map = new google.maps.Map(document.getElementById("map"), myOptions);

var rendererOptions = { map: map };
directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

var point1 = new google.maps.LatLng(-33.8975098545041,151.09962701797485);


var wps = [{ location: point1 }];

var org = new google.maps.LatLng ( -33.89192157947345,151.13604068756104);
var dest = new google.maps.LatLng ( -33.69727974097957,150.29047966003418);

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
