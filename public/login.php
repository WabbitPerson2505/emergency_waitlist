<?php
	require_once('_config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link type="text/css" rel="stylesheet" href="assets/styles.css">
</head>
<body>
	<p class="welcomeLogin">Welcome! Please enter the information provided to you</p>
	<div class="tabs">
		<div class="btnTabs">
			<button id="btnPatient">Patient</button>
			<button id="btnEmployee">Employee</button>
		</div>

		<div id="patient" class="tab">
			<form method="POST" action="patient.php">
				<label for="name">name: </label>
				<input type="text" id="name" name="name">
				<br><br>
				<label for="code">3 letter code: </label>
				<input type="text" id="code" name="code">
				<br><br>
				<button>login</button>
			</form>
		</div>

		<div id="employee" class="tab" hidden>
			<form method="POST" action="admin.php">
				<label for="username">username: </label>
				<input type="text" id="username" name="username">
				<br><br>
				<label for="password">password: </label>
				<input type="text" id="password" name="password">
				<br><br>
				<button>login</button>
			</form>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	window.addEventListener("load",start, false);

	function start() {
		
		document.getElementById("btnPatient").addEventListener("click", 
					function() { switchTab("patient") });
		document.getElementById("btnEmployee").addEventListener("click", 
					function() { switchTab("employee") });
	}

	function switchTab(element) {

		var tabs = document.getElementsByClassName("tab");
		
		for (let i = 0; i < tabs.length; i++) {
			tabs[i].hidden = true;
		}

		document.getElementById(element).hidden = false;
	};

</script>