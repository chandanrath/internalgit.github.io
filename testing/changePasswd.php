 
 <?php 

ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


//echo"<pre>";print_r($_SESSION);exit;

	$operation	=	'edit';
	$ID	=	substr(decode($_REQUEST['d']),2);
	$SQL_QUERY="SELECT password FROM "._PREFIX."users WHERE status='1' and username='".$_SESSION['ref_name']."'";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);

	$oldPassword	= substr(decode($arr[0]['password']),2);		
	$created_by		= $_SESSION['ref_id'];

?>

<!-- Main content starts -->

<div class="content">  

  	<!-- Main bar -->
  	<div class="mainbar">
      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">Change Password
          <!-- page meta -->
          
        </h2>


        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">Change Password </a>
        </div>

        <div class="clearfix"></div>

	    </div>
	    <!-- Page heading ends -->

	    <!-- Matter -->

	    <div class="matter">
        <div class="container">

          <div class="row">

            <div class="col-md-12">

              <div class="widget wred">
                <div class="widget-head">
                  <div class="pull-left">Change Password</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                    <a href="#" class="wclose"><i class="icon-remove"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">
                  <div class="padd">
                    
                    <!-- Profile form -->

					<?php
						if(isset($_GET['res']))
						{
							if($_GET['res']=='success')
							{
						?>
								<div id='msg' style='display:;text-align:center;color:red;'> <?php echo "Password Changed Successfully"?></div>
					<?php
							}
						}else{
							echo "<div id='msg' style='display:none;text-align:center;color:red;'></div>";
						}
				  ?>

					<div id="error" style="display:none; text-align:center;color:red;"> </div>
                   
					<div class="form profile">
					  <!-- Edit profile form (not working)-->
					
					   <form  method="post" class="form-horizontal" name="ChangePasswdForm" onsubmit="return ChangePasswd()">
						  <!-- Name -->
						  <div class="form-group">
							<label class="control-label col-lg-6" for="oldPassword">Old Password</label>
							<div class="col-lg-6">
							  <input type="password" class="form-control" name="oldPassword" id="oldPassword" value="<?php echo $oldPassword; ?>" readonly>
							</div>
						  </div>   
						 
						  <div class="form-group">
							<label class="control-label col-lg-3" for="newPasswd">New Password</label>
							<div class="col-lg-6">
							  <input type="password" class="form-control" name="newPasswd" id="newPasswd"  value="">
							</div>
						  </div>

						  <div class="form-group">
							<label class="control-label col-lg-3" for="cnfrmPasswd">Confirm Password</label>
							<div class="col-lg-6">
							  <input type="password" class="form-control" name="cnfrmPasswd" id="cnfrmPasswd"  value="">
							</div>
						  </div>
						 
						 
						
						  <!-- Buttons -->
						  <div class="form-group">
							 <!-- Buttons -->
							 <div class="col-lg-6 col-lg-offset-3">
								<input type="submit" class="btn btn-success" name="Success" id="submit" value="Submit"/>
								<input type="reset" class="btn btn-default" />

							</div>
						  </div>
							<input type="hidden" id="operation" name="operation" value="<?PHP echo $operation;?>" />
							<input type="hidden" id="manager_id" name="manager_id" value="<?PHP echo $_REQUEST['d'];?>" />
					  </form>
					</div>

                  </div>
                </div>
              </div>  
              
            </div>

          </div>

        </div>
		  </div>

		<!-- Matter ends -->

    </div>

   <!-- Mainbar ends -->	    	
   <div class="clearfix"></div>

</div>
<!-- Content ends -->



<!-- Scroll to top -->


