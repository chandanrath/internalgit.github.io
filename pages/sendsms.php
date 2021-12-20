<?PHP
ob_start();
session_start();

?>



<?php

if(isset($_GET) && $_GET['search']!="")
{
	$appendFilter = " and (cmpname like'%".$_GET['search']."%' OR cmpemail like'%".$_GET['search']."%' OR cname like'%".$_GET['search']."%' OR mobile like'%".$_GET['search']."%' OR powerteam like'%".$_GET['search']."%') ";
}
else
{
	$appendFilter = "";				
}

?>
<div class="row mt-30">
<div class="col-lg-12">

       
 <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" method="post"  >	
    <div class="valid-input">
       <input class="form-control form-control-sm w75" type="text" name="filterText" id="filterText" value="<?php echo (isset($_REQUEST['search']))?$_REQUEST['search']:''?>" placeholder="Search"  aria-label="Search">
        <span onclick="FilterMember()"><i class="fa fa-search p7" aria-hidden="true" ></i></span>
    </div>	
<div class="login-button"> </div>
</form> 
</div>
</div>

<div class="row mt-50 mb-30">

<div class="col-lg-6">



<form name="sendfrm" id="sendfrm" enctype="multipart/form-data" method="post" action="scripts/send_data.php" onsubmit="return validate_form();">

<input type="button"  name="selectall" id="selectall" class="btn button-area mb-30" value="Select All" onclick="SelectAll(document.sendfrm.chkSMS);" />

<?php            
            
 $userSql = "SELECT cmpid,cname,cmpname,cmpemail,mobile,status from "._PREFIX."client Where status=1". $appendFilter. " and cname<>'Admin' ";

$paging=new paging_admin(100,5);				
$result= $paging->query($conn,$userSql);			
$page=$paging->print_info();
$num_data=mysqli_num_rows($result);           

?>

<span class="error-alert" id="errselecte"></span>
<div class="card mb-30">
<div class="table-area">

<table>
  <tr>
	
    <th class="w40">Name</th>	
	<th class="w30">Phone</th>
	 <th class="w20">Send</th>
   
  </tr>
<?PHP
	if($num_data > 0){
	$i=1;
	while($fetch_data=mysqli_fetch_array($result))
	{
		
		$cmpid				= $fetch_data["cmpid"];	
		$cname				= $fetch_data["cname"];
		$mobile				= $fetch_data["mobile"];
		$created_date		= strtotime($fetch_data["created_date"]);
		
		
?>
  <tr>
  
    <td><?php echo $cname;?></td>
    <td><?php echo $mobile;?></td>
    <td>
                              
	<?php if($fetch_data["status"]==1) { ?>     
    <label class="checkbox-area">
    <input type="checkbox" name="chkSMS[]" class="checkbox-area" id="chkSMS" value="<?php echo encode($cmpid).'@'.$mobile?>">
    <span class="checkmark"></span>
    </label>	
	
    <?php } ?>                           
    </td>
    
	
  </tr>
 
 <?PHP	$i++; } } else {  ?>   
 <tr><td colspan="5" style="text-align:center"> No Records</td></tr> 
<?PHP	}  ?>    
</table>

<input type="hidden" name="operation" value="sendSMS">
</div>
</div>
</div>




<div class="col-lg-6">

<input type="submit" name="sendall" id="sendall"  class="btn button-area mb-30 float-right" value="Send" />
 <div style="clear:both;"></div>
<div class="card mb-30">
<textarea type="text" name="content" id="content" onKeyUp="return CheckWord();" placeholder="Description" rows="5"class="input-name" ><?php echo (isset($content)?$content:""); ?></textarea>
<small class="form-text text-muted">Count Should be Min. 200 Words.<span class="pull-right" id="charecter">0 / 200</span></small>
    <span class="error" id="errcont"></span>
</div>
</div>

</form>


<!--<script src="js/jquery.js"></script>-->
<script>
function CheckWord()
{
	var cs =$("textarea").val().length;
	varv = cs;
	$('#charecter').html(varv+' / 200');
	if(varv > 20)
	{
		//$('#charecter').html("");
		document.getElementById('errcontent').innerHTML= "Content Not More Then 200"	;
		document.forms["sendfrm"]["content"].focus();
		return false
	}
}


function validate_form()
{
var content = document.forms["sendfrm"]["content"].value;
	valid = true;
	
	if($('input[type=checkbox]:checked').length == 0)
	{
		
		document.getElementById('errselecte').innerHTML= "Please Select At Least One Number"	;
		return false;
	}
	
	if(content=="")
	{
		document.getElementById('errcont').innerHTML= "Please Enter Content"	;
		document.forms["sendfrm"]["content"].focus();
		return false
	}
	else
	{
		document.getElementById('errcont').innerHTML= "";
		
	}
	if(content!="")
	{
		
		if(content.length > 200)
		{
			document.getElementById('errcont').innerHTML= "Content Not More Then 200"	;
			document.forms["sendfrm"]["content"].focus();
			return false
		}
		else
		{
			document.getElementById('errcont').innerHTML= "";
			
		}		
	}
	
	document.getElementById('errselecte').innerHTML= "SMS Send Successfully"	;
}
function FilterMember()
{
	var filterText = document.getElementById('filterText').value;	
	document.getElementById('filterText').focus();	
	window.location.href ="dashboard.php?action=sendsms&search="+filterText;
	return true;
}

</script>

<script>
function SelectAll(chk)
{

	if(document.sendfrm.selectall.value=="Select All"){
	for (i = 0; i < chk.length; i++)
	chk[i].checked = true ;

	document.sendfrm.selectall.value="UnCheck All";
	}else{
	
		for (i = 0; i < chk.length; i++)
		chk[i].checked = false ;
		document.sendfrm.selectall.value="Select All";
	}
}
	
	// add multiple select / deselect functionality
	$("#selectall").click(function () {		
	
	  $('.chkSMS').attr('checked', this.checked);
	});
	
	// if all checkbox are selected, check the selectall checkbox
	// and viceversa
	$(".chkSMS").click(function(){
	
		if($("#chkSMS").length == $(".case:checked").length) {
			$("#selectall").attr("checked", "checked");
		} else {
			$("#selectall").removeAttr("checked");
		}
	
	});

</script>
 

<?php 

unset($_SESSION['errmsg']);
?>