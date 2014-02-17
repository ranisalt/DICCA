<?php
	require("lib.php");
	if (!verificarLogin()) {
		if (!forcarLogin()) {
			header("Location: index.php");
			exit;
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?> - Desafio</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<link rel="stylesheet" type="text/css" href="desafio.css"/>
		<script type="text/javascript" src="js/desafio.js"></script>
	</head>
	<body>
		<div class="header"><?php echo $header ?></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="equipe.php">Equipe</a></li>
				<li><a id="atual">Desafio</a></li>
				<li><a href="ranking.php">Ranking</a></li>
				<li><a href="contato.php">Contato</a></li>
				<li><a href="logout.php">Sair</a></li>
			</ul>
		</div>
		<div class="box">
			<br/>
			<?php
				
				//executa uma query para verificar se o desafio está ativo
				//executa uma query e transforma em tabela para verificar se está dentro do prazo
				$sql = mysql_query("SELECT TIMESTAMPDIFF(SECOND, now(), inicio) AS tempo1, TIMESTAMPDIFF(SECOND, now(), final) AS tempo2, TIMESTAMPDIFF(SECOND, now(), inicio_final) AS tempo3, TIMESTAMPDIFF(SECOND, now(), final_final) AS tempo4 FROM horario;", $con) or exit('Erro de leitura: ' . mysql_error()); //executa uma query
				$sql = mysql_fetch_array($sql); //transforma em tabela
				//alternativa: "SELECT t.tempo FROM (SELECT TIMESTAMPDIFF(SECOND, now(), final) AS tempo FROM horario) t WHERE tempo >= 1;" e calcular as colunas
				$on = mysql_query("SELECT status FROM controle WHERE sistema = 'desafio' AND status = 1;", $con) or exit('Erro de leitura: ' . mysql_error()); //executa uma query
				
				//calcula quantas colunas existem: se houver 1, significa que o desafio está ativado; se não, está desativado ou desconfigurado
				if (mysql_num_rows($on) == 1 && $sql["tempo1"] <= 0) {
					//compara o valor retornado, que significa quantos segundos há até o prazo, é maior que 0 (significa que ainda não atingiu o prazo;
					if ($sql["tempo2"] > 0) {
						echo '<p style="margin-bottom : -20px;" id="tmp"></p><br/><script type="text/javascript">contagem();</script>' . PHP_EOL;
						
						//executa uma query para verificar se a equipe foi validada
						$sql = mysql_query("SELECT cod_equipe FROM equipes WHERE cod_equipe = " . $_SESSION["cod"] . " AND valida = 1;", $con) or exit('Erro de leitura: ' . mysql_error());
						
						//calcula quantas colunas existem: se houver 1, significa que a equipe está validada; se não, está invalidada ou desconfigurada
						if (mysql_num_rows($sql) == 1) {
						
							//executa uma query para verificar quantas perguntas já foram respondidas pela equipe
							$respostas = mysql_query("SELECT * FROM respostas WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit('Erro de leitura: ' . mysql_error());
							
							//executa uma query para verificar a quantidade de perguntas totais do desafio
							$perguntas = mysql_query("SELECT * FROM perguntas;", $con) or exit('Erro de leitura: ' . mysql_error());
							
							//escreve na página o início do console
							echo '<div id="console">';
							
							//executa uma query para verificar quantas perguntas já foram respondidas pela equipe e escreve na página
							$sql = mysql_query("SELECT * FROM respostas WHERE cod_equipe = " . $_SESSION["cod"] . " AND pulou = 0;", $con) or exit('Erro de leitura: ' . mysql_error());
							echo '<p style="font-size : 100%;">Perguntas respondidas: ' . mysql_num_rows($sql) . '<br/>';
							
							//executa uma query para verificar quantos pontos a equipe somou com suas respostas, desconsiderando as "puladas", e escreve na página
							$sql = mysql_query("SELECT sum(p.pontos) AS soma FROM respostas r, perguntas p WHERE r.cod_pergunta = p.cod_pergunta AND cod_equipe = " . $_SESSION["cod"] . " AND pulou = 0;", $con) or exit('Erro de leitura: ' . mysql_error());	
							$sql = mysql_fetch_array($sql);
							
							//compara o valor retornado, que significa a soma de pontos da equipe: como o mysql retorna nulo se a soma for igual a 0, o php verifica e corrige esta exceção
							echo 'Pontuação da equipe: ' . (($sql["soma"] == 0) ? "0" : $sql["soma"]) . '</p>';
							
							//calcula quantas perguntas existem e quantas foram respondidas: caso haja mais perguntas do que respondidas, ainda há perguntas a serem respondidas; se não, a equipe respondeu ou pulou todas as perguntas
							if (mysql_num_rows($perguntas) > mysql_num_rows($respostas)) {
							
								//executa uma query e transforma em tabela para verificar os dados da pergunta atual
								$sql = mysql_query("SELECT * FROM perguntas WHERE cod_pergunta = " . (mysql_num_rows($respostas) + 1) . ";", $con) or exit("Erro de leitura: " . mysql_error());
								$sql = mysql_fetch_array($sql);
								
								//escreve na página os dados da pergunta atual
								echo '<form name="desafio" onsubmit="return validaResposta();" onreset="return validaPular();">' . PHP_EOL;
								echo '<p><strong>Pergunta ' . $sql["cod_pergunta"] . ' - ' . utf8_decode($sql["tema"]) . '</strong></p>' . PHP_EOL;
								echo '<p><em>' . utf8_decode($sql['pergunta']) . '</em></p>' . PHP_EOL;
								echo '<br/>' . PHP_EOL;
								echo '<table class="center"><tr><td><p><input type="text" name="resposta" onkeyup="contaChar();" maxlength=' . strlen($sql['resposta']). ' style="width : 300px; margin : 0px; padding : 0px;"/></p><td></tr>' . PHP_EOL;
								echo '<tr><td><p>Dica: <strong>' . utf8_decode($sql["dica"]) . '</strong></p></td></tr>' . PHP_EOL;
								echo '<tr><td><p>Esta questão vale ' . $sql["pontos"] . ' pontos.</p></td></tr>' . PHP_EOL;
								echo '<tr><td><p>Caracteres digitados: <span id="chr">0</span> de '  . strlen($sql["resposta"]) .  '</p></td></tr></table>' . PHP_EOL;
								echo '<p><input class="button" type="submit" value="Responder"/><input class="button" type="reset" value="Pular"/></p>' . PHP_EOL;
								echo '</form>';
							}
							else {
								//escreve na página o aviso de que todas as perguntas foram respondidas
								echo '<p style="font-size : 300%;">Parabéns!</p><p style="font-size : 150%;">Sua equipe respondeu todas as perguntas.<br/>Fique ligado na segunda parte do desafio!</p>' . PHP_EOL;
							}
							
							//escreve na página o fim do console
							echo '</div>';
						}
						else {
							//escreve na página o aviso de que a equipe não foi validada
							echo '<p style="font-size : 150%;">Sua equipe ainda não foi validada!<br/><a href="index.php#comoparticipar" class="como" style="color : blue; font-weight : bold;">Como validar?<a></p>' . PHP_EOL;
						}
						mysql_close($con);
					}
					else {
						if ($sql["tempo3"] > 0) {
							echo '<p style="margin-bottom : -20px;" id="tmp">Pausa para o almoço!</p><br/><script type="text/javascript">contagem();</script>' . PHP_EOL;
							echo '<div id="console"></div>';
						}
						else {
							if ($sql["tempo4"] > 0) {
								echo '<p style="margin-bottom : -20px;" id="tmp"></p><br/><script type="text/javascript">contagem();</script>' . PHP_EOL;
								
								//executa uma query para verificar se a equipe foi validada
								$sql = mysql_query("SELECT cod_equipe FROM equipes WHERE cod_equipe = " . $_SESSION["cod"] . " AND valida = 1;", $con) or exit('Erro de leitura: ' . mysql_error());
								
								//calcula quantas colunas existem: se houver 1, significa que a equipe está validada; se não, está invalidada ou desconfigurada
								if (mysql_num_rows($sql) == 1) {
								
									//executa uma query para verificar quantas perguntas já foram respondidas pela equipe
									$r_final = mysql_query("SELECT * FROM respostas_final WHERE cod_equipe = " . $_SESSION["cod"] . ";", $con) or exit('Erro de leitura: ' . mysql_error());
									
									//escreve na página o início do console
									echo '<div id="console">';
									
									//calcula quantas perguntas existem e quantas foram respondidas: caso haja mais perguntas do que respondidas, ainda há perguntas a serem respondidas; se não, a equipe respondeu ou pulou todas as perguntas
									if (mysql_num_rows($r_final) <= 0) {
									
										//executa uma query e transforma em tabela para verificar os dados da pergunta atual
										$sql = mysql_query("SELECT * FROM pergunta_final;", $con) or exit("Erro de leitura: " . mysql_error());
										$sql = mysql_fetch_array($sql);
										
										//escreve na página os dados da pergunta atual
										echo '<form name="desafio" onsubmit="return validaRespostaFinal();">' . PHP_EOL;
										echo '<p><strong>Pergunta final - desafio</strong></p>' . PHP_EOL;
										echo '<p><em>' . utf8_decode($sql['pergunta']) . '</em></p>' . PHP_EOL;
										echo '<br/>' . PHP_EOL;
										echo '<table class="center"><tr><td><p><input type="text" name="resposta" style="width : 300px; margin : 0px; padding : 0px;"/></p><td></tr>' . PHP_EOL;
										echo '<tr><td><p>Esta questão vale infinitos pontos.</p></td></tr></table>' . PHP_EOL;
										echo '<p><input class="button" type="submit" value="Responder"/></p>' . PHP_EOL;
										echo '</form>';
									}
									else {
										$r_final = mysql_fetch_array($r_final);
										echo '<form name="desafio" onsubmit="return validaRaciocinio();">' . PHP_EOL;
										echo '<p><strong>Pergunta final - raciocínio</strong></p>' . PHP_EOL;
										echo '<p><textarea name="raciocinio" class="textarea" style="width: 600px; height : 200px;">' . $r_final["raciocinio"] . '</textarea></p>' . PHP_EOL;
										echo '<br/>' . PHP_EOL;
										echo '<tr><td><p>Esta questão vale infinitos pontos.</p></td></tr></table>' . PHP_EOL;
										echo '<p><input class="button" type="submit" value="Responder"/></p>' . PHP_EOL;
										echo '</form>';
									}
									
									//escreve na página o fim do console
									echo '</div>';
								}
							}
							else {
								echo '<p style="margin-bottom : -20px;" id="tmp">Xiiii! Acabou o tempo :(</p><br/>	' . PHP_EOL;
							}
						}
					}
				}
				else {
					//escreve na página o aviso de que o desafio está desativado
					echo '<p>O desafio está desabilitado!<br/>Volte novamente quando chegar a hora.</p>';
				}
			?>
			<br/>
		</div>
		<div class="footer"><?php echo $footer ?></div>
	</body>
</html>