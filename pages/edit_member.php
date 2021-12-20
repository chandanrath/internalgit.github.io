
 <?php 

 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


if($_REQUEST['mode']=='edit')
{
	$operation	=	'editclient';
	$ID	=	decode($_REQUEST['d']);
	$SQL_QUERY="SELECT * FROM "._PREFIX."client WHERE  cmpid='".$ID."'";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);
	
	$name			=$arr['cname'];	
	$cmpname		=$arr['cmpname'];	
	$cmpemail		=$arr['cmpemail'];	
	$mobile			=$arr['mobile'];	
	$powerteam		=$arr['powerteam'];
	$ptid			=$arr['ptid'];	
	$status			=$arr['status'];	
	$dob			=$arr['dob'];	
	$website		=$arr['website'];
	$usp			=$arr['usp'];	
	$role			=$arr['role'];
	$roleid			=$arr['roleid'];
	$designation	=$arr['designation'];
	$sitsequence	=$arr['sitsequence'];
	
	
}


?>

<div class="row mt-50">
<div class="flex-container">
<div class="col-lg-10 col-md-12">
<div class="card p-20">

<form  method="post" class="form-horizontal" action="scripts/insert_users.php" name="usersForm"  id="usersForm" onSubmit="return UsersRegister();" enctype="multipart/form-data">

<?php
	$QUERYIMG="SELECT id,imgname,imgpath FROM "._PREFIX."client_img WHERE  cmpid='".$ID."'";	
	$resultImg= mysqli_query($conn,$QUERYIMG);
	$rowsImg = mysqli_num_rows($resultImg);
	$arrImg = mysqli_fetch_array($resultImg);
	$imgname = $arrImg['imgname'];
	$image_path = str_replace("../","",$arrImg['imgpath']);
	
?>
<div class="row">

<div class="col-lg-4 col-md-5">

<div class="photo">
<?php if(!empty($image_path)) { echo '<img src="'.BASE_URL.$image_path .'" width="240px"/>'; } else { echo"images/black-image.png";} ?> 
</div>

<div class="box" style="height:42px;">
<input type="file" name="logo" id="logo" class="custom-file-upload" alt="Image Should be JPG,PNG,GIF">
<input type="hidden" name="hid_logo" id="hid_logo"  value="<?php echo (!empty($imgname)?$imgname:''); ?>">

</div><span class="error" id="errlogo" style="text-align:center"></span>



</div>

    <div class="col-lg-7 col-md-7">
    
    <div class="inpurt-form">
<?php if($_SESSION['role']=="user") { ?>
    <input type="text" name="name" id="name"  value="<?php echo (isset($name)?$name:""); ?>"  <?php echo ($name!="")?"readonly='readonly'":""; ?> placeholder="Name" class="input-name"></input>
<?php } else { ?>
<input type="text" name="name" id="name"  value="<?php echo (isset($name)?$name:""); ?>"   placeholder="Name" class="input-name"></input>
<?php }  ?>
    <span class="error" id="errname"></span>
    </div>
    <div class="inpurt-form">
    <input type="text" name="cmpname" id="cmpname"  value="<?php echo (isset($cmpname)?$cmpname:""); ?>" placeholder="Company Name" class="input-name" ></input>
    <span class="error" id="errcmpname"></span>
    </div>
    <div class="inpurt-form">
    <textarea type="text" name="usp" id="usp" onKeyUp="return CheckWord();" placeholder="Description" class="input-name" ><?php echo (isset($usp)?$usp:""); ?></textarea>
	<small class="form-text text-muted">Count Should be maximum 150 characters.<span class="pull-right" id="charecter">0 / 150</span></small>
    <span class="error" id="errusp"></span>
    </div>
    <div class="inpurt-form">
<?php if($_SESSION['roleid']=="2") { ?>
    <input type="text" name="mobile" id="mobile"  value="<?php echo (isset($mobile)?$mobile:""); ?>" onkeypress="return isNumberKey(event);" <?php echo ($mobile!="")?"readonly='readonly'":""; ?> placeholder="Phone No." class="input-name" maxlength="10" ></input>
<?php } else { ?>
 <input type="text" name="mobile" id="mobile"  value="<?php echo (isset($mobile)?$mobile:""); ?>" onkeypress="return isNumberKey(event);" placeholder="Phone No." class="input-name" maxlength="10" ></input>
<?php } ?>
    <span class="error" id="errmobile"></span>
    </div>
    <div class="inpurt-form">
    <input type="text" name="cmpemail" id="cmpemail"  value="<?php echo (isset($cmpemail)?$cmpemail:""); ?>" placeholder="Email" class="input-name" ></input>
    <span class="error" id="erremail"></span>
    </div>
    <div class="inpurt-form">
    <input type="text" name="website" id="website"  value="<?php echo (isset($website)?$website:""); ?>" placeholder="Website" class="input-name" ></input>
    <span class="error" id="errwebsite"></span>
    </div>
    <div class="inpurt-form">
    <input type="text" name="dob" id="datepicker"  value="<?php echo (isset($dob)?$dob:""); ?>" placeholder="Date of Birth" class="input-name calender" >
    <span class="error" id="errdob"></span>
    </div>
    <div class="inpurt-form">
     <?php 
		$SQL_TEAM="SELECT id,powerteam,code FROM ri_powerteam WHERE  status=1  order by powerteam ASC";	
		$resultTeam = mysqli_query($conn,$SQL_TEAM);
		$rowsCmp = mysqli_num_rows($resultTeam);
	   
	?>
	 <select name="powerteam" id="powerteam" class="input-name" placeholder="Power Team">
        <option value="0" selected="selected">Select Power Team</option> 
		<?php 
		$k=1;
		if($rowsCmp > 0) {
			while($arrValCmp = mysqli_fetch_array($resultTeam))
			  {
		?>
			<option value="<?=$arrValCmp['id']?>" <?php if($ptid==$arrValCmp['id']) echo "selected='selected'";?> ><?=$arrValCmp['powerteam']?></option>
			
		<?php } } else { ?>    
		<option> No record Found </option>
		<?php } ?> 
      
      
      </select>
	
    <span class="error" id="errpteam"></span>
    </div>
	<div class="inpurt-form">
    
	 <select name="role" id="role" class="input-name" placeholder="Role" onchange="DesignationChng();">
        <option value="0" selected="selected">Select Role</option>
         <option value="user" <?php if($roleid=="2")echo "selected='selected'";?>> Users </option>
 		 <option value="admin" <?php if($roleid=="1")echo "selected='selected'";?>> Admin </option>
      </select>
    <span class="error" id="errrole"></span>
    </div>

	<div class="inpurt-form" id="designation" style="display:none">    
	 <select name="cmpdesign" id="cmpdesign" class="input-name" placeholder="Designation">
        <option value="0" selected="selected">Select Designation</option>
         <option value="president" <?php if($designation=="president")echo "selected='selected'";?>> President </option>
 		 <option value="vice-president" <?php if($designation=="vice-president")echo "selected='selected'";?>> Vice-President </option>
		<option value="treasurer" <?php if($designation=="treasurer")echo "selected='selected'";?>> Treasurer </option>
      </select>
		<span class="error" id="errcmpdesig"></span>     
    </div>

	<div class="inpurt-form" id="designationUser" style="display:none">
    <input type="text" name="desiguser" id="desiguser" value="<?php echo (isset($designation)?ucfirst($designation):""); ?>" placeholder="Designation" class="input-name" >
    <span class="error" id="errdesig"></span>
    </div>

	<div class="inpurt-form" id="sitsequence" style="display:none">    
	 <select name="sequence" id="sequence" class="input-name" placeholder="Sitting Sequence">
        <option value="0" selected="selected">Select sequence</option>
         <option value="1" <?php if($sitsequence=="1")echo "selected='selected'";?>> 1 </option>
 		 <option value="2" <?php if($sitsequence=="2")echo "selected='selected'";?>> 2 </option>
		<option value="3" <?php if($sitsequence=="3")echo "selected='selected'";?>> 3 </option>
      </select>
    
    </div>


    <div class="login-button">
    
	<input type="submit" class="btn button-area mr-30" name="Success" id="submit"  value="Submit"/>
	<button type="button" class="btn button-area" onclick="cancel('memberlist')">Cancel</button>

	<input type="hidden" id="operation" name="operation" value="<?PHP echo $operation;?>" />
	<input type="hidden" id="clientid" name="clientid" value="<?PHP echo $_REQUEST['d'];?>" />
	<input type="hidden" id="roleid" name="roleid" value="<?PHP echo $roleid;?>" />	
    </div>
    
    </div>

</div>
</form>

</div>
</div>
</div>
</div>


<script>
function DesignationChng()
{
	var rolVal = document.getElementById("role").value;

	if(rolVal=="admin")
	//if(rolVal=="1")
	{
		document.getElementById('designation').style.display="";	
		document.getElementById('sitsequence').style.display="";	
		document.getElementById('designationUser').style.display="none";	
	}
	else
	{
		document.getElementById('designationUser').style.display="";
		document.getElementById('designation').style.display="none";
		document.getElementById('sitsequence').style.display="none";
	}
}
DesignationChng();
</script>
<!-- Main content starts -->


<script>

function UsersRegister()
{

	var name = document.forms["usersForm"]["name"].value;
	var cmpname = document.forms["usersForm"]["cmpname"].value;
	var usp = document.forms["usersForm"]["usp"].value;
	var mobile = document.forms["usersForm"]["mobile"].value;
	var cmpemail = document.forms["usersForm"]["cmpemail"].value;	
	var website = document.forms["usersForm"]["website"].value;	
	var role = document.forms["usersForm"]["role"].value;
	var powerteam = document.forms["usersForm"]["powerteam"].value;
	
	if(name=="")
	{
		document.getElementById('errname').innerHTML= "Please Enter Name";
		document.forms["usersForm"]["name"].focus();
		return false
	}
	else
	{
		document.getElementById('errname').innerHTML= "";
		
	}
	if(cmpname=="")
	{
		document.getElementById('errcmpname').innerHTML= "Please Enter Company Name"	;
		document.forms["usersForm"]["cmpname"].focus();
		return false
	}
	else
	{
		document.getElementById('errcmpname').innerHTML= "";
		
	}
	if(usp=="")
	{
		document.getElementById('errusp').innerHTML= "Please Enter USP"	;
		document.forms["usersForm"]["usp"].focus();
		return false
	}
	else
	{
		document.getElementById('errusp').innerHTML= "";
		
	}
	if(usp!="")
	{
		
		if(usp.length > 150)
		{
			document.getElementById('errusp').innerHTML= "USP Content Not More Then 150"	;
			document.forms["usersForm"]["usp"].focus();
			return false
		}
		else
		{
			document.getElementById('errusp').innerHTML= "";
			
		}		
	}
	if(mobile=="")
	{
		document.getElementById('errmobile').innerHTML= "Please Enter Mobile"	;
		document.forms["usersForm"]["mobile"].focus();
		return false
	}
	else
	{
		document.getElementById('errmobile').innerHTML= "";
		
	}
	if((mobile.length != 10))
	{
		document.getElementById('errmobile').innerHTML= "Mobile Number Should be 10 Digit"	;
		document.forms["usersForm"]["mobile"].focus();
		return false
	}
	else
	{
		document.getElementById('errmobile').innerHTML= "";
		
	}
	if(!mobile.match(/^\d+/))
	{
		document.getElementById('errmobile').innerHTML="Mobile Number Should Numeric";
		document.forms["usersForm"]["mobile"].focus();
		return false;
	}
	else
	{
		document.getElementById('errmobile').innerHTML= "";
		
	}
	if(cmpemail=="")
	{
		
		document.getElementById('erremail').innerHTML= "Please Enter Email ID"	;	
		document.forms["usersForm"]["cmpemail"].focus();
		return false
	}
	else
	{
		document.getElementById('erremail').innerHTML= "";
		
	}
	if(cmpemail!="")
	{
		var regexp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regexp.test(cmpemail)) {
			
			document.getElementById('erremail').innerHTML= "Please Valid Email ID"	;		
			document.forms["usersForm"]["cmpemail"].focus();
			return false;
		}
	}
	else
	{
		document.getElementById('erremail').innerHTML= "";
		
	}
	/*if(website!="")
	{
		var re = /(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		
		if (!re.test(website)) { 
			document.getElementById('errwebsite').innerHTML= "Please Valid Website"	;		
			document.forms["usersForm"]["website"].focus();
			return false;
		}		
	}	
	else
	{
		document.getElementById('errwebsite').innerHTML= "";
		
	}*/
	if(powerteam=="0")
	{	
		document.getElementById('errpteam').innerHTML= "Please Select Power Team"	;	
		document.forms["usersForm"]["powerteam"].focus();
		return false
	}
	else
	{
		document.getElementById('errpteam').innerHTML= "";
		
	}

	if(role=="0")
	{
		document.getElementById("errrole").style.display = "";
		document.getElementById("errrole").innerHTML = 'Please Select Role.';	
		document.forms["usersForm"]["role"].focus();
		return false
	}
	else
	{
		document.getElementById('errrole').innerHTML= "";
		
	}

	if(role!="0")
	{
		/*if(role=="user")
		{
			if(document.forms["usersForm"]["desiguser"].value=="")
			{
				document.getElementById("errdesig").style.display = "";
				document.getElementById("errdesig").innerHTML = 'Please Enter Designation.';	
				document.forms["usersForm"]["desiguser"].focus();
				return false
			}
			else
			{
				document.getElementById('errdesig').innerHTML= "";		
			}
		}*/
		if(role=="admin")
		{
			if(document.forms["usersForm"]["cmpdesign"].value==0)
			{
				document.getElementById("errcmpdesig").style.display = "";
				document.getElementById("errcmpdesig").innerHTML = 'Please Select Designation.';	
				document.forms["usersForm"]["cmpdesign"].focus();
				return false
			}
			else
			{
				document.getElementById('errcmpdesig').innerHTML= "";		
			}
		}
	}

	var hid_logo = document.getElementById("hid_logo").value;
		
	if(hid_logo=="")
	{
		if( document.getElementById("logo").files.length == 0 ){
			document.getElementById('errlogo').innerHTML= "Please Enter Profile Image";			
			return false			
		}
		else
		{
			document.getElementById('errlogo').innerHTML= "";
			
		}
	}
	if( document.getElementById("logo").files.length != 0 )
	{
		var file = document.querySelector("#logo");
		if ( /\.(jpeg|jpg|png|gif)$/i.test(file.files[0].name) === false )
		{
			document.getElementById('errlogo').innerHTML= "Image Should '.jpg', '.jpeg', '.gif', '.png' extention Only";			
			return false;			
		}
		else
		{
			document.getElementById('errlogo').innerHTML= "";			
		}
	}	

	
	if (document.getElementById('logo').files[0].size > 1024000) {
      
		document.getElementById('errlogo').innerHTML= "Maximum Image Upload size Should 1MB only";		
		
        document.getElementById('hid_logo').value = '';
        return false;
    }
	else
	{
		document.getElementById('errlogo').innerHTML= "";
		
	}
	
	
}


function CheckWord()
{
	var cs =$("textarea").val().length;
	varv = cs;

	$('#charecter').html(varv+' / 150');
	if(varv > 150)
	{
		$('#charecter').html(varv+' / 150');

		document.getElementById("error").innerHTML = 'USP Should Not More Then 150 Words.';	
		document.forms["usersForm"]["usp"].focus();
		return false
	}
}
</script>

<?php 

unset($_SESSION['errmsg']);
?>