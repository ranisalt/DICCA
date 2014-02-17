<?php
	require("lib.php");
	if (!verificarLogin()) {
		forcarLogin();
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?></title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<link rel="stylesheet" type="text/css" href="submenu.css"/>
	</head>
	<body>
		<div class="header">
			<p><img src="img/desafioaceito.png" alt="Desafio aceito" style="height : 71px; margin-right : 20px;"/><img src="img/dicca.png" alt="Dicca #5" style="height : 71px;"/><img src="img/cerealguy.png" alt="Cereal guy" style="height : 71px; margin-left : 20px;"/></p>
		</div>
		<div id="menu">
			<ul>
				<li><a id="atual">Home</a></li>
				<?php
					if (!isset($_SESSION["cod"])) {
						echo "<li><a href='cadastro.php'>Cadastro</a></li>" . PHP_EOL;
						echo "<li><a href='login.php'>Login</a></li>" . PHP_EOL;
						echo '<li><a href="sobre.php">Sobre</a></li>' . PHP_EOL;
					}
					else {
						if ($_SESSION["cod"] == 1) {
							echo "<li><a href='admin/index.php'>Admin</a></li>" . PHP_EOL;
						}
						echo "<li><a href='equipe.php'>Equipe</a></li>" . PHP_EOL;
						echo "<li><a href='desafio.php'>Desafio</a></li>" . PHP_EOL;
						echo "<li><a href='ranking.php'>Ranking</a></li>" . PHP_EOL;
					}
				?>
				<li><a href="contato.php">Contato</a></li>
				<?php
					if (isset($_SESSION["cod"])) {
						echo "<li><a href='logout.php'>Sair</a></li>" . PHP_EOL;
					}
				?>
			</ul>
		</div>
		<div class="box">
			<div class="submenu">
				<br/>
				<ul>
					<li><a href="#oquee">O que é o Dicca?</a></li>
					<li><a href="#comoparticipar">Como participar?</a></li>
					<li><a href="#premiacao">Premiação</a></li>
					<li><a href="#cronograma">Cronograma</a></li>
					<li><a href="#regulamento">Regulamento</a></li>
				</ul>
			</div>
			<div class="conteudo">
				<br/>
				<a name="oquee"><p class="titulo">O que é o Dicca?</p>
				<p class="box">O Dicca (Desafio Interno do IFC Campus Camboriu), é um evento interdisciplinar academico gratuito que envolve diversas areas de conhecimento, tais como Turismo, Informatica, Agropecuaria, historia, matematica, entre outros. O desafio encontra-se em sua quinta edição, e é dividido em duas etapas, sendo que a primeira consistem em responder uma caralhada de questoes; e a segunda, a qual é um desafio final em formato surpresa</p>
				<br/>
				<a name="comoparticipar"><p class="titulo">Como participar?</p>
				<p class="box">Para participar do Dicca #5, voce devera montar uma equipe de 3 participantes, sendo que a equipe devera ter dois alunos de cursos diferentes e dois alunos de anos diferentes. Apos ter combinar com os outros dois alunos, acesse a pagina de cadastro e cadastre sua equipe. Logo apos essa segunda etapa, procure pelo aluno Leonardo Rigon na biblioteca, do 12:45 as 13:15 para a validação da sua equipe. Agora é só esperar o dia do desafio começar! Lembramos que é muito importante que todos os participantes leiam o manual do participante e o regulamento.</p>
				<br/>
				<a name="premiacao"><p class="titulo">Premiação</p>
				<p class="box">As equipes que ficarem nas 10 primeiras colocações, receberão como premiação pontos nas médias do terceiro bimentre. Abaixo, encontra-se uma lista dos professores e suas respectivas bonificações:</p>
				<br/>
				<a name="cronograma"><p class="titulo">Cronograma</p>
				<p class="box">Nada</p>
				<br/>
				<a name="regulamento"><p class="titulo">Regulamento</p>
				<p class="box">Nada</p>
				<br/>
			</div>
		</div>
		<div class="footer">
			<table>
				<tr>
					<td><a href="http://facebook.com/dicca5" target="_blank"><img src="img/facebook.png"/></a></td>
					<td><a href="http://facebook.com/dicca5" target="_blank" style="padding-right : 20px;">Curta no Facebook!</a></td>
					<td><a href="http://twitter.com/dicca5" target="_blank" style="padding-left : 20px;"><img src="img/twitter.png"/></a></td>
					<td><a href="http://twitter.com/dicca5" target="_blank">Siga no Twitter!</a></td>
				</tr>
			</table>
		</div>
	</body>
</html>