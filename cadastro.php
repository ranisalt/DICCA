<?php
	require("lib.php");
	if (!verificarLogin()) {
		if (forcarLogin()) {
			header("Location: index.php");
			exit;
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?> - Cadastro</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script type="text/javascript" src="js/cadastro.js"/></script>
		<style type="text/css">			
			th { font-size : 120%; } 
			input { margin : 5px; width : 200px; }
		</style>
	</head>
	<body>
		<div class="header"><?php echo $header ?></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a id="atual">Cadastro</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="sobre.php">Sobre</a></li>
				<li><a href="contato.php">Contato</a></li>
			</ul>
		</div>
		<div class="box" id="box">
		<?php	
			$sql = mysql_query("SELECT status FROM controle WHERE sistema = 'cadastro' and status = 1;", $con);
			if (mysql_num_rows($sql) == 1) {
				$sql = mysql_query("SELECT nome FROM turmas ORDER BY ano, curso ASC;", $con);
				$turmas = "";
				while ($linha = mysql_fetch_array($sql)) {
					$turmas = $turmas . '<option>' . $linha["nome"] . '</option>';
				}
				?>
				<br/>
				<form name="cadastro" onsubmit="return validaCadastro();" onreset="return confirmaLimpar();">
					<table class="center">
						<tr><td>Nome da equipe:</td><td><input type="text" name="equipe" maxlength="30"/></td></tr>
						<tr id="equipe_ok"></tr>
						<tr><td>Login da equipe:</td><td><input type="text" name="login" maxlength="16"/></td></tr>
						<tr id="login_ok"></tr>
						<tr><td>Senha de acesso:</td><td><input type="password" name="senha" maxlength="16" /></td></tr>
						<tr><td>Confirme a senha:</td><td><input type="password" name="senhac" maxlength="16"/></td></tr>
						<tr id="senha_ok"></tr>						
					</table>
					<br/>
					<table class="center" style="border : 1px solid white; padding : 2px;">
						<tr><th></th><th>Nome:</th><th>Turma:</th><th>Email:</th></tr>
						<?php
							for ($i = 1; $i <= 3; $i++) {
								echo '<tr><td>Participante ' . $i . ':</td><td><input type="text" name="nome' . $i . '" maxlength="50"/></td><td><select name="turma' . $i . '" style="width : 80px;">' . $turmas . '</select></td><td><input type="text" name="email' . $i . '" maxlength="50"/></td></tr>';
							}
						?>
					</table>
					<p><input class="button" type="submit" value="Cadastrar"/><input class="button" type="reset" value="Limpar"/></p>
				</form>
				<br/>
				<?php
			}
			else {
				echo '<br/><p>O cadastro de equipes está desabilitado!<br/>Volte novamente em alguns dias.</p><br/>';
			}
		?>
		</div>
		<div class="footer"><?php echo $footer ?></div>
	</body>
</html>