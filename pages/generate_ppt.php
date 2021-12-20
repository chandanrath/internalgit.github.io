<?PHP
ob_start();
session_start();
header("Content-Type: text/html;charset=UTF-8");

//echo"<pre>sess==";print_r($_SESSION);

if($_GET['mode']=='delete')
{
	$ID	=	decode($_REQUEST['d']);
	$update = "update "._PREFIX."client set sequence='0' where status=1 and cmpid='".$ID."'";
	mysqli_query($conn, $update);
	
	
	echo '<script>
			document.location.href="dashboard.php?action=generate-ppt";
		</script>'; 
		
}
else if(isset($_GET['mode']) && ($_GET['mode']=='up'))
{
	$ID	=	decode($_REQUEST['d']);
	$clickSeq = ($_REQUEST['seq']-1);
	$oldSeq = ($clickSeq+1);
	
	$updateOld = "update "._PREFIX."client set sequence=".$oldSeq." where status=1 and sequence='".$clickSeq."' and sequence_date='".date('Y-m-d')."'";
	mysqli_query($conn, $updateOld);

	$updateClk = "update "._PREFIX."client set sequence=".$clickSeq." where status=1 and cmpid='".$ID."'";
	mysqli_query($conn, $updateClk);
	
	echo '<script>
			document.location.href="dashboard.php?action=generate-ppt";
		</script>';
}
else if(isset($_GET['mode']) && ($_GET['mode']=='down'))
{
	$ID	=	decode($_REQUEST['d']);
	$clickSeq = ($_REQUEST['seq']+1);
	$oldSeq = ($clickSeq-1);
	
	$updateOld = "update "._PREFIX."client set sequence=".$oldSeq." where status=1 and sequence='".$clickSeq."' and sequence_date='".date('Y-m-d')."'";
	mysqli_query($conn, $updateOld);

	$updateClk = "update "._PREFIX."client set sequence=".$clickSeq." where status=1 and cmpid='".$ID."'";
	mysqli_query($conn, $updateClk);
	
	
	echo '<script>
			document.location.href="dashboard.php?action=generate-ppt";
		</script>';
}
if($_GET['mode']=='reset')
{
	//if($_SESSION['name']=="Admin")
	//{
		 $update = "update "._PREFIX."client set sequence='0',sequence_date='',designation_seq=0,added_by=0 where status=1  ";
	/*}
	else
	{
		$update = "update "._PREFIX."client set sequence='0',sequence_date='',designation_seq=0,added_by=0 where status=1 and added_by='".$_SESSION['cmpid']."' ";
	}*/
	
	
	mysqli_query($conn, $update);
	
	
	echo '<script>
			document.location.href="dashboard.php?action=generate-ppt";
		</script>'; 
		
}


?>

<!-----for search css ----->
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 


<div class="row mt-30">
<div class="col-lg-12">

<!---------onkeydown="onkeypressed(event, this);" ------>
<div class="valid-input">
  <input class="form-control form-control-sm w75" type="text" name="srchname" id="srchname" placeholder="Search By Member"  aria-label="Search" >
	<i class="fa fa-search p7" aria-hidden="true"></i>	
	<div id="suggestion-input" class="suggestion-input"></div>
</div>	



</div>

<button type="button" class="btn button-area" onclick="Reset()">Reset</button>
</div>

<?php
/*
if(isset($_GET) && $_GET['search']!="")
{
	$appendFilter = " and (rc.cname like'%".$_GET['search']."%' OR rc.cmpname like'%".$_GET['search']."%' OR rc.cmpemail like'%".$_GET['search']."%' OR rc.mobile like'%".$_GET['search']."%' OR rc.role like'%".$_GET['search']."%') ";
}
else
{
	$appendFilter = "";				
}
*/
?>

<div class="row mt-30">
<div class="col-lg-12 white-bg">
<div class="row">
<div class="col-lg-10 col-md-9 col-8 color-yellow"><div class="detalis-area">Details</div></div>
<div class="col-lg-2 col-md-3 col-4 color-yellow"><div class="detalis-area">Action</div></div>
</div>

<?PHP

//echo"<pre>sess==";print_r($_SESSION);

if($_SESSION['designation']=="president")
{
	 $userSql = "select cmpid,cname,cmpname,sequence FROM "._PREFIX."client WHERE `status`=1 AND  sequence<>0 order by designation_seq,sequence asc";
}
else if($_SESSION['designation']=="admin")
{
	$userSql = "select cmpid,cname,cmpname,sequence FROM "._PREFIX."client WHERE `status`=1 AND  sequence<>0 order by designation_seq,sequence asc";
}
else
{

  $userSql = "select cmpid,cname,cmpname,sequence FROM "._PREFIX."client WHERE `status`=1 AND  sequence<>0 AND added_by='".$_SESSION['cmpid']."' order by sequence asc";	
}



$resQury = mysqli_query($conn,$userSql);
$chkRows = mysqli_num_rows($resQury);        

if($chkRows > 0)
{
$i=1;
$member = "";
while($fetch_data=mysqli_fetch_array($resQury))
{
	
	$cmpid				= $fetch_data["cmpid"];	
	$cname				= $fetch_data["cname"];	
	$cmpname			= utf8_decode($fetch_data["cmpname"]);
	//$imgpath			= $fetch_data["imgpath"];	
	$sequence			= $fetch_data["sequence"];	
	$member				.= $cmpid.",";	
	
	
?>
<div class="row generate">
<div class="col-lg-10 col-md-9 col-8"><div class="detalis-area">

<!--<div class="photo-1"><img src="<?php //echo BASE_URL.$imgpath?>" width="120px" height="120px"  alt="<?=$cname?>" title="<?=$cname?>"></br></div>-->

<div class="margin-top">
<h2 class="title-Generate"><?=$cname?> / <?=$cmpname?></h2>
<!--<div class="co-title-Generate"><?$cmpname?></div>-->
</div>
</div></div>
<div class="col-lg-2 col-md-3 col-4"><div class="action-area">

<?php if($sequence!=1) { ?>
<span onclick="Updata('<?=encode($cmpid);?>','<?=$sequence?>');" style="cursor:pointer;"><i class="icon-upload font-26"></i></span>
<?php } else {?>
<i class="icon-upload font-26"></i>
<?php } ?>

<span onclick="Downdata('<?php echo encode($cmpid);?>','<?=$sequence?>');" style="cursor:pointer;"><i class="icon-download font-26"></i></span>


<span onclick="deleteDataa('<?php echo encode($cmpid);?>');" class="icon-action btn-cross" style="cursor:pointer;"><i class="icon-trash font-26"></i></span>
                     


</div></div>
</div>

<?php $i++; } } else { ?>
<div class="col-lg-10 col-md-9 col-8">No Record</div>
<?php } ?>


</div>
</div>
<!-----onclick="GeneratePPT('$member');"------>
<?php if($chkRows > 0) { $dataJson = json_encode($member);?>
<form method="post" action="scripts/generateppt.php" name="pptgen">
<div class="flex-container">
<button type="submit" class="ppt-button" name="generateppt" id="generateppt" >Generate PPT</button>
<input type="hidden" name="hiddata" value="<?=rtrim($member, ',');?>">
<input type="hidden" name="type" value="n">
</div>
</form>

<?php } ?>
              
<script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>	
<script type="text/javascript">



$(function() {
	
	//autocomplete
	var data;
		$("#srchname").autocomplete({
	
			source: "ajax/pptsearch.php",
			minLength: 1,
			//autoFocus:true,
			
			select: function( event, ui ) {
			
				var cmpid =  ui.item.id ;
				var cmpname = ui.item.value;			
				//alert(cmpid)
				AddSearchValue(event,cmpid);

				
				//return false;
			  },	
			
			
		});	
		
		
		
		$('#srchname').focus();

	});
</script>

<script>

function AddSearchValue(evnt,cid)
{	
	//if (evnt.keyCode == 13) {		
UpdateTable(cid);	// update member name to generate  PPT//
		
	//}
	
}
function UpdateTable(id)
{
	$.ajax({
		type: "POST",
		url: "ajax/update.php",
		data:'cmpid='+id,
		success: function(data){
//alert(data)
		
			location.reload(true);
			$("#suggesstion-input").html(data);
			}
		});

}

 </script>


<!-- Content ends -->
<script type="text/javascript">
function Reset()
{
	document.location.href="dashboard.php?action=generate-ppt&mode=reset";
}



function Updata(cid,seq)
{
	document.location.href="dashboard.php?action=generate-ppt&d="+cid+"&seq="+seq+"&mode=up";
}

function Downdata(cid,seq)
{
	document.location.href="dashboard.php?action=generate-ppt&d="+cid+"&seq="+seq+"&mode=down";
}
</script>

 <script type="text/javascript">

function deleteDataa(id)
{
	var i=window.confirm("Are You Sure Want To Remove Details");
	if(i)
	{		
		document.location.href="dashboard.php?action=generate-ppt&d="+id+"&mode=delete";
	}	
}

function GeneratePPT(row)
{
	document.location.href="scripts/generateppt.php?data="+row+"&type=n";
}

</script>



<?php 

unset($_SESSION['errmsg']);
?>