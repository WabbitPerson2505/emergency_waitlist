window.addEventListener("load",start, false);

function start() {
		
	document.getElementById("signout").addEventListener("click", 
					function() { window.location.replace("index.php"); });

}

function callApi(element, id) {

	var xhttp = new XMLHttpRequest();

	xhttp.onreadystatechange = function() {

		if (this.readyState == 4 && this.status == 200) {
			console.log(this.responseText);

			let responseJson = JSON.parse(this.responseText);

			document.getElementById("tableP").innerHTML = responseJson["patients"];
			document.getElementById("tableT").innerHTML = responseJson["treatments"];
		}
	};

	var request = "";

	switch(element) {
		case "delete":
			request = "delete=" + id;
			break;
		case "add":
			request = "add=" + id[0] + "&severity=" + id[1];
			break;
		default:
			request = "update=true";
			break;
	}

	

	xhttp.open("POST","api.php",true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(request);
}

function addTreatment(id) {
	var severity = document.getElementById("treatment"+id).value;
	var ids = [id, severity]
	callApi("add", ids);
}

function finishTreatment(id) {
	callApi("delete",id);
}