<?php
	include("../lib.php");
	
	//executa uma query para verificar o código da equipe com o login e senha enviados
	$sql = mysql_query("SELECT cod_equipe FROM equipes WHERE login = '" . mysql_real_escape_string($_POST["login"]) . "' AND senha = '" . hash("md5", mysql_real_escape_string($_POST["senha"])) . "';", $con) or exit("Erro de leitura: " . mysql_error());
	
	//calculas quantas colunas existem: se houver 1, significa que os dados enviados estão corretos
	if (mysql_num_rows($sql) == 1) {
	
		//transforma a query em tabela para verificar o código da equipe e armazenar na seção
		$sql = mysql_fetch_array($sql);
		$_SESSION["cod"] = $sql["cod_equipe"];
		
		//verifica se a box "permanecer logado" está marcada para manter o cookie
		if ($_POST["perm"] == "true") {
			$id = (hash("md5", $_SESSION["cod"] . date("U", time())));
			$_SESSION["cookie"] = $id;
		
			//executa uma query para armazenar no banco de dados o código do cookie, que no caso é o código da equipe criptografado
			mysql_query("INSERT INTO session (id, login, senha, expira) VALUES ('" . $id . "', '" . mysql_real_escape_string($_POST["login"]) . "', '" . hash("md5", mysql_real_escape_string($_POST["senha"])) . "', (DATE_ADD(NOW(), INTERVAL 30 DAY)));", $con) or exit("Erro de inserção: " . mysql_error());
			
			//cria o cookie com o código e duração de 30 dias
			setcookie("session", $id, time()+30*60*60*24, "/");
		}
		
		//fecha a conexão e envia "sucesso" como resultado para que o javascript mude de página
		mysql_close($con); //fecha a conexão
		exit("sucesso"); //envia "sucesso"
	}
	else {
		//escreve na página uma nova página com um aviso de que os dados estão incorretos
		?>
		<form name="logar" onsubmit="return validaLogin();">
			<table class="center">
				<tr><td>Login da equipe:</td><td><input type="text" id="login" maxlength="16"/></td></tr>
				<tr><td>Senha de acesso:</td><td><input type="password" id="senha" maxlength="16"/></td></tr>
				<tr><td colspan=2 style="text-align : center;"><input type="checkbox" name="perm" style="width : auto;" <?php if ($_POST["perm"] == "true") { ?>checked<?php } ?> />Permanecer logado</td></tr>
			</table>
			<p style="color : red;">Login e/ou senha incorretos!</p>
			<p><input class="button" type="submit" value="Logar"/></p>
		</form>
		<?php
		mysql_close($con); //fecha a conexão
	}
	
?>