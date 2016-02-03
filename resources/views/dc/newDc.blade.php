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
                        message: 'No Runner registered Yet,. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3>Please add a runner first</h3></center>');
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
                $(this).autocomplete("search", $('#so_number').val());

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
            ++errorFlag ;
        }
        else {
            $('#dc_number').css('border-color', 'green');
        }


        var runner_assigned = $('#runner_assigned').val();


        if ($.inArray(runner_assigned, availableTags) == -1) {

                $('#runner_assigned').css('border-color', 'red');
                ++errorFlag ;


        }

        else{
            $('#runner_assigned').css('border-color', 'green');
        }




        var driver_name = $('#driver_name').val();


        if (driver_name == '' || driver_name.length <3 ) {
            $('#driver_name').css('border-color', 'red');
           ++errorFlag ;
        }
        else {
            $('#driver_name').css('border-color', 'green');
        }

        var driver_contact_number = $('#driver_contact_number').val();


        if (driver_contact_number == '' || driver_contact_number.length !=10 ||  driver_contact_number <7000000000 ) {
            $('#driver_contact_number').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#driver_contact_number').css('border-color', 'green');
        }


        var truck_number = $('#truck_number').val();

        if ( truck_number == '' || truck_number <5 || truck_number >13 ) {
            $('#truck_number').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#truck_number').css('border-color', 'green');
        }

        var truck_type = $('#truck_type').val();

        if ( truck_type == '' || truck_type <2 || truck_type.length >25 ) {
            $('#truck_type').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#truck_type').css('border-color', 'green');
        }



//        var expected_delivery_date = $('#expected_delivery_date').datepicker('getDate');
        var expected_delivery_date = $('#expected_delivery_date').val();


        if ( expected_delivery_date == ''  ) {
            $('#expected_delivery_date').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#expected_delivery_date').css('border-color', 'green');
        }

        var expected_dispatch_date = $('#expected_dispatch_date').val();
//        var expected_dispatch_date = $('#expected_dispatch_date').datepicker('getDate');

        if ( expected_dispatch_date == ''  ) {
            $('#expected_dispatch_date').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#expected_dispatch_date').css('border-color', 'green');
        }


        var address = $('#address').val();

        if ( address == '' ||  address <5  ) {
            $('#address').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#address').css('border-color', 'green');
        }


        var lat = $('#lat').val();

        if ( lat == '' || lat < 3  ) {
            $('#lat').css('border-color', 'red');
            $('#address').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#lat').css('border-color', 'green');
        }

        var long = $('#long').val();

        if ( long == '' || long < 3  ) {
            $('#address').css('border-color', 'red');
            $('#long').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#long').css('border-color', 'green');
        }



        var tracking_status = $('#tracking_status').val();

        if ( tracking_status == '-1'  ) {
            $('#tracking_status').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#tracking_status').css('border-color', 'green');
        }

        var no_tracking_reason = $('#no_tracking_reason').val();


        if (  no_tracking_reason == '' &&  tracking_status == '0' ) {
            $('#no_tracking_reason').css('border-color', 'red');
            ++errorFlag ;
        }
        else {
            $('#no_tracking_reason').css('border-color', 'green');
        }

        var so_number = $('#so_number').val();



        if(lat == 0 || long == 0)
        {
            $.growl.error({
                message: 'Please Change Address.',
                size: 'large',
                duration: 5000
            });
            $('#address').css('border-color', 'red');
            $('#address').css('border-color', 'red');
            $('#address').css('border-color', 'red');
            return false;
        }


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

            $.growl.error({
                message: ' Please Update Address .',
                size: 'large',
                duration: 5000
            });
            return false;
        }




        if (!(dc_number && runner_assigned && driver_contact_number && driver_name && truck_number && truck_type && expected_delivery_date && expected_dispatch_date && address && lat && long)) {
            $.growl.error({
                message: 'Please fill all information.',
                size: 'large',
                duration: 5000
            });
            return false;
        } else {

            if ($.isNumeric(driver_contact_number) && driver_contact_number.length > 9) {

                if (dc_number.length > 5) {
                    if (driver_name.length > 3) {

                        if (tracking_status > -1) {

                            if (( tracking_status == 0 && no_tracking_reason.length > 3) || tracking_status == 1) {

                                ///////////////////  sender

                                $.get("runner/validate?runner=" + runner_assigned, function (data) {
                                    if (data == 1) {


//                            jsonObj = [];
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

//                            jsonObj.push(item);

                                        skuObj = [];
                                        $(".sku_class").each(function () {
                                            itemxx = {};
                                            itemxx['sku'] = $(this).attr('sku');
                                            itemxx['sku_quantity'] = $(this).val();
                                            skuObj.push(itemxx);
                                        });

                                        item['sku_details'] = skuObj;

//                            jsonObj.push(item);

                                        data = {json: JSON.stringify(item)};
//                                console.log(JSON.stringify(item));

//                            $.ajax
//                            ({
//                                type: "POST",
//                                //the url where you want to sent the userName and password to
//                                url: '/dc/create',
//                                //json object to sent to the authentication url
//                                data:'json='+jsonObj ,
//                                success: function () {
//
//                                    alert("Thanks!");
//                                }
//                            })

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
                                            }
                                        });


                                    } else {

                                        $.growl.error({
                                            message: 'Please select runner from autocomplete',
                                            size: 'large',
                                            duration: 5000
                                        });
                                    }
                                });


                                /////////////////////   sender ends
                            } else {
                                $.growl.error({
                                    message: 'Enter No tracking reason.',
                                    size: 'large',
                                    duration: 5000
                                });
                            }

                        } else {
                            $.growl.error({
                                message: 'Enter correct Tracking Status.',
                                size: 'large',
                                duration: 5000
                            });
                        }
                    } else {
                        $.growl.error({
                            message: 'Enter correct driver contact number.',
                            size: 'large',
                            duration: 5000
                        });
                    }
                } else {
                    $.growl.error({
                        message: 'Enter correct DC number.',
                        size: 'large',
                        duration: 5000
                    });
                }

            } else {
                $.growl.error({
                    message: 'Enter correct driver contact number.',
                    size: 'large',
                    duration: 5000
                });
            }
        }


//        jsonObj = [];
//        item = {};
//        item['dc_number'] = dc_number;
//        item['runner_assigned'] = runner_assigned;
//        item['driver_name'] = driver_name;
//        item['driver_contact_number'] = driver_contact_number;
//        item['truck_type'] = truck_type;
//        item['truck_number'] = truck_number;
//        item['expected_delivery_date'] = expected_delivery_date;
//        item['expected_dispatch_date'] = expected_dispatch_date;
//        item['address'] = address;
//        item['lat'] = lat;
//        item['long'] = long;
//        item['tracking_status'] = tracking_status;
//
//        jsonObj.push(item);
//
//        skuObj = [];
//        $(".sku_class").each(function () {
//            item = {};
//            item['sku'] = $(this).attr('sku');
//            item['quantity'] = $(this).val();
//            skuObj.push(item);
//        });
//
//        item = {};
//        item['sku_details'] = skuObj;
//        jsonObj.push(item);


//        console.log(JSON.stringify(jsonObj));


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
                    <input type="text" size="40" id="dc_number" placeholder="Enter DC number" readonly/> &nbsp;&nbsp;
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
                </td>
            </tr>
            <tr id="reason_row">
                <th colspan="1">
                    Reason for Not Tracking
                </th>
                <th colspan="3"><input type="text" placeholder="Enter Reason" id="no_tracking_reason"
                                       class="form-control"/>
                </th>
            </tr>

            <tr>
                <th>
                    <center>Runner Assignedd</center>
                </th>
                <td colspan="3">
                    <input type="text" id="runner_assigned" size="40" placeholder="Select Runner"/>
     				<span class="help-block danger">Error</span>
                </td>
            </tr>

            <tr>
                <th>
                    <center>Driver Name</center>
                </th>
                <td>
                    <input type="text" size="40" id="driver_name" placeholder="Enter Driver Name"/>
                </td>

                <th>
                    <center>Driver Contact Number</center>
                </th>
                <td>
                    <input type="text" size="40" id="driver_contact_number" placeholder="Enter Driver Contact Number"/>
                </td>
            </tr>
            <tr>
                <th>
                    <center>Truck Number</center>
                </th>
                <td>
                    <input type="text" size="40" id="truck_number" placeholder="Enter Truck Number"/>
                </td>
                <th>
                    <center>Truck Type</center>
                </th>
                <td>
                    <input type="text" size="40" id="truck_type" placeholder="Enter Truck Type"/>
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
                           value="" readonly>


                </td>
                <th>
                    <center>
                        Expected Delivery Date
                    </center>
                </th>
                <td>
                    <input id="expected_delivery_date" type="text" size="40"
                           placeholder="Select Expected Delivery Date" readonly/>
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
                    <input type="text" id="address" value="{{ $details['ship_to_address'] }}" size="60"/>
                    <input type="text" id="lat" value="{{ $details['lat'] }}" size="10" readonly=true />
                    <input type="text" id="long" value="{{ $details['long'] }}" size="10" readonly=true />
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
                </td>
                {{--<td>--}}
                {{--<button id="add_device" class="btn btn-primary"> Save and Register New</button>--}}
                {{--</td>--}}
            </tr>
        </table>
    </div>
</div>








