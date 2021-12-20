
 <?php 

 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


if($_REQUEST['mode']=='edit')
{
	$operation	=	'edit';
	$ID	=	substr(decode($_REQUEST['d']),2);
	$SQL_QUERY="SELECT * FROM ri_users WHERE  id='".$ID."'";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);
	
	$name		=$arr['name'];	
	$email		=$arr['email'];	
	$category	=$arr['category'];
	$role		=$arr['role'];
	$ractive		=$arr['role_active'];
	

	
}else{
	$operation	=	'add_new';

}


?>

<!-- Main content starts -->

<div class="content">

  	<!-- Main bar -->
  	<div class="mainbar">
      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">User Profile
          <!-- page meta -->
          
        </h2>
        
        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">User Profile  </a>
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
                  <div class="pull-left">User Profile</div>
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
								<div id='msg' style='display:;text-align:center;color:red;'> <?php echo "Email Id Already Registered"?></div>
					<?php
							}
						}else{
							echo "<div id='msg' style='display:none;text-align:center;color:red;'></div>";
						}
				  ?>

					<div id="error" style="display:none; text-align:center;color:red;"> </div>
                   
					<div class="form profile">
					  <!-- Edit profile form (not working)-->					
					   <form  method="post" class="form-horizontal" action="scripts/insert_users.php" name="usersForm"  id="usersForm" onSubmit="return users_register();">
						  <!-- Name -->
						  <div class="form-group">
							<label class="control-label col-lg-6" for="name">Full Name</label>
							<div class="col-lg-6">
							  <input type="text" class="form-control" name="name" id="name"  value="<?php echo (isset($name)?$name:""); ?>">
							</div>
						  </div>						 
						
						  <?php if(isset($email)) { 
							$readonly = 'readonly="readonly"';
						  }else{
							$readonly ='';
						  }
						  ?>
						  <div class="form-group">
							<label class="control-label col-lg-3" for="email">Email</label>
							<div class="col-lg-6">			
							  <input type="text" class="form-control" name="email" id="email"  value="<?php echo (isset($email)?$email:""); ?>" <?php echo $readonly; ?> >
							
							</div>
						  </div>
						 
                        
                        <div class="form-group" id="setrole">
						  <label class="col-lg-4 control-label">Role</label>
						  <div class="col-lg-4">
							<select class="form-control" name="role" id="role" onchange="UserRole(this.value);" >
                            <option value="0" >Select Role</option>
							<?php 									
								$qry_role ="SELECT roleid,name,code FROM "._PREFIX."role WHERE status=1";
								$resRole = mysqli_query($conn,$qry_role);
								$numRole = mysqli_num_rows($resRole);								
								if ($numRole > 0) {								
								while($roles = mysqli_fetch_array($resRole)) {										
							?>
							
							  <option value="<?php echo $roles['code'];?>" <?php echo($roles['code']==$role)?'selected="selected"':''; ?>><?php echo $roles['name'];?></option>

							  <?php } }else{ ?>
								<option value="0" >No Role found</option>
							 <?php } ?>

							</select>
						  </div>
						</div>
                        
                        <div class="form-group" id="roleactive" style="display:none;">
							<label class="col-lg-4 control-label">Role Active</label>
							
                            <div class="col-lg-4">			
							 Yes <input type="radio" name="ractive" id="ractive" value="1" <?php if($ractive==1)echo"checked='checked'";?>>			
                             No <input type="radio" name="ractive" id="ractive" value="0" <?php if($ractive==0)echo"checked='checked'";?>>							
							</div>
                            
						  </div>
                       
						  <!-- Buttons -->
						  <div class="form-group">
							 <!-- Buttons -->
							 <div class="col-lg-6 col-lg-offset-3">
								<input type="submit" class="btn btn-success" name="Success" id="submit"  value="Submit"/>								
								<button type="button" class="btn btn-default" onclick="cancel('users_list')">Cancel</button>

							</div>
						  </div>
							<input type="hidden" id="operation" name="operation" value="<?PHP echo $operation;?>" />
							<input type="hidden" id="users_id" name="users_id" value="<?PHP echo $_REQUEST['d'];?>" />
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

function UserRole(rid)
{
	
	var role = document.getElementById('role').value;
	//alert(role)
	if(role=='dataentry')
	{
		document.getElementById('roleactive').style.display='';	
	}
	else
	{
		document.getElementById('roleactive').style.display='none';	
	}
	
}
UserRole('<?php echo $role; ?>');
</script>
<script>
function users_register()
{
	var name = document.getElementById('name').value;
	var email = document.getElementById('email').value;
	var role = document.getElementById('role').value;
	
	if(name=="")
	{
		alert("Please Enter Full Name")	;
		document.getElementById('name').focus();
		return false
	}
	if(email=="")
	{
		alert("Please Enter Email ID")	;
		document.getElementById('email').focus();
		return false
	}
	if(email!="")
	{
		var regexp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regexp.test(email)) {
			
			alert("Please Valid Email ID");				
			document.getElementById("email").focus();
			return false;
		}
	}
	if(role=="0")
	{
		alert("Please Select Role")	;
		document.getElementById('role').focus();
		return false
	}
	
	
	
}

</script>