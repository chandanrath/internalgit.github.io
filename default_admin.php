<?php
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);

include_once('includes/define.php');

?>


<div class="row mt-200">
<div class="flex-container">
<div class="col-lg-10 col-md-12">

<div class="row">

<div class="col-lg-3 deshbaord-icon">
<a href="dashboard.php?action=add-member">
<div class="card p-20">
<div class="row">
<div class="col-lg-4"><i class="icon-add-user f-45"></i></div>
<div class="col-lg-8 font-15">Add Member</div>
</div>
</div>
</a>
</div>

<div class="col-lg-3 deshbaord-icon">
<a href="dashboard.php?action=memberlist">
<div class="card p-20">
<div class="row">
<div class="col-lg-4"><i class="icon-edit-user f-45"></i></div>
<div class="col-lg-8 font-15">Edit Member</div>
</div>
</div>
</a>
</div>

<div class="col-lg-3 deshbaord-icon">
<a href="dashboard.php?action=sendsms">
<div class="card p-20">
<div class="row">
<div class="col-lg-4"><i class="icon-massage f-45"></i></div>
<div class="col-lg-8 font-15">Send SMS</div>
</div>
</div>
</a>
</div>

<div class="col-lg-3 deshbaord-icon">
<a href="dashboard.php?action=sendemail">
<div class="card p-20">
<div class="row">
<div class="col-lg-4"><i class="icon-email-icon f-45"></i></div>
<div class="col-lg-8 font-15">Send Email</div>
</div>
</div>
</a>
</div>
</div>
</div>
</div>
</div>

<div class="flex-container">
    <div class="col-lg-3 col-md-3 deshbaord-icon">
    <a href="dashboard.php?action=generate-ppt">
    <div class="card p-20 color-yellow">
    <div class="row">
    <div class="col-lg-4"><i class="icon-ppt f-55"></i></div>
    <div class="col-lg-8 font-15">Generate PPT</div>
    </div>
    </div>
    </a>
    </div>

	<div class="col-lg-3 col-md-3 deshbaord-icon">
    <a href="javascript:void(0);" onclick="window.location='scripts/randomgenppt.php?type=r'">
    <div class="card p-20 color-yellow">
    <div class="row">
    <div class="col-lg-4"><i class="icon-ppt f-55"></i></div>
    <div class="col-lg-8 font-15">Generate PPT (Random)</div>
    </div>
    </div>
    </a>
    </div>

	<div class="col-lg-3 col-md-3 deshbaord-icon">
    <a href="javascript:void(0);" onclick="window.location='scripts/randomgenppt.php?type=rp'">
    <div class="card p-20 color-yellow">
    <div class="row">
    <div class="col-lg-4"><i class="icon-ppt f-55"></i></div>
    <div class="col-lg-8 font-15">Generate PPT (Random by Powerteam)</div>
    </div>
    </div>
    </a>
    </div>
</div>





</div>
