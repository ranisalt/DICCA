<?php
	require("../lib.php");
	require("lib.php");
	
	mysql_query("INSERT INTO respostas_final (cod_equipe, resposta) VALUES (" . $_SESSION["cod"] . ", '" . mysql_real_escape_string($_POST["r"]) . "');", $con) or exit(mysql_error());
	echo '<form name="desafio" onsubmit="return validaRaciocinio();">' . PHP_EOL;
	echo '<p><strong>Pergunta final - raciocínio</strong></p>' . PHP_EOL;
	echo '<p><textarea name="raciocinio" class="textarea" style="height : 200px;"></textarea></p>' . PHP_EOL;
	echo '<br/>' . PHP_EOL;
	echo '<tr><td><p>Esta questão vale infinitos pontos.</p></td></tr>' . PHP_EOL;
	echo '<p><input class="button" type="submit" value="Responder"/></p>' . PHP_EOL;
	echo '</form>';
?>