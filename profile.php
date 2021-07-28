<?php
  include 'inc/header.php';
  include 'lib/user.php';
 
?>
<?php 
	if(isset($_GET['id']))
	{
		$profile_id= (int) $_GET['id']; 
	}

	$users= new User();

	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['update']))
	{
		$updateuser= $users-> updateUserData($profile_id, $_POST);
	}
?>
		<div class="panel panel-default">
		    <div class="panel-heading">
			    <h2 class="text-center"> ...User profile... <span class="pull-right">
				<a class="btn btn-primary" href="index.php"> Back </a>
				</span> 
				</h2>
			</div>
			
			<div class="panel-body">
				<div style="max-width:600px; margin:0 auto">
					<?php
					    if(isset($updateuser))
						{
							echo $updateuser;
						}
					?>
					<?php
						$userdata= $users->getUserById($profile_id);
						if($userdata)
						{

					?>
					<form action=" " method="POST">
		                <div class="form-group">
						    <label for="name">Your name</label>
							<input type="text" id="name" name="name" class="form-control" value="<?php echo $userdata->name; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="batch">Batch</label>
							<input type="text" id="batch" name="batch" class="form-control"  value="<?php echo $userdata->batch; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="session">Session</label>
							<input type="text" id="session" name="session" class="form-control" value="<?php echo $userdata->session; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="registration">Registration</label>
							<input type="text" id="registration" name="registration" class="form-control" value="<?php echo $userdata->registration; ?>"/ >
						</div>
						<div class="form-group">
						    <label for="roll">Roll</label>
							<input type="text" id="roll" name="roll" class="form-control" value="<?php echo $userdata->roll; ?>"/ >
						</div>
						
						<button type="submit" name="update" class="btn btn-success">Update</button>
						<a class="btn btn-primary" href="index.php">
							  Okay </a>

		            </form>
					<?php } ?>
	            </div>		    
			</div>
		</div>
<?php include 'inc/footer.php';	?>