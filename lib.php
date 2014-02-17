<?php
	//informações do usuário limitado (SELECT, INSERT, UPDATE, DELETE) do mysql
	$user = "dicca";
	$pass = "v1t2n3c4";
	$db = "dicca";
	
	//informações do evento
	$evento = "DICCA #5";
	$header = '<p><img src="img/desafioaceito.png" alt="Desafio aceito" style="height : 71px; margin-right : 20px;"/><img src="img/dicca.png" alt="Dicca #5" style="height : 71px;"/><img src="img/cerealguy.png" alt="Cereal guy" style="height : 71px; margin-left : 20px;"/></p>';
	$footer = '<table><tr><td><a href="http://facebook.com/dicca5" target="_blank"><img src="img/facebook.png"/></a></td><td><a href="http://facebook.com/dicca5" target="_blank" style="padding-right : 20px;">Curta no Facebook!</a></td><td><a href="http://twitter.com/dicca5" target="_blank" style="padding-left : 20px;"><img src="img/twitter.png"/></a></td><td><a href="http://twitter.com/dicca5" target="_blank">Siga no Twitter!</a></td></tr></table>';
	
	//inicia a sessão
	session_start();
	
	//cria a conexão e seleciona o banco de dados
	$con = mysql_connect("localhost", $user, $pass) or die (mysql_error()); //cria a conexão
	mysql_select_db($db, $con); //seleciona o banco de dados
	
	//verifica se há sessão conectada presente
	function verificarLogin() {
		return isset($_SESSION["cod"]);
	}
	
	//força o login se houver cookies com login e senha
	function forcarLogin() {
		if (isset($_COOKIE["session"])) {
			global $con;
			mysql_query("DELETE FROM session WHERE TIMESTAMPDIFF(SECOND, NOW(), expira) <= 0;", $con);
			$sql = mysql_query("SELECT e.cod_equipe, s.id FROM equipes e, session s WHERE s.login = e.login AND s.senha = e.senha AND s.id = '" . $_COOKIE["session"] . "';", $con);
			if (mysql_num_rows($sql) == 1) {
				$sql = mysql_fetch_array($sql);
				$_SESSION["cod"] = $sql["cod_equipe"];
				$id = (hash("md5", $_SESSION["cod"] . date("U", time())));
				mysql_query("UPDATE session SET id = '" . $id . "', expira = (DATE_ADD(NOW(), INTERVAL 30 DAY)) WHERE id = '" . $sql["id"] . "';", $con);
				setcookie("session", $id, time()+30*60*60*24, "/");
				$_SESSION["cookie"] = $id;
				return true;
			}
		}
		return false;
	}
	
	/*function equipeLogada() {
		$sql = mysql_query("SELECT cod_equipe FROM equipes WHERE login = (SELECT login FROM session WHERE id = '" . $_SESSION["cod"] . "') AND senha = (SELECT senha FROM session WHERE id = '" . $_COOKIE["session"] . "');", $con);
		$sql = mysql_fetch_array($sql);
		return $sql["cod_equipe"];
	}*/
	
	//força o logout
	function forcarLogout() {
		global $con;
		$sql = mysql_query("DELETE FROM session WHERE id = '" . $_COOKIE["session"] . "';", $con);
		unset($_SESSION["cod"]); //apaga o código da sessão (desloga)
		unset($_SESSION["cookie"]); //apaga o código da sessão (desloga)
		unset($_COOKIE["session"]); //apaga o código da sessão (desloga)
		setcookie("id", "", time()-30*60*60*24);
		session_destroy(); //destrói os dados da seção
		header("Location: index.php");
		return true;
	}
?>