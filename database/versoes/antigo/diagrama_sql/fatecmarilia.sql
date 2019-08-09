-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: mysql02-farm53.uni5.net
-- Tempo de Geração: Abr 26, 2018 as 02:50 PM
-- Versão do Servidor: 5.5.43
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `fatecmarilia01`
--
CREATE DATABASE `fatecmarilia01` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `fatecmarilia01`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `academicos`
--

CREATE TABLE IF NOT EXISTS `academicos` (
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `titulacao` char(1) NOT NULL COMMENT 'D: Doutor; M: Mestre; E: Especialista; G: Graduado;',
  `urlLattes` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`funcionarios_funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `academicos_disciplinas`
--

CREATE TABLE IF NOT EXISTS `academicos_disciplinas` (
  `academicos_funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `disciplinas_codigo` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`academicos_funcionarios_funcionariosLogin_cpf`,`disciplinas_codigo`),
  KEY `disciplinas_codigo` (`disciplinas_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `academicos_niveisdeacesso`
--

CREATE TABLE IF NOT EXISTS `academicos_niveisdeacesso` (
  `niveisdeacesso_codigo` int(11) NOT NULL,
  `funcionarioLogin_cpf` char(15) NOT NULL,
  PRIMARY KEY (`niveisdeacesso_codigo`),
  KEY `niveisdeacesso_codigo` (`niveisdeacesso_codigo`),
  KEY `funcionarioLogin_cpf` (`funcionarioLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrativos`
--

CREATE TABLE IF NOT EXISTS `administrativos` (
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `formacao` text,
  PRIMARY KEY (`funcionarios_funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrativos_cargos`
--

CREATE TABLE IF NOT EXISTS `administrativos_cargos` (
  `administrativos_funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `cargos_codigo` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`administrativos_funcionarios_funcionariosLogin_cpf`,`cargos_codigo`),
  KEY `cargos_codigo` (`cargos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentosaula`
--

CREATE TABLE IF NOT EXISTS `agendamentosaula` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `termo` int(11) NOT NULL,
  `turno` int(11) NOT NULL,
  `aula1` tinyint(1) NOT NULL,
  `aula2` tinyint(1) NOT NULL,
  `aula3` tinyint(1) NOT NULL,
  `aula4` tinyint(1) NOT NULL,
  `aula5` tinyint(1) NOT NULL,
  `comentarios` varchar(200) DEFAULT NULL,
  `agendas_codigo` int(11) NOT NULL,
  `funcionarios_funcionarioslogin_cpf` char(15) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `agendas_codigo` (`agendas_codigo`),
  KEY `funcionarios_funcionarioslogin_cpf` (`funcionarios_funcionarioslogin_cpf`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentoslivre`
--

CREATE TABLE IF NOT EXISTS `agendamentoslivre` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `horarioInicial` time NOT NULL,
  `horarioFinal` time NOT NULL,
  `comentarios` varchar(200) DEFAULT NULL,
  `agendas_codigo` int(11) NOT NULL,
  `funcionarios_funcionarioslogin_cpf` char(15) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `agendas_codigo` (`agendas_codigo`),
  KEY `funcionarios_funcionarioslogin_cpf` (`funcionarios_funcionarioslogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendas`
--

CREATE TABLE IF NOT EXISTS `agendas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `tipoDeHorario` char(1) NOT NULL COMMENT 'L: Horário Livre; A: Horário de Aula;',
  `diasDeAntecedencia` int(11) NOT NULL,
  `departamentos_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `departamentos_codigo` (`departamentos_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE IF NOT EXISTS `alunos` (
  `alunosLogin_cpf` char(15) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `nomeAbreviado` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `dataNascimento` date NOT NULL,
  `foto` varchar(60) NOT NULL,
  `estadoCivil` char(1) NOT NULL COMMENT 'S: Solteiro(a); C: Casado(a); D: Divorciado(a); V: Viúvo(a);',
  `endereco` varchar(100) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `celular` varchar(14) NOT NULL,
  `telefoneRecado` varchar(14) NOT NULL,
  `nomeRecado` varchar(50) NOT NULL,
  PRIMARY KEY (`alunosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos_cursos`
--

CREATE TABLE IF NOT EXISTS `alunos_cursos` (
  `alunos_alunosLogin_cpf` char(15) NOT NULL,
  `cursos_codigo` int(11) NOT NULL,
  `ra` varchar(13) NOT NULL,
  PRIMARY KEY (`alunos_alunosLogin_cpf`,`cursos_codigo`),
  KEY `cursos_codigo` (`cursos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunoslogin`
--

CREATE TABLE IF NOT EXISTS `alunoslogin` (
  `cpf` char(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(128) NOT NULL,
  `situacao` char(1) NOT NULL COMMENT 'A: Ativo; D: Desativo;',
  `ultimoAcesso` datetime DEFAULT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunoslogin_solicitacao`
--

CREATE TABLE IF NOT EXISTS `alunoslogin_solicitacao` (
  `cpf` varchar(15) NOT NULL,
  `ra` varchar(13) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `data` date NOT NULL,
  `codigoDeAtivacao` char(8) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY (`cpf`),
  KEY `instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargos`
--

CREATE TABLE IF NOT EXISTS `cargos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `departamentos_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `departamentos_codigo` (`departamentos_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cargos_niveisdeacesso`
--

CREATE TABLE IF NOT EXISTS `cargos_niveisdeacesso` (
  `cargos_codigo` int(11) NOT NULL,
  `niveisdeacesso_codigo` int(11) NOT NULL,
  `funcionarioLogin_cpf` char(15) NOT NULL,
  PRIMARY KEY (`cargos_codigo`,`niveisdeacesso_codigo`),
  KEY `niveisdeacesso_codigo` (`niveisdeacesso_codigo`),
  KEY `funcionarioLogin_cpf` (`funcionarioLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) NOT NULL COMMENT '1: Ensino Presencial; 2: Ensino a Distância',
  `nome` varchar(50) NOT NULL,
  `nomeCompleto` varchar(100) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `perfilProfissiografico` text NOT NULL,
  `estruturaCurricular` text NOT NULL,
  `duracao` varchar(50) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  `coordenador` varchar(100) NOT NULL,
  `emailCoordenador` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `i_instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cursospos`
--

CREATE TABLE IF NOT EXISTS `cursospos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` int(11) NOT NULL COMMENT '1: Lato Sensu; 2: Stricto Sensu;',
  `nome` varchar(50) NOT NULL,
  `nomeCompleto` varchar(100) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `objetivo` text NOT NULL,
  `publicoAlvo` text NOT NULL,
  `quadroDeDisciplinas` text NOT NULL,
  `duracao` varchar(50) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `i_instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `mural` tinyint(1) NOT NULL,
  `oculto` tinyint(1) NOT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `i_instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destaques`
--

CREATE TABLE IF NOT EXISTS `destaques` (
  `codigo` char(13) NOT NULL,
  `data` datetime NOT NULL,
  `prioridade` int(11) NOT NULL,
  `titulo` varchar(70) DEFAULT NULL,
  `resumo` varchar(160) DEFAULT NULL,
  `imagem` varchar(100) NOT NULL,
  `posicaoTitulo` char(2) DEFAULT NULL,
  `linkUrl` varchar(150) DEFAULT NULL,
  `linkTarget` tinyint(1) DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'A: Ativado; D: Desativado; P: Pendente;',
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `dataAlteracao` datetime DEFAULT NULL,
  `cpfAlteracao` char(15) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `titulo` (`titulo`),
  KEY `funcionarios_funcionariosLogin_cpf` (`funcionarios_funcionariosLogin_cpf`),
  KEY `idx_1` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplinas`
--

CREATE TABLE IF NOT EXISTS `disciplinas` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `cargaHoraria` int(11) NOT NULL,
  `cursos_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `i_cursos_codigo` (`cursos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplinaspos`
--

CREATE TABLE IF NOT EXISTS `disciplinaspos` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `cargaHoraria` int(11) NOT NULL,
  `cursospos_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `i_cursos_codigo` (`cursospos_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_empresa` varchar(50) DEFAULT NULL,
  `email_contato` varchar(90) DEFAULT NULL,
  `responsavel_contato` varchar(50) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `observacao` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estagios`
--

CREATE TABLE IF NOT EXISTS `estagios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` longtext,
  `email_responsavel` varchar(90) DEFAULT NULL,
  `fone_contato` varchar(15) DEFAULT NULL,
  `nome_responsavel` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estagios_vagas`
--

CREATE TABLE IF NOT EXISTS `estagios_vagas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` longtext,
  `conteudo` longtext,
  `data_cadastro` datetime DEFAULT NULL,
  `codigo_vaga` varchar(10) DEFAULT NULL,
  `email_contato` varchar(90) DEFAULT NULL,
  `mostra_email_contato` char(1) DEFAULT NULL,
  `data_expiracao` date DEFAULT NULL,
  `id_empresa` int(11) NOT NULL,
  `funcionariosLogin_cpf` char(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_funcionariosLogin_cpf` (`funcionariosLogin_cpf`),
  KEY `fk_id_empresa` (`id_empresa`),
  KEY `idx_1` (`data_expiracao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE IF NOT EXISTS `funcionarios` (
  `funcionariosLogin_cpf` char(15) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `nomeAbreviado` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `dataNascimento` date NOT NULL,
  `foto` varchar(60) NOT NULL,
  PRIMARY KEY (`funcionariosLogin_cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarioslogin`
--

CREATE TABLE IF NOT EXISTS `funcionarioslogin` (
  `cpf` char(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(128) NOT NULL,
  `situacao` char(1) NOT NULL COMMENT 'A: Ativo; D: Desativo;',
  `ultimoAcesso` datetime DEFAULT NULL,
  `instituicao_codigo` int(11) NOT NULL,
  PRIMARY KEY (`cpf`),
  UNIQUE KEY `email` (`email`),
  KEY `instituicao_codigo` (`instituicao_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `instituicao`
--

CREATE TABLE IF NOT EXISTS `instituicao` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `nomeFantasia` varchar(100) NOT NULL,
  `imagem` varchar(60) NOT NULL,
  `descricao` text NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `complemento` varchar(50) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` char(2) NOT NULL,
  `telefone` varchar(14) NOT NULL,
  `fax` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `emailSuporte` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `murais`
--

CREATE TABLE IF NOT EXISTS `murais` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(70) NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `arquivo` varchar(100) NOT NULL,
  `linkUrl` varchar(150) NOT NULL,
  `departamento_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `departamento_codigo` (`departamento_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `niveisdeacesso`
--

CREATE TABLE IF NOT EXISTS `niveisdeacesso` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(100) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticias`
--

CREATE TABLE IF NOT EXISTS `noticias` (
  `codigo` char(13) NOT NULL,
  `data` datetime NOT NULL,
  `prioridade` int(11) NOT NULL,
  `titulo` varchar(70) NOT NULL,
  `urlTitulo` varchar(70) NOT NULL,
  `resumo` varchar(160) NOT NULL,
  `conteudo` text NOT NULL,
  `imagem` varchar(100) NOT NULL,
  `linkTitulo` varchar(100) DEFAULT NULL,
  `linkUrl` varchar(150) DEFAULT NULL,
  `linkTarget` tinyint(1) DEFAULT NULL,
  `status` char(1) NOT NULL COMMENT 'A: Ativado; D: Desativado; P: Pendente;',
  `funcionarios_funcionariosLogin_cpf` char(15) NOT NULL,
  `dataAlteracao` datetime DEFAULT NULL,
  `cpfAlteracao` char(15) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `titulo` (`titulo`,`urlTitulo`,`funcionarios_funcionariosLogin_cpf`),
  KEY `funcionarios_funcionariosLogin_cpf` (`funcionarios_funcionariosLogin_cpf`),
  KEY `idx_1` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estrutura da tabela `revista`
--

CREATE TABLE IF NOT EXISTS `revista` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `equipeeditorial` text NOT NULL,
  `comitecientifico` text NOT NULL,
  `equipediagramacaowebdesigner` text NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sisweb_usuario`
--

CREATE TABLE IF NOT EXISTS `sisweb_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `academicos`
--
ALTER TABLE `academicos`
  ADD CONSTRAINT `academicos_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `academicos_disciplinas`
--
ALTER TABLE `academicos_disciplinas`
  ADD CONSTRAINT `academicos_disciplinas_ibfk_1` FOREIGN KEY (`academicos_funcionarios_funcionariosLogin_cpf`) REFERENCES `academicos` (`funcionarios_funcionariosLogin_cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `academicos_disciplinas_ibfk_2` FOREIGN KEY (`disciplinas_codigo`) REFERENCES `disciplinas` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `academicos_niveisdeacesso`
--
ALTER TABLE `academicos_niveisdeacesso`
  ADD CONSTRAINT `academicos_niveisdeacesso_ibfk_1` FOREIGN KEY (`funcionarioLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `academicos_niveisdeacesso_ibfk_3` FOREIGN KEY (`niveisdeacesso_codigo`) REFERENCES `niveisdeacesso` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `administrativos_cargos`
--
ALTER TABLE `administrativos_cargos`
  ADD CONSTRAINT `administrativos_cargos_ibfk_1` FOREIGN KEY (`administrativos_funcionarios_funcionariosLogin_cpf`) REFERENCES `administrativos` (`funcionarios_funcionariosLogin_cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `administrativos_cargos_ibfk_2` FOREIGN KEY (`cargos_codigo`) REFERENCES `cargos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `agendamentosaula`
--
ALTER TABLE `agendamentosaula`
  ADD CONSTRAINT `agendamentosaula_ibfk_2` FOREIGN KEY (`agendas_codigo`) REFERENCES `agendas` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `agendamentosaula_ibfk_3` FOREIGN KEY (`funcionarios_funcionarioslogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `agendamentoslivre`
--
ALTER TABLE `agendamentoslivre`
  ADD CONSTRAINT `agendamentoslivre_ibfk_1` FOREIGN KEY (`agendas_codigo`) REFERENCES `agendas` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `agendamentoslivre_ibfk_2` FOREIGN KEY (`funcionarios_funcionarioslogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `agendas`
--
ALTER TABLE `agendas`
  ADD CONSTRAINT `agendas_ibfk_1` FOREIGN KEY (`departamentos_codigo`) REFERENCES `departamentos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `alunos_ibfk_2` FOREIGN KEY (`alunosLogin_cpf`) REFERENCES `alunoslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `alunos_cursos`
--
ALTER TABLE `alunos_cursos`
  ADD CONSTRAINT `alunos_cursos_ibfk_1` FOREIGN KEY (`cursos_codigo`) REFERENCES `cursos` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `alunos_cursos_ibfk_2` FOREIGN KEY (`alunos_alunosLogin_cpf`) REFERENCES `alunos` (`alunosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `alunoslogin`
--
ALTER TABLE `alunoslogin`
  ADD CONSTRAINT `alunoslogin_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `alunoslogin_solicitacao`
--
ALTER TABLE `alunoslogin_solicitacao`
  ADD CONSTRAINT `alunoslogin_solicitacao_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `cargos_ibfk_1` FOREIGN KEY (`departamentos_codigo`) REFERENCES `departamentos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `cargos_niveisdeacesso`
--
ALTER TABLE `cargos_niveisdeacesso`
  ADD CONSTRAINT `cargos_niveisdeacesso_ibfk_2` FOREIGN KEY (`niveisdeacesso_codigo`) REFERENCES `niveisdeacesso` (`codigo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cargos_niveisdeacesso_ibfk_3` FOREIGN KEY (`funcionarioLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cargos_niveisdeacesso_ibfk_4` FOREIGN KEY (`cargos_codigo`) REFERENCES `cargos` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para a tabela `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `cursospos`
--
ALTER TABLE `cursospos`
  ADD CONSTRAINT `cursospos_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `departamentos`
--
ALTER TABLE `departamentos`
  ADD CONSTRAINT `departamentos_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `destaques`
--
ALTER TABLE `destaques`
  ADD CONSTRAINT `destaques_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `disciplinas`
--
ALTER TABLE `disciplinas`
  ADD CONSTRAINT `disciplinas_ibfk_1` FOREIGN KEY (`cursos_codigo`) REFERENCES `cursos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `disciplinaspos`
--
ALTER TABLE `disciplinaspos`
  ADD CONSTRAINT `disciplinaspos_ibfk_1` FOREIGN KEY (`cursospos_codigo`) REFERENCES `cursospos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `estagios_vagas`
--
ALTER TABLE `estagios_vagas`
  ADD CONSTRAINT `fk_funcionariosLogin_cpf` FOREIGN KEY (`funcionariosLogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`),
  ADD CONSTRAINT `fk_id_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`);

--
-- Restrições para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `funcionarios_ibfk_1` FOREIGN KEY (`funcionariosLogin_cpf`) REFERENCES `funcionarioslogin` (`cpf`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `funcionarioslogin`
--
ALTER TABLE `funcionarioslogin`
  ADD CONSTRAINT `funcionarioslogin_ibfk_1` FOREIGN KEY (`instituicao_codigo`) REFERENCES `instituicao` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `murais`
--
ALTER TABLE `murais`
  ADD CONSTRAINT `murais_ibfk_1` FOREIGN KEY (`departamento_codigo`) REFERENCES `departamentos` (`codigo`) ON UPDATE CASCADE;

--
-- Restrições para a tabela `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`funcionarios_funcionariosLogin_cpf`) REFERENCES `funcionarios` (`funcionariosLogin_cpf`) ON UPDATE CASCADE;
