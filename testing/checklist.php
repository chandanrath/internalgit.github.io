<?PHP
ob_start();
session_start();

if($_GET['mode']=='delete')
{
	 $Domain	=	substr(decode($_REQUEST['d']),2);
	 $update = "update "._PREFIX."domain_checklist set status='2' where domain='".$Domain."'";
	 mysqli_query($conn, $update);			
	
	header('location:'.BASE_URL.'dashboard.php?action=checklist');	
}
?>



<!-- Main content starts -->

<div class="content">  
  	<!-- Main bar -->
  	<div class="mainbar">      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">Check List
          <!-- page meta -->
          
        </h2>
        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">Check List</a>
        </div>

        <div class="clearfix"></div>

	    </div>
	    <!-- Page heading ends -->

		<?php
			if(isset($_GET) && $_GET['domain']!="")
			{
				
				$appDomain=" and domain like'%".trim($_GET['domain'])."%'";			
			}
			else
			{
				$appDomain = "";	
			}
			
  		?>

	    <!-- Matter -->

	   <div class="matter">
        <div class="container">

          <div class="row">

		  <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" >		
			

			<div class="col-lg-4">  
			<h5>Domain</h5>
			
				<input type="text" name="domain" class="form-control" id="domain" value="<?php echo (isset($_GET['domain'])?$_GET['domain']:"");?>" >
			</div>
            
             <div class="col-lg-2">
			  <h5>&nbsp;</h5>
				<input type="button" class="btn btn-danger" name="filter_btn" id="filter_btn" value="Search" onclick="FilterCheckList();">
			</div>

			<?php 
			
			if(getAuth($conn,$_SESSION['role'],'ad')==1){ ?>
                <div class="col-lg-6">
                  <h5>&nbsp;</h5>				
                    <a href="<?PHP echo ADMIN_PATH;?>checklist_add" class="btn btn-danger pull-right">Add New</a>				
                </div>
            
            <?php } ?>
			


		</form>
		</div>
            <div class="col-md-12">
			<?php            
            
				 $sqlCat="SELECT id,domain,status,created_date FROM ri_domain_checklist where status=1 ".$appDomain." group by domain ORDER BY domain desc ";
				
				$paging=new paging_admin(10,5);				
				$result= $paging->query($conn,$sqlCat);				
				$page=$paging->print_info();
				$num_data=mysqli_num_rows($result);           
            
            ?>
              <div class="widget wred">
                <div class="widget-head">
                  <div class="pull-left">User List</div>
                  <div class="widget-icons pull-right">
                    <a href="javascript:void(0);" class="wminimize"><i class="icon-chevron-up"></i></a>			
					
                  </div>
                  <div class="clearfix"></div>
                </div>
				

                <div class="widget-content">
                  
                  <table class="table table-bordered ">
                      <thead>
                        <tr>
                                                   
                          <th>#</th>
                          <th>Domain Name</th>						  				
						  <th>Status</th> 
                          <th>created Date</th>                          
						   <th>Action</th>
                          				   
						 
                        </tr>
                      </thead>
                      <tbody>
						<?PHP
							$i=1;
							while($fetch_data=mysqli_fetch_array($result))
							{
								$chklist_id			= $fetch_data["id"];								
								$domain				= $fetch_data["domain"];													
								$status				= ($fetch_data["status"])==1?"Active":"Deactive";
								$created_date		= $fetch_data["created_date"];
								
								
						?>
                            <tr>
                              <td><?php echo $i ?></td>
                              <td><?php echo $domain;?></td>                            
                              <td><?php echo $status;?></td>     
                               <td><?php echo $created_date;?></td>                            
                              <td>
                              
                               <?php if($fetch_data["status"]==1) { ?> 
                               
								   <?php if(getAuth($conn,$_SESSION['role'],'ed')==1){ ?> 
                                   <a href="javascript:void(0);" onclick="edit_data('<?php echo encode($domain);?>','checklist_add');" class="btn btn-sm btn-warning"><i class="icon-pencil"></i> </a>   
                                   <?php } ?>                      
                                   <?php if(getAuth($conn,$_SESSION['role'],'de')==1){ ?> 
                                <a href="javascript:void(0);" onclick="delete_checklist('<?php echo encode($domain);?>');" class="btn btn-sm btn-cross" title="Delete"><i class="icon-remove"></i> </a>
                                <?php } ?>  
                                   
                            <?php } ?>                           
                              </td>
                             
                            </tr>
						 <?PHP
								$i++; 
							}
					   	?>

                      </tbody>
                    </table>

                </div>

                    <div class="widget-foot">

					<?php $page_link=$paging->print_link(); 
						if($page_link!="")
						{
					?>
                     
                        <ul class="pagination pull-right">
                          <li><?php echo $page_link;?></li>
                         
                        </ul>
					<?php } ?>
                      <?php if($num_data<=0) {  ?>
                      <div class="clearfix" style="align:center">No Records</div> 
					  <?php } ?>

                    </div>
              	</div>  


              </div> 
              
              <!-------user list end --------------------->             
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
<span class="totop"><a href="#"><i class="icon-chevron-up"></i></a></span> 
<script>
function FilterCheckList()
{
	
	var domain = document.getElementById('domain').value;
	
	window.location.href ="dashboard.php?action=checklist&domain="+domain;
	return true;
}

function delete_checklist(id)
{
	var i=window.confirm("Are You Sure About Deactive Of Data");
	if(i)
	{		
		document.location.href="dashboard.php?action=checklist&d="+id+"&mode=delete";
	}
	
}

</script>

<?php 

//unset($_SESSION['email']);
//unset($_SESSION['name']);
unset($_SESSION['category']);



?>