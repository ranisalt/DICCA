<?php
	require("lib.php");
	$sql = mysql_query("DELETE FROM session WHERE id = '" . $_SESSION["cookie"] . "';", $con);
	unset($_SESSION["cod"]); //apaga o c�digo da sess�o
	unset($_SESSION["cookie"]); //apaga o cookie da sess�o
	unset($_COOKIE["session"]); //apaga o c�digo do cookie
	setcookie("session", "", time()-30*60*60*24);
	session_destroy(); //destr�i os dados da se��o
	header("Location: index.php");
	exit;
?>