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

            if(expected_delivery_dt < expected_dispatch_dt)
            {
                $.growl.error({
                    message: 'Delivery Date Cannot Be Less Then Dispatch Date.',
                    size: 'large',
                    duration: 5000
                });
                return false;
            }


            var dc_number = $('#dc_number').val();
            $('#edit_dc').addClass("hide");
            $('#edit_dc').next().removeClass('hide');
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
                   $('#edit_dc').addClass("hide");
                   $('#edit_dc').next().removeClass('hide');
               }

            });
        });
    });

</script>



<div class="form-group">
    <table class="table borderless">
        <tr>
            <th>
                <center>Dc number</center>
            </th>
            <td>
                <input type="text" class="form-control" size="40" id="dc_number" value="{{ $dc['dc_number'] }}" placeholder="Enter DC number" readonly/>
            </td>
            <th>
                <center>Tracking statu</center>
            </th>
            <td>
               <input class="form-control" type="text" value=" @if ( $dc['is_tracked'] == 1 ) Tracked @else Un-Tracked @endif" readonly/>
            </td>
        </tr>


        <tr>
            <th>
                <center>Runner Assigned</center>
            </th>
            <td colspan="3">
                <input type="text" class="form-control" id="runner_assigned" size="40" placeholder="Runner Assigned" value="{{ $dc['runner_id'] }}" readonly/>
            </td>
        </tr>

        <tr>
            <th>
                <center>Driver Name</center>
            </th>
            <td>
                <input type="text" class="form-control" size="40" id="driver_name" placeholder="Enter Driver Name" value="{{ $dc['driver_id'] }}" readonly/>
            </td>

            <th>
                <center>Driver Contact Number</center>
            </th>
            <td>
                <input type="text" class="form-control" size="40" id="driver_contact_number" value="{{ $dc['driver_contact_number'] }}" placeholder="Enter Driver Contact Number" readonly />
            </td>
        </tr>
        <tr>
            <th>
                <center>Truck Number</center>
            </th>
            <td>
                <input type="text" class="form-control" size="40" id="truck_number" value="{{ $dc['truck_number'] }}" placeholder="Enter Truck Number" readonly />
            </td>
            <th>
                <center>Truck Type</center>
            </th>
            <td>
                <input type="text" class="form-control" size="40" id="truck_type" value="{{ $dc['truck_type'] }}" placeholder="Enter Truck Type" readonly />
            </td>
        </tr>
        <tr>
            <th style="background-color: #ADD2E0">
                <center>
                    Expected dispatch Date
                </center>
            </th>
            <td style="background-color: #ADD2E0">

                <input class="form-control" id="expected_dispatch_dt" size="40" value="{{ $dc['expected_dispatch_dt'] }}"  type="text" value="" readonly="readonly">


            </td>
            <th style="background-color: #ADD2E0">
                <center>
                    Expected Delivery Date
                </center>
            </th>
            <td style="background-color: #ADD2E0">
                <input class="form-control" id="expected_delivery_dt" type="datetime" size="40" value="{{ $dc['expected_delivery_dt'] }}"
                       placeholder="Select Expected Delivery Date" readonly/>
            </td>
        </tr>
        
    </table>
    
		<div class="row">
        	<div class="col-md-5"></div>
            	<div class="col-md-2">
                <button class="btn btn-primary" id="edit_dc" > Update Dates</button>
                <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>
              </div>
            <div class="col-md-5"></div>
		</div>
</div>