

<script type="application/javascript">
    $(document).ready(function () {

         availableTags = [
            @foreach( $so_numbers as $so_number)

    "{{ $so_number }}",
            @endforeach
    ];

        $(function () {

            $("#so_number").autocomplete({
                source: availableTags
            });
        });


        $('#so_entered').click(function () {
            var so_number = $.trim($('#so_number').val());
            $.post("so/checkExistence", {so_number: so_number}, function (result) {
//                alert(result);
                if (result == 1) {
                    $.post("so/show", {so_number: so_number}, function (result) {
                        $("#so_details").html(result);
//                        alert(result);
//                        alert("editable set");
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
                }
            });
        });



    });

</script>



<div id="enter_so">
    <div class="row">

        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label class="control-label col-sm-2">SO Number:</label>

                <div class="col-sm-3">
                    <input type="text" class="form-control" id="so_number" size="40" placeholder="Enter So Number">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <button id="so_entered" class="btn btn-default">Start Assigning</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="so_details" class="row"></div>
{{--<div class="loading">Loading&#8230;</div>--}}

<!----- all dc ----------->
<br><br><br><br><br>




