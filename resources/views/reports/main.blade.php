{{--<h1 id="qunit-header">QUnit Test Suite</h1>--}}
{{--<h2 id="qunit-banner"></h2>--}}
{{--<div id="qunit-testrunner-toolbar"></div>--}}
{{--<h2 id="qunit-userAgent"></h2>--}}
{{--<ol id="qunit-tests"></ol>--}}

<div>
    <nav class="navbar ">
    <button    name="dc" id="dc" style="background-color: #0ab2f1; color: #E5E5E5">DC created every day</button>
    <button    name="document" id="document" style="background-color: #0ab2f1; color: #E5E5E5">Documents uploaded every day</button>
    <button    name="so" id="so" style="background-color: #0ab2f1; color: #E5E5E5">SO processed every day</button>
    </nav>

   <div id="graphview">

   </div>

</div>

{{--<script>--}}
    {{--QUnit.test('reports',function (assert) {--}}
        {{--assert.equal(,'clicked DC')--}}
    {{--})--}}
{{--</script>--}}
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

<script>
    $('#random').click(function () {

        $('#graphview').html('<center><img src="./img/loading.gif" height="20%" width="20%"> <br> Loading ... </center>');

        $.get("/reports/random", function (data, status) {

            $('#graphview').html(data);
        });
        return true;
    });
</script>
