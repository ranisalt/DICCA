<?php
	session_start();
	require("mysql.php");
	
	if (isset($_COOKIE["login"]) && isset($_COOKIE["senha"])) {
		$con = mysql_connect("localhost", $user, $pass) or exit('Erro de conexão: ' . mysql_error());
		mysql_select_db($db, $con);	//seleciona o banco de dados
		$sql = mysql_query("SELECT cod_equipe FROM equipes WHERE login = '" . $_COOKIE["login"] . "' AND senha = '" . $_COOKIE["senha"] . "';", $con);
		$sql = mysql_fetch_array($sql);
		$_SESSION["cod"] = $sql["cod_equipe"];
	}
	
	include("info.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?></title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
		<div class="header"><?php echo $header ?></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<?php
					if (!isset($_SESSION["cod"])) {
						echo "<li><a href='cadastro.php'>Cadastro</a></li>" . PHP_EOL;
						echo "<li><a href='login.php'>Login</a></li>" . PHP_EOL;
						echo '<li><a href="sobre.php">Sobre</a></li>' . PHP_EOL;
					}
					else {
						if ($_SESSION["cod"] == 1) {
							echo "<li><a href='admin/index.php'>Admin</a></li>" . PHP_EOL;
						}
						echo "<li><a href='equipe.php'>Equipe</a></li>" . PHP_EOL;
						echo "<li><a href='desafio.php'>Desafio</a></li>" . PHP_EOL;
						echo "<li><a href='ranking.php'>Ranking</a></li>" . PHP_EOL;
					}
				?>
				<li><a href="contato.php">Contato</a></li>
				<?php
					if (isset($_SESSION["cod"])) {
						echo "<li><a href='logout.php'>Sair</a></li>" . PHP_EOL;
					}
				?>
			</ul>
		</div>
		<div class="box">
			<br/>
			<p>Você tentou acessar uma página que não existe.</p>
			<p>Está tentando chegar onde, safadinho?</p>
			<br/>
		</div>
		<div class="footer"><?php echo $footer ?></div>
	</body>
</html>