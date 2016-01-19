<script type="application/javascript">

    var options = {
        valueNames: [ 'name', 'born' ]
    };

    var userList = new List('users', options);

    $(document).ready(function(){


        $('.track_runner_button').click(function(){
//            alert('sdfsdf');
            var link = $(this).attr('target');

            var dc_number = $(this).attr('dc_number')

            $('#info').html('current location of ' + dc_number  )

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


<h3 align="center"> All Undelivered DC in System </h3>

<div height="200px">
    <div id="users">
        <input class="search" placeholder="Search" />
        <button class="sort" data-sort="name">
            Sort by Dc Number
        </button>
        <table class="table table-bordered">
            <tbody class="list">



            <tr>
                <th>
                    DC Number
                </th>
                <th>
                    SO Number
                </th>
                <th>
                    Customer
                </th>

                <th>
                    Tracking
                </th>
                <th>
                    Runner Alloted
                </th>

            </tr>
            @foreach($response as $element)
                <tr>
                    <td class="name">
                        {{ $element['dc_info']['dc_number'] }}
                    </td>
                    <td class="born">
                        {{ $element['dc_info']['so_number'] }}
                    </td>
                    <td>
                        {{ $element['so_info']['ship_to_name'] }}
                    </td>
                    <td>
                            @if(  $element['device_gsm_number']  != 0 )

                                <button class="track_runner_button" dc_number=" {{ $element['dc_info']['dc_number'] }}" target="/track/currentDeviceLocation?gsm_number={{ $element['device_gsm_number'] }}" class="btn btn-primary">Track</button>
                        @elseif( $element['dc_info']['is_tracked']  == 0)

                                This DC is not tracked
                        @else
                                Tracking not started yet
                        @endif

                    </td>
                    <td>
                        {{ $element['dc_info']['runner_id'] }}
                    </td>

                </tr>

            @endforeach
            </tbody>
        </table>
    </div>
    <script src="http://listjs.com/no-cdn/list.js"></script>


</div>
<hr>
<p><h3 id="info"></h3></p>
<br>

<div id="map_view" width="80%">
    <iframe id="map_frame" src="" width="80%" height="400px" ></iframe>
</div>