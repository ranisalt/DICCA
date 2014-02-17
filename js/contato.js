function contatoPessoal() {
	if (document.contato.nome.value == "") {
		alert("Preencha corretamente seu nome.");
		return false;
	}
	if (document.contato.email.value == "") {
		alert("Preencha corretamente seu email.");
		return false;
	}
	if (document.contato.mensagem.value == "") {
		alert("Preencha o campo de mensagem.");
		return false;
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("box").innerHTML = ajax.responseText;
		}
	}
	var params = "equipe=false&nome=" + document.contato.nome.value + "&email=" + document.contato.email.value +  "&mensagem=" + document.contato.mensagem.value;
	ajax.open("POST", "ajax/contato.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=iso-8859-1");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}

function contatoEquipe() {
	if (document.contato.mensagem.value == "") {
		alert("Preencha o campo de mensagem.");
		return false;
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("box").innerHTML = ajax.responseText;
		}
	}
	var params = "equipe=true&mensagem=" + document.contato.mensagem.value;
	alert(params);
	ajax.open("POST", "ajax/contato.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=iso-8859-1");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}