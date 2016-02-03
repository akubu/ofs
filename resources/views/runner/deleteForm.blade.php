<script type="application/javascript">

    $(document).ready(function(){


        @if( !count($runner_names))
            $(function(){
                    $.growl.error({
                        message: 'No Runner registered Yet,. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3>NO Runner Registered yet</h3></center>');
        @endif



      availableTags = [
            @foreach( $runner_names as $named)

    "{{ $named }}",
            @endforeach
    ];
    $(function() {

            $( "#runnerToDelete" ).autocomplete({
                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTags, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search", $( "#runnerToDelete").val());
            });
        });

        $('#delete_runner').click(function(){


            $('#delete_runner').addClass("hide");
            $('#delete_runner').next().removeClass('hide');

            var sure = confirm('Are you sure ? ');


            if (sure == true) {

            var runner_name = $('#runnerToDelete').val();

                if($.inArray(runner_name, availableTags) == -1)
                {

                    $.growl.error({
                        message: 'Select Runner Number from dropdown. ',
                        size: 'large',
                        duration: 10000
                    });
                    return false;
                }



            $.post("runner/delete", {runner_name : runner_name}, function(result) {



                $('#delete_result').html(result);

                if (result == 1)
                {

                    $.growl.notice({
                        message: 'Runned Deleted .',
                        size: 'large',
                        duration: 10000
                    });

                    $.get("/runner/delete", function (data, status) {

                        $('#body_div').html(data);
                    });


                }else{
                    $.growl.error({
                        message: 'Cannot delete runner Please Contact Support. ',
                        size: 'large',
                        duration: 10000
                    });

                    $('#delete_runner').removeClass("hide");
                    $('#delete_runner').next().addClass('hide');

                }

            });

            } else {
                txt = "You pressed Cancel!";
            }

        });



    });



</script>
<div id="info_status">
<div id="runner_selector" >

    <h3 align="center"> Select Runner to Delete</h3>


    <table class="table table-bordered">
        <tr>
            <th>
                Runner To Delete :
            </th>
            <th>
                <div class="ui-widget">
                    <input id="runnerToDelete" placeholder="Enter runner to Delete ">
                </div>
            </th>
            <th>
                <button  id="delete_runner" class="btn btn-primary">Delete Runner</button>
            </th>
        </tr>
    </table>


</div>

<hr />


<div id="delete_result">



</div>

</div>