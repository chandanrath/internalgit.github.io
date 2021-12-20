<?php 

error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
$host="localhost";$dbname="googlelogin";$dbpass="";$dbuser="root";$con;
$con=mysqli_connect($host, $dbuser, $dbpass, $dbname)
?>

<style>
* {
  box-sizing: border-box;
}

body {
  font: 16px Arial;  
}

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>

  <div class="autocomplete" style="width:300px;">
    <input id="name" type="text" name="name" placeholder="Name">

  </div>

   <br/>
   <div id="suggesstion-box"></div>
            


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
   <script>
    $(document).ready(function(){

	$("#name").keyup(function(){

		$.ajax({
		type: "POST",
		url: "autocomplete-search.php",
		data:'keyword='+$(this).val(),
		success: function(data){

//alert(data)
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
		}
		});
	});
});

function selectUsers(val) {
var res = val.split("-");
//alert(res[1])
$("#name").val(res[1]);

UpdateTable(res[0])

$("#suggesstion-box").hide();
}


function UpdateTable(id)
{
	$.ajax({
		type: "POST",
		url: "update.php",
		data:'userid='+id,
		success: function(data){

		//alert(data)
			location.reload(true);
			$("#suggesstion-box").html(data);
			}
		});

}


 </script>


<?php
$query ="SELECT id,userid,name,sequence FROM ri_users_seq WHERE status=1 order by sequence asc";
$result = mysqli_query($con, $query);
$count=  mysqli_num_rows($result);
//$row = mysqli_fetch_array($result);

?>
<table border=1>
<tr>
	
    <td>Name</td>
    <td>Sequence</td>
    <td>Action</td>
</tr>
<?php
if($count > 0)
{
	while($row = mysqli_fetch_array($result)){
	
	?>
	<tr>
	
		<td><div id="users"><?=$row['name']?></div></td>
		<td>up | Down</td>
		<td><a dref="">Delete</a></td>
	</tr>
	
	<?php } ?>
<?php } ?>
</table>
            