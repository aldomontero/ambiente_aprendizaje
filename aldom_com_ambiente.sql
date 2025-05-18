/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MariaDB
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : aldom_com_ambiente

 Target Server Type    : MariaDB
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 17/05/2025 22:30:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for comentarios_foros
-- ----------------------------
DROP TABLE IF EXISTS `comentarios_foros`;
CREATE TABLE `comentarios_foros`  (
  `IdComentarioForo` int(10) NOT NULL AUTO_INCREMENT,
  `ComentarioForo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IdUsuario` int(10) NULL DEFAULT NULL,
  `IdForo` int(10) NULL DEFAULT NULL,
  `FechaComentario` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`IdComentarioForo`) USING BTREE,
  INDEX `IdUsuario`(`IdUsuario`) USING BTREE,
  INDEX `IdForo`(`IdForo`) USING BTREE,
  CONSTRAINT `comentarios_foros_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `comentarios_foros_ibfk_2` FOREIGN KEY (`IdForo`) REFERENCES `foros` (`IdForo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of comentarios_foros
-- ----------------------------
INSERT INTO `comentarios_foros` VALUES (1, 'Ningun comentario', 1, 1, '2025-05-17 22:29:27');

-- ----------------------------
-- Table structure for foros
-- ----------------------------
DROP TABLE IF EXISTS `foros`;
CREATE TABLE `foros`  (
  `IdForo` int(10) NOT NULL AUTO_INCREMENT,
  `Foro` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IdGrupo` int(10) NULL DEFAULT NULL,
  `IdTema` int(10) NULL DEFAULT NULL,
  `IdTipoForo` int(10) NULL DEFAULT NULL,
  `FechaAlta` timestamp NULL DEFAULT current_timestamp(),
  `FechaVigencia` date NULL DEFAULT NULL,
  PRIMARY KEY (`IdForo`) USING BTREE,
  INDEX `IdGrupo`(`IdGrupo`) USING BTREE,
  INDEX `IdTema`(`IdTema`) USING BTREE,
  INDEX `IdTipoForo`(`IdTipoForo`) USING BTREE,
  CONSTRAINT `foros_ibfk_1` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`IdGrupo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `foros_ibfk_2` FOREIGN KEY (`IdTema`) REFERENCES `temas` (`IdTema`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `foros_ibfk_3` FOREIGN KEY (`IdTipoForo`) REFERENCES `tipo_foros` (`IdTipoForo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of foros
-- ----------------------------
INSERT INTO `foros` VALUES (1, 'Foro de discucion', 1, 1, 1, '2025-05-17 22:29:07', '2024-10-10');

-- ----------------------------
-- Table structure for grupos
-- ----------------------------
DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos`  (
  `IdGrupo` int(10) NOT NULL AUTO_INCREMENT,
  `Grupo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IdUsuario` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`IdGrupo`) USING BTREE,
  INDEX `IdUsuario`(`IdUsuario`) USING BTREE,
  CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grupos
-- ----------------------------
INSERT INTO `grupos` VALUES (1, 'Grupo I', 1);

-- ----------------------------
-- Table structure for grupos_temas
-- ----------------------------
DROP TABLE IF EXISTS `grupos_temas`;
CREATE TABLE `grupos_temas`  (
  `IdGrupoTema` int(1) NOT NULL DEFAULT 0,
  `IdGrupo` int(10) NULL DEFAULT NULL,
  `IdTema` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`IdGrupoTema`) USING BTREE,
  INDEX `IdGrupo`(`IdGrupo`) USING BTREE,
  INDEX `IdTema`(`IdTema`) USING BTREE,
  CONSTRAINT `grupos_temas_ibfk_1` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`IdGrupo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `grupos_temas_ibfk_2` FOREIGN KEY (`IdTema`) REFERENCES `temas` (`IdTema`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of grupos_temas
-- ----------------------------
INSERT INTO `grupos_temas` VALUES (0, 1, 1);

-- ----------------------------
-- Table structure for mensajes_destinos
-- ----------------------------
DROP TABLE IF EXISTS `mensajes_destinos`;
CREATE TABLE `mensajes_destinos`  (
  `IdMensajeDestino` int(10) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(10) NULL DEFAULT NULL,
  `IdMensajeEmisor` int(10) NULL DEFAULT NULL,
  `MensajeRecibido` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`IdMensajeDestino`) USING BTREE,
  INDEX `IdUsuario`(`IdUsuario`) USING BTREE,
  INDEX `IdMensajeEmisor`(`IdMensajeEmisor`) USING BTREE,
  CONSTRAINT `mensajes_destinos_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mensajes_destinos_ibfk_2` FOREIGN KEY (`IdMensajeEmisor`) REFERENCES `mensajes_emisores` (`IdMensajeEmisor`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mensajes_destinos
-- ----------------------------
INSERT INTO `mensajes_destinos` VALUES (1, 1, 2, 0);
INSERT INTO `mensajes_destinos` VALUES (2, 3, 3, 0);

-- ----------------------------
-- Table structure for mensajes_emisores
-- ----------------------------
DROP TABLE IF EXISTS `mensajes_emisores`;
CREATE TABLE `mensajes_emisores`  (
  `IdMensajeEmisor` int(10) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(10) NULL DEFAULT NULL,
  `MensajeEmisor` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `MensajeEmisorFechaHora` timestamp NULL DEFAULT current_timestamp(),
  `IdGrupo` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`IdMensajeEmisor`) USING BTREE,
  INDEX `IdUsuario`(`IdUsuario`) USING BTREE,
  INDEX `IdGrupo`(`IdGrupo`) USING BTREE,
  CONSTRAINT `mensajes_emisores_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `mensajes_emisores_ibfk_2` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`IdGrupo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of mensajes_emisores
-- ----------------------------
INSERT INTO `mensajes_emisores` VALUES (1, 2, 'hola', '2025-05-16 15:14:24', NULL);
INSERT INTO `mensajes_emisores` VALUES (2, 2, 'hola', '2025-05-16 15:16:36', NULL);
INSERT INTO `mensajes_emisores` VALUES (3, 1, 'hola', '2025-05-17 22:26:38', NULL);

-- ----------------------------
-- Table structure for objetos_didacticos
-- ----------------------------
DROP TABLE IF EXISTS `objetos_didacticos`;
CREATE TABLE `objetos_didacticos`  (
  `IdObjetoDidactico` int(10) NOT NULL DEFAULT 0,
  `IdObjeto` int(10) NULL DEFAULT NULL,
  `TituloObjetoDidactico` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ArchivoObjetoDidactico` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ObjetoDidacticoTema` tinyint(1) NULL DEFAULT NULL,
  `TamañoKBytes` bigint(30) NULL DEFAULT NULL,
  PRIMARY KEY (`IdObjetoDidactico`) USING BTREE,
  INDEX `IdObjeto`(`IdObjeto`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of objetos_didacticos
-- ----------------------------
INSERT INTO `objetos_didacticos` VALUES (0, 1, 'Actividad I', 'database-svgrepo-com.svg', 1, 0);

-- ----------------------------
-- Table structure for subtemas
-- ----------------------------
DROP TABLE IF EXISTS `subtemas`;
CREATE TABLE `subtemas`  (
  `IdSubTema` int(10) NOT NULL AUTO_INCREMENT,
  `IdTema` int(10) NULL DEFAULT NULL,
  `SubTema` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Visibilidad` tinyint(1) NULL DEFAULT NULL,
  `FechaAlta` timestamp NULL DEFAULT current_timestamp(),
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IdSubTema`) USING BTREE,
  INDEX `IdTema`(`IdTema`) USING BTREE,
  CONSTRAINT `subtemas_ibfk_1` FOREIGN KEY (`IdTema`) REFERENCES `temas` (`IdTema`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subtemas
-- ----------------------------
INSERT INTO `subtemas` VALUES (1, 1, 'Unidad I', 1, '2025-05-17 22:25:19', 'Detalle de la unidad');

-- ----------------------------
-- Table structure for temas
-- ----------------------------
DROP TABLE IF EXISTS `temas`;
CREATE TABLE `temas`  (
  `IdTema` int(10) NOT NULL AUTO_INCREMENT,
  `Tema` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `IdUsuario` int(10) NULL DEFAULT NULL,
  `Visibilidad` tinyint(1) NULL DEFAULT NULL,
  `FechaAlta` timestamp NULL DEFAULT current_timestamp(),
  `TemaPublico` tinyint(1) NULL DEFAULT NULL,
  `Observaciones` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IdTema`) USING BTREE,
  INDEX `IdUsuario`(`IdUsuario`) USING BTREE,
  CONSTRAINT `temas_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of temas
-- ----------------------------
INSERT INTO `temas` VALUES (1, 'Tema I', 1, 1, '2025-05-17 22:20:14', 1, 'Aprendizaje I');

-- ----------------------------
-- Table structure for tipo_foros
-- ----------------------------
DROP TABLE IF EXISTS `tipo_foros`;
CREATE TABLE `tipo_foros`  (
  `IdTipoForo` int(10) NOT NULL AUTO_INCREMENT,
  `TipoForo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IdTipoForo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_foros
-- ----------------------------
INSERT INTO `tipo_foros` VALUES (1, 'Foro tipo II');

-- ----------------------------
-- Table structure for tipo_usuario
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario`  (
  `IdTipoUsuario` int(10) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`IdTipoUsuario`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES (1, 'Administrador');
INSERT INTO `tipo_usuario` VALUES (2, 'General');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `NombreUsuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Correo` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `FechaAlta` timestamp NOT NULL DEFAULT current_timestamp(),
  `IdTipoUsuario` int(10) NULL DEFAULT NULL,
  `Password` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE INDEX `usuario`(`Usuario`) USING BTREE,
  INDEX `id_tipo_usuario`(`IdTipoUsuario`) USING BTREE,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`IdTipoUsuario`) REFERENCES `tipo_usuario` (`IdTipoUsuario`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_spanish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'administrador', 'administrador', 'administrador', '2013-02-18 23:00:15', 1, '91f5167c34c400758115c2a6826ec2e3');
INSERT INTO `usuarios` VALUES (2, 'alumno', 'alumno', 'alumno', '2013-02-18 23:00:15', 2, 'c6865cf98b133f1f3de596a4a2894630');
INSERT INTO `usuarios` VALUES (3, 'alumno 3', 'Alumno 3', 'alumno2@prueba.com', '2025-05-17 22:10:13', 2, 'd41d8cd98f00b204e9800998ecf8427e');

-- ----------------------------
-- Table structure for usuarios_grupos
-- ----------------------------
DROP TABLE IF EXISTS `usuarios_grupos`;
CREATE TABLE `usuarios_grupos`  (
  `IdUsuarioGrupo` int(10) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(10) NULL DEFAULT NULL,
  `IdGrupo` int(10) NULL DEFAULT NULL,
  PRIMARY KEY (`IdUsuarioGrupo`) USING BTREE,
  INDEX `IdUsuario`(`IdUsuario`) USING BTREE,
  INDEX `IdGrupo`(`IdGrupo`) USING BTREE,
  CONSTRAINT `usuarios_grupos_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `usuarios_grupos_ibfk_2` FOREIGN KEY (`IdGrupo`) REFERENCES `grupos` (`IdGrupo`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios_grupos
-- ----------------------------
INSERT INTO `usuarios_grupos` VALUES (1, 2, 1);

SET FOREIGN_KEY_CHECKS = 1;
