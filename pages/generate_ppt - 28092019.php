<?PHP
ob_start();
session_start();

if($_GET['mode']=='delete')
{
	$ID	=	decode($_REQUEST['d']);
	$update = "update "._PREFIX."client set sequence='0' where status=1 and cmpid='".$ID."'";
	mysqli_query($conn, $update);
	$updateSeq = "update "._PREFIX."client_seq set status='2' where cmpid='".$ID."' and created_date='".date('Y-m-d')."'";
	mysqli_query($conn, $updateSeq);
	
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
	
	$updateOld1 = "update "._PREFIX."client_seq set sequence=".$oldSeq." where status=1 and sequence='".$clickSeq."' and created_date='".date('Y-m-d')."'";
	mysqli_query($conn, $updateOld1);

	$updateClk1 = "update "._PREFIX."client_seq set sequence=".$clickSeq." where status=1 and cmpid='".$ID."'";
	mysqli_query($conn, $updateClk1);

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
	
	$updateOld1 = "update "._PREFIX."client_seq set sequence=".$oldSeq." where status=1 and sequence='".$clickSeq."' and created_date='".date('Y-m-d')."'";
	mysqli_query($conn, $updateOld1);

	$updateClk1 = "update "._PREFIX."client_seq set sequence=".$clickSeq." where status=1 and cmpid='".$ID."'";
	mysqli_query($conn, $updateClk1);
	
	echo '<script>
			document.location.href="dashboard.php?action=generate-ppt";
		</script>';
}
if($_GET['mode']=='reset')
{
	;
	$update = "update "._PREFIX."client set sequence='0',sequence_date='' where status=1 ";
	mysqli_query($conn, $update);
	
	
	echo '<script>
			document.location.href="dashboard.php?action=generate-ppt";
		</script>'; 
		
}


?>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- jQuery UI library -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
jQuery(document).ready(function($) {
    $("#srchname").autocomplete({

	
        source: "ajax/autocomplete-search.php",

		select: function( event, ui ) {
            //event.preventDefault();
			
			alert(ui.item.id);
          return false;
            $("#outputbox").val(ui.item.id);
        }
    });
});
</script>
<div class="row mt-30">
<div class="col-lg-12">

<!---------onkeydown="onkeypressed(event, this);" ------>
<div class="valid-input">
  <input class="form-control form-control-sm w75" type="text" name="srchname" id="srchname" placeholder="Search By Member"  aria-label="Search" autocomplete="off" >
	<i class="fa fa-search p7" aria-hidden="true"></i>	
</div>	
<div id="outputbox"></div>


</div>

<button type="button" class="btn button-area" onclick="Reset()">Reset</button>
</div>

<?php
if(isset($_GET) && $_GET['search']!="")
{
	$appendFilter = " and (rc.cname like'%".$_GET['search']."%' OR rc.cmpname like'%".$_GET['search']."%' OR rc.cmpemail like'%".$_GET['search']."%' OR rc.mobile like'%".$_GET['search']."%' OR rc.role like'%".$_GET['search']."%') ";
}
else
{
	$appendFilter = "";				
}
?>




<div class="row mt-30">
<div class="col-lg-12 white-bg">
<div class="row">
<div class="col-lg-10 col-md-9 col-8 color-yellow"><div class="detalis-area">Details</div></div>
<div class="col-lg-2 col-md-3 col-4 color-yellow"><div class="detalis-area">Action</div></div>
</div>

<?PHP
		            

 //$userSql = "select rc.cmpid,rc.cname,rc.cmpname,rc.cmpemail,rc.sequence,rci.imgname,rci.imgpath
//FROM "._PREFIX."client rc
//JOIN "._PREFIX."client_img rci ON(rci.cmpid=rc.cmpid)
//WHERE rc.`status`=1 AND rci.`status`=1 AND rc.mobverify=1 ".$appendFilter." order by rc.sequence asc";	

$userSql = "SELECT cmpid,cname,cmpname,sequence,status from "._PREFIX."client_seq where status=1 and created_date='".date('Y-m-d')."' order by sequence asc";

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
	$cmpname			= $fetch_data["cmpname"];
	//$imgpath			= $fetch_data["imgpath"];	
	$sequence			= $fetch_data["sequence"];	
	$member				.= $cmpid.",";	
	
	//$imgpath = str_replace("../","",$fetch_data['imgpath']);

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

<span onclick="Downdata('<?php echo encode($cmpid);?>','<?=$sequence?>');"><i class="icon-download font-26"></i></span>


<span onclick="deleteDataa('<?php echo encode($cmpid);?>');" class="btn btn-sm btn-cross"><i class="icon-trash font-26"></i></span>
                     


</div></div>
</div>

<?php $i++; } } else { ?>

<?php } ?>


</div>
</div>

<?php if($chkRows > 0) { $dataJson = json_encode($member);?>
<div class="flex-container">
<button type="button" class="ppt-button" name="generateppt" id="generateppt" onclick="GeneratePPT('<?=$member?>');">Generate PPT</button>

</div>

<?php } ?>
              
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
	document.location.href="scripts/generateppt.php?data="+row;
}

</script>




<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>-->
   <script>
/*
function onkeypressed(evt, input) {

    var code = evt.charCode || evt.keyCode;

    if (code == 27) {
        input.value = '';
    }
	else
	{
		$.ajax({
			type: "POST",
			url: "ajax/autocomplete-search.php",
			data:'keyword='+$(this).val(),
			success: function(data){
	
	alert(data)
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
			}
			});
	}
}



    $(document).ready(function(){

	$("#srchname").keyup(function(event){
	
		var code = event.charCode || event.keyCode;
	//alert(code)
		if (code == 27) {
			$("#srchname").val('');
		}

		$.ajax({
		type: "POST",
		url: "ajax/autocomplete-search.php",
		data:'keyword='+$(this).val(),
		success: function(data){

//alert(data)
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
		}
		});
	});
});
*/


function selectClient(val) {
var res = val.split("-");
alert(res[1])
$("#srchname").val(res[1]);

UpdateTable(res[0])

$("#suggesstion-box").hide();
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
			$("#suggesstion-box").html(data);
			}
		});

}

 </script>
				

<?php 

unset($_SESSION['errmsg']);
?>