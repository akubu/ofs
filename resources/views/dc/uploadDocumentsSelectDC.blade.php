<script type="application/javascript">
    $(document).ready(function () {


        @if( !count($dc_details))
   $(function () {
                    $.growl.error({
                        message: 'No DC Registered In System. ',
                        size: 'large',
                        duration: 10000
                    });
                    $('#allocate_device').hide();
                });
        $('#info_status').html('<center><h3>No DC Registered In System.</h3></center>');
        @endif

  availableTags = [
            @foreach( $dc_details as $dc_detail)

    "{{ $dc_detail }}" ,
            @endforeach
    ];

        $(function () {

            $("#dcNumberSelect").autocomplete({
                source: function (request, response) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i");
                    response($.grep(availableTags, function (value) {
                        return matcher.test(value.toUpperCase());
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function () {
                $(this).autocomplete("search", "");
            });
        });

        $('#dc_select').click(function () {


            $('#upload_div').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

            var dcNumberSelectCheck = $("#dcNumberSelect").val();
            var dcNumberSelect = $("#dcNumberSelect").val();

//            index_dc = $('#dcNumberSelect').val().lastIndexOf("| ");
////            alert(index_dc);
//            dcNumberSelect_temp = $('#dcNumberSelect').val().substring(index_dc+2);
////            alert(dcNumberSelect_temp);
//            var dcNumberSelect = (dcNumberSelect_temp.toUpperCase()).replace("+","").trim();





            if ($.inArray(dcNumberSelectCheck, availableTags) == -1) {

                $.growl.error({
                    message: 'Select DC  from dropdown. ',
                    size: 'large',
                    duration: 10000
                });
                return false;
            }

            $.get('dc/documentsForDC?dc_number=' + dcNumberSelect, function (data) {

                if (data != 0) {

                    $('#upload_div').html(data);

                } else {
                    $.growl.error({
                        message: 'Please check the DC Number As eneterd. ',
                        size: 'large',
                        duration: 5000
                    });

                }

            });

        });

    });


</script>

<div id="info_status">
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th style="width: 146px;vertical-align: middle;">Select DC Number:</th>
                <th>
                    <div class="ui-widget">
                        <input class="form-control" id="dcNumberSelect" placeholder="Enter DC Number">
                    </div>
                </th>
                <th>
                    <button id="dc_select" class="btn btn-primary btn-sm"> Proceed</button>
                </th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
        </table>

        <div id="upload_div">

        </div>
    </div>

</div>

