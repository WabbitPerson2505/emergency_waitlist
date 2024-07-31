<?php 

function showQueue($db) {
	$query = "SELECT q.id, name, condition, start FROM queue q 
			  INNER JOIN patient p ON q.patientid = p.id
		      INNER JOIN severity s ON q.severityid = s.id";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);
	return $results; 
}

function orderedQueue($db) {
	$query = "SELECT severityid, id FROM queue
			  order by severityid desc, id asc";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);
	return $results; 
}

function findPatientQueue($db, $id) {
	$query = "SELECT condition, q.id FROM queue q 
			  INNER JOIN patient p ON q.patientid = p.id
			  INNER JOIN severity s ON q.severityid = s.id 
			  WHERE p.id={$id}";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);

	return $results; 
}

function findPatient($db, $name, $code) {
	$query = "SELECT id FROM patient
			  WHERE LOWER(name) = LOWER('{$name}')
			  AND LOWER(code) = LOWER('{$code}')";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);

	return $results; 
}

function addPatient($db, $name) {
	$found = false;
	$code;

	while (!$found) {
		$code = codeGenerator();
		
		if (!findPatient($db, $name, $code)) {
			$found = true;
		}
	}

	$query = "INSERT INTO patient(name,code)
			  VALUES('{$name}','{$code}')";

	$result = $db->sql($query);

	return $result;
}

function addTreatment($db, $patientid, $severityid) {
	$query = "INSERT INTO queue(patientid,severityid,start) 
			  VALUES({$patientid},{$severityid},current_timestamp)";

	$result = $db->sql($query);

	return $result;
}

function findEmployee($db, $username, $password) {
	$query = "SELECT id FROM employee
			  WHERE username = '{$username}'
			  AND password = '{$password}'";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);

	return $results;
}

function deleteTreatment($db, $id) {
	$query = "DELETE FROM queue
			  WHERE id = {$id}";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);

	return $results;
}

function codeGenerator() {

	$alphabet = "abcdefghijklmnopqrstuvwxyz";
	$code = "";

	for ($i = 0; $i < 3; $i++) {
		$code .= $alphabet[rand(0,25)];
	}

	return $code;
}

function showAllTreatment($db) {
	$query = "SELECT id, condition FROM severity";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);

	return $results;
}

function showAllPatients($db) {
	$query = "SELECT * FROM patient";

	$result = $db->sql($query);

	if (!$result){
		return false;
	}

	$results = pg_fetch_all($result, PGSQL_ASSOC);

	return $results; 
}

function countWaitTime($db, $id) {
	$resultsQueue = orderedQueue($db);
	$len = count($resultsQueue);
	$count = 0;
	$found = false;

	for ($i = 0; $i < $len && !$found; $i++) {

		if ((int)$resultsQueue[$i]["id"] == (int)$id) {
			$found = true;
		} else {
			$count++;
		}

	}

	return 10*$count;
}

function tableTreatment() {
	$str = "<table>";
	$str .= "<tr><th>Position</th>
			<th>Name</th>
			<th>Condition</th>
			<th>Time in queue</th></tr>";

	$day = 24 * 60 * 60;
	$hour = 60 * 60;

	$resultQueue = showQueue($GLOBALS["db"], (int)$_SESSION["id"]);
	foreach ($resultQueue as $k => $v) {
		$timeSpent = time() - strtotime($v["start"]);
		$days = (int)($timeSpent/($day));
		$hours = (int)(($timeSpent%$day)/($hour));
		$minutes = (int)(($timeSpent%$hour)/(60));

		$str .= "<tr><td>{$v["id"]}</td>
		<td>{$v["name"]}</td>
		<td>{$v["condition"]}</td>
		<td>{$days} days {$hours} hours {$minutes} minutes</td>
		<td><button onclick=\"finishTreatment({$v["id"]})\">Treat</button></td></tr>";
	}

	$str .= "</table>";

	return $str;
}

function tablePatient() {
	$str = "<table>";
	$str .= "<tr><th>Id</th>
			<th>Name</th>
			<th>Code</th></tr>";

	$resultsTreatment = showAllTreatment($GLOBALS["db"]);
	$resultQueue = showAllPatients($GLOBALS["db"], (int)$_SESSION["id"]);
	foreach ($resultQueue as $k => $v) {

		$str .= "<tr><td>{$v["id"]}</td>
		<td>{$v["name"]}</td>
		<td>{$v["code"]}</td>
		<td><select id=\"treatment{$v["id"]}\">";
		
		foreach ($resultsTreatment as $key => $t) {
			$str .= "<option value=\"{$t["id"]}\">{$t["condition"]}</option>";
		}
		$str .= "<td><button onclick=\"addTreatment({$v["id"]})\">Add</button></td></tr>";
	}

	$str .= "</table>";

	return $str;
}
?>