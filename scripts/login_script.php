<?php

ob_start(); 
session_start();

include_once '../includes/connect.php';
include_once '../includes/define.php';
include_once '../includes/functions.php';


date_default_timezone_set('Asia/Calcutta');

$ipAddress = getIPaddress();		// get user ip address GIEGMPL//
	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_details = IPDetails($ipAddress);
//exit;
//echo"pass==".md5(encrypt_data('123456'));
//exit;
$currentTime = date('Y-m-d H:i:s');	

//echo"<pre>post==";print_r($_POST);
//exit;
$passwrd = md5($_POST['passwrd']);

if($_POST['username']=='admin')
{
	$userSql = "SELECT uid,cmpid,role,username from "._PREFIX."users 
	where status = 1 AND username = '".trim($_POST['username'])."'	AND passwrd='".trim($passwrd)."'";
}
else
{
	 $userSql = "SELECT ru.uid,ru.role,ru.username,ru.name,rc.cname,rc.cmpemail from "._PREFIX."users ru 
	JOIN "._PREFIX."client rc ON(rc.cmpid=ru.cmpid) where ru.status = 1 AND rc.`status`=1  AND ru.username = '".trim($_POST['username'])."' AND ru.passwrd='".trim($passwrd)."'";
}
	
	$uresult = mysqli_query($conn,$userSql);
	$userNum = mysqli_num_rows($uresult);
	$UserRow = mysqli_fetch_array($uresult);
	
	if($userNum > 0 )
	{	
		if($_POST['username']=='admin')
		{
			$_SESSION['username'] 	= $UserRow['username'];	//user role ;			
			$_SESSION['userid'] 	= $UserRow['uid'];	//user id ;
			$_SESSION['name'] 		= 'Admin';	//user id ;
			$_SESSION['email'] 		= $UserRow['username'];	//user id ;
			$_SESSION['role'] 		= $UserRow['role'];	//user role ;
			
		}
		else
		{			
			$_SESSION['username'] 	= $UserRow['username'];	//user role ;
			$_SESSION['cmpid'] 		= $UserRow['cmpid'];	//user role ;		
			$_SESSION['userid'] 	= $UserRow['uid'];	//user id ;
			$_SESSION['name'] 		= $UserRow['cname'];	//user id ;
			$_SESSION['email'] 		= $UserRow['cmpemail'];	//user id ;
			$_SESSION['role'] 		= $UserRow['role'];	//user role ;
		}
		
		// user login logs //
		$query_log ="insert into ri_users_log(userid,cmpid,username,useragent,ipaddress,agent_details,message,status,login_date)
		values('".$UserRow['uid']."','".$UserRow['cmpid']."','".$UserRow['username']."','".$useragent."','".$ipAddress."','".$agent_details."','Login Success','1','".date("Y-m-d H:i:s")."')";
		
		mysqli_query($conn,$query_log);
		
		// if login with admin//
		if($UserRow['role']=='admin')	
		{
			header('location:'.BASE_URL.'dashboard.php?action=default');	
			exit;	
		}
					
			// if login with Users//			
		else 
		{	
			 header('location:'.BASE_URL.'dashboard.php?action=default');	
					
				
		}	// end dataentry //	
		
	}
	else
	{
		$_SESSION['errmsg'] = "Login Credential Failed!.";
		
		
		// user login logs //
		$query_log ="insert into ri_users_log(userid,cmpid,username,useragent,ipaddress,agent_details,message,status,login_date)
		values('".$UserRow['uid']."','".$UserRow['cmpid']."','".$_POST['username']."','".$useragent."','".$ipAddress."','".$agent_details."','Login Credential Failed','1','".date("Y-m-d H:i:s")."')";
		
		mysqli_query($conn,$query_log);
		
		header("Location:".BASE_URL."login.php");
		
	}
	
function LoginLogs()
{
	$query_log ="insert into ri_error_log(userid,oauth_uid,name,email,remote_addr,types,pages,message,log_date,flag)
	values('".$UserRow['id']."','".$gpUserProfile['id']."','".$gpUserProfile['name']."','".$gpUserProfile['email']."','".$ipAddress."','Login','Login','".$errMsg."','".date("Y-m-d H:i:s")."',0)";
					
	 mysqli_query($conn,$query_log);
}


ob_flush(); 


?>