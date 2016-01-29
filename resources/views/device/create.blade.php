<script type="application/javascript">
    $(document).ready(function () {

        $(function () {
            var availableTagsType = [
                "GSM",
            ];
            $("#type").autocomplete({
                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTagsType, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
            }).focus(function() {
                $(this).autocomplete("search",  $("#type").val());
            });
        });


        $(function () {
            var availableTagsModel = [
                "Nokia 105",
                "Samsung 1200"
            ];
            $("#model").autocomplete({

                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTagsModel, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search",  $("#model").val());
            });
        });



        $('#add_device').click(function () {

            errorFlag =0;

            var type = $('#type').val();
            if (type == '' || type.length < 3 ) {

                $('#type').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#type').css('border-color', 'green');
            }


            var model = $('#model').val();
            if (model == '' || model.length < 3 ) {

                $('#model').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#model').css('border-color', 'green');
            }



            var imei_number = $('#imei_number').val();
            if (model == '' || model < 9999999999 ) {

                $('#imei_number').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#imei_number').css('border-color', 'green');
            }

            var sim_number = $('#sim_number').val();
            if (sim_number == '' || sim_number < 9999999999 ) {

                $('#sim_number').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#sim_number').css('border-color', 'green');
            }


            var gsm_number = $('#gsm_number').val();
            if (gsm_number == '' || gsm_number < 7000000000 || gsm_number.length !=10 ) {

                $('#gsm_number').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#gsm_number').css('border-color', 'green');
            }



            var scm_id = $('#scm_id').val();

            if(errorFlag > 0){

                $.growl.error({
                    message: 'Please correct all fields marked in Red .',
                    size: 'large',
                    duration: 5000
                });

                return false;

            }





            if (!(type && model && imei_number && sim_number && gsm_number && scm_id )) {

                $.growl.error({
                    message: ' Fill all fields',
                    size: 'large',
                    duration: 10000
                });
                $('#device_id').html(' ');

            } else {


                if ($.isNumeric(imei_number) && imei_number.length > 10) {
                    if ($.isNumeric(sim_number) && sim_number.length > 10) {
                        if ($.isNumeric(gsm_number) && gsm_number.length > 9) {
                            if (true) {
                                $.post("device/add", {
                                    type: type,
                                    model: model,
                                    imei_number: imei_number,
                                    sim_number: sim_number,
                                    gsm_number: gsm_number,
                                    scm_id: scm_id,
                                    runner_id: "0"
                                }, function (result) {


                                    if (result > 0) {

                                        $.growl.notice({

                                            message: 'Device Added. with Device ID :  ' + result,
                                            size: 'large',
                                            duration: 10000
                                        });

                                        $('#device_id').html(' <h3 align="center"> New Device Id is : ' + result + '  </h3>');

                                        $.get("/device/add", function (data, status) {
                                            if(data.auth_required == true)
                                            {
                                                window.location = "/auth/login";
                                                return false;
                                            }
                                            $('#body_div').html(data);
                                        });

                                        return false;


                                    }

                                    else {
                                        $.growl.error({
                                            message: 'Device cannot be added. Check information provided. ',
                                            size: 'large',
                                            duration: 10000
                                        });
                                        $('#device_id').html(' ');
                                    }

                                });

                            } else {

                                $.growl.error({
                                    message: ' Please check Runner ID ',
                                    size: 'large',
                                    duration: 10000

                                });
                            }
                        } else {
                            $.growl.error({
                                message: ' Please check GSM NUmber ',
                                size: 'large',
                                duration: 10000
                            });
                        }
                    } else {
                        $.growl.error({
                            message: ' please check SIM number ',
                            size: 'large',
                            duration: 10000
                        });
                    }
                } else {
                    $.growl.error({
                        message: ' Please check IMEI Number ',
                        size: 'large',
                        duration: 10000
                    });
                }


            }

        });
    });


</script>


<h3 align="center"> Enter Device information</h3>

<div id="device_info">

    <table class="table table-bordered">
        <tr>
            <th>
                Device type
            </th>
            <th>
                <input type="text" class="form-control" id="type" placeholder="Enter Device type">
            </th>
            <th>
                Device model
            </th>
            <th>
                <input type="text" class="form-control" id="model" placeholder="Enter Device Model">
            </th>
        </tr>
        <tr>
            <th>
                IMEI Number :
            </th>
            <th>
                <input type="text" class="form-control" id="imei_number" placeholder="Enter IMEI number">
            </th>
            <th>
                SIM Number
            </th>
            <th>
                <input type="text" class="form-control" id="sim_number" placeholder="Enter SIM number">
            </th>
        </tr>

        <tr>
            <th>
                Gsm Number
            </th>
            <th>
                <input type="text" class="form-control" id="gsm_number" placeholder="Enter GSM number">
            </th>

            <th>
                SCM ID
            </th>
            <th><input type="text" class="form-control" id="scm_id" value=" {{ $vt_user }} " placeholder="Enter SCM id"
                       readonly="readonly"></th>
        </tr>



        <tr>
            <th colspan="4">
                <button id="add_device" class="btn btn-primary">Add device to system</button>
            </th>
        </tr>
    </table>

</div>

<div align="center" id="device_id">

</div>