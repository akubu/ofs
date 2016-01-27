<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
<a class="a_custom" href="http://192.168.1.227:8000/test2">test</a>
<div id="boo">
    <script >

        $(document).ready(function(){

            $(function(){
                if($('#player_div').html().length < 5)
                {
                    $.get('/test3', function(data){
                        $('#player_div').html(data);
                    });
                }
            });

            $('a').click(function () {

                var url = $(this).attr('href');
                var title = $(this).html();
                $.get(url, function (data) {
                    $('#boo').html(data);
                });
                alert(url);
                history.pushState( {url : document.location.href } , title, location.href);

                return false;
            });

            window.onpopstate = function(event) {
                alert("location: " + document.location + ", state: " + JSON.stringify(event.state));
                alert(event.state.url);
            };
        });


    </script>

</div>
<div id="persistent">this is old</div>
<div id="player_div" ></div>
</body>
</html>