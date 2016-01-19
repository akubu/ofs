<script type="application/javascript">

    $(document).ready(function(){

        $("#expected_dispatch_dt").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#expected_delivery_dt").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#edit_dc').click(function(){

            var expected_dispatch_dt = $('#expected_dispatch_dt').val();
            var expected_delivery_dt = $('#expected_delivery_dt').val();


            var dc_number = $('#dc_number').val();
            $.post('/dc/update', {dc_number : dc_number,  expected_delivery_dt : expected_delivery_dt, expected_dispatch_dt : expected_dispatch_dt}, function(data){

               if(data == 1)
               {
                   $('#edit_div').html("");
                   $.growl.notice({
                       message: 'DC Updated .',
                       size: 'large',
                       duration: 5000
                   });

               }else{
                   $.growl.error({
                       message: 'DC Cannot be updates.',
                       size: 'large',
                       duration: 5000
                   });
               }

            });
        });
    });

</script>



<div class="form-group">
    <table class="table table-bordered">
        <tr>
            <th>
                <center>Dc number</center>
            </th>
            <td id="" colspan="2">
                <input type="text" size="40" id="dc_number" value="{{ $dc['dc_number'] }}" placeholder="Enter DC number" readonly="true"/>
            </td>
            <td>
                <label for="sel1">Tracking status</label>
                <input class="form-group" type="text" value="{{ $dc['is_tracked'] }}" readonly="true"/>
            </td>
        </tr>


        <tr>
            <th>
                <center>Runner Assigned</center>
            </th>
            <td colspan="3">
                <input type="text" id="runner_assigned" size="40" placeholder="Runner Assigned" value="{{ $dc['runner_id'] }}" readonly="true"/>
            </td>
        </tr>

        <tr>
            <th>
                <center>Driver Name</center>
            </th>
            <td>
                <input type="text" size="40" id="driver_name" placeholder="Enter Driver Name" value="{{ $dc['driver_id'] }}" readonly="true"/>
            </td>

            <th>
                <center>Driver Contact Number</center>
            </th>
            <td>
                <input type="text" size="40" id="driver_contact_number" value="{{ $dc['driver_contact_number'] }}" placeholder="Enter Driver Contact Number" readonly="true" />
            </td>
        </tr>
        <tr>
            <th>
                <center>Truck Number</center>
            </th>
            <td>
                <input type="text" size="40" id="truck_number" value="{{ $dc['truck_number'] }}" placeholder="Enter Truck Number" readonly="true" />
            </td>
            <th>
                <center>Truck Type</center>
            </th>
            <td>
                <input type="text" size="40" id="truck_type" value="{{ $dc['truck_type'] }}" placeholder="Enter Truck Type" readonly="true" />
            </td>
        </tr>
        <tr>
            <th style="background-color: #b2dba1">
                <center>
                    Expected dispatch Date
                </center>
            </th>
            <td style="background-color: #b2dba1">

                <input id="expected_dispatch_dt" size="40" value="{{ $dc['expected_dispatch_dt'] }}"  type="text" value="">


            </td>
            <th style="background-color: #b2dba1">
                <center>
                    Expected Delivery Date
                </center>
            </th>
            <td style="background-color: #b2dba1">
                <input id="expected_delivery_dt" type="datetime" size="40" value="{{ $dc['expected_delivery_dt'] }}"
                       placeholder="Select Expected Delivery Date"/>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <button class="btn btn-primary" id="edit_dc" > Update Dates</button>
            </td>
        </tr>
    </table>
</div>