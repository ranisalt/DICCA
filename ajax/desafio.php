<?php
	header("Content-Type: text/html; charset=ISO-8859-1");

	require("../lib.php");
	require("lib.php");
	$respostas = mysql_query("SELECT DISTINCT cod_pergunta FROM respostas WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit("Erro de leitura: " . mysql_error());
	$perguntas = mysql_query("SELECT * FROM perguntas;", $con) or exit("Erro de leitura: " . mysql_error());
	
	function pontuacao() {
		global $con;
		$sql = mysql_query("SELECT * FROM respostas WHERE cod_equipe = " . $_SESSION["cod"] . " AND pulou = 0;", $con);
		echo '<p style="font-size : 100%;">Perguntas respondidas: ' . mysql_num_rows($sql) . '<br/>';
		$sql = mysql_query("SELECT sum(p.pontos) AS soma FROM respostas r, perguntas p WHERE r.cod_pergunta = p.cod_pergunta AND cod_equipe = " . $_SESSION["cod"] . " AND pulou = 0;", $con);	
		$sql = mysql_fetch_array($sql);
		echo utf8_decode('Pontuação da equipe: ') . $sql["soma"] . '</p>';
	}
	
	function desafio($a) {
		global $con;
		pontuacao();
		$sql = mysql_query("SELECT * FROM perguntas WHERE cod_pergunta = " . $a . ";", $con) or exit("Erro de leitura: " . mysql_error());
		$sql = mysql_fetch_array($sql);
		echo '<form name="desafio" onsubmit="return validaResposta();" onreset="return validaPular();">' . PHP_EOL;
		echo '<p><strong>Pergunta ' . $sql["cod_pergunta"] . ' - ' . utf8_decode($sql["tema"]) . '</strong></p>' . PHP_EOL;
		echo '<p><em>' . utf8_decode($sql["pergunta"]) . '</em></p>' . PHP_EOL;
		echo '<br/>' . PHP_EOL;
		echo '<table class="center"><tr><td><p><input type="text" name="resposta" onkeyup="contaChar();" maxlength=' . strlen($sql["resposta"]). ' style="width : 300px; margin : 0px; padding : 0px;"/></p><td></tr>' . PHP_EOL;
		echo '<tr><td><p>Dica: <strong>' . utf8_decode($sql["dica"]) . '</strong></p></td></tr>' . PHP_EOL;
		echo '<tr><td><p>Esta quest&atilde;o vale ' . $sql["pontos"] . ' pontos.</p></td></tr>' . PHP_EOL;
		echo '<tr><td><p>Caracteres digitados: <span id="chr">0</span> de '  . strlen($sql["resposta"]) .  '</p></td></tr></table>' . PHP_EOL;
		echo '<p><input class="button" type="submit" value="Responder"/><input class="button" type="reset" value="Pular"/></p>' . PHP_EOL;
		echo '</form>';
	}
	
	/*SELECT (SELECT count(*) FROM respostas WHERE cod_equipe = 1) - ( SELECT count(*) FROM perguntas) AS count;*/
	
	if ($_POST["p"] == "false") {
		$sql = mysql_query("SELECT * FROM perguntas WHERE cod_pergunta = " . (mysql_num_rows($respostas) + 1) . ";", $con) or exit("Erro de leitura: " . mysql_error());
		$sql = mysql_fetch_array($sql);
		if (mysql_num_rows($perguntas) > mysql_num_rows($respostas)) {
			if (!desafio_compara(mysql_real_escape_string($_POST["r"]), $sql["resposta"])) {			
				desafio(mysql_num_rows($respostas) + 1);
				exit("<p style='color : red;'>Resposta errada!</p>");
			}
			else {
				
				mysql_query("INSERT INTO respostas (cod_equipe, cod_pergunta, pulou) VALUES (" . $_SESSION["cod"] . ", " . (mysql_num_rows($respostas) + 1) . ", 0);", $con);
				if (mysql_num_rows($perguntas) > mysql_num_rows($respostas)+1) {
					desafio(mysql_num_rows($respostas) + 2);
					exit();
				}
			}
		}
		
	}
	else {
		mysql_query("INSERT INTO respostas (cod_equipe, cod_pergunta) VALUES (" . $_SESSION["cod"] . ", " . (mysql_num_rows($respostas) + 1) . ");", $con);
		if (mysql_num_rows($perguntas) > mysql_num_rows($respostas)+1) {
			desafio(mysql_num_rows($respostas) + 2);
			exit;
		}
	}
	pontuacao();
	exit('sucesso');
?>