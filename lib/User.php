<?php 
include_once 'Session.php';
include 'Database.php';
class User
{
	private $db;
	private $table= "users";
	private $table2= "attendances";

	public function __construct()
	{
		$this->db= new dbConnection();
	}
	//check existed roll number
	public function checkExistedRoll($roll)
	{
		$sql= "select roll from $this->table where roll= :roll";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':roll', $roll);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//check existed registration number
	public function checkExistedRegistration($registration)
	{
		$sql= "select registration from $this->table where registration= :registration";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':registration', $registration);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	//insert a new student
	public function addStudent($data)
	{
		$name= $data['name'];
		$batch= $data['batch'];
		$session= $data['session'];
		$registration= $data['registration'];
		$roll= $data['roll'];

		if($name=="" || $batch=="" || $session=="" || $registration=="" || $roll==""){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty.</div>";
			return $msg;
		}
		if(preg_match('/[^A-Za-z .]+/i', $name)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain characters, dot and spaces.</div>";
			return $msg;
		}
		if(preg_match('/[^A-Za-z0-9]+/i', $batch)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Batch name must only contain alphanumerics (e.g. 4th or fourth).</div>";
			return $msg;
		}elseif (strlen($batch)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Batch name is too short (Upto 2 characters) </div>";
			return $msg;
		}
		if(preg_match('/[^0-9-]+/i', $session)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Session must only contain digits and hyphen (e.g. 2016-17 or 2016-2017).</div>";
			return $msg;
		}
		if(preg_match('/[^0-9-]+/i', $registration)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Registrstion must only contain digits and hyphen (e.g. 110-029-17 or 11002917).</div>";
			return $msg;
		}
		if(preg_match('/[^A-Z0-9]+/i', $roll)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Roll must only contain alphanumerics (e.g. 17CSE029 or 17).</div>";
			return $msg;
		}

		$check_existed_registration= $this->checkExistedRegistration($registration);

		if($check_existed_registration==true)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Registration number already exist. Please, try with new one. </div>";
			return $msg;
		}

		$check_existed_roll= $this->checkExistedRoll($roll);

		if($check_existed_roll==true)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Roll number already exist. Please, try with new one. </div>";
			return $msg;
		}
		
		$sql= "insert into $this->table(name, batch, session, registration, roll) values(:name, :batch, :session, :registration, :roll)";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':batch', $batch);
		$query->bindValue(':session', $session);
		$query->bindValue(':registration', $registration);
		$query->bindValue(':roll', $roll);

		$roll_sql= "insert into $this->table2(roll) values(:roll)";
		$query2= dbConnection::myPrepareMethod($roll_sql);
		$query2->bindValue(':roll', $roll);
		
		if($query->execute() && $query2->execute())
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull !!! </strong> New student have been added </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error !!! </strong> Sorry, there has been a problem to insert your details.  </div>";
			return $msg;
		}
	}

	public function getStudentData()
	{
		$sql= "select * from $this->table order by roll, registration";
		$query= dbConnection::myPrepareMethod($sql);		
		$query->execute();
		
		$result= $query->fetchAll();
		return $result;
	}

	public function getUserById($profile_id)
	{
		$sql= "select * from $this->table where id= :id limit 1";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':id', $profile_id);
		$query->execute();
		
		$result= $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}
	public function updateUserData($id, $data)
	{
		$name= $data['name'];
		$batch= $data['batch'];
		$session= $data['session'];
		$registration= $data['registration'];
		$roll= $data['roll'];

		if($name=="" || $batch=="" || $session=="" || $registration=="" || $roll==""){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty.</div>";
			return $msg;
		}
		if(preg_match('/[^A-Za-z .]+/i', $name)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain characters, dot and spaces.</div>";
			return $msg;
		}
		if(preg_match('/[^A-Za-z0-9]+/i', $batch)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Batch name must only contain alphanumerics (e.g. 4th or fourth).</div>";
			return $msg;
		}elseif (strlen($batch)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Batch name is too short (Upto 2 characters) </div>";
			return $msg;
		}
		if(preg_match('/[^0-9-]+/i', $session)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Session must only contain digits and hyphen (e.g. 2016-17 or 2016-2017).</div>";
			return $msg;
		}
		if(preg_match('/[^0-9-]+/i', $registration)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Registrstion must only contain digits and hyphen (e.g. 110-029-17 or 11002917).</div>";
			return $msg;
		}
		if(preg_match('/[^A-Z0-9]+/i', $roll)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Roll must only contain alphanumerics (e.g. 17CSE029 or 17).</div>";
			return $msg;
		}
		
		$sql= "update $this->table set name= :name, batch= :batch, session= :session, registration= :registration, roll= :roll where id= :id";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':batch', $batch);
		$query->bindValue(':session', $session);
		$query->bindValue(':registration', $registration);
		$query->bindValue(':roll', $roll);
		$query->bindValue(':id', $id);
		
		if($query->execute())
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull !!! </strong>
			User data updated successfully </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error !!! </strong>
			Sorry, User data not updated !!!  </div>";
			return $msg;
		}
		
	}

	//insert a student's attendance
	public function insertStudentRollCall($roll_call=array())
	{
		$todays_date= date('Y-m-d');

		$take_a_date_sql= "select distinct attend_date from $this->table2";
		$take_a_date= dbConnection::myPrepareMethod($take_a_date_sql);
		$take_a_date->execute();
      	$result= $take_a_date->fetchAll();

      	if($result)
      	{
      		foreach ($result as $key => $value) 
      		{
				$date_from_db= $value['attend_date'];

				if($todays_date == $date_from_db)
				{
					$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>Today's attendance has been already taken.</div>";
					return $msg;
				}
      		}
      	}	

		foreach ($roll_call as $key => $value) 
		{
			
			if($value == "Present")
			{
				$present_sql= "insert into $this->table2(roll, attend, attend_date) values('$key', 'Present', '$todays_date')";
				$present= dbConnection::myPrepareMethod($present_sql);
				$finished_roll_call= $present->execute();

			}
			elseif($value == "Absent")
			{
				$absent_sql= "insert into $this->table2(roll, attend, attend_date) values('$key', 'Absent', '$todays_date')";
				$absent= dbConnection::myPrepareMethod($absent_sql);
				$finished_roll_call= $absent->execute();

				// $absent->bindValue(':roll', $key);
				// $absent->bindValue(':attend', 'Absent');
				// $absent->bindValue(':attend_date', $todays_date);
				
			}
					
		}

		if($finished_roll_call)
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull !!! </strong> Todays roll call have been finished. </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error !!! </strong> Sorry, there has been a problem to insert todays attendances.  </div>";
			return $msg;
		}						
	}
	public function getStudentAttendanceDateList()
	{
		$take_a_date_sql= "select distinct attend_date from $this->table2 order by attend_date desc";
		$take_a_date= dbConnection::myPrepareMethod($take_a_date_sql);
		$take_a_date->execute();
      	$take_a_specific_date_from_db= $take_a_date->fetchAll();

      	return $take_a_specific_date_from_db;
	}

	public function getStudentAttendanceDetails($datewise_attend_details)
	{
		$sql="select $this->table2.attend, $this->table.name, $this->table.batch, $this->table.session, $this->table.registration, $this->table.roll from $this->table2 
            inner join $this->table
            on $this->table2.roll = $this->table.roll
            where $this->table2.attend_date= :attend_date
            order by $this->table2.roll";

	    $query= dbConnection::myPrepareMethod($sql);
	    $query->bindValue(':attend_date', $datewise_attend_details);
	    $query->execute();
	    return $query->fetchAll();
	}

	public function updateDateWiseAttendDetails($datewise_attend_details, $roll_call=array())
	{
		foreach ($roll_call as $key => $value) 
		{			
			if($value == "Present")
			{
				$present_sql= "update $this->table2 set attend= 'Present' where roll= '$key' and attend_date= '$datewise_attend_details'";
				$present= dbConnection::myPrepareMethod($present_sql);
				$finished_roll_call_update= $present->execute();

			}
			elseif($value == "Absent")
			{
				$absent_sql= "update $this->table2 set attend= 'Absent' where roll= '$key' and attend_date= '$datewise_attend_details'";
				$absent= dbConnection::myPrepareMethod($absent_sql);
				$finished_roll_call_update= $absent->execute();
				
			}
					
		}
		
		if($finished_roll_call_update)
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull !!! </strong> Roll call updated successfully. </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error !!! </strong>Sorry, Roll call not updated !!!  </div>";
			return $msg;
		}
	}
			
}
?>