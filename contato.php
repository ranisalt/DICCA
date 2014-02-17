<?php
	require("lib.php");
	if (!verificarLogin()) {
		forcarLogin();
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?> - Contato</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<style type="text/css">			
			input, textarea { width : 400px; resize : none; }
			table.center td { vertical-align : top; padding : 2px; }
		</style>
		<script type="text/javascript" src="js/contato.js"/></script>
	</head>
	<body>
		<div class="header"><?php echo $header ?></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php
					if (!isset($_SESSION["cod"])) {
						echo '<li><a href="cadastro.php">Cadastro</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="sobre.php">Sobre</a></li>' . PHP_EOL;
					}
					else {
						echo '<li><a href="equipe.php">Equipe</a></li>
				<li><a href="desafio.php">Desafio</a></li>
				<li><a href="ranking.php">Ranking</a></li>' . PHP_EOL;
					}
				?>
				<li><a id="atual">Contato</a></li>
				<?php
					if (isset($_SESSION["cod"])) {
						echo '<li><a href="logout.php">Sair</a></li>' . PHP_EOL;
					}
				?>
			</ul>
		</div>
		<div class="box" id="box">
			<br/>
		<?php	
			$sql = mysql_query("SELECT status FROM controle WHERE sistema = 'contato' and status = 1;", $con);
			if (mysql_num_rows($sql) == 1) {
				echo '	<form name="contato" onsubmit="return contato' . ((isset($_SESSION["cod"])) ? "Equipe" : "Pessoal") . '();">
				<table class="center">
					<tr>
						<td>
							<table class="center" style="text-align : right;">' . PHP_EOL;
					if (!isset($_SESSION["cod"])) {
									echo '								<tr><td>Nome: </td><td><input type="text" name="nome" class="text"/></td></tr>
									<tr><td>Email: </td><td><input type="text" name="email" class="text"/></td></tr>
									<tr><td>Mensagem: </td><td><textarea name="mensagem" class="textarea" style="height : 200px;"></textarea></td></tr>';
					}
					else {
						$sql = mysql_query("SELECT nome_equipe FROM equipes WHERE cod_equipe = " . $_SESSION["cod"] .";", $con);
						$sql = mysql_fetch_array($sql);
									echo '								<tr><td>Equipe:</td><td style="text-align : left; width : 400px;"><strong>' . utf8_decode($sql["nome_equipe"]) . '</strong></td></tr>
								<tr><td>Mensagem: </td><td><textarea name="mensagem" class="textarea" style="height : 200px;"></textarea></td></tr>' . PHP_EOL;
						mysql_close($con);
					}
							echo '							</table>
						</td>
						<td><img src="img/contato.jpg" style="margin : -8px;"/></td>
					</tr>
					<tr>
						<td colspan=2><p><input class="button" type="submit" value="Enviar"/><input class="button" type="reset" value="Limpar"/></p></td>
					</tr>
				</table>			
			</form>' . PHP_EOL;
			}
			else {
				echo '<p>O contato está desabilitado!<br/>Volte novamente em alguns dias.</p>';
			}
		?>
			<br/>
		</div>
		<div class="footer">
			<div class="footer"><?php echo $footer ?></div>
		</div>
	</body>
</html>