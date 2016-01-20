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


    $(function() {
            var availableTags = [
                @foreach( $runner_names as $named)

        "{{ $named }}",
                @endforeach
        ];
            $( "#runnerToDelete" ).autocomplete({
                source: availableTags
            });
        });

        $('#delete_runner').click(function(){

            var sure = confirm('Are you sure ? ');


            if (sure == true) {

            var runner_name = $('#runnerToDelete').val();

            $.post("runner/delete", {runner_name : runner_name}, function(result) {

                $('#delete_result').html(result);

                if (result == 1)
                {

                    $.growl.error({
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