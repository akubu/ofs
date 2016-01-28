<script type="application/javascript" >



    @if( !count($response))
        $(function(){
                $.growl.error({
                    message: 'No Runner registered Yet,. ',
                    size: 'large',
                    duration: 10000
                });
                $('#allocate_device').hide();
            });
    $('#info_status').html('<center><h3>NO Runner Registered yet</h3></center>');
            @endif

    var options = {
        valueNames: [ 'name', 'born' ]
    };

    var userList = new List('users', options);

    $(document).ready(function(){
        $('.track_runner_button').click(function(){
//            alert('sdfsdf');
           var link = $(this).attr('target');
            var runner_name = $(this).attr('runner_name');
            $('#info').html("Current location of " + runner_name);

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

<h3 align="center"> All runners in System </h3>
<div id="info_status">
<div>
    <div id="users">
        <input class="search" placeholder="Search" />
        <button class="sort" data-sort="name">
            Sort by name
        </button>
        <div height="200px" style="overflow-y: scroll; height:200px;">
    <table class="table table-bordered">
        <tbody class="list">

        @foreach($response as $runner)
            <tr>
                <td class="name">
                    {{ $runner['runner_info']['runner_name'] }}
                </td>
                <td class="born">
                    {{ $runner['runner_info']['vtiger_id'] }}
                </td>
                <td>
                    {{ $runner['runner_info']['runner_contact_number_1'] }}
                </td>
                <td>
                    {{ $runner['runner_info']['runner_contact_number_2'] }}
                </td>
                <td>
                    {{ $runner['current_address'] }}
                </td>
                <th>
                    <button class="track_runner_button" runner_name="{{ $runner['runner_info']['runner_name'] }} - {{ $runner['runner_info']['vtiger_id'] }}" target="/track/currentDeviceLocation?gsm_number={{ $runner['runner_info']['runner_contact_number_1'] }}" class="btn btn-primary">Track</button>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
            </div>
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

</div>