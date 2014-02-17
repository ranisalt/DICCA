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
		<title><?php echo $evento ?> - Equipe</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<style type="text/css">			
			th { font-size : 120%; } 
			td input { margin : 5px; width : 200px; }
			table.info { border : 1px solid black; border-radius : 10px; margin-left : auto; margin-right : auto; padding : 5px; }
			table.info th, table.info td { border : 1px solid black; padding : 5px; }
		</style>
		<script type="text/javascript" src="js/equipe.js"></script>
	</head>
	<body>
		<div class="header"><?php echo $header ?></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a id="atual">Equipe</a></li>
				<li><a href="desafio.php">Desafio</a></li>
				<li><a href="ranking.php">Ranking</a></li>
				<li><a href="contato.php">Contato</a></li>
				<li><a href="logout.php">Sair</a></li>
			</ul>
		</div>
		<div class="box">
			<?php
				$sql = mysql_query("SELECT * FROM equipes WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con);
				$sql = mysql_fetch_array($sql);
				
				echo '<br/><p> Bem vindo(a), ' . utf8_decode($sql["nome_equipe"]) . '!</p>';
				if ($sql["valida"] == 0) {
					echo '<p style="color : red;">Sua equipe ainda não foi validada!<br/>' . PHP_EOL;
					echo '<a href="index.php#comoparticipar" style="color : blue; font-weight : bold;">Como validar?</a></p>' . PHP_EOL;
				}
				else {
					echo '<p style="color : green;">Sua equipe já foi validada!</p>';
				}
				
				echo '<br/>';
				echo '<table class="info"><caption>Integrantes</caption>';
				echo '<tr><th>Nome</th><th>Turma</th><th>E-mail</th></tr>';
				
				$sql = mysql_query("SELECT nome, turma, email FROM participantes WHERE cod_equipe = " . $_SESSION["cod"] . " ORDER BY nome ASC;", $con);
				while ($linha = mysql_fetch_array($sql)) {
					echo '<tr><td>' . $linha["nome"] . '</td><td>' . $linha["turma"] . '</td><td><a href="mailto:' . $linha["email"] . '">' . $linha["email"] . '</a></td></tr>';
				}
				
				echo '</table><br/>';
				echo '<div id="alterar_senha">';
				echo '<form name="alterar_senha" onsubmit="return alterarSenha();">';
				echo '<table class="center">';
				echo '<caption>Alterar senha:</caption>';
				echo '<tr><td>Senha antiga:</td><td><input type="password" name="antiga"/></td></tr>';
				echo '<tr><td>Nova senha:</td><td><input type="password" name="nova"/></td></tr>';
				echo '<tr><td>Confirmar senha:</td><td><input type="password" name="novac"/></td></tr></table>';
				echo '<p><input class="button" type="submit" value="Alterar"/></p>';
				echo '</form>';
				echo '</div>';
				?>
			<br/>
		</div>
		<div class="footer"><?php echo $footer ?></div>
	</body>
</html>