<?php
	require("../mysql.php");
	$con = mysql_connect("localhost", $user, $pass) or exit('Erro de conexão: ' . mysql_error());
	mysql_select_db($db, $con);
	
	/*$result = mysql_query("SELECT cod_msg FROM mensagens WHERE respondida = 0;", $con);
	
	while ($x = mysql_fetch_array($result)){
		if(isset($_POST["responder" . $x["cod_msg"]])){
			$sq = mysql_query("UPDATE equipes SET validado = 1 WHERE cod_equipe = " . $x["cod_equipe"] . ";");
		}
	}*/
	mysql_close($con);
	
	/*mail("lordfire@xtibia.com", "Teste", "Teste de email");
	exit("Enviado!");*/
	
	include("info.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>DICCA #5 - Administração</title>
		<meta http-equiv="Content-Type" content="text/html;charset=windows-1252"/>
		<link rel="stylesheet" type="text/css" href="../style.css"/>
	</head>
	<body>
		<div class="header"><?php echo $header; ?></div>
		<div id="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a href="index.php"/>Admin</a></li>
				<li><a href="validar.php">Validar</a></li>
				<li><a id="atual">Mensagens</a></li>
				<li><a href="respostas.php">Respostas</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<table class="center" style="padding : 2px; border : 1px solid black; border-radius : 10px; min-width : 600px;">
				<caption>Mensagens de equipes</caption>
				<?php
					$con = mysql_connect("localhost", $user, $pass) or exit('Erro de conexão: ' . mysql_error());
					mysql_select_db($db, $con);
					
					$result = mysql_query("SELECT m.cod_msg, m.horario, m.mensagem, m.resposta, e.nome_equipe FROM mensagens_equipes m, equipes e WHERE m.cod_equipe = e.cod_equipe AND m.resposta = '' ORDER BY horario DESC;", $con);
					
					if (mysql_num_rows($result)) {
						echo '<tr>
						<td style="border : 1px solid black; width : 150px;">Horário</td>
						<td style="border : 1px solid black; width : 150px;">Equipe</td>
						<td style="border : 1px solid black; width : 500px;">Mensagem</td>
						<td style="border : 1px solid black; width : 100px;">Responder</td>
						</tr>';
						while ($x = mysql_fetch_array($result))
						{
							echo '<tr><td>' . date("H:i:s d/m/Y", strtotime($x["horario"])) . '</td>';
							echo '<td>' . $x["nome_equipe"] . '</td>';
							echo '<td>' . $x["mensagem"] . '</td>';						
							echo '<td><input type="button" value="Responder" onclick="window.open(\'responder.php?msg=equipes&cod=' . $x["cod_msg"] . '\');" style="width : 100px;"/></td></tr>';
						}
					}
					else {
						echo '<tr><td style="text-align : center;">Nenhuma mensagem nova</td></tr>';
					}
					
					mysql_close($con);
				?>
			</table>
			<br/>
			<table class="center" style="padding : 2px; border : 1px solid black; border-radius : 10px; min-width : 600px;">
				<caption>Mensagens públicas</caption>
				<?php
					$con = mysql_connect("localhost", $user, $pass) or exit('Erro de conexão: ' . mysql_error());
					mysql_select_db($db, $con);
					
					$result = mysql_query("SELECT cod_msg, horario, nome, email, mensagem FROM mensagens_pessoas WHERE respondida = 0 ORDER BY horario DESC;", $con);
					
					if (mysql_num_rows($result)) {
						echo '<tr>
						<td style="border : 1px solid black; width : 150px;">Horário</td>
						<td style="border : 1px solid black; width : 150px;">Nome</td>
						<td style="border : 1px solid black; width : 150px;">Email</td>
						<td style="border : 1px solid black; width : 350px;">Mensagem</td>
						<td style="border : 1px solid black; width : 100px;">Responder</td>
						</tr>';
						while ($x = mysql_fetch_array($result))
						{
							echo '<form action="mensagens.php" method="post"><tr>';
							echo '<td>' . date("H:i:s d/m/Y", strtotime($x["horario"])) . '</td>';
							echo '<td>' . $x["nome"] . '</td>';
							echo '<td>' . $x["email"] . '</td>';
							echo '<td>' . $x["mensagem"] . '</td>';						
							echo '<td><input type="button" value="Responder" onclick="window.open(\'responder.php?msg=pessoas&cod=' . $x["cod_msg"] . '\');" style="width : 100px;"/></td>';
							echo '</tr></form>';
						}
					}
					else {
						echo '<tr><td style="text-align : center;">Nenhuma mensagem nova</td></tr>';
					}
					
					mysql_close($con);
				?>
			</table>
			<br/>
		</div>
		<div class="footer"><?php echo $footer; ?></div>
	</body>
</html>