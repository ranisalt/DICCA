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
		<title><?php echo $evento ?> - Login</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<style type="text/css">
			input { margin : 5px; width : 200px; }
		</style>
		<!--<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>-->
		<script type="text/javascript" src="js/login.js"></script>
	</head>
	<body>
		<div class="header"><?php echo $header ?></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="cadastro.php">Cadastro</a></li>
				<li><a id="atual">Login</a></li>
				<li><a href="sobre.php">Sobre</a></li>
				<li><a href="contato.php">Contato</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<div id="console">
				<form name="logar" onsubmit="return validaLogin();">
					<table class="center">
						<tr><td>Login da equipe:</td><td><input type="text" id="login" maxlength="16"/></td></tr>
						<tr><td>Senha de acesso:</td><td><input type="password" id="senha" maxlength="16"/></td></tr>
						<tr><td colspan=2 style="text-align : center;"><input type="checkbox" name="perm" style="width : auto;" checked/>Permanecer logado</td></tr>
					</table>
					<p><input class="button" type="submit" value="Logar"/></p>
				</form>
			</div>
			<br/>
		</div>
		<div class="footer"><?php echo $footer ?></div>
	</body>
</html>