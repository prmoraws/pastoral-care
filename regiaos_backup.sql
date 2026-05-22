-- MySQL dump 10.13  Distrib 8.4.9, for Linux (x86_64)
--
-- Host: localhost    Database: pastoral_care
-- ------------------------------------------------------
-- Server version	8.4.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `regiaos`
--

DROP TABLE IF EXISTS `regiaos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regiaos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bloco_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regiaos_bloco_id_foreign` (`bloco_id`),
  CONSTRAINT `regiaos_bloco_id_foreign` FOREIGN KEY (`bloco_id`) REFERENCES `blocos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regiaos`
--

LOCK TABLES `regiaos` WRITE;
/*!40000 ALTER TABLE `regiaos` DISABLE KEYS */;
INSERT INTO `regiaos` VALUES (1,'Alagoinhas',1,NULL,NULL),(2,'CATU',1,NULL,NULL),(3,'ENTRE RIOS',1,NULL,NULL),(4,'ESPLANADA',1,NULL,NULL),(5,'RIBEIRA DO POMBAL',1,NULL,NULL),(6,'SANTA TEREZINHA',1,NULL,NULL),(7,'Barreiras',2,NULL,NULL),(8,'Barreiras II',2,NULL,NULL),(9,'Bom Jesus da Lapa',2,NULL,NULL),(10,'Ibotirama',2,NULL,NULL),(11,'Luis Eduardo',2,NULL,NULL),(12,'Camaçari',3,NULL,NULL),(13,'Barra da Pojuca',3,NULL,NULL),(14,'Dias D´Avila',3,NULL,NULL),(15,'Lama Preta',3,NULL,NULL),(16,'Monte Gordo',3,NULL,NULL),(17,'Phoc',3,NULL,NULL),(18,'Pojuca',3,NULL,NULL),(19,'Caminho de Areia',4,NULL,NULL),(20,'Alto de Coutos',4,NULL,NULL),(21,'Fazenda Coutos',4,NULL,NULL),(22,'Ilha Amerela',4,NULL,NULL),(23,'Lobato',4,NULL,NULL),(24,'Mirante de Periperi',4,NULL,NULL),(25,'Paripe',4,NULL,NULL),(26,'Paripe II',4,NULL,NULL),(27,'Plataforma',4,NULL,NULL),(28,'Santa Luzia',4,NULL,NULL),(29,'Uruguai',4,NULL,NULL),(30,'Cajazeiras X',5,NULL,NULL),(31,'Aguas Claras',5,NULL,NULL),(32,'Cajazeiras VI',5,NULL,NULL),(33,'Castelo Branco',5,NULL,NULL),(34,'Castelo Branco II',5,NULL,NULL),(35,'Mussurunga',5,NULL,NULL),(36,'Nova Brasilia',5,NULL,NULL),(37,'Valeria',5,NULL,NULL),(38,'Candeias',6,NULL,NULL),(39,'Madre de Deus',6,NULL,NULL),(40,'Nova Candeias',6,NULL,NULL),(41,'São Franscico do Conde',6,NULL,NULL),(42,'Vitória da Conquista',7,NULL,NULL),(43,'Bairro Brasil',7,NULL,NULL),(44,'Brumado',7,NULL,NULL),(45,'Caetite',7,NULL,NULL),(46,'Candido Sales',7,NULL,NULL),(47,'Guanambi',7,NULL,NULL),(48,'Ipiau',7,NULL,NULL),(49,'Itapetinga',7,NULL,NULL),(50,'Jaguaquara',7,NULL,NULL),(51,'Jequie',7,NULL,NULL),(52,'Jequie IV',7,NULL,NULL),(53,'Paramirim',7,NULL,NULL),(54,'Pocoes',7,NULL,NULL),(55,'Urbis VI',7,NULL,NULL),(56,'Dois Leões',8,NULL,NULL),(57,'Aquidaba',8,NULL,NULL),(58,'Brotas',8,NULL,NULL),(59,'Cine Centro',8,NULL,NULL),(60,'Cosme de Farias',8,NULL,NULL),(61,'Eng Velho de Brotas',8,NULL,NULL),(62,'Federação',8,NULL,NULL),(63,'Liberdade',8,NULL,NULL),(64,'Matatu de Brotas',8,NULL,NULL),(65,'Pau da Lima',8,NULL,NULL),(66,'Vale da Muriçoca',8,NULL,NULL),(67,'Vale do Matatu',8,NULL,NULL),(68,'Vasco da Gama',8,NULL,NULL),(69,'Fazenda Grande',9,NULL,NULL),(70,'Campinas de Piraja',9,NULL,NULL),(71,'Largo do Tanque',9,NULL,NULL),(72,'Piraja do Lobato',9,NULL,NULL),(73,'San Martin',9,NULL,NULL),(74,'São Caetano',9,NULL,NULL),(75,'Feira de Santana',10,NULL,NULL),(76,'Amelia Rodrigues',10,NULL,NULL),(77,'Campo Limpo',10,NULL,NULL),(78,'Conceição do Coite',10,NULL,NULL),(79,'Conceição do Jacuípe',10,NULL,NULL),(80,'Ipira',10,NULL,NULL),(81,'Irece',10,NULL,NULL),(82,'Jacobina',10,NULL,NULL),(83,'Presidente Dutra',10,NULL,NULL),(84,'Santo Estevão',10,NULL,NULL),(85,'São Gonçalos dos Campos',10,NULL,NULL),(86,'Xique Xique',10,NULL,NULL),(87,'Feira de Santana II',11,NULL,NULL),(88,'Cachoeira',11,NULL,NULL),(89,'Cansanção',11,NULL,NULL),(90,'Euclides da Cunha',11,NULL,NULL),(91,'Itaberaba',11,NULL,NULL),(92,'Muritiba',11,NULL,NULL),(93,'Serrinha',11,NULL,NULL),(94,'Tomba',11,NULL,NULL),(95,'Itabuna',12,NULL,NULL),(96,'Itabuna II',12,NULL,NULL),(97,'Itabuna III',12,NULL,NULL),(98,'Ilheus',12,NULL,NULL),(99,'Canavieras',12,NULL,NULL),(100,'Lomanto',12,NULL,NULL),(101,'Malhado',12,NULL,NULL),(102,'Itapuã',13,NULL,NULL),(103,'Avenida Aliomar',13,NULL,NULL),(104,'Bairro da Paz',13,NULL,NULL),(105,'Boca do Rio',13,NULL,NULL),(106,'Boca do Rio II',13,NULL,NULL),(107,'Imbui',13,NULL,NULL),(108,'São Cristovão',13,NULL,NULL),(109,'Juazeiro',14,NULL,NULL),(110,'Bonfim',14,NULL,NULL),(111,'Paulo Afonso',14,NULL,NULL),(112,'Remanso',14,NULL,NULL),(113,'Pernambues',15,NULL,NULL),(114,'Barra',15,NULL,NULL),(115,'Itaparica',15,NULL,NULL),(116,'Mar Grande',15,NULL,NULL),(117,'Nordeste',15,NULL,NULL),(118,'Pituba',15,NULL,NULL),(119,'Santa Cruz',15,NULL,NULL),(120,'São Rafael',15,NULL,NULL),(121,'Sete de Abril',15,NULL,NULL),(122,'Vale das Pedrinhas',15,NULL,NULL),(123,'Santo Antônio de Jesus',16,NULL,NULL),(124,'Amargosa',16,NULL,NULL),(125,'Castro Alves',16,NULL,NULL),(126,'Cruz das Almas',16,NULL,NULL),(127,'Gandu',16,NULL,NULL),(128,'Nazare',16,NULL,NULL),(129,'São Benedito',16,NULL,NULL),(130,'Valença',16,NULL,NULL),(131,'Valença II Bolivia',16,NULL,NULL),(132,'Simões Filho',17,NULL,NULL),(133,'Areia Branca II',17,NULL,NULL),(134,'CIA',17,NULL,NULL),(135,'Santo Amaro',17,NULL,NULL),(136,'Saubara',17,NULL,NULL),(137,'Tancredo Neves',18,NULL,NULL),(138,'Engomadeira',18,NULL,NULL),(139,'Estrada das Barreiras',18,NULL,NULL),(140,'Sussuarana',18,NULL,NULL),(141,'Teixeira de Freitas',19,NULL,NULL),(142,'Baianao II',19,NULL,NULL),(143,'Eunapolis',19,NULL,NULL),(144,'Itamaraju',19,NULL,NULL),(145,'Porto Seguro',19,NULL,NULL),(146,'Praca da Biblia',19,NULL,NULL),(147,'Vilas do Atlântico',20,NULL,NULL),(148,'Itinga',20,NULL,NULL),(149,'Jaua',20,NULL,NULL),(150,'Lauro de Freitas',20,NULL,NULL),(151,'Parque Santa Rita',20,NULL,NULL),(152,'Vida Nova',20,NULL,NULL),(153,'Vila de Abrante',20,NULL,NULL),(154,'Catedral',21,NULL,NULL);
/*!40000 ALTER TABLE `regiaos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-21  3:15:05
