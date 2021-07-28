<?php
  include 'inc/header.php';
  include 'lib/user.php';
 
?>

<!--start roll missing check for submitting -->
<script type="text/javascript">
	$(document).ready(function()
	{
		$('form').submit(function()
		{
			var roll_call= true;

			$(':radio').each(function()
			{
				name= $(this).attr('name');

				if(roll_call && !$(':radio[name="' + name + '"]:checked').length)
				{
					//alert(name + " Roll missing !!!");
					$('.alert').show();
					roll_call= false;
				}
			});
			return roll_call;
		});
	});
</script>

<div class='alert alert-danger' style="display: none;"> <strong> Whoops !!! </strong> Student roll missing.</div>
<!--end roll missing check for submitting -->

<!--start to show confirmation for delete option with sweet alert -->
<script>
	$(document).ready(function()
	{
		$('.delete_btn_ajax').click(function(e)
		{
			e.preventDefault();
			//console.log("hello !");
			var delete_specific_user_id= $(this).closest('tr').find('.delete_specific_user_id').val();
			//console.log(delete_specific_user_id);

			//copy code from sweet alert documentary start

			swal({
			  	title: "Are you sure?",
			  	text: "Once deleted, you will not be able to recover this Data !!!",
			  	icon: "warning",
			  	buttons: true,
			  	dangerMode: true,
			})
			.then((willDelete) => 
			{
			  	if (willDelete) 
			  	{
				    $.ajax({
				    	type: "POST",
				    	url: "index.php",
				    	data: {
				    		"initially_dlt_btn_value_set": 1,
				    		"delete_details": delete_specific_user_id,
				    	},
				    	success: function(response)
				    	{
				    		swal({
				    			title: "Data deleted successfully !!!",
				    			text: "You clicked the button!",
				    			icon: "success",
				    		})
				    		.then((result) => 
				    		{
				    			location.reload();
				    		});			    		
			    		}
			    	});
			  	}
			});
			//copy code from sweet alert documentary end
		});
	});	
</script>

<?php 
	if(isset($_POST['initially_dlt_btn_value_set']))
	{
		$delete_user_details= $_POST['delete_details'];

		$sql= "delete from users where id= '$delete_user_details'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
	}
?>

<!--end to show confirmation for delete option with sweet alert -->

<?php
	$users= new User();
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['roll_call']))
	{
		$roll_call= $_POST['roll_call'];
		$roll_call= $users->insertStudentRollCall($roll_call);

	    if(isset($roll_call))
		{
			echo $roll_call;
		}
	}
?>

<div class="panel panel-default">
    <div class="panel-heading">   	
	    <h2> 
	    	<a href="add.php" class="btn btn-success">Add Student</a>
	    	<a href="view.php" class="btn btn-info pull-right">View All</a> 
	    </h2>
	</div>
	<div class="panel-body">
		<div class="well text-center" style="font-size: 16px;">
			<strong>Today's Date: </strong><?php echo date('Y-m-d');?>
		</div>
		<form action="" method="POST" accept-charset="utf-8">
			<table class="table table-striped">
			    <tr>
			    	<th> Serial </th>
					<th> Student Name </th>
					<th> Batch </th>
					<th> Session </th>
					<th> Registration No </th>
					<th> Roll No </th>
					<th> Attendance </th>
					<th> Action </th>
			    </tr>

				<?php
					$get_user= $users->getStudentData();
					
					if($get_user)
					{
						$i=0;

						foreach ($get_user as $key => $value) 
						{
							$i++;

				?>
					<tr>
	                   <td><?php echo $i; ?></td>
					   <td><?php echo $value['name']; ?></td>
					   <td><?php echo $value['batch']; ?></td>
					   <td><?php echo $value['session']; ?></td>
					   <td><?php echo $value['registration']; ?></td>
					   <td><?php echo $value['roll']; ?></td>
					   <td>
					   		<input type="radio" name="roll_call[<?php echo $value['roll']; ?>]" value="Present"> (+)
					   		<input type="radio" name="roll_call[<?php echo $value['roll']; ?>]" value="Absent"> (-) 
					   </td>
					   <td>

						   <a class="btn btn-info" href="profile.php?id=<?php echo $value['id']; ?>">
						  Profile & Update</a>
						  
						  <input type="hidden" class="delete_specific_user_id" value="<?php echo $value['id']; ?>">
						   <a class="delete_btn_ajax btn btn-danger" href="javascript:void(0)">
						  Remove </a>

					   </td>
					</tr>

				<?php } }else{ ?>
					<tr>
						<td colspan="8">
							<h3 style="color: red; text-align: center;">Whoops !!! No data found...</h3>
						</td>							
					</tr>
				<?php } ?>

				<tr>
					<td colspan="8">
						<input type="submit" name="submit" class="btn btn-success" value="Store">
					</td>						
				</tr>
				
			</table>					
		</form>				    
	</div>
</div>
<?php include 'inc/footer.php';	?>