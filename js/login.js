function validaLogin() {
	if (document.logar.login.value == "" || document.logar.senha.value == "") {
		alert("Preencha corretamente os campos de login e senha.");
		return false;
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			if (ajax.responseText == "sucesso") {
				window.location = "equipe.php";
			}
			else {
				document.getElementById("console").innerHTML = ajax.responseText;
			}
		}
	}
	var params = "login=" + document.logar.login.value + "&senha=" + document.logar.senha.value + "&perm=";
	params += ((document.logar.perm.checked) ? "true" : "false");
	ajax.open("POST", "ajax/login.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}