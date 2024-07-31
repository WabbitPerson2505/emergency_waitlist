<?php
	require_once('_config.php');

	if (isset($_POST["username"])) {
		$_SESSION["id"] = findEmployee($GLOBALS["db"], $_POST["username"], $_POST["password"])[0]["id"];
	} 

	if (!$_SESSION["id"]) {
		header("Location: login.php");
	}

	if (isset($_POST["name"])) {
		addPatient($GLOBALS["db"], $_POST["name"]);
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
	<div class="tables">
<div class="treatments" id="tableT">
	<table>
		<tr>
			<th>Position</th>
			<th>Name</th>
			<th>Condition</th>
			<th>Time in queue</th>
		</tr>
<?php
	$day = 24 * 60 * 60;
	$hour = 60 * 60;
	
	$resultQueue = showQueue($GLOBALS["db"], (int)$_SESSION["id"]);
	foreach ($resultQueue as $k => $v) {
?>
		<tr>
			<td><?php echo $v["id"];?></td>
			<td><?php echo $v["name"];?></td>
			<td><?php echo $v["condition"];?></td>
			<td><?php 
				$timeSpent = time() - strtotime($v["start"]);
				$days = (int)($timeSpent/($day));
				$hours = (int)(($timeSpent%$day)/($hour));
				$minutes = (int)(($timeSpent%$hour)/(60));
				echo "{$days} days {$hours} hours {$minutes} minutes";
			?></td>
			<td>
				<button onclick="finishTreatment(<?php echo $v["id"]; ?>)">Treat</button>
			</td>
		</tr>
<?php
	}

?>
	</table>
</div>
<br><br>
<div class="patients" id="tableP">
	<table>
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Code</th>
		</tr>
<?php
	
	$resultsTreatment = showAllTreatment($GLOBALS["db"]);
	$resultQueue = showAllPatients($GLOBALS["db"], (int)$_SESSION["id"]);
	foreach ($resultQueue as $k => $v) {
?>
		<tr>
			<td><?php echo $v["id"];?></td>
			<td><?php echo $v["name"];?></td>
			<td><?php echo $v["code"]; ?></td>
			<td>
				<select id="treatment<?php echo $v["id"]; ?>">
<?php 
		foreach ($resultsTreatment as $key => $t) {
?>
			<option value="<?php echo $t["id"] ?>"><?php echo $t["condition"] ?></option>
<?php 
		}
?>
		</select>
		<button onclick="addTreatment(<?php echo $v["id"]; ?>)">Add</button>
			</td>
		</tr>
<?php
	}

?>
	</table>
</div>
</div>
<br><br>
<div class="register">
	<form method="POST" action="admin.php">
		<label>name: </label>
		<input type="text" name="name">
		<br><br>
		<button>add patient</button>
	</form>
</div>
<br><br>
<div class="signout">
	<button id="signout">sign out</button>
</div>
</body>
</html>