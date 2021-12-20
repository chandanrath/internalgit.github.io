<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
ini_set('max_execution_time', 0);

include_once '../includes/connect.php';
include_once '../includes/define.php';


$currDateTime 	= date("Y-m-d H:i:s");

if (isset($_GET['term'])){

	$return_arr = array();

	try {
	   
	    
	    $ChkSql = "SELECT cname from "._PREFIX."client where status = 1 AND (cname like'%".trim($_GET['term'])."%' OR cmpname like'%".trim($_GET['term'])."%') and cname<>'Admin' limit 0,10";		
			
		$result = mysqli_query($conn,$ChkSql);
		$MobNum = mysqli_num_rows($result);
		
		
	    while($rows =  mysqli_fetch_array($result)) {
	        $return_arr[] =  $rows['cname'];
	    }

	} catch(Exception $e) {
	    echo 'ERROR: ' . $e->getMessage();
	}

	//echo"<pre>dat==";print_r($return_arr);
    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);
}


?>