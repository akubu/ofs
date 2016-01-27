<script >


    //    $(document).ready(function(){
    //        function change(state) {
    //
    //        }
    //
    //        $(window).on("popstate", function(e) {
    //
    //            alert(e.originalEvent.state);
    //            change(e.originalEvent.state);
    //
    //        });
    //
    //        $('a').click(function() {
    //            alert('test')
    //            var url = $(this).attr('href');
    //            alert(url);
    //
    //
    //            $.get(url, function(data){
    //                alert(data);
    //                $('#boo').html(data);
    //            });
    //
    //
    //            history.pushState({ url: "/page2" }, "/page2", "page 2");
    //
    //            return false;
    //        });
    //
    //        (function(original) {
    //            history.pushState = function(state) {
    //                change(state);
    //                return original.apply(this, arguments);
    //            };
    //        })(history.pushState);
    //
    //    })


    $(document).ready(function(){

        $('a').click(function () {

            var url = $(this).attr('href');
            var title = $(this).html();
            $.get(url, function (data) {
                $('#boo').html(data);
            });
            alert("going to" +  url);
            history.pushState( {url : document.location.href } , title, url);

            return false;
        });


//        $(window).on("popstate", function(e) {
//            alert('here');
//
//            alert(e.state);
//            return false;
//        });

        window.onpopstate = function(event) {
            alert("location: " + document.location + ", state: " + JSON.stringify(event.state));
            alert("loading " + event.state.url);

        };
    });


</script>
<a class="a_custom" href="http://192.168.1.227:8000/test">test</a>