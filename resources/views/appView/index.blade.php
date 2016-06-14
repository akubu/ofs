<html>

<title>

</title>
<head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery.growl.js') }}"></script>

</head>

<body>
<center>
    <div class="row">
        <div class="col-sm-2 left">
            <a href="/webApp" >Home</a>
        </div>
        <div class="col-sm-2 right">
            <?php session_start(); echo $_SESSION['vt_user']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <h3>
                Tracking System (Runner App)
            </h3>
        </div>
    </div>
    <br>


    <div id="body_div">

        <div class="row">
            <div class="col-sm-4">
                <button id="start_loading" class="btn btn-primary" style="width: 100%">Start Loading</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <button id="dispatch" class="btn btn-primary" style="width: 100%">Dispatch</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <button id="deliver" class="btn btn-primary" style="width: 100%">Deliver</button>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <button id="track" class="btn btn-primary" style="width: 100%">Track</button>
            </div>
        </div>
</center>
<script src="/js/webNav.js"></script>

</div>

</body>



</html>