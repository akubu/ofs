<script type="application/javascript">
    $(document).ready(function () {
        $('#register_new_dc').click(function () {

            $('#register_new_dc').addClass("hide");
            $('#register_new_dc').next().removeClass('hide');

            var so_number = $.trim($('#so_number').val().toUpperCase()).replace("+","");

        $.post("dc/newDC", {so_number: so_number}, function (result, status) {

                $('#new_dc_form').html(result);

                $('#register_new_dc').html(' Reset DC form ');

            $('#register_new_dc').removeClass("hide");
            $('#register_new_dc').next().addClass('hide');

            });
        });
    });


</script>

<div class="table_titles filter_bar">

			<div class="container-fluid">
				
				<div class="row">
					
					<div class="col-md-6 text-left">
						SO Number :<strong id="so_number"> {{ $so_details['so_number'] }}</strong>
					</div>

					<div class="col-md-6 text-left">
						<strong>{{ $so_details['customer_name'] }}</strong>
					</div>

				</div>

			</div>

		</div>

<div class="row">
<div class="col-md-12">
   &nbsp;
</div>
</div>



<div id="so_item_table" class="row">
    <div class="col-sm-12">
        <table class="table table-striped">

            <tr>
                <th>S.No.</th>
                <th>Material</th>

                <th>Quantity</th>
                <th>Dispatched</th>
            </tr>

            @foreach($details as $detail)

                <tr>
                    <td>
                        {{ $detail['count'] + 1 }}
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
    <div class="col-md-5"></div>
        <div class="col-md-2">
            <button type="button" class="btn btn-primary" id="register_new_dc">Register New DC</button>
            <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>

        </div>
    </div>

    <div id="new_dc_form">



    </div>


</div>


