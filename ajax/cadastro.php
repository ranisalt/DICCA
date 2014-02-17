<?php
	require("../lib.php");
	require("lib.php");
	if (isset($_SESSION["cod"])) {
		exit("sucesso");
	}

	function validaNome($nome) {
		/*if (!preg_match("^([A-Z]/u{1})([a-zA-Z]/u*[ ]{1})*^", $nome)) {
			return false;
		}*/
		return $nome != "";
	}
	
	function validaTurmas() {
		global $con;
		$ano = mysql_query("SELECT DISTINCT ano FROM turmas WHERE nome = '" . $_POST["turma1"] . "' OR nome = '" . $_POST["turma2"] . "' OR nome = '" . $_POST["turma3"] . "';", $con) or exit("Erro de leitura: " . mysql_error());
		$curso = mysql_query("SELECT DISTINCT curso FROM turmas WHERE nome = '" . $_POST["turma1"] . "' OR nome = '" . $_POST["turma2"] . "' OR nome = '" . $_POST["turma3"] . "';", $con) or exit("Erro de leitura: " . mysql_error());
		if (mysql_num_rows($ano) < 2) {
			if (mysql_num_rows($curso) < 2) {
				return "Os alunos devem ser de 2 anos e 2 cursos diferentes!" . PHP_EOL;
			}
			return "Os alunos devem ser de 2 anos diferentes!" . PHP_EOL;
		}
		elseif (mysql_num_rows($curso) < 2) {
			return "Os alunos devem ser de 2 cursos diferentes!" . PHP_EOL;
		}
		return "ok";
	}
	
	function validaEmail ($email) {
		if (!preg_match("^([a-zA-Z0-9_\.\-])*@{1}(([a-zA-Z0-9_\-])*\.{1})*([a-zA-Z]){2,3}\.?(([a-zA-Z]){2})?^", $email)) {
			return false;
		}
		return $email != ""; 
	}
	
	$html = "";
	$erro = false;
	
	$sql = mysql_query("SELECT status FROM controle WHERE sistema = 'cadastro' AND status = 1;", $con) or exit("Erro de leitura: " . mysql_error());
	if (mysql_num_rows($sql) != 1) {
		mysql_close($con);
		exit("<br/><p>O cadastro de equipes está desabilitado!<br/>Volte novamente em alguns dias.</p><br/>");
	}
	$html .= '<br/><form name="cadastro" onsubmit="return validaCadastro();" onreset="return confirmaLimpar();"><table class="center">';
	
	$sql = mysql_query("SELECT nome_equipe FROM equipes WHERE nome_equipe = '" . mysql_real_escape_string(rawurldecode($_POST["equipe"])) . "';", $con) or exit("Erro de leitura: " . mysql_error());
	if (!isset($_POST["equipe"])) {
		$html .= '<tr><td>Nome da equipe:</td><td><input type="text" name="equipe" maxlength="30"/></td></tr>' . PHP_EOL;
		$html .= '<tr><td colspan=2>Preencha o campo "Nome da equipe" corretamente!</td></tr>' . PHP_EOL;
		$erro = true;
	}
	elseif (mysql_num_rows($sql) > 0) {
		$html .= '<tr><td>Nome da equipe:</td><td><input type="text" name="equipe" maxlength="30"/></td></tr>' . PHP_EOL;
		$html .= '<tr><td colspan=2>O nome escolhido já está em uso.</td></tr>' . PHP_EOL;
	}
	else {
		$html .= '<tr><td>Nome da equipe:</td><td><input type="text" name="equipe" maxlength="30" value="' . rawurldecode($_POST["equipe"]) . '"/></td></tr>' . PHP_EOL;
	}
	
	$sql = mysql_query("SELECT login FROM equipes WHERE login = '" . mysql_real_escape_string($_POST["login"]) . "';", $con) or exit("Erro de leitura: " . mysql_error());
	if (!isset($_POST["login"])) {
		$html .= '<tr><td>Login da equipe:</td><td><input type="text" name="login" maxlength="16"/></td></tr>' . PHP_EOL;
		$html .= '<tr><td colspan=2>Preencha o campo "Login da equipe" corretamente!</td></tr>' . PHP_EOL;
		$erro = true;
	}
	elseif (mysql_num_rows($sql) > 0) {
		$html .= '<tr><td>Login da equipe:</td><td><input type="text" name="login" maxlength="16"/></td></tr>' . PHP_EOL;
		$html .= '<tr><td colspan=2>O login escolhido já está em uso.</td></tr>' . PHP_EOL;
	}
	else {
		$html .= '<tr><td>Login da equipe:</td><td><input type="text" name="login" maxlength="16" value="' . $_POST["login"] . '"/></td></tr>' . PHP_EOL;
	}
	
	$html .= '<tr><td>Senha de acesso:</td><td><input type="password" name="senha" maxlength="16"/></td></tr>' . PHP_EOL;
	if (!isset($_POST["senha"])) {
		$html .= '<tr><td colspan=2>Preencha o campo "Senha de acesso" corretamente!</td></tr>' . PHP_EOL;
		$erro = true;
	}
	
	$html .= '<tr><td>Confirmação de senha:</td><td><input type="password" name="senhac" maxlength="16"/></td></tr>' . PHP_EOL;
	if (!isset($_POST["senhac"])) {
		$html .= '<tr><td colspan=2>Preencha o campo "Confirmação de senha" corretamente!</td></tr>' . PHP_EOL;
		$erro = true;
	}
	
	if (isset($_POST["senha"]) && isset($_POST["senhac"]) && $_POST["senha"] != $_POST["senhac"]) {
		$html .= '<tr><td colspan=2>As senhas digitadas não coincidem!</td></tr>' . PHP_EOL;
		$erro = true;
	}
	
	$html .= '</table><br/>' . PHP_EOL;
	$html .= '<table class="center" style="border : 1px solid white; padding : 2px;"><tr><th></th><th>Nome:</th><th>Turma:</th><th>Email:</th></tr>' . PHP_EOL;
	
	$sql = mysql_query("SELECT nome FROM turmas ORDER BY ano, curso ASC;", $con) or exit("Erro de leitura: " . mysql_error());
	$turmas = "";
	while ($x = mysql_fetch_array($sql)) {
		$turmas .= '<option>' . $x["nome"] . '</option>' . PHP_EOL;
	}
	$turmaValido = validaTurmas();
	for ($i = 1; $i <= 3; $i++) {
		$erro_part = false;
		$html .= '<tr><td>Participante ' . $i . ':</td>' . PHP_EOL;
		
		if (validaNome(rawurldecode($_POST["nome" . $i]))) {
			$html .= '<td><input type="text" name="nome' . $i . '" maxlength="50" value="' . rawurldecode($_POST["nome" . $i]) . '"/></td>' . PHP_EOL;
		}
		else {
			$html .= '<td><input type="text" name="nome' . $i . '" maxlength="50"/></td>' . PHP_EOL;
			$erro_part = true;
		}
	
		if ($turmaValido == "ok") {
			$html .= '<td><select name="turma' . $i . '" style="width : 80px;" value="' . $_POST["turma" . $i] . '">' . $turmas . '</select></td>' . PHP_EOL;
		}
		else {
			$html .= '<td><select name="turma' . $i . '" style="width : 80px;">' . $turmas . '</select></td>' . PHP_EOL;
			$erro_part = true;
		}
		
		if (validaEmail($_POST["email" . $i])) {
			$html .= '<td><input type="text" name="email' . $i . '" maxlength="50" value="' . $_POST["email" . $i] . '"/></td>' . PHP_EOL;
		}
		else {
			$html .= '<td><input type="text" name="email' . $i . '" maxlength="50"/></td>' . PHP_EOL;
			$erro_part = true;
		}
		$html .= '</tr>';
		
		if ($erro_part) {
			$html .= '<tr><td colspan=3>Os dados do participante ' . $i . ' não são válidos.</td></tr>' . PHP_EOL;
			$erro = true;
		}
	}
	
	if ($turmaValido != "ok") {
		$html .= '<tr><td colspan=3>' . $turmaValido . '</td></tr>' . PHP_EOL;
		$erro = true;
	}
	
	$html .= '</table><p><input class="button" type="submit" value="Cadastrar" name="cadastrar"/><input class="button" type="reset" value="Limpar" name="limpar"/></p></form><br/>' . PHP_EOL;
	
	if (!$erro) {
		$equipe = mysql_real_escape_string(/*rawurldecode(*/$_POST["equipe"]/*)*/);
		$login = mysql_real_escape_string($_POST["login"]);
		$senha = hash("md5", mysql_real_escape_string($_POST["senha"]));
		$nome1 = mysql_real_escape_string(/*rawurldecode(*/$_POST["nome1"]/*)*/);
		$turma1 = mysql_real_escape_string($_POST["turma1"]);
		$email1 = mysql_real_escape_string($_POST["email1"]);
		$nome2 = mysql_real_escape_string(/*rawurldecode(*/$_POST["nome2"]/*)*/);
		$turma2 = mysql_real_escape_string($_POST["turma2"]);
		$email2 = mysql_real_escape_string($_POST["email2"]);
		$nome3 = mysql_real_escape_string(/*rawurldecode(*/$_POST["nome3"]/*)*/);
		$turma3 = mysql_real_escape_string($_POST["turma3"]);
		$email3 = mysql_real_escape_string($_POST["email3"]);
	
		mysql_query("INSERT INTO equipes (nome_equipe, login, senha) VALUES ('$equipe', '$login', '$senha')", $con) or exit("Erro de inserção: " . mysql_error());
		$result = mysql_query("SELECT cod_equipe FROM equipes WHERE login = '$login';", $con) or exit("Erro de leitura: " . mysql_error());
		$x = mysql_fetch_array($result);
		mysql_query("INSERT INTO participantes (cod_equipe, nome, turma, email) VALUES (" . $x["cod_equipe"] . ", '$nome1', '$turma1', '$email1'), (" . $x["cod_equipe"] . ", '$nome2', '$turma2', '$email2'), (" . $x["cod_equipe"] . ", '$nome3', '$turma3', '$email3');", $con) or exit("Erro de inserção: " . mysql_error());
		
		$result = mysql_query("SELECT cod_equipe FROM equipes WHERE login = '$login' AND senha = '$senha';", $con) or exit("Erro de leitura: " . mysql_error());
	
		if (mysql_num_rows($result) == 1) {
			$x = mysql_fetch_array($result);
			$_SESSION["cod"] = $x["cod_equipe"];
		}
		mysql_close($con);
		exit("sucesso");
	}
	mysql_close($con);
	exit(limpa_str($html));
?>