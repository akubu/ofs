<script type="application/javascript">

    $(document).ready(function () {

        @if( !count($device_ids))
        $(function(){
                    $.growl.error({
                        message: 'No Devices Vaccant, Please recover first. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
        });
        $('#info_status').html('<center><h3>No Devices Vaccant, Please recover or add Device first</h3></center>');
@endif

        $(function () {
            var availableTags = [
                @foreach( $device_ids as $device_id)

        "{{ $device_id }}",
                @endforeach
        ];
            $("#deviceToAllocate").autocomplete({
                source: availableTags
            });
        });


        $(function () {
            var availableTagsRunner = [
                @foreach( $runner_names as $runner_name)

        "{{ $runner_name }}",
                @endforeach
        ];
            $("#runnerId").autocomplete({
                source: availableTagsRunner
            });
        });





        $('#allocate_device').click(function () {



            var device_id = $('#deviceToAllocate').val();

            if (device_id && device_id.length > 11) {
                $.get("device/show/device" + device_id, function (result) {

                    if(result == 0){
                        $.growl.error({
                            message: 'Something went wrong. ',
                            size: 'large',
                            duration: 10000
                                });
                        return false;
                    }

                    $('#after_selection').html(device_id);
                    $('#device_info').html(result);

                    $('#runner_selection').show();


                });

            } else {
                $.growl.error({
                    message: 'Check Device ID. ',
                    size: 'large',
                    duration: 10000
                });
            }


        });


        $('#assign_device').click(function () {

            var runner = $('#runnerId').val();
            var device_id = $('#deviceToAllocate').val();


            if (runner.length > 3 && runner != 0 ) {

                $.post("device/allocate", {device_id : device_id, runner_id : runner}, function(result, status){

                    $.growl.notice({
                        message: 'Device Allocated to runner. ',
                        size: 'large',
                        duration: 10000
                    });

                    $('#runnerId').attr("readonly", "readonly");

                });

            } else {
                $.growl.error({
                    message: 'Cannot Allocate. Please check Information. ',
                    size: 'large',
                    duration: 10000
                });
            }

        });


    });


</script>




<h3 align="center"> Allocate a Device to Runner </h3>
<div id="info_status">

<div id="device_selector">


    <table class="table table-bordered">
        <tr>
            <th>
                Device ID :
            </th>
            <th>

                    <input class="form-control ui-autocomplete-input" id="deviceToAllocate" placeholder="Enter Device ID" >

            </th>
            <th>
                <button id="allocate_device" class="btn btn-primary">Allocate Device</button>
            </th>
        </tr>
    </table>


</div>
<center>
    <h3 id="after_selection">

    </h3>
</center>

<hr>


<div align="center" id="device_info">

</div>


<hr>


<div id="runner_selection" hidden>

    <table class="table-bordered table">
        <th>
            Runner ID
        </th>
        <th>
            <input type="text" class="form-control" id="runnerId" placeholder="Enter runner id">
        </th>
        <th>
            <button id="assign_device" class="btn btn-primary">Assign</button>
        </th>
    </table>

</div>
</div>