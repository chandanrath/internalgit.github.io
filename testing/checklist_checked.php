
 <?php 

 ob_start(); 
session_start();
if (isset($_GET['debug'])) error_reporting(-1);
else error_reporting(0);


if($_REQUEST['mode']=='edit')
{
	$operation	=	'edit';
	$webname	=	substr(decode($_REQUEST['d']),2);
	//$SQL_QUERY="SELECT * FROM ri_checklist WHERE  id='".$ID."'";	
	//$result= mysqli_query($conn,$SQL_QUERY);
	//$rows = mysqli_num_rows($result);
	//$arr = mysqli_fetch_array($result);
	
	//$chkname	=$arr['chkname'];
	//$stage	= $arr['stage'];

	
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
                      <input type="text" class="form-control" name="webname" id="webname"  value="<?php echo (isset($webname)?$webname:""); ?>" readonly="readonly">
                    </div>                                                        
                  </div>
             		<?php         
            
						$SQL_Stage="SELECT cs.id,cs.name,dc.stageid
						FROM ri_domain_checklist dc
						join ri_checklist_stage cs on(cs.id=dc.stageid)
						where dc.domain='".$webname."' and dc.`status`=1
						group by dc.stageid
						ORDER BY cs.id ASC ";						
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
                            <tr>                      
                              <th width="5%">#</th>                              
                              <th width="25%"><strong><?php echo $dataStage['name'];?></strong></th>
                               <th width="5%"><strong>Action</strong> </th>
                               <th width="20%"><strong>Comment</strong> </th>
                                <th width="10%"><strong>Checked By</strong> </th>
                                 <th width="25%"><strong>Checked Date</strong> </th>
                            </tr>
                          </thead>
                          
                          
                            <?PHP
								 $SQL_CHKLIST="SELECT id,stageid,checklist,checkedid,comment,checked_by,checked_date FROM ri_domain_checklist where stageid='".$dataStage['id']."' and status=1 and domain='".$webname."' ORDER BY id ASC ";						
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
									  <td width="5%"><?php echo $i ?></td>
									  <td width="30%"><?php echo $datachklist["checklist"];?></td>
									  <td width="5%">
                                      <input type="checkbox" name="checklist[]" id="checklist" <?php if($datachklist["checkedid"]==1){ echo"checked='checked'";echo"disabled='disabled'"; }?>  value="<?php echo $datachklist["stageid"].'-'.$datachklist["id"];?>" />
                                      </td>
                                      <td width="20%">                                    
                                     	<textarea name="comment[<?php echo $datachklist["id"];?>]" rows="3" cols="25"><?php echo $datachklist["comment"]?></textarea>
                                      </td>                    
									  <td width="10%"><?php echo ucfirst($datachklist["checked_by"]); ?></td>
                                      <td width="25%"><?php echo (isset($datachklist["checked_date"])?$datachklist["checked_date"]:""); ?></td>
									 
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