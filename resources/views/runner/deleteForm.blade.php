<script type="application/javascript">

    $(document).ready(function(){


        @if( !count($runner_names))
            $(function(){
                    $.growl.error({
                        message: 'No Runner registered Yet,. ',
                        size: 'large',
                        duration: 5000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3>No Runner Registered yet</h3></center>');
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

            var sure = confirm('Are you sure you want to delete the selected runner ? ');


            if (sure == true) {

            var runner_name = $('#runnerToDelete').val();

                if($.inArray(runner_name, availableTags) == -1)
                {

                    $.growl.error({
                        message: 'Select Runner Number from dropdown. ',
                        size: 'large',
                        duration: 5000
                    });
                    return false;
                }



            $.post("runner/delete", {runner_name : runner_name}, function(result) {





                if (result == 1)
                {

                    $.growl.notice({
                        message: 'Runned Deleted .',
                        size: 'large',
                        duration: 5000
                    });

                    $.get("/runner/delete", function (data, status) {

                        $('#body_div').html(data);
                    });
                    $('#delete_runner').removeClass("hide");
                    $('#delete_runner').next().addClass('hide');

                }
                else if (result == -1)
                {
                    $.growl.error({
                        message: 'Runner have undelivered DCs assigned. Please finish current deliveries first',
                        size: 'large',
                        duration: 5000
                    });

                    $('#delete_runner').removeClass("hide");
                    $('#delete_runner').next().addClass('hide');
                }
                else{
                    $.growl.error({
                        message: 'Cannot delete runner Please Contact Support. ',
                        size: 'large',
                        duration: 5000
                    });

                    $('#delete_runner').removeClass("hide");
                    $('#delete_runner').next().addClass('hide');

                }

            });

            } else {

                $('#delete_runner').removeClass("hide");
                $('#delete_runner').next().addClass('hide');
            }

        });



    });



</script>
  <h3 align="center"> Select Runner to Delete</h3>
<div id="info_status">
<div id="runner_selector" >

<table class="table table-striped">
    <tr>
    	<th>&nbsp;</th>
    	<th>&nbsp;</th>
        <th style="width: 246px;vertical-align: middle;">Select Runner To Delete<Span class="danger">*</Span></th>
        <th>
            <div class="ui-widget">
                <input class="form-control" id="runnerToDelete" placeholder="Enter runner to Delete">
            </div>
        </th>
        <th>
            <button  id="delete_runner" class="btn btn-primary btn-sm">Delete Runner</button>
        </th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
</table>

 


</div>

<hr />


<div id="delete_result">



</div>

</div>