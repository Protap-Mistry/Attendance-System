<?php
  include 'inc/header.php';
  include 'lib/user.php';
 
?>

<!--start to show confirmation for delete option with sweet alert -->
<script>
	$(document).ready(function()
	{
		$('.delete_btn_ajax').click(function(e)
		{
			e.preventDefault();
			//console.log("hello !");
			var delete_specific_date_details= $(this).closest('tr').find('.delete_specific_date_details').val();
			//console.log(delete_specific_date_details);

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
				    	url: "view.php",
				    	data: {
				    		"initially_dlt_btn_value_set": 1,
				    		"delete_details": delete_specific_date_details,
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
		$delete_date_details= $_POST['delete_details'];

		$sql= "delete from attendances where attend_date= '$delete_date_details'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
	}
?>

<!--end to show confirmation for delete option with sweet alert -->

<div class="panel panel-default">
    <div class="panel-heading">
	    <h2> 
	    	<a href="add.php" class="btn btn-success">Add Student</a> 
	    	<a href="index.php" class="btn btn-primary pull-right">Take Attendance</a> 
	    </h2>
	</div>
	<div class="panel-body">
		<div class="well text-center" style="font-size: 16px;">
			<strong>Today's Date: </strong><?php echo date('Y-m-d');?>
		</div>
		<form action="" method="POST" accept-charset="utf-8">
			<table class="table table-striped">
			    <tr>
			    	<th width="33%"> Serial </th>
					<th width="33%"> Attendance Date</th>
					<th width="33%"> Action </th>
			    </tr>

				<?php 
					$users= new User(); 

					$get_date= $users->getStudentAttendanceDateList();
					
					if($get_date)
					{
						$i=0;

						foreach ($get_date as $key => $value) 
						{
							$i++;

				?>
					<tr>
	                   <td><?php echo $i; ?></td>
					   <td><?php echo $value['attend_date']; ?></td>
					   <td>
						   <a class="btn btn-info" href="details.php?datewise_attend_details=<?php echo $value['attend_date']; ?>"> Details </a>


						   <input type="hidden" class="delete_specific_date_details" value="<?php echo $value['attend_date']; ?>">
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

			</table>					
		</form>				    
	</div>
</div>
<?php include 'inc/footer.php';	?>