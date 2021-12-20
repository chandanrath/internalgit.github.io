<?php
include_once 'connect.php';
include_once 'define.php';


define("STRING_DELIMITER", " ");

date_default_timezone_set('Asia/Calcutta');

function LimitedWords($string)
{
	if (strlen($string) > 150) {
		$trimstring = substr($string, 0, 150). ' ...';
	} else {
		$trimstring = $string;
	}

	return  $trimstring;
}

function limitText($text, $limit) {
$strings = $text;
  if (strlen($text) > $limit) {
	  $words = str_word_count($text, 2);
	  $pos = array_keys($words);
	  if(sizeof($pos) >$limit)
	  {
		$text = substr($text, 0, $pos[$limit]) . '...';
	  }

	  return $text;
  }

  return $text;
}

function encrypt($data)
{
	//$data = "#@".$data;
	return base64_encode(base64_encode(base64_encode($data)));
}

function encode($data)
{
	//$data = "#@".$data;
	return base64_encode(base64_encode(base64_encode($data)));
}
function decode($data)
{
	//echo"<li>dsw==".$data = substr($data,2);
	return base64_decode(base64_decode(base64_decode($data)));
}

function getIPaddress()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    	$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}	
	
	$ip = explode(',',$ip);

	$ip[0] = (!empty($ip[0])?$ip[0]:0);
	
	return $ip[0];
}

function IPDetails($ipaddress)
{
	
	$agentContent = htmlspecialchars_decode("https://www.iplocate.io/api/lookup/".$ipaddress,ENT_NOQUOTES); //,ENT_NOQUOTES
	//$agentContent = htmlspecialchars_decode("http://api.ipstack.com/".$ipaddress."?access_key=04c5dd1d2dff879a0f9341155d406ec6",ENT_NOQUOTES); 
	return file_get_contents($agentContent); 
}
function ISPDetails($ipaddress)
{
	return $query = unserialize(file_get_contents('http://ip-api.com/php/'.$ipaddress));
	
}

function UserClickLog($conn,$cmpid,$otp,$cname,$useragent,$ipaddress,$agent_detail,$message,$ISP)
{
	  $queryLog ="insert into ri_users_log(cmpid,otp,cname,useragent,ipaddress,agent_details,message,isp,status,login_date)
values('".$cmpid."','".$otp."','".$cname."','".$useragent."','".$ipaddress."','".$agent_detail."','".$message."','".$ISP."',1,'".date("Y-m-d H:i:s")."')";

	mysqli_query($conn,$queryLog);
	
}

function UserClickMenuLog($conn,$cmpid,$otp,$cname,$ipaddress,$message)
{
	  $queryLog ="insert into ri_users_log(cmpid,otp,cname,ipaddress,message,status,login_date)
values('".$cmpid."','".$otp."','".$cname."','".$ipaddress."','".$message."',1,'".date("Y-m-d H:i:s")."')";

	mysqli_query($conn,$queryLog);
	
}

function ErrorLog($conn,$cmpid,$message,$ipaddress,$agent_detail)
{
	  $queryLog ="insert into ri_error_log(cmpid,errormsg,ipaddress,agent_details,status,error_date)
values('".$cmpid."','".$message."','".$ipaddress."','".$agent_detail."',1,'".date("Y-m-d H:i:s")."')";

	mysqli_query($conn,$queryLog);
	
}
function makeurl($text)
{
  // replace non letter or digits by -
  $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  if (function_exists('iconv'))
  {
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  }

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('#[^-\w]+#', '', $text);

  if (empty($text))
  {
    return '';
  }

  return $text;
 }

/*
function MailSend($subject,$html,$title,$Toemail)
{
	
	
	$mail = new PHPMailer();
	$mail->IsSMTP();				
	$mail->SMTPDebug  = 0;  
	$mail->SMTPAuth   = true;                  		// enable SMTP authentication
	$mail->Host       = "smtp.sendgrid.net"; 		// SMTP server
	$mail->Port       = 25; ;                    	// set the SMTP port for the GMAIL server
	$mail->Username   ="apikey"; 					// SMTP account username		
	$mail->Password   = "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";            // GMAIL password
	
	
	$mail->Subject    = $subject ;
	$mail->WordWrap = 150;

	$mail->MsgHTML($html);

	$mail->SetFrom('app@rathinfotech.com','Rathinfotech App');
	//$mail->AddAddress($Toemail, $title);
	$mail->AddAddress($Toemail,$title);
	
	
			
	if(!$mail->Send()) {
			 return "fail";
		
		} else {				
			
			return "success";			 
		}
	
}
	
	*/
	
	

?>
