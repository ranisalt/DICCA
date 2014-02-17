<?php
	require("../lib.php");
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		unset($_SESSION["login"]);
		unset($_SESSION["senha"]);
		exit;
	}
	
	function alterar_senha($erro) {
		echo '<form name="alterar_senha" onsubmit="return alterarSenha();">
				<table style="margin-left : auto; margin-right : auto; text-align : center;">
					<caption>Alterar senha:</caption>
					<tr><td>Senha antiga:</td><td><input type="password" name="antiga"/></td></tr>
					<tr><td>Nova senha:</td><td><input type="password" name="nova"/></td></tr>
					<tr><td>Confirmar senha:</td><td><input type="password" name="novac"/></td></tr>
				</table>
				<p id="erro" style="color : red;">' . $erro . '</p>
				<p><input class="button" type="submit" value="Alterar"/></p>
			</form>';
	}
	
	if ($_POST["nova"] == $_POST["novac"]) {
		$sql = mysql_query("SELECT senha FROM equipes WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit('<p style="color : red;">Não foi possível alterar a senha.</p>');
		$sql = mysql_fetch_array($sql);
		if ($sql["senha"] == hash("md5", mysql_real_escape_string($_POST["antiga"]))) {
			mysql_query("UPDATE equipes SET senha = '" . hash("md5", mysql_real_escape_string($_POST["nova"])) . "' WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit('<p style="color : red;">2Não foi possível alterar a senha.</p>' . mysql_error());
			exit('<p style="color : green;">Senha alterada com sucesso!</p>');
		}
		else {
			mysql_close($con);
			exit(alterar_senha("Senha antiga incorreta!"));
		}
	}
	exit(alterar_senha("As senhas digitadas não coincidem!"));
?>