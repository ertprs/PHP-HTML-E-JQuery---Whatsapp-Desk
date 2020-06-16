-- --------------------------------------------------------
-- Servidor:                     mysql.whatscompany.com.br
-- Versão do servidor:           10.2.23-MariaDB-log - MariaDB Server
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para u697328129_temtudo
CREATE DATABASE IF NOT EXISTS `u697328129_temtudo` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `u697328129_temtudo`;

-- Copiando estrutura para tabela u697328129_temtudo.adm
CREATE TABLE IF NOT EXISTS `adm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_cli` varchar(50) DEFAULT NULL,
  `email_adm` varchar(70) DEFAULT NULL,
  `pass_adm` varchar(30) DEFAULT NULL,
  `user_master` varchar(30) DEFAULT NULL,
  `whatsapp` varchar(30) DEFAULT NULL,
  `alerta` varchar(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela u697328129_temtudo.adm: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `adm` DISABLE KEYS */;
REPLACE INTO `adm` (`id`, `user_cli`, `email_adm`, `pass_adm`, `user_master`, `whatsapp`, `alerta`) VALUES
	(1, 'Multi-Atendimento', 'email@email.com', '1234', 'Multi-Atendimento', '5524999999999', '0');
/*!40000 ALTER TABLE `adm` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.api
CREATE TABLE IF NOT EXISTS `api` (
  `id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'Somente deve haver 1 campo e ser sempre id = 1',
  `api_token` varchar(100) DEFAULT NULL,
  `api_email` varchar(100) DEFAULT NULL,
  `api_idapp` varchar(100) DEFAULT NULL,
  `api_checkphone` varchar(5) DEFAULT NULL COMMENT 'Qtd de segundos de espera para verificar se telefone possui Whatsapp',
  `api_timezone_gmt` varchar(5) DEFAULT NULL COMMENT 'Número de hora para + ou - baseado no GMT',
  `info_atendente` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT 'Informa o nome da atendente no envio das mensagens',
  `info_transferencia` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT 'Informa que o atendimento foi transferido para determinada atendente',
  `limite_at` varchar(3) DEFAULT '3',
  `msg_off` varchar(255) DEFAULT 'Infelizmente nossos atendentes estão offline.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela u697328129_temtudo.api: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `api` DISABLE KEYS */;
REPLACE INTO `api` (`id`, `api_token`, `api_email`, `api_idapp`, `api_checkphone`, `api_timezone_gmt`, `info_atendente`, `info_transferencia`, `limite_at`, `msg_off`) VALUES
	(1, 'f575b5d73f51f5fc86beb8800e1b506c125986', 'api3@grupoconnectti.com.br', '4519', '5', '3', 1, 1, '3', '*Infelizmente nossos atendentes estÃ£o offline.*\r\nNosso horÃ¡rio de atendimento Ã© de Segunda a Sexta.\r\nDas 9:00 Ã s 18:00\r\nRetornaremos sua mensagem assim que possÃ­vel.\r\nObrigado.');
/*!40000 ALTER TABLE `api` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.contatos
CREATE TABLE IF NOT EXISTS `contatos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(30) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `status` varchar(2) DEFAULT '0',
  `posicao` int(10) DEFAULT NULL,
  `user_cli` varchar(50) DEFAULT NULL,
  `data_rg` varchar(10) DEFAULT NULL,
  `data_rt` varchar(10) DEFAULT NULL,
  `tag` varchar(50) DEFAULT NULL,
  `notepad` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela u697328129_temtudo.contatos: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `contatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contatos` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.logss
CREATE TABLE IF NOT EXISTS `logss` (
  `idl` int(11) NOT NULL AUTO_INCREMENT,
  `logss` text COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idl`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela u697328129_temtudo.logss: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `logss` DISABLE KEYS */;
/*!40000 ALTER TABLE `logss` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(9) COLLATE utf8_unicode_ci DEFAULT ' #424949 ',
  `created_at` datetime DEFAULT current_timestamp(),
  `modified_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Copiando dados para a tabela u697328129_temtudo.tags: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code_cli` varchar(100) DEFAULT NULL,
  `user_cli` varchar(40) DEFAULT NULL,
  `nome_cli` varchar(40) DEFAULT NULL,
  `user_adicional` varchar(2) DEFAULT '0',
  `pass` varchar(15) DEFAULT NULL,
  `email_cli` varchar(90) DEFAULT NULL,
  `status` int(11) DEFAULT -1,
  `logado` int(11) unsigned NOT NULL DEFAULT 0,
  `num` varchar(1) DEFAULT '1',
  `ativo` smallint(5) DEFAULT -1,
  `rota_min` tinyint(3) DEFAULT 1,
  `rota_max` tinyint(3) DEFAULT 1,
  `rota` tinyint(3) unsigned DEFAULT 0,
  `user_master` varchar(40) DEFAULT NULL,
  `alerta_sonoro` varchar(2) DEFAULT '-1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela u697328129_temtudo.usuarios: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
REPLACE INTO `usuarios` (`id`, `code_cli`, `user_cli`, `nome_cli`, `user_adicional`, `pass`, `email_cli`, `status`, `logado`, `num`, `ativo`, `rota_min`, `rota_max`, `rota`, `user_master`, `alerta_sonoro`) VALUES
	(4, '1234', 'Multi-Atendimento', 'Atendente 01', '0', '1234', 'email@email.com', 0, 0, '1', -1, 1, 1, 1, 'Multi-Atendimento', '-1');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.whats_chat
CREATE TABLE IF NOT EXISTS `whats_chat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entrada_saida` smallint(5) unsigned NOT NULL DEFAULT 0,
  `user_cli` varchar(40) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `status_cli` varchar(2) DEFAULT '-1',
  `data_msg` date DEFAULT NULL,
  `hora_msg` varchar(8) DEFAULT NULL,
  `status` varchar(2) DEFAULT '0',
  `tag_id` int(11) DEFAULT NULL,
  `mensagem` longtext DEFAULT NULL,
  `arquivo` varchar(200) DEFAULT NULL,
  `tipo_mensagem` varchar(20) DEFAULT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `lida` varchar(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_1` (`data_msg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela u697328129_temtudo.whats_chat: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `whats_chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `whats_chat` ENABLE KEYS */;

-- Copiando estrutura para tabela u697328129_temtudo.whats_chat_tmp
CREATE TABLE IF NOT EXISTS `whats_chat_tmp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `entrada_saida` smallint(5) unsigned NOT NULL DEFAULT 0,
  `user_cli` varchar(40) COLLATE latin1_general_ci DEFAULT NULL,
  `whatsapp` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `status_cli` varchar(2) COLLATE latin1_general_ci DEFAULT '-1',
  `data_msg` date DEFAULT NULL,
  `hora_msg` varchar(8) COLLATE latin1_general_ci DEFAULT NULL,
  `status` varchar(2) COLLATE latin1_general_ci DEFAULT '0',
  `mensagem` longtext COLLATE latin1_general_ci DEFAULT NULL,
  `arquivo` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `tipo_mensagem` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `referencia` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `base64` longtext COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Essa tabela é utilizada quando a mensagem é arquivo. Primeiramente grava o header. Depois grava o arquivo\r\ncodificado em Base64 para binário.Havendo sucesso, através da referência faz update o registro do header.\r\nHavendo sucesso, transfere para whats_chat . Havendo sucesso, o registro de whats_chat_tmp é deletado.';

-- Copiando dados para a tabela u697328129_temtudo.whats_chat_tmp: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `whats_chat_tmp` DISABLE KEYS */;
/*!40000 ALTER TABLE `whats_chat_tmp` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
