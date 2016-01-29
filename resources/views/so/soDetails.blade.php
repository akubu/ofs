<script type="application/javascript">
    $(document).ready(function () {
        $('#register_new_dc').click(function () {

            var so_number = $.trim($('#so_number').val().toUpperCase()).replace("+","");


            $.post("dc/newDC", {so_number: so_number}, function (result) {

                $('#new_dc_form').html(result);

                $('#register_new_dc').html(' Reset DC form ');

            });
        });
    });


</script>

<hr/>
<div class="row">
<div class="col-sm-2" align="right">
    <h4>SO Number : </h4>
</div>
<div class="col-sm-3" align="left">
    <h4><p id="so_number">{{ $so_details['so_number'] }}</p></h4>
</div>
    <div class="col-sm-7 " align="left">
        <h4>{{ $so_details['customer_name'] }}</h4>
    </div>

</div>



<div id="so_item_table" class="row">
    <div class="col-sm-12">
        <table border="0" cellpadding="2" class="table table-bordered">

            <tr>
                <th>S.No.</th>
                <th>Material</th>

                <th>Quantity</th>
                <th>Dispatched</th>
            </tr>

            @foreach($details as $detail)

                <tr>
                    <td>
                        {{ $detail['count'] }}
                    </td>
                    <td title="{{ $detail['sku'] }}">
                        {{ $detail['description'] }}
                    </td>

                    <td>
                        {{ $detail['quantity'] }}
                        &nbsp;
                        {{ $detail['units'] }}

                    </td>
                    <td>
                        {{ $detail['shipped'] }}
                        &nbsp;
                        {{ $detail['units'] }}
                    </td>

                </tr>

            @endforeach
        </table>
    </div>

    <div class="row">
        <div class="col-sm-12 align-right">
            <button type="button" class="btn btn-primary" id="register_new_dc">Register New DC</button>


        </div>
    </div>

    <div id="new_dc_form">



    </div>


</div>


