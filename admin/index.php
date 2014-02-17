<?php
	require("../lib.php");
	require("mysql.php");
	if (!$_SESSION["cod"] == 1) {
		header("Location: ../404.php");
		exit;
	}
	else {
		if (isset($_POST["trunc_equipes"])) {
			if (($_POST["nova_senha"] != NULL) && ($_POST["nova_senhac"] != NULL)) {
				if ($_POST["nova_senha"] == $_POST["nova_senhac"]) {
					require("admin.php");
					mysql_query("TRUNCATE TABLE equipes;", $con);
					mysql_query("TRUNCATE TABLE participantes;", $con);						
					mysql_query("INSERT INTO equipes (cod_equipe, nome_equipe, login, senha, valida) VALUES (1, 'Administração', 'admin', '" . hash("md5", mysql_real_escape_string($_POST["nova_senha"])) . "', 1);", $con);
					$result = mysql_query("SELECT max(cod_equipe) AS max FROM equipes;", $con);
					$result = mysql_fetch_array($result);
					$cod_equipe = $result["max"];
					mysql_query("INSERT INTO participantes (cod_equipe, nome, turma, email) VALUES ($cod_equipe, '$nome1', '$turma1', '$email1');", $con);
					mysql_query("INSERT INTO participantes (cod_equipe, nome, turma, email) VALUES ($cod_equipe, '$nome2', '$turma2', '$email2');", $con);
					mysql_query("INSERT INTO participantes (cod_equipe, nome, turma, email) VALUES ($cod_equipe, '$nome3', '$turma3', '$email3');", $con);
					mysql_close($con);
					session_destroy();
					header("Location: ../login.php");
					exit;
				}
				else {
					echo "<script type='text/javascript'>alert('As senhas digitadas não coincidem!');</script>";
				}
			}
			else {
				echo "<script type='text/javascript'>alert('Digite uma nova senha!');</script>";
			}
		}
		elseif (isset($_POST["trunc_mensagens"])) {
			mysql_query("TRUNCATE TABLE mensagens_equipes; TRUNCATE TABLE mensagens_pessoas;", $con);
			echo "<script type='text/javascript'>alert('Mensagens truncadas!');</script>";
		}
		elseif (isset($_POST["trunc_respostas"])) {
			mysql_query("TRUNCATE TABLE respostas; TRUNCATE TABLE respostadodia;", $con);
			echo "<script type='text/javascript'>alert('Respostas truncadas!');</script>";
		}
		elseif (isset($_POST["ativar_cadastro"])) {
			mysql_query("UPDATE controle SET status = 1 WHERE sistema = 'cadastro';", $con);
			echo "<script type='text/javascript'>alert('Cadastro ativado!');</script>";
		}
		elseif (isset($_POST["desativar_cadastro"])) {
			mysql_query("UPDATE controle SET status = 0 WHERE sistema = 'cadastro';", $con);
			echo "<script type='text/javascript'>alert('Cadastro desativado!');</script>";
		}
		elseif (isset($_POST["ativar_desafio"])) {
			mysql_query("UPDATE controle SET status = 1 WHERE sistema = 'desafio';", $con);
			echo "<script type='text/javascript'>alert('Desafio ativado!');</script>";
		}
		elseif (isset($_POST["desativar_desafio"])) {
			mysql_query("UPDATE controle SET status = 0 WHERE sistema = 'desafio';", $con);
			echo "<script type='text/javascript'>alert('Desafio desativado!');</script>";
		}
		elseif (isset($_POST["ativar_contato"])) {
			mysql_query("UPDATE controle SET status = 1 WHERE sistema = 'contato';", $con);
			echo "<script type='text/javascript'>alert('Contato ativado!');</script>";
		}
		elseif (isset($_POST["desativar_contato"])) {
			mysql_query("UPDATE controle SET status = 0 WHERE sistema = 'contato';", $con);
			echo "<script type='text/javascript'>alert('Contato desativado!');</script>";
		}
		mysql_close($con);
	}
	
	include("info.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>DICCA #5 - Equipe</title>
		<meta http-equiv="Content-Type" content="text/html;charset=windows-1252"/>
		<link rel="stylesheet" type="text/css" href="../style.css"/>
		<style type="text/css">
			input { width : 150px; height : 30px; font-size : 100%; }
		</style>
	</head>
	<body>
		<div class="header"><?php echo $header; ?></div>
		<div id="menu">
			<ul>
				<li><a href="../index.php">Home</a></li>
				<li><a id="atual">Admin</a></li>
				<li><a href="validar.php">Validar</a></li>
				<li><a href="mensagens.php">Mensagens</a></li>
				<li><a href="respostas.php">Respostas</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<p class="box">Controle de equipes</p>
			<?php
				echo "<form action='index.php' method='post'><table class='center'>";
				echo "<tr><td>Nova senha:</td><td>Confirmar:</td></tr>";
				echo "<tr><td><input type='text' name='nova_senha'/></td><td><input type='text' name='nova_senhac'/></td>";
				echo "<tr><td colspan=2 style='text-align : center;'><input type='submit' value='Truncar equipes' name='trunc_equipes'/></td></tr>";
				echo "</table></form>";
			?>
			<br/>
			<hr/>
			<table class="center">
				<p class="box">Mensagens e respostas</p>
				<tr>
					<td>
						<?php
							echo "<form action='index.php' method='post'><table class='center'>";
							echo "<tr><td><input type='submit' value='Truncar mensagens' name='trunc_mensagens'/></td></tr>";
							echo "</table></form>";
						?>
					</td>
					<td>
						<?php
							echo "<form action='index.php' method='post'><table class='center'>";
							echo "<tr><td><input type='submit' value='Truncar respostas' name='trunc_respostas'/></td></tr>";
							echo "</table></form>";
						?>
					</td>
				</tr>
			</table>
			<br/>
			<hr/>
			<p class="box">Controle de sistemas</p>
			<?php
				echo "<form action='index.php' method='post'><table class='center'><tr>";
				include("mysql.php");
				$con = mysql_connect("localhost", $user, $pass);
				if (!$con){ die('Erro de conexão: ' . mysql_error()); }
				mysql_select_db("dicca", $con);
				
				$sql = "SELECT status FROM controle WHERE sistema = 'cadastro';";
				$result = mysql_query($sql, $con);
				$x = mysql_fetch_array($result);
				
				if ($x["status"] == 0) {
					echo "<td><input type='submit' value='Ativar cadastro' name='ativar_cadastro'/></td>";
				}
				else {
					echo "<td><input type='submit' value='Desativar cadastro' name='desativar_cadastro'/></td>";
				}
				
				$sql = "SELECT status FROM controle WHERE sistema = 'desafio';";
				$result = mysql_query($sql, $con);
				$x = mysql_fetch_array($result);
				
				if ($x["status"] == 0) {
					echo "<td><input type='submit' value='Ativar desafio' name='ativar_desafio'/></td>";
				}
				else {
					echo "<td><input type='submit' value='Desativar desafio' name='desativar_desafio'/></td>";
				}
				
				$sql = "SELECT status FROM controle WHERE sistema = 'contato';";
				$result = mysql_query($sql, $con);
				$x = mysql_fetch_array($result);
				
				if ($x["status"] == 0) {
					echo "<td><input type='submit' value='Ativar contato' name='ativar_contato'/></td>";
				}
				else {
					echo "<td><input type='submit' value='Desativar contato' name='desativar_contato'/></td>";
				}
				echo "</tr></table></form>";
			?>
			<br/>
		</div>
		<div class="footer"><?php echo $footer; ?></div>
	</body>
</html>