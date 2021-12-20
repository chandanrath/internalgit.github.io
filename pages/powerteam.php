<?PHP
ob_start();
session_start();

?>



<?php

if($_REQUEST['mode']=='edit')
{
	$operation	=	'editPowerteam';
	$ID	=	decode($_REQUEST['d']);
 	$SQL_QUERY="select id,powerteam,status from "._PREFIX."powerteam where status=1 and id='".$ID."' order by id desc";
	
	$result		= mysqli_query($conn,$SQL_QUERY);				
	$num_data	= mysqli_num_rows($result);
	$arr 		= mysqli_fetch_array($result);
	
	$powerteam	= $arr['powerteam'];
	$id			= $arr['id'];
	$status		= $arr['status'];
		
}

else if($_REQUEST['mode']=='delete')
{
	$ID	=	decode($_REQUEST['d']);
	$deletePT = "update "._PREFIX."powerteam set status='2' where status=1 and id='".$ID."'";
	mysqli_query($conn, $deletePT);
	
	$deleteCMP = "update "._PREFIX."client set ptid='0' where status=1 and ptid='".$ID."'";
	mysqli_query($conn, $deleteCMP);
	
	
	echo '<script>
			document.location.href="dashboard.php?action=powerteam";
		</script>'; 
		
}
else {
	$operation	=	'addPowerteam';
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
    <form  method="post" class="form-horizontal" action="scripts/insert_users.php" name="ptForm"  id="ptForm" onSubmit="return Powerteam();">

    <div class="inpurt-form">
    <input type="text" name="powerteam" id="powerteam" placeholder="Powerteam" class="input-name" value="<?php echo (isset($powerteam)?$powerteam:""); ?>" >
    <span class="error" id="errteam"></span>
    </div>

	<div class="login-button">    
    <input type="submit" class="btn button-area mr-30" name="submit" id="submit"  value="Submit"/>
    
    <input type="hidden" id="operation" name="operation" value="<?PHP echo $operation;?>" />
    <input type="hidden" id="ptid" name="ptid" value="<?PHP echo $_REQUEST['d'];?>" />	
    </div>  

	
	</form>
  </div>


 <div class="col-lg-6">   
    <span class="error-alert" id="errselecte"></span>
      <div class="card mb-30">
        <div class="table-area">
	<?php
		$QUERYPT ="select id,powerteam,status from ri_powerteam where status=1 order by powerteam ASC";	
	
		$result_pt		= mysqli_query($conn,$QUERYPT);				
		$num_data_pt	= mysqli_num_rows($result_pt);
		
	?>
        
        <table>
          <tr>
            <th class="w30">Sr No</th>
            <th class="w40">Powerteam</th>	
			<th class="w40">Action</th>
            
          </tr>
        <?PHP
            if($num_data_pt > 0){
            $i=1;
            while($arrpt=mysqli_fetch_array($result_pt))
            {
                
                $id				= $arrpt["id"];	
                $powerteam		= $arrpt["powerteam"];                
                $created_date	= strtotime($arrpt["created_date"]);
                
                
        ?>
          <tr>
          
            <td><?php echo $i;?></td>
            <td><?php echo $powerteam;?></td>
            <td>
			<?php if($arrpt["status"]==1) { ?>     
            
            <a href="javascript:void(0);" onclick="EditData('<?php echo encode($id);?>','powerteam');" class="btn icon-action btn-sm "><i style="font-size: 22px;" class="icon-edit-user"></i> </a>    
            <a href="javascript:void(0);" onclick="deleteData('<?php echo encode($id);?>','powerteam');" class="btn icon-action btn-sm btn-cross" title="Delete"><i class="icon-trash font-26"></i> </a>
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

 </div>
<script>
function EditData(id)
{
	document.location.href="dashboard.php?action=powerteam&d="+id+"&mode=edit";	
}
function deleteData(id)
{
	var i=window.confirm("Are You Sure About Deactive Of Data");
	if(i)
	{		
		document.location.href="dashboard.php?action=powerteam&d="+id+"&mode=delete";
	}	
}
</script>






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