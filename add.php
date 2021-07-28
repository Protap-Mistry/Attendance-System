<?php
  include 'inc/header.php';
  include 'lib/user.php';
 
?>
<?php
	$users= new User();
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['add']))
	{
		$add= $users->addStudent($_POST);
	}
?>
<div class="panel panel-default">
    <div class="panel-heading">
	    <h2> 
	    	<a href="add.php" class="btn btn-success">Add Student</a> 
	    	<a href="index.php" class="btn btn-primary pull-right">Back</a> 
	    </h2>
	</div>
	<div class="panel-body">
		<div style="max-width:600px; margin:0 auto">
			<?php
			    if(isset($add))
				{
					echo $add;
				}
			?>				
			<form action="" method="POST" accept-charset="utf-8">
				<div class="form-group">
				    <label for="name">Student name</label>
					<input type="text" id="name" name="name" class="form-control"/ >
				</div>
				<div class="form-group">
				    <label for="batch">Batch</label>
					<input type="text" id="batch" name="batch" class="form-control"/ >
				</div>
				<div class="form-group">
				    <label for="session">Session</label>
					<input type="text" id="session" name="session" class="form-control"/ >
				</div>
				<div class="form-group">
				    <label for="registration">Registration No</label>
					<input type="text" id="registration" name="registration" class="form-control"/ >
				</div>
				<div class="form-group">
				    <label for="roll">Roll No</label>
					<input type="text" id="roll" name="roll" class="form-control"/ >
				</div>			
				<button type="submit" name="add" class="btn btn-success">Add</button>
				<button type="reset" name="clear" class="btn btn-warning">Clear</button>					
			</form>
		</div>			    
	</div>
</div>
<?php include 'inc/footer.php';	?>