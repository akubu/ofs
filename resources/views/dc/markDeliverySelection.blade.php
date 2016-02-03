<script type="application/javascript">
    $(document).ready(function () {


        @if( !count($dc_numbers))
          $(function(){
                    $.growl.error({
                        message: 'No Untracked DC registered Yet,. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h2 style="color:#0AB2F1; margin-top:30px;">No untracked DC Registered yet</h2></center>');
        @endif


  availableTags = [
            @foreach( $dc_numbers as $dc_number)

    "{{ $dc_number }}",
            @endforeach
    ];

        $(function () {

            $("#dcNumberSelect").autocomplete({
                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTags, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search",  $("#dcNumberSelect").val());
            });
        });

        $('#dc_select').click(function(){




            var dcNumberSelect = $.trim($("#dcNumberSelect").val());

            if($.inArray(dcNumberSelect, availableTags) == -1)
            {

                $.growl.error({
                    message: 'Select DC Number from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }




            $.get('dc/markDeliveredForm?dc_number=' + dcNumberSelect, function(data){

                if (data != 0){

                    $('#edit_div').html(data);

                }else {
                    $.growl.error({
                        message: 'Please check the DC Number As enterd. ',
                        size: 'large',
                        duration: 5000
                    });

                }

            } );

        });

    });

</script>

<center><h3>
        Mark Delivered
    </h3></center>

<div id="info_status">

<table class="table table-bordered">
    <tr>
        <th>
            Enter DC Number :
        </th>
        <th>
            <div class="ui-widget">
                <input id="dcNumberSelect" placeholder="Enter DC Number">
            </div>
        </th>
        <th>
            <button id="dc_select" class="btn btn-primary"> Select DC </button>
        </th>
    </tr>
</table>
</div>
<div id="edit_div">

</div>