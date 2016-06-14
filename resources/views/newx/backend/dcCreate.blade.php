
<!DOCTYPE html>
<html>
<head>
    <title>Manage DC </title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">

</head>
<body>

<div class="top_bar">

    <div class="container-fluid">

        <div class="row">

            <div class="col-md-3">

                <div class="clearfix">

                    <div class="logo">
                        <a href="javascript:void(0)"><img src="img/ofs_logo.png" alt="OFS"></a>
                    </div>

                </div>

            </div>

            <div class="col-md-9 text-right">

                <ul class="list-inline clearfix top_links">
                    {{--<li class="active"><a href="javascript:void(0)">RFQ's</a></li>--}}
                    {{--<li><a href="javascript:void(0)">Pending SO</a></li>--}}
                    {{--<li><a href="javascript:void(0)">MRN</a></li>--}}
                    <li class="active"><a href="dc_manage">DC</a></li>
                    {{--<li><a href="javascript:void(0)">Dispatch</a></li>--}}
                    <li><a href="javascript:void(0)">Update Status</a></li>
                    <li><a href="javascript:void(0)">Help</a></li>
                    <li> <a class="logout" href="javascript:void(0)"><i class="fa fa-power-off" aria-hidden="true"></i> LOGOUT</a></li>

                </ul>



            </div>

        </div>

    </div>
</div>

<div class="container-fluid">



    <div class="row">



        <div class="col-md-1 no_padding">

            <div class="leftBar">

                <ul>
                    <li class="active"><a href="javascript:void(0)"><img src="img/home.png"><br>Home</a></li>
                    <li><a href="javascript:void(0)"><img src="img/tracking.png"><br>Tracking</a></li>
                    {{--<li><a href="javascript:void(0)"><img src="img/warehouse.png"><br>Warehouse</a></li>--}}
                    <li><a href="javascript:void(0)"><img src="img/documents.png"><br>Documents</a></li>
                    <li>&nbsp;</li>
                </ul>

            </div>

        </div>

        <div class="col-md-11 no_padding">
            <div class="col-md-12 no_padding">

                <div class="add_bar">
                    <a class="add_sme_link" href="javascript:void(0)"><i class="fa fa-dashboard"></i> Create New DC</a>
                    <span style="float: right; padding-right: 15px">
                        {{--<button id="generate_dc" class="btn btn-md light-red" style="width: auto">Print DC</button>--}}
                    </span>
                    <span style="float: right; padding-right: 10px">
                        {{--<button id="generate_dc" class="btn btn-md light-red " style="width: auto">Cancel DC</button>--}}
                    </span>
                    <span style="float: right; padding-right: 10px">
                        <a href="/" >
                            {{--<button id="generate_dc" class="btn btn-md blue" style="width: auto" >Create DC</button>--}}
                        </a>
                    </span>
                </div>

            </div>

            {{--<div class="searchBar">--}}

            {{--<div class="row">--}}

            {{--<div class="col-md-9">--}}

            {{--<div class="row searchRow">--}}

            {{--<div class="col-md-6 col-sm-6 col-xs-6 no_padding_right">--}}

            {{--<div class="form-group icon">--}}
            {{--<i class="fa fa-search"></i>--}}
            {{--<input type="text" name="search" placeholder="Search RFQ here..." class="form-control">--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-md-6 col-sm-6 col-xs-6 no_padding_right">--}}
            {{--<button class="btn btn-md red">SEARCH</button>--}}
            {{--</div>--}}



            {{--</div>--}}

            {{--</div>--}}

            {{--<div class="col-md-3 btns text-right">--}}


            {{--</div>--}}

            {{--</div>--}}

            {{--</div>--}}



            {{--<table class="table">--}}

            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th >RFQ Number</th>--}}
            {{--<th >Customer Name</th>--}}
            {{--<th >Won Date</th>--}}
            {{--<th >Delivery Date</th>--}}
            {{--<th >RFQ Status</th>--}}
            {{--<th >SO Status</th>--}}

            {{--</tr>--}}
            {{--</thead>--}}

            {{--<tbody>--}}
            {{--<tr>--}}
            {{--<td >WI000675</td>--}}
            {{--<td >ABC Company</td>--}}
            {{--<td >12/05/2016</td>--}}
            {{--<td >20/05/2016</td>--}}
            {{--<td >RFQ Status</td>--}}
            {{--<td >SO Status</td>--}}

            {{--</tr>--}}
            {{--<tr>--}}
            {{--<td >WI000675</td>--}}
            {{--<td >ABC Company</td>--}}
            {{--<td >12/05/2016</td>--}}
            {{--<td >20/05/2016</td>--}}
            {{--<td >RFQ Status</td>--}}
            {{--<td >SO Status</td>--}}


            {{--</tr>--}}
            {{--<tr>--}}
            {{--<td >WI000675</td>--}}
            {{--<td >ABC Company</td>--}}
            {{--<td >12/05/2016</td>--}}
            {{--<td >20/05/2016</td>--}}
            {{--<td >RFQ Status</td>--}}
            {{--<td >SO Status</td>--}}


            {{--</tr>--}}
            {{--</tbody>--}}

            {{--</table>--}}



        </div>

    </div>

</div>

<footer class="dashboard_footer">
    <div class="poweredby text-center">Powered by POWER2SME</div>
</footer>

<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/slidebars.js"></script>
<script src="js/main.js"></script>

</body>
</html>