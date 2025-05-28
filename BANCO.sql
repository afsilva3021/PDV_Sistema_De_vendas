-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           11.7.1-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para sistpdv
CREATE DATABASE IF NOT EXISTS `sistpdv` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `sistpdv`;

-- Copiando estrutura para tabela sistpdv.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sistpdv.categorias: ~0 rows (aproximadamente)
REPLACE INTO `categorias` (`id`, `nome`) VALUES
	(1, 'Segurança');

-- Copiando estrutura para tabela sistpdv.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(100) NOT NULL,
  `EMAIL` varchar(150) DEFAULT NULL,
  `TELEFONE` varchar(20) DEFAULT NULL,
  `CPF_CNPJ` varchar(18) NOT NULL,
  `ENDERECO` text NOT NULL,
  `CIDADE` varchar(100) NOT NULL,
  `ESTADO` varchar(2) NOT NULL,
  `DATA_CADASTRO` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CPF_CNPJ` (`CPF_CNPJ`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sistpdv.clientes: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sistpdv.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOME_FANTASIA` varchar(255) NOT NULL,
  `RAZAO_SOCIAL` varchar(255) NOT NULL,
  `CNPJ` varchar(18) NOT NULL,
  `TELEFONE` varchar(20) DEFAULT NULL,
  `EMAIL` varchar(255) DEFAULT NULL,
  `ENDERECO` text DEFAULT NULL,
  `CIDADE` varchar(100) DEFAULT NULL,
  `ESTADO` varchar(2) DEFAULT NULL,
  `CEP` varchar(9) DEFAULT NULL,
  `SITUACAO` enum('ativo','inativo') DEFAULT 'ativo',
  `CRIADO` timestamp NOT NULL DEFAULT current_timestamp(),
  `ATUALIZADO` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `CNPJ` (`CNPJ`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sistpdv.empresas: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sistpdv.orcamento
CREATE TABLE IF NOT EXISTS `orcamento` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLIENTE_ID` int(11) NOT NULL,
  `PRODUTO_ID` int(11) NOT NULL,
  `QUANTIDADE` int(11) NOT NULL CHECK (`QUANTIDADE` > 0),
  `PRECO_UNITARIO` decimal(10,2) NOT NULL CHECK (`PRECO_UNITARIO` >= 0),
  `TOTAL` decimal(10,2) DEFAULT NULL,
  `DATA_ORCAMENTO` datetime DEFAULT current_timestamp(),
  `VALIDADE` date NOT NULL,
  `STATUS` enum('pendente','aprovado','rejeitado','expirado') DEFAULT 'pendente',
  `OBSERVACOES` text DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `CLIENTE_ID` (`CLIENTE_ID`),
  KEY `PRODUTO_ID` (`PRODUTO_ID`),
  CONSTRAINT `orcamento_ibfk_1` FOREIGN KEY (`CLIENTE_ID`) REFERENCES `clientes` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `orcamento_ibfk_2` FOREIGN KEY (`PRODUTO_ID`) REFERENCES `produtos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sistpdv.orcamento: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela sistpdv.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) NOT NULL,
  `PRECO` decimal(10,2) NOT NULL,
  `CODIGO` varchar(255) DEFAULT NULL,
  `EAN` varchar(255) DEFAULT NULL,
  `DESCRICAO` text DEFAULT NULL,
  `CUSTO` decimal(10,2) NOT NULL,
  `QUANTIDADE_ESTOQUE` int(11) DEFAULT 0,
  `CATEGORIA_ID` int(11) DEFAULT NULL,
  `IMAGEM` varchar(255) DEFAULT NULL,
  `STATUS` enum('ativo','inativo') DEFAULT 'ativo',
  `CRIADO` timestamp NOT NULL DEFAULT current_timestamp(),
  `ATUALIZADO` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`),
  KEY `CATEGORIA_ID` (`CATEGORIA_ID`),
  CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`CATEGORIA_ID`) REFERENCES `categorias` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sistpdv.produtos: ~4 rows (aproximadamente)
REPLACE INTO `produtos` (`ID`, `NOME`, `PRECO`, `CODIGO`, `EAN`, `DESCRICAO`, `CUSTO`, `QUANTIDADE_ESTOQUE`, `CATEGORIA_ID`, `IMAGEM`, `STATUS`, `CRIADO`, `ATUALIZADO`) VALUES
	(1, 'TESTE', 3324300.00, '34332', '2342342', 'teste', 23423400.00, 100, NULL, NULL, 'ativo', '2025-04-04 01:12:47', '2025-05-15 15:28:59'),
	(2, 'Manopla Titan 2000 Preta PRO TORK', 125000.00, '2232', '7899101613805', 'Características da Manopla\r\n\r\nModelo compatível com o original.,\r\n\r\nProduzido de acordo com as especificações das montadoras.,\r\n\r\nGarante originalidade e segurança.\r\n\r\n\r\n\r\n\r\n\r\nCompatível com Titan 150 (Honda), Titan 150 ES (Honda), Titan 2000 es (Honda), Titan 2000 KS (Honda), Titan 99 (Honda). FAN 125 (Honda)\r\n\r\n\r\nFoto Ilustrativa', 43300.00, 100, NULL, NULL, 'inativo', '2025-04-04 10:46:32', '2025-05-15 17:04:00'),
	(3, 'Manopla Titan 2000 Preta PRO TORK', 125000.00, '2232', '7899101613805', 'Características da Manopla\r\n\r\nModelo compatível com o original.,\r\n\r\nProduzido de acordo com as especificações das montadoras.,\r\n\r\nGarante originalidade e segurança.\r\n\r\n\r\n\r\n\r\n\r\nCompatível com Titan 150 (Honda), Titan 150 ES (Honda), Titan 2000 es (Honda), Titan 2000 KS (Honda), Titan 99 (Honda). FAN 125 (Honda)\r\n\r\n\r\nFoto Ilustrativa', 43300.00, 100, NULL, NULL, 'inativo', '2025-04-04 10:46:36', '2025-05-15 17:03:36'),
	(13, 'novo usuarios', 55300.00, '23', '23', '12', 3200.00, 1212, NULL, NULL, 'ativo', '2025-04-10 17:27:45', '2025-04-26 02:09:05'),
	(16, 'teste22222', 2323.00, '234', '234', 'reste', 2300.00, 11, NULL, NULL, 'ativo', '2025-04-26 02:06:51', '2025-04-26 02:08:57');

-- Copiando estrutura para tabela sistpdv.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `SENHA` varchar(255) NOT NULL,
  `DEPARTAMENTO` varchar(255) DEFAULT NULL,
  `BLOQUEADO` tinyint(1) DEFAULT 0,
  `GRUPO` varchar(255) DEFAULT NULL,
  `DESCONTO` decimal(5,2) DEFAULT NULL,
  `TELEFONE` varchar(20) DEFAULT NULL,
  `DELET` tinyint(1) DEFAULT 0,
  `CRIADO` timestamp NULL DEFAULT current_timestamp(),
  `ATUALIZADO` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `EMAIL` (`EMAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela sistpdv.usuarios: ~2 rows (aproximadamente)
REPLACE INTO `usuarios` (`ID`, `NOME`, `EMAIL`, `SENHA`, `DEPARTAMENTO`, `BLOQUEADO`, `GRUPO`, `DESCONTO`, `TELEFONE`, `DELET`, `CRIADO`, `ATUALIZADO`) VALUES
	(17, 'Alex Felix', 'admin@admin.com.br', '$2y$10$IaUiQ7BbOjn/skItGD5mg.s6ga2AB3xlAAwGO/JUmZl8sr/gnY6A2', 'admin', 0, 'admin', NULL, '11959328492', NULL, '2025-04-02 15:05:11', '2025-04-02 19:49:57'),
	(18, 'Teste de sistema', 'teste@admin.com.br', '$2y$10$iFCAeH4YTayrqpecWyPkOO134xhf4AcS50MVXP8a0TeLoNgaktR7u', 'admin', 0, 'admin', NULL, '1198398843434', NULL, '2025-04-02 15:13:36', '2025-05-16 15:33:15');

-- Copiando estrutura para tabela sistpdv.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLIENTE_ID` int(11) NOT NULL,
  `PRODUTO_ID` int(11) NOT NULL,
  `QUANTIDADE` int(11) NOT NULL CHECK (`QUANTIDADE` > 0),
  `PRECO_UNITARIO` decimal(10,2) NOT NULL CHECK (`PRECO_UNITARIO` >= 0),
  `TOTAL` decimal(10,2) DEFAULT NULL,
  `DATA_VENDA` datetime DEFAULT current_timestamp(),
  `STATUS` enum('PENDENTE','PAGO','CANCELADO') DEFAULT 'PENDENTE',
  PRIMARY KEY (`ID`),
  KEY `CLIENTE_ID` (`CLIENTE_ID`),
  KEY `PRODUTO_ID` (`PRODUTO_ID`),
  CONSTRAINT `vendas_ibfk_1` FOREIGN KEY (`CLIENTE_ID`) REFERENCES `clientes` (`ID`) ON DELETE CASCADE,
  CONSTRAINT `vendas_ibfk_2` FOREIGN KEY (`PRODUTO_ID`) REFERENCES `produtos` (`ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela sistpdv.vendas: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
