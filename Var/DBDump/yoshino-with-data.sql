/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : yoshino

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 09/02/2018 16:54:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for yoshino_player
-- ----------------------------
DROP TABLE IF EXISTS `yoshino_player`;
CREATE TABLE `yoshino_player`  (
  `pid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `player` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id` int(11) DEFAULT NULL,
  `skin` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `slim` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `cape` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `last_modified` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`pid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 26 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yoshino_player
-- ----------------------------
INSERT INTO `yoshino_player` VALUES (24, '1234', 1234, NULL, NULL, NULL, 0);
INSERT INTO `yoshino_player` VALUES (22, '12345', 1234, NULL, NULL, NULL, 0);
INSERT INTO `yoshino_player` VALUES (23, 'dawn1', 12342, NULL, NULL, NULL, 0);
INSERT INTO `yoshino_player` VALUES (25, 'dawn', 1234, NULL, NULL, NULL, 0);

-- ----------------------------
-- Table structure for yoshino_texture
-- ----------------------------
DROP TABLE IF EXISTS `yoshino_texture`;
CREATE TABLE `yoshino_texture`  (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`tid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yoshino_user
-- ----------------------------
DROP TABLE IF EXISTS `yoshino_user`;
CREATE TABLE `yoshino_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 12344 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of yoshino_user
-- ----------------------------
INSERT INTO `yoshino_user` VALUES (1234, 'dawn', 'c8b252971fa6db33766e0aac866d331d7dacec0680fb27f0897ab04d18565151', 'JzsGKIkclIqAlxNbRKwPu0QSzqzR1cTfJlQlj0UjIesdUwvKYia1JpDLuKUjOr02Wk39PgYPq95H64eaSt45lEUa1KFhUkyw3IP0Ofv2PD21cz2qQFdlF061CliBWfzO', 'i@emiria.moe');
INSERT INTO `yoshino_user` VALUES (12343, 'dawn2', 'c8b252971fa6db33766e0aac866d331d7dacec0680fb27f0897ab04d18565151', 'pfeKawQopfbo9LwhYdgSSENfEr4ya9s9uI58h2mxd6HI7pbQn9pfrIZkMT2Pnz8vWg8sW1doJmyrHz7829YzAJhrLYOHQhYDFs0908LaAi8AaJ80BtqCefaou8bYjcmr', 'i@98.com');
INSERT INTO `yoshino_user` VALUES (12342, 'dawn1', 'c8b252971fa6db33766e0aac866d331d7dacec0680fb27f0897ab04d18565151', '0NKBB2iSJOz3GMxWKuxMsYgXhCB4MZSGgHHJ1bDN7a2yNSihqQQPid74XrO2iiGQwacFIlhNpxu4Q6SFkhKCebKUcjtN7MLQjUhxxhf1iY1D27sPFpBi4KMVXHtRTLn8', 'i@123.com');

SET FOREIGN_KEY_CHECKS = 1;