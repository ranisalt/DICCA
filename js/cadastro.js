//var gerada = false;

/*function gerarSenha() {
	document.cadastro.senha.type = "text";
	var carac = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
	var senha = "";
	for (i = 0; i < 16; i++) {
		senha += carac.charAt(Math.floor(Math.random()*carac.length));
	}
	document.cadastro.senha.value = senha;
	document.cadastro.senhac.value = senha;
	gerada = true;
}*/

function limpaSenha() {
	/*if (gerada) {
		document.cadastro.senha.type = "password";*/
		document.cadastro.senha.value = "";
		document.cadastro.senhac.value = "";
		/*gerada = false;
	}*/
}

function validaCadastro() {
	if (document.cadastro.equipe.value == "") {
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		alert("Preencha corretamente o nome da equipe.");
		return false;
	}
	if (document.cadastro.login.value == "") {
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		alert("Preencha corretamente o login da equipe.");
		return false;
	}
	if (document.cadastro.senha.value == "" || document.cadastro.senhac.value == "") {
		alert("Preencha corretamente a senha da equipe.");
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		return false;
	}
	if (document.cadastro.senha.value != document.cadastro.senhac.value) {
		alert("A senha e a confirmação não conferem.");
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		return false;
	}
	if (document.cadastro.nome1.value == "" || document.cadastro.email1.value == "") {
		document.cadastro.nome1.value = "";
		document.cadastro.email1.value = "";
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		alert("Preencha corretamente os dados do participante 1.");
		return false;
	}
	if (document.cadastro.nome2.value == "" || document.cadastro.email2.value == "") {
		document.cadastro.nome2.value = "";
		document.cadastro.email2.value = "";
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		alert("Preencha corretamente os dados do participante 2.");
		return false;
	}
	if (document.cadastro.nome3.value == "" || document.cadastro.email3.value == "") {
		document.cadastro.nome3.value = "";
		document.cadastro.email3.value = "";
		document.cadastro.senha.value == "";
		document.cadastro.senhac.value == "";
		alert("Preencha corretamente os dados do participante 3.");
		return false;
	}
	if (document.cadastro.nome1.value == document.cadastro.nome2.value || document.cadastro.nome1.value == document.cadastro.nome3.value || document.cadastro.nome2.value == document.cadastro.nome3.value) {
		if (!confirm("Tem certeza que há duas pessoas com o mesmo nome?\nSua equipe será investigada por isso.")) {
			document.cadastro.senha.value == "";
			document.cadastro.senhac.value == "";
			return false;
		}
	}
	if (document.cadastro.turma1.value.substring(2) == document.cadastro.turma2.value.substring(2) && document.cadastro.turma1.value.substring(2) == document.cadastro.turma3.value.substring(2)) {
		alert("Os alunos devem ser de pelo menos 2 anos diferentes.");
		return false;
	}
	else if (document.cadastro.turma1.value == document.cadastro.turma2.value && document.cadastro.turma1.value == document.cadastro.turma3.value) {
		alert("Os alunos devem ser de pelo menos 2 turmas diferentes.");
		return false;
	}
	
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			if (ajax.responseText == "sucesso") {
				window.location = "equipe.php";
			}
			document.getElementById("box").innerHTML = ajax.responseText;
		}
	}
	var params = "equipe=" + document.cadastro.equipe.value + "&login=" + document.cadastro.login.value + "&senha=" + document.cadastro.senha.value +  "&senhac=" + document.cadastro.senhac.value + "&nome1=" + document.cadastro.nome1.value + "&turma1=" + document.cadastro.turma1.value + "&email1=" + document.cadastro.email1.value + "&nome2=" + document.cadastro.nome2.value + "&turma2=" + document.cadastro.turma2.value + "&email2=" + document.cadastro.email2.value + "&nome3=" + document.cadastro.nome3.value + "&turma3=" + document.cadastro.turma3.value + "&email3=" + document.cadastro.email3.value;
	ajax.open("POST", "ajax/cadastro.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=iso-8859-1");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}

function confirmaLimpar() {
	return confirm("Tem certeza que deseja limpar os dados?");
}