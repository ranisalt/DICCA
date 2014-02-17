<?php
	require("../lib.php");
	
	//executa uma query para verificar a diferença entre o horário atual e o horário final do desafio
	$sql = mysql_query("SELECT TIMESTAMPDIFF(SECOND, now(), final) AS tempo1, TIMESTAMPDIFF(SECOND, now(), inicio_final) AS tempo2, TIMESTAMPDIFF(SECOND, now(), final_final) AS tempo3 FROM horario;", $con);
	$sql = mysql_fetch_array($sql);
	
	function segundos_string($segundos) {
		//cria as variáveis para horas e minutos - segundos não precisam ser criados
		$horas = 0; $minutos = 0;
		
		//3600 segundos equivalem a 1 hora, então enquanto houver mais de 3600 segundos podemos incrementar em 1 hora
		while ($segundos >= 3600) { $segundos -= 3600; $horas++; }
		
		//60 segundos equivalem a 1 minuto, então enquanto houver mais de 60 segundos podemos incrementar em 1 minuto
		while ($segundos >= 60) { $segundos -= 60; $minutos++; }
		
		//trata o resultado para que não seja exibido "9:7:4" no lugar de "09:07:04" usando o atalho if e escreve na página o tempo
		//return ('00:00:00');
		return ((($horas >= 10) ? $horas : "0" . $horas) . ":" . (($minutos >= 10) ? $minutos : "0" . $minutos) . ":" . (($segundos >= 10) ? $segundos : "0" . $segundos));
	}
	
	//transforma o resultado em um valor em segundos UNIX
	$s = date("U", $sql["tempo1"]);
	
	if ($s > 0) {
		exit('A' . segundos_string($s));
	}
	else {		
		//transforma o resultado em um valor em segundos UNIX
		$s = date("U", $sql["tempo2"]);
		if ($s > 0) {
			exit('B' . segundos_string($s));
		}
		else {
			//transforma o resultado em um valor em segundos UNIX
			$s = date("U", $sql["tempo3"]);
			if ($s > 0) {
				exit('C' . segundos_string($s));
			}
		}
	}
?>