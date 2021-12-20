<?PHP
ob_start();
session_start();


if($_GET['mode']=='delete')
{
	
	$ID	=	decode($_REQUEST['d']);
	$update = "update "._PREFIX."client set status='2' where cmpid='".$ID."'";
	mysqli_query($conn, $update);
	$update1 = "update "._PREFIX."users set status='2' where cmpid='".$ID."'";
	mysqli_query($conn, $update1);
	
	header('location:'.BASE_URL.'dashboard.php?action=client');	
}

?>



<!-- Main content starts -->

<div class="content">  
  	<!-- Main bar -->
  	<div class="mainbar">      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">Client List
          <!-- page meta -->
          
        </h2>
        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>default"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">Client List</a>
        </div>

        <div class="clearfix"></div>

	    </div>
	    <!-- Page heading ends -->

		<?php
			
			if(!empty($_GET['fname']))
			{
				$appComp="and (cmpname like'%".$_GET['fname']."%' OR cname like'%".$_GET['fname']."%' OR cmpemail like'%".$_GET['fname']."%') ";			
			}
			else
			{
				$appComp = "";	
			}
			
  		?>

	    <!-- Matter -->

	   <div class="matter">
        <div class="container">

          <div class="row">

		  <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" >
			
            <div class="col-lg-5">			
				<input type="text" class="form-control" name="filtername" id="filtername" placeholder="Search By Name,Email,User Name etc.." value="<?php echo(isset($_GET['fname'])?$_GET['fname']:"");?>">				
			</div>
            
             <div class="col-lg-2">			  
				<input type="button" class="btn btn-danger" name="filter_btn" id="filter_btn" value="Search" onclick="FilterClient();">
			</div>

			
            <div class="col-lg-5">             			
                <a href="<?PHP echo ADMIN_PATH;?>addclient" class="btn btn-danger pull-right">Add New</a>				
            </div>
            
           
		</form>
		</div>
            <div class="col-md-12">
			<?php            
            
				$sqlCat="SELECT cmpid,cname,cmpemail,cmpname,mobile,address,website,mailcredit,status FROM "._PREFIX."client where status= 1 ".$appComp."  ORDER BY cmpname desc ";
				
				
				
				$paging=new paging_admin(10,10);				
				$result= $paging->query($conn,$sqlCat);				
				$page=$paging->print_info();
				$num_data=mysqli_num_rows($result);           
            
            ?>
              <div class="widget wred">
                <div class="widget-head">
                  <div class="pull-left">Client List</div>
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
                          <th>Contact Person</th>
                          <th>Client Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Mail Credit</th>
						  <th>Status</th>                          
						   <th>Action</th>
                          				   
						 
                        </tr>
                      </thead>
                      <tbody>
						<?PHP
							$i=1;
							while($fetch_data=mysqli_fetch_array($result))
							{
								$cmpid				= $fetch_data["cmpid"];								
								$cmpname			= $fetch_data["cmpname"];
								$name				= $fetch_data["cname"];
								$email				= $fetch_data["cmpemail"];
								$mobile				= $fetch_data["mobile"];
								$mailcredit			= $fetch_data["mailcredit"];
								$status				= ($fetch_data["status"])==1?"Active":"Deactive";
								$created_date		= $fetch_data["created_date"];
								
								
						?>
                            <tr>
                              <td><?php echo $i ?></td>
                              <td><?php echo $cmpname;?></td> 
                              <td><?php echo $name;?></td> 
                              <td><?php echo $email;?></td>
                              <td><?php echo $mobile;?></td>
                              <td><a href="javascript:void(0);" onclick="editCredit('<?php echo encode($cmpid);?>','mailcredit');" target="_blank"><?php echo $mailcredit;?></a></td>                           
                              <td><?php echo $status;?></td>                             
                              <td>
                              
                               <?php if($fetch_data["status"]==1) { ?> 
                               
								
                                   <a href="javascript:void(0);" onclick="editData('<?php echo encode($cmpid);?>','addclient');" class="btn" title="Edit"><i class="icon-edit"></i> </a>   
                                  
                                <a href="javascript:void(0);" onclick="deleteData('<?php echo encode($cmpid);?>','client');" class="btn" title="Delete"><i class="icon-remove"></i> </a>
                               
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
function FilterClient()
{	
	var filtername = document.getElementById('filtername').value;	
	window.location.href ="dashboard.php?action=client&fname="+filtername;
	return true;
}

</script>
<script>

function deleteData(id)
{
	var i=window.confirm("Are You Sure About Deactive Of Data");
	if(i)
	{		
		document.location.href="dashboard.php?action=client&d="+id+"&mode=delete";
	}	
}

function editData(id)
{	
	document.location.href="dashboard.php?action=addclient&d="+id+"&mode=edit";	
}
function editCredit(id)
{	
	document.location.href="dashboard.php?action=mailcredit&d="+id+"&mode=edit";	
}


</script>

<?php 
unset($_SESSION['category']);


?>