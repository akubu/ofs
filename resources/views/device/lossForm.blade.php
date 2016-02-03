<script type="application/javascript">

    $(document).ready(function(){


        @if( !count($device_ids))
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



       availableTags = [
            @foreach( $device_ids as $device_id)

    "{{ $device_id }}",
            @endforeach
    ];

        $(function () {

            $("#device_id").autocomplete({
                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTags, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search",  $("#device_id").val());
            });
        });



        $('#register_loss').click(function(){

            var device_id = $('#device_id').val();
            if($.inArray(device_id, availableTags) == -1)
            {

                $.growl.error({
                    message: 'Select Device ID from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }
            var reason = $('#reason').val();

            if (device_id.length >2 && reason && reason.length > 10)
            {
                $.post("/device/loss", { device_id : device_id, reason : reason}, function(result) {

                    if(result == 1)
                    {
                        $.growl.notice({
                            message: ' device loss registered.',
                            size: 'large',
                            duration: 10000
                        });
                        $('#device_id').val("");
                        $('#reason').val("");

                    }else{
                        $.growl.error({
                            message: 'Check device ID.',
                            size: 'large',
                            duration: 10000
                        });

                    }

                });

            }else{
                $.growl.error({
                    message: 'Enter proper information.',
                    size: 'large',
                    duration: 10000
                });
            }

        });

    });

</script>
<center><h3>Register A Device Loss</h3></center>
<hr>
<div id="info_status">

    <table class="table borderless">
        <tr>
            <th style="width:200px;">
                Enter Device ID
            </th>
            <th>
                <div class="ui-widget">
                    <input type="text" class="form-control" id="device_id" placeholder="Enter Device ID">
                </div>
            </th>


            <tr>
            <th>
                 Reason
            </th>
            <th>
                <input type="text" id="reason" class="form-control" placeholder="Enter Reason for loss" size="150">
            </th>
            </tr>

        </tr>
       
    </table>
    
    <div class="row">
	<div class="col-md-5"></div>
    <div class="col-md-2">
    	<button  id="register_loss" class="btn btn-primary">Register Loss</button>
    </div>
    <div class="col-md-5"></div>
</div>

</div>