<script type="application/javascript">

    $(document).ready(function () {

        @if( !count($runner_names))
        $(function () {
                    $.growl.error({
                        message: 'No Runner registered in System . ',
                        size: 'large',
                        duration: 5000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h2 style="color:#0AB2F1; margin-top:30px;">No Runner registered in System .</h2></center>');
        @endif

         availableTags = [
            @foreach( $runner_names as $runner_name)

        "{{ $runner_name }}",
            @endforeach
        ];
        $(function () {


            $("#runner_id").autocomplete({
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


        @if( !count($dc_numbers))
        $(function () {
//                    $.growl.error({
//                        message: 'No un-assigned DC in system . ',
//                        size: 'large',
//                        duration: 10000
//                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h2 style="color:#0AB2F1; margin-top:30px;">No un-assigned DC in system .</h2></center>');
        @endif


       var availableTagsRunner = [
            @foreach( $dc_numbers as $dc_numbers)

    "{{ $dc_numbers }}",
            @endforeach
    ];

        $(function () {

            $("#dc_number").autocomplete({

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


            var device_id = $('#runner_id').val();


            if ($.inArray(device_id, availableTags) == -1) {

                $.growl.error({
                    message: 'Select valid Runner from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }else{

                $('#runner_id').prop('disabled', true);

                $('#runner_selection').show();

            }




        });


        $('#assign_DC').click(function () {

            var runner_id = $('#runner_id').val();


            var dc_number = $('#dc_number').val();

            if ( dc_number.length < 1)
            {
                $.growl.error({
                    message: 'No DC selected ',
                    size: 'large',
                    duration: 5000
                });
                return false;
            }



                if ($.inArray(dc_number, availableTagsRunner) == -1) {

                    $.growl.error({
                        message: ' Please select valid DC from dropdown. ',
                        size: 'large',
                        duration: 10000
                    });
                    return false;
                }


            $.post("/runner/assign_dc", {dc_number: dc_number, runner_id: runner_id}, function (result, status) {


                if (result != 0) {

                    $.growl.notice({
                        message: 'DC Allocated to Runner . ',
                        size: 'large',
                        duration: 5000
                    });

                    $.get("/runner/assignDC", function (data, status) {
                        if(data.auth_required == true)
                        {
                            window.location = "/auth/login";
                            return false;
                        }
                        $('#body_div').html(data);
                    });

                }
                else {

                    $.growl.error({
                        message: 'Cannot Allocate DC to Runner. ',
                        size: 'large',
                        duration: 10000
                    });


                }
            });

        });
    });


</script>


<h3 align="center"> Allocate DC to Runner </h3>
<div id="info_status">

    <div id="device_selector">

        <table class="table table-striped">
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th style="width: 146px;vertical-align: middle;"> Select Runner :<Span class="danger">*</Span></th>
                <th>

                    <input class="form-control ui-autocomplete-input" id="runner_id"
                           placeholder="select runner">

                </th>
                <th>
                    <button id="allocate_device" class="btn btn-primary btn-sm">Select DC</button>
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





    <div id="runner_selection" hidden>
        <hr>
        <table class="table table-striped">
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th style="width: 146px;vertical-align: middle;">Select DC to assign </th>
                <th>

                    <input type="text" class="form-control" id="dc_number" placeholder="Cick to select DC " >

                </th>
                <th>
                    <button id="assign_DC" class="btn btn-primary btn-sm">Assign DC</button>
                    <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif"/></div>
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </table>


    </div>
</div>

<!-- Modal -->
