<?php
require("Helper.php");
require("Db.php");
session_start();

$host = "localhost";
$port = 5432;
$dbname = "postgres";
$user = "postgres";
$password = "postgres";

if (!isset($GLOBALS["db"])) {
	$GLOBALS["db"]= new Db($host,$port,$dbname,$user,$password);
}
?>