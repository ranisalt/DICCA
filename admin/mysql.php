<?php
	$user = "root";
	$pass = "v1t2n3c4";
	$db = "dicca";
	
	//cria a conex�o e seleciona o banco de dados
	$con = mysql_connect("localhost", $user, $pass) or die (mysql_error()); //cria a conex�o
	mysql_select_db($db, $con); //seleciona o banco de dados
?>