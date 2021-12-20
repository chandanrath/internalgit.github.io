
  <?PHP
     
$action=$_REQUEST['action'];

//echo"<pre>sess==";print_r($_SESSION);


/* scripts */

$actArray = array("logout","default-admin","userprofile","edit-userprofile","generate-ppt","generate-ppt-random","generate-ppt-powerteam","add-member","edit-member","memberlist","sendsms","powerteam","sendemail");



if($action=='')							{ 	include_once 'index.php';	}

if(!empty($action))
{
	if(in_array($action,$actArray))
	{		
	
	if($action=='logout')					{	include_once 'scripts/logout_script.php'; }
	if($action=='default-admin')			{ 	include_once 'default_admin.php';	}
	if($action=='userprofile')				{ 	include_once 'pages/userprofile.php';	}
	if($action=='edit-userprofile')			{ 	include_once 'pages/edit_userprofile.php';	}
	
	if($action=='generate-ppt')				{ 	include_once 'pages/generate_ppt.php';	}
	if($action=='generate-ppt-random')		{ 	include_once 'pages/generate_pptrandom.php';	}
	if($action=='generate-ppt-powerteam')	{ 	include_once 'pages/generate_pptpowerteam.php';	}
	
	
	if($action=='add-member')				{	include_once 'pages/add_member.php';	}
	
	if($action=='edit-member')				{	include_once 'pages/edit_member.php';	}
	if($action=='memberlist')				{	include_once 'pages/memberlist.php';	}
	
	if($action=='sendsms')					{  include_once 'pages/sendsms.php'; }
	if($action=='sendemail')				{  include_once 'pages/sendemail.php'; }
	
	if($action=='powerteam')				{	include_once 'pages/powerteam.php';	}

	}
	else
	{
		header("Location:index.php");
		exit;
	}
}



?>