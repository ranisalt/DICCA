<?php
	require("../lib.php");
	require("lib.php");
	if ($_POST["equipe"] == "true") {
		if (isset($_POST["mensagem"])) {
			mysql_query("INSERT INTO mensagens_equipes (cod_equipe, mensagem) VALUES (" . $_SESSION["cod"] . ", '" . mysql_real_escape_string(rawurldecode($_POST["mensagem"])) . "');", $con) or exit("Erro de inserção: " . mysql_error());
			mysql_close($con) or exit("Erro de conexão: " . mysql_error());
			exit('<br/><p style="color : green;">Enviado com sucesso!</p><br/>');
		}
	}
	else {
		if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["mensagem"])) {
			mysql_query("INSERT INTO mensagens_pessoas (nome, email, mensagem) VALUES ('" . mysql_real_escape_string(rawurldecode($_POST["nome"])) . "', '" . mysql_real_escape_string($_POST["email"]) . "', '" . mysql_real_escape_string(rawurldecode($_POST["mensagem"])) . "');", $con) or exit("Erro de inserção: " . mysql_error());
			mysql_close($con) or exit("Erro de conexão: " . mysql_error());
			exit('<br/><p style="color : green;">Enviado com sucesso!</p><br/>');
		}
	}
?>