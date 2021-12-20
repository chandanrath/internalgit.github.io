<?php
 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);

include_once '../includes/connect.php';
include_once '../includes/define.php';
include_once '../includes/functions.php';


date_default_timezone_set('Asia/Calcutta'); 


unset($_SESSION['errmsg']);

$created_date	= date('Y-m-d H:i:s');

 
if(!empty($_POST["keyword"])) {


    
	 $query1 ="SELECT cmpid,cname,cmpname FROM "._PREFIX."client WHERE (cname like '" . $_POST["keyword"] . "%' OR cmpname like '" . $_POST["keyword"] . "%' ) and cname<>'Admin' and sequence=0   ORDER BY cname ASC LIMIT 0,10";
	$result1 = mysqli_query($conn, $query1);
	$count1=  mysqli_num_rows($result1);

	$alert='<ul>';
	while($row=  mysqli_fetch_array($result1)){
		$cmpid	=$row["cmpid"];
		$name	=$row["cname"];
		$cmpname	=$row["cmpname"];
		$alert.="<li onClick='selectClient(\"$cmpid-$name\")'>$name / $cmpname</li>";
	}
	$alert.="</ul>";
	echo $alert;

} 

/*

if(!empty($_POST["keyword"])) {


     $query ="SELECT count(*) cnt FROM "._PREFIX."client WHERE sequence_date='".date('Y-m-d')."'  and status=1";

    $result = mysqli_query($conn, $query);
    $count=  mysqli_num_rows($result);
	$CurrDate=  mysqli_fetch_array($result);
	$currdateCnt = $CurrDate['cnt'];

	if($currdateCnt ==0){
		$updateSeq = "update "._PREFIX."client set sequence='0',sequence_date='".date('Y-m-d')."' where status=1 and cname<>='Admin' ";
		mysqli_query($conn, $updateSeq);

	}
	else
	{

		 $query1 ="SELECT cmpid,cname FROM "._PREFIX."client WHERE cname like '" . $_POST["keyword"] . "%' and cname<>'Admin' and sequence=0  and sequence_date='".date('Y-m-d')."' ORDER BY cname LIMIT 0,10";
		$result1 = mysqli_query($conn, $query1);
		$count1=  mysqli_num_rows($result1);
	
		$alert='<ul id="state-list">';
		while($row=  mysqli_fetch_array($result1)){
			$cmpid	=$row["cmpid"];
			$name	=$row["cname"];
			$alert.="<li onClick='selectClient(\"$cmpid-$name\")'>$name</li>";
		}
		$alert.="</ul>";
		echo $alert;
	}
} 

*/

?>