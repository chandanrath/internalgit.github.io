
 <span class="popuptext" id="myPopup">
<?php if($_SESSION['roleid']=="1") { ?>
<a href="<?PHP echo ADMIN_PATH;?>default-admin" style="color:#000; text-decoration:none;">Dashboard</a>
<a href="<?PHP echo ADMIN_PATH;?>add-member" style="color:#000; text-decoration:none;">Add Member</a>
<a href="<?PHP echo ADMIN_PATH;?>memberlist" style="color:#000; text-decoration:none;">Edit Member</a>

<?php if($_SESSION['name']=="Admin") { ?>
<a href="<?PHP echo ADMIN_PATH;?>powerteam" style="color:#000; text-decoration:none;">Powerteam</a>
<?php } ?>

<a href="<?PHP echo ADMIN_PATH;?>sendsms" style="color:#000; text-decoration:none;">Send SMS</a>
<a href="<?PHP echo ADMIN_PATH;?>sendemail" style="color:#000; text-decoration:none;">Send Email</a>
<a href="<?PHP echo ADMIN_PATH;?>generate-ppt" style="color:#000; text-decoration:none;">Generate PPT</a>

<a href="<?PHP echo ADMIN_PATH;?>logout" style="color:#000; text-decoration:none;">Logout</a>
<?php } else {  ?>


<a href="<?PHP echo ADMIN_PATH;?>userprofile" style="color:#000; text-decoration:none;">My Profile</a>
<?php
if(($_SESSION['role']=="admin") || ($_SESSION['email']=="sumeet@rathinfotech.com")){
?>
<a href="<?PHP echo ADMIN_PATH;?>generate-ppt" style="color:#000; text-decoration:none;">Generate PPT</a>
<?php } ?>
<a href="<?PHP echo ADMIN_PATH;?>logout" style="color:#000; text-decoration:none;">Logout</a>
<?php }  ?>

</span>

  
  <?php // sahilsawant92@yahoo.co.in?>