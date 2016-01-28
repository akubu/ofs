<script type="application/javascript">
    $(document).ready(function () {


        $("#deliverydate").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#mark_delivered').click(function () {

            var date = $("#deliverydate").val();

            if(date.length < 3)
            {
                $.growl.error({
                    message: 'Please select a date first.',
                    size: 'large',
                    duration: 5000
                });
                return false;
            }


            var dc_number = $.trim($('#dcNumberSelect').val());


            $.post("/dc/markDelivered", {dc_number : dc_number, date : date}, function (data, status) {

                if (data == 1) {
                    $.growl.notice({
                        message: 'DC Marked as Delivered.',
                        size: 'large',
                        duration: 5000
                    });

                    $.get("/dc/markDeliveredSelection", function (data, status) {

                        $('#body_div').html(data);


                    });
                    return false;


                } else {
                    $.growl.error({
                        message: 'DC Cannot be Marked As Delivered .',
                        size: 'large',
                        duration: 5000
                    });
                }
            });

        });

    });


</script>
<div id="info_status">
    <div class="row">
        <center>
            <table class="table table-bordered">
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
                               placeholder="Select Expected Delivery Date" readonly="readonly"/>
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
</div>