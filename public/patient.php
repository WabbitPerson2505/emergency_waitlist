<?php
	require_once('_config.php');

	if (isset($_POST["name"])) {
		$_SESSION["patientid"] = findPatient($GLOBALS["db"], $_POST["name"], $_POST["code"])[0]["id"];
	} 

	if (!$_SESSION["patientid"]) {
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Welcome</title>
	<script type="text/javascript" src="assets/function.js"></script>
	<link type="text/css" rel="stylesheet" href="assets/styles.css">
</head>
<body>
<div>
	<button id="signout" class="signP">sign out</button>
</div>
<div class="tablesP">
	<p class="welcome">Hello <?php echo $_POST["name"]; ?>! Here are your current treatments</p>
	<table>
		<tr>
			<th>Condition</th>
			<th>wait time</th>
		</tr>
<?php

	$resultQueue = findPatientQueue($GLOBALS["db"], $_SESSION["patientid"]);
	foreach ($resultQueue as $k => $v) {
?>
		<tr>
			<td><?php echo $v["condition"];?></td>
			<td>
<?php
	$time = countWaitTime($GLOBALS["db"], $v["id"]);
	$hours = (int)($time/60);
	$minutes = (int)($time%60);
	echo "The approximate wait time is: {$hours} hours {$minutes} minutes";
?>
			</td>
		</tr>
<?php
	}

?>
	</table>
</div>
<br></br>
</body>
</html>