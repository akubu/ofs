<div>
<nav class="navbar ">

    <button    id="dc" style="background-color: #0ab2f1; color: #E5E5E5">DC created every day</button>
    <button    id="document" style="background-color: #0ab2f1; color: #E5E5E5">Documents uploaded every day</button>
    <button    id="so" style="background-color: #0ab2f1; color: #E5E5E5">SO processed every day</button>
</nav>
   <div id="graphview">

   </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.js"></script>

<script>
$('#dc').click(function () {

$('#graphview').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

$.get("/reports/dc", function (data, status) {

$('#graphview').html(data);


});

return true;
});
</script>


<script>
    $('#document').click(function () {

        $('#graphview').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/reports/document", function (data, status) {

            $('#graphview').html(data);


        });

        return true;
    });
</script>

<script>
    $('#so').click(function () {

        $('#graphview').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/reports/so", function (data, status) {

            $('#graphview').html(data);


        });

        return true;
    });
</script>



