/*
Navicat MySQL Data Transfer

Source Server         : LocalEarms
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : omslive

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2018-03-30 09:37:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `login`
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `user_Id` bigint(25) NOT NULL AUTO_INCREMENT,
  `user_Name` varchar(25) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `companyId` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `userRights` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `createdTimeStamp` timestamp NULL DEFAULT NULL,
  `updatedTeimStamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `activeFlag` int(1) DEFAULT NULL,
  `gstType` int(2) DEFAULT NULL,
  PRIMARY KEY (`user_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('1', 'admin', 'admin', '1', '1', null, '2017-07-19 11:56:10', '1', '1');
INSERT INTO `login` VALUES ('2', 'admin', 'admin', '2', '1', null, '2017-08-05 17:41:34', '1', '1');
INSERT INTO `login` VALUES ('3', 'admin', 'admin', '3', '1', null, '2017-08-05 17:41:40', '1', '1');
INSERT INTO `login` VALUES ('4', 'bill', 'bill', '1', '2', null, null, '1', '1');
INSERT INTO `login` VALUES ('5', 'bill', 'bill', '2', '2', null, '2017-08-10 18:23:40', '1', '1');
INSERT INTO `login` VALUES ('6', 'bill', 'bill', '3', '2', null, '2017-08-10 18:23:51', '1', '1');
INSERT INTO `login` VALUES ('7', 'admin', 'admin', '4', '1', null, null, '1', '1');
INSERT INTO `login` VALUES ('8', 'bill', 'bill', '4', '2', null, null, '1', '1');

-- ----------------------------
-- Table structure for `salesbillprefix`
-- ----------------------------
DROP TABLE IF EXISTS `salesbillprefix`;
CREATE TABLE `salesbillprefix` (
  `salesBillPrefixId` double(20,0) NOT NULL DEFAULT '0',
  `companyRefId` double(20,0) DEFAULT NULL,
  `accountYearRefId` double(20,0) DEFAULT NULL,
  `salesBillPrefixValue` varchar(20) DEFAULT NULL,
  `salesBillDigit` int(2) DEFAULT NULL,
  `gstType` int(2) DEFAULT NULL,
  PRIMARY KEY (`salesBillPrefixId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of salesbillprefix
-- ----------------------------
INSERT INTO `salesbillprefix` VALUES ('1', '1', '1', null, '4', '1');
INSERT INTO `salesbillprefix` VALUES ('2', '1', '1', null, '4', '2');
INSERT INTO `salesbillprefix` VALUES ('3', '2', '1', null, '4', '1');
INSERT INTO `salesbillprefix` VALUES ('4', '2', '1', null, '4', '2');
INSERT INTO `salesbillprefix` VALUES ('5', '3', '1', null, '4', '1');
INSERT INTO `salesbillprefix` VALUES ('6', '3', '1', null, '4', '2');
INSERT INTO `salesbillprefix` VALUES ('7', '4', '1', null, '4', '1');
INSERT INTO `salesbillprefix` VALUES ('8', '4', '1', null, '4', '2');
INSERT INTO `salesbillprefix` VALUES ('9', '1', '2', '', '4', '1');
INSERT INTO `salesbillprefix` VALUES ('10', '1', '2', '', '4', '2');
INSERT INTO `salesbillprefix` VALUES ('11', '2', '2', '', '4', '1');
INSERT INTO `salesbillprefix` VALUES ('12', '2', '2', '', '4', '2');
INSERT INTO `salesbillprefix` VALUES ('13', '3', '2', '', '4', '1');
INSERT INTO `salesbillprefix` VALUES ('14', '3', '2', '', '4', '2');
INSERT INTO `salesbillprefix` VALUES ('15', '4', '2', '', '4', '1');
INSERT INTO `salesbillprefix` VALUES ('16', '4', '2', '', '4', '2');
