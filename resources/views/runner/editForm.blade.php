<script type="application/javascript">

    $(document).ready(function () {


        $('#save_runner_info').click(function () {

            var runner_name = $('#runner_name').val();
            var vtiger_id = $('#runner_vtiger_id').val();
            var runner_address = $('#runner_address').val();
            var runner_station_address = $('#runner_station_address').val();
            var runner_contact_number_1 = $('#runner_number_1').val();
            var runner_contact_number_2 = $('#runner_number_2').val();
            var runner_email = $('#runner_email').val();
            var reports_to_name = $('#runner_reports_to').val();
            var reports_to_email = $('#reports_to_mail').val();


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



