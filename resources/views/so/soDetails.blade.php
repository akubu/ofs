<script type="application/javascript">
    $(document).ready(function () {

        var so_number = $.trim($('#so_number').val().toUpperCase()).replace("+","");

        $('#new_dc_form').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading DCs ... </center>');

        $.post("/dc/dcCreated", { so_number : so_number}, function (data, status) {



            $('#new_dc_form').html(data);
        });

        $('#register_new_dc').click(function () {

            $('#register_new_dc').addClass("hide");
            $('#register_new_dc').next().removeClass('hide');
            var dc_type = $.trim($('#dc_type').val().toUpperCase()).replace("+","");



        $.post("dc/newDC", {so_number: so_number,dc_type: dc_type}, function (result, status) {

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
						SO Number :<strong id="so_number"> {{ $so_details['so_number'] }} &nbsp;( <strong>{{ $so_details['customer_name'] }} )</strong></strong>

                        <select  id="dc_type" style="float: right;background-color: #e7e7e7" >
                            <option selected="selected" value="type1">Type1</option>
                            <option value="type2">Type2</option>
                            <option value="type3">Type3</option>
                        </select>

                    </div>

					<div class="col-md-3 ">
                        {{--<div class="col-md-2">--}}

                            <button style="float: right" type="button" class="btn btn-primary" id="register_new_dc">Create New DC</button>
                            <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>

                        {{--</div>--}}
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

                <th>Booked Quantity</th>
                <th>Dispatched Quantity</th>
                <th>Remaining Quantity</th>
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
                    <td>
                        {{ $detail['quantity'] - $detail['shipped'] }}
                        &nbsp;
                        {{ $detail['units'] }}
                    </td>

                </tr>

            @endforeach
        </table>
    </div>

    <div class="row">
    <div class="col-md-5"></div>

    </div>

    <div id="new_dc_form">



    </div>


</div>


