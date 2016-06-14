$(document).ready(function(){

   $('#start_loading').click(function(){

       $.get("webApp/startLoading", function(data){

           $('#body_div').html(data);

       });

   }) ;

    $('#dispatch').click(function(){

        $.get("webApp/dispatch", function(data){

            $('#body_div').html(data);

        });

    }) ;

    $('#deliver').click(function(){

        $.get("webApp/deliver", function(data){

            $('#body_div').html(data);

        });

    }) ;

    $('#track').click(function(){

        $.get("webApp/track", function(data){

            $('#body_div').html(data);

        });

    }) ;


    $('#do_dispatch').click(function(){

        alert("dispatch");

        $.get("webApp/", function(data){

            $('#body_div').html(data);

        });

    }) ;


    $('#do_deliver').click(function(){

        alert("ddeliver");

        $.get("webApp/", function(data){

            $('#body_div').html(data);

        });

    }) ;


    $('#do_track').click(function(){

        alert("track");

        $.get("webApp/", function(data){

            $('#body_div').html(data);

        });

    }) ;






});