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


    $(function () {
            var availableTags = [
                @foreach( $dc_numbers as $dc_number)

        "{{ $dc_number }}",
                @endforeach
        ];
            $("#dcNumberSelect").autocomplete({
                source: availableTags
            });
        });

        $('#dc_select').click(function(){

            var dcNumberSelect = $("#dcNumberSelect").val();

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
            <button id="dc_select" class="btn btn-primary"> Proceed </button>
        </th>
    </tr>
</table>

<div id="upload_div">

</div>

</div>

