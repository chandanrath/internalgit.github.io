<?php
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);

include_once('includes/define.php');

//echo"<pre>sess==";print_r($_SESSION);
unset($_SESSION['ipdetails'])

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Champions | Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include_once 'includes/link.php'; ?>

</head>
<body>
<div class="bg">
<div class="container">
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12"><div class="d-flex justify-content-center">
<a href="<?=BASE_URL?>"><span><img src="images/logo.png" title="Champions" alt="Champions"/></span></a>
 </div></div>

</div>

<?php if(!isset($_REQUEST['action'])) { ?>
<div class="row mt-30">
<div class="col-lg-12">

<form  class="form-horizontal" method="post" action="sendotp.php" id="usersLogin" name="usersLogin" onsubmit="return UserLogin();">
<?php if($_GET['msg']!="") {
					
 if($_GET['msg']=="yes"){
 $messg = "OTP Sent Successfully.";
} else if($_GET['msg']=="userfail") { $messg = "Invalid Login Credential.";} else { $messg = "Invalid Users "; }
?>
<div class="error-alert" id="senderror"><?php echo $messg?></div>

<?php } ?>

<div class="error-alert" id="error"></div>
<?php if(isset($_SESSION['mobile']) && ($_SESSION['mobile']!="")){ $mobVal = $_SESSION['mobile']; } else { $mobVal =""; } ?>
<div class="valid-input">
  <input class="form-control form-control-sm w95" type="text" name="mobileno" id="mobileno"  value="<?=$mobVal?>" placeholder="Phone No"  aria-label="Search">
</div>	




<?php if(isset($_GET['msg']) && ($_GET['msg']=="yes")) { ?>
 <div class="error-alert" id="otperror"></div>               
<div class="valid-input">
  <input class="form-control form-control-sm w95" type="text" name="verifyotp" id="verifyotp"  value="" placeholder="OTP No"  aria-label="Search">
</div>
<div class="login-button">
<input type="submit" class="btn button-area" name="verifyBtn" id="verifyBtn" value="LOGIN" onClick="return ValidateOTP();"/>
<input type="hidden" name="operation" id="operation" value="verifyOTP">
</div>
<?php } else { ?>	
<div class="login-button">
 <input type="submit" class="btn button-area" name="submit" id="submit"  value="SEND OTP"/>
<input type="hidden" name="operation" id="operation" value="sendOTP">
</div>
<?php } ?>

</form>

</div>
</div>
<?php } else { ?>

<?php } ?>

</div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>

<script type="text/javascript">

//$("#senderror").fadeOut("slow");

function UserLogin()
{	
	
	var mobileno = document.forms["usersLogin"]["mobileno"].value;
	
	if(mobileno=="")
	{
		document.getElementById('error').innerHTML="Please enter your mobile number";
		document.forms["usersLogin"]["mobileno"].focus();
		return false
	}
	if(!mobileno.match(/^\d+/))
	{
		document.getElementById('error').innerHTML="Mobile Number Should Numeric";
		document.getElementById("mobileno").focus();
		return false;
	}
	if(mobileno.length != 10)
	{
		document.getElementById('error').innerHTML="Please enter Valid mobile number";
		document.forms["usersLogin"]["mobileno"].focus();
		return false
	}

	
}

</script>

<script>
 
function ValidateOTP()
{
	var verifyotp = $.trim(document.getElementById('verifyotp').value);
	
	if(verifyotp=="")
	{	
		document.getElementById('otperror').innerHTML="Please Enter Valid OTP"	;
		document.getElementById('verifyotp').focus();
		return false;
	}
	if(verifyotp.length < 4)
	{
		document.getElementById('otperror').innerHTML="Please Enter Valid OTP"	;
		document.getElementById('verifyotp').focus();
		return false;
	}
	
}


</script>



</html>