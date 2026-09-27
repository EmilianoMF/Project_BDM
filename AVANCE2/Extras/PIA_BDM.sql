-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bdm_pia
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `consultas`
--

DROP TABLE IF EXISTS `consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consultas` (
  `id_consulta` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `criterio_busqueda` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_consulta`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consultas`
--

LOCK TABLES `consultas` WRITE;
/*!40000 ALTER TABLE `consultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multimedia_siniestro`
--

DROP TABLE IF EXISTS `multimedia_siniestro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `multimedia_siniestro` (
  `id_multimedia` int NOT NULL AUTO_INCREMENT,
  `id_siniestro` int NOT NULL,
  `tipo_archivo` enum('Foto','Video') NOT NULL,
  `url_archivo` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_multimedia`),
  KEY `id_siniestro` (`id_siniestro`),
  CONSTRAINT `multimedia_siniestro_ibfk_1` FOREIGN KEY (`id_siniestro`) REFERENCES `siniestros` (`id_siniestro`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multimedia_siniestro`
--

LOCK TABLES `multimedia_siniestro` WRITE;
/*!40000 ALTER TABLE `multimedia_siniestro` DISABLE KEYS */;
INSERT INTO `multimedia_siniestro` VALUES (1,1,'Foto','uploads/69fc5f97066e7_Practica 8_EMF.png',NULL,'2026-05-07 03:47:03'),(2,2,'Foto','uploads/69fd351569976_Captura de pantalla 2024-05-27 073134.png',NULL,'2026-05-07 18:57:57'),(3,3,'Foto','uploads/69fd39a5c950f_Captura de pantalla 2024-05-27 073134.png',NULL,'2026-05-07 19:17:25'),(4,4,'Foto','uploads/69fd3c0f9a0cc_Captura de pantalla 2024-05-27 073347.png',NULL,'2026-05-07 19:27:43');
/*!40000 ALTER TABLE `multimedia_siniestro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimiento`
--

DROP TABLE IF EXISTS `seguimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguimiento` (
  `id_seguimiento` int NOT NULL AUTO_INCREMENT,
  `id_siniestro` int NOT NULL,
  `id_usuario` int NOT NULL,
  `comentario` text,
  `fecha_comentario` datetime DEFAULT CURRENT_TIMESTAMP,
  `respuesta` text,
  `fecha_respuesta` datetime DEFAULT NULL,
  PRIMARY KEY (`id_seguimiento`),
  KEY `id_siniestro` (`id_siniestro`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`id_siniestro`) REFERENCES `siniestros` (`id_siniestro`),
  CONSTRAINT `seguimiento_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimiento`
--

LOCK TABLES `seguimiento` WRITE;
/*!40000 ALTER TABLE `seguimiento` DISABLE KEYS */;
INSERT INTO `seguimiento` VALUES (1,1,12,'Hola','2026-05-07 13:17:45',NULL,NULL),(2,1,12,'Como estas? ','2026-05-07 13:25:47',NULL,NULL),(3,1,13,'Hola','2026-05-07 14:33:50',NULL,NULL),(4,1,13,'Hola buenos días.','2026-05-30 01:26:06',NULL,NULL);
/*!40000 ALTER TABLE `seguimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `siniestros`
--

DROP TABLE IF EXISTS `siniestros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `siniestros` (
  `id_siniestro` int NOT NULL AUTO_INCREMENT,
  `id_ajustador` int NOT NULL,
  `id_supervisor` int DEFAULT NULL,
  `id_unidad` int NOT NULL,
  `nombre_compania` varchar(100) DEFAULT NULL,
  `direccion_compania` varchar(150) DEFAULT NULL,
  `telefono_compania` varchar(20) DEFAULT NULL,
  `correo_compania` varchar(100) DEFAULT NULL,
  `fecha_siniestro` datetime NOT NULL,
  `ubicacion` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `numero_poliza` varchar(50) NOT NULL,
  `tipo_pago` enum('Pendiente','Deducible','Reparación','Pérdida total') DEFAULT 'Pendiente',
  `estado` enum('Pendiente','Rechazado','Aceptado','Aceptado con deducible','Aceptado sin deducible','Pago reparación','Pérdida total') DEFAULT 'Pendiente',
  `fecha_aprobacion` datetime DEFAULT NULL,
  `fecha_finalizacion` datetime DEFAULT NULL,
  `nombre_cliente` varchar(100) DEFAULT NULL,
  `correo_cliente` varchar(100) DEFAULT NULL,
  `otras_Uni` enum('Sí','No') DEFAULT NULL,
  PRIMARY KEY (`id_siniestro`),
  KEY `id_ajustador` (`id_ajustador`),
  KEY `id_supervisor` (`id_supervisor`),
  KEY `id_unidad` (`id_unidad`),
  CONSTRAINT `siniestros_ibfk_1` FOREIGN KEY (`id_ajustador`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `siniestros_ibfk_2` FOREIGN KEY (`id_supervisor`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `siniestros_ibfk_3` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id_unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `siniestros`
--

LOCK TABLES `siniestros` WRITE;
/*!40000 ALTER TABLE `siniestros` DISABLE KEYS */;
INSERT INTO `siniestros` VALUES (1,12,13,1,'Auto Kat','Infonavit Cerrito, De la montaña #126, Linares N.L.','8211785690','autokat123@gmail.com','2026-05-06 18:00:00','Linares NL.','El choque ocurrió en vías del tren. ','123456789','Pendiente','Pérdida total',NULL,'2026-05-07 17:25:56','Ka Hernández Álvarez ','ka123@gmail.com','Sí'),(2,13,NULL,2,'Auto Kat','Infonavit Cerrito, De la montaña #126, Linares N.L.','8211785690','autokat123@gmail.com','2026-05-05 17:00:00','Linares NL.','Estuvo bien fuerte.','12345674321','Pendiente','Pendiente',NULL,NULL,'Aurelio Montoya Flores ','aurelio123@gmail.com','No'),(3,16,NULL,6,'Auto Kat','Infonavit Cerrito, De la montaña #126, Linares N.L.','8211785690','autokat123@gmail.com','2026-05-06 10:00:00','Linares NL.','Choque en Intersección Arramberri y Colon\r\nDefensa trasera dañada en Mazda, Cofre dañado \r\nChoque con: Volkswagen Vento 2011\r\nPlacas: RMX-647-B\r\nDueño de la otra unidad: ','023495','Pendiente','Pendiente',NULL,NULL,'Jose Luis Montoya','montoya@gmail.com','Sí'),(4,12,13,7,'Auto Kat','Infonavit Cerrito, De la montaña #126, Linares N.L.','8211785690','autokat123@gmail.com','2026-04-29 21:28:00','Linares NL.','Choque en rotonda con Tsuru plata 2000.\r\n','67254','Pérdida total','Pérdida total',NULL,'2026-05-07 19:31:36','Marcos Antonio Fuentes ','marcos123@gmail.com','Sí');
/*!40000 ALTER TABLE `siniestros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidades`
--

DROP TABLE IF EXISTS `unidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unidades` (
  `id_unidad` int NOT NULL AUTO_INCREMENT,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `año` int NOT NULL,
  `placas` varchar(20) DEFAULT NULL,
  `numero_serie` varchar(50) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_unidad`),
  UNIQUE KEY `placas` (`placas`),
  UNIQUE KEY `numero_serie` (`numero_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidades`
--

LOCK TABLES `unidades` WRITE;
/*!40000 ALTER TABLE `unidades` DISABLE KEYS */;
INSERT INTO `unidades` VALUES (1,'Nissan ','Versa ',2021,'h1-543-21','23458769','Rojo '),(2,'Nissan ','Versa ',2000,'A1-753-21','98767789','Azul'),(6,'Mazda','Sport',2014,'SUH-814-A','23950324','Gris'),(7,'Nissan','Versa',2021,'HJE-21-20','4327890','Plata');
/*!40000 ALTER TABLE `unidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `genero` enum('Masculino','Femenino','Otro') NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `tipo_usuario` enum('Ajustador','Supervisor','Asegurado') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (12,'Marilyn','Montoya Flores','2005-07-12','uploads/69fb01db7cf81_blackpink.jpg','Femenino','marilyn123@gmail.com','$2y$10$JKoAfX/pTByduKsFw1qBPun8L5cLxH0xBmp7.zaUZz9/HhOUbz8NW','Mar','Ajustador'),(13,'Emiliano','Montoya Flores','2005-06-30','uploads/IMG_2029.jpg','Otro','montoyaemiliano80@gmail.com','$2y$10$AMm5JznZUNzRHi2KRutFN.VIBHo5HYJra5.b4245KZH2a5T9YT.km','Violet_Min','Supervisor'),(15,'Ka','Hernández Álvarez','2008-05-07','uploads/69fc596e54205_descarga (6).jpg','Femenino','ka123@gmail.com','$2y$10$w6CoxTYfWjiNdzp1SSi3pOwoGUKux.oTROuotswC1cTbyHnMDm73a','Ka','Asegurado'),(16,'Pepito','Maestro Ajustador','2006-01-09','uploads/69fd3a5d84802_Captura de pantalla 2024-06-10 025621.png','Masculino','pepito@gmail.com','$2y$10$nCRCMMr6fQ/PUEZStg1A/eFO0u/.Gys9N47hx4YL6Ab/FlVh9daNW','Super Pepito','Ajustador'),(19,'Violet ','Min','2005-06-30','uploads/6a1a8c5e0951a_Lisa BP.jpg','Otro','violet123@gmail.com','$2y$10$q8c3W5pQKZuqFvNvawpTTO4GECS/ptfRx39bZjatXWLjKucgkvvta','Violet_min2','Asegurado');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vista_detalle_siniestro`
--

DROP TABLE IF EXISTS `vista_detalle_siniestro`;
/*!50001 DROP VIEW IF EXISTS `vista_detalle_siniestro`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_detalle_siniestro` AS SELECT 
 1 AS `id_siniestro`,
 1 AS `id_ajustador`,
 1 AS `id_supervisor`,
 1 AS `nombre_compania`,
 1 AS `direccion_compania`,
 1 AS `telefono_compania`,
 1 AS `correo_compania`,
 1 AS `nombre_cliente`,
 1 AS `correo_cliente`,
 1 AS `fecha_siniestro`,
 1 AS `ubicacion`,
 1 AS `descripcion`,
 1 AS `otras_Uni`,
 1 AS `numero_poliza`,
 1 AS `tipo_pago`,
 1 AS `estado`,
 1 AS `fecha_aprobacion`,
 1 AS `fecha_finalizacion`,
 1 AS `marca`,
 1 AS `modelo`,
 1 AS `año`,
 1 AS `color`,
 1 AS `placas`,
 1 AS `numero_serie`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_seguimiento`
--

DROP TABLE IF EXISTS `vista_seguimiento`;
/*!50001 DROP VIEW IF EXISTS `vista_seguimiento`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_seguimiento` AS SELECT 
 1 AS `id_seguimiento`,
 1 AS `id_siniestro`,
 1 AS `comentario`,
 1 AS `respuesta`,
 1 AS `fecha_comentario`,
 1 AS `fecha_respuesta`,
 1 AS `nombre`,
 1 AS `tipo_usuario`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_siniestros`
--

DROP TABLE IF EXISTS `vista_siniestros`;
/*!50001 DROP VIEW IF EXISTS `vista_siniestros`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_siniestros` AS SELECT 
 1 AS `id_siniestro`,
 1 AS `fecha_siniestro`,
 1 AS `nombre_cliente`,
 1 AS `correo_cliente`,
 1 AS `estado`,
 1 AS `tipo_pago`,
 1 AS `ubicacion`,
 1 AS `numero_poliza`,
 1 AS `marca`,
 1 AS `modelo`,
 1 AS `color`,
 1 AS `placas`,
 1 AS `nombre_ajustador`,
 1 AS `id_ajustador`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vista_detalle_siniestro`
--

/*!50001 DROP VIEW IF EXISTS `vista_detalle_siniestro`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_detalle_siniestro` AS select `s`.`id_siniestro` AS `id_siniestro`,`s`.`id_ajustador` AS `id_ajustador`,`s`.`id_supervisor` AS `id_supervisor`,`s`.`nombre_compania` AS `nombre_compania`,`s`.`direccion_compania` AS `direccion_compania`,`s`.`telefono_compania` AS `telefono_compania`,`s`.`correo_compania` AS `correo_compania`,`s`.`nombre_cliente` AS `nombre_cliente`,`s`.`correo_cliente` AS `correo_cliente`,`s`.`fecha_siniestro` AS `fecha_siniestro`,`s`.`ubicacion` AS `ubicacion`,`s`.`descripcion` AS `descripcion`,`s`.`otras_Uni` AS `otras_Uni`,`s`.`numero_poliza` AS `numero_poliza`,`s`.`tipo_pago` AS `tipo_pago`,`s`.`estado` AS `estado`,`s`.`fecha_aprobacion` AS `fecha_aprobacion`,`s`.`fecha_finalizacion` AS `fecha_finalizacion`,`u`.`marca` AS `marca`,`u`.`modelo` AS `modelo`,`u`.`año` AS `año`,`u`.`color` AS `color`,`u`.`placas` AS `placas`,`u`.`numero_serie` AS `numero_serie` from (`siniestros` `s` join `unidades` `u` on((`s`.`id_unidad` = `u`.`id_unidad`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_seguimiento`
--

/*!50001 DROP VIEW IF EXISTS `vista_seguimiento`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_seguimiento` AS select `s`.`id_seguimiento` AS `id_seguimiento`,`s`.`id_siniestro` AS `id_siniestro`,`s`.`comentario` AS `comentario`,`s`.`respuesta` AS `respuesta`,`s`.`fecha_comentario` AS `fecha_comentario`,`s`.`fecha_respuesta` AS `fecha_respuesta`,`u`.`nombre` AS `nombre`,`u`.`tipo_usuario` AS `tipo_usuario` from (`seguimiento` `s` join `usuarios` `u` on((`s`.`id_usuario` = `u`.`id_usuario`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_siniestros`
--

/*!50001 DROP VIEW IF EXISTS `vista_siniestros`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_siniestros` AS select `s`.`id_siniestro` AS `id_siniestro`,`s`.`fecha_siniestro` AS `fecha_siniestro`,`s`.`nombre_cliente` AS `nombre_cliente`,`s`.`correo_cliente` AS `correo_cliente`,`s`.`estado` AS `estado`,`s`.`tipo_pago` AS `tipo_pago`,`s`.`ubicacion` AS `ubicacion`,`s`.`numero_poliza` AS `numero_poliza`,`u`.`marca` AS `marca`,`u`.`modelo` AS `modelo`,`u`.`color` AS `color`,`u`.`placas` AS `placas`,`usr`.`nombre` AS `nombre_ajustador`,`s`.`id_ajustador` AS `id_ajustador` from ((`siniestros` `s` join `unidades` `u` on((`s`.`id_unidad` = `u`.`id_unidad`))) join `usuarios` `usr` on((`s`.`id_ajustador` = `usr`.`id_usuario`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-30  3:13:30
