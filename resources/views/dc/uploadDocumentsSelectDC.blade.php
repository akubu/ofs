<script type="application/javascript">
    $(document).ready(function () {


        @if( !count($dc_numbers))
   $(function(){
                    $.growl.error({
                        message: 'No Devices Registered in system. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3>No Devices Registered in system.</h3></center>');
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
                $(this).autocomplete("search", "");
            });
        });

        $('#dc_select').click(function(){

            var dcNumberSelect = $("#dcNumberSelect").val();
            if($.inArray(dcNumberSelect, availableTags) == -1)
            {

                $.growl.error({
                    message: 'Select Device ID from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }

            $.get('dc/documentsForDC?dc_number=' + dcNumberSelect, function(data){

                if (data != 0){

                    $('#upload_div').html(data);

                }else {
                    $.growl.error({
                        message: 'Please check the DC Number As eneterd. ',
                        size: 'large',
                        duration: 5000
                    });

                }

            } );

        });

    });




</script>

<div id="info_status">
<div class="table-responsive">
<table class="table table-striped">
    <tr>
    	<th>&nbsp;</th>
    	<th>&nbsp;</th>
        <th style="width: 146px;vertical-align: middle;">Enter DC Number :</th>
        <th>
            <div class="ui-widget">
                <input class="form-control" id="dcNumberSelect" placeholder="Enter DC Number">
            </div>
        </th>
        <th>
            <button id="dc_select" class="btn btn-primary btn-sm"> Proceed </button>
        </th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
</table>

<div id="upload_div">

</div>
</div>

</div>

