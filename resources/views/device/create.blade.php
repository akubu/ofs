<script type="application/javascript">
    $(document).ready(function () {

        $(function () {
            var availableTagsType = [
                "GSM",
            ];
            $("#type").autocomplete({
                source: function (request, response) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
                    response($.grep(availableTagsType, function (value) {
                        return matcher.test(value.toUpperCase());
                    }));
                },
            }).focus(function () {
                $(this).autocomplete("search", $("#type").val());
            });
        });


        $(function () {
            var availableTagsModel = [
                "Nokia 105",
                "Samsung 1200"
            ];
            $("#model").autocomplete({

                source: function (request, response) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
                    response($.grep(availableTagsModel, function (value) {
                        return matcher.test(value.toUpperCase());
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function () {
                $(this).autocomplete("search", $("#model").val());
            });
        });


        $('#add_device').click(function () {

            errorFlag = 0;

            var type = $('#type').val();
            if (type == '') {

                $('#type').css('border-color', 'red');
                $('#type_error').removeClass("hide");
                $('#type_error').html("Please Enter Device Type");
                ++errorFlag;
            }
            else {
                $('#type').css('border-color', 'green');
                $('#type_error').addClass("hide");
                $('#type_error').html("");
            }


            var model = $('#model').val();
            if (model == '') {

                $('#model').css('border-color', 'red');
                $('#model_error').removeClass("hide");
                $('#model_error').html("Please Enter Device Model");
                ++errorFlag;
            }
            else {
                $('#model').css('border-color', 'green');
                $('#model_error').addClass("hide");
                $('#model_error').html("");
            }


            var imei_number = $('#imei_number').val();
            if (imei_number == '' || imei_number < 999999999) {

                $('#imei_number').css('border-color', 'red');
                $('#imei_error').removeClass("hide");
                $('#imei_error').html("Please Enter Correct IMEI Number");
                ++errorFlag;
            }
            else {
                $('#imei_number').css('border-color', 'green');
                $('#imei_error').addClass("hide");
                $('#imei_error').html("");
            }

            var sim_number = $('#sim_number').val();
            if (sim_number == '' || sim_number < 9999999999) {

                $('#sim_number').css('border-color', 'red');
                $('#sim_error').removeClass("hide");
                $('#sim_error').html("Please Enter Correct SIM Number")
                ++errorFlag;
            }
            else {
                $('#sim_number').css('border-color', 'green');
                $('#sim_error').addClass("hide");
                $('#sim_error').html("")
            }


            var gsm_number = $('#gsm_number').val();
            if (gsm_number == '' || gsm_number < 7000000000 || gsm_number > 9999999999 || !$.isNumeric(gsm_number)) {

                $('#gsm_number').css('border-color', 'red');
                $('#gsm_error').removeClass("hide");
                $('#gsm_error').html("Please Enter Correct CUG Number")
                ++errorFlag;
            }
            else {
                $('#gsm_number').css('border-color', 'green');
                $('#gsm_error').addClass("hide");
                $('#gsm_error').html("")
            }


            var scm_id = $('#scm_id').val();

            if (errorFlag > 0) {

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


                $('#add_device').addClass("hide");
                $('#add_device').next().removeClass('hide');

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
                            if (data.auth_required == true) {
                                window.location = "/auth/login";
                                return false;
                            }
                            $('#body_div').html(data);
                        });

                        return false;


                    }

                    else {
                        $.growl.error({
                            message: 'Device cannot be added. Check information provided. Make sure the device is not already Registered ',
                            size: 'large',
                            duration: 10000
                        });
                        $('#add_device').removeClass("hide");
                        $('#add_device').next().addClass('hide');
                        $('#device_id').html(' ');
                    }

                });

            }

        });
    });


</script>


<h3 align="center"> Enter New Device information</h3>
<hr>

<div id="device_info">

    <table class="table borderless">
        <tr>
            <th>
                Device type
                <Span class="danger">*</Span>
            </th>
            <th>
                <input type="text" class="form-control" id="type" placeholder="Enter Device type">
                <span class="help-block hide danger" id="type_error"></span>
            </th>
            <th>
                Device model
                <Span class="danger">*</Span>
            </th>
            <th>
                <input type="text" class="form-control" id="model" placeholder="Enter Device Model">
                <span class="help-block hide danger" id="model_error"></span>
            </th>
        </tr>
        <tr>
            <th>
                IMEI Number :
                <Span class="danger">*</Span>
            </th>
            <th>
                <input type="text" class="form-control" id="imei_number" placeholder="Enter IMEI number">
                <span class="help-block hide danger" id="imei_error"></span>
            </th>
            <th>
                SIM Number
                <Span class="danger">*</Span>
            </th>
            <th>
                <input type="text" class="form-control" id="sim_number" placeholder="Enter SIM number">
                <span class="help-block hide danger" id="sim_error"></span>
            </th>
        </tr>

        <tr>
            <th>
                Gsm Number
                <Span class="danger">*</Span>
            </th>
            <th>
                <input type="text" class="form-control" id="gsm_number" placeholder="Enter GSM number">
                <span class="help-block hide danger" id="gsm_error"></span>
            </th>

            <th>
                SCM ID
            </th>
            <th><input type="text" class="form-control" id="scm_id" value=" {{ $vt_user }} " placeholder="Enter SCM id"
                       readonly="readonly"></th>
        </tr>


    </table>
    <div class="row">
        <div class="col-md-5"></div>
        <div class="col-md-2">
            <button id="add_device" class="btn btn-primary">Add device to system</button>
            <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif"/></div>
        </div>
        <div class="col-md-5"></div>
    </div>

</div>

<div align="center" id="device_id">

</div>