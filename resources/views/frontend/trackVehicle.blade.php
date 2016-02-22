<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<br><br>
<center>


<?php
	$ref = \Request::server('HTTP_REFERER') ;


	echo '<a href=" '. $ref. '" > <h4>Go Back </h4></a>';
	?>


 <iframe id="mapFrame" src="http://track.power2sme.com/createmap/{{ $startLat }}/{{ $startLong }}/{{ $currentLat }}/{{ $currentLong }}/{{ $endLat }}/{{ $endLong }}" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>


<div class="row margin-bottom-30" style=" background:#EEEEEE; margin-right: 0px;">

    <div class="col-sm-4">
        <div class="padding-30c">

            <h3>

                Order Requested from Location :


            </h3>
            <dl class="week-day ">

                
                <dd>{{ $start_address }}</dd>
            </dl>
        </div>

    </div>

    <div class="col-sm-4">

        <div class="padding-30c" style="background:#09B2F1; color:white;">
            <h3>

                Current Location of Order :

            </h3>
            <dl class="week-day ">

                <dd>{{ $current_address }}</dd>
            </dl>

        </div>

    </div>

    <div class="col-sm-4">
        <div class="padding-30c">
            <h3>

                Delivery Location :

            </h3>
            <dl class="week-day ">

                <dd>{{ $end_address }}</dd>
            </dl>

        </div>
    </div>

</div>





</center>


</body>
</html>