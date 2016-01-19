<script type="application/javascript">
    $(document).ready(function () {


        $(function () {
            var availableTags = [
                @foreach( $response as $dc)

        "{{ $dc['dc_info']['dc_number'] }}",
                @endforeach
        ];
            $("#dcNumberSelect").autocomplete({
                source: availableTags
            });
        });

        $('#dc_select').click(function(){

            var dcNumberSelect = $("#dcNumberSelect").val();

            $.get('dc/updateForm?dc_number=' + dcNumberSelect, function(data){

                if (data != 0){

                    $('#edit_div').html(data);

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

<center><h3>Update DC</h3></center>

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

<div id="edit_div">

</div>