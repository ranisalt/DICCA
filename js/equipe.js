function alterarSenha() {
	if (document.alterar_senha.antiga.value == "" || document.alterar_senha.nova.value == "" || document.alterar_senha.novac.value == "") {
		document.alterar_senha.antiga.value = "";
		document.alterar_senha.nova.value = "";
		document.alterar_senha.novac.value = "";
		alert("Preencha corretamente os campos de login e senha.");
		return false;
	}
	if (document.alterar_senha.nova.value != document.alterar_senha.novac.value) {
		document.alterar_senha.antiga.value = "";
		document.alterar_senha.nova.value = "";
		document.alterar_senha.novac.value = "";
		alert("A senha e a confirmação não conferem.");
		return false;
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("alterar_senha").innerHTML = ajax.responseText;
		}
	}
	var params = "antiga=" + document.alterar_senha.antiga.value + "&nova=" + document.alterar_senha.nova.value + "&novac=" + document.alterar_senha.novac.value;
	ajax.open("POST", "ajax/alterar_senha.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}