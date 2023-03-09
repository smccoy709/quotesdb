<?php	
	class Database {
		private $host;
		private $port;
		private $dbname;
		private $username;
		private $password;
		private $conn;
	
		public function __construct() {
			$this->username = getenv('USERNAME');
			$this->password = getenv('PASSWORD');
			$this->dbname = getenv('DBNAME');
			$this->host = getenv('HOST');
			$this->port = getenv('PORT');
		}
	
		public function connect() {
			$this->conn = null;
			
			$dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";
			
			try {
				$this->conn = new PDO($dsn, $this->username, $this->password);
			} catch (PDOException $e) {
				echo "Connection Error:  " . $e->getMessage();
			} 
			
			return $this->conn;
		}
	}
?>