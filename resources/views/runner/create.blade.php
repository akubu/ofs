<script type="application/javascript">
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }


    $(document).ready(function () {





        $('#add_runner').click(function () {

errorFlag =0;
            var runner_email = $('#runner_email').val();

            if (runner_email == '' || runner_email.length <3 ) {
                $('#runner_email').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_email').css('border-color', 'green');
            }
            var reports_to_email = $('#reports_to_mail').val();


            if (reports_to_email == '' || reports_to_email.length <3 ) {
                $('#reports_to_mail').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#reports_to_mail').css('border-color', 'green');
            }

           // var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
//            return pattern.test(emailAddress);

            if( !validateEmail(runner_email) || !validateEmail(reports_to_email)){
                $.growl.error({
                    message: 'Enter proper E-mail Address.',
                    size: 'large',
                    duration: 10000
                });
                $('#runner_email').css('border-color', 'red');


            }

            var runner_name = $('#runner_name').val();
            if (runner_name == '' || runner_name.length <2 ) {
                $('#runner_name').css('border-color', 'red');
                $('#runner_name_error').removeClass("hide");
                $('#runner_name_error').html("Please Enter Runner Name");
                ++errorFlag ;
            }
            else {
                $('#runner_name').css('border-color', 'green');
                $('#runner_name_error').addClass("hide");
                $('#runner_name_error').html("");
            }

            var vtiger_id = $('#runner_vtiger_id').val();

            if (vtiger_id == '' || vtiger_id.length <3 ) {
                $('#runner_vtiger_id').css('border-color', 'red');
                $('#runner_vtiger_id_error').removeClass("hide");
                $('#runner_vtiger_id_error').html("Please Enter Correct ID");
                ++errorFlag ;
            }
            else {
                $('#runner_vtiger_id').css('border-color', 'green');
                $('#runner_vtiger_id_error').addClass("hide");
                $('#runner_vtiger_id_error').html("");
            }

            var runner_address = $('#runner_address').val();
            if (runner_address == '' || runner_address.length <3 ) {
                $('#runner_address').css('border-color', 'red');
                $('#runner_address_error').removeClass("hide");
                $('#runner_address_error').html("Please Enter Correct Address");
                ++errorFlag ;
            }
            else {
                $('#runner_address').css('border-color', 'green');
                $('#runner_address_error').addClass("hide");
                $('#runner_address_error').html("Please Enter Correct Address");
            }


            var runner_station_address = $('#runner_station_address').val();

            if (runner_station_address == '' || runner_station_address.length <3 ) {
                $('#runner_station_address').css('border-color', 'red');
                $('#runner_station_address_error').removeClass("hide");
                $('#runner_station_address_error').html("Please Enter Correct Office Address");
                ++errorFlag ;
            }
            else {
                $('#runner_station_address').css('border-color', 'green');
                $('#runner_station_address_error').addClass("hide");
                $('#runner_station_address_error').html("");
            }


            var runner_contact_number_1 = $('#runner_contact_number_1').val();
            if (runner_contact_number_1 == '' || runner_contact_number_1.length <3 || runner_contact_number_1 < 7000000000) {
                $('#runner_contact_number_1').css('border-color', 'red');
                $('#runner_contact_number_1_error').removeClass("hide");
                $('#runner_contact_number_1_error').html("Please Enter Correct CUG Number");
                ++errorFlag ;
            }
            else {
                $('#runner_contact_number_1').css('border-color', 'green');
                $('#runner_contact_number_1_error').addClass("hide");
                $('#runner_contact_number_1_error').html("");
            }


            var runner_contact_number_2 = $('#runner_contact_number_2').val();

            var reports_to_name = $('#runner_reports_to').val();

            if (reports_to_name == '' || reports_to_name.length <3 ) {
                $('#runner_reports_to').css('border-color', 'red');
                $('#runner_reports_to_error').removeClass("hide");
                $('#runner_reports_to_error').html("Please Enter Reports to Name");
                ++errorFlag ;
            }
            else {
                $('#runner_reports_to').css('border-color', 'green');
                $('#runner_reports_to_error').addClass("hide");
                $('#runner_reports_to_error').html("");
            }


            if(errorFlag > 0){

                $.growl.error({
                    message: 'Please correct all fields marked in Red .',
                    size: 'large',
                    duration: 5000
                });

                return false;

            }




            if (runner_name.length > 2) {
                if (vtiger_id.length == 7) {
                    if (runner_address.length > 5) {
                        if ($.isNumeric(runner_contact_number_1) && runner_contact_number_1.length > 9) {
                            if ($.isNumeric(runner_contact_number_2) || runner_contact_number_2 == '') {
                                if (runner_email) {
                                    if (reports_to_name) {
                                        if (reports_to_email) {

                                            $('#add_runner').addClass("hide");
                                            $('#add_runner').next().removeClass('hide');

                                            $.post("runner/create", {
                                                runner_name: runner_name,
                                                vtiger_id: vtiger_id,
                                                runner_address: runner_address,
                                                runner_station_address: runner_station_address,
                                                runner_contact_number_1: runner_contact_number_1,
                                                runner_contact_number_2: runner_contact_number_2,
                                                runner_email: runner_email,
                                                reports_to_name: reports_to_name,
                                                reports_to_email: reports_to_email
                                            }, function (result) {

                                                if (result == 1) {


                                                    $.growl.notice({
                                                        message: 'Runner created.',
                                                        size: 'large',
                                                        duration: 10000
                                                    });

                                                 $('#create_runner').html('<center><h3>Runner "'+ runner_name + '" Created</h3></center>')

                                                    return false;

                                                }

                                                if (result == -1) {
                                                    $.growl.error({
                                                        message: 'Runner Aready present. To edit please use appropriate menu',
                                                        size: 'large',
                                                        duration: 10000
                                                    });  $('#add_runner').removeClass("hide");
                                                    $('#add_runner').next().addClass('hide');
                                                }
                                                else {
                                                    $.growl.error({
                                                        message: 'Incorrect information. Runner Cannot be created.',
                                                        size: 'large',
                                                        duration: 10000
                                                    });

                                                $('#add_runner').removeClass("hide");
                                                $('#add_runner').next().addClass('hide');

                                                }


                                            });

                                        } else {
                                            $.growl.error({
                                                message: 'Check Reports to E-Mail.',
                                                size: 'large',
                                                duration: 10000
                                            });
                                        }
                                    } else {
                                        $.growl.error({
                                            message: 'Check Reports to Name.',
                                            size: 'large',
                                            duration: 10000
                                        });
                                    }
                                } else {
                                    $.growl.error({
                                        message: 'Check Runner E-Mail.',
                                        size: 'large',
                                        duration: 10000
                                    });
                                }
                            } else {

                            }
                        } else {
                            $.growl.error({
                                message: 'Check Runner CUG Number .',
                                size: 'large',
                                duration: 10000
                            });
                        }
                    } else {
                        $.growl.error({
                            message: 'Check Runner Address.',
                            size: 'large',
                            duration: 10000
                        });
                    }
                } else {
                    $.growl.error({
                        message: 'Check vTiger ID.',
                        size: 'large',
                        duration: 10000
                    });
                }
            } else {
                $.growl.error({
                    message: 'Check Runner Name.',
                    size: 'large',
                    duration: 10000
                });

            }


        });
    });


</script>


<h3 align="center"> Enter Information of New Runner </h3>
<hr>
<div id="create_runner">
    <table class="table borderless">
        <tr>
            <th>
                <center> Runner Name
                    <Span class="danger">*</Span></center>
            </th>
            <th>
                <input class="form-control" type="text" id="runner_name" size="40" placeholder="Enter Runner Name"/>
                    <span class="help-block hide danger" id="runner_name_error"></span>
            </th>
            <th>
                <center>Runner VTiger id
                    <Span class="danger">*</Span></center>
            </th>
            <th>
                <input class="form-control" type="txt" id="runner_vtiger_id" size="40" placeholder="Enter vTiger ID">
                    <span class="help-block hide danger" id="runner_vtiger_id_error"></span>
            </th>
        </tr>

        <tr>
            <th>
                <center>Runner Address
                    <Span class="danger">*</Span>
            </th>
            <th>
                <input class="form-control" type="text" id="runner_address" size="40" placeholder="Enter Runner Address">
                    <span class="help-block hide danger" id="runner_address_error"></span>
            </th>
            <th>
                <center>Runner office address
                    <Span class="danger">*</Span></center>
            </th>
            <th>
                <input class="form-control" type="text" id="runner_station_address" size="40" placeholder="Enter Office Address">
                    <span class="help-block hide danger" id="runner_station_address_error"></span>
            </th>
        </tr>
        <tr>
            <th>
                <center>Runner CUG Contact Number
                    <Span class="danger">*</Span></center>
            </th>
            <th>
                <input class="form-control" type="text" id="runner_contact_number_1" size="40" placeholder="Enter CUG Number">
                    <span class="help-block hide danger" id="runner_contact_number_1_error"></span>
            </th>
            <th>
                <center>Runner's Alternate Contact Number

            </th>
            <th>
                <input class="form-control" type="text" id="runner_contact_number_2" size="40"
                               placeholder="Alternate Contact Number">

            </th>
        </tr>


        <tr>
            <th>
                <center>Runner Reports to
                    <Span class="danger">*</Span>
                    </center>
            </th>
            <th>
                <input class="form-control" type="text" id="runner_reports_to" size="40" placeholder="Runner Reports to">
                    <span class="help-block hide danger" id="runner_reports_to_error"></span>
            </th>
            <th>
                <center>Reports to E-Mail
                    <Span class="danger">*</Span>
                </center>
            </th>
            <th>
                <input class="form-control" type="email" id="reports_to_mail" size="40" placeholder="Reports to E-Mail Address">
                    <span class="help-block hide danger" id="reports_to_mail_error"></span>
            </th>
        </tr>
        <tr>
            <th>
                <center>Runner E-mail
                    <Span class="danger">*</Span>
                </center>

            </th>
            <th>
                <input class="form-control" type="text" id="runner_email" size="40" placeholder="Enter Runner's E-Mail Address">
                    <span class="help-block hide danger" id="runner_email_error"></span>
            </th>
            <th colspan="2"></th>
        </tr>


    </table>
    
    <div class="row">
    <div class="col-md-12">
    <div class="col-md-5"></div>
    	<div class="col-md-2">
    
                <button id="add_runner" class="btn btn-primary">Add Runner</button>
                <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>
        
        </div>
     <div class="col-md-5"></div>
    </div>
    </div>


</div>