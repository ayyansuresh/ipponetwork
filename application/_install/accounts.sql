/*
Navicat MySQL Data Transfer

Source Server         : LocalEarms
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : accounts

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2017-10-20 12:55:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account`
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `accountId` bigint(20) NOT NULL auto_increment,
  `accountType` int(2) NOT NULL,
  `accountName` varchar(100) NOT NULL,
  `accountNumber` varchar(100) NOT NULL,
  `companyRefId` bigint(20) default NULL,
  `ifsCode` varchar(100) default NULL,
  `bankAccountType` varchar(100) default NULL,
  PRIMARY KEY  (`accountId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', '1', 'cash', 'cash', '1', 'cash', 'cash');
INSERT INTO `account` VALUES ('2', '2', 'test', 'test', '1', '1', '1');

-- ----------------------------
-- Table structure for `accountopeningbalance`
-- ----------------------------
DROP TABLE IF EXISTS `accountopeningbalance`;
CREATE TABLE `accountopeningbalance` (
  `accountTrialBalanceId` bigint(20) NOT NULL auto_increment,
  `accountRefId` bigint(20) NOT NULL,
  `OpeningBalance` double NOT NULL,
  `trialBalance` double NOT NULL,
  `closingBalance` double NOT NULL,
  `companyRefId` double(20,0) default NULL,
  `accountYearRefId` double(20,0) default NULL,
  PRIMARY KEY  (`accountTrialBalanceId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accountopeningbalance
-- ----------------------------
INSERT INTO `accountopeningbalance` VALUES ('1', '1', '0', '1183', '1183', '1', '1');
INSERT INTO `accountopeningbalance` VALUES ('2', '2', '0', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for `accounttransaction`
-- ----------------------------
DROP TABLE IF EXISTS `accounttransaction`;
CREATE TABLE `accounttransaction` (
  `accountTransactionId` bigint(20) NOT NULL auto_increment,
  `accountDate` date NOT NULL,
  `transactionType` int(2) NOT NULL,
  `accountRefId` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `mode` int(2) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `transactionDescription` text NOT NULL,
  `tableReference` double(20,0) NOT NULL,
  `tableDetailId` double(20,0) default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  PRIMARY KEY  (`accountTransactionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accounttransaction
-- ----------------------------

-- ----------------------------
-- Table structure for `accountyear`
-- ----------------------------
DROP TABLE IF EXISTS `accountyear`;
CREATE TABLE `accountyear` (
  `accountyear_id` int(5) NOT NULL auto_increment,
  `year` varchar(30) NOT NULL,
  PRIMARY KEY  (`accountyear_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accountyear
-- ----------------------------
INSERT INTO `accountyear` VALUES ('1', '2017-2018');

-- ----------------------------
-- Table structure for `bankdeposit`
-- ----------------------------
DROP TABLE IF EXISTS `bankdeposit`;
CREATE TABLE `bankdeposit` (
  `depositId` bigint(20) NOT NULL auto_increment,
  `depositDate` date default NULL,
  `depositMode` int(2) default NULL,
  `depositAmount` double default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  `createdBy` bigint(20) default NULL,
  `updatedBy` bigint(20) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `modeDescription` varchar(200) default NULL,
  `accountRefId` bigint(20) default NULL,
  PRIMARY KEY  (`depositId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bankdeposit
-- ----------------------------

-- ----------------------------
-- Table structure for `bankwithdrawal`
-- ----------------------------
DROP TABLE IF EXISTS `bankwithdrawal`;
CREATE TABLE `bankwithdrawal` (
  `withdrawalId` bigint(20) NOT NULL auto_increment,
  `withdrawalDate` date default NULL,
  `withdrawalMode` int(2) default NULL,
  `withdrawalAmount` double default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  `createdBy` bigint(20) default NULL,
  `updatedBy` bigint(20) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `modeDescription` varchar(200) default NULL,
  `accountRefId` bigint(20) default NULL,
  PRIMARY KEY  (`withdrawalId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of bankwithdrawal
-- ----------------------------

-- ----------------------------
-- Table structure for `city`
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `cityId` bigint(20) NOT NULL auto_increment,
  `cityName` varchar(200) default NULL,
  `stateRefId` bigint(20) default NULL,
  `activeFlag` int(1) default '1',
  PRIMARY KEY  (`cityId`),
  KEY `stateRefId` (`stateRefId`),
  CONSTRAINT `stateRefId` FOREIGN KEY (`stateRefId`) REFERENCES `state` (`stateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1431 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES ('1', 'CHENNAI', '31', '1');
INSERT INTO `city` VALUES ('2', 'SALAM', '31', '1');
INSERT INTO `city` VALUES ('3', 'THANJAVUR', '31', '1');
INSERT INTO `city` VALUES ('4', 'OOTY', '31', '1');
INSERT INTO `city` VALUES ('5', 'VELLORE', '31', '1');
INSERT INTO `city` VALUES ('6', 'TIRUNELVELI', '31', '1');
INSERT INTO `city` VALUES ('7', 'TIRUPPUR', '31', '1');
INSERT INTO `city` VALUES ('8', 'TIRUCHIRAPPALLI', '31', '1');
INSERT INTO `city` VALUES ('9', 'MADURAI', '31', '1');
INSERT INTO `city` VALUES ('10', 'COIMBATORE', '31', '1');
INSERT INTO `city` VALUES ('11', 'ERODE', '31', '1');
INSERT INTO `city` VALUES ('12', 'THOOTHUKUDI', '31', '1');
INSERT INTO `city` VALUES ('13', 'NAGARKOVIL', '31', '1');
INSERT INTO `city` VALUES ('14', 'DINDIKUL', '31', '1');
INSERT INTO `city` VALUES ('15', 'CUDDALORE', '31', '1');
INSERT INTO `city` VALUES ('16', 'KANCHIPURAM', '31', '1');
INSERT INTO `city` VALUES ('17', 'TIRUVANNAMALAI', '31', '1');
INSERT INTO `city` VALUES ('18', 'KUMBAKONAM', '31', '1');
INSERT INTO `city` VALUES ('19', 'RAJAPALAYAM', '31', '1');
INSERT INTO `city` VALUES ('20', 'PUDUKOTTAI', '31', '1');
INSERT INTO `city` VALUES ('21', 'HOSUR', '31', '1');
INSERT INTO `city` VALUES ('22', 'AMBUR', '31', '1');
INSERT INTO `city` VALUES ('23', 'KARAIKKUDI', '31', '1');
INSERT INTO `city` VALUES ('24', 'NEYVELI', '31', '1');
INSERT INTO `city` VALUES ('25', 'NAGAPATTINAM', '31', '1');
INSERT INTO `city` VALUES ('26', 'RAMAESVARAM', '31', '1');
INSERT INTO `city` VALUES ('27', 'POLLACHI', '31', '1');
INSERT INTO `city` VALUES ('28', 'VIRUDHUNAGAR', '31', '1');
INSERT INTO `city` VALUES ('29', 'ARAKONAM', '31', '1');
INSERT INTO `city` VALUES ('30', 'TIRUCHENGODE', '31', '1');
INSERT INTO `city` VALUES ('31', 'MAYILADUDUTHURAI', '31', '1');
INSERT INTO `city` VALUES ('32', 'SIVAKASI', '31', '1');
INSERT INTO `city` VALUES ('33', 'PATTUKOTTAI', '31', '1');
INSERT INTO `city` VALUES ('34', 'PALANI', '31', '1');
INSERT INTO `city` VALUES ('35', 'VANNIYAMPADI', '31', '1');
INSERT INTO `city` VALUES ('36', 'THIRUTTANI', '31', '1');
INSERT INTO `city` VALUES ('37', 'METTUPALAYAM', '31', '1');
INSERT INTO `city` VALUES ('38', 'EDAPPADI', '31', '1');
INSERT INTO `city` VALUES ('39', 'TINDIVANAM', '31', '1');
INSERT INTO `city` VALUES ('40', 'ARANI', '31', '1');
INSERT INTO `city` VALUES ('41', 'PARAMAKUDI', '31', '1');
INSERT INTO `city` VALUES ('42', 'SATTUR', '31', '1');
INSERT INTO `city` VALUES ('43', 'ARRUPPUKOTTAI', '31', '1');
INSERT INTO `city` VALUES ('44', 'RAMANATHAPURAM', '31', '1');
INSERT INTO `city` VALUES ('45', 'VILATHIKULAM', '31', '1');
INSERT INTO `city` VALUES ('46', 'Thiruvananthapuram', '18', '1');
INSERT INTO `city` VALUES ('47', 'Kochi', '18', '1');
INSERT INTO `city` VALUES ('48', 'Kozhikode', '18', '1');
INSERT INTO `city` VALUES ('49', 'Quilon', '18', '1');
INSERT INTO `city` VALUES ('50', 'Trichur', '18', '1');
INSERT INTO `city` VALUES ('51', 'Alappuzha', '18', '1');
INSERT INTO `city` VALUES ('52', 'Palakkad', '18', '1');
INSERT INTO `city` VALUES ('53', 'Malappuram', '18', '1');
INSERT INTO `city` VALUES ('54', 'Manjeri', '18', '1');
INSERT INTO `city` VALUES ('55', 'Tellicherry', '18', '1');
INSERT INTO `city` VALUES ('56', 'Ponnani', '18', '1');
INSERT INTO `city` VALUES ('57', 'Vatakara', '18', '1');
INSERT INTO `city` VALUES ('58', 'Kanhangad', '18', '1');
INSERT INTO `city` VALUES ('59', 'Taliparamba', '18', '1');
INSERT INTO `city` VALUES ('60', 'Payyanur', '18', '1');
INSERT INTO `city` VALUES ('61', 'Koyilandy', '18', '1');
INSERT INTO `city` VALUES ('62', 'Neyyattinkara', '18', '1');
INSERT INTO `city` VALUES ('63', 'Beypore', '18', '1');
INSERT INTO `city` VALUES ('64', 'Kayamkulam', '18', '1');
INSERT INTO `city` VALUES ('65', 'Kannur', '18', '1');
INSERT INTO `city` VALUES ('66', 'Nedumangad', '18', '1');
INSERT INTO `city` VALUES ('67', 'Tirurangadi', '18', '1');
INSERT INTO `city` VALUES ('68', 'Tirur', '18', '1');
INSERT INTO `city` VALUES ('69', 'Kottayam', '18', '1');
INSERT INTO `city` VALUES ('70', 'Nileshwaram', '18', '1');
INSERT INTO `city` VALUES ('71', 'Kasaragod', '18', '1');
INSERT INTO `city` VALUES ('72', 'Kunnamkulam', '18', '1');
INSERT INTO `city` VALUES ('73', 'Ottappalam', '18', '1');
INSERT INTO `city` VALUES ('74', 'Tiruvalla', '18', '1');
INSERT INTO `city` VALUES ('75', 'Adoor', '18', '1');
INSERT INTO `city` VALUES ('76', 'Perinthalmanna', '18', '1');
INSERT INTO `city` VALUES ('77', 'Chalakkudy', '18', '1');
INSERT INTO `city` VALUES ('78', 'Mattanur', '18', '1');
INSERT INTO `city` VALUES ('79', 'Punalur', '18', '1');
INSERT INTO `city` VALUES ('80', 'Kottarakara', '18', '1');
INSERT INTO `city` VALUES ('81', 'Cherthala', '18', '1');
INSERT INTO `city` VALUES ('82', 'Maradu', '18', '1');
INSERT INTO `city` VALUES ('83', 'Kottakkal', '18', '1');
INSERT INTO `city` VALUES ('84', 'Shornur', '18', '1');
INSERT INTO `city` VALUES ('85', 'Kattappana', '18', '1');
INSERT INTO `city` VALUES ('86', 'Manjeshwaram', '18', '1');
INSERT INTO `city` VALUES ('87', 'Uppala', '18', '1');
INSERT INTO `city` VALUES ('88', 'Pandalam', '18', '1');
INSERT INTO `city` VALUES ('89', 'Varkala', '18', '1');
INSERT INTO `city` VALUES ('90', 'Chavakkad', '18', '1');
INSERT INTO `city` VALUES ('91', 'Mananthavady', '18', '1');
INSERT INTO `city` VALUES ('92', 'Pathanamthitta', '18', '1');
INSERT INTO `city` VALUES ('93', 'Attingal', '18', '1');
INSERT INTO `city` VALUES ('94', 'Paravur', '18', '1');
INSERT INTO `city` VALUES ('95', 'Ramanattukara', '18', '1');
INSERT INTO `city` VALUES ('96', 'Kalamassery', '18', '1');
INSERT INTO `city` VALUES ('97', 'Guwahati', '4', '1');
INSERT INTO `city` VALUES ('98', 'Silchar', '4', '1');
INSERT INTO `city` VALUES ('99', 'Dibrugarh', '4', '1');
INSERT INTO `city` VALUES ('100', 'Jorhat', '4', '1');
INSERT INTO `city` VALUES ('101', 'Nagaon', '4', '1');
INSERT INTO `city` VALUES ('102', 'Tinsukia', '4', '1');
INSERT INTO `city` VALUES ('103', 'Tezpur', '4', '1');
INSERT INTO `city` VALUES ('104', 'Bongaigaon', '4', '1');
INSERT INTO `city` VALUES ('105', 'Karimganj', '4', '1');
INSERT INTO `city` VALUES ('106', 'Dhubri', '4', '1');
INSERT INTO `city` VALUES ('107', 'Diphu', '4', '1');
INSERT INTO `city` VALUES ('108', 'Northlakhimpur', '4', '1');
INSERT INTO `city` VALUES ('109', 'Lumding', '4', '1');
INSERT INTO `city` VALUES ('110', 'Goalpara', '4', '1');
INSERT INTO `city` VALUES ('111', 'Sibsagar', '4', '1');
INSERT INTO `city` VALUES ('112', 'Haflong', '4', '1');
INSERT INTO `city` VALUES ('113', 'Barpeta', '4', '1');
INSERT INTO `city` VALUES ('114', 'Golaghat', '4', '1');
INSERT INTO `city` VALUES ('115', 'Bilasipara', '4', '1');
INSERT INTO `city` VALUES ('116', 'Lanka', '4', '1');
INSERT INTO `city` VALUES ('117', 'Hojai', '4', '1');
INSERT INTO `city` VALUES ('118', 'Barpetaroad', '4', '1');
INSERT INTO `city` VALUES ('119', 'Digboi', '4', '1');
INSERT INTO `city` VALUES ('120', 'Kokrajhar', '4', '1');
INSERT INTO `city` VALUES ('121', 'Hailakandi', '4', '1');
INSERT INTO `city` VALUES ('122', 'berdeen', '1', '1');
INSERT INTO `city` VALUES ('123', 'Alipur', '1', '1');
INSERT INTO `city` VALUES ('124', 'Anowa', '1', '1');
INSERT INTO `city` VALUES ('125', 'Arainjlakapunga', '1', '1');
INSERT INTO `city` VALUES ('126', 'Arong', '1', '1');
INSERT INTO `city` VALUES ('127', 'Austinabad', '1', '1');
INSERT INTO `city` VALUES ('128', 'Bambooflat', '1', '1');
INSERT INTO `city` VALUES ('129', 'Bambooflat', '1', '1');
INSERT INTO `city` VALUES ('130', 'Bananga', '1', '1');
INSERT INTO `city` VALUES ('131', 'Beadonabad', '1', '1');
INSERT INTO `city` VALUES ('132', 'Bengala', '1', '1');
INSERT INTO `city` VALUES ('133', 'Betapur', '1', '1');
INSERT INTO `city` VALUES ('134', 'Bindraban', '1', '1');
INSERT INTO `city` VALUES ('135', 'Birchganj', '1', '1');
INSERT INTO `city` VALUES ('136', 'Bonington', '1', '1');
INSERT INTO `city` VALUES ('137', 'Brookesabad', '1', '1');
INSERT INTO `city` VALUES ('138', 'Bumlitan', '1', '1');
INSERT INTO `city` VALUES ('139', 'Bajajag', '1', '1');
INSERT INTO `city` VALUES ('140', 'Calicut', '1', '1');
INSERT INTO `city` VALUES ('141', 'Chanumia', '1', '1');
INSERT INTO `city` VALUES ('142', 'Chanumla', '1', '1');
INSERT INTO `city` VALUES ('143', 'Chetamale', '1', '1');
INSERT INTO `city` VALUES ('144', 'Chingenh', '1', '1');
INSERT INTO `city` VALUES ('145', 'Dakomkeh', '1', '1');
INSERT INTO `city` VALUES ('146', 'Dakomkel', '1', '1');
INSERT INTO `city` VALUES ('147', 'Diglipur', '1', '1');
INSERT INTO `city` VALUES ('148', 'Ditdak', '1', '1');
INSERT INTO `city` VALUES ('149', 'Dolyganj', '1', '1');
INSERT INTO `city` VALUES ('150', 'Dakoank', '1', '1');
INSERT INTO `city` VALUES ('151', 'Endeageleda', '1', '1');
INSERT INTO `city` VALUES ('152', 'Enfak', '1', '1');
INSERT INTO `city` VALUES ('153', 'Enounga', '1', '1');
INSERT INTO `city` VALUES ('154', 'Eoya', '1', '1');
INSERT INTO `city` VALUES ('155', 'Garacharma', '1', '1');
INSERT INTO `city` VALUES ('156', 'Garacherama', '1', '1');
INSERT INTO `city` VALUES ('157', 'Geinyale', '1', '1');
INSERT INTO `city` VALUES ('158', 'Goplakabang', '1', '1');
INSERT INTO `city` VALUES ('159', 'Haddo', '1', '1');
INSERT INTO `city` VALUES ('160', 'Haoin', '1', '1');
INSERT INTO `city` VALUES ('161', 'Hastmatabad', '1', '1');
INSERT INTO `city` VALUES ('162', 'Henhoaha', '1', '1');
INSERT INTO `city` VALUES ('163', 'Henoaha', '1', '1');
INSERT INTO `city` VALUES ('164', 'Henpoin', '1', '1');
INSERT INTO `city` VALUES ('165', 'Heoin', '1', '1');
INSERT INTO `city` VALUES ('166', 'Herberiabad', '1', '1');
INSERT INTO `city` VALUES ('167', 'Herbertabad', '1', '1');
INSERT INTO `city` VALUES ('168', 'Heya', '1', '1');
INSERT INTO `city` VALUES ('169', 'Hinam', '1', '1');
INSERT INTO `city` VALUES ('170', 'Hobdaypur', '1', '1');
INSERT INTO `city` VALUES ('171', 'Homfrayganj', '1', '1');
INSERT INTO `city` VALUES ('172', 'Hope Town', '1', '1');
INSERT INTO `city` VALUES ('173', 'Ignoitijala', '1', '1');
INSERT INTO `city` VALUES ('174', 'Ilichar', '1', '1');
INSERT INTO `city` VALUES ('175', 'Inaka', '1', '1');
INSERT INTO `city` VALUES ('176', 'Ingoie', '1', '1');
INSERT INTO `city` VALUES ('177', 'Ingoitijala', '1', '1');
INSERT INTO `city` VALUES ('178', 'Jalebar', '1', '1');
INSERT INTO `city` VALUES ('179', 'Janglighat', '1', '1');
INSERT INTO `city` VALUES ('180', 'Janglighat', '1', '1');
INSERT INTO `city` VALUES ('181', 'Kanalla', '1', '1');
INSERT INTO `city` VALUES ('182', 'Karen', '1', '1');
INSERT INTO `city` VALUES ('183', 'Karenvillage', '1', '1');
INSERT INTO `city` VALUES ('184', 'Kartara', '1', '1');
INSERT INTO `city` VALUES ('185', 'Keaiya', '1', '1');
INSERT INTO `city` VALUES ('186', 'Keaiya', '1', '1');
INSERT INTO `city` VALUES ('187', 'Kemios', '1', '1');
INSERT INTO `city` VALUES ('188', 'Kerawa', '1', '1');
INSERT INTO `city` VALUES ('189', 'Kimus', '1', '1');
INSERT INTO `city` VALUES ('190', 'Kirehenpoan', '1', '1');
INSERT INTO `city` VALUES ('191', 'Koihoa', '1', '1');
INSERT INTO `city` VALUES ('192', 'Koimekeah', '1', '1');
INSERT INTO `city` VALUES ('193', 'Kolarue', '1', '1');
INSERT INTO `city` VALUES ('194', 'Kwachengui', '1', '1');
INSERT INTO `city` VALUES ('195', 'Kwatetukwage', '1', '1');
INSERT INTO `city` VALUES ('196', 'Kakana', '1', '1');
INSERT INTO `city` VALUES ('197', 'Laful', '1', '1');
INSERT INTO `city` VALUES ('198', 'Laksi', '1', '1');
INSERT INTO `city` VALUES ('199', 'Lapate', '1', '1');
INSERT INTO `city` VALUES ('200', 'Lopate', '1', '1');
INSERT INTO `city` VALUES ('201', 'Maimyo', '1', '1');
INSERT INTO `city` VALUES ('202', 'Maitaitaanla', '1', '1');
INSERT INTO `city` VALUES ('203', 'Malacca', '1', '1');
INSERT INTO `city` VALUES ('204', 'Malappuram', '1', '1');
INSERT INTO `city` VALUES ('205', 'Manglutan', '1', '1');
INSERT INTO `city` VALUES ('206', 'Manjeri', '1', '1');
INSERT INTO `city` VALUES ('207', 'Mannarghat', '1', '1');
INSERT INTO `city` VALUES ('208', 'Manpur', '1', '1');
INSERT INTO `city` VALUES ('209', 'Maru', '1', '1');
INSERT INTO `city` VALUES ('210', 'Mataitanla', '1', '1');
INSERT INTO `city` VALUES ('211', 'Mathura', '1', '1');
INSERT INTO `city` VALUES ('212', 'Mattaitahoe', '1', '1');
INSERT INTO `city` VALUES ('213', 'Mithakhari', '1', '1');
INSERT INTO `city` VALUES ('214', 'Mohean', '1', '1');
INSERT INTO `city` VALUES ('215', 'Moshoit', '1', '1');
INSERT INTO `city` VALUES ('216', 'Mus', '1', '1');
INSERT INTO `city` VALUES ('217', 'Mayabandar', '1', '1');
INSERT INTO `city` VALUES ('218', 'Nachuge', '1', '1');
INSERT INTO `city` VALUES ('219', 'Namunaghar', '1', '1');
INSERT INTO `city` VALUES ('220', 'Oalhetaih', '1', '1');
INSERT INTO `city` VALUES ('221', 'Oallorong', '1', '1');
INSERT INTO `city` VALUES ('222', 'Obate', '1', '1');
INSERT INTO `city` VALUES ('223', 'Oelhetaih', '1', '1');
INSERT INTO `city` VALUES ('224', 'Ogechai', '1', '1');
INSERT INTO `city` VALUES ('225', 'Okchauka', '1', '1');
INSERT INTO `city` VALUES ('226', 'Olenchi', '1', '1');
INSERT INTO `city` VALUES ('227', 'Oukchaung', '1', '1');
INSERT INTO `city` VALUES ('228', 'Oukchong', '1', '1');
INSERT INTO `city` VALUES ('229', 'Pahiala', '1', '1');
INSERT INTO `city` VALUES ('230', 'Pahlagaon', '1', '1');
INSERT INTO `city` VALUES ('231', 'Pahua', '1', '1');
INSERT INTO `city` VALUES ('232', 'Palalankwe', '1', '1');
INSERT INTO `city` VALUES ('233', 'Passa', '1', '1');
INSERT INTO `city` VALUES ('234', 'Patau', '1', '1');
INSERT INTO `city` VALUES ('235', 'Patua', '1', '1');
INSERT INTO `city` VALUES ('236', 'Perka', '1', '1');
INSERT INTO `city` VALUES ('237', 'Phaiapong', '1', '1');
INSERT INTO `city` VALUES ('238', 'Poshat', '1', '1');
INSERT INTO `city` VALUES ('239', 'Portblair', '1', '1');
INSERT INTO `city` VALUES ('240', 'Portbleras', '1', '1');
INSERT INTO `city` VALUES ('241', 'Portusblairensis', '1', '1');
INSERT INTO `city` VALUES ('242', 'Poshat', '1', '1');
INSERT INTO `city` VALUES ('243', 'Protheroepu', '1', '1');
INSERT INTO `city` VALUES ('244', 'Protheroepur', '1', '1');
INSERT INTO `city` VALUES ('245', 'Pulo Bakka', '1', '1');
INSERT INTO `city` VALUES ('246', 'Pulo Kunji', '1', '1');
INSERT INTO `city` VALUES ('247', 'Poahat', '1', '1');
INSERT INTO `city` VALUES ('248', 'Rangachang', '1', '1');
INSERT INTO `city` VALUES ('249', 'Rongat', '1', '1');
INSERT INTO `city` VALUES ('250', 'Sabari', '1', '1');
INSERT INTO `city` VALUES ('251', 'Sanenya', '1', '1');
INSERT INTO `city` VALUES ('252', 'Sawai', '1', '1');
INSERT INTO `city` VALUES ('253', 'Shadipur', '1', '1');
INSERT INTO `city` VALUES ('254', 'Shake', '1', '1');
INSERT INTO `city` VALUES ('255', 'Stewartganj', '1', '1');
INSERT INTO `city` VALUES ('256', 'Sawi', '1', '1');
INSERT INTO `city` VALUES ('257', 'Tabiag', '1', '1');
INSERT INTO `city` VALUES ('258', 'Tabiag', '1', '1');
INSERT INTO `city` VALUES ('259', 'Tafwap', '1', '1');
INSERT INTO `city` VALUES ('260', 'Takaroait', '1', '1');
INSERT INTO `city` VALUES ('261', 'Talarom', '1', '1');
INSERT INTO `city` VALUES ('262', 'Talaram', '1', '1');
INSERT INTO `city` VALUES ('263', 'Tamala', '1', '1');
INSERT INTO `city` VALUES ('264', 'Tamalco', '1', '1');
INSERT INTO `city` VALUES ('265', 'Tamalu', '1', '1');
INSERT INTO `city` VALUES ('266', 'Tambeebui', '1', '1');
INSERT INTO `city` VALUES ('267', 'Tapivang', '1', '1');
INSERT INTO `city` VALUES ('268', 'Tapuye', '1', '1');
INSERT INTO `city` VALUES ('269', 'Tapiyang', '1', '1');
INSERT INTO `city` VALUES ('270', 'Taylerabad', '1', '1');
INSERT INTO `city` VALUES ('271', 'Temain', '1', '1');
INSERT INTO `city` VALUES ('272', 'Tenlaa', '1', '1');
INSERT INTO `city` VALUES ('273', 'Thaiapong', '1', '1');
INSERT INTO `city` VALUES ('274', 'Tiden', '1', '1');
INSERT INTO `city` VALUES ('275', 'Titaije', '1', '1');
INSERT INTO `city` VALUES ('276', 'Titaiji', '1', '1');
INSERT INTO `city` VALUES ('277', 'Tochangedu', '1', '1');
INSERT INTO `city` VALUES ('278', 'Toibalawe', '1', '1');
INSERT INTO `city` VALUES ('279', 'Toibalewe', '1', '1');
INSERT INTO `city` VALUES ('280', 'Toinyugeda', '1', '1');
INSERT INTO `city` VALUES ('281', 'Tusonabad', '1', '1');
INSERT INTO `city` VALUES ('282', 'Taeangha', '1', '1');
INSERT INTO `city` VALUES ('283', 'Urekka ', '1', '1');
INSERT INTO `city` VALUES ('284', 'Wimberleyganj', '1', '1');
INSERT INTO `city` VALUES ('285', 'Wrightmyo', '1', '1');
INSERT INTO `city` VALUES ('286', 'Yatkirana', '1', '1');
INSERT INTO `city` VALUES ('287', 'Yadita', '1', '1');
INSERT INTO `city` VALUES ('288', 'Visakhapatnam', '2', '1');
INSERT INTO `city` VALUES ('289', 'Vijayawada', '2', '1');
INSERT INTO `city` VALUES ('290', 'Guntur', '2', '1');
INSERT INTO `city` VALUES ('291', 'Nellore', '2', '1');
INSERT INTO `city` VALUES ('292', 'Kurnool', '2', '1');
INSERT INTO `city` VALUES ('293', 'Kadapa', '2', '1');
INSERT INTO `city` VALUES ('294', 'Rajahmundry', '2', '1');
INSERT INTO `city` VALUES ('295', 'Kakinada', '2', '1');
INSERT INTO `city` VALUES ('296', 'Tirupati', '2', '1');
INSERT INTO `city` VALUES ('297', 'Anantapur', '2', '1');
INSERT INTO `city` VALUES ('298', 'Vizianagaram', '2', '1');
INSERT INTO `city` VALUES ('299', 'Eluru', '2', '1');
INSERT INTO `city` VALUES ('300', 'Ongole', '2', '1');
INSERT INTO `city` VALUES ('301', 'Nandyal', '2', '1');
INSERT INTO `city` VALUES ('302', 'Machilipatnam', '2', '1');
INSERT INTO `city` VALUES ('303', 'Adoni', '2', '1');
INSERT INTO `city` VALUES ('304', 'Tenali', '2', '1');
INSERT INTO `city` VALUES ('305', 'Proddatur', '2', '1');
INSERT INTO `city` VALUES ('306', 'Chittoor', '2', '1');
INSERT INTO `city` VALUES ('307', 'Hindupur', '2', '1');
INSERT INTO `city` VALUES ('308', 'Bhimavaram', '2', '1');
INSERT INTO `city` VALUES ('309', 'Madanapalle', '2', '1');
INSERT INTO `city` VALUES ('310', 'Guntakal', '2', '1');
INSERT INTO `city` VALUES ('311', 'Srikakulam', '2', '1');
INSERT INTO `city` VALUES ('312', 'Dharmavaram', '2', '1');
INSERT INTO `city` VALUES ('313', 'Rayachoti', '2', '1');
INSERT INTO `city` VALUES ('314', 'Gudivada', '2', '1');
INSERT INTO `city` VALUES ('315', 'Narasaraopet', '2', '1');
INSERT INTO `city` VALUES ('316', 'Tadipatri', '2', '1');
INSERT INTO `city` VALUES ('317', 'Tadepalligudem', '2', '1');
INSERT INTO `city` VALUES ('318', 'Amaravati ‡', '2', '1');
INSERT INTO `city` VALUES ('319', 'Chilakaluripet', '2', '1');
INSERT INTO `city` VALUES ('320', 'Acheshon', '3', '1');
INSERT INTO `city` VALUES ('321', 'Aholin', '3', '1');
INSERT INTO `city` VALUES ('322', 'Akolin', '3', '1');
INSERT INTO `city` VALUES ('323', 'Along', '3', '1');
INSERT INTO `city` VALUES ('324', 'Alonung', '3', '1');
INSERT INTO `city` VALUES ('325', 'Amatulla', '3', '1');
INSERT INTO `city` VALUES ('326', 'Amili', '3', '1');
INSERT INTO `city` VALUES ('327', 'Anelih', '3', '1');
INSERT INTO `city` VALUES ('328', 'Angatsi', '3', '1');
INSERT INTO `city` VALUES ('329', 'Apranli', '3', '1');
INSERT INTO `city` VALUES ('330', 'Aprunyi', '3', '1');
INSERT INTO `city` VALUES ('331', 'Ardai', '3', '1');
INSERT INTO `city` VALUES ('332', 'Aropu', '3', '1');
INSERT INTO `city` VALUES ('333', 'Ashalin', '3', '1');
INSERT INTO `city` VALUES ('334', 'Asonli', '3', '1');
INSERT INTO `city` VALUES ('335', 'Bacha', '3', '1');
INSERT INTO `city` VALUES ('336', 'Balek', '3', '1');
INSERT INTO `city` VALUES ('337', 'Balu', '3', '1');
INSERT INTO `city` VALUES ('338', 'Basar', '3', '1');
INSERT INTO `city` VALUES ('339', 'Bhalukpung', '3', '1');
INSERT INTO `city` VALUES ('340', 'Bindula', '3', '1');
INSERT INTO `city` VALUES ('341', 'Bini', '3', '1');
INSERT INTO `city` VALUES ('342', 'Bogu', '3', '1');
INSERT INTO `city` VALUES ('343', 'Bomak', '3', '1');
INSERT INTO `city` VALUES ('344', 'Bomdila', '3', '1');
INSERT INTO `city` VALUES ('345', 'Bomdo', '3', '1');
INSERT INTO `city` VALUES ('346', 'Bomjur', '3', '1');
INSERT INTO `city` VALUES ('347', 'Borduria', '3', '1');
INSERT INTO `city` VALUES ('348', 'Boru', '3', '1');
INSERT INTO `city` VALUES ('349', 'Brahmakund', '3', '1');
INSERT INTO `city` VALUES ('350', 'Bruini', '3', '1');
INSERT INTO `city` VALUES ('351', 'Budh', '3', '1');
INSERT INTO `city` VALUES ('352', 'Buha', '3', '1');
INSERT INTO `city` VALUES ('353', 'But', '3', '1');
INSERT INTO `city` VALUES ('354', 'Chalan', '3', '1');
INSERT INTO `city` VALUES ('355', 'Chameliang', '3', '1');
INSERT INTO `city` VALUES ('356', 'Changro', '3', '1');
INSERT INTO `city` VALUES ('357', 'Chantam', '3', '1');
INSERT INTO `city` VALUES ('358', 'Chareimna', '3', '1');
INSERT INTO `city` VALUES ('359', 'Chemgeng', '3', '1');
INSERT INTO `city` VALUES ('360', 'Chemir', '3', '1');
INSERT INTO `city` VALUES ('361', 'Chengele', '3', '1');
INSERT INTO `city` VALUES ('362', 'Chepwe', '3', '1');
INSERT INTO `city` VALUES ('363', 'Chhota Dirak', '3', '1');
INSERT INTO `city` VALUES ('364', 'Chibuni', '3', '1');
INSERT INTO `city` VALUES ('365', 'Chira', '3', '1');
INSERT INTO `city` VALUES ('366', 'Chodo', '3', '1');
INSERT INTO `city` VALUES ('367', 'Chonkham', '3', '1');
INSERT INTO `city` VALUES ('368', 'Chopnyu', '3', '1');
INSERT INTO `city` VALUES ('369', 'Chug', '3', '1');
INSERT INTO `city` VALUES ('370', 'Chumba', '3', '1');
INSERT INTO `city` VALUES ('371', 'Chuna', '3', '1');
INSERT INTO `city` VALUES ('372', 'Chunpura', '3', '1');
INSERT INTO `city` VALUES ('373', 'Dabom', '3', '1');
INSERT INTO `city` VALUES ('374', 'Dalbuing', '3', '1');
INSERT INTO `city` VALUES ('375', 'Dambuk', '3', '1');
INSERT INTO `city` VALUES ('376', 'Damroh', '3', '1');
INSERT INTO `city` VALUES ('377', 'Danli', '3', '1');
INSERT INTO `city` VALUES ('378', 'Daring', '3', '1');
INSERT INTO `city` VALUES ('379', 'Demwe', '3', '1');
INSERT INTO `city` VALUES ('380', 'Dening', '3', '1');
INSERT INTO `city` VALUES ('381', 'Dijungania', '3', '1');
INSERT INTO `city` VALUES ('382', 'Dirang', '3', '1');
INSERT INTO `city` VALUES ('383', 'Dirji', '3', '1');
INSERT INTO `city` VALUES ('384', 'Doimara', '3', '1');
INSERT INTO `city` VALUES ('385', 'Dong', '3', '1');
INSERT INTO `city` VALUES ('386', 'Donkeng', '3', '1');
INSERT INTO `city` VALUES ('387', 'Donli', '3', '1');
INSERT INTO `city` VALUES ('388', 'Dorkang', '3', '1');
INSERT INTO `city` VALUES ('389', 'Dosing', '3', '1');
INSERT INTO `city` VALUES ('390', 'Dubbin', '3', '1');
INSERT INTO `city` VALUES ('391', 'Dui Yambi', '3', '1');
INSERT INTO `city` VALUES ('392', 'Duimukh', '3', '1');
INSERT INTO `city` VALUES ('393', 'Duta', '3', '1');
INSERT INTO `city` VALUES ('394', 'Embragon', '3', '1');
INSERT INTO `city` VALUES ('395', 'Etalin', '3', '1');
INSERT INTO `city` VALUES ('396', 'Gai', '3', '1');
INSERT INTO `city` VALUES ('397', 'Gamkik', '3', '1');
INSERT INTO `city` VALUES ('398', 'Gasheng', '3', '1');
INSERT INTO `city` VALUES ('399', 'Gasigaon', '3', '1');
INSERT INTO `city` VALUES ('400', 'Geling', '3', '1');
INSERT INTO `city` VALUES ('401', 'Gette', '3', '1');
INSERT INTO `city` VALUES ('402', 'Gingba', '3', '1');
INSERT INTO `city` VALUES ('403', 'Gocham', '3', '1');
INSERT INTO `city` VALUES ('404', 'Gohaintan', '3', '1');
INSERT INTO `city` VALUES ('405', 'Grunli', '3', '1');
INSERT INTO `city` VALUES ('406', 'Hachi', '3', '1');
INSERT INTO `city` VALUES ('407', 'Hapoli', '3', '1');
INSERT INTO `city` VALUES ('408', 'Harmutigaon', '3', '1');
INSERT INTO `city` VALUES ('409', 'Hatu Yua', '3', '1');
INSERT INTO `city` VALUES ('410', 'Hayutang', '3', '1');
INSERT INTO `city` VALUES ('411', 'Helam', '3', '1');
INSERT INTO `city` VALUES ('412', 'Hong', '3', '1');
INSERT INTO `city` VALUES ('413', 'Hora', '3', '1');
INSERT INTO `city` VALUES ('414', 'Hupu', '3', '1');
INSERT INTO `city` VALUES ('415', 'Ibniyi', '3', '1');
INSERT INTO `city` VALUES ('416', 'Idilin', '3', '1');
INSERT INTO `city` VALUES ('417', 'Ilupu', '3', '1');
INSERT INTO `city` VALUES ('418', 'Ipilin', '3', '1');
INSERT INTO `city` VALUES ('419', 'Itanagar', '3', '1');
INSERT INTO `city` VALUES ('420', 'Jamiri', '3', '1');
INSERT INTO `city` VALUES ('421', 'Jang', '3', '1');
INSERT INTO `city` VALUES ('422', 'Jido', '3', '1');
INSERT INTO `city` VALUES ('423', 'Jining', '3', '1');
INSERT INTO `city` VALUES ('424', 'Jiram', '3', '1');
INSERT INTO `city` VALUES ('425', 'Jirigam', '3', '1');
INSERT INTO `city` VALUES ('426', 'Kablongpu', '3', '1');
INSERT INTO `city` VALUES ('427', 'Kadum', '3', '1');
INSERT INTO `city` VALUES ('428', 'Kafi', '3', '1');
INSERT INTO `city` VALUES ('429', 'Kahao', '3', '1');
INSERT INTO `city` VALUES ('430', 'Kalaktang', '3', '1');
INSERT INTO `city` VALUES ('431', 'Kalom', '3', '1');
INSERT INTO `city` VALUES ('432', 'Kamalabari', '3', '1');
INSERT INTO `city` VALUES ('433', 'Kambang', '3', '1');
INSERT INTO `city` VALUES ('434', 'Kamku', '3', '1');
INSERT INTO `city` VALUES ('435', 'Kamphu', '3', '1');
INSERT INTO `city` VALUES ('436', 'Kangkar', '3', '1');
INSERT INTO `city` VALUES ('437', 'Kapteng', '3', '1');
INSERT INTO `city` VALUES ('438', 'Karangania', '3', '1');
INSERT INTO `city` VALUES ('439', 'Karko', '3', '1');
INSERT INTO `city` VALUES ('440', 'Kaying', '3', '1');
INSERT INTO `city` VALUES ('441', 'Kebang', '3', '1');
INSERT INTO `city` VALUES ('442', 'Kelangkania', '3', '1');
INSERT INTO `city` VALUES ('443', 'Kenze Mane', '3', '1');
INSERT INTO `city` VALUES ('444', 'Khagam', '3', '1');
INSERT INTO `city` VALUES ('445', 'Khaitong', '3', '1');
INSERT INTO `city` VALUES ('446', 'Kharem', '3', '1');
INSERT INTO `city` VALUES ('447', 'Khonsa', '3', '1');
INSERT INTO `city` VALUES ('448', 'Kodak', '3', '1');
INSERT INTO `city` VALUES ('449', 'Koloriang', '3', '1');
INSERT INTO `city` VALUES ('450', 'Kombong', '3', '1');
INSERT INTO `city` VALUES ('451', 'Komra', '3', '1');
INSERT INTO `city` VALUES ('452', 'Komsing', '3', '1');
INSERT INTO `city` VALUES ('453', 'Korbo', '3', '1');
INSERT INTO `city` VALUES ('454', 'Kuimbum', '3', '1');
INSERT INTO `city` VALUES ('455', 'Kumki', '3', '1');
INSERT INTO `city` VALUES ('456', 'Lagam', '3', '1');
INSERT INTO `city` VALUES ('457', 'Laju', '3', '1');
INSERT INTO `city` VALUES ('458', 'Langjon', '3', '1');
INSERT INTO `city` VALUES ('459', 'Lap', '3', '1');
INSERT INTO `city` VALUES ('460', 'Lapung', '3', '1');
INSERT INTO `city` VALUES ('461', 'Lathau', '3', '1');
INSERT INTO `city` VALUES ('462', 'Lepanglat', '3', '1');
INSERT INTO `city` VALUES ('463', 'Lhatsa Gompa', '3', '1');
INSERT INTO `city` VALUES ('464', 'Lhau', '3', '1');
INSERT INTO `city` VALUES ('465', 'Lida', '3', '1');
INSERT INTO `city` VALUES ('466', 'Likhapani', '3', '1');
INSERT INTO `city` VALUES ('467', 'Londa', '3', '1');
INSERT INTO `city` VALUES ('468', 'Longju', '3', '1');
INSERT INTO `city` VALUES ('469', 'Lumpo', '3', '1');
INSERT INTO `city` VALUES ('470', 'Machum', '3', '1');
INSERT INTO `city` VALUES ('471', 'Mai', '3', '1');
INSERT INTO `city` VALUES ('472', 'Maiunli', '3', '1');
INSERT INTO `city` VALUES ('473', 'Manan', '3', '1');
INSERT INTO `city` VALUES ('474', 'Manmao', '3', '1');
INSERT INTO `city` VALUES ('475', 'Mara', '3', '1');
INSERT INTO `city` VALUES ('476', 'Margherita', '3', '1');
INSERT INTO `city` VALUES ('477', 'Marniu', '3', '1');
INSERT INTO `city` VALUES ('478', 'Mebu', '3', '1');
INSERT INTO `city` VALUES ('479', 'Mega', '3', '1');
INSERT INTO `city` VALUES ('480', 'Mekha', '3', '1');
INSERT INTO `city` VALUES ('481', 'Mepumna', '3', '1');
INSERT INTO `city` VALUES ('482', 'Meshing', '3', '1');
INSERT INTO `city` VALUES ('483', 'Miao', '3', '1');
INSERT INTO `city` VALUES ('484', 'Miging', '3', '1');
INSERT INTO `city` VALUES ('485', 'Minutang', '3', '1');
INSERT INTO `city` VALUES ('486', 'Minzong', '3', '1');
INSERT INTO `city` VALUES ('487', 'Mipi', '3', '1');
INSERT INTO `city` VALUES ('488', 'Mopung', '3', '1');
INSERT INTO `city` VALUES ('489', 'Moshing', '3', '1');
INSERT INTO `city` VALUES ('490', 'Mpen', '3', '1');
INSERT INTO `city` VALUES ('491', 'Mpong', '3', '1');
INSERT INTO `city` VALUES ('492', 'Mrambon', '3', '1');
INSERT INTO `city` VALUES ('493', 'Mukki', '3', '1');
INSERT INTO `city` VALUES ('494', 'Naharlagun', '3', '1');
INSERT INTO `city` VALUES ('495', 'Nampong', '3', '1');
INSERT INTO `city` VALUES ('496', 'Niaunyu', '3', '1');
INSERT INTO `city` VALUES ('497', 'Niktak', '3', '1');
INSERT INTO `city` VALUES ('498', 'Ninging', '3', '1');
INSERT INTO `city` VALUES ('499', 'Ningru', '3', '1');
INSERT INTO `city` VALUES ('500', 'Nioku', '3', '1');
INSERT INTO `city` VALUES ('501', 'Nizamghat', '3', '1');
INSERT INTO `city` VALUES ('502', 'Nizau', '3', '1');
INSERT INTO `city` VALUES ('503', 'Noju', '3', '1');
INSERT INTO `city` VALUES ('504', 'Norang', '3', '1');
INSERT INTO `city` VALUES ('505', 'Nring', '3', '1');
INSERT INTO `city` VALUES ('506', 'Nyereng', '3', '1');
INSERT INTO `city` VALUES ('507', 'Nyeying', '3', '1');
INSERT INTO `city` VALUES ('508', 'Nyorak', '3', '1');
INSERT INTO `city` VALUES ('509', 'Nyukmadong', '3', '1');
INSERT INTO `city` VALUES ('510', 'Nyuri', '3', '1');
INSERT INTO `city` VALUES ('511', 'Pangchen', '3', '1');
INSERT INTO `city` VALUES ('512', 'Par', '3', '1');
INSERT INTO `city` VALUES ('513', 'Pareng', '3', '1');
INSERT INTO `city` VALUES ('514', 'Pasighat', '3', '1');
INSERT INTO `city` VALUES ('515', 'Paya', '3', '1');
INSERT INTO `city` VALUES ('516', 'Payagam', '3', '1');
INSERT INTO `city` VALUES ('517', 'Phutang', '3', '1');
INSERT INTO `city` VALUES ('518', 'Pika', '3', '1');
INSERT INTO `city` VALUES ('519', 'Pilu', '3', '1');
INSERT INTO `city` VALUES ('520', 'Pinchi', '3', '1');
INSERT INTO `city` VALUES ('521', 'Plongliang', '3', '1');
INSERT INTO `city` VALUES ('522', 'Pointong', '3', '1');
INSERT INTO `city` VALUES ('523', 'Poyom', '3', '1');
INSERT INTO `city` VALUES ('524', 'Puchep', '3', '1');
INSERT INTO `city` VALUES ('525', 'Puging', '3', '1');
INSERT INTO `city` VALUES ('526', 'Punyang', '3', '1');
INSERT INTO `city` VALUES ('527', 'Pyudung', '3', '1');
INSERT INTO `city` VALUES ('528', 'Rahung', '3', '1');
INSERT INTO `city` VALUES ('529', 'Rajja', '3', '1');
INSERT INTO `city` VALUES ('530', 'Ramsing', '3', '1');
INSERT INTO `city` VALUES ('531', 'Rang', '3', '1');
INSERT INTO `city` VALUES ('532', 'Rangku', '3', '1');
INSERT INTO `city` VALUES ('533', 'Reru', '3', '1');
INSERT INTO `city` VALUES ('534', 'Riang', '3', '1');
INSERT INTO `city` VALUES ('535', 'Riangchi', '3', '1');
INSERT INTO `city` VALUES ('536', 'Riga', '3', '1');
INSERT INTO `city` VALUES ('537', 'Rikor', '3', '1');
INSERT INTO `city` VALUES ('538', 'Riu', '3', '1');
INSERT INTO `city` VALUES ('539', 'Rotung', '3', '1');
INSERT INTO `city` VALUES ('540', 'Rungarh', '3', '1');
INSERT INTO `city` VALUES ('541', 'Rupa', '3', '1');
INSERT INTO `city` VALUES ('542', 'Sachida', '3', '1');
INSERT INTO `city` VALUES ('543', 'Sagong', '3', '1');
INSERT INTO `city` VALUES ('544', 'Sakong', '3', '1');
INSERT INTO `city` VALUES ('545', 'Sakti', '3', '1');
INSERT INTO `city` VALUES ('546', 'Sangma', '3', '1');
INSERT INTO `city` VALUES ('547', 'Sartam', '3', '1');
INSERT INTO `city` VALUES ('548', 'Semma', '3', '1');
INSERT INTO `city` VALUES ('549', 'Senge Dzong', '3', '1');
INSERT INTO `city` VALUES ('550', 'Senua', '3', '1');
INSERT INTO `city` VALUES ('551', 'Shergaon', '3', '1');
INSERT INTO `city` VALUES ('552', 'Shikhi', '3', '1');
INSERT INTO `city` VALUES ('553', 'Shimong', '3', '1');
INSERT INTO `city` VALUES ('554', 'Shinli', '3', '1');
INSERT INTO `city` VALUES ('555', 'Shoi', '3', '1');
INSERT INTO `city` VALUES ('556', 'Sibbuk', '3', '1');
INSERT INTO `city` VALUES ('557', 'Sibbum', '3', '1');
INSERT INTO `city` VALUES ('558', 'Sigar', '3', '1');
INSERT INTO `city` VALUES ('559', 'Silli', '3', '1');
INSERT INTO `city` VALUES ('560', 'Singing', '3', '1');
INSERT INTO `city` VALUES ('561', 'Sulung', '3', '1');
INSERT INTO `city` VALUES ('562', 'Tado', '3', '1');
INSERT INTO `city` VALUES ('563', 'Tagengs', '3', '1');
INSERT INTO `city` VALUES ('564', 'Taipi Duidam', '3', '1');
INSERT INTO `city` VALUES ('565', 'Taipudia', '3', '1');
INSERT INTO `city` VALUES ('566', 'Tajobum', '3', '1');
INSERT INTO `city` VALUES ('567', 'Taktsang', '3', '1');
INSERT INTO `city` VALUES ('568', 'Taku', '3', '1');
INSERT INTO `city` VALUES ('569', 'Takum', '3', '1');
INSERT INTO `city` VALUES ('570', 'Tali', '3', '1');
INSERT INTO `city` VALUES ('571', 'Talo', '3', '1');
INSERT INTO `city` VALUES ('572', 'Talong', '3', '1');
INSERT INTO `city` VALUES ('573', 'Talung Dzong', '3', '1');
INSERT INTO `city` VALUES ('574', 'Tamid Arung', '3', '1');
INSERT INTO `city` VALUES ('575', 'Tammu', '3', '1');
INSERT INTO `city` VALUES ('576', 'Tanden', '3', '1');
INSERT INTO `city` VALUES ('577', 'Tangmaolia', '3', '1');
INSERT INTO `city` VALUES ('578', 'Tapun', '3', '1');
INSERT INTO `city` VALUES ('579', 'Tawai', '3', '1');
INSERT INTO `city` VALUES ('580', 'Tawang', '3', '1');
INSERT INTO `city` VALUES ('581', 'Tembang', '3', '1');
INSERT INTO `city` VALUES ('582', 'Tethaliang', '3', '1');
INSERT INTO `city` VALUES ('583', 'Tezu', '3', '1');
INSERT INTO `city` VALUES ('584', 'Theronliang', '3', '1');
INSERT INTO `city` VALUES ('585', 'Tila', '3', '1');
INSERT INTO `city` VALUES ('586', 'Tilai', '3', '1');
INSERT INTO `city` VALUES ('587', 'Tipang', '3', '1');
INSERT INTO `city` VALUES ('588', 'Tirap', '3', '1');
INSERT INTO `city` VALUES ('589', 'Tirkang', '3', '1');
INSERT INTO `city` VALUES ('590', 'Toku', '3', '1');
INSERT INTO `city` VALUES ('591', 'Tonwa', '3', '1');
INSERT INTO `city` VALUES ('592', 'Tralin', '3', '1');
INSERT INTO `city` VALUES ('593', 'Turet', '3', '1');
INSERT INTO `city` VALUES ('594', 'Tuting', '3', '1');
INSERT INTO `city` VALUES ('595', 'Walong', '3', '1');
INSERT INTO `city` VALUES ('596', 'Wati', '3', '1');
INSERT INTO `city` VALUES ('597', 'Wintong', '3', '1');
INSERT INTO `city` VALUES ('598', 'Yagrung', '3', '1');
INSERT INTO `city` VALUES ('599', 'Yanman', '3', '1');
INSERT INTO `city` VALUES ('600', 'Yapuik', '3', '1');
INSERT INTO `city` VALUES ('601', 'Yedbuk', '3', '1');
INSERT INTO `city` VALUES ('602', 'Yemsing', '3', '1');
INSERT INTO `city` VALUES ('603', 'Yengji', '3', '1');
INSERT INTO `city` VALUES ('604', 'Yingku', '3', '1');
INSERT INTO `city` VALUES ('605', 'Yiyu', '3', '1');
INSERT INTO `city` VALUES ('606', 'Yoba', '3', '1');
INSERT INTO `city` VALUES ('607', 'Yomcha', '3', '1');
INSERT INTO `city` VALUES ('608', 'Yomtam', '3', '1');
INSERT INTO `city` VALUES ('609', 'Ziro', '3', '1');
INSERT INTO `city` VALUES ('610', 'Patna', '5', '1');
INSERT INTO `city` VALUES ('611', 'Gaya', '5', '1');
INSERT INTO `city` VALUES ('612', 'Bhagalpur', '5', '1');
INSERT INTO `city` VALUES ('613', 'Muzaffarpur', '5', '1');
INSERT INTO `city` VALUES ('614', 'Purnia', '5', '1');
INSERT INTO `city` VALUES ('615', 'Darbhanga', '5', '1');
INSERT INTO `city` VALUES ('616', 'Bihar ', '5', '1');
INSERT INTO `city` VALUES ('617', 'Ara ', '5', '1');
INSERT INTO `city` VALUES ('618', 'Begusarai', '5', '1');
INSERT INTO `city` VALUES ('619', 'Katihar', '5', '1');
INSERT INTO `city` VALUES ('620', 'Chapra', '5', '1');
INSERT INTO `city` VALUES ('621', 'Munger ', '5', '1');
INSERT INTO `city` VALUES ('622', 'Saharsa', '5', '1');
INSERT INTO `city` VALUES ('623', 'Bettiah', '5', '1');
INSERT INTO `city` VALUES ('624', 'Hajipur', '5', '1');
INSERT INTO `city` VALUES ('625', 'Sasaram', '5', '1');
INSERT INTO `city` VALUES ('626', 'Dehri', '5', '1');
INSERT INTO `city` VALUES ('627', 'Siwan', '5', '1');
INSERT INTO `city` VALUES ('628', 'Motihari', '5', '1');
INSERT INTO `city` VALUES ('629', 'Nawada', '5', '1');
INSERT INTO `city` VALUES ('630', 'Bagaha', '5', '1');
INSERT INTO `city` VALUES ('631', 'Buxar', '5', '1');
INSERT INTO `city` VALUES ('632', 'Sitamarhi', '5', '1');
INSERT INTO `city` VALUES ('633', 'Kishanganj', '5', '1');
INSERT INTO `city` VALUES ('634', 'Jamalpur', '5', '1');
INSERT INTO `city` VALUES ('635', 'Atawa', '6', '1');
INSERT INTO `city` VALUES ('636', 'Badheri', '6', '1');
INSERT INTO `city` VALUES ('637', 'Bahlana', '6', '1');
INSERT INTO `city` VALUES ('638', 'Bahlolpur', '6', '1');
INSERT INTO `city` VALUES ('639', 'Bajwara', '6', '1');
INSERT INTO `city` VALUES ('640', 'Bijwaribakhta', '6', '1');
INSERT INTO `city` VALUES ('641', 'Burail', '6', '1');
INSERT INTO `city` VALUES ('642', 'Burail', '6', '1');
INSERT INTO `city` VALUES ('643', 'Buterla', '6', '1');
INSERT INTO `city` VALUES ('645', 'Czandigarh', '6', '1');
INSERT INTO `city` VALUES ('646', 'Dariya', '6', '1');
INSERT INTO `city` VALUES ('647', 'Dhanas', '6', '1');
INSERT INTO `city` VALUES ('648', 'Dhanauran', '6', '1');
INSERT INTO `city` VALUES ('649', 'Dadumajra', '6', '1');
INSERT INTO `city` VALUES ('650', 'Fatehgarh', '6', '1');
INSERT INTO `city` VALUES ('651', 'Halamajra', '6', '1');
INSERT INTO `city` VALUES ('652', 'Jhampur', '6', '1');
INSERT INTO `city` VALUES ('653', 'Kaimbwala', '6', '1');
INSERT INTO `city` VALUES ('654', 'Kanthala', '6', '1');
INSERT INTO `city` VALUES ('655', 'Kanthara', '6', '1');
INSERT INTO `city` VALUES ('656', 'Khodajassu', '6', '1');
INSERT INTO `city` VALUES ('657', 'Kursan', '6', '1');
INSERT INTO `city` VALUES ('658', 'Kanjimaira', '6', '1');
INSERT INTO `city` VALUES ('659', 'Kansil', '6', '1');
INSERT INTO `city` VALUES ('660', 'Kujheri', '6', '1');
INSERT INTO `city` VALUES ('661', 'Madanpur', '6', '1');
INSERT INTO `city` VALUES ('662', 'Mahlamajra', '6', '1');
INSERT INTO `city` VALUES ('663', 'Malak', '6', '1');
INSERT INTO `city` VALUES ('664', 'Mastgarh', '6', '1');
INSERT INTO `city` VALUES ('665', 'Moloia', '6', '1');
INSERT INTO `city` VALUES ('666', 'Mariwalatown', '6', '1');
INSERT INTO `city` VALUES ('667', 'Palsaura', '6', '1');
INSERT INTO `city` VALUES ('668', 'Phaldan', '6', '1');
INSERT INTO `city` VALUES ('669', 'Rajbhavanharyana', '6', '1');
INSERT INTO `city` VALUES ('670', 'Rajbhavanpunjab', '6', '1');
INSERT INTO `city` VALUES ('671', 'Raipur', '6', '1');
INSERT INTO `city` VALUES ('672', 'Sangariwala', '6', '1');
INSERT INTO `city` VALUES ('673', 'Sarangpur', '6', '1');
INSERT INTO `city` VALUES ('674', 'Shahpur', '6', '1');
INSERT INTO `city` VALUES ('675', 'Shahpurcholian', '6', '1');
INSERT INTO `city` VALUES ('676', 'Shahzadpur', '6', '1');
INSERT INTO `city` VALUES ('677', 'Sainimajra', '6', '1');
INSERT INTO `city` VALUES ('678', 'Togan', '6', '1');
INSERT INTO `city` VALUES ('679', 'Candigarchas', '6', '1');
INSERT INTO `city` VALUES ('680', 'Candígarh', '6', '1');
INSERT INTO `city` VALUES ('681', 'Kirandul', '7', '1');
INSERT INTO `city` VALUES ('682', 'Namna Kalan', '7', '1');
INSERT INTO `city` VALUES ('683', 'Sirgiti', '7', '1');
INSERT INTO `city` VALUES ('684', 'Bhatapara', '7', '1');
INSERT INTO `city` VALUES ('685', 'Chhuikhadan', '7', '1');
INSERT INTO `city` VALUES ('686', 'Shivrinarayan', '7', '1');
INSERT INTO `city` VALUES ('687', 'Baloda', '7', '1');
INSERT INTO `city` VALUES ('688', 'Pandariya', '7', '1');
INSERT INTO `city` VALUES ('689', 'Bhilai', '7', '1');
INSERT INTO `city` VALUES ('690', 'Bemetra', '7', '1');
INSERT INTO `city` VALUES ('691', 'Arang', '7', '1');
INSERT INTO `city` VALUES ('692', 'Phunderdihari', '7', '1');
INSERT INTO `city` VALUES ('693', 'Dharamjaigarh', '7', '1');
INSERT INTO `city` VALUES ('694', 'Dongragarh', '7', '1');
INSERT INTO `city` VALUES ('695', 'Birgao', '7', '1');
INSERT INTO `city` VALUES ('696', 'Jamul-Durg', '7', '1');
INSERT INTO `city` VALUES ('697', 'Mehmand', '7', '1');
INSERT INTO `city` VALUES ('698', 'Baloda Bazar', '7', '1');
INSERT INTO `city` VALUES ('699', 'Takhatpur', '7', '1');
INSERT INTO `city` VALUES ('700', 'Surajpur', '7', '1');
INSERT INTO `city` VALUES ('701', 'Khairagarh', '7', '1');
INSERT INTO `city` VALUES ('702', 'Dipka', '7', '1');
INSERT INTO `city` VALUES ('703', 'Simga', '7', '1');
INSERT INTO `city` VALUES ('704', 'Lormi', '7', '1');
INSERT INTO `city` VALUES ('705', 'Kunkuri', '7', '1');
INSERT INTO `city` VALUES ('706', 'Telgaon', '7', '1');
INSERT INTO `city` VALUES ('707', 'Baikunthpur', '7', '1');
INSERT INTO `city` VALUES ('708', 'Bhilai Charoda', '7', '1');
INSERT INTO `city` VALUES ('709', 'Tilda-Newra', '7', '1');
INSERT INTO `city` VALUES ('710', 'Lingiyadih', '7', '1');
INSERT INTO `city` VALUES ('711', 'Gandai', '7', '1');
INSERT INTO `city` VALUES ('712', 'Urla-Raipur', '7', '1');
INSERT INTO `city` VALUES ('713', 'Akaltara', '7', '1');
INSERT INTO `city` VALUES ('714', 'Chharchha', '7', '1');
INSERT INTO `city` VALUES ('715', 'Jashpur-Nagar', '7', '1');
INSERT INTO `city` VALUES ('716', 'Bhatgaon', '7', '1');
INSERT INTO `city` VALUES ('717', 'Gharghoda', '7', '1');
INSERT INTO `city` VALUES ('718', 'Bagbahara', '7', '1');
INSERT INTO `city` VALUES ('719', 'Mowa', '7', '1');
INSERT INTO `city` VALUES ('720', 'Bade-Bacheli', '7', '1');
INSERT INTO `city` VALUES ('721', 'Saraipali', '7', '1');
INSERT INTO `city` VALUES ('722', 'Deori Bilaspur', '7', '1');
INSERT INTO `city` VALUES ('723', 'Bhanpuri', '7', '1');
INSERT INTO `city` VALUES ('724', 'Kota', '7', '1');
INSERT INTO `city` VALUES ('725', 'Bilha', '7', '1');
INSERT INTO `city` VALUES ('726', 'Bodri', '7', '1');
INSERT INTO `city` VALUES ('727', 'Kondagaon', '7', '1');
INSERT INTO `city` VALUES ('728', 'Gobranawapara', '7', '1');
INSERT INTO `city` VALUES ('729', 'Chirmiri', '7', '1');
INSERT INTO `city` VALUES ('730', 'Ahiwara', '7', '1');
INSERT INTO `city` VALUES ('731', 'Champa', '7', '1');
INSERT INTO `city` VALUES ('732', 'Dongargaon', '7', '1');
INSERT INTO `city` VALUES ('733', 'Bhaiyathan', '7', '1');
INSERT INTO `city` VALUES ('734', 'Pathalgaon', '7', '1');
INSERT INTO `city` VALUES ('735', 'Pithora', '7', '1');
INSERT INTO `city` VALUES ('736', 'Geedam', '7', '1');
INSERT INTO `city` VALUES ('737', 'Jagdalpur', '7', '1');
INSERT INTO `city` VALUES ('738', 'Kharod', '7', '1');
INSERT INTO `city` VALUES ('739', 'Katghora', '7', '1');
INSERT INTO `city` VALUES ('740', 'Ambikapur', '7', '1');
INSERT INTO `city` VALUES ('741', 'Dhamdha', '7', '1');
INSERT INTO `city` VALUES ('742', 'Frezarpur', '7', '1');
INSERT INTO `city` VALUES ('743', 'Balod', '7', '1');
INSERT INTO `city` VALUES ('744', 'Sarangarh', '7', '1');
INSERT INTO `city` VALUES ('745', 'Kharsia', '7', '1');
INSERT INTO `city` VALUES ('746', 'Pendra', '7', '1');
INSERT INTO `city` VALUES ('747', 'Kumhari', '7', '1');
INSERT INTO `city` VALUES ('748', 'Naila Janjgir', '7', '1');
INSERT INTO `city` VALUES ('749', 'Naya Baradwar', '7', '1');
INSERT INTO `city` VALUES ('750', 'Basna', '7', '1');
INSERT INTO `city` VALUES ('751', 'Patan', '7', '1');
INSERT INTO `city` VALUES ('752', 'Gogaon', '7', '1');
INSERT INTO `city` VALUES ('753', 'Khamhria', '7', '1');
INSERT INTO `city` VALUES ('754', 'Sakti', '7', '1');
INSERT INTO `city` VALUES ('755', 'Gaurella', '7', '1');
INSERT INTO `city` VALUES ('756', 'Manendragarh', '7', '1');
INSERT INTO `city` VALUES ('757', 'Ambagarh Chowki', '7', '1');
INSERT INTO `city` VALUES ('758', 'Kurud', '7', '1');
INSERT INTO `city` VALUES ('759', 'Ratanpur', '7', '1');
INSERT INTO `city` VALUES ('760', 'Ramanujganj', '7', '1');
INSERT INTO `city` VALUES ('761', 'Dalli Rajhara', '7', '1');
INSERT INTO `city` VALUES ('762', 'Banarsi', '7', '1');
INSERT INTO `city` VALUES ('763', 'Vishrampur', '7', '1');
INSERT INTO `city` VALUES ('764', 'Naya Raipur', '7', '1');
INSERT INTO `city` VALUES ('765', 'Mungeli', '7', '1');
INSERT INTO `city` VALUES ('766', 'Khongapani', '7', '1');
INSERT INTO `city` VALUES ('767', 'Amal', '8', '1');
INSERT INTO `city` VALUES ('768', 'Ambabari', '8', '1');
INSERT INTO `city` VALUES ('769', 'Amboli', '8', '1');
INSERT INTO `city` VALUES ('770', 'Amli', '8', '1');
INSERT INTO `city` VALUES ('771', 'Bedpa', '8', '1');
INSERT INTO `city` VALUES ('772', 'Bildari', '8', '1');
INSERT INTO `city` VALUES ('773', 'Chikhli', '8', '1');
INSERT INTO `city` VALUES ('774', 'Dadra', '8', '1');
INSERT INTO `city` VALUES ('775', 'Dharasana', '8', '1');
INSERT INTO `city` VALUES ('776', 'Galonda', '8', '1');
INSERT INTO `city` VALUES ('777', 'Karad', '8', '1');
INSERT INTO `city` VALUES ('778', 'Karchond', '8', '1');
INSERT INTO `city` VALUES ('779', 'Khadoli', '8', '1');
INSERT INTO `city` VALUES ('780', 'Kharadpada', '8', '1');
INSERT INTO `city` VALUES ('781', 'Kherarbari', '8', '1');
INSERT INTO `city` VALUES ('782', 'Kherdi', '8', '1');
INSERT INTO `city` VALUES ('783', 'Kothar', '8', '1');
INSERT INTO `city` VALUES ('784', 'Luari', '8', '1');
INSERT INTO `city` VALUES ('785', 'Mandavni', '8', '1');
INSERT INTO `city` VALUES ('786', 'Mashat', '8', '1');
INSERT INTO `city` VALUES ('787', 'Naroli', '8', '1');
INSERT INTO `city` VALUES ('788', 'Nekowal', '8', '1');
INSERT INTO `city` VALUES ('789', 'Pati', '8', '1');
INSERT INTO `city` VALUES ('790', 'Rakholi', '8', '1');
INSERT INTO `city` VALUES ('791', 'Randha Moti', '8', '1');
INSERT INTO `city` VALUES ('792', 'Randha Nana', '8', '1');
INSERT INTO `city` VALUES ('793', 'Rudana', '8', '1');
INSERT INTO `city` VALUES ('794', 'Saili', '8', '1');
INSERT INTO `city` VALUES ('795', 'Sili', '8', '1');
INSERT INTO `city` VALUES ('796', 'Silvassa', '8', '1');
INSERT INTO `city` VALUES ('797', 'Sindavni', '8', '1');
INSERT INTO `city` VALUES ('798', 'Tithal', '8', '1');
INSERT INTO `city` VALUES ('799', 'Umbarkoi', '8', '1');
INSERT INTO `city` VALUES ('800', 'Vansda', '8', '1');
INSERT INTO `city` VALUES ('801', 'Vasona', '8', '1');
INSERT INTO `city` VALUES ('802', 'Velugam', '8', '1');
INSERT INTO `city` VALUES ('803', 'Bhimpur', '9', '1');
INSERT INTO `city` VALUES ('804', 'Daman', '9', '1');
INSERT INTO `city` VALUES ('805', 'Dholar', '9', '1');
INSERT INTO `city` VALUES ('806', 'Diu', '9', '1');
INSERT INTO `city` VALUES ('807', 'Ghantwar', '9', '1');
INSERT INTO `city` VALUES ('808', 'Gogola', '9', '1');
INSERT INTO `city` VALUES ('809', 'Kotda', '9', '1');
INSERT INTO `city` VALUES ('810', 'Marwad', '9', '1');
INSERT INTO `city` VALUES ('811', 'Sarkharia', '9', '1');
INSERT INTO `city` VALUES ('812', 'Sigsar', '9', '1');
INSERT INTO `city` VALUES ('813', 'Bicholim', '11', '1');
INSERT INTO `city` VALUES ('814', 'Canacona', '11', '1');
INSERT INTO `city` VALUES ('815', 'Cuncolim', '11', '1');
INSERT INTO `city` VALUES ('816', 'Curchorem', '11', '1');
INSERT INTO `city` VALUES ('817', 'Mapusa', '11', '1');
INSERT INTO `city` VALUES ('818', 'Margao', '11', '1');
INSERT INTO `city` VALUES ('819', 'Mormugao', '11', '1');
INSERT INTO `city` VALUES ('820', 'Panaji', '11', '1');
INSERT INTO `city` VALUES ('821', 'Pernem', '11', '1');
INSERT INTO `city` VALUES ('822', 'Ponda', '11', '1');
INSERT INTO `city` VALUES ('823', 'Quepem', '11', '1');
INSERT INTO `city` VALUES ('824', 'Sanguem', '11', '1');
INSERT INTO `city` VALUES ('825', 'Sanquelim', '11', '1');
INSERT INTO `city` VALUES ('826', 'Valpoi', '11', '1');
INSERT INTO `city` VALUES ('827', 'Ahmedabad', '12', '1');
INSERT INTO `city` VALUES ('828', 'Surat', '12', '1');
INSERT INTO `city` VALUES ('829', 'Vadodara', '12', '1');
INSERT INTO `city` VALUES ('830', 'Rajkot', '12', '1');
INSERT INTO `city` VALUES ('831', 'Bhavnagar', '12', '1');
INSERT INTO `city` VALUES ('832', 'Jamnagar', '12', '1');
INSERT INTO `city` VALUES ('833', 'Junagadh', '12', '1');
INSERT INTO `city` VALUES ('834', 'Gandhidham', '12', '1');
INSERT INTO `city` VALUES ('835', 'Nadiad', '12', '1');
INSERT INTO `city` VALUES ('836', 'Gandhinagar', '12', '1');
INSERT INTO `city` VALUES ('837', 'Anand', '12', '1');
INSERT INTO `city` VALUES ('838', 'Morbi', '12', '1');
INSERT INTO `city` VALUES ('839', 'Mehsana', '12', '1');
INSERT INTO `city` VALUES ('840', 'Surendranagar', '12', '1');
INSERT INTO `city` VALUES ('841', 'Bharuch', '12', '1');
INSERT INTO `city` VALUES ('842', 'Vapi', '12', '1');
INSERT INTO `city` VALUES ('843', 'Navsari', '12', '1');
INSERT INTO `city` VALUES ('844', 'Veraval', '12', '1');
INSERT INTO `city` VALUES ('845', 'Porbandar', '12', '1');
INSERT INTO `city` VALUES ('846', 'Godhra', '12', '1');
INSERT INTO `city` VALUES ('847', 'Bhuj', '12', '1');
INSERT INTO `city` VALUES ('848', 'Ankleshwar', '12', '1');
INSERT INTO `city` VALUES ('849', 'Botad', '12', '1');
INSERT INTO `city` VALUES ('850', 'Palanpur', '12', '1');
INSERT INTO `city` VALUES ('851', 'Patan', '12', '1');
INSERT INTO `city` VALUES ('852', 'Dahod', '12', '1');
INSERT INTO `city` VALUES ('853', 'Faridabad', '13', '1');
INSERT INTO `city` VALUES ('854', 'Gurgaon', '13', '1');
INSERT INTO `city` VALUES ('855', 'Panipat', '13', '1');
INSERT INTO `city` VALUES ('856', 'Ambala', '13', '1');
INSERT INTO `city` VALUES ('857', 'Yamunanagar', '13', '1');
INSERT INTO `city` VALUES ('858', 'Rohtak', '13', '1');
INSERT INTO `city` VALUES ('859', 'Hisar', '13', '1');
INSERT INTO `city` VALUES ('860', 'Karnal', '13', '1');
INSERT INTO `city` VALUES ('861', 'Sonipat', '13', '1');
INSERT INTO `city` VALUES ('862', 'Panchkula', '13', '1');
INSERT INTO `city` VALUES ('863', 'Bhiwani', '13', '1');
INSERT INTO `city` VALUES ('864', 'Sirsa', '13', '1');
INSERT INTO `city` VALUES ('865', 'Bahadurgarh', '13', '1');
INSERT INTO `city` VALUES ('866', 'Jind', '13', '1');
INSERT INTO `city` VALUES ('867', 'Thanesar', '13', '1');
INSERT INTO `city` VALUES ('868', 'Kaithal', '13', '1');
INSERT INTO `city` VALUES ('869', 'Rewari', '13', '1');
INSERT INTO `city` VALUES ('870', 'Palwal', '13', '1');
INSERT INTO `city` VALUES ('871', 'Shimla ', '14', '1');
INSERT INTO `city` VALUES ('872', 'Solan', '14', '1');
INSERT INTO `city` VALUES ('873', 'Dharmsala ', '14', '1');
INSERT INTO `city` VALUES ('874', 'Baddi', '14', '1');
INSERT INTO `city` VALUES ('875', 'Nahan', '14', '1');
INSERT INTO `city` VALUES ('876', 'Mandi', '14', '1');
INSERT INTO `city` VALUES ('877', 'Paontasahib', '14', '1');
INSERT INTO `city` VALUES ('878', 'Sundarnagar', '14', '1');
INSERT INTO `city` VALUES ('879', 'Chamba', '14', '1');
INSERT INTO `city` VALUES ('880', 'Kullu', '14', '1');
INSERT INTO `city` VALUES ('881', 'Srinagar', '15', '1');
INSERT INTO `city` VALUES ('882', 'Jammu', '15', '1');
INSERT INTO `city` VALUES ('883', 'Anantnag', '15', '1');
INSERT INTO `city` VALUES ('884', 'Udhampur', '15', '1');
INSERT INTO `city` VALUES ('885', 'Baramula', '15', '1');
INSERT INTO `city` VALUES ('886', 'Sopore', '15', '1');
INSERT INTO `city` VALUES ('887', 'Kathua', '15', '1');
INSERT INTO `city` VALUES ('888', 'Bandipura', '15', '1');
INSERT INTO `city` VALUES ('889', 'Leh', '15', '1');
INSERT INTO `city` VALUES ('890', 'Rajauri', '15', '1');
INSERT INTO `city` VALUES ('891', 'Ganderbal', '15', '1');
INSERT INTO `city` VALUES ('892', 'Punch', '15', '1');
INSERT INTO `city` VALUES ('893', 'Kulgam', '15', '1');
INSERT INTO `city` VALUES ('894', 'Duru Verinag', '15', '1');
INSERT INTO `city` VALUES ('895', 'Bijbiara', '15', '1');
INSERT INTO `city` VALUES ('896', 'Kupwara', '15', '1');
INSERT INTO `city` VALUES ('897', 'Doda', '15', '1');
INSERT INTO `city` VALUES ('898', 'Akhnoor', '15', '1');
INSERT INTO `city` VALUES ('899', 'Jamshedpur', '16', '1');
INSERT INTO `city` VALUES ('900', 'Dhanbad', '16', '1');
INSERT INTO `city` VALUES ('901', 'Ranchi', '16', '1');
INSERT INTO `city` VALUES ('902', 'Bokarosteel', '16', '1');
INSERT INTO `city` VALUES ('903', 'Deoghar', '16', '1');
INSERT INTO `city` VALUES ('904', 'Phusro', '16', '1');
INSERT INTO `city` VALUES ('905', 'Hazaribag', '16', '1');
INSERT INTO `city` VALUES ('906', 'Giridih', '16', '1');
INSERT INTO `city` VALUES ('907', 'Ramgarh', '16', '1');
INSERT INTO `city` VALUES ('908', 'Medininagar', '16', '1');
INSERT INTO `city` VALUES ('909', 'Chirkunda', '16', '1');
INSERT INTO `city` VALUES ('910', 'Jumritilaiya', '16', '1');
INSERT INTO `city` VALUES ('911', 'Sahibganj', '16', '1');
INSERT INTO `city` VALUES ('912', 'Saunda', '16', '1');
INSERT INTO `city` VALUES ('913', 'Chaibasa', '16', '1');
INSERT INTO `city` VALUES ('914', 'Lohardaga', '16', '1');
INSERT INTO `city` VALUES ('915', 'Chakradharpur', '16', '1');
INSERT INTO `city` VALUES ('916', 'Madhupur', '16', '1');
INSERT INTO `city` VALUES ('917', 'Gumla', '16', '1');
INSERT INTO `city` VALUES ('918', 'Chatra', '16', '1');
INSERT INTO `city` VALUES ('919', 'Godda', '16', '1');
INSERT INTO `city` VALUES ('920', 'Gumia', '16', '1');
INSERT INTO `city` VALUES ('921', 'Dumka', '16', '1');
INSERT INTO `city` VALUES ('922', 'Garwa', '16', '1');
INSERT INTO `city` VALUES ('923', 'Pakaur', '16', '1');
INSERT INTO `city` VALUES ('924', 'Bengaluru', '17', '1');
INSERT INTO `city` VALUES ('925', 'Mysore', '17', '1');
INSERT INTO `city` VALUES ('926', 'Hubli-Dharwar', '17', '1');
INSERT INTO `city` VALUES ('927', 'Mangalore', '17', '1');
INSERT INTO `city` VALUES ('928', 'Belgaum', '17', '1');
INSERT INTO `city` VALUES ('929', 'Gulbarga', '17', '1');
INSERT INTO `city` VALUES ('930', 'Davanagere', '17', '1');
INSERT INTO `city` VALUES ('931', 'Bellary', '17', '1');
INSERT INTO `city` VALUES ('932', 'Bijapur', '17', '1');
INSERT INTO `city` VALUES ('933', 'Shimoga', '17', '1');
INSERT INTO `city` VALUES ('934', 'Tumkur', '17', '1');
INSERT INTO `city` VALUES ('935', 'Raichur', '17', '1');
INSERT INTO `city` VALUES ('936', 'Bidar', '17', '1');
INSERT INTO `city` VALUES ('937', 'Hospet', '17', '1');
INSERT INTO `city` VALUES ('938', 'Hassan', '17', '1');
INSERT INTO `city` VALUES ('939', 'Gadag-Betigeri', '17', '1');
INSERT INTO `city` VALUES ('940', 'Udupi', '17', '1');
INSERT INTO `city` VALUES ('941', 'Robertson Pet', '17', '1');
INSERT INTO `city` VALUES ('942', 'Bhadravati', '17', '1');
INSERT INTO `city` VALUES ('943', 'Chitradurga', '17', '1');
INSERT INTO `city` VALUES ('944', 'Kolar', '17', '1');
INSERT INTO `city` VALUES ('945', 'Mandya', '17', '1');
INSERT INTO `city` VALUES ('946', 'Chikmagalur', '17', '1');
INSERT INTO `city` VALUES ('947', 'Gangawati', '17', '1');
INSERT INTO `city` VALUES ('948', 'Bagalkot', '17', '1');
INSERT INTO `city` VALUES ('949', 'Amini', '19', '1');
INSERT INTO `city` VALUES ('950', 'Andrott', '19', '1');
INSERT INTO `city` VALUES ('951', 'Kadmat', '19', '1');
INSERT INTO `city` VALUES ('952', 'Kalpeni', '19', '1');
INSERT INTO `city` VALUES ('953', 'Kavaratti', '19', '1');
INSERT INTO `city` VALUES ('954', 'Minicoy', '19', '1');
INSERT INTO `city` VALUES ('955', 'Indore', '20', '1');
INSERT INTO `city` VALUES ('956', 'Bhopal', '20', '1');
INSERT INTO `city` VALUES ('957', 'Jabalpur', '20', '1');
INSERT INTO `city` VALUES ('958', 'Gwalior', '20', '1');
INSERT INTO `city` VALUES ('959', 'Ujjain', '20', '1');
INSERT INTO `city` VALUES ('960', 'Sagar', '20', '1');
INSERT INTO `city` VALUES ('961', 'Dewas', '20', '1');
INSERT INTO `city` VALUES ('962', 'Satna', '20', '1');
INSERT INTO `city` VALUES ('963', 'Ratlam', '20', '1');
INSERT INTO `city` VALUES ('964', 'Rewa', '20', '1');
INSERT INTO `city` VALUES ('965', 'Murwara', '20', '1');
INSERT INTO `city` VALUES ('966', 'Singrauli', '20', '1');
INSERT INTO `city` VALUES ('967', 'Burhanpur', '20', '1');
INSERT INTO `city` VALUES ('968', 'Khandwa', '20', '1');
INSERT INTO `city` VALUES ('969', 'Morena', '20', '1');
INSERT INTO `city` VALUES ('970', 'Bhind', '20', '1');
INSERT INTO `city` VALUES ('971', 'Chhindwara', '20', '1');
INSERT INTO `city` VALUES ('972', 'Guna', '20', '1');
INSERT INTO `city` VALUES ('973', 'Shivpuri', '20', '1');
INSERT INTO `city` VALUES ('974', 'Vidisha', '20', '1');
INSERT INTO `city` VALUES ('975', 'Damoh', '20', '1');
INSERT INTO `city` VALUES ('976', 'Chhatarpur', '20', '1');
INSERT INTO `city` VALUES ('977', 'Mandsaur', '20', '1');
INSERT INTO `city` VALUES ('978', 'Khargone', '20', '1');
INSERT INTO `city` VALUES ('979', 'Nimach ', '20', '1');
INSERT INTO `city` VALUES ('980', 'Mumbai', '21', '1');
INSERT INTO `city` VALUES ('981', 'Pune', '21', '1');
INSERT INTO `city` VALUES ('982', 'Nagpur', '21', '1');
INSERT INTO `city` VALUES ('983', 'Nashik', '21', '1');
INSERT INTO `city` VALUES ('984', 'Vasai-Virar', '21', '1');
INSERT INTO `city` VALUES ('985', 'Aurangabad', '21', '1');
INSERT INTO `city` VALUES ('986', 'Solapur', '21', '1');
INSERT INTO `city` VALUES ('987', 'Bhiwandi', '21', '1');
INSERT INTO `city` VALUES ('988', 'Amravati', '21', '1');
INSERT INTO `city` VALUES ('989', 'Malegaon', '21', '1');
INSERT INTO `city` VALUES ('990', 'Kolhapur', '21', '1');
INSERT INTO `city` VALUES ('991', 'Nanded', '21', '1');
INSERT INTO `city` VALUES ('992', 'Sangli [Sangali]', '21', '1');
INSERT INTO `city` VALUES ('993', 'Jalgaon', '21', '1');
INSERT INTO `city` VALUES ('994', 'Akola', '21', '1');
INSERT INTO `city` VALUES ('995', 'Latur', '21', '1');
INSERT INTO `city` VALUES ('996', 'Ahmadnagar', '21', '1');
INSERT INTO `city` VALUES ('997', 'Dhule', '21', '1');
INSERT INTO `city` VALUES ('998', 'Ichalkaranji', '21', '1');
INSERT INTO `city` VALUES ('999', 'Chandrapur', '21', '1');
INSERT INTO `city` VALUES ('1000', 'Parbhani', '21', '1');
INSERT INTO `city` VALUES ('1001', 'Jalna', '21', '1');
INSERT INTO `city` VALUES ('1002', 'Bhusawal', '21', '1');
INSERT INTO `city` VALUES ('1003', 'Navi Mumbai', '21', '1');
INSERT INTO `city` VALUES ('1004', 'Panvel', '21', '1');
INSERT INTO `city` VALUES ('1005', 'Bishnupur', '22', '1');
INSERT INTO `city` VALUES ('1006', 'Chakpikarong', '22', '1');
INSERT INTO `city` VALUES ('1007', 'Chandel', '22', '1');
INSERT INTO `city` VALUES ('1008', 'Chattrik', '22', '1');
INSERT INTO `city` VALUES ('1009', 'Churachandpur', '22', '1');
INSERT INTO `city` VALUES ('1010', 'Imphal', '22', '1');
INSERT INTO `city` VALUES ('1011', 'Jiribam', '22', '1');
INSERT INTO `city` VALUES ('1012', 'Kakching', '22', '1');
INSERT INTO `city` VALUES ('1013', 'Kalapahar', '22', '1');
INSERT INTO `city` VALUES ('1014', 'Mao', '22', '1');
INSERT INTO `city` VALUES ('1015', 'Mulam', '22', '1');
INSERT INTO `city` VALUES ('1016', 'Parbung', '22', '1');
INSERT INTO `city` VALUES ('1017', 'Sadarhills', '22', '1');
INSERT INTO `city` VALUES ('1018', 'Saibom', '22', '1');
INSERT INTO `city` VALUES ('1019', 'Sempang', '22', '1');
INSERT INTO `city` VALUES ('1020', 'Senapati', '22', '1');
INSERT INTO `city` VALUES ('1021', 'Sochumer', '22', '1');
INSERT INTO `city` VALUES ('1022', 'Taloulong', '22', '1');
INSERT INTO `city` VALUES ('1023', 'Tamenglong', '22', '1');
INSERT INTO `city` VALUES ('1024', 'Thinghat', '22', '1');
INSERT INTO `city` VALUES ('1025', 'Thoubal', '22', '1');
INSERT INTO `city` VALUES ('1026', 'Ukhrul', '22', '1');
INSERT INTO `city` VALUES ('1027', 'Aizawl', '24', '1');
INSERT INTO `city` VALUES ('1028', 'Darlawn', '24', '1');
INSERT INTO `city` VALUES ('1029', 'Khawhai', '24', '1');
INSERT INTO `city` VALUES ('1030', 'Kolasib', '24', '1');
INSERT INTO `city` VALUES ('1031', 'Lunglei', '24', '1');
INSERT INTO `city` VALUES ('1032', 'Mamit', '24', '1');
INSERT INTO `city` VALUES ('1033', 'North Vanlaiphai', '24', '1');
INSERT INTO `city` VALUES ('1034', 'Saiha', '24', '1');
INSERT INTO `city` VALUES ('1035', 'Sairang', '24', '1');
INSERT INTO `city` VALUES ('1036', 'Saitlaw', '24', '1');
INSERT INTO `city` VALUES ('1037', 'Serchhip', '24', '1');
INSERT INTO `city` VALUES ('1038', 'Thenzawl', '24', '1');
INSERT INTO `city` VALUES ('1039', 'Mokokchung', '25', '1');
INSERT INTO `city` VALUES ('1040', 'Mon', '25', '1');
INSERT INTO `city` VALUES ('1041', 'Wokha', '25', '1');
INSERT INTO `city` VALUES ('1042', 'Ariankuppam', '27', '1');
INSERT INTO `city` VALUES ('1043', 'Karaikal', '27', '1');
INSERT INTO `city` VALUES ('1044', 'Kurumbapet', '27', '1');
INSERT INTO `city` VALUES ('1045', 'Mahe', '27', '1');
INSERT INTO `city` VALUES ('1046', 'Manavely', '27', '1');
INSERT INTO `city` VALUES ('1047', 'Ozhukarai', '27', '1');
INSERT INTO `city` VALUES ('1048', 'Puducherry ', '27', '1');
INSERT INTO `city` VALUES ('1049', 'Thirumalairayanpattinam', '27', '1');
INSERT INTO `city` VALUES ('1050', 'Villianur', '27', '1');
INSERT INTO `city` VALUES ('1051', 'Yanam', '27', '1');
INSERT INTO `city` VALUES ('1052', 'Bhubaneswar', '26', '1');
INSERT INTO `city` VALUES ('1053', 'Cuttack', '26', '1');
INSERT INTO `city` VALUES ('1054', 'Raurkela ', '26', '1');
INSERT INTO `city` VALUES ('1055', 'Brahmapur', '26', '1');
INSERT INTO `city` VALUES ('1056', 'Sambalpur', '26', '1');
INSERT INTO `city` VALUES ('1057', 'Puri', '26', '1');
INSERT INTO `city` VALUES ('1058', 'Baleshwar ', '26', '1');
INSERT INTO `city` VALUES ('1059', 'Bhadrak', '26', '1');
INSERT INTO `city` VALUES ('1060', 'Baripada', '26', '1');
INSERT INTO `city` VALUES ('1061', 'Balangir', '26', '1');
INSERT INTO `city` VALUES ('1062', 'Jharsuguda', '26', '1');
INSERT INTO `city` VALUES ('1063', 'Jaypur', '26', '1');
INSERT INTO `city` VALUES ('1064', 'Bargarh', '26', '1');
INSERT INTO `city` VALUES ('1065', 'Brajarajnagar', '26', '1');
INSERT INTO `city` VALUES ('1066', 'Rayagada', '26', '1');
INSERT INTO `city` VALUES ('1067', 'Bhawanipatna', '26', '1');
INSERT INTO `city` VALUES ('1068', 'Paradip', '26', '1');
INSERT INTO `city` VALUES ('1069', 'Dhenkanal', '26', '1');
INSERT INTO `city` VALUES ('1070', 'Barbil ', '26', '1');
INSERT INTO `city` VALUES ('1071', 'Jatani', '26', '1');
INSERT INTO `city` VALUES ('1072', 'Kendujhar ', '26', '1');
INSERT INTO `city` VALUES ('1073', 'Byasanagar', '26', '1');
INSERT INTO `city` VALUES ('1074', 'Rajagangapur', '26', '1');
INSERT INTO `city` VALUES ('1075', 'Sunabeda', '26', '1');
INSERT INTO `city` VALUES ('1076', 'Koraput', '26', '1');
INSERT INTO `city` VALUES ('1077', 'Bhubaneswar', '26', '1');
INSERT INTO `city` VALUES ('1078', 'Cuttack', '26', '1');
INSERT INTO `city` VALUES ('1079', 'Raurkela ', '26', '1');
INSERT INTO `city` VALUES ('1080', 'Brahmapur', '26', '1');
INSERT INTO `city` VALUES ('1081', 'Sambalpur', '26', '1');
INSERT INTO `city` VALUES ('1082', 'Puri', '26', '1');
INSERT INTO `city` VALUES ('1083', 'Baleshwar ', '26', '1');
INSERT INTO `city` VALUES ('1084', 'Bhadrak', '26', '1');
INSERT INTO `city` VALUES ('1085', 'Ludhiana', '28', '1');
INSERT INTO `city` VALUES ('1086', 'Amritsar', '28', '1');
INSERT INTO `city` VALUES ('1087', 'Jalandhar', '28', '1');
INSERT INTO `city` VALUES ('1088', 'Patiala', '28', '1');
INSERT INTO `city` VALUES ('1089', 'Bathinda ', '28', '1');
INSERT INTO `city` VALUES ('1090', 'Ajitgarh', '28', '1');
INSERT INTO `city` VALUES ('1091', 'Hoshiarpur', '28', '1');
INSERT INTO `city` VALUES ('1092', 'Moga', '28', '1');
INSERT INTO `city` VALUES ('1093', 'Pathankot', '28', '1');
INSERT INTO `city` VALUES ('1094', 'Batala', '28', '1');
INSERT INTO `city` VALUES ('1095', 'Abohar', '28', '1');
INSERT INTO `city` VALUES ('1096', 'Maler Kotla', '28', '1');
INSERT INTO `city` VALUES ('1097', 'Khanna', '28', '1');
INSERT INTO `city` VALUES ('1098', 'Phagwara', '28', '1');
INSERT INTO `city` VALUES ('1099', 'Muktsar', '28', '1');
INSERT INTO `city` VALUES ('1100', 'Barnala', '28', '1');
INSERT INTO `city` VALUES ('1101', 'Firozpur', '28', '1');
INSERT INTO `city` VALUES ('1102', 'Kapurthala', '28', '1');
INSERT INTO `city` VALUES ('1103', 'Zirakpur', '28', '1');
INSERT INTO `city` VALUES ('1104', 'Rajpura', '28', '1');
INSERT INTO `city` VALUES ('1105', 'Kot Kapura', '28', '1');
INSERT INTO `city` VALUES ('1106', 'Sangrur', '28', '1');
INSERT INTO `city` VALUES ('1107', 'Faridkot', '28', '1');
INSERT INTO `city` VALUES ('1108', 'Mansa', '28', '1');
INSERT INTO `city` VALUES ('1109', 'Gobindgarh', '28', '1');
INSERT INTO `city` VALUES ('1110', 'Jaipur', '29', '1');
INSERT INTO `city` VALUES ('1111', 'Jodhpur', '29', '1');
INSERT INTO `city` VALUES ('1112', 'Kota', '29', '1');
INSERT INTO `city` VALUES ('1113', 'Bikaner', '29', '1');
INSERT INTO `city` VALUES ('1114', 'Ajmer', '29', '1');
INSERT INTO `city` VALUES ('1115', 'Udaipur', '29', '1');
INSERT INTO `city` VALUES ('1116', 'Bhilwara', '29', '1');
INSERT INTO `city` VALUES ('1117', 'Alwar', '29', '1');
INSERT INTO `city` VALUES ('1118', 'Bharatpur', '29', '1');
INSERT INTO `city` VALUES ('1119', 'Sikar', '29', '1');
INSERT INTO `city` VALUES ('1120', 'Sri Ganganagar', '29', '1');
INSERT INTO `city` VALUES ('1121', 'pali', '29', '1');
INSERT INTO `city` VALUES ('1122', 'chittorgarh', '29', '1');
INSERT INTO `city` VALUES ('1123', 'Tonk', '29', '1');
INSERT INTO `city` VALUES ('1124', 'kishangarh', '29', '1');
INSERT INTO `city` VALUES ('1125', 'beawar', '29', '1');
INSERT INTO `city` VALUES ('1126', 'Hanumangarh', '29', '1');
INSERT INTO `city` VALUES ('1127', 'dholpur', '29', '1');
INSERT INTO `city` VALUES ('1128', 'Gangapur city', '29', '1');
INSERT INTO `city` VALUES ('1129', 'Sawai Madhopur', '29', '1');
INSERT INTO `city` VALUES ('1130', 'churu', '29', '1');
INSERT INTO `city` VALUES ('1131', 'Jhunjhunu', '29', '1');
INSERT INTO `city` VALUES ('1132', 'Amba', '30', '1');
INSERT INTO `city` VALUES ('1133', 'Aritar', '30', '1');
INSERT INTO `city` VALUES ('1134', 'Arithang', '30', '1');
INSERT INTO `city` VALUES ('1135', 'Arubotay', '30', '1');
INSERT INTO `city` VALUES ('1136', 'Assam Lingzey', '30', '1');
INSERT INTO `city` VALUES ('1137', 'Assangthang', '30', '1');
INSERT INTO `city` VALUES ('1138', 'Bardang', '30', '1');
INSERT INTO `city` VALUES ('1139', 'Barfung', '30', '1');
INSERT INTO `city` VALUES ('1140', 'Berang', '30', '1');
INSERT INTO `city` VALUES ('1141', 'Bering', '30', '1');
INSERT INTO `city` VALUES ('1142', 'Bermiok', '30', '1');
INSERT INTO `city` VALUES ('1143', 'Bermiok', '30', '1');
INSERT INTO `city` VALUES ('1144', 'Beyong', '30', '1');
INSERT INTO `city` VALUES ('1145', 'Bhaluthang', '30', '1');
INSERT INTO `city` VALUES ('1146', 'Bhusuk', '30', '1');
INSERT INTO `city` VALUES ('1147', 'Bojoghari', '30', '1');
INSERT INTO `city` VALUES ('1148', 'Budang', '30', '1');
INSERT INTO `city` VALUES ('1149', 'Buriakhop', '30', '1');
INSERT INTO `city` VALUES ('1150', 'Chakung', '30', '1');
INSERT INTO `city` VALUES ('1151', 'Changayshanti', '30', '1');
INSERT INTO `city` VALUES ('1152', 'Hyderabad', '32', '1');
INSERT INTO `city` VALUES ('1153', 'Warangal', '32', '1');
INSERT INTO `city` VALUES ('1154', 'Mahabubnagar', '32', '1');
INSERT INTO `city` VALUES ('1155', 'Khammam', '32', '1');
INSERT INTO `city` VALUES ('1156', 'Ramagundam', '32', '1');
INSERT INTO `city` VALUES ('1157', 'Nizamabad', '32', '1');
INSERT INTO `city` VALUES ('1158', 'Siddipet', '32', '1');
INSERT INTO `city` VALUES ('1159', 'Nalgonda', '32', '1');
INSERT INTO `city` VALUES ('1160', 'Jammikunta', '32', '1');
INSERT INTO `city` VALUES ('1161', 'Miryalaguda', '32', '1');
INSERT INTO `city` VALUES ('1162', 'Suryapet', '32', '1');
INSERT INTO `city` VALUES ('1163', 'Kumarghat', '33', '1');
INSERT INTO `city` VALUES ('1164', 'Badharghat', '33', '1');
INSERT INTO `city` VALUES ('1165', 'Jogendranagar', '33', '1');
INSERT INTO `city` VALUES ('1166', 'Sabroom', '33', '1');
INSERT INTO `city` VALUES ('1167', 'Udaipur', '33', '1');
INSERT INTO `city` VALUES ('1168', 'Dharmanagar', '33', '1');
INSERT INTO `city` VALUES ('1169', 'Kunjaban', '33', '1');
INSERT INTO `city` VALUES ('1170', 'Belonia', '33', '1');
INSERT INTO `city` VALUES ('1171', 'Unakoti', '33', '1');
INSERT INTO `city` VALUES ('1172', 'Gakulnagar', '33', '1');
INSERT INTO `city` VALUES ('1173', 'Amarpur', '33', '1');
INSERT INTO `city` VALUES ('1174', 'Kailashahar', '33', '1');
INSERT INTO `city` VALUES ('1175', 'Kanpur', '34', '1');
INSERT INTO `city` VALUES ('1176', 'Lucknow', '34', '1');
INSERT INTO `city` VALUES ('1177', 'Ghaziabad', '34', '1');
INSERT INTO `city` VALUES ('1178', 'agra', '34', '1');
INSERT INTO `city` VALUES ('1179', 'Varanasi ', '34', '1');
INSERT INTO `city` VALUES ('1180', 'Meerut', '34', '1');
INSERT INTO `city` VALUES ('1181', 'Allahabad ', '34', '1');
INSERT INTO `city` VALUES ('1182', 'Bareilly', '34', '1');
INSERT INTO `city` VALUES ('1183', 'Aligarh', '34', '1');
INSERT INTO `city` VALUES ('1184', 'Moradabad', '34', '1');
INSERT INTO `city` VALUES ('1185', 'Saharanpur', '34', '1');
INSERT INTO `city` VALUES ('1186', 'Gorakhpur', '34', '1');
INSERT INTO `city` VALUES ('1187', 'Noida', '34', '1');
INSERT INTO `city` VALUES ('1188', 'Firozabad', '34', '1');
INSERT INTO `city` VALUES ('1189', 'Jhansi', '34', '1');
INSERT INTO `city` VALUES ('1190', 'Muzaffarnagar', '34', '1');
INSERT INTO `city` VALUES ('1191', 'Mathura', '34', '1');
INSERT INTO `city` VALUES ('1192', 'Rampur', '34', '1');
INSERT INTO `city` VALUES ('1193', 'Shahjahanpur', '34', '1');
INSERT INTO `city` VALUES ('1194', 'Farrukhabad', '34', '1');
INSERT INTO `city` VALUES ('1195', 'Maunath Bhanjan', '34', '1');
INSERT INTO `city` VALUES ('1196', 'Hapur', '34', '1');
INSERT INTO `city` VALUES ('1197', 'Faizabad', '34', '1');
INSERT INTO `city` VALUES ('1198', 'Etawah', '34', '1');
INSERT INTO `city` VALUES ('1199', 'Mirzapur', '34', '1');
INSERT INTO `city` VALUES ('1200', 'Dehradun', '35', '1');
INSERT INTO `city` VALUES ('1201', 'Haridwar', '35', '1');
INSERT INTO `city` VALUES ('1202', 'Roorkee', '35', '1');
INSERT INTO `city` VALUES ('1203', 'Haldwani', '35', '1');
INSERT INTO `city` VALUES ('1204', 'Rudrapur', '35', '1');
INSERT INTO `city` VALUES ('1205', 'Kashipur', '35', '1');
INSERT INTO `city` VALUES ('1206', 'Rishikesh', '35', '1');
INSERT INTO `city` VALUES ('1207', 'Pithoragarh', '35', '1');
INSERT INTO `city` VALUES ('1208', 'Ramnagar', '35', '1');
INSERT INTO `city` VALUES ('1209', 'Kichha', '35', '1');
INSERT INTO `city` VALUES ('1210', 'Manglaur', '35', '1');
INSERT INTO `city` VALUES ('1211', 'Jaspur', '35', '1');
INSERT INTO `city` VALUES ('1212', 'Kotdwara', '35', '1');
INSERT INTO `city` VALUES ('1213', 'Nainital', '35', '1');
INSERT INTO `city` VALUES ('1214', 'Almora', '35', '1');
INSERT INTO `city` VALUES ('1215', 'Mussoorie', '35', '1');
INSERT INTO `city` VALUES ('1216', 'Sitarganj', '35', '1');
INSERT INTO `city` VALUES ('1217', 'Bazpur', '35', '1');
INSERT INTO `city` VALUES ('1218', 'Pauri', '35', '1');
INSERT INTO `city` VALUES ('1219', 'Tehri', '35', '1');
INSERT INTO `city` VALUES ('1220', 'Nagla', '35', '1');
INSERT INTO `city` VALUES ('1221', 'Laksar', '35', '1');
INSERT INTO `city` VALUES ('1222', 'Chamoli Gopeshwar', '35', '1');
INSERT INTO `city` VALUES ('1223', 'Umru Khurd', '35', '1');
INSERT INTO `city` VALUES ('1224', 'Srinagar', '35', '1');
INSERT INTO `city` VALUES ('1225', 'Kolkata', '36', '1');
INSERT INTO `city` VALUES ('1226', 'Asansol', '36', '1');
INSERT INTO `city` VALUES ('1227', 'Siliguri', '36', '1');
INSERT INTO `city` VALUES ('1228', 'Durgapur', '36', '1');
INSERT INTO `city` VALUES ('1229', 'Bardhaman', '36', '1');
INSERT INTO `city` VALUES ('1230', 'English Bazar', '36', '1');
INSERT INTO `city` VALUES ('1231', 'Baharampur', '36', '1');
INSERT INTO `city` VALUES ('1232', 'Habra', '36', '1');
INSERT INTO `city` VALUES ('1233', 'Jalpaiguri', '36', '1');
INSERT INTO `city` VALUES ('1234', 'Kharagpur', '36', '1');
INSERT INTO `city` VALUES ('1235', 'Shantipur', '36', '1');
INSERT INTO `city` VALUES ('1236', 'Dankuni', '36', '1');
INSERT INTO `city` VALUES ('1237', 'Dhulian', '36', '1');
INSERT INTO `city` VALUES ('1238', 'Ranaghat', '36', '1');
INSERT INTO `city` VALUES ('1239', 'Haldia', '36', '1');
INSERT INTO `city` VALUES ('1240', 'Raiganj', '36', '1');
INSERT INTO `city` VALUES ('1241', 'Krishnanagar', '36', '1');
INSERT INTO `city` VALUES ('1242', 'Nabadwip', '36', '1');
INSERT INTO `city` VALUES ('1243', 'Medinipur', '36', '1');
INSERT INTO `city` VALUES ('1244', 'Balurghat', '36', '1');
INSERT INTO `city` VALUES ('1245', 'Aali', '10', '1');
INSERT INTO `city` VALUES ('1246', 'Ali Pur', '10', '1');
INSERT INTO `city` VALUES ('1247', 'Asola', '10', '1');
INSERT INTO `city` VALUES ('1248', 'Aya Nagar', '10', '1');
INSERT INTO `city` VALUES ('1249', 'Babar Pur', '10', '1');
INSERT INTO `city` VALUES ('1250', 'Bakhtawar Pur', '10', '1');
INSERT INTO `city` VALUES ('1251', 'Bakkar Wala', '10', '1');
INSERT INTO `city` VALUES ('1252', 'Bankauli', '10', '1');
INSERT INTO `city` VALUES ('1253', 'Bankner', '10', '1');
INSERT INTO `city` VALUES ('1254', 'Bapraula', '10', '1');
INSERT INTO `city` VALUES ('1255', 'Baqiabad', '10', '1');
INSERT INTO `city` VALUES ('1256', 'Barwala', '10', '1');
INSERT INTO `city` VALUES ('1257', 'Bawana', '10', '1');
INSERT INTO `city` VALUES ('1258', 'Begum Pur', '10', '1');
INSERT INTO `city` VALUES ('1259', 'Bhalswa Jahangir Pur', '10', '1');
INSERT INTO `city` VALUES ('1260', 'Bhati', '10', '1');
INSERT INTO `city` VALUES ('1261', 'Bhor Garh', '10', '1');
INSERT INTO `city` VALUES ('1262', 'Burari', '10', '1');
INSERT INTO `city` VALUES ('1263', 'Chandan Hola', '10', '1');
INSERT INTO `city` VALUES ('1264', 'Chattar Pur', '10', '1');
INSERT INTO `city` VALUES ('1265', 'Chhawala', '10', '1');
INSERT INTO `city` VALUES ('1266', 'Chilla Saroda Bangar', '10', '1');
INSERT INTO `city` VALUES ('1267', 'Chilla Saroda Khadar', '10', '1');
INSERT INTO `city` VALUES ('1268', 'Dallo Pura', '10', '1');
INSERT INTO `city` VALUES ('1269', 'Darya Pur Kalan', '10', '1');
INSERT INTO `city` VALUES ('1270', 'Dayal Pur', '10', '1');
INSERT INTO `city` VALUES ('1271', 'Delhi', '10', '1');
INSERT INTO `city` VALUES ('1272', 'Delhi Cantonment', '10', '1');
INSERT INTO `city` VALUES ('1273', 'Deoli', '10', '1');
INSERT INTO `city` VALUES ('1274', 'Dera Mandi', '10', '1');
INSERT INTO `city` VALUES ('1275', 'Dindar Pur', '10', '1');
INSERT INTO `city` VALUES ('1276', 'Fateh Pur Beri', '10', '1');
INSERT INTO `city` VALUES ('1277', 'Gharoli', '10', '1');
INSERT INTO `city` VALUES ('1278', 'Gharonda Neemka Bangar', '10', '1');
INSERT INTO `city` VALUES ('1279', 'Gheora', '10', '1');
INSERT INTO `city` VALUES ('1280', 'Ghitorni', '10', '1');
INSERT INTO `city` VALUES ('1281', 'Gokal Pur', '10', '1');
INSERT INTO `city` VALUES ('1282', 'Hastsal', '10', '1');
INSERT INTO `city` VALUES ('1283', 'Ibrahim Pur', '10', '1');
INSERT INTO `city` VALUES ('1284', 'Jaffar Pur Kalan', '10', '1');
INSERT INTO `city` VALUES ('1285', 'Jaffrabad', '10', '1');
INSERT INTO `city` VALUES ('1286', 'Jait Pur', '10', '1');
INSERT INTO `city` VALUES ('1287', 'Jharoda Kalan', '10', '1');
INSERT INTO `city` VALUES ('1288', 'Jharoda Majra Burari', '10', '1');
INSERT INTO `city` VALUES ('1289', 'Jiwan Pur', '10', '1');
INSERT INTO `city` VALUES ('1290', 'Jona Pur', '10', '1');
INSERT INTO `city` VALUES ('1291', 'Kair', '10', '1');
INSERT INTO `city` VALUES ('1292', 'Kamal Pur Majra Burari', '10', '1');
INSERT INTO `city` VALUES ('1293', 'Kanjhawala', '10', '1');
INSERT INTO `city` VALUES ('1294', 'Kapas Hera', '10', '1');
INSERT INTO `city` VALUES ('1295', 'Karala', '10', '1');
INSERT INTO `city` VALUES ('1296', 'Karawal Nagar', '10', '1');
INSERT INTO `city` VALUES ('1297', 'Khajoori Khas', '10', '1');
INSERT INTO `city` VALUES ('1298', 'Khan Pur Dhani', '10', '1');
INSERT INTO `city` VALUES ('1299', 'Khera', '10', '1');
INSERT INTO `city` VALUES ('1300', 'Khera Kalan', '10', '1');
INSERT INTO `city` VALUES ('1301', 'Khera Khurd', '10', '1');
INSERT INTO `city` VALUES ('1302', 'Kirari Suleman Nagar', '10', '1');
INSERT INTO `city` VALUES ('1303', 'Kondli', '10', '1');
INSERT INTO `city` VALUES ('1304', 'Kotla Mahigiran', '10', '1');
INSERT INTO `city` VALUES ('1305', 'Kusum Pur', '10', '1');
INSERT INTO `city` VALUES ('1306', 'Lad Pur', '10', '1');
INSERT INTO `city` VALUES ('1307', 'Libas Pur', '10', '1');
INSERT INTO `city` VALUES ('1308', 'Maidan Garhi', '10', '1');
INSERT INTO `city` VALUES ('1309', 'Malik Pur Kohi', '10', '1');
INSERT INTO `city` VALUES ('1310', 'Mandoli', '10', '1');
INSERT INTO `city` VALUES ('1311', 'Mir Pur Turk', '10', '1');
INSERT INTO `city` VALUES ('1312', 'Mithe Pur', '10', '1');
INSERT INTO `city` VALUES ('1313', 'Mitraon', '10', '1');
INSERT INTO `city` VALUES ('1314', 'Mohammad Pur Majri', '10', '1');
INSERT INTO `city` VALUES ('1315', 'Molar Band', '10', '1');
INSERT INTO `city` VALUES ('1316', 'Moradabad Pahari', '10', '1');
INSERT INTO `city` VALUES ('1317', 'Mubarak Pur Dabas', '10', '1');
INSERT INTO `city` VALUES ('1318', 'Mukand Pur', '10', '1');
INSERT INTO `city` VALUES ('1319', 'Mukhmel Pur', '10', '1');
INSERT INTO `city` VALUES ('1320', 'Mundka', '10', '1');
INSERT INTO `city` VALUES ('1321', 'Mustafabad', '10', '1');
INSERT INTO `city` VALUES ('1322', 'Nangli Sakrawati', '10', '1');
INSERT INTO `city` VALUES ('1323', 'Nangloi Jat', '10', '1');
INSERT INTO `city` VALUES ('1324', 'Neb Sarai', '10', '1');
INSERT INTO `city` VALUES ('1325', 'New Delhi', '10', '1');
INSERT INTO `city` VALUES ('1326', 'Nilothi', '10', '1');
INSERT INTO `city` VALUES ('1327', 'Nithari', '10', '1');
INSERT INTO `city` VALUES ('1328', 'Pehlad Pur Bangar', '10', '1');
INSERT INTO `city` VALUES ('1329', 'Pooth Kalan', '10', '1');
INSERT INTO `city` VALUES ('1330', 'Pooth Khurd', '10', '1');
INSERT INTO `city` VALUES ('1331', 'Pul Pehlad', '10', '1');
INSERT INTO `city` VALUES ('1332', 'Qadi Pur', '10', '1');
INSERT INTO `city` VALUES ('1333', 'Quammruddin Nagar', '10', '1');
INSERT INTO `city` VALUES ('1334', 'Qutab Garh', '10', '1');
INSERT INTO `city` VALUES ('1335', 'Raja Pur Khurd', '10', '1');
INSERT INTO `city` VALUES ('1336', 'Rajokri', '10', '1');
INSERT INTO `city` VALUES ('1337', 'Raj Pur Khurd', '10', '1');
INSERT INTO `city` VALUES ('1338', 'Rani Khera', '10', '1');
INSERT INTO `city` VALUES ('1339', 'Roshan Pura', '10', '1');
INSERT INTO `city` VALUES ('1340', 'Sadat Pur Gujran', '10', '1');
INSERT INTO `city` VALUES ('1341', 'Sahibabad Daulat Pur', '10', '1');
INSERT INTO `city` VALUES ('1342', 'Saidabad', '10', '1');
INSERT INTO `city` VALUES ('1343', 'Saidul Azaib', '10', '1');
INSERT INTO `city` VALUES ('1344', 'Sambhalka', '10', '1');
INSERT INTO `city` VALUES ('1345', 'Shafi Pur Ranhola', '10', '1');
INSERT INTO `city` VALUES ('1346', 'Shakar Pur Baramad', '10', '1');
INSERT INTO `city` VALUES ('1347', 'Siras Pur', '10', '1');
INSERT INTO `city` VALUES ('1348', 'Sultan Pur', '10', '1');
INSERT INTO `city` VALUES ('1349', 'Sultan Pur Majra', '10', '1');
INSERT INTO `city` VALUES ('1350', 'Taj Pul', '10', '1');
INSERT INTO `city` VALUES ('1351', 'Tigri', '10', '1');
INSERT INTO `city` VALUES ('1352', 'Tikri Kalan', '10', '1');
INSERT INTO `city` VALUES ('1353', 'Tikri Khurd', '10', '1');
INSERT INTO `city` VALUES ('1354', 'Tilang Pur Kotla', '10', '1');
INSERT INTO `city` VALUES ('1355', 'Tukhmir Pur', '10', '1');
INSERT INTO `city` VALUES ('1356', 'Ujwa', '10', '1');
INSERT INTO `city` VALUES ('1357', 'Ziauddin Pur', '10', '1');
INSERT INTO `city` VALUES ('1358', 'Cherrapunji', '23', '1');
INSERT INTO `city` VALUES ('1359', 'Mairang', '23', '1');
INSERT INTO `city` VALUES ('1360', 'Mankachar', '23', '1');
INSERT INTO `city` VALUES ('1361', 'Nongpoh', '23', '1');
INSERT INTO `city` VALUES ('1362', 'Nongstoin', '23', '1');
INSERT INTO `city` VALUES ('1363', 'Shillong', '23', '1');
INSERT INTO `city` VALUES ('1364', 'Tura', '23', '1');
INSERT INTO `city` VALUES ('1365', 'Veeravanallur', '31', '1');
INSERT INTO `city` VALUES ('1366', 'Kallidai kuryichi', '31', '1');
INSERT INTO `city` VALUES ('1367', 'Kadayanallur', '31', '1');
INSERT INTO `city` VALUES ('1368', 'Kottar', '31', '1');
INSERT INTO `city` VALUES ('1369', 'Mannarkudi', '31', '1');
INSERT INTO `city` VALUES ('1370', 'Vedharanayam', '31', '1');
INSERT INTO `city` VALUES ('1371', 'Vettaikaran Iruppu', '31', '1');
INSERT INTO `city` VALUES ('1372', 'Mathukur', '31', '1');
INSERT INTO `city` VALUES ('1373', 'Tenkasi', '31', '1');
INSERT INTO `city` VALUES ('1374', 'Monday Market', '31', '1');
INSERT INTO `city` VALUES ('1376', 'Usulampatti', '31', '1');
INSERT INTO `city` VALUES ('1377', 'Vellakovil', '31', '1');
INSERT INTO `city` VALUES ('1378', 'Muthupetai', '31', '1');
INSERT INTO `city` VALUES ('1380', 'Tiruchuli', '31', '1');
INSERT INTO `city` VALUES ('1381', 'Paapanad', '31', '1');
INSERT INTO `city` VALUES ('1382', 'Peraiyur', '31', '1');
INSERT INTO `city` VALUES ('1383', 'T.Kallupatti', '31', '1');
INSERT INTO `city` VALUES ('1384', 'Srivilliputhur', '31', '1');
INSERT INTO `city` VALUES ('1385', 'Theni', '31', '1');
INSERT INTO `city` VALUES ('1386', 'Mamsapuram', '31', '1');
INSERT INTO `city` VALUES ('1387', 'Arupukkotai', '31', '1');
INSERT INTO `city` VALUES ('1388', 'Coutrallam', '31', '1');
INSERT INTO `city` VALUES ('1389', 'Sankarankovil', '31', '1');
INSERT INTO `city` VALUES ('1390', 'Surandai', '31', '1');
INSERT INTO `city` VALUES ('1391', 'Puliyangudi', '31', '1');
INSERT INTO `city` VALUES ('1392', 'Tirupattur', '31', '1');
INSERT INTO `city` VALUES ('1393', 'Sivagangai', '31', '1');
INSERT INTO `city` VALUES ('1394', 'Paramakudi', '31', '1');
INSERT INTO `city` VALUES ('1395', 'Ambhasamuthram', '31', '1');
INSERT INTO `city` VALUES ('1396', 'Panruti', '31', '1');
INSERT INTO `city` VALUES ('1397', 'Kalathur', '31', '1');
INSERT INTO `city` VALUES ('1398', 'Kalugumalai', '31', '1');
INSERT INTO `city` VALUES ('1399', 'Kangeyam', '31', '1');
INSERT INTO `city` VALUES ('1400', 'M.Kallupatti', '31', '1');
INSERT INTO `city` VALUES ('1402', 'Kirandul', '7', '1');
INSERT INTO `city` VALUES ('1403', 'Valakom', '18', '1');
INSERT INTO `city` VALUES ('1404', 'Alencherry', '18', '1');
INSERT INTO `city` VALUES ('1405', 'Perali', '31', '1');
INSERT INTO `city` VALUES ('1406', 'BANGARPET', '17', '1');
INSERT INTO `city` VALUES ('1407', 'PANRUTI', '31', '1');
INSERT INTO `city` VALUES ('1408', 'MALLANKINAR', '31', '1');
INSERT INTO `city` VALUES ('1409', 'THIRUCHENDER', '31', '1');
INSERT INTO `city` VALUES ('1410', 'THIRUNELVELI', '31', '1');
INSERT INTO `city` VALUES ('1411', 'KARIYA PATTI', '31', '1');
INSERT INTO `city` VALUES ('1412', 'KOVIL PATTHI', '31', '1');
INSERT INTO `city` VALUES ('1413', 'KULLAR', '31', '1');
INSERT INTO `city` VALUES ('1414', 'THIRUPATHUR', '31', '1');
INSERT INTO `city` VALUES ('1415', 'THIRUKOVILUR', '31', '1');
INSERT INTO `city` VALUES ('1416', 'ANNAIMALAI', '31', '1');
INSERT INTO `city` VALUES ('1417', 'ARANI', '31', '1');
INSERT INTO `city` VALUES ('1418', 'ARANTHANGI', '31', '1');
INSERT INTO `city` VALUES ('1419', 'ARUPPUKOTTAI', '31', '1');
INSERT INTO `city` VALUES ('1420', 'CHENNAI', '31', '1');
INSERT INTO `city` VALUES ('1421', 'KANCHIPURAM', '31', '1');
INSERT INTO `city` VALUES ('1422', 'BARAN', '29', '1');
INSERT INTO `city` VALUES ('1423', 'SALEM', '31', '1');
INSERT INTO `city` VALUES ('1424', 'NEEMUCH', '20', '1');
INSERT INTO `city` VALUES ('1425', 'KUSHALNAGAR', '17', '1');
INSERT INTO `city` VALUES ('1426', 'AATHUR', '31', '1');
INSERT INTO `city` VALUES ('1427', 'ERNAKULAM', '18', '1');
INSERT INTO `city` VALUES ('1428', 'POTTAL PUTHUR', '31', '1');
INSERT INTO `city` VALUES ('1429', 'SRIVAIKUNDAM', '31', '1');
INSERT INTO `city` VALUES ('1430', 'UDUMALAIPETTAI', '31', '1');

-- ----------------------------
-- Table structure for `commodity`
-- ----------------------------
DROP TABLE IF EXISTS `commodity`;
CREATE TABLE `commodity` (
  `commodityId` bigint(20) NOT NULL auto_increment,
  `commodityName` varchar(200) default NULL,
  `commodityUOM` bigint(20) default NULL,
  `commodityHSNCodeRef` varchar(20) default NULL,
  PRIMARY KEY  (`commodityId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of commodity
-- ----------------------------

-- ----------------------------
-- Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `company_id` bigint(6) NOT NULL auto_increment,
  `company_Name_English` varchar(200) NOT NULL,
  `company_Name_Tamil` varchar(200) default NULL,
  PRIMARY KEY  (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'Vasantham Milk Agency', 'Vasantham Milk Agency');

-- ----------------------------
-- Table structure for `companyaddress`
-- ----------------------------
DROP TABLE IF EXISTS `companyaddress`;
CREATE TABLE `companyaddress` (
  `addressId` bigint(20) NOT NULL auto_increment,
  `companyRefId` bigint(20) default NULL,
  `address1` varchar(200) default NULL,
  `address2` varchar(200) default NULL,
  `countryRefId` bigint(20) default NULL,
  `stateRefId` bigint(20) default NULL,
  `cityRefId` bigint(20) default NULL,
  `pinCode` varchar(20) default NULL,
  `email` varchar(100) default NULL,
  `phone` varchar(20) default NULL,
  `mobile` varchar(20) default NULL,
  `addressType` int(1) default NULL,
  `activeFlag` int(1) default NULL,
  `accountbankName` varchar(50) default NULL,
  `accountNumber` varchar(50) default NULL,
  `IFS Code` varchar(50) default NULL,
  `GST` varchar(50) default NULL,
  PRIMARY KEY  (`addressId`),
  KEY `addressCountryRefId` (`countryRefId`),
  KEY `addressStateRefId` (`stateRefId`),
  KEY `addressCityRefId` (`cityRefId`),
  KEY `companyaddressRefId` (`companyRefId`),
  CONSTRAINT `companyaddress_ibfk_1` FOREIGN KEY (`companyRefId`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `companyaddress_ibfk_2` FOREIGN KEY (`cityRefId`) REFERENCES `city` (`cityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `companyaddress_ibfk_3` FOREIGN KEY (`countryRefId`) REFERENCES `country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `companyaddress_ibfk_4` FOREIGN KEY (`stateRefId`) REFERENCES `state` (`stateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of companyaddress
-- ----------------------------
INSERT INTO `companyaddress` VALUES ('1', '1', 'test', null, null, null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `countryId` bigint(10) NOT NULL auto_increment,
  `countryName` varchar(20) default NULL,
  `activeFlag` int(1) default NULL,
  PRIMARY KEY  (`countryId`),
  KEY `countryId` (`countryId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', 'India', '1');

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `customerID` bigint(20) NOT NULL auto_increment,
  `name` varchar(200) default NULL,
  `gstNumber` varchar(50) NOT NULL,
  `partyGstType` int(2) NOT NULL,
  `cutomerType` int(2) NOT NULL,
  `companyRefId` bigint(6) NOT NULL,
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `createdBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `activeFlag` int(1) default NULL,
  `aadharNumber` varchar(100) default NULL,
  PRIMARY KEY  (`customerID`),
  KEY `customerCompanyRefId` (`companyRefId`),
  KEY `customerCreatedBy` (`createdBy`),
  KEY `customerGstTypeRefId` (`partyGstType`),
  KEY `customerTypeRefId` (`cutomerType`),
  KEY `customerGSTNumber` USING BTREE (`gstNumber`),
  CONSTRAINT `customerCompanyRefId` FOREIGN KEY (`companyRefId`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `customerCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `login` (`user_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `customerGstTypeRefId` FOREIGN KEY (`partyGstType`) REFERENCES `customergsttype` (`customerGstTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `customerTypeRefId` FOREIGN KEY (`cutomerType`) REFERENCES `customertype` (`customerTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------

-- ----------------------------
-- Table structure for `customeraddress`
-- ----------------------------
DROP TABLE IF EXISTS `customeraddress`;
CREATE TABLE `customeraddress` (
  `addressId` bigint(20) NOT NULL auto_increment,
  `customerRefId` bigint(20) default NULL,
  `address1` varchar(200) default NULL,
  `address2` varchar(200) default NULL,
  `countryRefId` bigint(20) default NULL,
  `stateRefId` bigint(20) default NULL,
  `cityRefId` bigint(20) default NULL,
  `pinCode` varchar(20) default NULL,
  `email` varchar(100) default NULL,
  `phone` varchar(20) default NULL,
  `mobile` varchar(20) default NULL,
  `addressType` int(1) default NULL,
  `activeFlag` int(1) default NULL,
  `createdBy` double(20,0) default NULL,
  `updateBy` double(20,0) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`addressId`),
  KEY `addressCountryRefId` (`countryRefId`),
  KEY `addressStateRefId` (`stateRefId`),
  KEY `addressCityRefId` (`cityRefId`),
  KEY `addressCustomerRefId` (`customerRefId`),
  CONSTRAINT `addressCityRefId` FOREIGN KEY (`cityRefId`) REFERENCES `city` (`cityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `addressCountryRefId` FOREIGN KEY (`countryRefId`) REFERENCES `country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `addressCustomerRefId` FOREIGN KEY (`customerRefId`) REFERENCES `customer` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `addressStateRefId` FOREIGN KEY (`stateRefId`) REFERENCES `state` (`stateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customeraddress
-- ----------------------------

-- ----------------------------
-- Table structure for `customergsttype`
-- ----------------------------
DROP TABLE IF EXISTS `customergsttype`;
CREATE TABLE `customergsttype` (
  `customerGstTypeId` int(1) NOT NULL auto_increment,
  `customerGstTypeName` varchar(200) default NULL,
  PRIMARY KEY  (`customerGstTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customergsttype
-- ----------------------------
INSERT INTO `customergsttype` VALUES ('1', 'Within State (CGST/SGST)');
INSERT INTO `customergsttype` VALUES ('2', 'Other State (IGST)');

-- ----------------------------
-- Table structure for `customeropeningbalance`
-- ----------------------------
DROP TABLE IF EXISTS `customeropeningbalance`;
CREATE TABLE `customeropeningbalance` (
  `customerTrialBalanceId` bigint(20) NOT NULL auto_increment,
  `customerRefId` bigint(20) default NULL,
  `customerOpeningBalance` double default NULL,
  `customerClosingBalance` double default NULL,
  `customerTrialBalance` double default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  PRIMARY KEY  (`customerTrialBalanceId`),
  UNIQUE KEY `customer_company_account` USING BTREE (`customerRefId`,`companyRefId`,`accountYearRefId`),
  CONSTRAINT `customeropeningbalance_ibfk_1` FOREIGN KEY (`customerRefId`) REFERENCES `customer` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customeropeningbalance
-- ----------------------------

-- ----------------------------
-- Table structure for `customertransaction`
-- ----------------------------
DROP TABLE IF EXISTS `customertransaction`;
CREATE TABLE `customertransaction` (
  `customerTransactionId` bigint(20) NOT NULL auto_increment,
  `customerRefId` bigint(20) default NULL,
  `transactionDate` date default NULL,
  `billType` int(2) default NULL,
  `transactiondescription` text,
  `transactionType` int(2) default NULL,
  `amount` double default NULL,
  `accountYearRefId` double(20,0) default NULL,
  `companyRefId` double(20,0) default NULL,
  `activeFlag` int(2) default NULL,
  `createdBy` double(20,0) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedBy` double(20,0) default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `tableReferenceId` bigint(20) default NULL,
  `tableDetailId` bigint(20) default NULL,
  PRIMARY KEY  (`customerTransactionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customertransaction
-- ----------------------------

-- ----------------------------
-- Table structure for `customertype`
-- ----------------------------
DROP TABLE IF EXISTS `customertype`;
CREATE TABLE `customertype` (
  `customerTypeId` int(1) NOT NULL auto_increment,
  `customerTypeName` varchar(200) default NULL,
  PRIMARY KEY  (`customerTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customertype
-- ----------------------------
INSERT INTO `customertype` VALUES ('1', 'Purchase');
INSERT INTO `customertype` VALUES ('2', 'Sales');
INSERT INTO `customertype` VALUES ('3', 'Purchase and Sales');

-- ----------------------------
-- Table structure for `daytransaction`
-- ----------------------------
DROP TABLE IF EXISTS `daytransaction`;
CREATE TABLE `daytransaction` (
  `id` int(3) NOT NULL auto_increment,
  `date` date NOT NULL,
  `transactionTable` int(3) NOT NULL,
  `transactionType` int(3) NOT NULL,
  `transactionDetailId` int(3) NOT NULL default '0',
  `transactionDescription` text NOT NULL,
  `activeFlag` tinyint(2) default NULL,
  `amount` double NOT NULL,
  `customerId` tinyint(5) NOT NULL,
  `accountYearRefId` double NOT NULL,
  `companyRefId` double NOT NULL,
  `created_By` int(3) NOT NULL,
  `updated_By` int(3) NOT NULL,
  `created_Timestamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updated_Timestamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of daytransaction
-- ----------------------------

-- ----------------------------
-- Table structure for `developertable`
-- ----------------------------
DROP TABLE IF EXISTS `developertable`;
CREATE TABLE `developertable` (
  `id` bigint(20) NOT NULL auto_increment,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of developertable
-- ----------------------------

-- ----------------------------
-- Table structure for `expensecategory`
-- ----------------------------
DROP TABLE IF EXISTS `expensecategory`;
CREATE TABLE `expensecategory` (
  `expenseCategoryId` bigint(20) NOT NULL auto_increment,
  `expenseCategoryName` varchar(300) default NULL,
  `activeFlag` int(1) default '0',
  PRIMARY KEY  (`expenseCategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of expensecategory
-- ----------------------------

-- ----------------------------
-- Table structure for `expenses`
-- ----------------------------
DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `expenseId` bigint(20) NOT NULL auto_increment,
  `expenseCateogryRefId` bigint(20) default NULL,
  `expenseSubCateogoryRefId` bigint(20) default NULL,
  `amount` double default NULL,
  `paymentMode` int(4) default NULL,
  `paymentDescription` varchar(500) default NULL,
  `accountRefId` bigint(20) default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  `createdBy` bigint(20) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedBy` bigint(20) default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `expenseDate` date default NULL,
  `activeFlag` int(1) default '1',
  `voucherNumber` bigint(20) default NULL,
  PRIMARY KEY  (`expenseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of expenses
-- ----------------------------

-- ----------------------------
-- Table structure for `expensesubcategory`
-- ----------------------------
DROP TABLE IF EXISTS `expensesubcategory`;
CREATE TABLE `expensesubcategory` (
  `expenseSubCategoryId` bigint(20) NOT NULL auto_increment,
  `expenseCategoryRefId` bigint(20) default NULL,
  `expenseSubCategoryName` varchar(200) default NULL,
  `activeFlag` int(1) default NULL,
  PRIMARY KEY  (`expenseSubCategoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of expensesubcategory
-- ----------------------------

-- ----------------------------
-- Table structure for `gsthsncode`
-- ----------------------------
DROP TABLE IF EXISTS `gsthsncode`;
CREATE TABLE `gsthsncode` (
  `hsnCode` varchar(20) NOT NULL default '0',
  `hsnType` int(1) default '1',
  `description` text NOT NULL,
  `cgstRate` double NOT NULL,
  `sgstRate` double NOT NULL,
  `igstRate` double NOT NULL,
  `vatRate` double default NULL,
  `cstRate` double default NULL,
  `activeFlag` int(1) default NULL,
  PRIMARY KEY  (`hsnCode`),
  KEY `gstHSNTypeRef` (`hsnType`),
  CONSTRAINT `gsthsncode_ibfk_1` FOREIGN KEY (`hsnType`) REFERENCES `gsttype` (`gstTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gsthsncode
-- ----------------------------

-- ----------------------------
-- Table structure for `gsttype`
-- ----------------------------
DROP TABLE IF EXISTS `gsttype`;
CREATE TABLE `gsttype` (
  `gstTypeId` int(1) NOT NULL auto_increment,
  `gstTypeName` varchar(200) default NULL,
  PRIMARY KEY  (`gstTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gsttype
-- ----------------------------
INSERT INTO `gsttype` VALUES ('1', 'Product');
INSERT INTO `gsttype` VALUES ('2', 'Service');

-- ----------------------------
-- Table structure for `items`
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `ItemId` bigint(20) NOT NULL auto_increment,
  `NAME` varchar(200) NOT NULL,
  `packingFactor` double default NULL,
  `billFactor` double default NULL,
  `UnitPrice` double NOT NULL,
  `UnitPriceWholeSale` double NOT NULL,
  `commodityRefId` varchar(20) default NULL,
  `Description` varchar(200) default NULL,
  `Discount` double default NULL,
  `companyRefId` bigint(20) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updatedBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `activeFlag` int(2) default NULL,
  `barCode` varchar(50) default NULL,
  PRIMARY KEY  (`ItemId`),
  KEY `productName` USING BTREE (`NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Items Details';

-- ----------------------------
-- Records of items
-- ----------------------------

-- ----------------------------
-- Table structure for `login`
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `user_Id` bigint(25) NOT NULL auto_increment,
  `user_Name` varchar(25) collate utf8_swedish_ci NOT NULL,
  `password` varchar(50) collate utf8_swedish_ci NOT NULL,
  `companyId` varchar(50) collate utf8_swedish_ci NOT NULL,
  `userRights` varchar(50) collate utf8_swedish_ci NOT NULL,
  `createdTimeStamp` timestamp NULL default NULL,
  `updatedTeimStamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `activeFlag` int(1) default NULL,
  `gstType` int(2) default NULL,
  PRIMARY KEY  (`user_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('1', 'admin', 'admin', '1', '1', null, '2017-07-20 00:26:10', '1', '1');
INSERT INTO `login` VALUES ('2', 'bill', 'bill', '1', '1', null, '2017-10-15 17:49:32', '1', '1');

-- ----------------------------
-- Table structure for `modeofpayment`
-- ----------------------------
DROP TABLE IF EXISTS `modeofpayment`;
CREATE TABLE `modeofpayment` (
  `modeId` int(2) NOT NULL auto_increment,
  `modeName` varchar(200) default NULL,
  PRIMARY KEY  (`modeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of modeofpayment
-- ----------------------------
INSERT INTO `modeofpayment` VALUES ('1', 'cash');
INSERT INTO `modeofpayment` VALUES ('2', 'Online');
INSERT INTO `modeofpayment` VALUES ('3', 'Cheque');
INSERT INTO `modeofpayment` VALUES ('4', 'Demand Draft');

-- ----------------------------
-- Table structure for `openingstock`
-- ----------------------------
DROP TABLE IF EXISTS `openingstock`;
CREATE TABLE `openingstock` (
  `commodityStockId` bigint(20) NOT NULL auto_increment,
  `commodityRefId` bigint(20) NOT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `accountYearRefId` bigint(20) NOT NULL,
  `UOMRefId` bigint(20) default NULL,
  `createdBy` bigint(20) default NULL,
  `createdTimeStamp` timestamp NULL default NULL,
  `openingUOMQuantity` double NOT NULL,
  `closingUOMQuantity` double NOT NULL,
  `trialUOMQuantity` double NOT NULL,
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  `stockValue` double default NULL,
  PRIMARY KEY  (`commodityStockId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of openingstock
-- ----------------------------

-- ----------------------------
-- Table structure for `purchasebill`
-- ----------------------------
DROP TABLE IF EXISTS `purchasebill`;
CREATE TABLE `purchasebill` (
  `purchaseBillID` bigint(20) NOT NULL auto_increment,
  `purchaseBillDisplayNumber` varchar(50) NOT NULL,
  `purchaseBillDate` date default NULL,
  `CustomerID` bigint(20) default NULL,
  `ProductDiscount` double(10,2) default NULL,
  `TotalDiscount` double(10,2) default NULL,
  `cgstTotal` double NOT NULL,
  `sgstTotal` double NOT NULL,
  `igstTotal` double NOT NULL,
  `chessRate` float(2,2) NOT NULL,
  `totalChess` double NOT NULL,
  `runningTotal` double NOT NULL,
  `fright` double NOT NULL,
  `roundOff` double NOT NULL,
  `purchaseBillTotal` double NOT NULL,
  `companyRefId` int(2) NOT NULL,
  `accountYearRefId` int(2) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  `purchaseBillType` int(2) NOT NULL,
  `purchaseBillStatus` int(2) NOT NULL,
  `purchaseBillStage` int(2) NOT NULL,
  `purchaseBillLock` int(2) NOT NULL default '0',
  `purchaseBillGSTType` int(2) default NULL,
  `transport` varchar(200) default NULL,
  `bundle` int(4) default NULL,
  `addressRefId` double(20,0) default NULL,
  `vatTotal` double default NULL,
  `cstTotal` double default '0',
  `vatCstFlag` int(1) default '0',
  `reverseCharge` int(1) default NULL,
  PRIMARY KEY  (`purchaseBillID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchasebill
-- ----------------------------

-- ----------------------------
-- Table structure for `purchasebillitem`
-- ----------------------------
DROP TABLE IF EXISTS `purchasebillitem`;
CREATE TABLE `purchasebillitem` (
  `ID` double NOT NULL auto_increment,
  `purchaseBillRefId` bigint(20) NOT NULL,
  `itemRefId` bigint(20) default NULL,
  `commodityRefId` bigint(20) default NULL,
  `unitrate` double(30,2) default NULL,
  `Discount` double default NULL,
  `Quantity` double default NULL,
  `total` double default NULL,
  `chessRate` double NOT NULL,
  `chessTotal` double NOT NULL,
  `cgstRate` double NOT NULL,
  `cgstTotal` double NOT NULL,
  `sgstRate` double NOT NULL,
  `sgstTotal` double NOT NULL,
  `igstRate` double NOT NULL,
  `igstTotal` double NOT NULL,
  `UOMRefId` bigint(20) default NULL,
  `packingfactor` double default NULL,
  `totalUOMQuantity` double default NULL,
  `purchaseBillDate` date NOT NULL,
  `hsnCodeRefId` varchar(20) default NULL,
  `purchaseCustomerRefId` bigint(20) NOT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `accountYearRefId` bigint(20) NOT NULL,
  `purchaseBillType` int(2) NOT NULL,
  `purchaseBillGSTType` int(2) default NULL,
  `purchaseBillBags` int(11) default NULL,
  `vatRate` double default NULL,
  `vatTotal` double default NULL,
  `cstRate` double default NULL,
  `cstTotal` double default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchasebillitem
-- ----------------------------

-- ----------------------------
-- Table structure for `purchasepayment`
-- ----------------------------
DROP TABLE IF EXISTS `purchasepayment`;
CREATE TABLE `purchasepayment` (
  `purchasePaymentId` bigint(20) NOT NULL auto_increment,
  `purchaseBillRefId` bigint(20) default NULL,
  `paymentDate` date default NULL,
  `paymentMode` int(2) default NULL,
  `paymentAmount` double default NULL,
  `paymentDescription` varchar(200) default NULL,
  `customerRefId` bigint(20) default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  `createdBy` bigint(20) default NULL,
  `updatedBy` bigint(20) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `modeDescription` varchar(200) default NULL,
  `accountRefId` bigint(20) default NULL,
  `receiptNumber` varchar(20) default NULL,
  `billDescription` varchar(300) default NULL,
  PRIMARY KEY  (`purchasePaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of purchasepayment
-- ----------------------------

-- ----------------------------
-- Table structure for `salesbill`
-- ----------------------------
DROP TABLE IF EXISTS `salesbill`;
CREATE TABLE `salesbill` (
  `salesBillID` bigint(20) NOT NULL auto_increment,
  `salesBillNumber` bigint(20) NOT NULL,
  `salesBillDisplayNumber` varchar(50) NOT NULL,
  `salesBillDate` date default NULL,
  `CustomerID` bigint(20) default NULL,
  `ProductDiscount` double(10,2) default NULL,
  `TotalDiscount` double(10,2) default NULL,
  `cgstTotal` double NOT NULL,
  `sgstTotal` double NOT NULL,
  `igstTotal` double NOT NULL,
  `chessRate` float(2,2) NOT NULL,
  `totalChess` double NOT NULL,
  `runningTotal` double NOT NULL,
  `fright` double NOT NULL,
  `roundOff` double NOT NULL,
  `salesBillTotal` double NOT NULL,
  `companyRefId` int(2) NOT NULL,
  `accountYearRefId` int(2) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00' on update CURRENT_TIMESTAMP,
  `salesBillType` int(2) NOT NULL,
  `salesBillStatus` int(2) NOT NULL,
  `salesBillStage` int(2) NOT NULL,
  `salesBillLock` int(2) NOT NULL default '0',
  `salesBillGSTType` int(2) default NULL,
  `transport` varchar(200) default NULL,
  `bundle` int(4) default NULL,
  `addressRefId` double(20,0) default NULL,
  `cstTotal` double default NULL,
  `vatTotal` double default NULL,
  `accountRefId` double default NULL,
  `vatCstFlag` int(1) default NULL,
  `lineTotalwithtax` double default NULL,
  PRIMARY KEY  (`salesBillID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salesbill
-- ----------------------------

-- ----------------------------
-- Table structure for `salesbillitem`
-- ----------------------------
DROP TABLE IF EXISTS `salesbillitem`;
CREATE TABLE `salesbillitem` (
  `ID` double NOT NULL auto_increment,
  `salesBillRefId` bigint(20) NOT NULL,
  `itemRefId` bigint(20) default NULL,
  `commodityRefId` bigint(20) default NULL,
  `unitrate` double(30,2) default NULL,
  `Discount` double default NULL,
  `Quantity` double default NULL,
  `total` double default NULL,
  `chessRate` double NOT NULL,
  `chessTotal` double NOT NULL,
  `cgstRate` double NOT NULL,
  `cgstTotal` double NOT NULL,
  `sgstRate` double NOT NULL,
  `sgstTotal` double NOT NULL,
  `igstRate` double NOT NULL,
  `igstTotal` double NOT NULL,
  `UOMRefId` bigint(20) default NULL,
  `packingfactor` double default NULL,
  `totalUOMQuantity` double default NULL,
  `salesBillDate` date NOT NULL,
  `hsnCodeRefId` varchar(20) default NULL,
  `salesCustomerRefId` bigint(20) NOT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `accountYearRefId` bigint(20) NOT NULL,
  `salesBillType` int(2) NOT NULL,
  `salesBillGSTType` int(2) default NULL,
  `salesBillBags` int(11) default NULL,
  `cstRate` double default NULL,
  `cstTotal` double default NULL,
  `vatRate` double default NULL,
  `vatTotal` double default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salesbillitem
-- ----------------------------

-- ----------------------------
-- Table structure for `salesbillprefix`
-- ----------------------------
DROP TABLE IF EXISTS `salesbillprefix`;
CREATE TABLE `salesbillprefix` (
  `salesBillPrefixId` double(20,0) NOT NULL default '0',
  `companyRefId` double(20,0) default NULL,
  `accountYearRefId` double(20,0) default NULL,
  `salesBillPrefixValue` varchar(20) default NULL,
  `salesBillDigit` int(2) default NULL,
  `gstType` int(2) default NULL,
  PRIMARY KEY  (`salesBillPrefixId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of salesbillprefix
-- ----------------------------
INSERT INTO `salesbillprefix` VALUES ('1', '1', '1', null, '1', '1');
INSERT INTO `salesbillprefix` VALUES ('2', '1', '1', null, '1', '2');
INSERT INTO `salesbillprefix` VALUES ('3', '1', '1', null, '1', '3');

-- ----------------------------
-- Table structure for `salespayment`
-- ----------------------------
DROP TABLE IF EXISTS `salespayment`;
CREATE TABLE `salespayment` (
  `salesPaymentId` bigint(20) NOT NULL auto_increment,
  `salesBillRefId` bigint(20) default NULL,
  `paymentDate` date default NULL,
  `paymentMode` int(2) default NULL,
  `paymentAmount` double default NULL,
  `customerRefId` bigint(20) default NULL,
  `companyRefId` bigint(20) default NULL,
  `accountYearRefId` bigint(20) default NULL,
  `createdBy` bigint(20) default NULL,
  `updatedBy` bigint(20) default NULL,
  `createdTimestamp` timestamp NULL default NULL,
  `updatedTimestamp` timestamp NULL default NULL on update CURRENT_TIMESTAMP,
  `modeDescription` varchar(200) default NULL,
  `accountRefId` bigint(20) default NULL,
  `receiptNumber` bigint(20) default NULL,
  `billDescription` varchar(300) default NULL,
  PRIMARY KEY  (`salesPaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of salespayment
-- ----------------------------

-- ----------------------------
-- Table structure for `state`
-- ----------------------------
DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `stateId` bigint(20) NOT NULL auto_increment,
  `stateName` varchar(200) default NULL,
  `countryRefiId` bigint(20) default NULL,
  `activeFlag` int(1) default '1',
  `stateCode` varchar(4) default NULL,
  PRIMARY KEY  (`stateId`),
  KEY `countryReference` (`countryRefiId`),
  CONSTRAINT `countryReference` FOREIGN KEY (`countryRefiId`) REFERENCES `country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of state
-- ----------------------------
INSERT INTO `state` VALUES ('1', 'Andaman and Nicobar Islands', '1', '1', '35');
INSERT INTO `state` VALUES ('2', 'Andhra Pradesh', '1', '1', '28');
INSERT INTO `state` VALUES ('3', 'Arunachal Pradesh', '1', '1', '12');
INSERT INTO `state` VALUES ('4', 'Assam', '1', '1', '18');
INSERT INTO `state` VALUES ('5', 'Bihar', '1', '1', '10');
INSERT INTO `state` VALUES ('6', 'Chandigarh', '1', '1', '04');
INSERT INTO `state` VALUES ('7', 'Chhattisgarh', '1', '1', '22');
INSERT INTO `state` VALUES ('8', 'Dadra and Nagar Haveli', '1', '1', '26');
INSERT INTO `state` VALUES ('9', 'Daman and Diu', '1', '1', '25');
INSERT INTO `state` VALUES ('10', 'Delhi', '1', '1', '07');
INSERT INTO `state` VALUES ('11', 'Goa', '1', '1', '30');
INSERT INTO `state` VALUES ('12', 'Gujarat', '1', '1', '24');
INSERT INTO `state` VALUES ('13', 'Haryana', '1', '1', '06');
INSERT INTO `state` VALUES ('14', 'Himachal Pradesh', '1', '1', '02');
INSERT INTO `state` VALUES ('15', 'Jammu and Kashmir', '1', '1', '01');
INSERT INTO `state` VALUES ('16', 'Jharkhand', '1', '1', '20');
INSERT INTO `state` VALUES ('17', 'Karnataka', '1', '1', '29');
INSERT INTO `state` VALUES ('18', 'Kerala', '1', '1', '32');
INSERT INTO `state` VALUES ('19', 'Lakshadweep', '1', '1', '31');
INSERT INTO `state` VALUES ('20', 'Madhya Pradesh', '1', '1', '23');
INSERT INTO `state` VALUES ('21', 'Maharashtra', '1', '1', '27');
INSERT INTO `state` VALUES ('22', 'Manipur', '1', '1', '14');
INSERT INTO `state` VALUES ('23', 'Meghalaya', '1', '1', '17');
INSERT INTO `state` VALUES ('24', 'Mizoram', '1', '1', '15');
INSERT INTO `state` VALUES ('25', 'Nagaland', '1', '1', '13');
INSERT INTO `state` VALUES ('26', 'Orissa', '1', '1', '21');
INSERT INTO `state` VALUES ('27', 'Puducherry', '1', '1', '34');
INSERT INTO `state` VALUES ('28', 'Punjab', '1', '1', '03');
INSERT INTO `state` VALUES ('29', 'Rajasthan', '1', '1', '08');
INSERT INTO `state` VALUES ('30', 'Sikkim', '1', '1', '11');
INSERT INTO `state` VALUES ('31', 'Tamil Nadu', '1', '1', '33');
INSERT INTO `state` VALUES ('32', 'Telangana', '1', '1', '36');
INSERT INTO `state` VALUES ('33', 'Tripura', '1', '1', '16');
INSERT INTO `state` VALUES ('34', 'Uttar Pradesh', '1', '1', '09');
INSERT INTO `state` VALUES ('35', 'Uttarakhand', '1', '1', '05');
INSERT INTO `state` VALUES ('36', 'West Bengal', '1', '1', '19');

-- ----------------------------
-- Table structure for `stock`
-- ----------------------------
DROP TABLE IF EXISTS `stock`;
CREATE TABLE `stock` (
  `stockId` bigint(20) NOT NULL auto_increment,
  `commodityRefId` bigint(20) NOT NULL,
  `UOMId` double NOT NULL,
  `UOMQuantity` double NOT NULL,
  `date` date NOT NULL,
  `companyRefId` double NOT NULL,
  `accountYearRefId` double NOT NULL,
  `type` int(2) NOT NULL,
  `tableReferenceId` int(2) NOT NULL,
  `tableReferenceDetailId` int(2) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updatedBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`stockId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock
-- ----------------------------

-- ----------------------------
-- Table structure for `tablereference`
-- ----------------------------
DROP TABLE IF EXISTS `tablereference`;
CREATE TABLE `tablereference` (
  `referenceId` int(3) NOT NULL auto_increment,
  `referenceTable` varchar(30) NOT NULL,
  PRIMARY KEY  (`referenceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tablereference
-- ----------------------------

-- ----------------------------
-- Table structure for `uom`
-- ----------------------------
DROP TABLE IF EXISTS `uom`;
CREATE TABLE `uom` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of uom
-- ----------------------------
INSERT INTO `uom` VALUES ('1', 'Nos');

-- ----------------------------
-- Table structure for `villagecustomer`
-- ----------------------------
DROP TABLE IF EXISTS `villagecustomer`;
CREATE TABLE `villagecustomer` (
  `villagePartyId` bigint(20) NOT NULL auto_increment,
  `billRefId` bigint(20) default NULL,
  `billType` int(2) default NULL,
  `customerName` varchar(200) default NULL,
  `customerTown` varchar(200) default NULL,
  PRIMARY KEY  (`villagePartyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of villagecustomer
-- ----------------------------

-- ----------------------------
-- Procedure structure for `stockReport_Commodity_Date`
-- ----------------------------
DROP PROCEDURE IF EXISTS `stockReport_Commodity_Date`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `stockReport_Commodity_Date`(IN `FromDate` date,IN `ToDate` date,IN `Commodity` bigint,IN `FirmID` bigint,IN `AccountYear` bigint)
BEGIN
	SELECT a.date as stockdate,c.purchaseBillDisplayNumber as billnumber,
'purchase' as billtype,
CONCAT(d.`name`,', ',f.cityName) as customer,
CASE a.type
  WHEN '1' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'credit'
,
CASE a.type
  WHEN '2' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'debit'


 FROM 
stock as a
inner join purchasebillitem as b on a.tableReferenceDetailId=b.ID
inner join purchasebill as c on c.purchaseBillID=b.purchaseBillRefId
inner join customer as d on d.customerID=c.CustomerID
inner join customeraddress as e on e.addressId=c.addressRefId
inner join city as f on f.cityId=e.cityRefId
where a.tableReferenceId=4  and a.type=1 and a.commodityRefId=Commodity
and a.date between FromDate AND ToDate AND a.companyRefId=FirmID and a.accountYearRefId=AccountYear GROUP BY c.purchaseBillID


UNION

SELECT a.date as stockdate,c.salesBillDisplayNumber as billnumber,
'sales' as billtype,
CONCAT(d.`name`,', ',f.cityName) as customer,
CASE a.type
  WHEN '1' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'credit'
,
CASE a.type
  WHEN '2' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'debit'


 FROM 
stock as a
inner join salesbillitem as b on a.tableReferenceDetailId=b.ID
inner join salesbill as c on c.salesBillID=b.salesBillRefId
inner join customer as d on d.customerID=c.CustomerID
inner join customeraddress as e on e.addressId=c.addressRefId
inner join city as f on f.cityId=e.cityRefId
where a.tableReferenceId=2  and a.type=2 and a.commodityRefId=Commodity 
and a.date between FromDate AND ToDate AND a.companyRefId=FirmID and a.accountYearRefId=AccountYear GROUP BY c.salesBillID
ORDER BY stockdate;

END
;;
DELIMITER ;

-- ----------------------------
-- Procedure structure for `stockReport_Commodity_Date_Opening`
-- ----------------------------
DROP PROCEDURE IF EXISTS `stockReport_Commodity_Date_Opening`;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `stockReport_Commodity_Date_Opening`(IN `FromDate` date,IN `ToDate` date,IN `Commodity` bigint,IN `FirmID` bigint,IN `AccountYear` bigint)
BEGIN
	SELECT a.date as stockdate,c.purchaseBillDisplayNumber as billnumber,
'purchase' as billtype,
CONCAT(d.`name`,', ',f.cityName) as customer,
CASE a.type
  WHEN '1' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'credit'
,
CASE a.type
  WHEN '2' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'debit'


 FROM 
stock as a
inner join purchasebillitem as b on a.tableReferenceDetailId=b.ID
inner join purchasebill as c on c.purchaseBillID=b.purchaseBillRefId
inner join customer as d on d.customerID=c.CustomerID
inner join customeraddress as e on e.addressId=c.addressRefId
inner join city as f on f.cityId=e.cityRefId
where a.tableReferenceId=4  and a.type=1 and a.commodityRefId=Commodity
and a.date < FromDate  AND a.companyRefId=FirmID and a.accountYearRefId=AccountYear group by a.commodityRefId


UNION

SELECT a.date as stockdate,c.salesBillDisplayNumber as billnumber,
'sales' as billtype,
CONCAT(d.`name`,', ',f.cityName) as customer,
CASE a.type
  WHEN '1' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'credit'
,
CASE a.type
  WHEN '2' THEN sum(a.UOMQuantity)
  ELSE NULL
  END as 'debit'


 FROM 
stock as a
inner join salesbillitem as b on a.tableReferenceDetailId=b.ID
inner join salesbill as c on c.salesBillID=b.salesBillRefId
inner join customer as d on d.customerID=c.CustomerID
inner join customeraddress as e on e.addressId=c.addressRefId
inner join city as f on f.cityId=e.cityRefId
where a.tableReferenceId=2  and a.type=2 and a.commodityRefId=Commodity 
and a.date < FromDate AND a.companyRefId=FirmID and a.accountYearRefId=AccountYear group by a.commodityRefId
ORDER BY stockdate;

END
;;
DELIMITER ;
