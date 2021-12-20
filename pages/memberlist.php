<?PHP
ob_start();
session_start();


if($_GET['mode']=='delete')
{
	
	$ID	=	decode($_REQUEST['d']);
	$update = "update "._PREFIX."client set status='2' where cmpid='".$ID."'";
	mysqli_query($conn, $update);
	$updateImg = "update "._PREFIX."client_img set status='2' where cmpid='".$ID."'";
	mysqli_query($conn, $updateImg);
	
	echo '<script>
			document.location.href="dashboard.php?action=memberlist";
	</script>'; 
		
}

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
        <div class="search-area">
        <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" method="post"  >	
          <input class="form-control form-control-sm w75" type="text" name="filterText" id="filterText" value="<?php echo (isset($_REQUEST['search']))?$_REQUEST['search']:''?>" placeholder="Search"  aria-label="Search">
          <span onclick="FilterMember()"><i class="fa fa-search p7" aria-hidden="true" ></i></span>
        </form>
        </div>
    </div>
</div>




<div class="row mt-50">
<div class="col-lg-12">
<div class="card">
<div class="table-area">
<?php            
            
 $userSql = "SELECT cmpid,cname,cmpname,cmpemail,mobile,status from "._PREFIX."client Where status=1". $appendFilter. " and cname<>'Admin' ";

$paging=new paging_admin(100,5);				
$result= $paging->query($conn,$userSql);			
$page=$paging->print_info();
$num_data=mysqli_num_rows($result);           

?>
<table>
  <tr>
    <th class="w20">Name</th>
	<th class="w20">Company</th>
    <th class="w20">EmailId</th>
	<th class="w20">Phone</th>
    <th class="w20">Action</th>
  </tr>
<?PHP
	if($num_data > 0){
	$i=1;
	while($fetch_data=mysqli_fetch_array($result))
	{
		
		$cmpid				= $fetch_data["cmpid"];	
		$cname				= $fetch_data["cname"];							
		$cmpname			= $fetch_data["cmpname"];
		$cmpemail			= $fetch_data["cmpemail"];
		$mobile				= $fetch_data["mobile"];
		$role				= $fetch_data["role"];						
		$status				= ($fetch_data["status"])==1?"Active":"Deactive";
		$created_date		= strtotime($fetch_data["created_date"]);
		
		
?>
  <tr>
   
    <td><?php echo $cname;?></td>
    <td><?php echo $cmpname;?></td>
    <td><?php echo $cmpemail;?></td>                    
    <td><?php echo $mobile;?></td>
    <td>
                              
	<?php if($fetch_data["status"]==1) { ?>     
    
    <a href="javascript:void(0);" onclick="edit_data('<?php echo encode($cmpid);?>','edit-member');" class="btn icon-action btn-sm "><i style="font-size: 22px;" class="icon-edit-user"></i> </a>    
    <a href="javascript:void(0);" onclick="deleteData('<?php echo encode($cmpid);?>','memberlist');" class="btn icon-action btn-sm btn-cross" title="Delete"><i class="icon-trash font-26"></i> </a>
    <?php } ?>                           
    </td>
    
	
  </tr>
 
 <?PHP	$i++; } } else {  ?>   
 <tr><td colspan="5" style="text-align:center"> No Records</td></tr> 
<?PHP	}  ?>    
</table>
</div>




</div>
</div>
</div>


<script>

function FilterMember()
{
	var filterText = document.getElementById('filterText').value;	
	document.getElementById('filterText').focus();	
	window.location.href ="dashboard.php?action=memberlist&search="+filterText;
	return true;
}


function deleteData(id)
{
	var i=window.confirm("Are You Sure About Deactive Of Data");
	if(i)
	{		
		document.location.href="dashboard.php?action=memberlist&d="+id+"&mode=delete";
	}	
}

</script>

<?php 

unset($_SESSION['errmsg']);
?>