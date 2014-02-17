<?php
	if (isset($_GET["msg"]) && isset($_GET["cod"])) {
		require("../mysql.php");
		$con = mysql_connect("localhost", $user, $pass);
		mysql_select_db($db, $con);
		
		if ($_GET["msg"] == "pessoas") {
			echo '<br/>';
			$result = mysql_query("SELECT nome, email, mensagem FROM mensagens_pessoas WHERE cod_msg = " . $_GET["cod"] . ";");
			$x = mysql_fetch_array($result);
			echo '<table><tr><td>Nome:</td><td>' . $x["nome"] . '</td></tr><tr><td>Email:</td><td>' . $x["email"] . '</td></tr><tr><td>Mensagem:</td><td>' . $x["mensagem"] . '</td></tr></table></div>';
			echo '<textarea name="resposta"></textarea></br>';
			echo '<input type="submit" value="Responder"/>';
		}
	}
?>