<script type="application/javascript">

</script>

<div class="table_titles filter_bar">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-6 text-left">
                SO Number :<strong id="so_number"> {{ $so_details['so_number'] }} &nbsp;( <strong>{{ $so_details['customer_name'] }} )</strong></strong>



            </div>

            <div class="col-md-3 ">
                {{--<div class="col-md-2">--}}

                {{--<button style="float: right" type="button" class="btn btn-primary" id="register_new_dc">Create New DC</button>--}}
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

 <strong style="text-align: center">SO has been closed</strong>

</div>


