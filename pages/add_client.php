
 <?php 

 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


if($_REQUEST['mode']=='edit')
{
	$operation	=	'editclient';
	$ID	=	decode($_REQUEST['d']);
	$SQL_QUERY="SELECT * FROM ri_client WHERE  cmpid='".$ID."' and status=1";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);
	
	$cmpname	=$arr['cmpname'];
	$name		=$arr['cname'];
	$email		=$arr['cmpemail'];	
	$phone		=$arr['phone'];
	$mobile		=$arr['mobile'];	
	$credit		=$arr['mailcredit'];
	$address	=$arr['address'];
	$website	=$arr['website'];
	
}else{
	$operation	=	'addclient';

}


?>

<!-- Main content starts -->

<div class="content">

  	<!-- Main bar -->
  	<div class="mainbar">
      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">Add Client
          <!-- page meta -->
          
        </h2>
        
        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>default"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">Add Client  </a>
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
                  <div class="pull-left">Add Client</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                   
                  </div>
                  <div class="clearfix"></div>
                </div>
				<div class="pull-right">All Fields are mandatory.</div>

                <div class="widget-content">
                  <div class="padd">
                    
                    <!-- Profile form -->

					<?php
					//echo"<pre>sess=";print_r($_SESSION);
					
						if(isset($_SESSION['error']))
						{
							if($_SESSION['error']=='duplicate')
							{
						?>
								<div id='msg' style='display:;text-align:center;color:red;'> <?php echo "Client Already Registered"?></div>
					<?php
							}
						}else{
							echo "<div id='msg' style='display:none;text-align:center;color:red;'></div>";
						}
				  ?>

					<div id="error" style="text-align:center;color:red;"> </div>
                   
					<div class="form profile">
					 				
					   <form  method="post" class="form-horizontal" action="scripts/insert_details.php" name="usersReg"  id="usersReg" onSubmit="return ClientRegister();">
                        			 
						
						  <!-- Name -->
						  <div class="form-group">
							<label class="control-label col-lg-6" for="name">Client Name<span style="color:#F00"> *</span></label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="name" id="name"  value="<?php echo (isset($name)?$name:""); ?>">
							</div>
						  </div>
                          <div class="form-group">
							<label class="control-label col-lg-6" for="name">Company Name<span style="color:#F00"> *</span></label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="cmpname" id="cmpname"  value="<?php echo (isset($cmpname)?$cmpname:""); ?>">
							</div>
						  </div>
                          
                          <div class="form-group">
							<label class="control-label col-lg-6" for="name">Client Email<span style="color:#F00"> *</span></label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="email" id="email"  value="<?php echo (isset($email)?$email:""); ?>">
							</div>
						  </div>
                          <div class="form-group">
							<label class="control-label col-lg-6" for="name">Phone.</label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="phone" id="phone"  value="<?php echo (isset($phone)?$phone:""); ?>" onkeypress="return isNumberKey(event);">
							</div>
						  </div>
                          <div class="form-group">
							<label class="control-label col-lg-6" for="name">Mobile No.<span style="color:#F00"> *</span></label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="mobile" id="mobile"  value="<?php echo (isset($mobile)?$mobile:""); ?>" onkeypress="return isNumberKey(event);">
							</div>
						  </div>
                          
                          <div class="form-group">
							<label class="control-label col-lg-6" for="name">Address<span style="color:#F00"> *</span></label>
							<div class="col-lg-6">
							  <textarea class="form-control" name="address" id="address" ><?php echo (isset($address)?$address:""); ?></textarea>
							</div>
						  </div>
                          
                          <div class="form-group">
							<label class="control-label col-lg-6" for="name">Website</label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="website" id="website"  value="<?php echo (isset($website)?$website:""); ?>" >
							</div>
						  </div>
                        		 
						
						  <div class="form-group">
							
							 <div class="col-lg-6 col-lg-offset-3">
								<input type="submit" class="btn btn-success" name="submit" id="submit"  value="Submit"/>								
								<button type="button" class="btn btn-default" onclick="cancel('client')">Cancel</button>

							</div>
						  </div>
							<input type="hidden" id="operation" name="operation" value="<?PHP echo $operation;?>" />
							<input type="hidden" id="userid" name="userid" value="<?PHP echo $_REQUEST['d'];?>" />
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
<script>
function ClientRegister()
{
	var name = document.forms["usersReg"]["name"].value;
	var cmpname = document.forms["usersReg"]["cmpname"].value;
	var email = document.forms["usersReg"]["email"].value;
	var phone = document.forms["usersReg"]["phone"].value;
	var mobile = document.forms["usersReg"]["mobile"].value;
	var address = document.forms["usersReg"]["address"].value;
	
	if(name=="")
	{
		document.getElementById('error').innerHTML="Please Enter Users Name";
		document.forms["usersReg"]["name"].focus();
		return false
	}
	if(cmpname=="")
	{
		document.getElementById('error').innerHTML="Please Enter Company Name";
		document.forms["usersReg"]["cmpname"].focus();
		return false
	}
	if(email=="")
	{
		document.getElementById('error').innerHTML="Please Enter Company Email";
		document.forms["usersReg"]["email"].focus();
		return false
	}
	if(email!="")
	{
		var regexp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regexp.test(email)) {
			
			document.getElementById('error').innerHTML="Please Enter Valid Email Id";
			document.getElementById("email").focus();
			return false;
		}
	}
	if(phone!="")
	{
		
		if(!phone.match(/^\d+/))
		{
			document.getElementById('error').innerHTML="Phone Number Should Numeric";
			document.getElementById("phone").focus();
			return false;
		}
	   
	}
	if(mobile=="")
	{
		document.getElementById('error').innerHTML="Please Enter Mobile No.";
		document.getElementById("mobile").focus();
		return false
	}
	if(!mobile.match(/^\d+/))
	{
		document.getElementById('error').innerHTML="Mobile Number Should Numeric";
		document.getElementById("mobile").focus();
		return false;
	}
	if(address=="")
	{
		document.getElementById('error').innerHTML="Please Enter Address";
		document.getElementById("address").focus();
		return false
	}
	
	
	
}

</script>