<script type="application/javascript">

    var options = {
        valueNames: [ 'name', 'born' ]
    };

    var userList = new List('users', options);
    $(document).ready(function(){
        $('.track_runner_button').click(function(){
//            alert('sdfsdf');
            var link = $(this).attr('target');
            var device_id = $(this).attr('device_id');
            $('#info').html("current location of device : " + device_id)
            $.get(link, function(data){
//                alert(data);
//                $('#map_view').html(data);
                $('#map_frame').attr('src', link);

            });
        });
    });

</script>

<style>

    .list {
        font-family:sans-serif;
    }
    td {
        padding:10px;
        border:solid 1px #eee;
    }

    input {
        border:solid 1px #ccc;
        border-radius: 5px;
        padding:7px 14px;
        margin-bottom:10px
    }
    input:focus {
        outline:none;
        border-color:#aaa;
    }
    .sort {
        padding:8px 30px;
        border-radius: 6px;
        border:none;
        display:inline-block;
        color:#fff;
        text-decoration: none;
        background-color: #28a8e0;
        height:30px;
    }
    .sort:hover {
        text-decoration: none;
        background-color:#1b8aba;
    }
    .sort:focus {
        outline:none;
    }
    .sort:after {
        display:inline-block;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid transparent;
        content:"";
        position: relative;
        top:-10px;
        right:-5px;
    }
    .sort.asc:after {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #fff;
        content:"";
        position: relative;
        top:4px;
        right:-5px;
    }
    .sort.desc:after {
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid #fff;
        content:"";
        position: relative;
        top:-4px;
        right:-5px;
    }



</style>


<h3 align="center"> All Devices in System </h3>

<div>
    <div id="users">
        <input class="search" placeholder="Search" />
        <button class="sort" data-sort="name">
            Sort by Device ID
        </button>
        <table class="table table-bordered">
            <tbody class="list">



        <tr>
            <th>
                Device ID
            </th>
            <th>
                Device Model
            </th>
            <th>
                Device Type
            </th>

            <th>
                GSM Number
            </th>
            <th>
                Runner Alloted
            </th>
            <th>
                Track
            </th>
        </tr>
        @foreach($devices as $device)
            <tr>
                <td class="name">
                    {{ $device['device_id'] }}
                </td>
                <td class="born">
                    {{ $device['device_model'] }}
                </td>
                <td>
                    {{ $device['device_type'] }}
                </td>
                <td>
                    {{ $device['gsm_number'] }}
                </td>
                <td>
                    {{ $device['runner_id'] }}
                </td>
                <td>
                    <button class="track_runner_button" device_id="{{ $device['device_id'] }}" target="/track/currentDeviceLocation?gsm_number={{ $device['gsm_number'] }}" class="btn btn-primary">Track</button>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
</div>
    <script src="http://listjs.com/no-cdn/list.js"></script>


</div>
<br>
<hr>
<p><h3 id="info"></h3></p>
<br>

<div id="map_view" width="80%">
    <iframe id="map_frame" src="" width="80%" height="400px" ></iframe>
</div>