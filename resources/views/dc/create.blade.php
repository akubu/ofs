

<script type="application/javascript">
    $(document).ready(function () {

         availableTags = [
            @foreach( $so_numbers as $so_number)

    "{{ $so_number }}",
            @endforeach
    ];

        $(function () {
            $("#so_number").autocomplete({
                source: function( request, response ) {
                    var matcher = new RegExp($.trim(request.term).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), "i" );
                    response($.grep(availableTags, function(value) {
                        return matcher.test( value.toUpperCase() );
                    }));
                },
                minLength: 0,
                scroll: true
            }).focus(function() {
                $(this).autocomplete("search", $('#so_number').val());
            })
        });


        $('#so_entered').click(function () {

            $('#so_entered').addClass("hide");
            $('#so_entered').next().removeClass('hide');
            index_so = $('#so_number').val().lastIndexOf("| ");
            so_number_temp = $('#so_number').val().substring(index_so+2);
            var so_number = (so_number_temp.toUpperCase()).replace("+","").trim();



            $.post("so/checkExistence", {so_number: so_number}, function (result) {
                if (result == 1) {
                    $('#so_number').val(so_number);
                    $.post("so/show", {so_number: so_number}, function (result) {
                        $("#so_details").html(result);
                        var value = $('#so_number').attr('readonly');
                        if (value == 'false') {
                            $('#so_number').attr('readonly', 'true');
                        }
                        else {
                            $('#so_number').attr('readonly', 'false');
                        }
                        $('#enter_so').hide();
                    });
                }
                else {
                    $.growl.error({
                        message: 'Incorrect SO number. Please Enter Correct SO number.',
                        size: 'large',
                        duration: 10000
                    });

                    $('#so_entered').removeClass("hide");
                    $('#so_entered').next().addClass('hide');
                }
            });
        });
    });

</script>


<div id="enter_so">
<table class="table table-striped">
    <tr>
    	<th>&nbsp;</th>
    	<th>&nbsp;</th>
        <th style="width: 146px;vertical-align: middle;">Select SO :</th>
        <th>
            <input type="text" class="form-control" id="so_number" size="40" placeholder="Enter SO Number">
        </th>
        <th>
         <button id="so_entered" class="btn btn-primary btn-sm"> Create DC </button>
         <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>
        </th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
</table>

</div>

<div id="so_details" class="row"></div>
<br><br><br><br><br>




