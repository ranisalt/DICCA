<?php
	if (isset($_POST["inserir"]) && isset($_POST["senha"]) && isset($_POST["tema"]) && isset($_POST["pergunta"]) && isset($_POST["resposta"])) {
		//informações do usuário limitado (SELECT, INSERT, UPDATE, DELETE) do mysql
		$server = "mysql7.000webhost.com";
		$user = "a9167191_dicca";
		$pass = mysql_real_escape_string($_POST["senha"]);
		$db = "a9167191_dicca";

		$con = mysql_connect($server, $user, $pass); //cria a conexão
		mysql_select_db($db, $con); //seleciona o banco de dados
		mysql_query("SET time_zone = 'America/Sao_Paulo';", $con);
		
		mysql_query("INSERT INTO perguntadodia (data_pergunta, tema, pergunta, resposta" . ((isset($_POST["dica"])) ? ", dica" : "") . ") VALUES (DATE_ADD((SELECT max(data_pergunta) FROM perguntadodia), INTERVAL 1 DAY), '" . mysql_real_escape_string("tema") . ", " . mysql_real_escape_string("pergunta") . ", " . mysql_real_escape_string("resposta") . ((isset($_POST["dica"])) ? ", '" . mysql_real_escape_string($_POST["dica"]) : "") . ");", $con);
	}
?>
<form action="inserir.php" method="post">
	<table style="margin-left : auto; margin-right : auto;">
		<tr><td>Senha:</td><td><input name="senha" type="password"/></td></tr>
		<tr><td>Tema:</td><td><input name="tema" type="text"/></td></tr>
		<tr><td>Pergunta:</td><td><input name="pergunta" type="text"/></td></tr>
		<tr><td>Resposta:</td><td><input name="resposta" type="text"/></td></tr>
		<tr><td>Dica:</td><td><input name="dica" type="text"/></td></tr>
		<tr><td colspan=2><input name="inserir" type="submit" value="Inserir"/></td></tr>
	</table>
</form>