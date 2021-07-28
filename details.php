<?php
  include 'inc/header.php';
  include 'lib/user.php';
?>

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


<?php 
	error_reporting(0);
	if(isset($_GET['datewise_attend_details']))
	{
		$datewise_attend_details= $_GET['datewise_attend_details']; 
	}	

	$users= new User();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update']))
	{
		$roll_call= $_POST['roll_call'];
		$update_datewise_attend_details= $users->updateDateWiseAttendDetails($datewise_attend_details, $roll_call);
	}
	if($update_datewise_attend_details)
	{
		echo $update_datewise_attend_details;
	}
?>

<div class="panel panel-default">
    <div class="panel-heading">
	    <h2> 
	    	<a href="add.php" class="btn btn-success">Add Student</a> 
	    	<a href="view.php" class="btn btn-primary pull-right">Back</a> 
	    </h2>
	</div>
	<div class="panel-body">
		<div class="well text-center" style="font-size: 16px;">
			<strong>Roll Call's Date: </strong><?php echo $datewise_attend_details;?>
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
			    </tr>

				<?php 

					$get_datewise_details= $users->getStudentAttendanceDetails($datewise_attend_details);
					
					if($get_datewise_details)
					{
						$i=0;

						foreach ($get_datewise_details as $key => $value) 
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
					   		<input type="radio" name="roll_call[<?php echo $value['roll']; ?>]" value="Present" <?php if($value['attend'] == "Present"){echo "checked";} ?>> (+)
					   		<input type="radio" name="roll_call[<?php echo $value['roll']; ?>]" value="Absent" <?php if($value['attend'] == "Absent"){echo "checked";} ?>> (-) 
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
						 
							<input type="submit" name="update" class="btn btn-success" href="update.php?id=<?php echo $value['attend_date']; ?>" value="Update">

							<a class="btn btn-primary" href="view.php">
							  Okay </a>

					   </td>
					</tr>				
			</table>					
		</form>				    
	</div>
</div>
<?php include 'inc/footer.php';	?>