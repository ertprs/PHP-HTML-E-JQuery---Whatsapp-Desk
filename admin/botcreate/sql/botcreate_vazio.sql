-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.5-m8 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para botcreate
CREATE DATABASE IF NOT EXISTS `botcreate` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `botcreate`;

-- Copiando estrutura para tabela botcreate.botconfig
CREATE TABLE IF NOT EXISTS `botconfig` (
  `id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `imagem` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cabecalho` text,
  `item1inicial` text,
  `item2inicial` text,
  `item3inicial` text,
  `item4inicial` text,
  `item5inicial` text,
  `item6inicial` text,
  `item7inicial` text,
  `item8inicial` text,
  `item9inicial` text,
  `item10inicial` text,
  `respostaitem1inicial` text,
  `respostaitem2inicial` text,
  `respostaitem3inicial` text,
  `respostaitem4inicial` text,
  `respostaitem5inicial` text,
  `respostaitem6inicial` text,
  `respostaitem7inicial` text,
  `respostaitem8inicial` text,
  `respostaitem9inicial` text,
  `respostaitem10inicial` text,
  `respostaitem1nivel2` text,
  `respostaitem2nivel2` text,
  `respostaitem3nivel2` text,
  `respostaitem4nivel2` text,
  `respostaitem5nivel2` text,
  `respostaitem6nivel2` text,
  `respostaitem7nivel2` text,
  `respostaitem8nivel2` text,
  `respostaitem9nivel2` text,
  `respostaitem10nivel2` text,
  `emproducao` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela botcreate.botconfig: ~0 rows (aproximadamente)
DELETE FROM `botconfig`;
/*!40000 ALTER TABLE `botconfig` DISABLE KEYS */;
/*!40000 ALTER TABLE `botconfig` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
