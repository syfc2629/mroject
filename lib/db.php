<?php
require("settings.php");
// This class handles all database related tasks
class db {
	
	private $conn = null;
	
	// Opens DB connection
	public function open() {
		$settings = new settings();
		$this->conn = new PDO("mysql:host=$settings->db_server;dbname=$settings->db_database", 
								$settings->db_user, $settings->db_pass);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	
	// Closes DB connection
	public function close() {
		if ($this->conn != null)
			$this->conn = null;
	}

}
?>