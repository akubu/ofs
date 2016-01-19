<script type="application/javascript">
    $.(document).ready(function(){

    $("#deliverydate").datepicker({
        dateFormat: "yy-mm-dd"
    });

        $('#mark_delivered').click(function () {

            var date =$("#deliverydate").val();

            $.post("/dc/markDelivered", {dc_number : {{ $dc_number }} , date : date }, function(data, status){

                if(result == 1){
                    $.growl.notice({
                        message: ' Delivery of {{ $dc_number }} recorded.',
                        size: 'large',
                        duration: 5000
                    });

                }else {
                    $.growl.error({
                        message: ' Something went wrong , check date or contact support.',
                        size: 'large',
                        duration: 5000
                    });

                }


            });

        });

    });



</script>

<div class="row">
    <center>
    <table class="table table-bordered" >
        <tr>
            <td colspan="2">
                <h3>
                    Delivered DC {{ $dc_number }}
                </h3>
            </td>
        </tr>
        <tr>
        <th>
            Delivered on
        </th>
        <th>
            <input id="deliverydate" type="datetime" size="40"
                   placeholder="Select Expected Delivery Date"/>
        </td>
        </th>
        </tr>
        <tr>
            <th colspan="2">
                <button class="btn btn-primary" id="mark_delivered"> Mark Delivered</button>
            </th>
        </tr>
        </table>
        </center>
</div>