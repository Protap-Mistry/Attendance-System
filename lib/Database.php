<?php 
	include 'Config.php';

	class dbConnection{

		private static $pdo;

		public static function getDatabase(){

			if(!isset(self::$pdo)){

				try{
					self::$pdo= new PDO('mysql: host='.db_host.'; dbname='.db_name, db_user, db_pass);
				}
				catch(PDOException $e){
					echo $e->getMessage();
				}
			}
			return self::$pdo;
		}

		public static function myPrepareMethod($sql){

			return self::getDatabase()->prepare($sql);
		}
	}
	

?>