<?php
	require("lib.php");
	if (!verificarLogin()) {
		if (!forcarLogin()) {
			header("Location: index.php");
			exit;
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?> - Ranking</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<style type="text/css">
			table.ranking { margin-left : auto; margin-right : auto; text-align : center; border : 1px solid black; border-radius : 5px; padding : 5px; }
			table.ranking th, table.ranking td { border : 1px solid black; padding : 2px; }
			br { clear : both; }
		</style>
	</head>
	<body>
		<div class="header">
			<p><img src="img/desafioaceito.png" alt="Desafio aceito" style="height : 71px; margin-right : 20px;"/><img src="img/dicca.png" alt="Dicca #5" style="height : 71px;"/><img src="img/cerealguy.png" alt="Cereal guy" style="height : 71px; margin-left : 20px;"/></p>
		</div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="equipe.php">Equipe</a></li>
				<li><a href="desafio.php">Desafio</a></li>
				<li><a id="atual">Ranking</a></li>
				<li><a href="contato.php">Contato</a></li>
				<li><a href="logout.php">Sair</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<table class="ranking">
				<tr>
					<th>Pergunta:</th>
					<th>Respostas:</th>
				</tr>
				<?php					
					$result = mysql_query("SELECT * FROM perguntas;", $con) or exit("Erro de leitura: " . mysql_error());
					
					$i = 0;
					while ($i++ < mysql_num_rows($result)) {
						$qtd = mysql_query("SELECT * FROM respostas WHERE cod_pergunta = " . $i . " AND pulou = 0;") or exit("Erro de leitura: " . mysql_error());
						
						echo "<tr>" . PHP_EOL;
						echo "<td>" . $i . "</td>" . PHP_EOL;
						echo "<td>" . mysql_num_rows($qtd) . "</td>" . PHP_EOL;
						echo "</tr>" . PHP_EOL;
					}
					
					mysql_close($con);
				?>
			</table>
			<br/>
		</div>
		<div class="footer">
			<table>
				<tr>
					<td><a href="http://facebook.com/dicca5" target="_blank"><img src="img/facebook.png"/></a></td>
					<td><a href="http://facebook.com/dicca5" target="_blank" style="padding-right : 20px;">Curta no Facebook!</a></td>
					<td><a href="http://twitter.com/dicca5" target="_blank" style="padding-left : 20px;"><img src="img/twitter.png"/></a></td>
					<td><a href="http://twitter.com/dicca5" target="_blank">Siga no Twitter!</a></td>
				</tr>
			</table>
		</div>
	</body>
</html>