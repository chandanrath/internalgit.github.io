<?php

ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);

include_once '../includes/connect.php';
include_once '../includes/define.php';
include_once '../includes/functions.php';

date_default_timezone_set('Asia/Calcutta'); 

$ipaddress = getIPaddress();		// get user ip address GIEGMPL//	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_detail = IPDetails($ipaddress);
$ISPurl = ISPDetails($ipaddress);
$ISP = (!empty($ISPurl['isp'])?$ISPurl['isp']:"") ;

unset($_SESSION['errmsg']);

$created_date	= date('Y-m-d H:i:s');
$operation		= $_POST['operation'];


//echo"<pre>post==";print_r($_POST);



if($operation=='addclient')
{
   $chkClient = ChkduplicateClient($conn,$_POST['cmpemail'],"ri_client");
	
	if($chkClient > 0)
	{
		$_SESSION['errmsg'] = "Member Email ID Already Registered!";
		header('location:'.BASE_URL.'dashboard.php?action=add-users');	
		exit;
	}

	$chkMobile = ChkduplicateMobile($conn,$_POST['mobile'],"ri_client");
	
	if($chkMobile > 0)
	{
		$_SESSION['errmsg'] = "Member Mobile No. Already Registered!";
		header('location:'.BASE_URL.'dashboard.php?action=add-users');	
		exit;
	}
	
	//$sequence = MemberSequence();

	if($_POST['role']=="admin") {
		$roleid = 1; 
		$sitsequence = $_POST['sequence'];
		$designation = $_POST['cmpdesign']; 
	}else { 
		$roleid = 2;
		$sitsequence = 111;
		$designation = ($_POST['desiguser']!=""?strtolower($_POST['desiguser']):"member");	//desiguser
	}
	//$website = parse_url($_POST['website'], PHP_URL_HOST);	// remove https.http//
	$weburl = preg_replace("(^https?://)", "", $_POST['website'] );
	$website = rtrim($weburl,"/");
	
	$dob = (!empty($_POST['dob'])?$_POST['dob']:'0000-00-00');

	$query ="insert into "._PREFIX."client(cname,cmpname,cmpemail,mobile,dob,role,roleid,designation,ptid,website,usp,mobverify,status,sitsequence,created_date)
	values('".trim($_POST['name'])."','".trim($_POST['cmpname'])."','".trim($_POST['cmpemail'])."','".trim($_POST['mobile'])."','".trim($dob)."','".trim($_POST['role'])."','".trim($roleid)."','".trim($designation)."','".trim($_POST['powerteam'])."','".trim($website)."','".trim(addslashes($_POST['usp']))."','1',1,'".$sitsequence."','".$created_date."')";
	
	mysqli_query($conn,$query);			 
	$cmpid = mysqli_insert_id($conn);

	if(!empty($_FILES['logo']['name']))	
	{	
		
		$target_dir = "../images/profile/".$cmpid."/";
		
		$Checkimage =  CheckUploadImage($_FILES['logo'],$target_dir,strtolower($_POST['name']),$cmpid);
		$result = json_decode($Checkimage,true);
		
		//echo"res==<pre>";print_r($result);
		if($result['status']=="ok")
		{
				$queryImg ="insert into "._PREFIX."client_img(cmpid,imgname,imgpath,status,created_date)
			values('".trim($cmpid)."','".trim($_FILES['logo']['name'])."','".trim($result['path'])."','1','".$created_date."')";
			
			mysqli_query($conn,$queryImg);
		}			 
			
			
	}
	
	$message = "Add Member to ".$_POST['name'];
	UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);

	
	header('location:'.BASE_URL.'dashboard.php?action=memberlist');
	
	
}
else if($operation=='editclient')
{
	//echo"<pre>post==";print_r($_POST);exit;
	$clientid		= (!empty($_POST['clientid'])?$_POST['clientid']:"");

	if($_POST['role']=="admin") {
		$roleid = 1; 
		$sitsequence = $_POST['sequence'];
		$designation = $_POST['cmpdesign']; 
	}else { 
		$roleid = 2;
		$sitsequence = 111;
		$designation = ($_POST['desiguser']!=""?strtolower($_POST['desiguser']):"member");	//desiguser
	}

	$cid = decode($clientid);	// userid//
		$dob = (!empty($_POST['dob'])?$_POST['dob']:'0000-00-00');

	  $update = "update "._PREFIX."client set cname='".trim($_POST['name'])."',cmpname='".trim($_POST['cmpname'])."',dob='".trim($dob)."', mobile='".trim($_POST['mobile'])."', cmpemail='".trim($_POST['cmpemail'])."',  ptid='".trim($_POST['powerteam'])."', website='".trim($_POST['website'])."',  usp='".trim(addslashes($_POST['usp']))."',role='".trim($_POST['role'])."',roleid='".trim($roleid)."',designation='".trim($designation)."',sitsequence='".trim($sitsequence)."',update_date='".$created_date."' where cmpid='".decode($clientid)."'";
	mysqli_query($conn, $update);	
	
	if(!empty($_FILES['logo']['name']))	
	{	
		
		$target_dir = "../images/profile/".$cid."/";
		
		$Checkimage =  CheckUploadImage($_FILES['logo'],$target_dir,strtolower($_POST['name']),$clientid);
		$result = json_decode($Checkimage,true);
		
		//echo"res==<pre>";print_r($result);
		if($result['status']=="ok")
		{
			$sqlIMG="select id from "._PREFIX."client_img where cmpid='".decode($clientid)."' and status=1 ";	
			$chkIMG = mysqli_query($conn,$sqlIMG);
			$rowIMG = mysqli_num_rows($chkIMG);
			if($rowIMG > 0)
			{	
			 $updateImg = "update "._PREFIX."client_img set imgname='".trim($_FILES['logo']['name'])."',imgpath='".trim($result['path'])."',modified_date='".$created_date."' where cmpid='".decode($clientid)."' and status=1";
				mysqli_query($conn, $updateImg);
			}
			else
			{
				 $queryImg ="insert into "._PREFIX."client_img(cmpid,imgname,imgpath,status,created_date)
				values('".decode($clientid)."','".trim($_FILES['logo']['name'])."','".trim($result['path'])."','1','".$created_date."')";
				
				mysqli_query($conn,$queryImg);
			}
						
			
		}			 
			
			
	}
	$message = "Edit Member to ".$_POST['name'];
	UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);

	header('location:'.BASE_URL.'dashboard.php?action=memberlist');	
}
else if($operation=='addPowerteam')
{
	$code = makeurl($_POST['powerteam']);

	$queryPT ="insert into "._PREFIX."powerteam(powerteam,code,status,created_date)
	values('".trim($_POST['powerteam'])."','".trim($code)."','1','".$created_date."')";
	
	mysqli_query($conn,$queryPT);

	header('location:'.BASE_URL.'dashboard.php?action=powerteam');
}
else if($operation=='editPowerteam')
{
	$code = makeurl($_POST['powerteam']);
	$ptid = decode($_POST['ptid']);	// powerid//	

	$updatePT = "update "._PREFIX."powerteam set powerteam='".trim($_POST['powerteam'])."',code='".trim($code)."' where id='".$ptid."' and status=1";
	mysqli_query($conn, $updatePT);

	header('location:'.BASE_URL.'dashboard.php?action=powerteam');
}


else if($operation=='userprofile')
{
	$clientid		= (!empty($_POST['clientid'])?$_POST['clientid']:"");

	$cid = decode($clientid);

	  $update = "update "._PREFIX."client set cmpname='".trim($_POST['cmpname'])."',dob='".trim($_POST['dob'])."', cmpemail='".trim($_POST['cmpemail'])."',  ptid='".trim($_POST['powerteam'])."', website='".trim($_POST['website'])."',  usp='".trim($_POST['usp'])."',update_date='".$created_date."' where cmpid='".decode($clientid)."'";
	mysqli_query($conn, $update);	
	
	if(!empty($_FILES['logo']['name']))	
	{	
		
		$target_dir = "../images/profile/".$cid."/";
		
		$Checkimage =  CheckUploadImage($_FILES['logo'],$target_dir,strtolower($_POST['name']),$clientid);
		$result = json_decode($Checkimage,true);
		
		//echo"res==<pre>";print_r($result);
		if($result['status']=="ok")
		{
			$sqlIMG="select id from "._PREFIX."client_img where cmpid='".decode($clientid)."' and status=1 ";	
			$chkIMG = mysqli_query($conn,$sqlIMG);
			$rowIMG = mysqli_num_rows($chkIMG);
			if($rowIMG > 0)
			{	
			 $updateImg = "update "._PREFIX."client_img set imgname='".trim($_FILES['logo']['name'])."',imgpath='".trim($result['path'])."',modified_date='".$created_date."' where cmpid='".decode($clientid)."' and status=1";
				mysqli_query($conn, $updateImg);
			}
			else
			{
				 $queryImg ="insert into "._PREFIX."client_img(cmpid,imgname,imgpath,status,created_date)
				values('".decode($clientid)."','".trim($_FILES['logo']['name'])."','".trim($result['path'])."','1','".$created_date."')";
				
				mysqli_query($conn,$queryImg);
			}
						
			
		}			 
			
			
	}

	$message = "Edit Member to ".$_POST['name'];
	UserClickLog($conn,$_SESSION['cmpid'],'0',$_SESSION['name'],$useragent,$ipaddress,$agent_detail,$message,$ISP);

	header('location:'.BASE_URL.'dashboard.php?action=userprofile');	// for personal user
}



/****************method started **********************************/

function MemberSequence()
{

	$query1 ="SELECT max(sequence) as squ FROM "._PREFIX."client where status=1";
	$result1 = mysqli_query($conn, $query1);
	$count=  mysqli_num_rows($result1);
	$row1 = mysqli_fetch_array($result1);
	$sequ = ($row1['squ']+1);
	return $sequ;
}

function CheckUploadImage($files,$dir,$cname,$cmpid)
{
	$target_dir = $dir;
	$cname = str_replace(" ","-",strtolower(trim($cname)));
    $currdate = date('His');
	$newFile = $cname."-".$currdate.".jpg";
		
	if(!is_dir($target_dir)) {
		
			mkdir($target_dir);
		}
		
	$target_file = $target_dir.$newFile;	
	
	//$uploadOk = "ok";
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	//move_uploaded_file($files["tmp_name"], $target_file);

	if (move_uploaded_file($files["tmp_name"], $target_file)) {
       // echo "<center><i><h4>The file ". basename( $files["tmp_name"]). " has been uploaded.</h4></i></center>";
		$uploadOk = "ok";
    } else {
       // echo "<center>Sorry, there was an error uploading your file.</font></center>";
		$uploadOk = "error";
    }
	
	return json_encode(array("status"=>$uploadOk,"path"=>$target_file));
	
}

 function ChkduplicateClient($conn,$email,$table)
 {	
	$sql="select cmpid from $table where cmpemail='".$email."' and status=1 and mobverify=1";	
	$chkQury = mysqli_query($conn,$sql);
	$chkRows = mysqli_num_rows($chkQury);
	return 	$chkRows;	
 }
function ChkduplicateMobile($conn,$mobile,$table)
 {	
	$sql="select cmpid from $table where mobile='".$mobile."' and status=1 and mobverify=1";	
	$chkQury = mysqli_query($conn,$sql);
	$chkRows = mysqli_num_rows($chkQury);
	return 	$chkRows;	
 }
 
 function CheckEmailId($conn,$email)
 {	
	
	$sql="select rc.cmpid,rc.cmpemail,ru.uid
	from ri_client rc
	JOIN ri_users ru ON(rc.cmpid=ru.cmpid)
	where rc.cmpemail='".$email."' AND rc.mobverify=1
	and rc.status=1 AND ru.status=1";
 
	$resEmail = mysqli_query($conn,$sql);
	$numEmail = mysqli_num_rows($resEmail);
	
	if($numEmail > 0)
	{
		$arrVal = mysqli_fetch_array($resEmail);
		
		$rowVal = $arrVal['cmpid']."@".$arrVal['uid'];
	}
	else
	{
		$rowVal = 0;	
	}
	
	return 	$rowVal;	
 }
 


?>
