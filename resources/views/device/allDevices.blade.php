<script type="application/javascript">

    @if( !count($devices))
    $(function(){
                $.growl.error({
                    message: 'No Devices Registered in system. ',
                    size: 'large',
                    duration: 10000
                });
                $('#allocate_device').hide();
            });
    $('#info_status').html('<center><h2 style="color:#0AB2F1; margin-top:30px;">No Devices Registered in system.</h2></center>');
            @endif



        var options = {
        valueNames: [ 'name', 'born' ]
    };

    var userList = new List('users', options);
    $(document).ready(function(){
        $('.track_runner_button').click(function(){
//            alert('sdfsdf');
            var link = $(this).attr('target');
            var device_id = $(this).attr('device_id');
            $('#info').html("current location of device : " + device_id)
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


<h3 align="center"> All Devices in System </h3>

<div id="info_status">
    <div id="users">
    
     <div class="table_titles filter_bar">

			<div class="container-fluid">
				
				<div class="row">
					
					<div class="col-md-6 text-left">
						<input class="form-control search" placeholder="Search" />
					</div>

					<div class="col-md-6 text-right">
						<span class="sort" data-sort="name">
            Sort by Device ID <i class="fa fa-sort-amount-desc"></i>
        </span>
					</div>

				</div>

			</div>

		</div>
    <div class="row">
 
   
    <div class="col-md-12">&nbsp;</div>
	</div>
        
        
        
        <div height="200px" style="overflow-y: scroll; height:200px;">
        <table class="table table-striped">
            <tbody class="list">




        @foreach($devices as $device)
            <tr>
                <td class="name">
                    {{ $device['device_id'] }}
                </td>
                <td class="born">
                    {{ $device['device_model'] }}
                </td>
                <td>
                    {{ $device['device_type'] }}
                </td>
                <td>
                    {{ $device['gsm_number'] }}
                </td>
                <td>
                    {{ $device['runner_id'] }}
                </td>
                <td>
                    <button device_id="{{ $device['device_id'] }}" target="/track/currentDeviceLocation?gsm_number={{ $device['gsm_number'] }}" class="btn btn-primary btn-sm  track_runner_button">Track</button>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
            </div>
</div>
    <script src="http://listjs.com/no-cdn/list.js"></script>



<br>
<hr>
<p><h3 id="info"></h3></p>
<br>

<div id="map_view" width="80%">
    <iframe id="map_frame" src="" width="80%" height="400px" frameborder="0"></iframe>
</div>

        </div>