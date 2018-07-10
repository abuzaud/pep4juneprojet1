/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : sutekinabox

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-07-11 01:07:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for box
-- ----------------------------
DROP TABLE IF EXISTS `box`;
CREATE TABLE `box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `products` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:object)',
  `current_place` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of box
-- ----------------------------
INSERT INTO `box` VALUES ('1', 'box1', null, 'empty', '50');
INSERT INTO `box` VALUES ('2', 'box2', null, 'empty', '120');
INSERT INTO `box` VALUES ('3', 'box3', null, 'validation_box', '10');
INSERT INTO `box` VALUES ('4', 'box4', null, 'rejected_box', '30');
INSERT INTO `box` VALUES ('5', 'box5', null, 'ok_box', '200');
INSERT INTO `box` VALUES ('6', 'box6', null, 'desc_box', '75');
INSERT INTO `box` VALUES ('7', 'box7', null, 'add_products_box', '30');

-- ----------------------------
-- Table structure for migration_versions
-- ----------------------------
DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migration_versions
-- ----------------------------
INSERT INTO `migration_versions` VALUES ('20180709143121');
INSERT INTO `migration_versions` VALUES ('20180710075548');
INSERT INTO `migration_versions` VALUES ('20180710105703');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES ('1', 'fournisseur_1', '1');
INSERT INTO `supplier` VALUES ('2', 'fournisseur_2', '1');
INSERT INTO `supplier` VALUES ('3', 'fournisseur_3', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifications` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  `registration_date` datetime NOT NULL,
  `last_connection_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Antoine', 'Buzaud', 'antoine.buzaud@gmail.com', 'a:1:{i:0;s:9:\"ROLE_ADMIN\";}', '$2y$13$B8sOmcbiHUyYZTjW9ng9n.qXcYd9WTceobWyMVZnwKj9qkfONy1SO', 'N;', '2018-07-10 22:58:40', null);
INSERT INTO `user` VALUES ('2', 'Test', 'TestLast', 'test@test.com', 'a:1:{i:0;s:9:\"ROLE_USER\";}', '$2y$13$JePc/XeeV8muaM7cP8tQCeK.LK5qCNgarlQY7oB/qFdcMfEsAVu9K', 'N;', '2018-07-10 22:59:11', null);
