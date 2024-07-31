<?php
require_once('_config.php');

if (isset($_POST["add"])) {
	addTreatment($GLOBALS["db"], $_POST["add"], $_POST["severity"]);
}

if (isset($_POST["delete"])) {
	deleteTreatment($GLOBALS["db"], $_POST["delete"]);
}

$request = ["patients" => tablePatient(), 
			"treatments" => tableTreatment()];

echo json_encode($request);
?>