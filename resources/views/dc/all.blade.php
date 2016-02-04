<script type="application/javascript">


    @if( !count($response))
        $(function(){
                $.growl.error({
                    message: 'No DC registered Yet,. ',
                    size: 'large',
                    duration: 10000
                });
                $('#allocate_device').hide();
            });
    $('#info_status').html('<center><h2 style="color:#0AB2F1; margin-top:30px;">NO DC Registered yet</h2></center>');
            @endif


                var options = {
        valueNames: [ 'name', 'born' ]
    };

    var userList = new List('users', options);

    $(document).ready(function(){


        $('.track_runner_button').click(function(){
//            alert('sdfsdf');
            var link = $(this).attr('target');

            var dc_number = $(this).attr('dc_number')

            $('#info').html('current location of ' + dc_number  )

            $.get(link, function(data){
//                alert(data);
//                $('#map_view').html(data);
                $('#map_frame').attr('src', link);

            });
        });
    });



</script>

<style>

  
   
    .sort {
        padding:6px 25px;
        border-radius: 5px;
        border:1px solid #28a8e0;       
        color:#28a8e0;
		vertical-align: sub;
    }
  
   
    .sort:after {
        display:inline-block;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid transparent;
        content:"";
        position: relative;
        top:-10px;
        right:-5px;
    }
    .sort.asc:after {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #fff;
        content:"";
        position: relative;
        top:4px;
        right:-5px;
    }
    .sort.desc:after {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #fff;
        content:"";
        position: relative;
        top:-4px;
        right:-5px;
    }



</style>


<h3 align="center"> All Undelivered DC in System </h3>
<div id="info_status">
<div >
    <div id="users">
    
    
    <div class="table_titles filter_bar">

			<div class="container-fluid">
				
				<div class="row">
					
					<div class="col-md-6 text-left">
						<input class="form-control search" placeholder="Search" />
					</div>

					<div class="col-md-6 text-right">
						<span class="sort" data-sort="name">
            Sort by Dc Number <i class="fa fa-sort-amount-desc"></i>
        </span>
					</div>

				</div>

			</div>

		</div>
    
    <div class="row">
 
   
    <div class="col-md-12">&nbsp;</div>
	</div>
     <div style="overflow-y: scroll; height:200px;">
        <table class="table table-striped">
            <tbody class="list">



            <tr>
                <th>
                    DC Number
                </th>
                <th>
                    Expected Dispatch Date
                </th>
                <th>
                    Expected Delivery Date
                </th>
                <th>
                    Customer
                </th>

                <th>
                    Tracking
                </th>
                <th>
                    Runner Alloted
                </th>

            </tr>
            @foreach($response as $element)
                <tr>
                    <td class="name">
                        {{ $element['dc_info']['dc_number'] }}
                    </td>
                    <td class="born">
                        {{ $element['dc_info']['expected_dispatch_dt'] }}
                    </td>
                    <td class="born">
                        {{ $element['dc_info']['expected_delivery_dt'] }}
                    </td>
                    <td>
                        {{ $element['so_info']['ship_to_name'] }}
                    </td>
                    <td>
                            @if(  $element['device_gsm_number']  != 0 )

                                <button class="track_runner_button" dc_number=" {{ $element['dc_info']['dc_number'] }}" target="/track/currentDeviceLocation?gsm_number={{ $element['device_gsm_number'] }}" class="btn btn-primary">Track</button>
                        @elseif( $element['dc_info']['is_tracked']  == 0)

                                This DC is not tracked
                        @else
                                Tracking not started yet
                        @endif

                    </td>
                    <td>
                        {{ $element['dc_info']['runner_id'] }}
                    </td>

                </tr>

            @endforeach
            </tbody>
        </table>
     </div>
    </div>
    <script src="http://listjs.com/no-cdn/list.js"></script>


</div>


<p><h3 id="info"></h3></p>
<br>

<div id="map_view" width="80%">
    <iframe id="map_frame" src="" width="80%" height="400px" frameborder="0"></iframe>
</div>
</div>
