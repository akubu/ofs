<script type="application/javascript">
    $(document).ready(function () {



        $('#map_sellector').hide();
        $('#select_address').hide();
        $('#reason_row').hide();

        $("#expected_dispatch_date").datepicker({
            dateFormat: "yy-mm-dd"
        });
        $("#expected_delivery_date").datepicker({
            dateFormat: "yy-mm-dd"
        });


        @if( !count($runner_names))
         $(function () {
                    $.growl.error({
                        message: 'No Runner registered In System. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3 style="color:#0AB2F1; margin-top:30px;">Please add a runner first</h3></center>');
        @endif


 availableTags = [
            @foreach( $runner_names as $runner_name)

    "{{ $runner_name }}",
            @endforeach
    ];

        $(function () {

            $("#runner_assigned").autocomplete({
                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTags, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search", $('#runner_assigned').val());

            });
        });


        $('#select_address').click(function () {
            $('#map_sellector').hide();
            $('#select_address').hide();
            $('#locate_on_map').show();
            $('#address').attr('readonly', true)
            $('#locate_on_map').html('Change Address');
        });

        $('#generate_dc').click(function () {

            var so_number = $('#so_number').val();
            $.post('/dc/getDCNumber', {so_number: so_number}, function (data) {

                $('#dc_number').val(data);

            });

        });


        $('#locate_on_map').click(function () {
            $('#address').attr('readonly', false);
            $('#select_address').show();
            $('#locate_on_map').hide();
            $('#lat').val(28.6139391);
            $('#long').val(77.20902120000005);
            $('#map_sellector').show();
            $('#us3').locationpicker({
                location: {latitude: $('#lat').val(), longitude: $('#long').val()},
                radius: 100,
                inputBinding: {
                    latitudeInput: $('#lat'),
                    longitudeInput: $('#long'),
                    locationNameInput: $('#address')
                },
                enableAutocomplete: true,
                    enableReverseGeocode: true,
                onchanged: function (currentLocation, radius, isMarkerDropped) {
                    // Uncomment line below to show alert on each Location Changed event
                    //alert("Location changed. New location (" + currentLocation.latitude + ", " + currentLocation.longitude + ")");

                }
            });
        });

        $(function () {
            if ($('#lat').val() == 0 || $('#lat').val() == 0) {
                $('#locate_on_map').show();
                $('#select_address').show();
            }
            else {
                $('#locate_on_map').html('Change Address');
                $('#address').attr('readonly', true)
                $('#select_address').hide();
            }
        });



    $('#tracking_status').change(function () {

        var tracking_status = $('#tracking_status').val();
        if (tracking_status == 0) {
            $('#reason_row').show();
        } else {
            $('#reason_row').hide();
        }
    });

    $('#register_dc').click(function () {




        errorFlag = 0;

        var dc_number = $('#dc_number').val();

        if (dc_number == ''  ) {
            $('#dc_number').css('border-color', 'red');
            $('#dc_error').removeClass("hide");
            $('#dc_error').html("Please Generate A DC Number");

            ++errorFlag ;
        }
        else {
            $('#dc_number').css('border-color', 'green');
            $('#dc_error').addClass("hide");
            $('#dc_error').html("");
        }


        var runner_assigned = $('#runner_assigned').val();


        if ($.inArray(runner_assigned, availableTags) == -1) {

                $('#runner_assigned').css('border-color', 'red');
            $('#runner_error').removeClass("hide");
            $('#runner_error').html("Please Select A Runner");
                ++errorFlag ;


        }

        else{
            $('#runner_assigned').css('border-color', 'green');
            $('#runner_error').addClass("hide");
            $('#runner_error').html("");
        }




        var driver_name = $('#driver_name').val();


        if (driver_name == '' || driver_name.length <3 ) {
            $('#driver_name').css('border-color', 'red');
            $('#driver_name_error').removeClass("hide");
            $('#driver_name_error').html("Please Enter Driver Name");
           ++errorFlag ;
        }
        else {
            $('#driver_name').css('border-color', 'green');
            $('#driver_name_error').addClass("hide");
            $('#driver_name_error').html("");driver_contact_error
        }

        var driver_contact_number = $('#driver_contact_number').val();


        if (driver_contact_number == '' || driver_contact_number.length !=10 ||  driver_contact_number <7000000000 ) {
            $('#driver_contact_number').css('border-color', 'red');
            $('#driver_contact_error').removeClass("hide");
            $('#driver_contact_error').html("Please Enter Valid Mobile Number");
            ++errorFlag ;
        }
        else {
            $('#driver_contact_number').css('border-color', 'green');
            $('#driver_contact_error').addClass("hide");
            $('#driver_contact_error').html("");
        }


        var truck_number = $('#truck_number').val();

        if ( truck_number == '' || truck_number <5 || truck_number >13 ) {
            $('#truck_number').css('border-color', 'red');
            $('#truck_number_error').removeClass("hide");
            $('#truck_number_error').html("Please Enter A Proper Truck Number");
            ++errorFlag ;
        }
        else {
            $('#truck_number').css('border-color', 'green');
            $('#truck_number_error').addClass("hide");
            $('#truck_number_error').html("");
        }

        var truck_type = $('#truck_type').val();

        if ( truck_type == '' || truck_type <2 || truck_type.length >25 ) {
            $('#truck_type').css('border-color', 'red');
            $('#truck_type_error').removeClass("hide");
            $('#truck_type_error').html("Pleas Enter A Proper Truck Type");
            ++errorFlag ;
        }
        else {
            $('#truck_type').css('border-color', 'green');
            $('#truck_type_error').addClass("hide");
            $('#truck_type_error').html("");
        }



//        var expected_delivery_date = $('#expected_delivery_date').datepicker('getDate');
        var expected_delivery_date = $('#expected_delivery_date').val();


        if ( expected_delivery_date == ''  ) {
            $('#expected_delivery_date').css('border-color', 'red');
            $('#delivery_date_error').removeClass("hide");
            $('#delivery_date_error').html("Please Select Expected Delivery Date");
            ++errorFlag ;
        }
        else {
            $('#expected_delivery_date').css('border-color', 'green');
            $('#delivery_date_error').addClass("hide");
            $('#delivery_date_error').html("");
        }

        var expected_dispatch_date = $('#expected_dispatch_date').val();
//        var expected_dispatch_date = $('#expected_dispatch_date').datepicker('getDate');

        if ( expected_dispatch_date == ''  ) {
            $('#expected_dispatch_date').css('border-color', 'red');
            $('#dispatch_date_error').removeClass("hide");
            $('#dispatch_date_error').html("Please Enter Expected Dispatch Date");
            ++errorFlag ;
        }
        else {
            $('#expected_dispatch_date').css('border-color', 'green');
            $('#dispatch_date_error').addClass("hide");
            $('#dispatch_date_error').html("");
        }


        var address = $('#address').val();

        if ( address == '' ||  address <5  ) {
            $('#address').css('border-color', 'red');
            $('#address_error').removeClass("hide");
            $('#address_error').html("Please Enter An Address");
            ++errorFlag ;
        }
        else {
            $('#address').css('border-color', 'green');
            $('#address_error').addClass("hide");
            $('#address_error').html("");
        }


        var lat = $('#lat').val();

        if ( lat == '' || lat < 3  ) {
            $('#lat').css('border-color', 'red');
            $('#address').css('border-color', 'red');

        }
        else {
            $('#lat').css('border-color', 'green');
        }

        var long = $('#long').val();

        if ( long == '' || long < 3  ) {
            $('#address').css('border-color', 'red');
            $('#long').css('border-color', 'red');

        }
        else {
            $('#long').css('border-color', 'green');
        }



        var tracking_status = $('#tracking_status').val();

        if ( tracking_status == '-1'  ) {
            $('#tracking_status').css('border-color', 'red');
            $('#tracking_status_error').removeClass("hide");
            $('#tracking_status_error').html("Please Select A Tracking Status");

            ++errorFlag ;
        }
        else {
            $('#tracking_status').css('border-color', 'green');
        $('#tracking_status_error').addClass("hide");
        $('#tracking_status_error').html("");
    }


        var no_tracking_reason = $('#no_tracking_reason').val();


        if (  no_tracking_reason == '' &&  tracking_status == '0' ) {
            $('#no_tracking_reason').css('border-color', 'red');
            $('#reason_error').removeClass("hide");
            $('#reason_error').html("Please Enter Reason For Not tracking This Shipment");
            ++errorFlag ;
        }
        else {
            $('#no_tracking_reason').css('border-color', 'green');
            $('#reason_error').addClass("hide");
            $('#reason_error').html("");
        }

        var so_number = $('#so_number').val();






        var is_a_quantity = 0; var qty_error = 0;

    $(".sku_class").each(function () {

            if($.isNumeric($(this).val()))
            {
                is_a_quantity = is_a_quantity + $(this).val();
                $(this).css('border-color', 'green');
            }else{
                $(this).css('border-color', 'red');
                qty_error = 1;
            }


        });

        if (is_a_quantity == 0 || is_a_quantity == 0.0 ) {

            $('.sku_class').css('border-color', 'red');
            ++errorFlag ;

        }
        else{
            $('.sku_class').css('border-color', 'green');
        }

        if(errorFlag > 0){

            $.growl.error({
                message: 'Please correct all fields marked in Red .',
                size: 'large',
                duration: 5000
            });

            return false;

        }


        if (expected_delivery_date < expected_dispatch_date) {
            $.growl.error({
                message: 'Delivery date can not be before dispatch date. ',
                size: 'large',
                duration: 5000
            });

            return false;
        }

        if (lat == 0 || long == 0) {

//            $.growl.error({
//                message: ' Please Update Address .',
//                size: 'large',
//                duration: 5000
//            });
//            $('#register_dc').attr('disabled', false);
//            return false;
        }



        $('#register_dc').addClass("hide");
        $('#register_dc').next().removeClass('hide');

                                $.get("runner/validate?runner=" + runner_assigned, function (data) {
                                    if (data == 1) {

                                        item = {};
                                        item['dc_number'] = dc_number;
                                        item['runner_assigned'] = runner_assigned;
                                        item['driver_name'] = driver_name;
                                        item['driver_contact_number'] = driver_contact_number;
                                        item['truck_type'] = truck_type;
                                        item['truck_number'] = truck_number;
                                        item['expected_delivery_date'] = expected_delivery_date;
                                        item['expected_dispatch_date'] = expected_dispatch_date;
                                        item['address'] = address;
                                        item['lat'] = lat;
                                        item['long'] = long;
                                        item['tracking_status'] = tracking_status;
                                        item['no_tracking_reason'] = no_tracking_reason;
                                        item['so_number'] = so_number;

                                        skuObj = [];
                                        $(".sku_class").each(function () {
                                            itemxx = {};
                                            itemxx['sku'] = $(this).attr('sku');
                                            itemxx['sku_quantity'] = $(this).val();
                                            skuObj.push(itemxx);
                                        });

                                        item['sku_details'] = skuObj;

                                        data = {json: JSON.stringify(item)};


                                        $.post("/dc/create", data, function (data, status) {

                                            if (data == 1) {
                                                $.growl.notice({
                                                    message: 'DC Registered.',
                                                    size: 'large',
                                                    duration: 5000
                                                });

                                                $('#new_dc_form').html(" ");
                                                $('#register_new_dc').html(' Register New DC ');


                                                $.post("/so/show", {so_number: so_number}, function (data, status) {

                                                    $('#so_details').html(data);
                                                });


                                            } else {
                                                $.growl.error({
                                                    message: 'Change DC Number.',
                                                    size: 'large',
                                                    duration: 5000
                                                });
                                                $('#register_dc').attr('disabled', false);
                                                $('#register_dc').removeClass("hide");
                                                $('#register_dc').next().addClass('hide');
                                            }
                                        });


                                    } else {


                                        $('#register_dc').attr('disabled', false);
                                        $('#register_dc').removeClass("hide");
                                        $('#register_dc').next().addClass('hide');
                                    }
                                });
            });

    });


</script>


<hr>
<div class="row" id="info_status">
    <div class="form-group">
        <table class="table table-bordered">
            <tr>
                <th>
                    <center>Dc number</center>
                </th>
                <td id="" colspan="2">

                    <input type="text" size="40" id="dc_number" placeholder="Enter DC number" readonly/>
                    <span class="help-block hide danger" id="dc_error"></span>
                    &nbsp;&nbsp;

                    &nbsp;&nbsp;
                    <button id="generate_dc" class="btn btn-primary" style="width: auto">Generate DC Number</button>
                </td>
                <td>
                    {{--<label for="sel1">Select list:</label>--}}
                    <select class="form-control" id="tracking_status">
                        <option value="-1">Select Tracking status</option>
                        <option value="1">This DC is Tracked</option>
                        <option value="0">This DC is Un-Tracked</option>

                    </select>
                    <span class="help-block hide danger" id="tracking_status_error">Please Select a Tracking Status</span>
                </td>
            </tr>
            <tr id="reason_row">
                <th colspan="1">
                    Reason for Not Tracking
                </th>
                <th colspan="3"><input type="text" placeholder="Enter Reason" id="no_tracking_reason"
                                       class="form-control"/><span class="help-block hide danger" id="reason_error">Please Enter A Reason For Not Tracking</span>
                </th>
            </tr>

            <tr>
                <th>
                    <center>Runner Assignedd</center>
                </th>
                <td colspan="3">

                    <input type="text" id="runner_assigned" size="40" placeholder="Select Runner"/><span class="help-block hide danger" id="runner_error">Please Select A Runner From DropDown</span>

     				<span class="help-block hide danger"></span>

                </td>
            </tr>

            <tr>
                <th>
                    <center>Driver Name</center>
                </th>
                <td>
                    <input type="text" size="40" id="driver_name" placeholder="Enter Driver Name"/><span class="help-block hide danger" id="driver_name_error"></span>
                </td>

                <th>
                    <center>Driver Contact Number</center>
                </th>
                <td>
                    <input type="text" size="40" id="driver_contact_number" placeholder="Enter Driver Contact Number"/><span class="help-block hide danger" id="driver_contact_error"></span>
                </td>
            </tr>
            <tr>
                <th>
                    <center>Truck Number</center>
                </th>
                <td>
                    <input type="text" size="40" id="truck_number" placeholder="Enter Truck Number"/><span class="help-block hide danger" id="truck_number_error">Error</span>
                </td>
                <th>
                    <center>Truck Type</center>
                </th>
                <td>
                    <input type="text" size="40" id="truck_type" placeholder="Enter Truck Type"/>
                    <span class="help-block hide danger" id="truck_type_error"></span>
                </td>
            </tr>
            <tr>
                <th>
                    <center>
                        Expected dispatch Date
                    </center>
                </th>
                <td>

                    <input id="expected_dispatch_date" size="40" placeholder="Select Dispatch Date" type="text"

                           value="" readonly><span class="help-block hide danger" id="dispatch_date_error"></span>





                </td>
                <th>
                    <center>
                        Expected Delivery Date
                    </center>
                </th>
                <td>
                    <input id="expected_delivery_date" type="text" size="40"

                           placeholder="Select Expected Delivery Date" readonly/><span class="help-block hide danger" id="delivery_date_error">Error</span>

                </td>
            </tr>
        </table>
    </div>

    <!----------- enter info into dc --------------->


    <div class="row">
        <table class="table table-bordered">
            <tr>
                <th>
                    SKU
                </th>
                <th>
                    Description
                </th>
                <th>
                    Quantity
                </th>

            </tr>

            @foreach($details['details'] as $detail)
                <tr>
                    <td>
                        {{ $detail['sku'] }}
                    </td>
                    <td>
                        {{ $detail['sku_description'] }}
                    </td>
                    <td>
                        <input type="text" value="0" class="sku_class" sku="{{ $detail['sku'] }}" size="40"
                               placeholder="Enter Quantity">

                        {{ $detail['sku_units'] }}

                    </td>
                </tr>
            @endforeach

        </table>

        <table class="table table-bordered">
            <tr>
                <th>
                    Delivery Address
                </th>
                <th>
                    <input type="text" id="address" value="{{ $details['ship_to_address'] }}" size="60"/><span class="help-block hide danger" id="address_error">Error</span>
                    <input type="text" id="lat" value="{{ $details['lat'] }}" size="10" readonly=true hidden />
                    <input type="text" id="long" value="{{ $details['long'] }}" size="10" readonly=true hidden/>
                   </th><th>
                    <button id="select_address" class="btn btn-primary" style="width: auto">Select This Address
                    </button>
                    </th>
                <th>
                    <button id="locate_on_map" class="btn btn-primary">Locate on map</button>
                </th>
            </tr>
        </table>
        <div class="row" id="map_sellector">

            <div class="form-horizontal" style="width: 80%">

                <div id="us3" style="width: 100%; height: 400px;"></div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix"></div>
                <script></script>
            </div>

        </div>
        <table class="table table-bordered">
            <tr>
                <td colspan="3">
                    {{--</td>--}}
                    {{--<td>--}}
                    <button id="register_dc" class="btn btn-primary"> Register DC</button>
                    <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>
                </td>
                {{--<td>--}}
                {{--<button id="add_device" class="btn btn-primary"> Save and Register New</button>--}}
                {{--</td>--}}
            </tr>
        </table>
    </div>
</div>









