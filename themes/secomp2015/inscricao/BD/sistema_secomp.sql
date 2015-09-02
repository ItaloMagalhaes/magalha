-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Ago-2015 às 22:23
-- Versão do servidor: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sistema_secomp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_global`
--

CREATE TABLE IF NOT EXISTS `admin_global` (
`id_coordenador` int(10) unsigned NOT NULL,
  `nome` varchar(70) CHARACTER SET utf8 NOT NULL,
  `cpf` varchar(15) CHARACTER SET utf8 NOT NULL,
  `fid_usuario` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_pagamento`
--

CREATE TABLE IF NOT EXISTS `admin_pagamento` (
`id_coordenador` int(10) unsigned NOT NULL,
  `nome` varchar(70) CHARACTER SET utf8 NOT NULL,
  `cpf` varchar(15) CHARACTER SET utf8 NOT NULL,
  `fid_usuario` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE IF NOT EXISTS `atividades` (
`id_atividade` int(10) NOT NULL,
  `nome` text NOT NULL,
  `n_vagas` int(10) NOT NULL,
  `nome_preponente` text NOT NULL,
  `tipo` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `preco` float NOT NULL,
  `local` text NOT NULL,
  `data_inicio` date NOT NULL,
  `data_termino` date NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_termino` time NOT NULL,
  `carga_horaria` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `config_sistema`
--

CREATE TABLE IF NOT EXISTS `config_sistema` (
  `status_monitor` tinyint(1) NOT NULL,
  `status_aluno` tinyint(1) NOT NULL,
  `data_vencimento` date NOT NULL,
  `ultima_data_fila` date NOT NULL,
  `valor_padrao` double NOT NULL,
  `acrescimo` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `config_sistema`
--

INSERT INTO `config_sistema` (`status_monitor`, `status_aluno`, `data_vencimento`, `ultima_data_fila`, `valor_padrao`, `acrescimo`) VALUES
(1, 1, '2015-07-30', '2015-08-06', 25, 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `congressista`
--

CREATE TABLE IF NOT EXISTS `congressista` (
`id_congressista` int(10) unsigned NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cpf` varchar(15) CHARACTER SET utf8 NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `data_nascimento` date NOT NULL,
  `data_cadastro` date NOT NULL,
  `sexo` varchar(15) CHARACTER SET utf8 NOT NULL,
  `escolaridade` varchar(30) CHARACTER SET utf8 NOT NULL,
  `telefone` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `rua` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `bairro` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `numero` int(10) unsigned DEFAULT NULL,
  `complemento` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cidade` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `estado` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `cep` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `fid_usuario` int(10) unsigned DEFAULT NULL,
  `material` int(10) unsigned NOT NULL,
  `pagamento` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamento`
--

CREATE TABLE IF NOT EXISTS `pagamento` (
`id_pagamento` int(10) unsigned NOT NULL,
  `preco` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  `fid_participante_atividade` int(10) unsigned NOT NULL,
  `fid_congressista` int(10) unsigned NOT NULL,
  `fid_atividade` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `participante_atividade`
--

CREATE TABLE IF NOT EXISTS `participante_atividade` (
`id_relacao_inscrito_atividade` int(10) unsigned NOT NULL,
  `fid_congressista` int(10) unsigned NOT NULL,
  `fid_atividade` int(11) NOT NULL,
  `presenca` tinyint(1) NOT NULL,
  `fila_de_espera` tinyint(1) NOT NULL,
  `data_cadastro` date NOT NULL,
  `data_chamada_fila` date NOT NULL,
  `email_enviado` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id_usuario` int(10) unsigned NOT NULL,
  `login` varchar(70) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(150) CHARACTER SET utf8 NOT NULL,
  `tipo` varchar(30) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=363 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_global`
--
ALTER TABLE `admin_global`
 ADD PRIMARY KEY (`id_coordenador`), ADD KEY `fid_usuario` (`fid_usuario`);

--
-- Indexes for table `admin_pagamento`
--
ALTER TABLE `admin_pagamento`
 ADD PRIMARY KEY (`id_coordenador`), ADD KEY `fid_usuario` (`fid_usuario`);

--
-- Indexes for table `atividades`
--
ALTER TABLE `atividades`
 ADD PRIMARY KEY (`id_atividade`);

--
-- Indexes for table `congressista`
--
ALTER TABLE `congressista`
 ADD PRIMARY KEY (`id_congressista`), ADD KEY `fid_usuario` (`fid_usuario`);

--
-- Indexes for table `pagamento`
--
ALTER TABLE `pagamento`
 ADD PRIMARY KEY (`id_pagamento`), ADD KEY `fid_aluno` (`fid_congressista`), ADD KEY `fid_participante_oficina` (`fid_participante_atividade`), ADD KEY `fid_atividade` (`fid_atividade`);

--
-- Indexes for table `participante_atividade`
--
ALTER TABLE `participante_atividade`
 ADD PRIMARY KEY (`id_relacao_inscrito_atividade`), ADD KEY `fid_aluno` (`fid_congressista`), ADD KEY `fid_atividade` (`fid_atividade`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_global`
--
ALTER TABLE `admin_global`
MODIFY `id_coordenador` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_pagamento`
--
ALTER TABLE `admin_pagamento`
MODIFY `id_coordenador` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
MODIFY `id_atividade` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `congressista`
--
ALTER TABLE `congressista`
MODIFY `id_congressista` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=287;
--
-- AUTO_INCREMENT for table `pagamento`
--
ALTER TABLE `pagamento`
MODIFY `id_pagamento` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `participante_atividade`
--
ALTER TABLE `participante_atividade`
MODIFY `id_relacao_inscrito_atividade` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=363;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `admin_pagamento`
--
ALTER TABLE `admin_pagamento`
ADD CONSTRAINT `admin_pagamento_ibfk_1` FOREIGN KEY (`fid_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `congressista`
--
ALTER TABLE `congressista`
ADD CONSTRAINT `congressista_ibfk_1` FOREIGN KEY (`fid_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pagamento`
--
ALTER TABLE `pagamento`
ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`fid_congressista`) REFERENCES `congressista` (`id_congressista`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pagamento_ibfk_2` FOREIGN KEY (`fid_atividade`) REFERENCES `atividades` (`id_atividade`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `participante_atividade`
--
ALTER TABLE `participante_atividade`
ADD CONSTRAINT `participante_atividade_ibfk_1` FOREIGN KEY (`fid_congressista`) REFERENCES `congressista` (`id_congressista`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `participante_atividade_ibfk_2` FOREIGN KEY (`fid_atividade`) REFERENCES `atividades` (`id_atividade`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
