SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP DATABASE IF EXISTS `dicca`;
CREATE DATABASE `dicca` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dicca`;

CREATE TABLE `controle` (
  `sistema` varchar(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `controle` (`sistema`, `status`) VALUES
('desafio', 1),
('contato', 1),
('cadastro', 1);

CREATE TABLE `equipes` (
  `cod_equipe` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome_equipe` varchar(30) NOT NULL,
  `login` varchar(16) NOT NULL,
  `senha` char(32) NOT NULL,
  `valida` tinyint(1) NOT NULL,
  PRIMARY KEY (`cod_equipe`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `nome_equipe` (`nome_equipe`),
  UNIQUE KEY `cod_equipe` (`cod_equipe`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `equipes` (`cod_equipe`, `nome_equipe`, `login`, `senha`, `valida`) VALUES
(1, 'Administração', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'George Simon', 'george', 'e10adc3949ba59abbe56e057f20f883e', 1),
(3, 'Ela Balança, Mas Não Para', 'vemktem', 'cc58172e9b9cd0d9d440c36387a3551d', 1),
(4, 'Dois acentos no O', 'acentos', 'dad0ebf64f2b4ce5e483433fc404d3a1', 0),
(5, 'Á', 'a', '0cc175b9c0f1b6a831c399e269772661', 0),
(6, 'Teste', '1', 'c4ca4238a0b923820dcc509a6f75849b', 1);

CREATE TABLE `horario` (
  `inicio` timestamp NOT NULL DEFAULT '2012-01-01 08:00:00',
  `final` timestamp NOT NULL DEFAULT '2012-12-21 23:12:12',
  `inicio_final` timestamp NOT NULL DEFAULT '2012-12-28 08:00:00',
  `final_final` timestamp NOT NULL DEFAULT '2012-12-30 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `horario` (`inicio`, `final`, `inicio_final`, `final_final`) VALUES
('2012-11-01 10:00:00', '2012-11-21 01:00:00', '2012-11-21 02:50:00', '2012-11-22 00:30:00');

CREATE TABLE `mensagens_equipes` (
  `cod_msg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `horario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cod_equipe` bigint(20) unsigned NOT NULL,
  `mensagem` text NOT NULL,
  `resposta` text NOT NULL,
  PRIMARY KEY (`cod_msg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mensagens_equipes` (`cod_msg`, `horario`, `cod_equipe`, `mensagem`, `resposta`) VALUES
(1, '2012-11-20 00:56:25', 1, 'ÁÁÁÁÁ', NULL),
(2, '2012-11-20 01:05:57', 1, 'á', NULL);

CREATE TABLE `mensagens_pessoas` (
  `cod_msg` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `horario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mensagem` text NOT NULL,
  `respondida` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cod_msg`),
  UNIQUE KEY `cod_msg` (`cod_msg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mensagens_pessoas` (`cod_msg`, `horario`, `nome`, `email`, `mensagem`, `respondida`) VALUES
(1, '2012-11-19 23:49:59', 'Angelo Gamba Prata de Carvalho', 'angelogpc@hotmail.com', 'ME MANDA UMA PIZZA METADE CALABRESA, METADE CALABREZA', 0);

CREATE TABLE `participantes` (
  `cod_equipe` bigint(20) unsigned NOT NULL,
  `nome` varchar(50) NOT NULL,
  `turma` char(4) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `participantes` (`cod_equipe`, `nome`, `turma`, `email`) VALUES
(1, 'Ranieri Schroeder Althoff', 'IA10', 'ranisalt@gmail.com'),
(1, 'Leonardo Garibaldi Rigon', 'IA10', 'leo_rigon@yahoo.com.br'),
(1, 'DICCA 2012', 'IA10', 'dicca2012@gmail.com'),
(2, 'Amado Batista', 'IA10', 'amado@amado.com.br'),
(2, 'Beto Barbosa', 'CA11', 'beto@barbosa.com'),
(2, 'Almir Sater', 'TA10', 'almir@sater.com'),
(3, 'Joana Fernandes', 'IA11', 'jojo1096@hotmail.com'),
(3, 'Solana Llanes', 'TH12', 'solana.llanes@hotmail.com'),
(3, 'Juliano Batista', 'AA10', 'juliano.batista@hotmail.com'),
(4, 'Marina Tété', 'AA10', 'tete@alalala.com'),
(4, 'Didi Mócó', 'IA12', 'didi@ia.com'),
(4, 'Pópó', 'AA10', 'popo@ia.com'),
(5, 'Á', 'AA10', 'a@a.com'),
(5, 'ç', 'IA10', 'c@c.com'),
(5, 'Õ', 'TH12', 'o@o.com'),
(6, 'Leonardo', 'AA10', 'leo@hotmail.com'),
(6, 'Vinicius', 'AA11', 'tes@hotmail.com'),
(6, 'Laura', 'IA12', 'la@hotmail.com');

CREATE TABLE `pergunta_final` (
  `pergunta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pergunta_final` (`pergunta`) VALUES
('Teste de pergunta final.');

CREATE TABLE `perguntas` (
  `cod_pergunta` tinyint(4) NOT NULL,
  `pontos` smallint(5) unsigned NOT NULL,
  `dificuldade` tinyint(3) unsigned NOT NULL,
  `tema` varchar(20) NOT NULL,
  `pergunta` text NOT NULL,
  `resposta` text NOT NULL,
  `dica` text NOT NULL,
  PRIMARY KEY (`cod_pergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `perguntas` (`cod_pergunta`, `pontos`, `dificuldade`, `tema`, `pergunta`, `resposta`, `dica`) VALUES
(1, 1000, 1, 'Política', 'Qual o nome do presidente atual dos EUA?<br/><img src="questoes/arbusto.jpg" alt="Arbusto" height=100 name="imagem" onclick="imgAumenta();"/>', 'Barack Obama', 'Foi recentemente eleito como Prêmio Nobel da Paz.'),
(2, 1500, 2, 'Geografia', 'Qual o país africano que recentemente se dividiu em 2?', 'Sudao', 'É palco de um conflito religioso que tem mais de 2 milhões de refugiados.'),
(3, 500, 0, 'Variadas', 'Qual o nome do cara mais foda do mundo?', 'Ranieri Schroeder Althoff', 'Simplesmente melhor que você.'),
(4, 1000, 2, 'Matemática', 'Um algarismo de seis dígitos seguidos de duas letras forma uma senha. Sabendo que entre as letras uma é vogal e outra uma consoante, e que nenhum dígito se repete, responda: qual o número de possiblidades para este código, sendo o segundo dígito o número três e que havia o número nove em algum deles.', '1587600', ''),
(5, 500, 1, 'Matemática', 'Qual o maior número primo menor que 10.000 (dez mil)?', '9973', ''),
(6, 500, 1, 'Tecnologia', 'A figura abaixo ilustra um comparativo de imagens geradas entre duas tecnologias, sendo que a da esquerda refere-se a uma tecnologia que está iniciando sua entrada no mercado de dispositivos móveis e até mesmo em TVs. Como esta tecnologia é conhecida?\r\n<img src="questoes/baloes.png">', 'AMOLED', 'Sua tecnologia é capaz de desligar pixels mais rapidamente.');

CREATE TABLE `session` (
  `id` char(32) NOT NULL,
  `login` varchar(16) NOT NULL,
  `senha` char(32) NOT NULL,
  `expira` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `session` (`id`, `login`, `senha`, `expira`) VALUES
('252cf2cc5f9975bfe354ca4a0dad55d0', '1', 'c4ca4238a0b923820dcc509a6f75849b', '2012-12-20 23:38:43'),
('dfdc0a0072b06452fb835a2431c54d5e', '1', 'c4ca4238a0b923820dcc509a6f75849b', '2012-12-22 02:47:13'),
('fa1b7ef9f718273629edbd6e9dd2a0e2', '1', 'c4ca4238a0b923820dcc509a6f75849b', '2012-12-20 23:17:36');

CREATE TABLE `turmas` (
  `nome` char(4) NOT NULL,
  `curso` char(1) NOT NULL,
  `ano` year(4) NOT NULL,
  PRIMARY KEY (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `turmas` (`nome`, `curso`, `ano`) VALUES
('AA10', 'A', 2010),
('AA11', 'A', 2011),
('AA12', 'A', 2012),
('AB10', 'A', 2010),
('AB11', 'A', 2011),
('AB12', 'A', 2012),
('CA11', 'C', 2011),
('CA12', 'C', 2012),
('IA10', 'I', 2010),
('IA11', 'I', 2011),
('IA12', 'I', 2012),
('TA10', 'T', 2010),
('TH11', 'T', 2011),
('TH12', 'T', 2012);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
