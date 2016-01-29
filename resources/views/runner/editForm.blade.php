<script type="application/javascript">

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }

    $(document).ready(function () {


        $('#save_runner_info').click(function () {


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
            if (runner_name == '' || runner_name.length <3 ) {
                $('#runner_name').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_name').css('border-color', 'green');
            }

            var vtiger_id = $('#runner_vtiger_id').val();

            if (vtiger_id == '' || vtiger_id.length <3 ) {
                $('#runner_vtiger_id').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_vtiger_id').css('border-color', 'green');
            }

            var runner_address = $('#runner_address').val();
            if (runner_address == '' || runner_address.length <3 ) {
                $('#runner_address').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_address').css('border-color', 'green');
            }


            var runner_station_address = $('#runner_station_address').val();

            if (runner_station_address == '' || runner_station_address.length <3 ) {
                $('#runner_station_address').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_station_address').css('border-color', 'green');
            }


            var runner_contact_number_1 = $('#runner_contact_number_1').val();
            if (runner_contact_number_1 == '' || runner_contact_number_1 <7000000000  ) {
                $('#runner_contact_number_1').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_contact_number_1').css('border-color', 'green');
            }


            var runner_contact_number_2 = $('#runner_contact_number_2').val();

            var reports_to_name = $('#runner_reports_to').val();

            if (reports_to_name == '' || reports_to_name.length < 3 ) {

                $('#runner_reports_to').css('border-color', 'red');
                ++errorFlag ;
            }
            else {
                $('#runner_reports_to').css('border-color', 'green');
            }


            if(errorFlag > 0){

                $.growl.error({
                    message: 'Please correct all fields marked in Red .',
                    size: 'large',
                    duration: 5000
                });

                return false;

            }





            $.post("runner/update", {
                runner_name: runner_name,
                vtiger_id: vtiger_id,
                runner_address: runner_address,
                runner_statioon_address: runner_station_address,
                runner_contact_number_1: runner_contact_number_1,
                runner_contact_number_2: runner_contact_number_2,
                runner_email: runner_email,
                reports_to_name: reports_to_name,
                reports_to_email: reports_to_email
            }, function (result) {

                $('#edit_form').html(result);

            });


        });


    });

</script>


<br><br>


<h3 align="center"> Edit Runner info</h3>

<table class="table table-bordered">
    <tr>
        <th>Runner Name</th>
        <th><input type="text" id="runner_name" value="{{ $runner['runner_name'] }}" readonly="readonly"/></th>
        <th>Runner VTiger id</th>
        <th><input type="txt" id="runner_vtiger_id" value="{{ $runner['vtiger_id'] }}" readonly="readonly"></th>
    </tr>

    <tr>
        <th>Runner Address</th>
        <th><input type="text" id="runner_address" value="{{ $runner['runner_address'] }}"></th>
        <th>Runner office address</th>
        <th><input type="text" id="runner_station_address" value="{{ $runner['runner_station_address'] }}"></th>
    </tr>
    <tr>
        <th>Runner Contact Number 2</th>
        <th><input type="text" id="runner_number_1" value="{{ $runner['runner_contact_number_1'] }}"></th>
        <th>Runner Contact Number 2</th>
        <th><input type="text" id="runner_number_2" value="{{ $runner['runner_contact_number_2'] }}"></th>
    </tr>
    <tr>
        <th>Runner E-mail</th>
        <th><input type="text" id="runner_email" value="{{ $runner['runner_email'] }}" size="29"></th>
        <th colspan="2"></th>
    </tr>


    <tr>
        <th>Runner Reports to</th>
        <th><input type="text" id="runner_reports_to" value="{{ $runner['reports_to_name'] }}"></th>
        <th>Runner Reports to E-Mail</th>
        <th><input type="email" id="reports_to_mail" value="{{ $runner['reports_to_email'] }}" size="30"></th>
    </tr>
    <tr>
        <td colspan="4">
            <button id="save_runner_info" class="btn btn-primary">Save Runner Info</button>
        </td>
    </tr>

</table>



