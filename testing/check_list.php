
 <?php 

 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


if($_REQUEST['mode']=='edit')
{
	$operation	=	'edit';
	$ID	=	substr(decode($_REQUEST['d']),2);
echo	$SQL_QUERY="SELECT * FROM ri_checklist WHERE  id='".$ID."'";	
	$result= mysqli_query($conn,$SQL_QUERY);
	$rows = mysqli_num_rows($result);
	$arr = mysqli_fetch_array($result);
	
	$chkname	=$arr['chkname'];
	$stage	= $arr['stage'];

	
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
	      <h2 class="pull-left">Domain Checklist
          <!-- page meta -->
          
        </h2>
        
        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">Domain CheckList  </a>
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
                  <div class="pull-left">Website CheckList</div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="icon-chevron-up"></i></a> 
                   
                  </div>
                  <div class="clearfix"></div>
                </div>
				
                <div class="widget-content">
                  <div class="padd">
                    
                    <!-- Profile form -->

					

		<div class="form profile">
									
               <form  method="post" class="form-horizontal" action="scripts/insert_setting.php" name="webchkListForm"  id="webchkListForm" >
                
              <!-- chklistname Name -->
             <div class="field_wrapper">
             
                    <div class="form-group">
                    <label class="control-label col-lg-5" for="name">Website Name </label>
                    <div class="col-lg-5">
                      <input type="text" class="form-control" name="webname" id="webname"  value="<?php echo (isset($webname)?$webname:""); ?>">
                    </div>                                                        
                  </div>
             		<?php        
            
						$SQL_Stage="SELECT id,name,stage FROM ri_checklist_stage ORDER BY id ASC ";						
						$resStage= mysqli_query($conn,$SQL_Stage);
						$rowstage = mysqli_num_rows($resStage);
						
					?>
                    <div class="form-group">    
                   
                   <table class="table table-bordered ">
                   <?php
				  	 $k=1;
					   while($dataStage=mysqli_fetch_array($resStage))
						{
					?>
                          <thead>
                            <tr style="color:#666;">                      
                              <th>#</th>                              
                              <th><strong><?php echo $dataStage['name'];?></strong></th>                                             
                               <th>Action / Status </th>
                            </tr>
                          </thead>
                          
                          
                            <?PHP
								$SQL_CHKLIST="SELECT id,stageid,checklist FROM ri_checklist where stageid='".$dataStage['id']."' and status=1 ORDER BY id ASC ";						
								$reschklist= mysqli_query($conn,$SQL_CHKLIST);
								$rowchklist = mysqli_num_rows($reschklist);
								if($rowchklist > 0)
								{
									$i=1;
									while($datachklist=mysqli_fetch_array($reschklist))
									{
										$check_id = $data["id"];
										
							?>
                             	<tbody id="<?php echo $datachklist["stageid"];?>">
									<tr>
									  <td><?php echo $i ?></td>
									  <td><?php echo $datachklist["checklist"];?></td>
									  <td>
                                      <input type="checkbox" name="checklist[]" id="checklist" value="<?php echo $datachklist["stageid"].'-'.$datachklist["id"];?>" />
                                      <?php if($i==$rowchklist){ ?>
									  	
                                        <a href="javascript:void(0);" class="add_button<?php echo $datachklist["stageid"];?>" onclick="AddNewText('<?php echo $datachklist["stageid"];?>');" id="add_button<?php echo $datachklist["stageid"]?>" title="Add field">
                                  		<img src="img/icons/plus.png" width="10%" height="45%"/></a>
                                  		
                                        <input type="submit" name="addtext" id="addtext<?php echo $datachklist["stageid"];?>" value="Save" onclick="return AddCheckList(<?php echo $datachklist["stageid"];?>)" style="display:none;" />
									  
									  <?php	} ?>								 
                                      
                                      </td>                    
									  
									 
									</tr>
                                  </tbody>
								 <?PHP
										$i++; 
									}
								?>
                                <tbody id="field_wrapper_<?php echo $dataStage["id"];?>"></tbody>                                 
                             	
                                
							<?php	} ?>
                            
    						
                          
                          
                          
                     <?php $k++;  } ?>
                     
                         
                        </table>
    					
                    </div>
                     <!-- Buttons -->
                    <div class="form-group">
                        
                         <div class="col-lg-8 col-lg-offset-6">
                            <input type="submit" class="btn btn-success" name="submit" id="submit"  value="Update" onclick="return SubmitCheckList();"/>								
                            <button type="button" class="btn btn-default" onclick="cancel('domain_checklist')">Cancel</button>
            
                        </div>
                      </div>
                
               </div>
                
                    <input type="hidden" id="operation" name="operation" value="<?PHP echo $operation;?>" />
                    <input type="hidden" id="type" name="type" value="website_checklist" />
                    <input type="hidden" id="webchk_id" name="webchk_id" value="<?PHP echo $_REQUEST['d'];?>" />       
                        
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

function SubmitCheckList()
{
	var webname = document.getElementById('webname').value;		
	if(webname=="")
	{
		alert("Please Select CheckList Name")	;
		document.getElementById('webname').focus();
		return false;	
	}
	
}


function AddCheckList(id)
{
	
	var newtext = document.getElementById('newtext_'+id).value;
	
	
	if(id==1)
	{			
		if(newtext=="")
		{
			alert("Please Enter Website Template")	;
			document.getElementById('newtext_'+id).focus();
			return false;	
		}
		
	}
	if(id==2)
	{		
		if(newtext=="")
		{
			alert("Please Enter Website design")	;
			document.getElementById('newtext_'+id).focus();
			return false;	
		}	
	}
	if(id==3)
	{		
		if(newtext=="")
		{
			alert("Please Enter Keyword/Content")	;
			document.getElementById('newtext_'+id).focus();
			return false;	
		}	
	}
	if(id==4)
	{		
		if(newtext=="")
		{
			alert("Please Enter SEO Checklist")	;
			document.getElementById('newtext_'+id).focus();
			return false;	
		}	
	}
	
	/*
	$.ajax({
			type: "POST",
			url: "scripts/insert_setting.php",
			data: "id="+id+"&text1="+values1+"&type=website_checklist",
			
		
			success: function(html) {				
				//alert(html)
				//document.getElementById('showsite').innerHTML=html;	
			
			}
		});	
		*/
		
}


function AddNewText(id)
{
	var maxField = 2; //Input fields increment limitation
    //var addButton = $('#add_button'+id); //Add button selector
	var wrapper = $('#field_wrapper_'+id); //Input field wrapper
	 var fieldHTML = '<tr><td></td><td><input type="text" name="newchecklist['+id+'][]" id="newtext_'+id+'" class="form-control" value=""></td><td></td></tr>'; 
	 //New input field html 
    var x = 1; //Initial field counter is 1
	
	
	//Check maximum number of input fields
	if(x < maxField){ 
		x++; //Increment field counter
		$(wrapper).append(fieldHTML); //Add field html
	}
	
	// click plus then show submit button 
	$('#addtext'+id).show();
		
}




</script>
<script>
function CheckList_Add()
{
	var chkname = document.getElementById('chkname').value;	
	var stage = document.getElementById('stage').value;
	
	if(stage=="0")
	{
		alert("Please Select Stage")	;
		document.getElementById('stage').focus();
		return false
	}
	
	if(chkname=="")
	{
		alert("Please Enter Checklist Name")	;
		document.getElementById('chkname').focus();
		return false
	}
	
	
	
	
}

</script>