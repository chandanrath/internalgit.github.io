<?php

session_start();
date_default_timezone_set('Asia/Kolkata');
ini_set('max_execution_time', 0);

include_once 'includes/connect.php';
include_once 'includes/define.php';
include_once 'includes/functions.php';

$currDateTime 	= date("Y-m-d H:i:s");


$ipaddress = getIPaddress();		// get user ip address GIEGMPL//
	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_detail = IPDetails($ipAddress);
$ISPurl = ISPDetails($ipAddress);
$ISP = (!empty($ISPurl['isp'])?$ISPurl['isp']:"") ;


if($_POST['operation']=="sendOTP")
{

 $ChkSql = "SELECT mobile from "._PREFIX."client where status = 1 AND mobile='".trim($_POST['mobileno'])."'";		
			
$res1 = mysqli_query($conn,$ChkSql);
$MobNum = mysqli_num_rows($res1);
$UserMob = mysqli_fetch_array($res1);
$userMobile = $UserMob['mobile'];

if(($MobNum==0))
{
	$_SESSION["mobile"] = $_POST['mobileno'];	
	$_SESSION['otpmsg'] = "Login Not Authenticate ";
	$message = $_SESSION['mobile']."-".$_SESSION['otpmsg'];
	ErrorLog($conn,0,$message,$ipaddress,$agent_detail);
	header('location:'.BASE_URL.'login.php?msg=fail');	
	exit;
}

else if($MobNum > 0)
{

	$mobileAuth = MOBILE_AUTH;
	
	$mobile="91".$_POST['mobileno'];
	
	$otp= rand(1000,9999);  //Generate random number as OTP
				
				
	$msg="Your OTP is ".$otp." for ChampionsMumbai.com Login. Powered by RATH Infotech.";   //Your Custom Message
	
	//echo"https://control.msg91.com/api/sendotp.php?authkey=".$mobileAuth."&mobile=".$mobile."&message=".$msg."&sender=RATHAPP&otp=".$otp;
	
	
	//Hit the API
	//$postUrl = htmlspecialchars_decode("https://control.msg91.com/api/sendotp.php?authkey=".$mobileAuth."&mobile=".$mobile."&message=".$msg."&sender=RATHAPP&otp=".$otp,ENT_NOQUOTES);
	
//echo"cont==".	$contents = file_get_contents($postUrl);    
			   
//	$result=json_decode($contents,true);	
	
//	echo"<pre>res==";print_r($result);
//	exit;

  	
	$ch = curl_init();
    $curlConfig = array(
        CURLOPT_URL            => "https://control.msg91.com/api/sendotp.php?authkey=".$mobileAuth."&mobile=".$mobile."&message=".$msg."&sender=RATHAPP&otp=".$otp,
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
       // CURLOPT_POSTFIELDS     => $post_array
    );
    curl_setopt_array($ch, $curlConfig);

	$result = curl_exec($ch);
	curl_close($ch);

	$response = json_decode($result,true);
	
   // echo"<pre>res==";print_r($response);
    
    //echo"type==".$response['type'];
	//exit;
	
		if($response['type']=="success")
		{
			
			$_SESSION["mobile"] = $_POST['mobileno'];	
			$_SESSION["otpmsg"] = "OTP sent successfully";	
			header('location:'.BASE_URL.'login.php?msg=yes');
		}
		else
		{
			$_SESSION["otpmsg"] = "OTP sent Fail";	
			header('location:'.BASE_URL.'login.php?msg=fail');	
		}
	}
	else
	{
		$_SESSION["mobile"] = $_POST['mobileno'];	
		$_SESSION['otpmsg'] = "Mobile Number Not Authenticate ";
		$message = $_SESSION['mobile']."-".$_SESSION['otpmsg'];
		ErrorLog($conn,0,$message,$ipaddress,$agent_detail);
		header('location:'.BASE_URL.'login.php?msg=userfail');	
		exit;
	}

}
else if($_POST['operation']=="verifyOTP")
{
	unset($_SESSION['otpmsg']);

	if(isset($_POST['verifyotp']) && $_POST['verifyotp'] != "")
	{
		 $mobileno 		= "91".$_POST['mobileno'];
		 //$hidcmpid  	= $_POST['hidcmpid'];
		 $mobileAuth 	= MOBILE_AUTH;
		$recieved_otp 	= $_POST['verifyotp'];
		
		$postData1 = array(
				'authkey' => $mobileAuth,
				'mobile' => trim($mobileno),
				'otp' => $recieved_otp,
				
			);
			
		
		$verifyOTPMsg 	= MobileVerifyOTP($postData1);
		
		if($verifyOTPMsg=="success")
		{
			$updOtp = "update "._PREFIX."client set mobverify='1' where  mobile='".$_POST['mobileno']."' and status=1";
			$mailres = mysqli_query($conn, $updOtp);

			$userSql = "SELECT cmpid,role,roleid,cname,cmpname,cmpemail,designation from "._PREFIX."client where status = 1 AND mobile='".trim($_POST['mobileno'])."'";
			
			
			$uresult = mysqli_query($conn,$userSql);
			 $userNum = mysqli_num_rows($uresult);
			
			if($userNum > 0 )
			{	
				$UserRow = mysqli_fetch_array($uresult);
				//echo"role==".$UserRow['role'];
		
				$_SESSION['cmpid'] 		= $UserRow['cmpid'];	//user id ;
				$_SESSION['name'] 		= $UserRow['cname'];	//user name ;
				$_SESSION['email'] 		= $UserRow['cmpemail'];	//user email ;
				$_SESSION['mobile'] 	= $_POST['mobileno'];	//user mobile ;
				$_SESSION['role'] 		= $UserRow['role'];	//user role ;
				$_SESSION['roleid'] 		= $UserRow['roleid'];	//user role ;
				$_SESSION['designation'] 		= $UserRow['designation'];	//user role ;
				//echo"<pre>sess==";print_r($_SESSION);
			
				// user log //
				//$message = "Login";
				//UserClickLog($conn,$UserRow['cmpid'],$recieved_otp,$UserRow['cname'],$useragent,$ipAddress,$agent_detail,$message,$ISP);
				
				// redirection page //
				if($UserRow['roleid']=='1')
				{				

					header('location:'.BASE_URL.'dashboard.php?action=default-admin');
					exit;					
				}
				else
				{
					header('location:'.BASE_URL.'dashboard.php?action=userprofile');
					exit;
				}

				}
				else
				{
	
					header('location:'.BASE_URL.'login.php');
					exit;
				}

			}
			else
			{			
				 $_SESSION['otpmsg'] = "Please enter Correct OTP ";
				$message = $_SESSION['mobile']."-". $_SESSION['otpmsg'];
				ErrorLog($conn,$cmpid,$message,$ipaddress,$agent_detail);
				header('location:'.BASE_URL.'login.php?msg=fail');	
				exit;
			}
		}
	}

function MobileVerifyOTP($postData)
{	

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://control.msg91.com/api/verifyRequestOTP.php?authkey=".$postData['authkey']."&mobile=".trim($postData['mobile'])."&otp=".$postData['otp'],
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => $postData,				 
	  CURLOPT_HTTPHEADER => array(
		"content-type: application/x-www-form-urlencoded"
	  ),
	));
	
	$response = curl_exec($curl);
	$err = curl_error($curl);
	
	curl_close($curl);
	
	$result=json_decode($response,true);

//echo $result;
	return $result['type'];
}


exit;


?>