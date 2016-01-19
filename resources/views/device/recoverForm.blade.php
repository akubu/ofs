<script type="application/javascript">

    $(document).ready(function(){


        $(function () {
            var availableTags = [
                @foreach( $devices as $device)

        "{{ $device }}",
                @endforeach
        ];
            $("#device_id").autocomplete({
                source: availableTags
            });
        });



        $('#recover').click(function(){

            var device_id = $('#device_id').val();
            if ( device_id.length >2)
            {
                $.post("/device/recover", { device_id : device_id}, function(result) {

                   if(result == 1)
                   {
                       $.growl.notice({
                           message: ' device added to pool.',
                           size: 'large',
                           duration: 10000
                       });

                   }else{
                       $.growl.error({
                           message: 'Check device ID.',
                           size: 'large',
                           duration: 10000
                       });

                   }

                });

            }else{
                $.growl.error({
                    message: 'Check device ID.',
                    size: 'large',
                    duration: 10000
                });
            }

        });

    });

</script>

<div>

    <center><h3>Recover A Device From a Runner</h3></center>

    <table class="table-bordered table">
        <tr>
            <th>
                Device ID
            </th>
            <th>
                <input class="form-control" type="text" name="device_id" id="device_id" placeholder="Enter Device ID"/>
            </th>
            <th>
                <button class="form-control btn-primary btn" id="recover" >Recover Device</button>
            </th>
        </tr>
    </table>
</div>