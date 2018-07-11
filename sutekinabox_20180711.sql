/*
Navicat MySQL Data Transfer

Source Server         : locahost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : sutekinabox

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-07-11 17:59:24
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
  `budget` double NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of box
-- ----------------------------
INSERT INTO `box` VALUES ('1', 'box1', null, 'desc_incomplete', '10', null, 'REF_BOX_1');
INSERT INTO `box` VALUES ('2', 'box2-test', null, 'empty', '10', null, null);
INSERT INTO `box` VALUES ('3', 'box3', null, 'desc_complete', '10', 'Andouille tri-tip leberkas tail ribeye kielbasa, ham hock burgdoggen. T-bone ball tip strip steak pancetta flank alcatra biltong spare ribs leberkas hamburger brisket. Meatloaf biltong buffalo spare ribs sirloin, frankfurter beef tongue. ', 'REF_BOX_3');
INSERT INTO `box` VALUES ('4', 'box4', null, 'desc_complete', '30', 'Kielbasa andouille corned beef, burgdoggen ball tip short ribs spare ribs fatback beef ribs alcatra shankle. Venison pig porchetta jowl, brisket turkey meatball capicola flank alcatra. Pork chop short ribs ground round bresaola beef ribs salami pancetta. ', 'REF_BOX_4');
INSERT INTO `box` VALUES ('5', 'box5', null, 'ok_box', '200', 'Beef ribs burgdoggen brisket alcatra chicken tail pig, short loin rump pork pancetta bresaola andouille jowl drumstick. Shankle prosciutto jowl, short loin shank pork loin meatball salami cupim swine pork hamburger.', 'REF_BOX_5');
INSERT INTO `box` VALUES ('6', 'box6', null, 'desc_incomplete', '75', 'Meatball ham beef ribs, shoulder capicola tail pastrami andouille ground round. Ball tip rump pork loin prosciutto, hamburger fatback filet mignon porchetta corned beef tenderloin buffalo beef ribs sirloin. ', '');
INSERT INTO `box` VALUES ('14', 'box2-test', 'N;', 'desc_complete', '99', 'Test d\'ajout d\'une box 2', 'GR4886987');
INSERT INTO `box` VALUES ('15', 'Box 999', 'N;', 'desc_incomplete', '99', null, null);
INSERT INTO `box` VALUES ('16', 'Box998', 'N;', 'products_incomplete', '75.45', null, null);
INSERT INTO `box` VALUES ('18', 'Box1524', 'N;', 'products_complete', '85.65', null, null);
INSERT INTO `box` VALUES ('19', 'Box1525', 'N;', 'validation_box', '95', 'BLABLABLABNLA', null);
INSERT INTO `box` VALUES ('20', 'Box1528', 'N;', 'desc_complete', '95.48', 'sfsfgsdfsdfdsf', 'frgdsgedhrgetdfhg');

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
INSERT INTO `migration_versions` VALUES ('20180711092624');
INSERT INTO `migration_versions` VALUES ('20180711124240');
INSERT INTO `migration_versions` VALUES ('20180711124732');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` int(11) NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'product_1', '1', 'Spicy jalapeno bacon ipsum dolor amet pork belly filet mignon pig prosciutto turkey. Hamburger landjaeger pork loin tenderloin, alcatra spare ribs drumstick cupim andouille strip steak. Ground round frankfurter pork tenderloin, beef meatloaf turkey t-bone shankle beef ribs tail chuck biltong spare ribs.', 'X5-41-X94');
INSERT INTO `product` VALUES ('2', 'product_2', '1', ' Venison kevin ribeye, biltong ham leberkas buffalo brisket tri-tip flank beef picanha. Shankle alcatra pancetta filet mignon turducken prosciutto kielbasa swine beef ribs kevin beef hamburger sirloin. Pork porchetta shank hamburger doner spare ribs swine beef ribs prosciutto sausage.', 'XDFDZ5-45D65d-DF');
INSERT INTO `product` VALUES ('3', 'product_3', '2', 'Ham hock tail shank, tongue prosciutto salami ham spare ribs capicola turkey rump kielbasa chuck frankfurter corned beef. T-bone ribeye shank flank short loin biltong salami jerky pancetta ball tip cow.', 'DFSD-D865-D');
INSERT INTO `product` VALUES ('4', 'product_4', '1', 'Meatloaf strip steak fatback hamburger frankfurter kevin. Ground round hamburger ball tip burgdoggen tongue. Kielbasa turkey ham cupim tri-tip andouille ham hock ground round pastrami ribeye. ', 'DEDF4868451');
INSERT INTO `product` VALUES ('5', 'product_5', '2', 'Biltong pancetta venison turkey drumstick meatloaf burgdoggen shoulder kielbasa buffalo pork chop short loin flank pork loin. Kevin shoulder cow salami pastrami drumstick pork belly. Short loin ground round spare ribs ham hock, shoulder leberkas brisket swine salami. ', 'SDFE57846923');

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
INSERT INTO `user` VALUES ('1', 'Antoine', 'Buzaud', 'antoine.buzaud@gmail.com', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '$2y$13$B8sOmcbiHUyYZTjW9ng9n.qXcYd9WTceobWyMVZnwKj9qkfONy1SO', 'N;', '2018-07-10 22:58:40', null);
INSERT INTO `user` VALUES ('2', 'Test', 'TestLast', 'test@test.com', 'a:1:{i:0;s:7:\"ROLE_PM\";}', '$2y$13$JePc/XeeV8muaM7cP8tQCeK.LK5qCNgarlQY7oB/qFdcMfEsAVu9K', 'N;', '2018-07-10 22:59:11', null);
