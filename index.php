<?php
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


include_once 'includes/connect.php';
include_once 'includes/define.php';
include_once 'includes/functions.php';

$detsils = array();
$ipaddress = getIPaddress();		// get user ip address GIEGMPL//	
$useragent = $_SERVER['HTTP_USER_AGENT'];
$agent_detail = IPDetails($ipaddress);
$ISPurl = ISPDetails($ipaddress);
$ISP = (!empty($ISPurl['isp'])?$ISPurl['isp']:"") ;

$cmpid = (isset($_SESSION['cmpid'])?$_SESSION['cmpid']:"");
$name =	(isset($_SESSION['name'])?$_SESSION['name']:"");

$message = "page click to index Page";
$detsils['ipaddress'] 	= $ipaddress;
$detsils['useragent'] 	= $useragent;
$detsils['agentdetail'] = $agent_detail;
$detsils['ispurl'] 		= $ISPurl;
$detsils['isp'] 		= $ISP;

$_SESSION['ipdetails'] = $detsils;

UserClickLog($conn,$cmpid,'0',$name,$useragent,$ipaddress,$agent_detail,$message,$ISP);



//echo"<pre>ses==";print_r($_SESSION);

?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>Champions | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php include_once 'includes/link.php'; ?>
 
<style>
.ui-helper-hidden-accessible{
	display:none;
}
</style>
<!-----for search css ----->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 

</head>
<body>
<div class="bg">
<div class="container">
<div class="row">
<div class="col-sm-12 col-lg-12 col-md-12"><div class="d-flex justify-content-center">
<a href="<?=BASE_URL?>"><span><img src="images/logo.png" title="Champions" alt="Champions"/></span></a>
</div>
    <span class="login">
    <?php if(isset($_SESSION['role'])) { ?>
    <div onclick="myFunction()" class="profile-area popup">
    <a href="#">Welcome <?php echo $_SESSION['name'];?></a><span class="profile-icon"><img src="images/profile-icon.svg"/></span>
    
    <?php include_once 'includes/menu.php';?>
    </div>
    <?php } else { ?>
    <a href="login.php">Log In</a>
    <?php } ?>
    </span>
</div>
</div>


<div class="row mt-50">

    <div class="col-lg-12">
        <div class="search-area">
        <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" method="post"  >	
          <input class="form-control form-control-sm w75" type="text" name="searchTxt" id="searchTxt" value="<?php echo (isset($_REQUEST['search']))?$_REQUEST['search']:''?>" placeholder="Search"  aria-label="Search" >
			<div id="suggestion-input" class="suggestion-input"></div>

			<input type="hidden" id="userID" name="userID" value=""/>
       
        </form>
        </div>
    </div>
	
	<!-- <div class="col-lg-12">
        <div class="search-area">
        <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" method="post"  >	
          <input type='text' name='country' id='country' value='' class='form-control form-control-sm w75 auto'>

         <span onclick="FilterMember()"><i class="fa fa-search p7" aria-hidden="true" ></i></span>

        </form>
        </div>
    </div>-->


</div>

<?php

?>



<?php
if(isset($_GET) && $_GET['search']!="")
{
	$appFilter = " and (rc.cname like'%".$_GET['search']."%' OR rc.cmpname like'%".$_GET['search']."%' OR rc.cmpemail like'%".$_GET['search']."%' OR rc.mobile like'%".$_GET['search']."%' OR rc.role like'%".$_GET['search']."%') ";
}
else
{
	$appFilter = "";				
}
?>

<div class="row mt-50" id="my-gallery-container">
<?php 
  $chkSql = "select rc.cmpid,rc.cname,rc.designation,rc.role,rc.roleid,rc.cmpname,rc.cmpemail,rc.mobile,rc.powerteam,rc.ptid,rc.role,rc.website,rc.usp,rc.sequence,
rci.imgname,rci.imgpath
FROM "._PREFIX."client rc
JOIN "._PREFIX."client_img rci ON(rci.cmpid=rc.cmpid)
WHERE rc.`status`=1 AND rci.`status`=1 AND rc.mobverify=1 and cname<>'Admin' ".$appFilter." order by rc.roleid,rc.sitsequence,rc.cname asc";	
$resSql = mysqli_query($conn,$chkSql);
$chkNum = mysqli_num_rows($resSql);

if($chkNum > 0)
{
	$i=1;
	while($rows = mysqli_fetch_array($resSql))
	{
		$imgpath = str_replace("../","",$rows['imgpath']);
?>

<div class="item">
<div class="card-home">
<div class="card-area">
<div class="area-row">
<div class="photo-area"><img src="<?php echo BASE_URL.$imgpath?>" width="100%"/></div>
<div class="text-area">
<h2 class="title"><?=ucwords($rows['cname'])?></h2>
<div class="co-title"><?=ucwords($rows['cmpname'])?></div>
<div class="tel"><i class="icon-phone font-weight-700"></i> <a href="tel:<?=("+91".$rows['mobile'])?>"><?=("+91-".$rows['mobile'])?></a></div>
<div class="tel"><i class="icon-email-icon font-weight-700"></i> <a href="mailto:<?=($rows['cmpemail'])?>"><?=($rows['cmpemail'])?></a></div>
<?php if($rows['website']!="") {
$web = explode("https://",$rows['website']);

if(isset($web[1])){ $website = $web[0].$web[1];} else $website = "https://".$web[0];

?> 
<div class="tel"><i class="icon-web font-weight-700"></i> <a href="<?php echo rtrim($website, '/');?> " target="_blank" ><?php echo $rows['website'];?></a></div>
<?php } ?>
</div>
</div>
<!-- <div class="photo"></div> -->
<p><?php echo $rows['usp']; //limitText($rows['usp'],20)?></p>
</div>
<?php if($rows['roleid']=="1") { ?>
<div class="ledership-area"><?php echo ucwords(str_replace("-"," ",$rows['designation'])); ?></div>
<?php } else if(($rows['roleid']=="2") && ($rows['designation']!="member")) {?>
<div class="business-area"><?php echo ucwords(str_replace("-"," ",$rows['designation'])); ?></div>
<?php } else { ?>

<?php } ?>
<input type="hidden" name="hidval" value="<?php echo $rows['cmpid']; ?>">

<div class="share">
<button type="button" class="btn" data-toggle="modal" data-target="#myModal-<?php echo $rows['cmpid']; ?>">
<i class="icon-share"></i></button>
</div>
</div>


<div class="modal" id="myModal-<?php echo $rows['cmpid']; ?>">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
         
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->



		<!--------send whatsapp------------->
		<?php 
			$messg = "Name-".$rows['cname'].", Company-".$rows['cmpname'].", Mobile-".$rows['mobile'].", Email-".$rows['cmpemail'];
			$whatsAppUrl = "https://api.whatsapp.com/send?text=$messg";
		?>
		<!--------send whatsapp End------------->

    <div class="modal-body">

		<div class="mtb-10" id="successmsg<?php echo $rows['cmpid']?>" style="display:none;color:#871022; text-align:center"></div>

        <div id="listBox-<?php echo $rows['cmpid']?>">

        <a href="javascript:void(0);" onClick="SendSMSByUser('<?php echo $rows['cmpid']?>')">
<i class="icon-massage font-40 mr-30"></i></a>
        <a href="<?=$whatsAppUrl?>" ><i class="icon-whatsapp font-40 mr-30"></i></a>

        <a href="javascript:void(0);" onclick="copyText('<?php echo $rows['cmpid']?>')"><i class="icon-copy font-40 mr-30"></i></a>		 

        <a href="javascript:void(0);" onClick="SendEMAILByUser('<?php echo $rows['cmpid']?>')"><i class="icon-email-icon font-40"></i></a>
        </div>

		
		
		<!--------send sms------------->
        <div class="mtb-10" id="smsopenBox-<?php echo $rows['cmpid']?>" style="display:none;">

        <div id="errmob-<?php echo $rows['cmpid']?>" style="color:#F30;"></div>
        <input type="text" name="sendsms<?php echo $rows['cmpid']?>" id="sendsms<?php echo $rows['cmpid']?>" placeholder="Mobile No." class="mobile-input" onkeypress="return isNumberKey(event);" maxlength="10" />
        <input type='button' value='Submit' id='submitsms-<?php echo $rows['cmpid']?>' class="btn" onClick="submitsmsSend('<?php echo $rows['cmpid']?>');"	/>
		<img id="smsloading-<?php echo $rows['cmpid']?>" src="images/loader.gif" style="display:none;" width="20px" height="20px;"/>
        </div>
		<!--------send sms END------------->
		
		<!--------Copy Clipboard------------->
		<div class="mtb-10" id="errclip-<?php echo $rows['cmpid']?>" style="color:#F30;"></div>
		<div class="mtb-10" id="copyBox-<?php echo $rows['cmpid']?>" style="display:none;">
		
       <textarea name="hidcopy-<?php echo $rows['cmpid']?>" id="hidcopy-<?php echo $rows['cmpid']?>" style="text-align:center;" ><?php echo "Name-".$rows['cname']."<br /> Company-".$rows['cmpname']."<br /> Mobile-".$rows['mobile']."<br /> Email-".$rows['cmpemail'];?></textarea>		
        </div>
		<!--------Copy Clipboard end------------->


		<!--------send email------------->
		<div class="mtb-10" id="emailopenBox-<?php echo $rows['cmpid']?>" style="display:none;">

       	<div id="erremail-<?php echo $rows['cmpid']?>" style="color:#F30;"></div>
        <input type="text" name="sendemail<?php echo $rows['cmpid']?>" id="sendemail<?php echo $rows['cmpid']?>" placeholder="Enter Email." class="mobile-input" />
		<input type='button' value='Submit' id='submitemail-<?php echo $rows['cmpid']?>' class="btn" onClick="submitemailSend('<?php echo $rows['cmpid']?>');"/>
		<img id="emailloading-<?php echo $rows['cmpid']?>" src="images/loader.gif" style="display:none;" width="20px" height="20px;"/>
        </div>
		<!--------send email end------------->
		
		<input type='hidden' name='hidcmpid' id='hidcmpid' value="<?php echo $rows['cmpid']?>"  />    
	</div>
        
        <!-- Modal footer -->
        
        
      </div>
    </div>
  </div>
</div>
<?php $i++;  }  } else { ?>



<div class="item">
<div class="card-home">
<div class="card-area">
<div class="area-row">
</div>
<p>No Records</p>
</div>
</div>
</div>
<?php } ?>




</div>
</div>
<footer style="text-align:center; color:#fff; padding:10px 0;">Made with <i class="icon-love" style="font-weight:700;"></i> by <a href="https://www.rathinfotech.com/" style="color:#fff; text-decoration:none;">rath infotech</a></footer>

</div>

</body>

<script src="js/jquery.js"></script>
<script src="js/validate.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/mp.mansory.js"></script>
 <script type="text/javascript">
		jQuery(document).ready(function ( $ ) {
			$("#my-gallery-container").mpmansory(
				{
					childrenClass: 'item', // default is a div
					columnClasses: 'padding', //add classes to items
					breakpoints:{
						xl: 4,
						lg: 4, 
						md: 6, 
						sm: 6,
						col: 12
					},
					distributeBy: { order: false, height: false, attr: 'data-order', attrOrder: 'asc' }, //default distribute by order, options => order: true/false, height: true/false, attr => 'data-order', attrOrder=> 'asc'/'desc'
					onload: function (items) {
						//make somthing with items
					} 
				}
			);
		});
	</script>

<script>

function SendSMSByUser(id)
{
	document.getElementById("listBox-"+id).style.display="none";
	document.getElementById("smsopenBox-"+id).style.display="";
}
function SendEMAILByUser(id)
{
	document.getElementById("listBox-"+id).style.display="none";
	document.getElementById("emailopenBox-"+id).style.display="";
}

function SendWhatsappByUser(id)
{
	document.getElementById("listBox-"+id).style.display="none";
	document.getElementById("emailopenBox-"+id).style.display="";
}


// clip board //
function copyText(id) {
  /* Get the text field */

	document.getElementById("listBox-"+id).style.display="none";
	document.getElementById("copyBox-"+id).style.display="";

	var copyText = document.getElementById("hidcopy-"+id);
	
	/* Select the text field */
	copyText.select();
	
	/* Copy the text inside the text field */
	document.execCommand("copy");
	
	/* Alert the copied text */
	
	document.getElementById("copyBox-"+id).style.display="none";
	
	document.getElementById("successmsg"+id).style.display="";
	document.getElementById("errclip-"+id).innerHTML =copyText.value;
}
	
function submitemailSend(id)
{
	
	var sendemail = $('#sendemail'+id).val();
	
	if(sendemail=="")
	{
		document.getElementById('erremail-'+id).innerHTML= "Please Enter Email Id"	;
		document.getElementById("sendemail"+id).focus();
		return false
	}
	else
	{
		document.getElementById('erremail-'+id).innerHTML= "";
		
	}
	if(sendemail!="")
	{
		var regexp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regexp.test(sendemail)) {
			
			document.getElementById('erremail-'+id).innerHTML= "Please Valid Email ID"	;		
			document.getElementById("sendemail"+id).focus();
			return false;
		}
	}
	else
	{
		document.getElementById('erremail-'+id).innerHTML= "";
		
	}
	
	var dataString = 'emailid='+ sendemail +'&cmp='+id +'&type=sendEmailMsg' ;
	
	$.ajax({
			type: "POST",
			url: 'scripts/send_data.php',
			data: dataString,
			cache: false,
			beforeSend: function(){	
	
				document.getElementById('submitemail-'+id).style.display="none";
				$("#emailloading-"+id).show();
			},
			complete: function() {	

				$("#loading").hide();			
                $('#emailopenBox-'+id).hide();
				$('#successmsg'+id).show();
				$('#successmsg'+id).html("Thank You For Sending Email");
              
            },  
			success: function(data){
			
			}
		});
	

}

function submitsmsSend(id)
{
	var sendsms = $('#sendsms'+id).val();
	if(sendsms=="")
	{
		document.getElementById('errmob-'+id).innerHTML= "Please Enter Mobile"	;
		document.getElementById("sendsms"+id).focus();
		return false
	}
	else
	{
		document.getElementById('errmob-'+id).innerHTML= "";
		
	}
	if((sendsms.length != 10))
	{
		document.getElementById('errmob-'+id).innerHTML= "Mobile Number Should be 10 Digit"	;
		document.getElementById("sendsms"+id).focus();
		return false
	}
	else
	{
		document.getElementById('errmob-'+id).innerHTML= "";		
	}
	
	var dataString = 'mobnum='+ sendsms +'&cmp='+id +'&type=sendMobSMS' ;
	
	$.ajax({
			type: "POST",
			url: 'scripts/send_data.php',
			data: dataString,
			cache: false,
			beforeSend: function(){			
				$("#submitsms-"+id).hide();
				$("#smsloading-"+id).show();
			},
			complete: function() {
		
                $('#smsopenBox-'+id).hide();
				$('#successmsg'+id).show();
				$('#successmsg'+id).html("Thank You For Sending SMS");
              
            },  
			success: function(data){
			
			}
		});
	
	
}


// send SMS //
$(document).ready(function(){

	
// click on close button /
	$(".close").click(function(){
  		location.reload(true);
	});
});


</script>

<script>
// When the user clicks on div, open the popup
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>	


<script type="text/javascript">


$(function() {
	
	//autocomplete
	var data;
		$("#searchTxt").autocomplete({	
			source: "ajax/search.php",
			minLength: 1,		

			select: function (event, ui) {
				
				window.location.href ="index.php?search="+ui.item.value;
				 //return false;
       	 	} 
			
		});

		$("#searchTxt").keyup(function(event){

			var code = event.charCode || event.keyCode;
			//alert(code)
			if (code == 27) {
				//click esc button//
				$("#searchTxt").val('');
				window.location.href ="index.php";
			}			
			if (code == 13) {				
				window.location.href ="index.php?search="+$("#searchTxt").val();
				
			}
				
			});
	

			$('#searchTxt').focus();

 });

</script>


</html>