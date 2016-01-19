
<?php
include_once './config.php';
session_start();
if (isset($_SESSION['username']) and $_SESSION['refreshed']=="no" )
{  $_SESSION['started'] = time();
    $ses_id = session_id();
    setcookie($ses_id, $_SESSION['username'], time() + (60 * 1), "/");
	
	$username = $_SESSION["username"];
	
	///  DB layer
	
	$conn = mysqli_connect($SKUserver, $SKUusername, $SKUpassword, "p2s");
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT  FROM p2s.cscart_rfq_lines_with_sku;";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
       // print_r($row);
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
    
 ?>
 
<!doctype html>

<html>
  
  <head>
    <title>Power2SME synonym Registration System </title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
     <script type='text/javascript' src='http://code.jquery.com/jquery-1.4.3.min.js'></script>
     <script>
    var $ = jQuery.noConflict();
</script>
     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js" type="text/javascript"></script>
    
    <script>
    var jq20 = jQuery.noConflict();
</script>
    
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" type="text/javascript"></script>
    <style type="text/css">
     
      <script>
    var $_143 = $.noConflict(true);
</script>
  
     
    
    * { font-family:Arial; }
h2 { padding:0 0 5px 5px; }
h2 a { color: #224f99; }
a { color:#999; text-decoration: none; }
a:hover { color:#802727; }
p { padding:0 0 5px 0; }

input { padding:5px; border:1px solid #999; border-radius:4px; -moz-border-radius:4px; -web-kit-border-radius:4px; -khtml-border-radius:4px; }
 
    
    
      /* Space out content a bit */
      body {
        padding-top: 20px;
        padding-bottom: 20px;
      }
      /* Everything but the jumbotron gets side spacing for mobile first views */
      .header, .marketing, .footer {
        padding-left: 15px;
        padding-right: 15px;
      }
      /* Custom page header */
      .header {
        border-bottom: 1px solid #e5e5e5;
      }
      /* Make the masthead heading the same height as the navigation */
      .header h3 {
        margin-top: 0;
        margin-bottom: 0;
        line-height: 40px;
        padding-bottom: 19px;
      }
      /* Custom page footer */
      .footer {
        padding-top: 19px;
        color: #777;
        border-top: 1px solid #e5e5e5;
      }
      /* Customize container */
      @media(min-width: 768px) {
        .container {
          max-width: 730px;
        }
      }
      .container-narrow > hr {
        margin: 30px 0;
      }
      /* Main marketing message and sign up button */
      .jumbotron {
        text-align: center;
        border-bottom: 1px solid #e5e5e5;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }
      /* Supporting marketing content */
      .marketing {
        margin: 40px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
      /* Responsive: Portrait tablets and up */
      @media screen and(min-width: 768px) {
        /* Remove the padding we set earlier */
        .header, .marketing, .footer {
          padding-left: 0;
          padding-right: 0;
        }
        /* Space out the masthead */
        .header {
          margin-bottom: 30px;
        }
        /* Remove the bottom border on the jumbotron for visual effect */
        .jumbotron {
          border-bottom: 0;
        }
      }
    </style>
    
    

    
    
  </head>
  
  <body>
  	
  	<script type='text/javascript'>//<![CDATA[ 
$(window).ready(function(){
$(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        
        
        $('#addScnt').live('click', function() {
        	 text = document.forms['mainForm'].elements['sel2'].value;
        	
                $('<p><label for="similarskus"><input type="text" id="similarsku" size="65" name="similarsku[]" value="' + text +'" placeholder="Input Value" /></label> <a href="#" id="remScnt">Remove</a></p>').appendTo(scntDiv);
                i++;
                return false;
        });
        
        $('#remScnt').live('click', function() { 
                if( i > 2 ) {
                        $(this).parents('p').remove();
                        i--;
                }
                return false;
        });
});

});//]]>  



</script>


  	
  	
  	
  	
    <div class="container">
      <div class="header">
        <ul class="nav nav-pills pull-right">
          <li>
            <?php echo $username; ?>&nbsp; &nbsp;<a href="#">LogOut</a>
          </li>
        </ul>
        <h3 class="text-muted">Power2SME</h3>
      </div>
      <div class="jumbotron">
        <h1>Synonym Database<br></h1>
        <p class="lead">Please select a SKU from the drop-down menu on the top and enter synonyms corresponding to it in the text-box and add similar SKUs to the bottom list.<br></p>
        <p></p>
      </div>
      
      <form action="./registerSynonyms.php" method="post" id="mainForm" class="mainForm">
      
      <div class="row marketing">
        <div class="col-lg-6">
        	
        	
        	<h4>Select an SKU from the list below<br></h4>
        	<br />
  <input type="text" name="sku" class="form-control"id="default" list="languages" placeholder="e.g. JavaScript">
        	<datalist id="languages">
    <option value="HTML">
    <option value="CSS">
    <option value="JavaScript">
    <option value="Java">
    <option value="Ruby">
    <option value="PHP">
    <option value="Go">
    <option value="Erlang">
    <option value="Python">
    <option value="C">
    <option value="C#">
    <option value="C++">
  </datalist>
        	
       <!-------- 	
          <h4>Select an SKU from the list below<br></h4>
          <select class="form-control" name="SKU">
            <option value="1op">Option 1</option>
            <option value="2op">Option 2</option>
            <option value="3op">Option 3</option>
          </select>
          ---->
          
          <hr>
          
          <h3>Enter a text term below, eg: MS, HR, CR, etc<br></h3>
          <input class="form-control" type="text" name="abbr">
          <hr>
          <br/>
          
          <h4>Enter synonyms corresponding to the selected SKU. (&nbsp; Words , Phrases and any text that describes the SKU). Add coma(,) to saparate words and phrases.<br></h4>
          <textarea id="synonyms" placeholder="Enter text here." name="synonyms" rows="7" class="form-control" ></textarea>
          <hr>
          <h4>Select SKU's with similar description ( do not consider dimentions )<br></h4>
          <select class="form-control" name="sel2" id="sel2">
            <option id="addScnt"  value="dfd">Option 1</option>
            <option id="addScnt"  value="ttd">Option 2</option>
            <option id="addScnt"  value="333">Option 3</option>
          </select><br>
          
          
<div id="p_scents">
   
   
    
</div>
  
  <br />
  <input type="submit" value="SUBMIT"  class="btn pull-left btn-primary btn-block"/> 
  
          
        </div>
      </div>
      <div class="footer">
        <p></p>
      </div>
    </div>
    <!-- /container -->
    </form>
    
    


        
    
  </body>

</html>


 <?php   
}
else {
	$url = "./login.php"; 
   die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
 }
?>


