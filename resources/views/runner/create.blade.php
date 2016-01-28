<script type="application/javascript">
    $(document).ready(function () {





        $('#add_runner').click(function () {


            var runner_email = $('#runner_email').val();
            var reports_to_email = $('#reports_to_mail').val();

           // var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
//            return pattern.test(emailAddress);

            {{--if((runner_email.indexOf( "@")) && (runner_email.indexOf( ".")) ){--}}
                {{--$.growl.error({--}}
                    {{--message: 'Enter proper E-mail Address.',--}}
                    {{--size: 'large',--}}
                    {{--duration: 10000--}}
                {{--});--}}
                {{--return false;--}}

            {{--}--}}

            {{--if((reports_to_email.indexOf( "@" )) && (reports_to_email.indexOf( "."))){--}}
                {{--$.growl.error({--}}
                    {{--message: 'Enter proper E-mail Address.',--}}
                    {{--size: 'large',--}}
                    {{--duration: 10000--}}
                {{--});--}}
                {{--return false;--}}

            {{--}--}}

            var runner_name = $('#runner_name').val();
            var vtiger_id = $('#runner_vtiger_id').val();
            var runner_address = $('#runner_address').val();
            var runner_station_address = $('#runner_station_address').val();
            var runner_contact_number_1 = $('#runner_contact_number_1').val();
            var runner_contact_number_2 = $('#runner_contact_number_2').val();

            var reports_to_name = $('#runner_reports_to').val();


            if (runner_name.length > 3) {
                if (vtiger_id.length == 7) {
                    if (runner_address.length > 5) {
                        if ($.isNumeric(runner_contact_number_1) && runner_contact_number_1.length > 9) {
                            if ($.isNumeric(runner_contact_number_2) && runner_contact_number_2 / length > 9) {
                                if (runner_email) {
                                    if (reports_to_name) {
                                        if (reports_to_email) {

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
                                                    });
                                                }
                                                else {
                                                    $.growl.error({
                                                        message: 'Incorrect information. Runner Cannot be created.',
                                                        size: 'large',
                                                        duration: 10000
                                                    });

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
                                $.growl.error({
                                    message: 'Check Runner CUG Number.',
                                    size: 'large',
                                    duration: 10000
                                });
                            }
                        } else {
                            $.growl.error({
                                message: 'Check Runner Number .',
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
    <table class="table table-bordered">
        <tr>
            <th>
                <center> Runner Name
            </th>
            <th>
                <center><input type="text" id="runner_name" size="40" placeholder="Enter Runner Name"/>
            </th>
            <th>
                <center>Runner VTiger id
            </th>
            <th>
                <center><input type="txt" id="runner_vtiger_id" size="40" placeholder="Enter vTiger ID">
            </th>
        </tr>

        <tr>
            <th>
                <center>Runner Address
            </th>
            <th>
                <center><input type="text" id="runner_address" size="40" placeholder="Enter Runner Address">
            </th>
            <th>
                <center>Runner office address
            </th>
            <th>
                <center><input type="text" id="runner_station_address" size="40" placeholder="Enter Office Address">
            </th>
        </tr>
        <tr>
            <th>
                <center>Runner CUG Contact Number 1
            </th>
            <th>
                <center><input type="text" id="runner_contact_number_1" size="40" placeholder="Enter CUG Number">
            </th>
            <th>
                <center>Runner Contact Number 2
            </th>
            <th>
                <center><input type="text" id="runner_contact_number_2" size="40"
                               placeholder="Alternate Contact Number">
            </th>
        </tr>


        <tr>
            <th>
                <center>Runner Reports to
            </th>
            <th>
                <center><input type="text" id="runner_reports_to" size="40" placeholder="Runner Reports to">
            </th>
            <th>
                <center>Reports to E-Mail
            </th>
            <th>
                <center><input type="email" id="reports_to_mail" size="40" placeholder="Reports to E-Mail Address">
            </th>
        </tr>
        <tr>
            <th>
                <center>Runner E-mail
            </th>
            <th>
                <center><input type="text" id="runner_email" size="40" placeholder="Enter Runner's E-Mail Address">
            </th>
            <th colspan="2"></th>
        </tr>

        <tr>
            <td colspan="4">
                <button id="add_runner" class="btn btn-primary">Add Runner</button>
            </td>
        </tr>

    </table>


</div>