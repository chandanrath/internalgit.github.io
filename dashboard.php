<?php
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);session_start();

if(($_REQUEST['action']==""))
{
	session_destroy();
	header("Location:index.php");
	exit;		
}

if(isset($_SESSION) && $_SESSION['role']!="")
{	
	include_once 'includes/connect.php';
	include_once 'includes/define.php';
	include_once 'includes/functions.php';
	include_once 'includes/paging_class.php';
	
}
else
{
	session_destroy();
	header("Location:index.php");
	exit;	
}

$ipaddress = getIPaddress();		// get user ip address GIEGMPL//	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_detail = IPDetails($ipaddress);
$ISPurl = ISPDetails($ipaddress);
$ISP = (!empty($ISPurl['isp'])?$ISPurl['isp']:"") ;
// user log //
$message = "page click to ".$_GET['action'];
UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);


?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Champions | <?=(!empty($_GET['action'])?ucwords($_GET['action']):"Dashboard");?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php include_once 'includes/link.php'; ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>
<body>
<div class="bg">
<div class="container">
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12">
<div class="d-flex justify-content-center">
 
 <a href="<?=BASE_URL?>"><span><img src="images/logo.png" title="Champions" alt="Champions"/></span>   </a>
 
</div> 

<div onclick="myFunction()" class="profile-area popup">

<span class="profile-text">Welcome <?php echo $_SESSION['name'];?> </span>

<span class="profile-icon">
<img src="images/profile-icon.svg"/></span>
<?php include_once 'includes/menu.php';?>
</div>
</div>

</div>
<?php 
 	include_once 'action.php';
?>

</div>
</div>

<footer style="text-align:center; color:#fff; padding:10px 0;">made with <i class="icon-love" style="font-weight:700;"></i> by <a href="https://www.rathinfotech.com/" style="color:#fff; text-decoration:none;">rath infotech</a></footer>

</div>
</body>

<?php if(($_GET['action']=="add-member") || $_GET['action']=="edit-member" ||$_GET['action']=="edit-userprofile") { ?>
<!------for date picker---------->


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#datepicker" ).datepicker({
			 changeMonth:true,
			 changeYear:true,
			 yearRange:"-100:+1",
			 dateFormat:"yy-mm-dd" });
  } );
  </script>

<!------for date picker end---------->

<?php } ?>
<?php if(($_GET['action']=="sendsms") || ($_GET['action']=="sendemail")) { ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<?php } ?>
<script src="js/bootstrap.js"></script>

<script src="js/validate.js"></script>



<script>
// When the user clicks on div, open the popup
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
</html>