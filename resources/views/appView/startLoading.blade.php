<script type="application/javascript">

    $(document).ready(function(){

        $('#attach').click(function(){

            var truck_select = $('#truck_select').val();
            var device_number = $('#device_select').val();

            if(!truck_select || !device_number)
            {
                $.growl.error({
                    message: 'Please select Truck and Device.',
                    size: 'large',
                    duration: 10000
                });

                return false;
            }

            var txt;
            var r = confirm('do you want to attach ' +truck_select + " with " + device_number);
            if (r == true) {


                $.get("/webApp/track", function(data){

                    $('#body_div').html(data);

                });



            } else {

                        return false;

            }


        }) ;
    });

</script>

<center>
<div class="row">
    <div class="col-sm-2 centered">
        <h5><b>Select Truck Number </b></h5>
    </div>
</div>
    <div class="row">
        <div class="col-sm-4" >
            <select style="width: 100%" id="truck_select">
                <option value="" > Select A Truck</option>
                @foreach( $truck_numbers as $truck_number)

                    <option value="{{ $truck_number }}"> {{ $truck_number }} </option>
                @endforeach

            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-2 centered">
            <h5><b>Select Truck Number </b></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" >
            <select style="width: 100%" id="device_select">
                <option value="" > Select A Device</option>
                @foreach( $device_numbers as $device_number)

                    <option value="{{ $device_number }}"> {{ $device_number }} </option>
                @endforeach

            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4">
            <button id="attach" >Attach Device</button>
        </div>
    </div>

</center>
<script src="/js/webNav.js"></script>

