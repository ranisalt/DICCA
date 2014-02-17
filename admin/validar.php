<?php
	session_start();
	
	if (!$_SESSION["cod"] == 1) {
		header("Location: ../404.php");
		exit;
	}
	else {
		include("mysql.php");
		$con = mysql_connect("localhost", $user, $pass);
		if (!$con){ die('Erro de conexão: ' . mysql_error()); }
		mysql_select_db($db, $con);
			
		$result = mysql_query("SELECT cod_equipe FROM equipes;", $con);
						
		while ($row = mysql_fetch_array($result)){
			$cod = $row["cod_equipe"];
			if(isset($_POST["validar" . $row["cod_equipe"]])){
				mysql_query("UPDATE equipes SET valida = 1 WHERE cod_equipe = $cod;");
				break;
			}
			elseif(isset($_POST["invalidar" . $row["cod_equipe"]])){
				mysql_query("UPDATE equipes SET valida = 0 WHERE cod_equipe = $cod;");
				break;
			}
		}
		mysql_close($con);
	}
	
	include("info.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>DICCA #5 - Administração</title>
		<meta http-equiv="Content-Type" content="text/html;charset=windows-1252"/>
		<link rel="stylesheet" type="text/css" href="../style.css"/>
		<style type="text/css">
			table.center { min-width : 600px; text-align : center; }
		</style>
	</head>
	<body>
		<div class="header"><?php echo $header; ?></div>
		<div id="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="index.php">Admin</a></li>
				<li><a id="atual">Validar</a></li>
				<li><a href="mensagens.php">Mensagens</a></li>
				<li><a href="respostas.php">Respostas</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<table class="center" style="padding : 2px; border : 1px solid black; border-radius : 10px;">
				<caption>Equipes não-válidas</caption>
				<?php
					include("../mysql.php");
					$con = mysql_connect("localhost", $user, $pass);
					if (!$con)  { die('Erro de conexão: ' . mysql_error()); }
					mysql_select_db($db, $con);
					
					$result = mysql_query("SELECT cod_equipe, nome_equipe FROM equipes WHERE valida = 0 AND cod_equipe > 1;", $con);
					
					if (mysql_num_rows($result) >= 1) {
						while ($row = mysql_fetch_array($result))
						{
							echo "<form action='validar.php' method='post'><tr>" . PHP_EOL;
							echo "<td style='border : 1px solid black; width : 20px;' name='cod' id='cod'>" . $row['cod_equipe'] . "</td>" . PHP_EOL;
							echo "<td style='border : 1px solid black; width : 300px;'>" . $row['nome_equipe'] . "</td>" . PHP_EOL;
							echo "<td style='border : 1px solid black; width : 100px;'><input type='submit' value='Validar' name='validar" . $row["cod_equipe"] . "' style='width : 100px;'/></td>" . PHP_EOL;
							echo "</tr></form>" . PHP_EOL;
						}
					}
					else {
						echo "<tr><td>Nenhuma equipe esperando validação</td></tr>" . PHP_EOL;
					}
				?>
			</table>
			<br/>
			<table class="center" style="padding : 2px; border : 1px solid black; border-radius : 10px;">
				<caption>Equipes válidas</caption>
				<?php					
					$result = mysql_query("SELECT cod_equipe, nome_equipe FROM equipes WHERE valida = 1 AND cod_equipe > 1;", $con);
					
					if (mysql_num_rows($result) >= 1) {
						while ($row = mysql_fetch_array($result))
						{
							echo "<form action='validar.php' method='post'><tr>" . PHP_EOL;
							echo "<tr>" . PHP_EOL;
							echo "<td style='border : 1px solid black; width : 20px;' name='cod' id='cod'>" . $row['cod_equipe'] . "</td>" . PHP_EOL;
							echo "<td style='border : 1px solid black; width : 300px;'>" . $row['nome_equipe'] . "</td>" . PHP_EOL;
							echo "<td style='border : 1px solid black; width : 100px;'><input type='submit' value='Invalidar' name='invalidar" . $row["cod_equipe"] . "' style='width : 100px;'/></td>" . PHP_EOL;
							echo "</tr>" . PHP_EOL;
							echo "</tr></form>" . PHP_EOL;
						}
					}
					else {
						echo "<tr><td>Nenhuma equipe validada</td></tr>" . PHP_EOL;
					}
					
					mysql_close($con);
				?>
			</table>
			<br/>
		</div>
		<div class="footer"><?php echo $footer; ?></div>
	</body>
</html>