<?php
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);

include_once('includes/define.php');

?>
<?php 
$chkSql = "select rc.cmpid,rc.cname,rc.cmpname,rc.cmpemail,rc.mobile,rc.powerteam,rc.ptid,rc.role,rc.website,rc.usp,rc.sequence,rc.designation,
rci.imgname,rci.imgpath
FROM "._PREFIX."client rc
JOIN "._PREFIX."client_img rci ON(rci.cmpid=rc.cmpid)
WHERE rc.`status`=1 AND rci.`status`=1 AND rc.mobverify=1 and rc.cmpid='".$_SESSION['cmpid']."'";	
$resSql = mysqli_query($conn,$chkSql);
$chkNum = mysqli_num_rows($resSql);
$mydata=mysqli_fetch_array($resSql);

?>

<div class="row mt-50 mb-30">
<div class="flex-container">
<div class="col-lg-10 col-md-12">

<div class="card p-20">
<div class="row">
<div class="col-lg-4 col-md-5">
<?php $imgpath = str_replace("../","",$mydata['imgpath']); ?>
<div class="photo"><img src="<?php echo BASE_URL.$imgpath?>" width="240px"  alt="<?=$mydata['cname']?>" title="<?=$mydata['cname']?>"/></div>
<div class="edit-icon">
<a href="javascript:void(0);" onclick="edit_data('<?php echo encode($mydata['cmpid']);?>','edit-userprofile');"><i class="icon-edit"></i></a></div>

<div class="preview-button"><button type="button" name="generateppt" id="generateppt" onclick="GeneratePPT('<?=$mydata['cmpid']?>');">Preview</button></div>
</div>
<div class="col-lg-7 col-md-5">
<h2 class="title-profile"><?=$mydata['cname']?></h2>
<div class="co-title-profile"><?=$mydata['cmpname']?></div>
<p><?=limitText($mydata['usp'],50)?></p>
<p class="tel-profile"><i class="icon-phone"></i> <a href="tel:+91<?=$mydata['mobile']?>">+91 <?=$mydata['mobile']?></a></p>
<p class="tel-profile"><i class="icon-email-icon"></i> <a href="mailto:<?=$mydata['cmpemail']?>"><?=$mydata['cmpemail']?></a></p>
<?php if(!empty($mydata['website'])) { 
$web = explode("https://",$mydata['website']);
if(isset($web[1])){ $website = $web[0].$web[1];} else $website = "https://".$web[0];
?>
<p class="tel-profile"><i class="icon-web"></i> <a href="<?=$website?>" target="_blank"><?=$mydata['website']?></a></p>
<?php } ?>
<?php if(!empty($mydata['dob'])) { ?>
<p class="tel-profile"><i class="icon-birthday-cake"></i><?=$mydata['dob']?></p>
<?php } ?>
<?php

$SqlPT = "select powerteam FROM "._PREFIX."powerteam WHERE status=1 AND id='".$mydata['ptid']."'";
	
$resSqlPT = mysqli_query($conn,$SqlPT);
$chkNumPT = mysqli_num_rows($resSqlPT);
$mydataPT=mysqli_fetch_array($resSqlPT);
?>

<?php if(!empty($mydata['powerteam'])) { ?>
<p class="tel-profile"><i class="icon-team"></i> <?=ucfirst($mydataPT['powerteam'])?> / <?=$mydata['designation']?></p>
<?php } ?>
</div>
<div class="col-lg-1 col-md-2">
<div class="edit-icon">
<a href="javascript:void(0);" onclick="edit_data('<?php echo encode($mydata['cmpid']);?>','edit-userprofile');"><i class="icon-edit"></i></a></div>
</div>
</div>
</div>

</div>
</div>
</div>
<!-- <div class="col-lg-4 col-md-6 col-sm-6"> -->
<!-- <div class="card"> -->
<!-- <div class="card-area"> -->
<!-- <div class="photo"><img src="images/photo-2.png"/></div> -->
<!-- <h2 class="title">Sumeet Mehta</h2> -->
<!-- <div class="co-title">Rath Infotech</div> -->
<!-- <p class="text-center">Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.</p> -->
<!-- <p class="tel"><i class="icon-phone"></i> <a href="tel:+919999097408">+91 9999097408</a></p> -->
<!-- <p class="tel"><i class="icon-email-icon"></i> <a href="mailto:sumeet@rathinfotech.com">sumeet@rathinfotech.com</a></p> -->
<!-- <p class="tel"><i class="icon-web"></i> <a href="https://www.rathinfotech.com">www.rathinfotech.com</a></p> -->
<!-- </div> -->
<!-- <div class="share"> <button type="button" class="btn" data-toggle="modal" data-target="#myModal"><i class="icon-share"></i></button></div> -->
<!-- <div class="ledership-area">Leadership Team</div> -->
<!-- </div> -->
<!-- </div> -->

</div>
</div>
</div>

</body>
<script>
function GeneratePPT(row)
{
	document.location.href="scripts/randomgenppt.php?data="+row+"&type=pre";
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
// When the user clicks on div, open the popup
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
</html>