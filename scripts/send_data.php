
<?php
ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


include_once '../includes/connect.php';
include_once '../includes/define.php';
include_once '../includes/functions.php';
require_once('../PHPMailer/class.phpmailer.php');


$ipaddress = getIPaddress();		// get user ip address GIEGMPL//	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_detail = IPDetails($ipaddress);
$ISPurl = ISPDetails($ipaddress);
$ISP = (!empty($ISPurl['isp'])?$ISPurl['isp']:"") ;


//echo"post==<pre>";print_r($_POST);exit;
if($_POST['operation']=="sendSMS")
{
	if(!empty($_POST['chkSMS']))
	{
		
		$preNum  = "+91";
		$mobileNum = "";
		foreach($_POST['chkSMS'] as $value)
		{
			$valData = $value;

			$valData = explode("@",$value);
			
			$cmpid = decode($valData[0]);
			$mobile = $preNum.$valData[1];

			$mobileNum .= $mobile.",";			
		
		}
			
			$mobileNumber = rtrim($mobileNum, ',');

		//	$mobileNumber = "+919967355303";
			
			$content = $_POST['content'];	
			
			$request="http://mobicomm.dove-sms.com//submitsms.jsp?user=CONCEPT&key=a221b44e9cXX&mobile=".$mobileNumber."&message=".urlencode($content)."&senderid=CONCEQ&accusage=1";
			
			
			$response = explode(',',file_get_contents($request));

			
			if($response[1]=='success')
			{
				echo 'Message Sent Successfully';	
			}

	}
	
		$message = "SMS Send By ".$_SESSION['name'];
		UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);

		header('location:'.BASE_URL.'dashboard.php?action=sendsms');	
		exit;
	
}


else if($_POST['operation']=="sendEMAIL")
{
	if(!empty($_POST['chkEMAIL']))
	{
		
		$sendemail =array();
		$subject = trim($_POST['subject']);
		$message = trim($_POST['content']);
			

		foreach($_POST['chkEMAIL'] as $value)
		{
			//$value = ;

			$valData = explode("#",$value);
			
			$cmpid = decode($valData[0]);		// cmpid //
			$sendemail = $valData[1];				// emsil id

			$mailstatus = mailSend($subject,$sendemail,$message);		
		
		}

	}

	$message = "Email Send By ".$_SESSION['name'];
	UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);

	header('location:'.BASE_URL.'dashboard.php?action=sendemail');	
		exit;
}

else if($_POST['type']=="sendMobSMS")
{	
	//echo"post==<pre>";print_r($_POST);
	$content = "";
	$preNum  = "+91";
	$cmpid = $_POST['cmp'];
    $mobile = $preNum.$_POST['mobnum'];

	$mobileNumber = $mobile;

	//$mobileNumber = "+919967355303";
		
	$SQL_QUERY="SELECT * FROM "._PREFIX."client WHERE  cmpid='".$cmpid."' and status=1";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arrData = mysqli_fetch_array($result);
	
	
    $content .= "Name -".$arrData['cname']."\r\n";
	$content .=	"Company Name -".$arrData['cmpname']."\r\n";
	$content .= "Email Id -".$arrData['cmpemail']."\r\n";
	$content .= "Mobile No. -".$arrData['mobile']."\r\n";
	if(!empty($arrData['website'])){
	$content .= "Website -".$arrData['website'];
	}
	
	
	 $request="http://mobicomm.dove-sms.com//submitsms.jsp?user=CONCEPT&key=a221b44e9cXX&mobile=".$mobileNumber."&message=".urlencode($content)."&senderid=CONCEQ&accusage=1";
	
	
	$response = explode(',',file_get_contents($request));
	
	if($response[1]=='success')
	{
		echo $response[1];	
	}

	//echo $response;
//header('location:'.BASE_URL.'index.php');	

	
}
else if($_POST['type']=="sendEmailMsg")
{
	//echo"post==<pre>";print_r($_POST);
	$message = "";
	$subject = $arrData['cmpemail']." Details";
	$cmpid = $_POST['cmp'];
		
	$SQL_QUERY="SELECT cname,cmpname,cmpemail,mobile,website FROM "._PREFIX."client WHERE  cmpid='".$cmpid."' and status=1";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arrData = mysqli_fetch_array($result);
	
	
	$message .= "Name -".$arrData['cname']."\r\n";
	$message .=	"Company Name -".$arrData['cmpname']."\r\n";
	$message .= "Email Id -".$arrData['cmpemail']."\r\n";
	$message .= "Mobile No. -".$arrData['mobile']."\r\n";
	if(!empty($arrData['website'])){
	$message .= "Website -".$arrData['website'];
	}

	$mailstatus = mailSend($subject,$_POST['emailid'],$message);
	
}


// start method //
function mailSend($subject,$sendemail,$message)
{
	$mail     = new PHPMailer();

	$body	  = $message;
						   
					   // 2 = messages only
	$mail = new PHPMailer();
	$mail->IsSMTP();				
	$mail->SMTPDebug  = 0;  
	$mail->SMTPAuth   = true;                  		// enable SMTP authentication
	$mail->Host       = "smtp.sendgrid.net"; 		// SMTP server
	$mail->Port       = 25;                    	// set the SMTP port for the GMAIL server
	$mail->Username   = "apikey"; 					// SMTP account username		
	$mail->Password   = "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";            // GMAIL password
	
	$mail->Subject    = $subject ;
	$mail->WordWrap = 150;

	$mail->MsgHTML($body);

	$mail->SetFrom('app@rathinfotech.com','championsmumbai');
	
	$mail->AddAddress($sendemail, "championsmumbai.com");	
	$mail->AddAddress("chandan@rathinfotech.com", "Chandan");			
		
		if (!$mail->Send()) {
			
			//$errmsg =  "Mailer Error for " . $email1 . " ". $mail->ErrorInfo;
			
			$errmsg1 = "fail Mail";			
				
		} else {
			//$errmsg = "Message sent to ".$email1;
		
			$errmsg1 = "Mail success";
		}
		
	return $errmsg1;
}
?>