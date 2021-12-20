<?PHP
ob_start();
session_start();

?>
<?php
if($_GET['mode']=='delete')
{
	 $ID	=	substr(decode($_REQUEST['d']),2);
	 $update = "update "._PREFIX."menu set status='2' where id='".$ID."'";
	mysqli_query($conn, $update);			
	
	header('location:'.BASE_URL.'dashboard.php?action=menu');	
}
?>



<div class="content">  
  	<!-- Main bar -->
  	<div class="mainbar">      
	    <!-- Page heading -->
	    <div class="page-head">
        <!-- Page heading -->
	      <h2 class="pull-left">Error Log List
          <!-- page meta -->
          
        </h2>
        <!-- Breadcrumb -->
        <div class="bread-crumb pull-right">
          <a href="<?PHP echo ADMIN_PATH; ?>"><i class="icon-home"></i> Home</a> 
          <!-- Divider -->
          <span class="divider">/</span> 
          <a href="#" class="bread-current">Error Log List</a>
        </div>

        <div class="clearfix"></div>

	    </div>
	    <!-- Page heading ends -->

		<?php
			if(isset($_GET) && $_GET['search']!="")
			{
				$search = 	$_GET['search'];
				if($search==0){$appSearch="";}
				if($search=='parent'){$appSearch=" and parent=1";}
				if($search=='child'){$appSearch=" and parent=0";}				
			}
			
  		?>

	    <!-- Matter -->

	   <div class="matter">
        <div class="container">

          <div class="row">

		  <form name="btypefrm" id="btypefrm" enctype="multipart/form-data" >		
			

			<div class="col-lg-4">  
			<h5>Status</h5>
				<select class="form-control" name="fstatus" id="fstatus" >
					<option value=0>Select Menu</option>
					<option value="parent" <?php echo ($search=='parent')?'selected="selected"':''?>>Parent Menu</option>
					<option value="child" <?php echo ($search=='child')?'selected="selected"':''?>>Child Menu</option>
						
				</select>  
				<input type="hidden" name="hidStatus" id="hidStatus" value="<?php echo base64_encode($search); ?>">
			</div>
            
            <?php
				if(!empty($_GET['fromdate']) && (!empty($_GET['todate'])))
				{
					$fromdate = $_GET['fromdate'];
					$todate =  $_GET['todate'];
					$app_date = 	" where DATE_FORMAT(log_date, '%Y-%m-%d') BETWEEN '".$_GET['fromdate']."' and '".$_GET['todate']."'";	
				}
				else
				{
					$frmdate = "";
					$todate = "";
					$app_date = "";	
				}
			?>
            
             <div class="col-lg-2"> 
                <h4>From Date </h4>
                <input type="date" class="form-control" id="fromdate" name="fromdate" value="<?=$fromdate;?>" placeholder="From Date">
             </div>
             
             <div class="col-lg-2"> 
                <h4>To Date </h4>
                <input type="date" class="form-control" id="todate" name="todate" value="<?=$todate;?>" placeholder="To Date">
             </div>
             
             
             <div class="col-lg-2">
			  <h5>&nbsp;</h5>
				<input type="button" class="btn btn-danger" name="filter_btn" id="filter_btn" value="Search" onclick="FilterUserMenu();">
			</div>

			
			


		</form>
		</div>
            <div class="col-md-12">
			<?php            
            
				$sqlCat="SELECT log_id,name,types,pages,message,log_date FROM ri_error_log ".$app_date." ORDER BY log_id desc ";
				
				$paging=new paging_admin(10,5);				
				$result= $paging->query($conn,$sqlCat);				
				$page=$paging->print_info();
				$num_data=mysqli_num_rows($result);           
            
            ?>
              <div class="widget wred">
                <div class="widget-head">
                  <div class="pull-left">Error Log List</div>
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
                          <th>Name</th>
                          <th>Type</th>
                          <th>pages</th>             				
						  <th>Message</th>                          
						   <th>Log Date</th>
                          
                        </tr>
                      </thead>
                      <tbody>
						<?PHP
							$i=1;
							while($fetch_data=mysqli_fetch_array($result))
							{
								$log_id			= $fetch_data["log_id"];								
								$name			= $fetch_data["name"];
								$type			= $fetch_data["types"];
								$pages			= $fetch_data["pages"];																					
								$message		= $fetch_data["message"];
								$log_date		= $fetch_data["log_date"];							
								
						?>
                            <tr>
                              <td><?php echo $i ?></td>
                              
                              <td><?php echo $type;?></td>
                              <td><?php echo $name;?></td>
                             <td><?php echo $pages;?></td>
                              <td><?php echo $message;?></td>
                              <td><?php echo $log_date;?></td>
                             
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
function FilterUserMenu()
{
	
	var fstatus = document.getElementById('fstatus').value;
	var fromdate = document.getElementById('fromdate').value;
	var todate = document.getElementById('todate').value;
	
	window.location.href ="dashboard.php?action=error_log&search="+fstatus+"&fromdate="+fromdate+"&todate="+todate;
	return true;
}



</script>

<?php 


unset($_SESSION['category']);



?>