


@include('frontend.header')



<body>

<!--<header class="header" id="header" role="banner">-->
<header>
    <div class="container">

        <div class="col-lg-12  col-md-12 col-sm-12">

            <div class="col-lg-3  col-md-3 col-sm-3">

                <div class="logoWrapper"><a href="http://www.power2sme.com"><img src="http://www.power2sme.com/sites/default/files/logo.png" alt="" style="width:135px"></a></div>
                <!--<div class="logoWrapper">
          <a href="http://www.power2sme.com" title="Home" rel="home" class="header__logo" id="logo"><img src="http://www.power2sme.com/sites/default/files/logo.png" alt="Home" class="header__logo-image"></a>
            </div>-->
            </div>


            <div class="col-lg-9  col-md-9 col-sm-9">
                <!-- 	<div class="topnavWrapper">



               <div id="topnav" class="topnav">

                    <ul>


                        <li style="position: relative;display: block;"><a href="#" rel="nofollow">Login</a>


                                     </li>

                    </ul>

                </div>-->


                <!-- mobile--->
                <div class="topnav-dropdown">
                    <div class="menuBtn"><img src="http://power2sme.com/sites/default/files/img/menu-icon.png" alt="Menu icon"></div></div>
                <div class="clear"></div>
                <!-- end of mobile -->


            </div>
            <div class="mainnavWrapper"><!--mainnavWrapper start-->

                <div class="main-nav">
                    <ul>

                        <li><a href="http://www.smeshops.com">SMEShops</a></li>
                        <li><a href="http://www.power2sme.com/deals/">Raw Material Deals</a></li>
                        <li><a href="http://ssex.power2sme.com/services-exchange">Service Exchange</a></li>
                        <li><a href="http://www.power2sme.com/sme_khabar">SME Khabar</a></li>










                    </ul>

                </div>
                <!-- for mobile -->
                <!-- <div class="main-nav-responsive">
                <div class="main-nav-menuBtn">Menu</div>
                <div id="main-nav-list">
                    <ul>
                       <li><a href="http://www.smeshops.com">SMEShops</a></li>
    <li><a href="http://www.power2sme.com/deals/">Raw Material Deals</a></li>
    <li><a href="http://ssex.power2sme.com/services-exchange">Service Exchange</a></li>
    <li><a href="http://www.power2sme.com/sme_khabar">SME Khabar</a></li>
                    </ul>
                </div>
            </div>
                            -->
            </div>

            <div class="clear"></div>

            <div class="topnav-dropdown-list" id="navigation-list">
                <ul>
                    <li><a href="http://www.smeshops.com">SMEShops</a></li>
                    <li><a href="http://www.power2sme.com/deals/">Raw Material Deals</a></li>
                    <li><a href="http://ssex.power2sme.com/services-exchange">Service Exchange</a></li>
                    <li><a href="http://www.power2sme.com/sme_khabar">SME Khabar</a></li>
                    <!-- <li><a href="/login/?redirect_url=" rel="nofollow">Sign in</a> </li>
                       <li><a href="http://www.power2sme.com/contact-us.aspx">Register</a></li>-->
                </ul>
            </div>

            <!-- end of mobile -->


        </div>
    </div>
    </div></div>



    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // hide the menu when the page load
            $("#navigation-list").hide();
            // when .menuBtn is clicked, do this
            $(".menuBtn").click(function() {
                // open the menu with slide effect
                $("#navigation-list").slideToggle(0);
            });

            $("#main-nav-list").hide();
            // when .menuBtn is clicked, do this
            $(".main-nav-menuBtn").click(function() {
                // open the menu with slide effect
                $("#main-nav-list").slideToggle(300);
            });
        });
    </script>
</header>
<div class="col-lg-12  col-md-12 col-sm-12" style="padding:0;">
    <div class="pageTitileRow bg2 margin-bottom-30"><!--pageTitileRow start-->
        <div class="tCenter f24 fc1">POWER2SME Tracking System</div>
    </div>
</div>

<!-- body section -->

<!-- resgiter section-->

<div class="container">

    <div class="row margin-bottom-20" >
        <div clas="col-md-12">

            <p style="text-align:center; font-size:24px; line-height:40px ; margin-bottom:40px;">Customer No : <span style="color:#09B2F1;">{{ $customer['customer_number'] }}</span><br><span style="font-size:30px; text-transform:capitalize;"> {{ $customer['customer_name'] }}</span></p>

        </div>

    </div>






</div>


@if($customer['invoice_count'] > 0)

        <div class="row" style="background:#EEEEEE; margin:0px !important;">

            <div class="col-md-12" style="margin-top:15px">
                <div class="col-md-3">
                    <p class="lalignment" style="text-align:right; margin-top: 12px;">Select an Invoice for Tracking:</p>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select class="form-control" style="height: 52px;border-radius: 0;" id="invoiceDropDown" onChange="showMap();">
                        {{--*/ $c = 0 /*--}}

                                <option> Select An invoice to start tracking</option>

                        @foreach ($customer['invoices'] as $cust)

                                <option onclick=showIt("invoice{{ $c }}")
                        value="invoice{{ $c }}"> {{ $cust['invoice_number'] }}</option>

                        <?php ++$c; ?>

                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-1" align="center">
                    <p style="    background-color: #09B2F1;
            border-radius: 50%;
            color: #FFFFFF;
            height: 40px;
            width: 40px;
            padding-top: 10px;

        ">OR</p>
                </div>

                <div class="col-md-2">
                    <p class="lalignment" style="text-align:right; margin-top: 12px;">Select another RFQ:</p>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" style="height: 52px;border-radius: 0;" id="rfqDropDown1"
                                onChange="rfqChange1();">
                                        <option value="{{ $customer['rfq'] }}">  {{ $customer['rfq'] }}</option>

                        @foreach ($customer['rfq_all'] as $rfq)

                            <option value="{{ $rfq->{'Wish List No_'} }}"
                                    onclick="rfqSelected('{{ $rfq->{'Wish List No_'} }}');">  {{ $rfq->{'Wish List No_'} }}    </option>


                            @endforeach
                            </select>

                    </div>
                </div>
            </div>
        </div>

    @endif


    @if($customer['invoice_count'] < 1)

        <div class="row" style="background:#EEEEEE; margin:0px !important;">







                <div align="center" class="col-md-8 padding-30c">
                    <p class="lalignment" style="text-align:right; margin-top: 12px;">

                        No invoice is on tracking for entered RFQ, Please select another RFQ number :

                    </p>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <br>
                        <select class="form-control padding-30c" style="height: 52px;border-radius: 0;" id="rfqDropDown2"
                                onChange="rfqChange2();">
                                        <option value="{{ $customer['rfq'] }}">  {{ $customer['rfq'] }}</option>

                        @foreach ($customer['rfq_all'] as $rfq)

                            <option value="{{ $rfq->{'Wish List No_'} }}"
                                    onclick="rfqSelected('{{ $rfq->{'Wish List No_'} }}');">  {{ $rfq->{'Wish List No_'} }}    </option>


                            @endforeach
                            </select>

                    </div>
                </div>
            </div>
        </div>


        @endif



{{--*/ $count = 0 /*--}}

<!-- map -->
@if($customer['invoice_count'] > 0)




    @foreach ($customer['invoices'] as $cinv )

        @if($cinv['delivered'] == "false")



        <div id="invoice{{$count }}" style="display: none; visibility: hidden;">


            <div class="map">


                <iframe id="frameinvoice{{$count }}"
                        src="{{ $cinv['mapurl'] }}"
                        width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>

            </div>


            <div class="row margin-bottom-30" style=" background:#EEEEEE; margin-right: 0px;">

                <div class="col-sm-4">
                    <div class="padding-30c">

                        <h3>

                            Order Requested from Location :


                        </h3>
                        <dl class="week-day ">

                            <dd>{{ $customer['invoices'][$count]['addresses']['start_address'] }}</dd>
                        </dl>
                    </div>

                </div>

                <div class="col-sm-4">

                    <div class="padding-30c" style="background:#09B2F1; color:white;">
                        <h3>

                            Current Location of Order :

                        </h3>
                        <dl class="week-day ">

                            <dd>

                                <div id="current_location_invoice{{$count }}"   >
                                {{ $customer['invoices'][$count]['addresses']['current_address'] }}
                                </div>

                            </dd>
                        </dl>

                    </div>

                </div>

                <div class="col-sm-4">
                    <div class="padding-30c">
                        <h3>

                            Delivery Location :

                        </h3>
                        <dl class="week-day ">

                            <dd>{{ $customer['invoices'][$count]['addresses']['end_address'] }}</dd>
                        </dl>



                    </div>
                </div>

            </div>


            <!-- end of map -->


            <div class="container">

                <div class="row margin-bottom-30">

                    <!--<div class="col-sm-5 hentry">

                            <div class="widget_black-studio-tinymce">
                                <div class="featured-widget padding-30c">



                                </div>
                            </div>



                        </div>--><!-- /.col -->

                    <div class="col-md-10 col-md-offset-1">

                        <!--<h3 class="widget-title margin-top-0">
                            Track your cargo: A123-998-876 (Chiang Mai, TH - Singapore, SG)
                        </h3>

                        -->

                        <h3 class="widget-title">
                            <span class="widget-title__inline">ORDER DETAILS</span>
                        </h3>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th class="align-center">Product</th>
                                    <th class="align-center">Quantity</th>
                                </tr>
                                </thead>
                                <tbody>

                                {{--*/ $countDetail = 1 /*--}}
                        @foreach( $customer['invoices'][$count]['details']  as $detail)

                                <tr>



                                                            <td> <?php echo $countDetail; ?></td>

                                                            <td class="align-center">{{  $detail['material'] }}</td>
                                                            <td class="align-center">{{ $detail['quantity'] }} {{ $detail['units'] }}</td>
                                                        </tr>
                                <?php ++$countDetail; ?>
                                @endforeach

                                <!---                   <tr>
                                                       <td>2.</td>
                                                       <td class="align-center">MS CHANNEL ISMC 300 LOCAL</td>
                                                       <td class="align-center">20.01 MT</td>
                                                   </tr>
                                                   <tr>
                                                       <td>3.</td>
                                                       <td class="align-center">MS CHANNEL 350 LOCAL</td>
                                                       <td class="align-center">70.01 MT</td>
                                                   </tr>
                                                   <tr class="active">
                                                       <td>4.</td>
                                                       <td class="align-center">MS BEAM 350 LOCAL</td>
                                                       <td class="align-center">10.00 MT</td>
                                                   </tr>
                                                   <tr>
                                                       <td>5.</td>
                                                       <td class="align-center">MS ISMB 250 LOCAL</td>
                                                       <td class="align-center">40.00 MT</td>
                                                   </tr>


                                                   ----------->


                                <option>{{ $customer['invoices'][$count]['invoice_number'] }}</option>


                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->

                    </div>
                    <!-- /.col -->


                </div>
                <!-- /.row -->

            </div>

        </div>



        <?php $count++; ?>
        @endif



        @if($cinv['delivered'] == "true")

            <div id="invoice{{$count }}" style="display: none; visibility: hidden;">
            <div class="map">

                <div style="width:100%; height:250px ; background:#FBFBFB;display:table;">

                    <p style="text-align:center; color:#09B2F1; font-size:32px; display:table-cell; vertical-align:middle">Order already delivered on {{ $cinv['deliveredAt'] }}</p>

                </div>



            </div>
</div>
            <?php $count++; ?>
        @endif



        @endforeach

        @endif


                <!-- end of register section -->
        <!-- end of body section -->










        <script type="application/javascript">

            function showMap() {
                var sel = document.getElementById("invoiceDropDown");
                var val = sel.options[sel.selectedIndex].value;

                showIt(val);


            }


        </script>




        <script type="application/javascript">


            var count = {{ $count  }};

            function showIt(thisID) {
                //First hide the currently open div

                for (i = 0; i < count; i++) {
                    document.getElementById("invoice" + i).style.display = 'none';
                }

                localStorage['trackFrame'] = thisID;
                //Then open the div that u want to show

                document.getElementById(thisID).style.display = 'block';
                document.getElementById(thisID).style.visibility = 'visible';


                var iframe = document.getElementById('frame' + thisID);
                iframe.src = iframe.src;


                //Set the ID to the variable

            }
        </script>


        <script type="application/javascript">

            function rfqChange1() {
                var sel = document.getElementById("rfqDropDown1");
                var val = sel.options[sel.selectedIndex].value;
                rfqSelected(val);


            }
            function rfqChange2() {
                var sel = document.getElementById("rfqDropDown2");
                var val = sel.options[sel.selectedIndex].value;
                rfqSelected(val);


            }


        </script>



        <script type="text/javascript">

            function rfqSelected(rfq) {

                window.location = "./" + rfq;
            }


        </script>

<!------
        <script type="text/javascript">
            var auto_refresh = setInterval(
                    function ()
                    {
                        $('#current_location_invoice0').load(""+"").fadeIn("slow");
                    }, 10000); // refresh every 10000 milliseconds$
        </script>
------->


        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXxkYt5TxoLuIxJZSDjSd0v--rrbC-b3s&signed_in=true&callback=initialize()"
                async defer></script>


</body>

@include('frontend.footer');
