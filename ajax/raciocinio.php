<?php
	require("../lib.php");
	require("lib.php");
	
	mysql_query("UPDATE respostas_final SET raciocinio = '" . mysql_real_escape_string($_POST["r"]) . "' WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit(mysql_error());
	/*$r_final = mysql_query("SELECT * FROM respostas_final WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit('Erro de leitura: ' . mysql_error());
	$r_final = mysql_fetch_array($r_final);
	echo '<script type="text/javascript">alert("Raciocínio salvo!");</script>';
	echo '<form name="desafio" onsubmit="return validaRaciocinio();">' . PHP_EOL;
	echo '<p><strong>Pergunta final - raciocínio</strong></p>' . PHP_EOL;
	echo '<p><textarea name="raciocinio" class="textarea" style="height : 200px;">' . $r_final["raciocinio"] . '</textarea></p>' . PHP_EOL;
	echo '<br/>' . PHP_EOL;
	echo '<tr><td><p>Esta questão vale infinitos pontos.</p></td></tr>' . PHP_EOL;
	echo '<p><input class="button" type="submit" value="Responder"/></p>' . PHP_EOL;
	echo '</form>';*/
?>