<script type="application/javascript">

    $(document).ready(function () {

        @if( !count($device_ids))
        $(function () {
                    $.growl.error({
                        message: 'No Devices Vacant, Please recover first. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h2 style="color:#0AB2F1; margin-top:30px;">No Devices Vaccant, Please recover or add Device first</h2></center>');
        @endif

         availableTags = [
            @foreach( $device_ids as $device_id)

        "{{ $device_id }}",
            @endforeach
        ];
        $(function () {


            $("#deviceToAllocate").autocomplete({
                source: function (request, response) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
                    response($.grep(availableTags, function (value) {
                        return matcher.test(value.toUpperCase());
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function () {
                $(this).autocomplete("search", $("#deviceToAllocate").val());
            });
        });


        availableTagsRunner = [
            @foreach( $runner_names as $runner_name)

    "{{ $runner_name }}",
            @endforeach
    ];

        $(function () {

            $("#runnerId").autocomplete({

                source: function (request, response) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
                    response($.grep(availableTagsRunner, function (value) {
                        return matcher.test(value.toUpperCase());
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function () {
                $(this).autocomplete("search", $("#runnerId").val());
            });
        });


        $('#allocate_device').click(function () {


            var device_id = $('#deviceToAllocate').val();


            if ($.inArray(device_id, availableTags) == -1) {

                $.growl.error({
                    message: 'Select Device from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }

            if (device_id && device_id.length > 11) {

                $('#allocate_device').addClass("hide");
                $('#allocate_device').next().removeClass('hide');

                $.get("device/show/" + device_id, function (result) {

                    if (result == 0) {
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

                    $('#allocate_device').removeClass("hide");
                    $('#allocate_device').next().addClass('hide');


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


            if (runner.length > 3 && runner != 0) {


                $('#assign_device').addClass("hide");
                $('#assign_device').next().removeClass('hide');

                $.post("device/allocate", {device_id: device_id, runner_id: runner}, function (result, status) {


                    if (result != 0) {
                        $.growl.notice({
                            message: 'Device Allocated to runner. ',
                            size: 'large',
                            duration: 10000
                        });

                        $('#assign_device').addClass("hide");
                        $('#assign_device').next().addClass('hide');

                        $('#runnerId').attr("readonly", "readonly");

                        $.get("/device/allocateForm", function (data, status) {
                            if (data.auth_required == true) {
                                window.location = "/auth/login";
                                return false;
                            }
                            $('#body_div').html(data);
                        });


                    }
                    else {


                    }
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


<h3 align="center"> Allocate Device to Runner </h3>
<div id="info_status">

    <div id="device_selector">

        <table class="table table-striped">
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th style="width: 146px;vertical-align: middle;">Device ID:<Span class="danger">*</Span></th>
                <th>

                    <input class="form-control ui-autocomplete-input" id="deviceToAllocate"
                           placeholder="Enter Device ID">

                </th>
                <th>
                    <button id="allocate_device" class="btn btn-primary btn-sm">Allocate Device</button>
                    <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif"/></div>
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
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


    <div id="runner_selection" hidden>
        <hr>
        <table class="table table-striped">
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th style="width: 146px;vertical-align: middle;">Runner ID:</th>
                <th>

                    <input type="text" class="form-control" id="runnerId" placeholder="Cick to select runner " readonly>

                </th>
                <th>
                    <button id="assign_device" class="btn btn-primary btn-sm">Assign</button>
                    <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif"/></div>
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </table>


    </div>
</div>

<!-- Modal -->
