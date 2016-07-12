$(document).ready(function () {




    $.get("/home", function (data, status) {

        if(data.auth_required == true)
        {
            window.location = "/auth/login";
            return false;
        }
        $('#body_div').html(data);
    });

    $('#home').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/home", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });

        return false;

    });

////////////////////      Adssignment NAV Starts



    $('#new_assignment_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/manageDc", function (data, status) {

            $('#body_div').html(data);


        });

        return true;
    });


    $('#mark_delivered_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/dc/markDeliveredSelection", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);


        });

        return true;
    });






    $('#current_assignment_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("dc/manageDC", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#update_dc_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("dc/updateDCSelection", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });

///////////////////////  Assignment NAV  Ends




    $('#track_shipment_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("dc/manageDC", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#assign_runner_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/runner/assignDC", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#track_device').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/device/all", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#add_runner_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/runner/create", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#update_runner_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/runner/updateSelect", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#delete_runner_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/runner/delete", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#all_runner_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/runner/all", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#new_device_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/device/add", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#allocate_device_to_runner_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/device/allocateForm", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#recover_device_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/device/recover", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });



    $('#register_device_loss_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/device/loss", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });

    $('#all_device_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/device/all", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });



    $('#upload_document_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/dc/uploadDocuments", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });

    $('#view_document_nav').click(function () {

        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');
        $.get("/dc/uploadDocuments", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#start_shipment_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/start_shipment", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#register_delivery_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/register_delivery", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#urgent_notifications_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/urgent_notifications", function (data, status) {
            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }
            $('#body_div').html(data);
        });


    });


    $('#ask_question_nav').click(function () {
        $('#body_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/help/askForm", function (data, status) {



            if(data.auth_required == true)
            {
                window.location = "/auth/login";
                return false;
            }


            $('#body_div').html(data);
        });


    });


});




///////////   functions for the future past




