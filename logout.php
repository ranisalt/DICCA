<?php
	require("lib.php");
	$sql = mysql_query("DELETE FROM session WHERE id = '" . $_SESSION["cookie"] . "';", $con);
	unset($_SESSION["cod"]); //apaga o código da sessão
	unset($_SESSION["cookie"]); //apaga o cookie da sessão
	unset($_COOKIE["session"]); //apaga o código do cookie
	setcookie("session", "", time()-30*60*60*24);
	session_destroy(); //destrói os dados da seção
	header("Location: index.php");
	exit;
?>