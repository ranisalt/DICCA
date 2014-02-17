<?php
	require("lib.php");
	if (!verificarLogin()) {
		forcarLogin();
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo $evento ?> - Sobre</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<style type="text/css">			
			caption { font-size : 150%; font-weight : bold; color : black; margin : 0px; } 
			img.sobre { height : 100px; }
			td { text-align : center; }
		</style>
	</head>
	<body>
		<div class="header">
			<p><img src="img/desafioaceito.png" alt="Desafio aceito" style="height : 71px; margin-right : 20px;"/><img src="img/dicca.png" alt="Dicca #5" style="height : 71px;"/><img src="img/cerealguy.png" alt="Cereal guy" style="height : 71px; margin-left : 20px;"/></p>
		</div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="cadastro.php">Cadastro</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a id="atual">Sobre</a></li>
				<li><a href="contato.php">Contato</a></li>
				<?php
					if (isset($_SESSION["cod"])) {
						echo '<li><a href="logout.php">Sair</a></li>' . PHP_EOL;
					}
				?>
			</ul>
		</div>
		<div class="box" style="padding : 20px;">
			<p style="text-align : center; font-size : 200%; font-weight : bold; margin : 0px;">Desafio Interno do Instituto Federal Catarinense</p>
			<br/>
			<table class="center">
				<caption>Desenvolvido por:</caption>
				<tr>
					<td>
						<img class="sobre" src="img/desenvolvedores.jpg" alt="Desenvolvedores"/>
					</td>
					<td>
						<p>
							Leonardo Garibaldi Rigon<br/>
							Ranieri Schroeder Althoff<br/>
						</p>
					</td>
				</tr>
			</table>
			<br/>
			<table class="center">
				<caption>Equipe:</caption>
				<tr>
					<td>
						<p>
							Ana Clara Canto Souza (Agropecuária)<br/>
							Marina Silva (Controle Ambiental)<br/>
							Mateus Cichelero da Silva (Informática)<br/>
							Sofia Knoll (Turismo)
						</p>
					</td>
					<td>
						<img class="sobre" src="img/fodase.jpg" alt="Equipe"/>
					</td>
				</tr>
			</table>
			<br/>
			<table class="center">
				<caption>Professores:</caption>
				<tr>
					<td>
						<img class="sobre" src="img/professor.jpg" alt="Professores"/>
					</td>
					<td>
						<p>
							Adriano (Química)<br/>
							Armando (Matemática)<br/>
							Elena Shizuno (História)<br/>
							Maria Olandina Machado (Geografia)<br/>
							Priscilla Simões (Português)<br/>
							Renata Ogusucu (Biologia)<br/>
							Ricardo (Física)
						</p>
					</td>
				</tr>
			</table>
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