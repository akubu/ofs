<script type="application/javascript">

    $(document).ready(function(){


        @if( !count($devices))
     $(function(){
                    $.growl.error({
                        message: 'No Devices Allocated to Runners. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3>No Devices Allocated to Runners</h3></center>');
        @endif




           availableTags = [
            @foreach( $devices as $device)

    "{{ $device }}",
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



        $('#recover').click(function(){

            var device_id = $('#device_id').val();

            if($.inArray(device_id, availableTags) == -1)
            {

                $.growl.error({
                    message: 'Select Runner Number from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }

            if ( device_id.length >2)
            {

                $('#recover').addClass("hide");
                $('#recover').next().removeClass('hide');
                $.post("/device/recover", { device_id : device_id}, function(result) {

                   if(result == 1)
                   {
                       $.growl.notice({
                           message: ' device added to pool.',
                           size: 'large',
                           duration: 10000
                       });

                       $.get("/device/recover", function (data, status) {
                           if(data.auth_required == true)
                           {
                               window.location = "/auth/login";
                               return false;
                           }
                           $('#body_div').html(data);
                       });

                   }else{
                       $.growl.error({
                           message: 'Check device ID.',
                           size: 'large',
                           duration: 10000
                       });
                       $('#recover').removeClass("hide");
                       $('#recover').next().addClass('hide');
                   }

                });

            }else{
                $.growl.error({
                    message: 'Check device ID.',
                    size: 'large',
                    duration: 10000
                });
            }

        });

    });

</script>

<div id="info_status">

    <center><h3>Recover Device From a Runner</h3></center>

    <table class="table-bordered table">
        <tr>
            <th>
                Device ID
            </th>
            <th>
                <input class="form-control" type="text" name="device_id" id="device_id" placeholder="Enter Device ID"/>
            </th>
            <th>
                <button class="form-control btn-primary btn" id="recover" >Recover Device</button>
                <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>
            </th>
        </tr>
    </table>
</div>