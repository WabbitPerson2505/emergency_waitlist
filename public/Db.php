<?php

class Db {
	public $dbcon;

	function __construct($host, $port, $dbname, $user, $password) {
		$connection = "host={$host} port={$port} dbname={$dbname}  
				user={$user} password={$password}";
		$this->dbcon = pg_connect($connection);
	}

	function sql($query) {
		$result = pg_query($this->dbcon,$query);
		return $result;
	}
}

?>