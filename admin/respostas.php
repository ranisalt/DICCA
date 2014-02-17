<?php
	session_start();
	require("mysql.php");
	
	//restringindo a página para "cod" (código de equipe) setado (equipes logadas)
	if (!$_SESSION["cod"] == 1) {
		header("Location: ../404.php");
		exit;
	}	
	
	include("info.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>DICCA #5 - Ranking</title>
		<meta http-equiv="Content-Type" content="text/html;charset=windows-1252"/>
		<link rel="stylesheet" type="text/css" href="../style.css"/>
		<style type="text/css">
			table.ranking { margin-left : auto; margin-right : auto; text-align : center; border : 1px solid black; border-radius : 5px; padding : 5px; }
			table.ranking th, table.ranking td { border : 1px solid black; padding : 2px; }
			br { clear : both; }
		</style>
	</head>
	<body>
		<div class="header"><?php echo $header; ?></div>
		<div id="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="index.php"/>Admin</a></li>
				<li><a href="validar.php">Validar</a></li>
				<li><a href="mensagens.php">Mensagens</a></li>
				<li><a id="atual">Respostas</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<?php
				include("mysql.php");
				$con = mysql_connect("localhost", $user, $pass) or exit('Erro de conexão: ' . mysql_error());
				mysql_select_db($db, $con);	//seleciona o banco de dados
				
				$eqp = mysql_query("SELECT distinct e.cod_equipe, e.nome_equipe, r.cod_equipe FROM equipes e, respostas r WHERE e.cod_equipe = r.cod_equipe;", $con) or exit('Erro de leitura: ' . mysql_error());
				if (mysql_num_rows($eqp) == 0) {
					echo '<p>Nenhuma equipe respondeu alguma pergunta</p>';
				}
				else {
					while ($i = mysql_fetch_array($eqp)) {
						echo '<table class="ranking"><caption>Equipe: ' . $i["nome_equipe"] . '</caption><tr><th>Pergunta</th><th>Horário</th></tr>';
						$rsp = mysql_query("SELECT cod_pergunta, horario, pulou FROM respostas WHERE cod_equipe = " . $i["cod_equipe"] . ";", $con) or exit('Erro de leitura: ' . mysql_error());
						while ($j = mysql_fetch_array($rsp)) {
							$pulou = $j["pulou"] == 0 ? "0, 255, 0" : "255, 0, 0";
							echo '<tr style="background-color : rgba(' . $pulou . ', 0.2);"><td>' . $j["cod_pergunta"] . '</td><td>' . date("d/m/Y H:i:s", strtotime($j["horario"])) . '</td></tr>' . PHP_EOL;
						}
						$max = mysql_query("SELECT * FROM perguntas;", $con);
						if (mysql_num_rows($rsp) == mysql_num_rows($max)) {
							echo '<tr><td colspan=3><strong>Respondeu todas!</strong></td></tr>';
						}
						echo '</table><br/>';
					}
				}
				
				mysql_close($con);
			?>
		</div>
		<div class="footer"><?php echo $footer; ?></div>
	</body>
</html>