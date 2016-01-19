
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Power2SME, Special, Admin, Dashboard">

    <title>Power2SME - Proprietary System</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="/css/login.css" rel="stylesheet">
    <link href="/css/jquery.growl.css" rel="stylesheet">
    <link href="/css/login-responsive.css" rel="stylesheet">

  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">

		      <form class="form-login" action="/auth/vtiger/user" method="post">

		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
                	<p align="center"><img src="/images/logo.png" width="150px"></p>
		            <input type="text" class="form-control" placeholder="User ID" name="username" autofocus>
		            <br>
		            <input type="password" class="form-control" placeholder="Password" name="password">
					{!! csrf_field() !!}
		            <label class="checkbox">
		                <span class="pull-right">
		                    <!-- <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a> -->
		                </span>
		            </label>
		            <button id="login" class="btn btn-theme btn-block" href="dashboard.jsp" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		            <div class="hide" style="text-align: center;"><img src="/images/ajax-loader.gif" /></div>
		            <hr>
		            
		            <div class="registration">
		                <!-- Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a> -->
		            </div>
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-1.11.3.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/jquery.growl.js"></script>
    <script src="/js/auth.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("/images/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
