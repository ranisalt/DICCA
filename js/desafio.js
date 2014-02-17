function contaChar() {
	document.getElementById('chr').innerHTML = document.desafio.resposta.value.length;
}

var d = "";

function contagem() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			if (ajax.responseText != "") {
				if (d == "") {
					d = ajax.responseText[0];
				}
				switch(ajax.responseText[0]) {
					case 'A':
						if (d != 'A') {
							window.location.reload(true);
							return;
						}
						document.getElementById("tmp").innerHTML = "Tempo restante: " + ajax.responseText.substring(1);
						break;
					case 'B':
						if (d != 'B') {
							window.location.reload(true);
							return;
						}
						document.getElementById("tmp").innerHTML = "Pausa para o almoço! " + ajax.responseText.substring(1);
						break;
					case 'C':
						if (d != 'C') {
							window.location.reload(true);
							return;
						}
						document.getElementById("tmp").innerHTML = "Desafio final: " + ajax.responseText.substring(1); 
						break;		
					default:
						document.getElementById("tmp").innerHTML = "Xiiii! Acabou o tempo :(";
						document.getElementById("console").innerHTML = "";
						return;
				}
				//alert(ajax.responseText);
				contagem();
			}
		}
	}
	ajax.open("GET", "ajax/contagem.php", true);
	ajax.send();
}

function limpa_str(str) {
    var acentos = [
		/[\300-\306]/g, /[\340-\346]/g,  // A, a
        /[\310-\313]/g, /[\350-\353]/g,  // E, e
        /[\314-\317]/g, /[\354-\357]/g,  // I, i
        /[\322-\330]/g, /[\362-\370]/g,  // O, o
        /[\331-\334]/g, /[\371-\374]/g,  // U, u
        /[\321]/g, /[\361]/g, // N, n
        /[\307]/g, /[\347]/g, // C, c
    ];
    var letras = ['A','a','E','e','I','i','O','o','U','u','N','n','C','c'];
    for (var i = 0; i < acentos.length; i++) {
        str = str.replace(acentos[i], letras[i]);
    }
    return str;
}

function validaRespostaFinal() {
	if (document.desafio.resposta.value == "") {
		return false;
	}
	document.getElementById("console").innerHTML = "";
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("console").innerHTML = ajax.responseText;
		}
	}
	var params = "r=" + limpa_str(document.desafio.resposta.value);
	ajax.open("POST", "ajax/desafiofinal.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}

function validaRaciocinio() {
	if (document.desafio.raciocinio.value == "") {
		return false;
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			alert("Raciocínio salvo!");
		}
	}
	//document.desafio.raciocinio.value = limpa_str(document.desafio.raciocinio.value);
	var params = "r=" + /*limpa_str(*/document.desafio.raciocinio.value/*)*/;
	ajax.open("POST", "ajax/raciocinio.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}

function validaResposta() {
	if (document.desafio.resposta.value == "") {
		return false;
	}
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			if (ajax.responseText == "sucesso")
			{
				window.location.reload(true);
				return;
			}
			else {
				document.getElementById("console").innerHTML = ajax.responseText;
			}
		}
	}
	var params = "p=false&r=" + limpa_str(document.desafio.resposta.value);
	ajax.open("POST", "ajax/desafio.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
}

function validaPular() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			document.getElementById("console").innerHTML = ajax.responseText;
		}
	}
	var params = "p=true";
	ajax.open("POST", "ajax/desafio.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.setRequestHeader("Content-length", params.length);
	ajax.setRequestHeader("Connection", "close");
	ajax.send(params);
	return false;
} 

function imgAumenta() {
	document.desafio.imagem.height = 300;
	document.desafio.imagem.setAttribute("onClick", "imgDiminui()");
}

function imgDiminui() {
	document.desafio.imagem.height = 100
	document.desafio.imagem.setAttribute("onClick", "imgAumenta()");
}