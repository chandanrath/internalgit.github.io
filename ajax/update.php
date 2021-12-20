<?php
 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);

include_once '../includes/connect.php';
include_once '../includes/define.php';
include_once '../includes/functions.php';


date_default_timezone_set('Asia/Calcutta'); 

$created_date = date('Y-m-d');
//echo"role==".$_SESSION['role'];exit;
if($_SESSION['role']=="admin")
{
	if(!empty($_POST["cmpid"]))
	{
	
		 $query ="SELECT sequence,cname,cmpname FROM "._PREFIX."client WHERE cmpid ='".$_POST["cmpid"]."' and status=1 and cname<>'Admin' ";
		$result = mysqli_query($conn, $query);
		$count=  mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$userName = $row['cname'];
		$cmpname = $row['cmpname'];
		
		$cnt=1;
		
	
		if($row['sequence']==0){
			
			$query1 ="SELECT max(sequence) as squ FROM "._PREFIX."client where status=1 and cname<>'Admin'";
			$result1 = mysqli_query($conn, $query1);
			$count=  mysqli_num_rows($result1);
			$row1 = mysqli_fetch_array($result1);
			
			$seq = ($cnt + $row1['squ']);
			
			if($_SESSION['designation']=="vice-president")
			{
				$desigSeq = 1;	
			}
			else if($_SESSION['designation']=="treasurer")
			{
					$desigSeq = 2;	
			}
			else if($_SESSION['designation']=="president")
			{
					$desigSeq = 3;	
			}
			else
			{
				$desigSeq = 4;
			}


			 $update = "update "._PREFIX."client set sequence='".$seq."',added_by='".$_SESSION['cmpid']."',designation_seq='".$desigSeq."',sequence_date ='".$created_date."' where cmpid='".$_POST["cmpid"]."' and status=1 and cname<>'Admin'";
			mysqli_query($conn, $update);
	
			// $InsSequ = "insert into "._PREFIX."client_seq(cmpid,cname,cmpname,sequence,status,created_date) values('".$_POST["cmpid"]."','".trim($userName)."','".trim($cmpname)."','".trim($seq)."',1,'".$created_date."')";
		//	$resIns = mysqli_query($conn, $InsSequ);
	
	
		}
		
		
	} 
}
?>