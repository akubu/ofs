

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
    <div class="pageTitileRow bg2"><!--pageTitileRow start-->
        <div class="tCenter f24 fc1">POWER2SME Tracking System</div>
    </div>
</div>



<!-- body section -->
<div>

    <!-- resgiter section-->

    <div class="image-container set-full-height" style="background-image: url('{{ $baseURL }}/ls/backnew.jpg'); min-height:150px;   margin-top: 6px;">
        <!--   Creative Tim Branding   -->
        @if($error == "yes")
            <div class="alert alert-danger" align="center"> PAN or RFQ invalid, Re-Enter or please contact power2SME
            </div>
            @endif



        <!--   Big container   -->
        <div class="col-md-12">
            <div style="margin-top:140px;" class="side-text1">
                <h5>locate your shipment <span style="font-size:105px; font-style:italic;">here</span><img src="{{ $baseURL }}/ls/arrow.png" class="hidden-xs" alt="arrow"></h5>

                <form class="track-search" action="#">

                    <div class="col-md-4 padding-left-0">
                        <input id="pan"  name="searchtext" type="text" value="" placeholder="Enter PAN number..">
                    </div>

                    <div class="col-md-2 padding-left-0">
                        <input id="rfq"  name="searchtext" type="text" value="" placeholder="Enter RFQ Number..">
                    </div>

                    <div class="col-md-1 padding-left-0">
                        <button type="button" class="btn btn-info radius-0" onclick="trackIt();">TRACK</button>
                    </div>

                </form>


            </div>
        </div>

        <!--  big container -->




    </div>

    <!-- end of register section -->

</div>







<!-- end of body section -->

<script>
  function trackIt()
  {

    pan=document.getElementById("pan").value;

    rfq = document.getElementById("rfq").value;

    pan = pan.toUpperCase();
    rfq = rfq.toUpperCase();

    if (!pan)
    {
      alert('Please enter PAN number ');
    }

    else if (!rfq)
    {
      alert('Please enter RFQ number ');
    }
    else if ( pan.length < 10)
    {
      alert("Incorrect PAN number lenght")  ;
    }

   else if (pan && rfq)
    {
      rfq = rfq.replace("/", "");
      rfq = rfq.replace("\\", "");
      pan = pan.replace("/", "");
      pan = pan.replace("\\", "");

      window.location="{{ $baseURL }}/customer/"+pan+"/"+rfq;
    }




  }

</script>



@include('frontend.footer')



  </body>

</html>