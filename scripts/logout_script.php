
<?php
include_once '../includes/connect.php';
include_once '../includes/define.php';


	unset($_SESSION['cmpid']);	
	unset($_SESSION['cname']);
	unset($_SESSION['name']);
	unset($_SESSION['cmpemail']);	
	unset($_SESSION['role']);
	unset($_SESSION['mobile']);	
	unset($_SESSION['token']);
	unset($_SESSION['designation']);
	
	session_unset();
	
	session_unset($_SESSION['cmpid']);
	session_unset($_SESSION['cname']);
	session_unset($_SESSION['cmpemail']);
	session_unset($_SESSION['role']);
	session_unset($_SESSION['mobile']);
	session_unset($_SESSION['designation']);


	
	session_destroy();
	
	
	 
	 
	header("Location:index.php");
?>

<script> 
		
	window.location.href ='<?=BASE_URL?>index.php';
	close();		
</script>