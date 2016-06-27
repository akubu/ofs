<!DOCTYPE html>
<meta charset="utf-8">

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

        $("#dc_date").datepicker({
            dateFormat: "yy-mm-dd"
        });





        {{--@if( !count($runner_names))--}}
         {{--$(function () {--}}
                    {{--$.growl.error({--}}
                        {{--message: 'No Runner registered In System. ',--}}
                        {{--size: 'large',--}}
                        {{--duration: 10000--}}
                    {{--});--}}
                    {{--$('#allocate_device').hide();--}}
                {{--});--}}

        {{--$('#info_status').html('<center><h3 style="color:#0AB2F1; margin-top:30px;">Please add a runner first</h3></center>');--}}

        {{--@endif--}}


 {{--availableTags = [--}}
            {{--@foreach( $runner_names as $runner_name)--}}

    {{--"{{ $runner_name }}",--}}
            {{--@endforeach--}}
    {{--];--}}

        {{--$(function () {--}}

            {{--$("#runner_assigned").autocomplete({--}}
                {{--source: function (request, response) {--}}
                    {{--var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");--}}
                    {{--response($.grep(availableTags, function (value) {--}}
                        {{--return matcher.test(value.toUpperCase());--}}
                    {{--}));--}}
                {{--},--}}
                {{--minLength: 0,--}}
                {{--scroll: true--}}
            {{--}).focus(function () {--}}
                {{--$(this).autocomplete("search", $('#runner_assigned').val());--}}

            {{--});--}}
        {{--});--}}


        $('#select_address').click(function () {
            $('#map_sellector').hide();
            $('#select_address').hide();
            $('#locate_on_map').show();
            $('#address').attr('readonly', true)
            $('#locate_on_map').html('Change Address');
        });

//        $('#generate_dc').click(function () {
//
//            var so_number = $('#so_number').val();
//            $.post('/dc/getDCNumber', {so_number: so_number}, function (data) {
//
//                $('#dc_number').val(data);
//
//            });
//
//        });


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


//        $('#tracking_status').change(function () {
//
//            var tracking_status = $('#tracking_status').val();
//            if (tracking_status == 0) {
//                $('#reason_row').show();
//            } else {
//                $('#reason_row').hide();
//            }
//        });

        $('#register_dc').click(function () {


            errorFlag = 0;

            which = 0;

//            var dc_number = $('#dc_number').val();
//
//            if (dc_number == '') {
//                $('#dc_number').css('border-color', 'red');
//                $('#dc_error').removeClass("hide");
//                $('#dc_error').html("Please Generate A DC Number");
//                which = 1;
//                ++errorFlag;
//            }
//            else {
//                $('#dc_number').css('border-color', 'green');
//                $('#dc_error').addClass("hide");
//                $('#dc_error').html("");
//            }


//            var runner_assigned = $('#runner_assigned').val();
//
//
//            if ($.inArray(runner_assigned, availableTags) == -1) {
//                which = 2;
//                $('#runner_assigned').css('border-color', 'red');
//                $('#runner_error').removeClass("hide");
//                $('#runner_error').html("Please Select A Runner");
//                ++errorFlag;
//
//
//            }
//
//            else {
//                $('#runner_assigned').css('border-color', 'green');
//                $('#runner_error').addClass("hide");
//                $('#runner_error').html("");
//            }


            var driver_name = $('#driver_name').val();

            which = 3;
            if (driver_name == '' || driver_name.length < 3) {
                $('#driver_name').css('border-color', 'red');
                $('#driver_name_error').removeClass("hide");
                $('#driver_name_error').html("Please Enter Driver Name");
                ++errorFlag;
            }
            else {
                $('#driver_name').css('border-color', 'green');
                $('#driver_name_error').addClass("hide");
                $('#driver_name_error').html("");
            }

            var driver_contact_number = $('#driver_contact_number').val();


            if (driver_contact_number == '' || driver_contact_number < 7000000000 || driver_contact_number > 9999999999 || !$.isNumeric(driver_contact_number)) {
                which = 4;
                $('#driver_contact_number').css('border-color', 'red');
                $('#driver_contact_error').removeClass("hide");
                $('#driver_contact_error').html("Please Enter Valid Mobile Number");
                ++errorFlag;
            }
            else {
                $('#driver_contact_number').css('border-color', 'green');
                $('#driver_contact_error').addClass("hide");
                $('#driver_contact_error').html("");
            }


            var truck_number = $('#truck_number').val();

            if (truck_number == '' || truck_number < 5 || truck_number > 13) {
                which = 5;
                $('#truck_number').css('border-color', 'red');
                $('#truck_number_error').removeClass("hide");
                $('#truck_number_error').html("Please Enter A Proper Truck Number");
                ++errorFlag;
            }
            else {
                $('#truck_number').css('border-color', 'green');
                $('#truck_number_error').addClass("hide");
                $('#truck_number_error').html("");
            }

            var truck_capacity = $('#truck_capacity').val();

            if (truck_capacity == '' || truck_capacity < 0.1 || truck_capacity.length > 6) {

                which = 6;
                $('#truck_capacity').css('border-color', 'red');
                $('#truck_type_error').removeClass("hide");
                $('#truck_type_error').html("Please Enter A Proper Truck Type");
                ++errorFlag;
            }
            else {
                $('#truck_type').css('border-color', 'green');
                $('#truck_type_error').addClass("hide");
                $('#truck_type_error').html("");
            }


//        var expected_delivery_date = $('#expected_delivery_date').datepicker('getDate');
            var expected_delivery_date = $('#expected_delivery_date').val();


            if (expected_delivery_date == '') {

                which = 7;
                $('#expected_delivery_date').css('border-color', 'red');
                $('#delivery_date_error').removeClass("hide");
                $('#delivery_date_error').html("Please Select Expected Delivery Date");
                ++errorFlag;
            }
            else {
                $('#expected_delivery_date').css('border-color', 'green');
                $('#delivery_date_error').addClass("hide");
                $('#delivery_date_error').html("");
            }

            var expected_dispatch_date = $('#expected_dispatch_date').val();
//        var expected_dispatch_date = $('#expected_dispatch_date').datepicker('getDate');

            if (expected_dispatch_date == '') {
                which = 8;
                $('#expected_dispatch_date').css('border-color', 'red');
                $('#dispatch_date_error').removeClass("hide");
                $('#dispatch_date_error').html("Please Enter Expected Dispatch Date");
                ++errorFlag;
            }
            else {
                $('#expected_dispatch_date').css('border-color', 'green');
                $('#dispatch_date_error').addClass("hide");
                $('#dispatch_date_error').html("");
            }


            var address = $('#address').val();

            if (address == '' || address < 5) {
                which = 9;
//            $('#address').css('border-color', 'red');
//            $('#address_error').removeClass("hide");
//            $('#address_error').html("Please Enter An Address");
//            ++errorFlag ;
            }
            else {
//            $('#address').css('border-color', 'green');
//            $('#address_error').addClass("hide");
//            $('#address_error').html("");
            }


            var lat = $('#lat').val();

            if (lat == '' || lat < 3) {
//            $('#lat').css('border-color', 'red');
//            $('#address').css('border-color', 'red');
                which = 10;
            }
            else {
                $('#lat').css('border-color', 'green');
            }

            var long = $('#long').val();

            if (long == '' || long < 3) {
//            $('#address').css('border-color', 'red');
//            $('#long').css('border-color', 'red');
                which = 11;
            }
            else {
                $('#long').css('border-color', 'green');
            }


//            var tracking_status = $('#tracking_status').val();
//
//            if (tracking_status == '-1') {
//                $('#tracking_status').css('border-color', 'red');
//                $('#tracking_status_error').removeClass("hide");
//                $('#tracking_status_error').html("Please Select A Tracking Status");
//                which = 12;
//                ++errorFlag;
//            }
//            else {
//                $('#tracking_status').css('border-color', 'green');
//                $('#tracking_status_error').addClass("hide");
//                $('#tracking_status_error').html("");
//            }

//
//            var no_tracking_reason = $('#no_tracking_reason').val();
//
//
//            if (no_tracking_reason == '' && tracking_status == '0') {
//                $('#no_tracking_reason').css('border-color', 'red');
//                $('#reason_error').removeClass("hide");
//                $('#reason_error').html("Please Enter Reason For Not tracking This Shipment");
//                ++errorFlag;
//                which = 13;
//            }
//            else {
//                $('#no_tracking_reason').css('border-color', 'green');
//                $('#reason_error').addClass("hide");
//                $('#reason_error').html("");
//            }

            var so_number = $('#so_number').val();


            var is_a_quantity = 0;
            var qty_error = 0;

            $(".sku_class").each(function () {

                if ($.isNumeric($(this).val())) {
                    is_a_quantity = is_a_quantity + $(this).val();
                    $(this).css('border-color', 'green');
                } else {
                    $(this).css('border-color', 'red');
                    qty_error = 1;
                    which = 19;
                }


            });

            if (is_a_quantity == 0 || is_a_quantity == 0.0 || qty_error < 0) {

                $('.sku_class').css('border-color', 'red');

                which = 21;
                ++errorFlag;
            }
            else {
                $('.sku_class').css('border-color', 'green');
            }

            if (errorFlag > 0) {

                if (which == 21) {
                    $.growl.error({
                        message: 'Quantity for at-least one sku should be Greater than 0.',
                        size: 'large',
                        duration: 5000
                    });

                }
                {

                    $.growl.error({
                        message: 'Please correct all fields marked in Red .',
                        size: 'large',
                        duration: 5000
                    });
                }

                which = 0;


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


            $('#register_new_dc').addClass("hide");
            $('#register_new_dc').next().removeClass('hide');



            $('input').attr('readonly', true);





                    var JavaScriptObjectLiteral = {
                        dc_number: "",
                        runner_assigned: "",
                        driver_name: driver_name,
                        driver_contact_number: driver_contact_number,
                        truck_capacity: truck_capacity,
                        truck_number: truck_number,
                        expected_delivery_date: expected_delivery_date,
                        expected_dispatch_date: expected_dispatch_date,
                        address: address,
                        lat: lat,
                        long: long,
                        tracking_status: "",
                        no_tracking_reason: "",
                        so_number: so_number,
                        dc_date: $('#dc_date').val()

                    }


                    skuObj = [];
                    $(".sku_class").each(function () {
                        itemxx = {};
                        itemxx['sku'] = $(this).attr('sku');
                        itemxx['sku_quantity'] = $(this).val();
                        skuObj.push(itemxx);
                    });

                    JavaScriptObjectLiteral['sku_details'] = skuObj;


                    theJ = {json: JSON.stringify(JavaScriptObjectLiteral)};


                    $.post("/dc/create", theJ, function (data, status) {



                        if (status == "success") {

//                            json = JSON.parse(data);
                            var dc_number = data['dc_number'];

                            $.growl.notice({
                                message: 'DC Registered. DC Number: ' + dc_number ,
                                size: 'large',
                                duration: 10000
                            });

                            $('#new_dc_form').html(" ");
                            $('#register_new_dc').html(' Register New DC ');


                            $.post("/so/show", {so_number: so_number}, function (data, status) {

                                $('#so_details').html(data);
                            });






                        } else {
                            $.growl.error({
                                message: 'DC Not Registered.',
                                size: 'large',
                                duration: 5000
                            });
                            $('#register_dc').attr('disabled', false);
                            $('input').attr('readonly', false);
                            $('#register_dc').removeClass("hide");
                            $('#register_dc').next().addClass('hide');


                            $('#register_new_dc').removeClass("hide");
                            $('#register_new_dc').next().addClass('hide');
                        }




            });
        });

    });


</script>


<hr>
<div class="row" id="info_status">

    {{--<table class="table table-striped">--}}
        {{--<tr>--}}

            {{--<th style="width: 210px;vertical-align: middle; text-align:center">Dc number:<Span class="danger">*</Span>--}}
            {{--</th>--}}

            {{--<th>--}}
                {{--<input type="text" class="form-control" size="40" id="dc_number" placeholder="Enter DC number"--}}
                       {{--readonly/>--}}
                {{--<span class="help-block hide danger" id="dc_error"></span>--}}
            {{--</th>--}}
            {{--<th>--}}
                {{--<button id="generate_dc" class="btn btn-primary btn-sm" style="width: auto">Generate DC Number</button>--}}
            {{--</th>--}}
            {{--<th>&nbsp;</th>--}}
            {{--<th>&nbsp;</th>--}}
            {{--<th>&nbsp;</th>--}}
            {{--<th>&nbsp;</th>--}}
            {{--<th>&nbsp;</th>--}}

        {{--</tr>--}}
    {{--</table>--}}

    <div class="form-group">
        <table class="table borderless">



            <tr>
                <th>
                    <center>
                       BEBB location  :
                        <Span class="danger">*</Span></center>
                    </center>
                </th>
                    <td>

                        <input type="text" class="form-control" id="location_Code" value="{{ $location_code }}" disabled/>
                    {{--<select id="bebb_location" class="form-control">--}}
                        {{--@foreach($bebb_locations as $bebb_location)--}}
                        {{--<option value="{{ $bebb_location->code }}">{{$bebb_location->code}}</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}

                    <span class="help-block hide danger" id="bebb_location_error"></span>
                </td>

                <th>
                    <center> DC Date <Span class="danger">*</Span></center>
                </th>

                <td>

                    <input id="dc_date" class="form-control" type="text" size="40"

                           placeholder="Select DC Date" value="{{ $date_time }}" readonly/><span class="help-block hide danger"
                                                                                       id="dc_date_error">Error</span>

                </td>
            </tr>



            <tr>
                <th>
                    <center>Driver Name
                        <Span class="danger">*</Span></center>
                </th>
                <td>
                    <input type="text" class="form-control" size="40" id="driver_name" placeholder="Enter Driver Name"/><span
                            class="help-block hide danger" id="driver_name_error"></span>
                </td>

                <th>
                    <center>Driver Contact Number
                        <Span class="danger">*</Span></center>
                </th>
                <td>
                    <input type="text" class="form-control" size="40" id="driver_contact_number"
                           placeholder="Enter Driver Contact Number"/><span class="help-block hide danger"
                                                                            id="driver_contact_error"></span>
                </td>
            </tr>
            <tr>
                <th>
                    <center>Truck Number
                        <Span class="danger">*</Span></center>
                </th>
                <td>
                    <input type="text" class="form-control" size="40" id="truck_number"
                           placeholder="Enter Truck Number"/><span class="help-block hide danger"
                                                                   id="truck_number_error">Error</span>
                </td>
                <th>
                <center>Truck capacity
                <Span class="danger">*</Span></center>
                </th>
                <td>
                    <input type="text" size="40" id="truck_capacity" value="" class="form-control"
                           placeholder="Enter Truck Load Capacity" />
                    <span class="help-block hide danger" id="truck_type_error"></span>
                </td>
            </tr>
            <tr>
                <th>
                    <center>
                        Expected dispatch Date
                        <Span class="danger">*</Span>
                    </center>
                </th>
                <td>

                    <input id="expected_dispatch_date" class="form-control" size="40" placeholder="Select Dispatch Date"
                           type="text"

                           value="" readonly><span class="help-block hide danger" id="dispatch_date_error"></span>


                </td>
                <th>
                    <center>
                        Expected Delivery Date
                        <Span class="danger">*</Span>
                    </center>
                </th>
                <td>
                    <input id="expected_delivery_date" class="form-control" type="text" size="40"

                           placeholder="Select Expected Delivery Date" readonly/><span class="help-block hide danger"
                                                                                       id="delivery_date_error">Error</span>

                </td>
            </tr>
        </table>
    </div>

    <!----------- enter info into dc --------------->

    <br><br>

    <table class="table table-striped">
        <tr>
            <th>
                SKU
            </th>
            <th>
                Description
            </th>
            <th>
                Remaining Quantity
            </th>
            <th>
                Current Quantity
            </th>
            <th>
                SKU Units
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
                    {{ $detail['sku_quantity'] -  $detail['shipped'] }} {{ $detail['sku_units'] }}
                </td>
                <td>
                    <input type="text" class="form-control sku_class" value="0" sku="{{ $detail['sku'] }}" size="40"
                           placeholder="Enter Quantity">

                </td>
                <td>
                    {{ $detail['sku_units'] }}
                </td>
            </tr>
        @endforeach

    </table>

    <table class="table table-striped">
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th style="width: 210px;vertical-align: middle; text-align:center">Delivery Address:
                <Span class="danger">*</Span></th>
            <th>
                <input type="text" class="form-control" id="address" value="{{ $details['ship_to_address'] }}"
                       size="60"/><span class="help-block hide danger" id="address_error">Error</span>
                <input type="text" id="lat" value="{{ $details['lat'] }}" size="10" readonly=true hidden/>
                <input type="text" id="long" value="{{ $details['long'] }}" size="10" readonly=true hidden/>
            </th>
            <th>
                <button id="select_address" class="btn btn-primary btn-sm">Select This Address</button>
            </th>
            <th>
                <button id="locate_on_map" class="btn btn-primary btn-sm">Locate on map</button>
            </th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>


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

    <div class="col-md-12">
        <div class="col-md-5"></div>
        <div class="col-md-2">
            <button id="register_dc" class="btn btn-primary"> Create DC</button>
            <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif"/></div>
        </div>
        <div class="col-md-5"></div>
    </div>


</div>









