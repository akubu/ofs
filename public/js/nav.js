$(document).ready(function () {


    $.get("/home", function (data, status) {

        $('#body_div').html(data);
    });

    $('#home').click(function () {


        $.get("/home", function (data, status) {

            $('#body_div').html(data);
        });

        return false;

    });

////////////////////      Adssignment NAV Starts



    $('#new_assignment_nav').click(function () {


        $.get("manageDc", function (data, status) {

            $('#body_div').html(data);


        });

        return true;
    });


    $('#mark_delivered_nav').click(function () {


        $.get("/dc/markDeliveredSelection", function (data, status) {

            $('#body_div').html(data);


        });

        return true;
    });






    $('#current_assignment_nav').click(function () {

        $.get("dc/manageDC", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#update_dc_nav').click(function () {


        $.get("dc/updateDCSelection", function (data, status) {

            $('#body_div').html(data);
        });


    });

///////////////////////  Assignment NAV  Ends




    $('#track_shipment_nav').click(function () {


        $.get("dc/manageDC", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#track_runner_nav').click(function () {


        $.get("/runner/all", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#track_device').click(function () {


        $.get("/device/all", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#add_runner_nav').click(function () {


        $.get("/runner/create", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#update_runner_nav').click(function () {


        $.get("/runner/updateSelect", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#delete_runner_nav').click(function () {


        $.get("/runner/delete", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#all_runner_nav').click(function () {


        $.get("/runner/all", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#new_device_nav').click(function () {


        $.get("/device/add", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#allocate_device_to_runner_nav').click(function () {


        $.get("/device/allocateForm", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#recover_device_nav').click(function () {


        $.get("/device/recover", function (data, status) {

            $('#body_div').html(data);
        });


    });



    $('#register_device_loss_nav').click(function () {


        $.get("/device/loss", function (data, status) {

            $('#body_div').html(data);
        });


    });

    $('#all_device_nav').click(function () {


        $.get("/device/all", function (data, status) {

            $('#body_div').html(data);
        });


    });



    $('#upload_document_nav').click(function () {


        $.get("/dc/uploadDocuments", function (data, status) {

            $('#body_div').html(data);
        });


    });

    $('#view_document_nav').click(function () {


        $.get("/dc/uploadDocuments", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#start_shipment_nav').click(function () {


        $.get("/start_shipment", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#register_delivery_nav').click(function () {


        $.get("/register_delivery", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#urgent_notifications_nav').click(function () {


        $.get("/urgent_notifications", function (data, status) {

            $('#body_div').html(data);
        });


    });


    $('#ask_question_nav').click(function () {


        $.get("/help/askForm", function (data, status) {

            $('#body_div').html(data);
        });


    });


});




///////////   functions for the future past




