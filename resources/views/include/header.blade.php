 <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" id="home" href="/"><font color="#FFFFFF" style="font-size: 22px;">Tracking System</font></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" > Assignments &nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#" id="new_assignment_nav">New Assignment</a></li>
                <li><a href="#" id="current_assignment_nav">Current Assignments</a></li>
                <li><a href="#" id="update_dc_nav">Update DC</a></li>
                <li><a href="#" id="mark_delivered_nav">Mark Delivered</a></li>
              </ul>
            </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Tracking centre <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#" id="track_shipment_nav">Track Shipment-DC</a></li>
                      <li><a href="#" id="track_runner_nav">Track runner</a></li>
                      <li><a href="#" id="track_device">Track Device</a></li>
                  </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Runner Central <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#" id="add_runner_nav">Add Runner</a></li>
                      {{--<li><a href="#" id="update_runner_nav">Update Runner</a></li>--}}
                      <li><a href="#" id="delete_runner_nav">Delete Runner</a></li>
                      <li><a href="#" id="all_runner_nav">All Runners</a></li>
                  </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Device <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#" id="new_device_nav">New Device</a></li>
                      <li><a href="#" id="allocate_device_to_runner_nav">Allocate to Runner</a></li>
                      <li><a href="#" id="recover_device_nav">Recover from runner</a></li>
                      <li><a href="#" id="register_device_loss_nav">Register Loss</a></li>
                      <li><a href="#" id="all_device_nav">All Devices</a></li>

                  </ul>
              </li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Document management <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#" id="upload_document_nav">Manage Documents</a></li>
                      {{--<li><a href="#" id="view_document_nav">View Documents</a></li>--}}
                  </ul>
              </li>

              {{--<li class="dropdown">--}}
                  {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Notifications <span class="caret"></span></a>--}}
                  {{--<ul class="dropdown-menu">--}}
                      {{--<li><a href="#" id="urgent_notifications_nav"> Urgent </a></li>--}}
                      {{--<li><a href="#" id="auto_notifications_nav">Auto Notifications</a></li>--}}
                  {{--</ul>--}}
              {{--</li>--}}

              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Help <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                      <li><a href="#" id="ask_question_nav"> Ask Question </a></li>

                  </ul>
              </li>
				
                 <li class="dropdown">
                  <a style="padding:15px 22px;"><i class="fa fa-user"></i> <?php
                        session_start();
                    if(isset($_SESSION["vt_user"]) ){

                        echo "    ".$_SESSION["vt_user"];
                    }else{

                                      die('<script type="text/javascript">window.location.href="/auth/login" </script>');
                          }

                  ?></a>
                
              </li>
             
              <li class="dropdown" style="border:1px solid #FFFFFF; border-radius:3px; margin-top: 8px;">
            
                  <a href="/auth/logout" style="padding-top: 5px;
    padding-bottom: 5px;" class=""><i class="fa fa-power-off"></i> <strong>Logout</strong></a>
              
              </li>


          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>
