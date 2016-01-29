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
        $('#info_status').html('<center><h3>NO RunnerRegistered yet</h3></center>');
        @endif


     availableTags = [
            @foreach( $runner_names as $named)

    "{{ $named }}",
            @endforeach
    ];

        $(function() {
            $( "#runnerToEdit" ).autocomplete({
                source: availableTags,
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search", "");
            });
        });

        $('#edit_runner').click(function(){

            var runner_name = $('#runnerToEdit').val();

            if($.inArray(runner_name, availableTags) == -1)
            {

                $.growl.error({
                    message: 'Select Runner ID from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }


            $.post("runner/updateSelect", {runner_name : runner_name}, function(result) {

                $('#edit_form').html(result);

            });


        });



    });



</script>
<div id="info_status">
<div id="runner_selector" >

    <h3 align="center"> Select Runner to Edit</h3>


    <table class="table table-bordered">
        <tr>
            <th>
                Runner To Edit :
            </th>
            <th>
                <div class="ui-widget">
                     <input id="runnerToEdit" placeholder="Enter Runner Name" />
                </div>
            </th>
            <th>
                <button  id="edit_runner" class="btn btn-primary">Edit Runner</button>
            </th>
        </tr>
    </table>


</div>

<hr />

<div id="edit_form">



</div>

</div>