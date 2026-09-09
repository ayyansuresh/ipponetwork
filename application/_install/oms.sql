/*
Navicat MySQL Data Transfer

Source Server         : ran
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : oms

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-08-23 18:49:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `account`
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `accountId` bigint(20) NOT NULL AUTO_INCREMENT,
  `accountType` int(2) NOT NULL,
  `accountName` varchar(100) NOT NULL,
  `accountNumber` varchar(100) NOT NULL,
  `companyRefId` bigint(20) DEFAULT NULL,
  `ifsCode` varchar(100) DEFAULT NULL,
  `bankAccountType` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`accountId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', '1', 'Cash In Hand', 'cash', '1', 'cash', 'cash');
INSERT INTO `account` VALUES ('2', '1', 'Cash In Hand', 'cash', '2', 'cash', 'cash');
INSERT INTO `account` VALUES ('3', '1', 'Cash In Hand', 'cash', '3', 'cash', 'cash');
INSERT INTO `account` VALUES ('4', '2', 'City Union Bank', '510909010052104', '2', 'CIUB0000090', 'Current Account');
INSERT INTO `account` VALUES ('5', '2', 'IDBI Bank', '1118102000002424', '2', 'IBKL0001118', 'Current Account');
INSERT INTO `account` VALUES ('6', '2', 'Tamilnad Mercantile Bank', '110150050800100', '1', 'TMBL0000110', 'Current Account');
INSERT INTO `account` VALUES ('7', '2', 'City Union Bank', '512020010018641', '1', 'CIUB0000090', 'OLCC');
INSERT INTO `account` VALUES ('8', '2', 'City Union Bank', '510909010035912', '1', 'CIUB0000090', 'Current Account');
INSERT INTO `account` VALUES ('9', '2', 'IDBI Bank', '1118102000002417', '1', 'IBKL0001118', 'Current Account');

-- ----------------------------
-- Table structure for `accountopeningbalance`
-- ----------------------------
DROP TABLE IF EXISTS `accountopeningbalance`;
CREATE TABLE `accountopeningbalance` (
  `accountTrialBalanceId` bigint(20) NOT NULL AUTO_INCREMENT,
  `accountRefId` bigint(20) NOT NULL,
  `OpeningBalance` double NOT NULL,
  `trialBalance` double NOT NULL,
  `closingBalance` double NOT NULL,
  `companyRefId` double(20,0) DEFAULT NULL,
  `accountYearRefId` double(20,0) DEFAULT NULL,
  PRIMARY KEY (`accountTrialBalanceId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accountopeningbalance
-- ----------------------------
INSERT INTO `accountopeningbalance` VALUES ('1', '1', '0', '23850', '7251', '1', '1');
INSERT INTO `accountopeningbalance` VALUES ('2', '2', '0', '-14500', '0', '2', '2');
INSERT INTO `accountopeningbalance` VALUES ('3', '3', '0', '-14500', '0', '3', '3');

-- ----------------------------
-- Table structure for `accounttransaction`
-- ----------------------------
DROP TABLE IF EXISTS `accounttransaction`;
CREATE TABLE `accounttransaction` (
  `accountTransactionId` bigint(20) NOT NULL AUTO_INCREMENT,
  `accountDate` date NOT NULL,
  `transactionType` int(2) NOT NULL,
  `accountRefId` bigint(20) NOT NULL,
  `amount` double NOT NULL,
  `mode` int(2) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transactionDescription` text NOT NULL,
  `tableReference` double(20,0) NOT NULL,
  `tableDetailId` double(20,0) DEFAULT NULL,
  `companyRefId` bigint(20) DEFAULT NULL,
  `accountYearRefId` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`accountTransactionId`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accounttransaction
-- ----------------------------
INSERT INTO `accounttransaction` VALUES ('2', '2017-07-03', '1', '1', '4050', '1', '1', '2017-08-10 13:03:26', '0', '2017-08-10 18:33:26', 'Cash Payment for Cash Bill Number - 397', '1', '6', '1', '1');
INSERT INTO `accounttransaction` VALUES ('3', '2017-07-03', '1', '1', '1600', '1', '1', '2017-08-10 13:06:16', '0', '2017-08-10 18:36:16', 'Cash Payment for Cash Bill Number - 400', '1', '9', '1', '1');
INSERT INTO `accounttransaction` VALUES ('4', '2017-07-03', '1', '1', '4000', '1', '1', '2017-08-10 13:07:00', '0', '2017-08-10 18:37:00', 'Cash Payment for Cash Bill Number - 401', '1', '10', '1', '1');
INSERT INTO `accounttransaction` VALUES ('5', '2017-07-04', '1', '1', '1600', '1', '1', '2017-08-11 04:44:09', '0', '2017-08-11 10:14:09', 'Cash Payment for Cash Bill Number - 416', '1', '25', '1', '1');
INSERT INTO `accounttransaction` VALUES ('6', '2017-07-05', '1', '1', '3750', '1', '1', '2017-08-11 05:05:28', '0', '2017-08-11 10:35:28', 'Cash Payment for Cash Bill Number - 432', '1', '41', '1', '1');
INSERT INTO `accounttransaction` VALUES ('7', '2017-07-05', '1', '1', '1600', '1', '1', '2017-08-11 05:07:41', '0', '2017-08-11 10:37:41', 'Cash Payment for Cash Bill Number - 433', '1', '42', '1', '1');
INSERT INTO `accounttransaction` VALUES ('8', '2017-07-01', '1', '1', '7250', '1', '1', '2017-08-11 08:26:31', '0', '2017-08-11 13:56:31', 'Cash Payment for Cash Bill Number - 395', '1', '46', '1', '1');

-- ----------------------------
-- Table structure for `accountyear`
-- ----------------------------
DROP TABLE IF EXISTS `accountyear`;
CREATE TABLE `accountyear` (
  `accountyear_id` int(5) NOT NULL AUTO_INCREMENT,
  `year` varchar(30) NOT NULL,
  PRIMARY KEY (`accountyear_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accountyear
-- ----------------------------
INSERT INTO `accountyear` VALUES ('1', '2017-2018');

-- ----------------------------
-- Table structure for `city`
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city` (
  `cityId` bigint(20) NOT NULL AUTO_INCREMENT,
  `cityName` varchar(200) DEFAULT NULL,
  `stateRefId` bigint(20) DEFAULT NULL,
  `activeFlag` int(1) DEFAULT '1',
  PRIMARY KEY (`cityId`),
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
  `commodityId` bigint(20) NOT NULL AUTO_INCREMENT,
  `commodityName` varchar(200) DEFAULT NULL,
  `commodityUOM` bigint(20) DEFAULT NULL,
  `commodityHSNCodeRef` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`commodityId`),
  UNIQUE KEY `commodityname` (`commodityName`) USING BTREE,
  KEY `commodityid` (`commodityId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of commodity
-- ----------------------------
INSERT INTO `commodity` VALUES ('1', 'Roasted coffee', '1', '09012000');
INSERT INTO `commodity` VALUES ('2', 'Orid Dal', '1', '07130000');
INSERT INTO `commodity` VALUES ('3', 'Toor Dal', '1', '07130000');
INSERT INTO `commodity` VALUES ('4', 'Moong Dal', '1', '07130000');
INSERT INTO `commodity` VALUES ('5', 'Orid Split', '1', '07130000');
INSERT INTO `commodity` VALUES ('6', 'Orid Split Black', '1', '07130000');
INSERT INTO `commodity` VALUES ('7', 'Raw coffee', '1', '09011200');
INSERT INTO `commodity` VALUES ('8', 'Coriander Seeds', '1', '09092000');
INSERT INTO `commodity` VALUES ('9', 'Refined Palm Oil', '1', '15119020');
INSERT INTO `commodity` VALUES ('10', 'Refined Sunflower Oil', '1', '15121910');
INSERT INTO `commodity` VALUES ('11', 'Chicory', '1', '21013010');
INSERT INTO `commodity` VALUES ('12', 'ORID DUST', '1', '23025000');

-- ----------------------------
-- Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `company_id` bigint(6) NOT NULL AUTO_INCREMENT,
  `company_Name_English` varchar(200) NOT NULL,
  `company_Name_Tamil` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'O.M.S.VELMURUGAN & V. VANITHA', 'O.M.S.VELMURUGAN & V. VANITHA');
INSERT INTO `company` VALUES ('2', 'YESVEE TRADERS', 'YESVEE TRADERS');
INSERT INTO `company` VALUES ('3', 'SEETHALAKSHMI TRADING COMPANY', 'SEETHALAKSHMI TRADING COMPANY');

-- ----------------------------
-- Table structure for `companyaddress`
-- ----------------------------
DROP TABLE IF EXISTS `companyaddress`;
CREATE TABLE `companyaddress` (
  `addressId` bigint(20) NOT NULL AUTO_INCREMENT,
  `companyRefId` bigint(20) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `countryRefId` bigint(20) DEFAULT NULL,
  `stateRefId` bigint(20) DEFAULT NULL,
  `cityRefId` bigint(20) DEFAULT NULL,
  `pinCode` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `addressType` int(1) DEFAULT NULL,
  `activeFlag` int(1) DEFAULT NULL,
  `accountbankName` varchar(50) DEFAULT NULL,
  `accountNumber` varchar(50) DEFAULT NULL,
  `IFS Code` varchar(50) DEFAULT NULL,
  `GST` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`addressId`),
  KEY `addressCountryRefId` (`countryRefId`),
  KEY `addressStateRefId` (`stateRefId`),
  KEY `addressCityRefId` (`cityRefId`),
  KEY `companyaddressRefId` (`companyRefId`),
  CONSTRAINT `companyaddress_ibfk_1` FOREIGN KEY (`companyRefId`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `companyaddress_ibfk_2` FOREIGN KEY (`cityRefId`) REFERENCES `city` (`cityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `companyaddress_ibfk_3` FOREIGN KEY (`countryRefId`) REFERENCES `country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `companyaddress_ibfk_4` FOREIGN KEY (`stateRefId`) REFERENCES `state` (`stateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of companyaddress
-- ----------------------------
INSERT INTO `companyaddress` VALUES ('1', '1', 'NO : 1, PERALI ROAD', null, '1', '33', '28', '626001', 'omsvelmuruganandvvanitha@gmail.com', '9843058501', '9843058501', '1', '1', null, null, null, '33AFHPV8484K1ZN');
INSERT INTO `companyaddress` VALUES ('2', '2', 'NO : 1/1 C, PERALI ROAD', null, '1', '33', '28', '626001', 'yesveetradersvnr@gmail.com', '9843058501', '9843058501', '1', '1', null, null, null, '33AABFY8060F1Z8');
INSERT INTO `companyaddress` VALUES ('3', '3', 'NO : 1, PERALI ROAD', null, '1', '33', '28', '626001', null, null, null, '1', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `countryId` bigint(10) NOT NULL AUTO_INCREMENT,
  `countryName` varchar(20) DEFAULT NULL,
  `activeFlag` int(1) DEFAULT NULL,
  PRIMARY KEY (`countryId`),
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
  `customerID` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `gstNumber` varchar(50) NOT NULL,
  `partyGstType` int(2) NOT NULL,
  `cutomerType` int(2) NOT NULL,
  `companyRefId` bigint(6) NOT NULL,
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `createdBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activeFlag` int(1) DEFAULT NULL,
  `aadharNumber` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`customerID`),
  KEY `customerCompanyRefId` (`companyRefId`),
  KEY `customerCreatedBy` (`createdBy`),
  KEY `customerGstTypeRefId` (`partyGstType`),
  KEY `customerTypeRefId` (`cutomerType`),
  KEY `customerGSTNumber` (`gstNumber`) USING BTREE,
  CONSTRAINT `customerCompanyRefId` FOREIGN KEY (`companyRefId`) REFERENCES `company` (`company_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `customerCreatedBy` FOREIGN KEY (`createdBy`) REFERENCES `login` (`user_Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `customerGstTypeRefId` FOREIGN KEY (`partyGstType`) REFERENCES `customergsttype` (`customerGstTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `customerTypeRefId` FOREIGN KEY (`cutomerType`) REFERENCES `customertype` (`customerTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('2', 'BANGARPET SHRI LAKSHMI AGRO FOODS', '29AHNPA8269K2ZN', '2', '2', '1', '0', '2017-08-08 17:27:43', '1', '2017-08-08 17:27:43', '1', '');
INSERT INTO `customer` VALUES ('3', 'PEELAL STORE', '', '1', '2', '1', '0', '2017-08-08 18:09:42', '1', '2017-08-08 18:09:42', '1', '');
INSERT INTO `customer` VALUES ('4', 'MARUTHI RESTAURANT', '33AARFS5567P2Z6', '1', '2', '1', '1', '2017-08-10 16:38:04', '1', '2017-08-08 18:24:03', '1', '');
INSERT INTO `customer` VALUES ('5', 'PANRUTI TAMILNADU MALIGAI', '', '1', '2', '1', '0', '2017-08-09 13:06:09', '1', '2017-08-09 13:06:09', '1', '');
INSERT INTO `customer` VALUES ('7', 'COUTRALLAM AATHUR MANI COFFE BAR', '', '1', '2', '1', '0', '2017-08-09 17:28:12', '1', '2017-08-09 17:28:12', '1', '');
INSERT INTO `customer` VALUES ('8', 'SHIVAMURUGAN ', '', '1', '2', '1', '0', '2017-08-09 17:32:11', '1', '2017-08-09 17:32:11', '1', '');
INSERT INTO `customer` VALUES ('9', 'HOTEL GERMANUS', '', '1', '2', '1', '0', '2017-08-09 17:36:08', '1', '2017-08-09 17:36:08', '1', '');
INSERT INTO `customer` VALUES ('10', 'HOTEL KING METRO', '33AAAFH4825N1ZC', '1', '2', '1', '1', '2017-08-10 13:11:25', '1', '2017-08-09 17:38:17', '1', '');
INSERT INTO `customer` VALUES ('11', 'HOTEL NAVEEN TEMPLE', '33AALPU4769P1ZO', '1', '2', '1', '1', '2017-08-10 13:12:07', '1', '2017-08-09 17:39:26', '1', '');
INSERT INTO `customer` VALUES ('12', 'SRI VISHNU AGENCY', '', '1', '2', '1', '0', '2017-08-09 17:41:13', '1', '2017-08-09 17:41:13', '1', '');
INSERT INTO `customer` VALUES ('13', 'TAMILRAJ STORE', '', '1', '2', '1', '0', '2017-08-09 17:45:54', '1', '2017-08-09 17:45:54', '1', '');
INSERT INTO `customer` VALUES ('14', 'F.A.ENTERPRISES', '29AAAFF3704G12Q', '2', '2', '1', '0', '2017-08-09 17:47:40', '1', '2017-08-09 17:47:40', '1', '');
INSERT INTO `customer` VALUES ('15', 'ALA MUHAMMED USUB', '', '1', '2', '1', '0', '2017-08-09 17:49:20', '1', '2017-08-09 17:49:20', '1', '');
INSERT INTO `customer` VALUES ('16', 'G.GOPALAKRISHNAN & CO', '', '1', '2', '1', '0', '2017-08-09 17:50:28', '1', '2017-08-09 17:50:28', '1', '');
INSERT INTO `customer` VALUES ('17', 'S.T.S.MALIGAI', '', '1', '2', '1', '0', '2017-08-09 17:51:32', '1', '2017-08-09 17:51:32', '1', '');
INSERT INTO `customer` VALUES ('18', 'SITHARAM & CO', '', '1', '2', '1', '0', '2017-08-09 17:52:34', '1', '2017-08-09 17:52:34', '1', '');
INSERT INTO `customer` VALUES ('19', 'SRI LAKSHMI NARA SIMMAVIBS', '', '1', '2', '1', '0', '2017-08-09 17:53:45', '1', '2017-08-09 17:53:45', '1', '');
INSERT INTO `customer` VALUES ('20', 'LAKSHMI NARAYANA BHANAN', '', '1', '2', '1', '0', '2017-08-09 17:55:11', '1', '2017-08-09 17:55:11', '1', '');
INSERT INTO `customer` VALUES ('21', 'GANESH DEPARTMENTAL STORE', '', '1', '2', '1', '0', '2017-08-09 17:56:19', '1', '2017-08-09 17:56:19', '1', '');
INSERT INTO `customer` VALUES ('22', 'AMUTHAMESS', '', '1', '2', '1', '0', '2017-08-10 17:43:50', '1', '2017-08-09 18:01:24', '0', '');
INSERT INTO `customer` VALUES ('23', 'BHARATHI BAKERY', '', '1', '2', '1', '0', '2017-08-09 18:02:11', '1', '2017-08-09 18:02:11', '1', '');
INSERT INTO `customer` VALUES ('24', 'DEVASTHANA CANTEEN', '', '1', '2', '1', '0', '2017-08-09 18:03:36', '1', '2017-08-09 18:03:36', '1', '');
INSERT INTO `customer` VALUES ('25', 'HOTEL ARCHANA', '', '1', '2', '1', '0', '2017-08-09 18:04:23', '1', '2017-08-09 18:04:23', '1', '');
INSERT INTO `customer` VALUES ('26', 'HOTEL KAVERY', '', '1', '2', '1', '0', '2017-08-09 18:05:11', '1', '2017-08-09 18:05:11', '1', '');
INSERT INTO `customer` VALUES ('27', 'HOTEL VIGNESH ', '', '1', '2', '1', '0', '2017-08-09 18:05:57', '1', '2017-08-09 18:05:57', '1', '');
INSERT INTO `customer` VALUES ('28', 'MAHARAJA', '', '1', '2', '1', '0', '2017-08-09 18:06:36', '1', '2017-08-09 18:06:36', '1', '');
INSERT INTO `customer` VALUES ('29', 'SHANMUGAN TEA STALL', '', '1', '2', '1', '0', '2017-08-09 18:07:30', '1', '2017-08-09 18:07:30', '1', '');
INSERT INTO `customer` VALUES ('30', 'NAMBIRAJAN TEA STALL', '', '1', '2', '1', '0', '2017-08-09 18:08:26', '1', '2017-08-09 18:08:26', '1', '');
INSERT INTO `customer` VALUES ('31', 'SRI SAI COFFE BAR', '', '1', '2', '1', '0', '2017-08-09 18:09:11', '1', '2017-08-09 18:09:11', '1', '');
INSERT INTO `customer` VALUES ('32', 'SRINIVASAN TEA STALL', '', '1', '2', '1', '0', '2017-08-09 18:09:53', '1', '2017-08-09 18:09:53', '1', '');
INSERT INTO `customer` VALUES ('33', 'TDS MALIGAI & RICE MANDI', '', '1', '2', '1', '0', '2017-08-09 18:10:58', '1', '2017-08-09 18:10:58', '1', '');
INSERT INTO `customer` VALUES ('34', 'NASSEM STORE', '', '1', '2', '1', '0', '2017-08-09 18:14:06', '1', '2017-08-09 18:14:06', '1', '');
INSERT INTO `customer` VALUES ('35', 'VIJAI CLASSIC', '', '1', '2', '1', '0', '2017-08-09 18:14:46', '1', '2017-08-09 18:14:46', '1', '');
INSERT INTO `customer` VALUES ('36', 'S.A.AGENCY', '', '1', '2', '1', '0', '2017-08-09 18:15:40', '1', '2017-08-09 18:15:40', '1', '');
INSERT INTO `customer` VALUES ('37', 'LAKSHMI STORE', '', '1', '2', '1', '0', '2017-08-09 18:17:51', '1', '2017-08-09 18:17:51', '1', '');
INSERT INTO `customer` VALUES ('38', 'SSM STORE', '', '1', '2', '1', '0', '2017-08-09 18:18:29', '1', '2017-08-09 18:18:29', '1', '');
INSERT INTO `customer` VALUES ('39', 'T.K.BAI', '', '1', '2', '1', '0', '2017-08-09 18:19:05', '1', '2017-08-09 18:19:05', '1', '');
INSERT INTO `customer` VALUES ('40', 'LK RAJALAKSHMI STORE', '', '1', '2', '1', '0', '2017-08-09 18:19:55', '1', '2017-08-09 18:19:55', '1', '');
INSERT INTO `customer` VALUES ('41', 'K.A.K.TRADERS', '32AEBPK1467Q1ZB', '2', '2', '1', '0', '2017-08-09 18:21:30', '1', '2017-08-09 18:21:30', '1', '');
INSERT INTO `customer` VALUES ('42', 'HOTEL ANANDHA BHAVAN', '', '1', '2', '1', '0', '2017-08-09 18:24:45', '1', '2017-08-09 18:24:45', '1', '');
INSERT INTO `customer` VALUES ('43', 'SANTHAI VIJAYAN HOTEL', '', '1', '2', '1', '0', '2017-08-09 18:27:24', '1', '2017-08-09 18:27:24', '1', '');
INSERT INTO `customer` VALUES ('44', 'SANTHAI PANDI STORE', '', '1', '2', '1', '0', '2017-08-09 18:28:09', '1', '2017-08-09 18:28:09', '1', '');
INSERT INTO `customer` VALUES ('45', 'IRAIVAN STORE', '', '1', '2', '1', '0', '2017-08-09 18:31:03', '1', '2017-08-09 18:31:03', '1', '');
INSERT INTO `customer` VALUES ('46', 'AUTOOR MANI GROUP HOTELS [P] LTD', '', '1', '2', '1', '0', '2017-08-10 09:58:34', '1', '2017-08-10 09:58:34', '1', '');
INSERT INTO `customer` VALUES ('47', 'MUHAMMED ALI MALIGAI', '', '1', '2', '1', '0', '2017-08-10 10:06:59', '1', '2017-08-10 10:06:59', '1', '');
INSERT INTO `customer` VALUES ('48', 'ARAL BHARATH TEA STALL', '', '1', '2', '1', '0', '2017-08-10 10:07:55', '1', '2017-08-10 10:07:55', '1', '');
INSERT INTO `customer` VALUES ('49', 'ARANI HOTEL ARRIYAS', '', '1', '2', '1', '0', '2017-08-10 10:08:30', '1', '2017-08-10 10:08:30', '1', '');
INSERT INTO `customer` VALUES ('50', 'HOTEL KRISHNA BHAWAN', '', '1', '2', '1', '0', '2017-08-10 10:10:10', '1', '2017-08-10 10:10:10', '1', '');
INSERT INTO `customer` VALUES ('51', 'M/S V.M.K.CHINNAPALAM', '', '2', '1', '1', '0', '2017-08-10 10:10:46', '1', '2017-08-10 10:10:46', '1', '');
INSERT INTO `customer` VALUES ('52', 'MADHUVAN ENTERPRISE', '', '2', '1', '1', '0', '2017-08-10 10:13:10', '1', '2017-08-10 10:13:10', '1', '');
INSERT INTO `customer` VALUES ('53', 'M/S VIJAY KUMAR ANIL KUMAR', '', '2', '1', '1', '0', '2017-08-10 10:20:37', '1', '2017-08-10 10:20:37', '1', '');
INSERT INTO `customer` VALUES ('54', ' KIRAN KUMAR & CO', '', '2', '1', '1', '0', '2017-08-10 10:23:05', '1', '2017-08-10 10:23:05', '1', '');
INSERT INTO `customer` VALUES ('55', ' DHANALAKSHMI STORE', '', '1', '2', '1', '0', '2017-08-10 10:32:29', '1', '2017-08-10 10:32:29', '1', '');
INSERT INTO `customer` VALUES ('56', 'PEELAL STORE (ALL READY ENTERPRISE)', '', '1', '2', '1', '0', '2017-08-10 10:35:46', '1', '2017-08-10 10:35:46', '1', '');
INSERT INTO `customer` VALUES ('57', 'PMR MEENAMMAL MALIGAI', '', '1', '2', '1', '0', '2017-08-10 10:36:57', '1', '2017-08-10 10:36:57', '1', '');
INSERT INTO `customer` VALUES ('58', 'RATHNA VALLI STORE', '', '1', '2', '1', '0', '2017-08-10 10:37:46', '1', '2017-08-10 10:37:46', '1', '');
INSERT INTO `customer` VALUES ('59', 'ANAND AGRO FOOD PvtLtd', '', '1', '2', '1', '0', '2017-08-10 10:39:08', '1', '2017-08-10 10:39:08', '1', '');
INSERT INTO `customer` VALUES ('60', 'SOLIGANALLUR ARUNA BHAVAN', '', '1', '2', '1', '0', '2017-08-10 10:40:11', '1', '2017-08-10 10:40:11', '1', '');
INSERT INTO `customer` VALUES ('61', 'GREAT INDIA EXPORT', '33ALQPK5663E1ZY', '1', '1', '1', '1', '2017-08-10 17:00:25', '1', '2017-08-10 10:42:20', '1', '');
INSERT INTO `customer` VALUES ('62', 'PRISHA ENTERPRISES', '33AAFPA3418H1ZB', '1', '1', '1', '0', '2017-08-10 10:46:28', '1', '2017-08-10 10:46:28', '1', '');
INSERT INTO `customer` VALUES ('63', 'N.C.G.NANDHA KUMARAN', '', '1', '1', '1', '0', '2017-08-10 10:49:39', '1', '2017-08-10 10:49:39', '1', '');
INSERT INTO `customer` VALUES ('64', 'SHRI LALA CORPORATION', '', '2', '1', '1', '0', '2017-08-10 10:51:54', '1', '2017-08-10 10:51:54', '1', '');
INSERT INTO `customer` VALUES ('65', 'SRI KAVI TRADERS', '', '1', '1', '1', '0', '2017-08-10 11:38:43', '1', '2017-08-10 11:38:43', '1', '');
INSERT INTO `customer` VALUES ('66', 'YASHWANT DALL MILL', '', '2', '1', '1', '0', '2017-08-10 11:41:17', '1', '2017-08-10 11:41:17', '1', '');
INSERT INTO `customer` VALUES ('67', 'VARUN TRADERS', '', '2', '1', '1', '0', '2017-08-10 11:44:33', '1', '2017-08-10 11:44:33', '1', '');
INSERT INTO `customer` VALUES ('68', 'SACHIN SHIVAJIRAO HUDE', '', '2', '1', '1', '0', '2017-08-10 11:47:01', '1', '2017-08-10 11:47:01', '1', '');
INSERT INTO `customer` VALUES ('69', 'SRI VENKATA SAI TRADERS', '', '2', '1', '1', '0', '2017-08-10 11:50:22', '1', '2017-08-10 11:50:22', '1', '');
INSERT INTO `customer` VALUES ('70', 'GOYAL & COMPANY', '', '2', '1', '1', '0', '2017-08-10 11:54:23', '1', '2017-08-10 11:54:23', '1', '');
INSERT INTO `customer` VALUES ('71', '  SOLINGANALLUR VIJAYA KUMAR', '', '1', '2', '1', '0', '2017-08-10 11:54:59', '1', '2017-08-10 11:54:59', '1', '');
INSERT INTO `customer` VALUES ('72', 'SACHIN TRADING COMPANY', '', '2', '1', '1', '0', '2017-08-10 11:56:42', '1', '2017-08-10 11:56:42', '1', '');
INSERT INTO `customer` VALUES ('73', 'HOTEL SARAVANA BHAVAN (VADA PALANI)', '33AABFH3049M1ZF', '1', '2', '1', '0', '2017-08-10 11:57:50', '1', '2017-08-10 11:57:50', '1', '');
INSERT INTO `customer` VALUES ('74', 'MATHURANTHAGAM K.E.SEKAR', '', '1', '2', '1', '0', '2017-08-10 11:58:57', '1', '2017-08-10 11:58:57', '1', '');
INSERT INTO `customer` VALUES ('75', 'M/S MANBHAR DEVI AGRO INDUSTRIES', '', '2', '1', '1', '0', '2017-08-10 11:59:02', '1', '2017-08-10 11:59:02', '1', '');
INSERT INTO `customer` VALUES ('76', 'HOTEL ABIRAMI', '', '1', '2', '1', '0', '2017-08-10 12:00:00', '1', '2017-08-10 12:00:00', '1', '');
INSERT INTO `customer` VALUES ('77', 'HOTEL GOWRI SANKAR', '', '1', '2', '1', '1', '2017-08-11 10:05:03', '1', '2017-08-10 12:01:14', '1', '');
INSERT INTO `customer` VALUES ('78', 'M/S BANSIDHAR RAMSWAROOP MEHTA', '', '2', '1', '1', '0', '2017-08-10 12:01:31', '1', '2017-08-10 12:01:31', '1', '');
INSERT INTO `customer` VALUES ('79', 'HOTEL RAMANAS', '', '1', '2', '1', '0', '2017-08-10 12:02:08', '1', '2017-08-10 12:02:08', '1', '');
INSERT INTO `customer` VALUES ('80', 'THIRUPATHI BALAJI COFFEE BAR', '', '1', '2', '1', '0', '2017-08-10 12:03:29', '1', '2017-08-10 12:03:29', '1', '');
INSERT INTO `customer` VALUES ('81', 'HOTEL MYSORE ARIYA BHAVAN', '', '1', '2', '1', '0', '2017-08-10 12:14:12', '1', '2017-08-10 12:14:12', '1', '');
INSERT INTO `customer` VALUES ('82', 'SLN COFFEE AND SPICES EXPORTS PRIVATE LIMITED', '29AAWCS9691N1ZS', '2', '1', '1', '0', '2017-08-10 12:27:59', '1', '2017-08-10 12:27:59', '1', '');
INSERT INTO `customer` VALUES ('83', 'AMBIKA CHICORY TRADERS', '33EFUPS9070H1Z0', '1', '1', '1', '0', '2017-08-10 12:30:53', '1', '2017-08-10 12:30:53', '1', '');
INSERT INTO `customer` VALUES ('84', 'SRI UMA COFFEE CURING WORKS', '', '2', '1', '1', '0', '2017-08-10 12:33:01', '1', '2017-08-10 12:33:01', '1', '');
INSERT INTO `customer` VALUES ('85', 'A.S.V.M  MOORTHI & SONS [MANI IYYAR]', '33ABGFA2266H1ZP', '1', '2', '1', '0', '2017-08-10 13:26:23', '1', '2017-08-10 13:26:23', '1', '');
INSERT INTO `customer` VALUES ('86', 'RAMESH IYYAR TB ROAD', '33AAJFH1751L1ZC', '1', '2', '1', '0', '2017-08-10 13:27:46', '1', '2017-08-10 13:27:46', '1', '');
INSERT INTO `customer` VALUES ('87', 'SRI ANKALAMMAN STORE', '33DBRPA2387L2Z1', '1', '2', '1', '0', '2017-08-10 13:39:15', '1', '2017-08-10 13:39:15', '1', '');
INSERT INTO `customer` VALUES ('88', 'S.GURU PRASATH', '33ABIFS9402M1ZV', '1', '2', '1', '0', '2017-08-10 16:05:13', '1', '2017-08-10 16:05:13', '1', '');
INSERT INTO `customer` VALUES ('89', 'MANI TEA STALL', '33ACIPM6676L1Z1', '1', '2', '1', '0', '2017-08-10 16:16:55', '1', '2017-08-10 16:16:55', '1', '');
INSERT INTO `customer` VALUES ('90', 'SAI TEJA ENTERPRISES', '32APWPS2021J1ZP', '2', '2', '1', '0', '2017-08-10 16:22:00', '1', '2017-08-10 16:22:00', '1', '');
INSERT INTO `customer` VALUES ('91', 'THATTUPURACKAL AGECOIES', '32ADSWPK9182C1Z9', '2', '2', '1', '0', '2017-08-10 16:26:01', '1', '2017-08-10 16:26:01', '1', '');
INSERT INTO `customer` VALUES ('92', 'SANMUGA DHALL MILL', '33AFEPG5590EIP', '1', '2', '1', '0', '2017-08-10 16:27:47', '1', '2017-08-10 16:27:47', '1', '');
INSERT INTO `customer` VALUES ('93', 'SRI SATHYAM STORE', '33AAAPE2433P1ZY', '1', '2', '1', '0', '2017-08-10 16:29:04', '1', '2017-08-10 16:29:04', '1', '');
INSERT INTO `customer` VALUES ('94', 'SRI VALLI MALIGAI', '33ADHPU1061C1ZX', '1', '2', '1', '0', '2017-08-10 16:30:37', '1', '2017-08-10 16:30:37', '1', '');
INSERT INTO `customer` VALUES ('95', 'TAMILNADU MALIGAI', '33AACPT9088K1Z2', '1', '2', '1', '0', '2017-08-10 16:33:22', '1', '2017-08-10 16:33:22', '1', '');
INSERT INTO `customer` VALUES ('96', 'M.S.P TRADERS', '33BHNPT1995A1Z9', '1', '2', '1', '0', '2017-08-10 16:37:11', '1', '2017-08-10 16:37:11', '1', '');
INSERT INTO `customer` VALUES ('97', 'MARUTHI A/C RESTAURANT', '33AFWPR8506F1Z0', '1', '2', '1', '0', '2017-08-10 16:39:39', '1', '2017-08-10 16:39:39', '1', '');
INSERT INTO `customer` VALUES ('98', 'HOTEL AATHY', '', '1', '2', '1', '0', '2017-08-10 17:14:48', '1', '2017-08-10 17:14:48', '1', '');
INSERT INTO `customer` VALUES ('99', 'SRIVARI COFFEE BAR, GANDHI ROAD', '', '1', '2', '1', '1', '2017-08-10 17:16:22', '1', '2017-08-10 17:15:30', '1', '');
INSERT INTO `customer` VALUES ('100', 'SRIVARI COFFEE BAR, MAIN BAZAAR', '', '1', '2', '1', '0', '2017-08-10 17:17:05', '1', '2017-08-10 17:17:05', '1', '');
INSERT INTO `customer` VALUES ('101', 'VASANTHA VIHAR', '', '1', '2', '1', '0', '2017-08-10 17:17:57', '1', '2017-08-10 17:17:57', '1', '');
INSERT INTO `customer` VALUES ('102', 'M. PANDIYARAJAN', '', '1', '2', '1', '0', '2017-08-10 17:18:44', '1', '2017-08-10 17:18:44', '1', '');
INSERT INTO `customer` VALUES ('103', 'JTC FLOUR MILL', '', '1', '2', '1', '0', '2017-08-10 17:19:46', '1', '2017-08-10 17:19:46', '1', '');
INSERT INTO `customer` VALUES ('104', 'NANDHINI TRADERS', '', '1', '2', '1', '0', '2017-08-10 17:20:18', '1', '2017-08-10 17:20:18', '1', '');
INSERT INTO `customer` VALUES ('105', 'S.S. JWAALA SRI TRADERS', '', '1', '2', '1', '0', '2017-08-10 17:20:59', '1', '2017-08-10 17:20:59', '1', '');
INSERT INTO `customer` VALUES ('106', 'S.S. SRIDEVI TRADERS', '', '1', '2', '1', '0', '2017-08-10 17:21:33', '1', '2017-08-10 17:21:33', '1', '');
INSERT INTO `customer` VALUES ('107', 'HOTEL GOWRINIVAS', '', '1', '2', '1', '0', '2017-08-10 17:22:31', '1', '2017-08-10 17:22:31', '1', '');
INSERT INTO `customer` VALUES ('108', 'SRIVAIKUNDAM AATHUR MANI HOTEL', '', '1', '2', '1', '0', '2017-08-10 17:25:18', '1', '2017-08-10 17:25:18', '1', '');
INSERT INTO `customer` VALUES ('109', 'AMUTHA MESS', '', '1', '2', '1', '0', '2017-08-10 17:25:47', '1', '2017-08-10 17:25:47', '1', '');
INSERT INTO `customer` VALUES ('110', 'HOTEL BANU BRINDAVAN', '', '1', '2', '1', '0', '2017-08-10 17:28:59', '1', '2017-08-10 17:28:59', '1', '');
INSERT INTO `customer` VALUES ('111', 'HOTEL VASANTHAM', '', '1', '2', '1', '0', '2017-08-10 17:29:43', '1', '2017-08-10 17:29:43', '1', '');
INSERT INTO `customer` VALUES ('112', 'HOTEL BRINDAVAN', '', '1', '2', '1', '0', '2017-08-10 17:30:19', '1', '2017-08-10 17:30:19', '1', '');
INSERT INTO `customer` VALUES ('113', 'SRI KRISHNA DEPARTMENTAL STORE', '', '1', '2', '1', '0', '2017-08-10 17:31:47', '1', '2017-08-10 17:31:47', '1', '');
INSERT INTO `customer` VALUES ('114', 'V. ARUNACHALAM IYER AND SONS (P) LIMITED ULAVAR SANTHAI', '', '1', '2', '1', '0', '2017-08-10 17:34:32', '1', '2017-08-10 17:34:32', '1', '');
INSERT INTO `customer` VALUES ('115', 'V. ARUNACHALAM IYER AND SONS (P) LIMITED KITCHEN', '', '1', '2', '1', '0', '2017-08-10 17:35:42', '1', '2017-08-10 17:35:42', '1', '');
INSERT INTO `customer` VALUES ('116', 'HOTEL SAKTHI GANESH', '', '1', '2', '1', '0', '2017-08-10 18:25:16', '1', '2017-08-10 18:25:16', '1', '');
INSERT INTO `customer` VALUES ('117', 'TAN TEA', '', '1', '2', '1', '0', '2017-08-11 10:11:58', '1', '2017-08-11 10:11:58', '1', '');
INSERT INTO `customer` VALUES ('118', 'VASANTHAM', '', '1', '2', '1', '0', '2017-08-11 10:30:06', '1', '2017-08-11 10:30:06', '1', '');

-- ----------------------------
-- Table structure for `customeraddress`
-- ----------------------------
DROP TABLE IF EXISTS `customeraddress`;
CREATE TABLE `customeraddress` (
  `addressId` bigint(20) NOT NULL AUTO_INCREMENT,
  `customerRefId` bigint(20) DEFAULT NULL,
  `address1` varchar(200) DEFAULT NULL,
  `address2` varchar(200) DEFAULT NULL,
  `countryRefId` bigint(20) DEFAULT NULL,
  `stateRefId` bigint(20) DEFAULT NULL,
  `cityRefId` bigint(20) DEFAULT NULL,
  `pinCode` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `addressType` int(1) DEFAULT NULL,
  `activeFlag` int(1) DEFAULT NULL,
  `createdBy` double(20,0) DEFAULT NULL,
  `updateBy` double(20,0) DEFAULT NULL,
  `createdTimestamp` timestamp NULL DEFAULT NULL,
  `updatedTimestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`addressId`),
  KEY `addressCountryRefId` (`countryRefId`),
  KEY `addressStateRefId` (`stateRefId`),
  KEY `addressCityRefId` (`cityRefId`),
  KEY `addressCustomerRefId` (`customerRefId`),
  CONSTRAINT `addressCityRefId` FOREIGN KEY (`cityRefId`) REFERENCES `city` (`cityId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `addressCountryRefId` FOREIGN KEY (`countryRefId`) REFERENCES `country` (`countryId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `addressCustomerRefId` FOREIGN KEY (`customerRefId`) REFERENCES `customer` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `addressStateRefId` FOREIGN KEY (`stateRefId`) REFERENCES `state` (`stateId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customeraddress
-- ----------------------------
INSERT INTO `customeraddress` VALUES ('1', '2', '', '', '1', '17', '1406', '', '', '', '', '1', '1', '1', null, '2017-08-08 17:27:43', null);
INSERT INTO `customeraddress` VALUES ('2', '3', '', '', '1', '31', '1387', '', '', '', '', '1', '1', '1', null, '2017-08-08 18:09:42', null);
INSERT INTO `customeraddress` VALUES ('3', '4', '', '', '1', '31', '6', '', '', '', '', '1', '0', '1', null, '2017-08-08 18:24:03', '2017-08-10 16:38:04');
INSERT INTO `customeraddress` VALUES ('4', '5', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-09 13:06:09', null);
INSERT INTO `customeraddress` VALUES ('6', '7', '', '', '1', '31', '1388', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:28:12', null);
INSERT INTO `customeraddress` VALUES ('7', '8', '', '', '1', '31', '18', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:32:11', null);
INSERT INTO `customeraddress` VALUES ('8', '9', '', '', '1', '31', '9', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:36:08', null);
INSERT INTO `customeraddress` VALUES ('9', '10', '', '', '1', '31', '9', '', '', '', '', '1', '0', '1', null, '2017-08-09 17:38:17', '2017-08-10 13:11:25');
INSERT INTO `customeraddress` VALUES ('10', '11', '', '', '1', '31', '9', '', '', '', '', '1', '0', '1', null, '2017-08-09 17:39:26', '2017-08-10 13:12:07');
INSERT INTO `customeraddress` VALUES ('11', '12', '', '', '1', '31', '9', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:41:13', null);
INSERT INTO `customeraddress` VALUES ('12', '13', '', '', '1', '31', '1408', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:45:54', null);
INSERT INTO `customeraddress` VALUES ('13', '14', '', '', '1', '17', '927', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:47:40', null);
INSERT INTO `customeraddress` VALUES ('14', '15', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:49:20', null);
INSERT INTO `customeraddress` VALUES ('15', '16', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:50:28', null);
INSERT INTO `customeraddress` VALUES ('16', '17', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:51:32', null);
INSERT INTO `customeraddress` VALUES ('17', '18', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:52:34', null);
INSERT INTO `customeraddress` VALUES ('18', '19', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:53:45', null);
INSERT INTO `customeraddress` VALUES ('19', '20', '', '', '1', '31', '33', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:55:11', null);
INSERT INTO `customeraddress` VALUES ('20', '21', '', '', '1', '31', '27', '', '', '', '', '1', '1', '1', null, '2017-08-09 17:56:19', null);
INSERT INTO `customeraddress` VALUES ('21', '22', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:01:24', null);
INSERT INTO `customeraddress` VALUES ('22', '23', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:02:11', null);
INSERT INTO `customeraddress` VALUES ('23', '24', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:03:36', null);
INSERT INTO `customeraddress` VALUES ('24', '25', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:04:23', null);
INSERT INTO `customeraddress` VALUES ('25', '26', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:05:11', null);
INSERT INTO `customeraddress` VALUES ('26', '27', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:05:57', null);
INSERT INTO `customeraddress` VALUES ('27', '28', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:06:36', null);
INSERT INTO `customeraddress` VALUES ('28', '29', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:07:30', null);
INSERT INTO `customeraddress` VALUES ('29', '30', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:08:26', null);
INSERT INTO `customeraddress` VALUES ('30', '31', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:09:11', null);
INSERT INTO `customeraddress` VALUES ('31', '32', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:09:53', null);
INSERT INTO `customeraddress` VALUES ('32', '33', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:10:58', null);
INSERT INTO `customeraddress` VALUES ('33', '34', '', '', '1', '31', '1410', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:14:06', null);
INSERT INTO `customeraddress` VALUES ('34', '35', '', '', '1', '31', '1410', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:14:46', null);
INSERT INTO `customeraddress` VALUES ('35', '36', '', '', '1', '31', '16', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:15:40', null);
INSERT INTO `customeraddress` VALUES ('36', '37', '', '', '1', '31', '1411', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:17:51', null);
INSERT INTO `customeraddress` VALUES ('37', '38', '', '', '1', '31', '1411', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:18:29', null);
INSERT INTO `customeraddress` VALUES ('38', '39', '', '', '1', '31', '1411', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:19:05', null);
INSERT INTO `customeraddress` VALUES ('39', '40', '', '', '1', '31', '1411', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:19:55', null);
INSERT INTO `customeraddress` VALUES ('40', '41', '', '', '1', '18', '64', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:21:30', null);
INSERT INTO `customeraddress` VALUES ('41', '42', '', '', '1', '31', '1412', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:24:45', null);
INSERT INTO `customeraddress` VALUES ('42', '43', '', '', '1', '31', '1413', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:27:24', null);
INSERT INTO `customeraddress` VALUES ('43', '44', '', '', '1', '31', '1413', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:28:09', null);
INSERT INTO `customeraddress` VALUES ('44', '45', '', '', '1', '31', '1414', '', '', '', '', '1', '1', '1', null, '2017-08-09 18:31:03', null);
INSERT INTO `customeraddress` VALUES ('45', '46', '', '', '1', '31', '6', '', '', '', '', '1', '1', '1', null, '2017-08-10 09:58:34', null);
INSERT INTO `customeraddress` VALUES ('46', '47', '', '', '1', '31', '1416', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:06:59', null);
INSERT INTO `customeraddress` VALUES ('47', '48', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:07:55', null);
INSERT INTO `customeraddress` VALUES ('48', '49', '', '', '1', '31', '1417', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:08:30', null);
INSERT INTO `customeraddress` VALUES ('49', '50', '', '', '1', '31', '1418', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:10:10', null);
INSERT INTO `customeraddress` VALUES ('50', '51', '8/1311/3, NEHRU KUNJ', '', '1', '17', '929', '585104', 'vmkcnadar@gmail.com', '08472-268730', '', '1', '1', '1', null, '2017-08-10 10:10:46', null);
INSERT INTO `customeraddress` VALUES ('51', '52', 'SHOP NO B -124, NEW MARKETING YARD', '', '1', '12', '830', '', '', '', '9825547295', '1', '1', '1', null, '2017-08-10 10:13:10', null);
INSERT INTO `customeraddress` VALUES ('52', '53', 'C-7, MANDI YARD', '', '1', '29', '1422', '325205', '', '07453-230981', '9414190981', '1', '1', '1', null, '2017-08-10 10:20:37', null);
INSERT INTO `customeraddress` VALUES ('53', '54', '', '', '1', '29', '1422', '325205', '', '', '9414191241', '1', '1', '1', null, '2017-08-10 10:23:05', null);
INSERT INTO `customeraddress` VALUES ('54', '55', '', '', '1', '31', '43', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:32:29', null);
INSERT INTO `customeraddress` VALUES ('55', '56', '', '', '1', '31', '43', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:35:46', null);
INSERT INTO `customeraddress` VALUES ('56', '57', '', '', '1', '31', '43', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:36:57', null);
INSERT INTO `customeraddress` VALUES ('57', '58', '', '', '1', '31', '43', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:37:46', null);
INSERT INTO `customeraddress` VALUES ('58', '59', '', '', '1', '31', '1', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:39:08', null);
INSERT INTO `customeraddress` VALUES ('59', '60', '', '', '1', '31', '1', '', '', '', '', '1', '1', '1', null, '2017-08-10 10:40:11', null);
INSERT INTO `customeraddress` VALUES ('60', '61', 'NO 19, THIRUNAVUKKARASU GARDEN, 4TH LANE, KORUKKUPET', '', '1', '31', '1', '600021', 'greatindiaexport75@gmail.com', '', '9500118698', '1', '0', '1', null, '2017-08-10 10:42:20', '2017-08-10 17:00:25');
INSERT INTO `customeraddress` VALUES ('61', '62', '25/10, FLAG STAFF STREET', '', '1', '31', '1', '600013', '', '', '', '1', '1', '1', null, '2017-08-10 10:46:28', null);
INSERT INTO `customeraddress` VALUES ('62', '63', '83, A.P.S. GIRLS SCHOOL STREET, LINK ROAD, NATARAJ ILLAM', '', '1', '31', '28', '626001', '', '04562-420736', '9443384486', '1', '1', '1', null, '2017-08-10 10:49:39', null);
INSERT INTO `customeraddress` VALUES ('63', '64', 'STATION ROAD, PANELI MOTI', '', '1', '12', '830', '360480', '', '02826-276733', '9979053733', '1', '1', '1', null, '2017-08-10 10:51:54', null);
INSERT INTO `customeraddress` VALUES ('64', '65', '458/1, MOOLAPILLAIYAR KOVIL', '', '1', '31', '1423', '636005', '', '0427-2225140', '9443665140', '1', '1', '1', null, '2017-08-10 11:38:43', null);
INSERT INTO `customeraddress` VALUES ('65', '66', 'BIDAR ROAD, MALEWADI, UDGIR', '', '1', '21', '995', '413517', 'dattatrayabiradar2009@gmail.com', '', '', '1', '1', '1', null, '2017-08-10 11:41:17', null);
INSERT INTO `customeraddress` VALUES ('66', '67', 'MARKET YARD, UDGIR', '', '1', '21', '995', '413517', '', '02385-256232', '9923226668', '1', '1', '1', null, '2017-08-10 11:44:33', null);
INSERT INTO `customeraddress` VALUES ('67', '68', 'SHOP NO 72 C, MARKET YARD', '', '1', '21', '995', '413512', '', '02382-256211', '9422611533', '1', '1', '1', null, '2017-08-10 11:47:01', null);
INSERT INTO `customeraddress` VALUES ('68', '69', 'D. NO 20-9-33, BLOCK NO 5, 1ST FLOOR, PUSHPA COMPLEX, ETUKURU ROAD', '', '1', '2', '290', '522003', 'ychandrasekharao@gmail.com', '', '9441045058', '1', '1', '1', null, '2017-08-10 11:50:22', null);
INSERT INTO `customeraddress` VALUES ('69', '70', 'STATION ROAD', '', '1', '20', '1424', '458441', 'anilgoyal18181@gmail.com', '', '9425106481', '1', '1', '1', null, '2017-08-10 11:54:23', null);
INSERT INTO `customeraddress` VALUES ('70', '71', '', '', '1', '31', '1', '', '', '', '', '1', '1', '1', null, '2017-08-10 11:54:59', null);
INSERT INTO `customeraddress` VALUES ('71', '72', 'HUDE BUILDING, ADAT LINE, NEW MONDHA, MARKET YARD, UDGIR', '', '1', '21', '995', '', '', '', '9422611527', '1', '1', '1', null, '2017-08-10 11:56:42', null);
INSERT INTO `customeraddress` VALUES ('72', '73', '', '', '1', '31', '1', '', '', '', '', '1', '1', '1', null, '2017-08-10 11:57:50', null);
INSERT INTO `customeraddress` VALUES ('73', '74', '', '', '1', '31', '1', '', '', '', '', '1', '1', '1', null, '2017-08-10 11:58:57', null);
INSERT INTO `customeraddress` VALUES ('74', '75', 'F-21, AGRO FOOD PARK, RANPUR', '', '1', '29', '1112', '325009', '', '', '9829037191', '1', '1', '1', null, '2017-08-10 11:59:02', null);
INSERT INTO `customeraddress` VALUES ('75', '76', '', '', '1', '31', '1421', '', '', '', '', '1', '1', '1', null, '2017-08-10 12:00:00', null);
INSERT INTO `customeraddress` VALUES ('76', '77', '', '', '1', '31', '16', '', '', '', '', '1', '0', '1', null, '2017-08-10 12:01:14', '2017-08-11 10:05:03');
INSERT INTO `customeraddress` VALUES ('77', '78', 'B-78, NEW BHAMASHAH MANDI, ANANTPURA', '', '1', '29', '1112', '324005', '', '', '9829037073', '1', '1', '1', null, '2017-08-10 12:01:31', null);
INSERT INTO `customeraddress` VALUES ('78', '79', '', '', '1', '31', '16', '', '', '', '', '1', '1', '1', null, '2017-08-10 12:02:08', null);
INSERT INTO `customeraddress` VALUES ('79', '80', '', '', '1', '31', '16', '', '', '', '', '1', '1', '1', null, '2017-08-10 12:03:29', null);
INSERT INTO `customeraddress` VALUES ('80', '81', '', '', '1', '31', '16', '', '', '', '', '1', '1', '1', null, '2017-08-10 12:14:12', null);
INSERT INTO `customeraddress` VALUES ('81', '82', 'PB NO 47, KIADB INDUSTRIAL AREA, KUDLUR', '', '1', '17', '1425', '571234', '', '', '', '1', '1', '1', null, '2017-08-10 12:27:59', null);
INSERT INTO `customeraddress` VALUES ('82', '83', '3/118, THIRAVIYANANTHAPURAM, ROSALPATTI', '', '1', '31', '28', '626001', 'mahaaranichicory@yahoo.co.in', '', '9843814789', '1', '1', '1', null, '2017-08-10 12:30:53', null);
INSERT INTO `customeraddress` VALUES ('83', '84', 'PLOT NO 8, INDUSTRIAL AREA, KUDLUR', '', '1', '17', '1425', '571234', '', '', '', '1', '1', '1', null, '2017-08-10 12:33:01', null);
INSERT INTO `customeraddress` VALUES ('84', '10', '', '', '1', '31', '9', '', '', '', '', '1', '1', null, '1', '2017-08-10 13:11:25', null);
INSERT INTO `customeraddress` VALUES ('85', '11', '', '', '1', '31', '9', '', '', '', '', '1', '1', null, '1', '2017-08-10 13:12:07', null);
INSERT INTO `customeraddress` VALUES ('86', '85', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-10 13:26:23', null);
INSERT INTO `customeraddress` VALUES ('87', '86', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-10 13:27:46', null);
INSERT INTO `customeraddress` VALUES ('88', '87', '', '', '1', '31', '1415', '', '', '', '', '1', '1', '1', null, '2017-08-10 13:39:15', null);
INSERT INTO `customeraddress` VALUES ('89', '88', '', '', '1', '31', '1407', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:05:13', null);
INSERT INTO `customeraddress` VALUES ('90', '89', '', '', '1', '31', '1426', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:16:55', null);
INSERT INTO `customeraddress` VALUES ('91', '90', '', '', '1', '18', '1427', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:22:00', null);
INSERT INTO `customeraddress` VALUES ('92', '91', '', '', '1', '18', '64', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:26:01', null);
INSERT INTO `customeraddress` VALUES ('93', '92', '', '', '1', '31', '1412', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:27:47', null);
INSERT INTO `customeraddress` VALUES ('94', '93', '', '', '1', '31', '1407', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:29:04', null);
INSERT INTO `customeraddress` VALUES ('95', '94', '', '', '1', '31', '1396', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:30:37', null);
INSERT INTO `customeraddress` VALUES ('96', '95', '', '', '1', '31', '1407', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:33:22', null);
INSERT INTO `customeraddress` VALUES ('97', '96', '', '', '1', '31', '1428', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:37:11', null);
INSERT INTO `customeraddress` VALUES ('98', '4', '', '', '1', '31', '6', '', '', '', '', '1', '1', null, '1', '2017-08-10 16:38:04', null);
INSERT INTO `customeraddress` VALUES ('99', '97', '', '', '1', '31', '6', '', '', '', '', '1', '1', '1', null, '2017-08-10 16:39:39', null);
INSERT INTO `customeraddress` VALUES ('100', '61', 'NO 19, THIRUNAVUKKARASU GARDEN, 4TH LANE, KORUKKUPET', '', '1', '31', '1', '600021', 'greatindiaexport75@gmail.com', '', '9500118698', '1', '1', null, '1', '2017-08-10 17:00:25', null);
INSERT INTO `customeraddress` VALUES ('101', '98', '', '', '1', '31', '5', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:14:48', null);
INSERT INTO `customeraddress` VALUES ('102', '99', '', '', '1', '31', '5', '', '', '', '', '1', '0', '1', null, '2017-08-10 17:15:30', '2017-08-10 17:16:22');
INSERT INTO `customeraddress` VALUES ('103', '99', 'GANDHI ROAD', '', '1', '31', '5', '', '', '', '', '1', '1', null, '1', '2017-08-10 17:16:22', null);
INSERT INTO `customeraddress` VALUES ('104', '100', 'MAIN BAZAAR', '', '1', '31', '5', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:17:05', null);
INSERT INTO `customeraddress` VALUES ('105', '101', '', '', '1', '31', '5', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:17:57', null);
INSERT INTO `customeraddress` VALUES ('106', '102', '', '', '1', '31', '28', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:18:44', null);
INSERT INTO `customeraddress` VALUES ('107', '103', '', '', '1', '31', '28', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:19:46', null);
INSERT INTO `customeraddress` VALUES ('108', '104', '', '', '1', '31', '28', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:20:18', null);
INSERT INTO `customeraddress` VALUES ('109', '105', '', '', '1', '31', '28', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:20:59', null);
INSERT INTO `customeraddress` VALUES ('110', '106', '', '', '1', '31', '28', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:21:33', null);
INSERT INTO `customeraddress` VALUES ('111', '107', '', '', '1', '31', '20', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:22:31', null);
INSERT INTO `customeraddress` VALUES ('112', '108', '', '', '1', '31', '1429', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:25:18', null);
INSERT INTO `customeraddress` VALUES ('113', '109', '', '', '1', '31', '1409', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:25:47', null);
INSERT INTO `customeraddress` VALUES ('114', '110', '', '', '1', '31', '12', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:28:59', null);
INSERT INTO `customeraddress` VALUES ('115', '111', '', '', '1', '31', '12', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:29:43', null);
INSERT INTO `customeraddress` VALUES ('116', '112', '', '', '1', '31', '12', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:30:19', null);
INSERT INTO `customeraddress` VALUES ('117', '113', '', '', '1', '31', '1430', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:31:47', null);
INSERT INTO `customeraddress` VALUES ('118', '114', '', '', '1', '31', '6', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:34:32', null);
INSERT INTO `customeraddress` VALUES ('119', '115', '', '', '1', '31', '6', '', '', '', '', '1', '1', '1', null, '2017-08-10 17:35:42', null);
INSERT INTO `customeraddress` VALUES ('120', '116', '', '', '1', '31', '20', '', '', '', '', '1', '1', '1', null, '2017-08-10 18:25:16', null);
INSERT INTO `customeraddress` VALUES ('121', '77', '', '', '1', '31', '18', '', '', '', '', '1', '1', null, '1', '2017-08-11 10:05:03', null);
INSERT INTO `customeraddress` VALUES ('122', '117', '', '', '1', '31', '9', '', '', '', '', '1', '1', '1', null, '2017-08-11 10:11:58', null);
INSERT INTO `customeraddress` VALUES ('123', '118', '', '', '1', '31', '12', '', '', '', '', '1', '1', '1', null, '2017-08-11 10:30:06', null);

-- ----------------------------
-- Table structure for `customergsttype`
-- ----------------------------
DROP TABLE IF EXISTS `customergsttype`;
CREATE TABLE `customergsttype` (
  `customerGstTypeId` int(1) NOT NULL AUTO_INCREMENT,
  `customerGstTypeName` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`customerGstTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

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
  `customerTrialBalanceId` bigint(20) NOT NULL AUTO_INCREMENT,
  `customerRefId` bigint(20) DEFAULT NULL,
  `customerOpeningBalance` double DEFAULT NULL,
  `customerClosingBalance` double DEFAULT NULL,
  `customerTrialBalance` double DEFAULT NULL,
  `companyRefId` bigint(20) DEFAULT NULL,
  `accountYearRefId` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`customerTrialBalanceId`),
  UNIQUE KEY `customer_company_account` (`customerRefId`,`companyRefId`,`accountYearRefId`) USING BTREE,
  CONSTRAINT `customeropeningbalance_ibfk_1` FOREIGN KEY (`customerRefId`) REFERENCES `customer` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=354 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customeropeningbalance
-- ----------------------------
INSERT INTO `customeropeningbalance` VALUES ('3', '2', '0', '-1380000', '-1380000', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('4', '2', '0', '1380000', '1380000', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('5', '2', '0', '1380000', '1380000', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('6', '3', '0', '-20200', '-20200', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('7', '3', '0', '16400', '16400', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('8', '3', '0', '16400', '16400', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('9', '4', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('10', '4', '0', '5400', '5400', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('11', '4', '0', '5400', '5400', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('12', '5', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('13', '5', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('14', '5', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('18', '7', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('19', '7', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('20', '7', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('21', '8', '0', '-3902', '-3902', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('22', '8', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('23', '8', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('24', '9', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('25', '9', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('26', '9', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('27', '10', '0', '-1400', '-1400', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('28', '10', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('29', '10', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('30', '11', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('31', '11', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('32', '11', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('33', '12', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('34', '12', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('35', '12', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('36', '13', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('37', '13', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('38', '13', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('39', '14', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('40', '14', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('41', '14', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('42', '15', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('43', '15', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('44', '15', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('45', '16', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('46', '16', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('47', '16', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('48', '17', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('49', '17', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('50', '17', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('51', '18', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('52', '18', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('53', '18', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('54', '19', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('55', '19', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('56', '19', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('57', '20', '0', '-8004', '-8004', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('58', '20', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('59', '20', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('60', '21', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('61', '21', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('62', '21', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('63', '22', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('64', '22', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('65', '22', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('66', '23', '0', '-6758', '-6758', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('67', '23', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('68', '23', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('69', '24', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('70', '24', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('71', '24', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('72', '25', '0', '-5040', '-5040', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('73', '25', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('74', '25', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('75', '26', '0', '-6003', '-6003', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('76', '26', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('77', '26', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('78', '27', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('79', '27', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('80', '27', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('81', '28', '0', '-7500', '-7500', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('82', '28', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('83', '28', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('84', '29', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('85', '29', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('86', '29', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('87', '30', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('88', '30', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('89', '30', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('90', '31', '0', '-4802', '-4802', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('91', '31', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('92', '31', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('93', '32', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('94', '32', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('95', '32', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('96', '33', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('97', '33', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('98', '33', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('99', '34', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('100', '34', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('101', '34', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('102', '35', '0', '-4502', '-4502', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('103', '35', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('104', '35', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('105', '36', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('106', '36', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('107', '36', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('108', '37', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('109', '37', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('110', '37', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('111', '38', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('112', '38', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('113', '38', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('114', '39', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('115', '39', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('116', '39', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('117', '40', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('118', '40', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('119', '40', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('120', '41', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('121', '41', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('122', '41', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('123', '42', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('124', '42', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('125', '42', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('126', '43', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('127', '43', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('128', '43', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('129', '44', '0', '-10350', '-10350', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('130', '44', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('131', '44', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('132', '45', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('133', '45', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('134', '45', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('135', '46', '0', '-12806', '-12806', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('136', '46', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('137', '46', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('138', '47', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('139', '47', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('140', '47', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('141', '48', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('142', '48', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('143', '48', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('144', '49', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('145', '49', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('146', '49', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('147', '50', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('148', '50', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('149', '50', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('150', '51', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('151', '51', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('152', '51', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('153', '52', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('154', '52', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('155', '52', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('156', '53', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('157', '53', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('158', '53', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('159', '54', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('160', '54', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('161', '54', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('162', '55', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('163', '55', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('164', '55', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('165', '56', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('166', '56', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('167', '56', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('168', '57', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('169', '57', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('170', '57', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('171', '58', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('172', '58', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('173', '58', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('174', '59', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('175', '59', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('176', '59', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('177', '60', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('178', '60', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('179', '60', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('180', '61', '0', '23602298', '23602298', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('181', '61', '0', '3922278', '3922278', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('182', '61', '0', '3922278', '3922278', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('183', '62', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('184', '62', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('185', '62', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('186', '63', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('187', '63', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('188', '63', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('189', '64', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('190', '64', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('191', '64', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('192', '65', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('193', '65', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('194', '65', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('195', '66', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('196', '66', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('197', '66', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('198', '67', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('199', '67', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('200', '67', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('201', '68', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('202', '68', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('203', '68', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('204', '69', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('205', '69', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('206', '69', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('207', '70', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('208', '70', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('209', '70', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('210', '71', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('211', '71', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('212', '71', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('213', '72', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('214', '72', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('215', '72', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('216', '73', '0', '-765000', '-765000', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('217', '73', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('218', '73', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('219', '74', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('220', '74', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('221', '74', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('222', '75', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('223', '75', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('224', '75', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('225', '76', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('226', '76', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('227', '76', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('228', '77', '0', '-10202', '-10202', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('229', '77', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('230', '77', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('231', '78', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('232', '78', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('233', '78', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('234', '79', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('235', '79', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('236', '79', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('237', '80', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('238', '80', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('239', '80', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('240', '81', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('241', '81', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('242', '81', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('243', '82', '0', '911880', '911880', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('244', '82', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('245', '82', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('246', '83', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('247', '83', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('248', '83', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('249', '84', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('250', '84', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('251', '84', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('252', '85', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('253', '85', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('254', '85', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('255', '86', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('256', '86', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('257', '86', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('258', '87', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('259', '87', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('260', '87', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('261', '88', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('262', '88', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('263', '88', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('264', '89', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('265', '89', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('266', '89', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('267', '90', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('268', '90', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('269', '90', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('270', '91', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('271', '91', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('272', '91', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('273', '92', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('274', '92', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('275', '92', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('276', '93', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('277', '93', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('278', '93', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('279', '94', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('280', '94', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('281', '94', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('282', '95', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('283', '95', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('284', '95', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('285', '96', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('286', '96', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('287', '96', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('288', '97', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('289', '97', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('290', '97', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('291', '98', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('292', '98', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('293', '98', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('294', '99', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('295', '99', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('296', '99', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('297', '100', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('298', '100', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('299', '100', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('300', '101', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('301', '101', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('302', '101', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('303', '102', '0', '-27200', '-27200', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('304', '102', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('305', '102', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('306', '103', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('307', '103', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('308', '103', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('309', '104', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('310', '104', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('311', '104', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('312', '105', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('313', '105', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('314', '105', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('315', '106', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('316', '106', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('317', '106', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('318', '107', '0', '-3403', '-3403', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('319', '107', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('320', '107', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('321', '108', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('322', '108', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('323', '108', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('324', '109', '0', '-2500', '-2500', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('325', '109', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('326', '109', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('327', '110', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('328', '110', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('329', '110', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('330', '111', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('331', '111', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('332', '111', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('333', '112', '0', '-6600', '-6600', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('334', '112', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('335', '112', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('336', '113', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('337', '113', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('338', '113', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('339', '114', '0', '-8405', '-8405', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('340', '114', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('341', '114', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('342', '115', '0', '0', '0', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('343', '115', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('344', '115', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('345', '116', '0', '-3252', '-3252', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('346', '116', '0', '3000', '3000', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('347', '116', '0', '3000', '3000', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('348', '117', '0', '-4200', '-4200', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('349', '117', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('350', '117', '0', '0', '0', '3', '1');
INSERT INTO `customeropeningbalance` VALUES ('351', '118', '0', '-6403', '-6403', '1', '1');
INSERT INTO `customeropeningbalance` VALUES ('352', '118', '0', '0', '0', '2', '1');
INSERT INTO `customeropeningbalance` VALUES ('353', '118', '0', '0', '0', '3', '1');

-- ----------------------------
-- Table structure for `customertransaction`
-- ----------------------------
DROP TABLE IF EXISTS `customertransaction`;
CREATE TABLE `customertransaction` (
  `customerTransactionId` bigint(20) NOT NULL AUTO_INCREMENT,
  `customerRefId` bigint(20) DEFAULT NULL,
  `transactionDate` date DEFAULT NULL,
  `billType` int(2) DEFAULT NULL,
  `transactiondescription` text,
  `transactionType` int(2) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `accountYearRefId` double(20,0) DEFAULT NULL,
  `companyRefId` double(20,0) DEFAULT NULL,
  `activeFlag` int(2) DEFAULT NULL,
  `createdBy` double(20,0) DEFAULT NULL,
  `createdTimestamp` timestamp NULL DEFAULT NULL,
  `updatedBy` double(20,0) DEFAULT NULL,
  `updatedTimestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tableReferenceId` bigint(20) DEFAULT NULL,
  `tableDetailId` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`customerTransactionId`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customertransaction
-- ----------------------------
INSERT INTO `customertransaction` VALUES ('9', '61', '2017-07-05', '1', 'Purchase Debit for Credit Bill Number - 387', '2', '1378179', '1', '1', '1', '1', '2017-08-10 12:40:27', null, null, '3', '3');
INSERT INTO `customertransaction` VALUES ('10', '61', '2017-07-06', '1', 'Purchase Debit for Credit Bill Number - 390', '2', '145560', '1', '1', '1', '1', '2017-08-10 12:43:18', null, null, '3', '4');
INSERT INTO `customertransaction` VALUES ('11', '61', '2017-07-05', '1', 'Purchase Debit for Credit Bill Number - 388', '2', '1157687', '1', '1', '1', '1', '2017-08-10 12:46:08', null, null, '3', '5');
INSERT INTO `customertransaction` VALUES ('12', '61', '2017-07-06', '1', 'Purchase Debit for Credit Bill Number - 389', '2', '1018920', '1', '1', '1', '1', '2017-08-10 12:48:27', null, null, '3', '6');
INSERT INTO `customertransaction` VALUES ('13', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 391', '2', '1018920', '1', '1', '1', '4', '2017-08-10 12:55:27', null, null, '3', '7');
INSERT INTO `customertransaction` VALUES ('14', '4', '2017-07-03', '1', 'Debit For Credit Bill - 396', '1', '5400', '1', '1', '1', '1', '2017-08-10 13:00:02', null, null, '1', '5');
INSERT INTO `customertransaction` VALUES ('15', '4', '2017-07-03', '2', 'Debit For Cash bill - 397', '1', '4050', '1', '1', '1', '1', '2017-08-10 13:03:26', null, null, '1', '6');
INSERT INTO `customertransaction` VALUES ('16', '4', '2017-07-03', '2', 'Credit For Cash bill - 397', '2', '4050', '1', '1', '1', '1', '2017-08-10 13:03:26', null, null, '1', '6');
INSERT INTO `customertransaction` VALUES ('17', '35', '2017-07-03', '1', 'Debit For Credit Bill - 398', '1', '4200', '1', '1', '1', '1', '2017-08-10 13:04:35', null, null, '1', '7');
INSERT INTO `customertransaction` VALUES ('18', '35', '2017-07-03', '1', 'Debit For Credit Bill - 399', '1', '302', '1', '1', '1', '1', '2017-08-10 13:05:24', null, null, '1', '8');
INSERT INTO `customertransaction` VALUES ('19', '11', '2017-07-03', '2', 'Debit For Cash bill - 400', '1', '1600', '1', '1', '1', '1', '2017-08-10 13:06:16', null, null, '1', '9');
INSERT INTO `customertransaction` VALUES ('20', '11', '2017-07-03', '2', 'Credit For Cash bill - 400', '2', '1600', '1', '1', '1', '1', '2017-08-10 13:06:16', null, null, '1', '9');
INSERT INTO `customertransaction` VALUES ('21', '37', '2017-07-03', '2', 'Debit For Cash bill - 401', '1', '4000', '1', '1', '1', '1', '2017-08-10 13:07:00', null, null, '1', '10');
INSERT INTO `customertransaction` VALUES ('22', '37', '2017-07-03', '2', 'Credit For Cash bill - 401', '2', '4000', '1', '1', '1', '1', '2017-08-10 13:07:00', null, null, '1', '10');
INSERT INTO `customertransaction` VALUES ('23', '114', '2017-07-03', '1', 'Debit For Credit Bill - 402', '1', '7800', '1', '1', '1', '1', '2017-08-10 13:08:00', null, null, '1', '11');
INSERT INTO `customertransaction` VALUES ('24', '114', '2017-07-03', '1', 'Debit For Credit Bill - 403', '1', '605', '1', '1', '1', '1', '2017-08-10 13:08:39', null, null, '1', '12');
INSERT INTO `customertransaction` VALUES ('26', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 392', '2', '144104', '1', '1', '1', '1', '2017-08-10 13:22:10', null, null, '3', '8');
INSERT INTO `customertransaction` VALUES ('27', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 393', '2', '146530', '1', '1', '1', '1', '2017-08-10 13:42:14', null, null, '3', '9');
INSERT INTO `customertransaction` VALUES ('28', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 394', '2', '1018920', '1', '1', '1', '1', '2017-08-10 14:02:40', null, null, '3', '10');
INSERT INTO `customertransaction` VALUES ('29', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 395', '2', '997920', '1', '1', '1', '1', '2017-08-10 14:03:44', null, null, '3', '11');
INSERT INTO `customertransaction` VALUES ('30', '82', '2017-05-25', '1', 'Purchase Debit for Credit Bill Number - EDCIN074', '2', '911880', '1', '1', '1', '1', '2017-08-10 14:46:45', null, null, '3', '12');
INSERT INTO `customertransaction` VALUES ('31', '116', '2017-07-03', '1', 'Debit For Credit Bill - 404', '1', '3000', '1', '1', '1', '1', '2017-08-11 04:10:08', null, null, '1', '13');
INSERT INTO `customertransaction` VALUES ('32', '116', '2017-07-03', '1', 'Debit For Credit Bill - 405', '1', '252', '1', '1', '1', '1', '2017-08-11 04:28:17', null, null, '1', '14');
INSERT INTO `customertransaction` VALUES ('33', '107', '2017-07-03', '1', 'Debit For Credit Bill - 406', '1', '3000', '1', '1', '1', '1', '2017-08-11 04:30:15', null, null, '1', '15');
INSERT INTO `customertransaction` VALUES ('34', '107', '2017-07-03', '1', 'Debit For Credit Bill - 407', '1', '403', '1', '1', '1', '1', '2017-08-11 04:30:58', null, null, '1', '16');
INSERT INTO `customertransaction` VALUES ('35', '20', '2017-07-03', '1', 'Debit For Credit Bill - 408', '1', '7500', '1', '1', '1', '1', '2017-08-11 04:31:59', null, null, '1', '17');
INSERT INTO `customertransaction` VALUES ('36', '20', '2017-07-03', '1', 'Debit For Credit Bill - 409', '1', '504', '1', '1', '1', '1', '2017-08-11 04:32:41', null, null, '1', '18');
INSERT INTO `customertransaction` VALUES ('37', '77', '2017-07-03', '1', 'Debit For Credit Bill - 410', '1', '2400', '1', '1', '1', '1', '2017-08-11 04:36:03', null, null, '1', '19');
INSERT INTO `customertransaction` VALUES ('38', '77', '2017-07-03', '1', 'Debit For Credit Bill - 411', '1', '302', '1', '1', '1', '1', '2017-08-11 04:37:17', null, null, '1', '20');
INSERT INTO `customertransaction` VALUES ('39', '8', '2017-07-03', '1', 'Debit For Credit Bill - 412', '1', '3600', '1', '1', '1', '1', '2017-08-11 04:38:16', null, null, '1', '21');
INSERT INTO `customertransaction` VALUES ('40', '8', '2017-07-03', '1', 'Debit For Credit Bill - 413', '1', '302', '1', '1', '1', '1', '2017-08-11 04:39:15', null, null, '1', '22');
INSERT INTO `customertransaction` VALUES ('41', '77', '2017-07-03', '1', 'Debit For Credit Bill - 414', '1', '7500', '1', '1', '1', '1', '2017-08-11 04:40:53', null, null, '1', '23');
INSERT INTO `customertransaction` VALUES ('42', '117', '2017-07-03', '1', 'Debit For Credit Bill - 415', '1', '4200', '1', '1', '1', '1', '2017-08-11 04:42:48', null, null, '1', '24');
INSERT INTO `customertransaction` VALUES ('43', '11', '2017-07-04', '2', 'Debit For Cash bill - 416', '1', '1600', '1', '1', '1', '1', '2017-08-11 04:44:09', null, null, '1', '25');
INSERT INTO `customertransaction` VALUES ('44', '11', '2017-07-04', '2', 'Credit For Cash bill - 416', '2', '1600', '1', '1', '1', '1', '2017-08-11 04:44:09', null, null, '1', '25');
INSERT INTO `customertransaction` VALUES ('45', '112', '2017-07-05', '1', 'Debit For Credit Bill - 417', '1', '6600', '1', '1', '1', '1', '2017-08-11 04:45:43', null, null, '1', '26');
INSERT INTO `customertransaction` VALUES ('46', '46', '2017-07-05', '1', 'Debit For Credit Bill - 418', '1', '12000', '1', '1', '1', '1', '2017-08-11 04:47:12', null, null, '1', '27');
INSERT INTO `customertransaction` VALUES ('47', '46', '2017-07-05', '1', 'Debit For Credit Bill - 419', '1', '806', '1', '1', '1', '1', '2017-08-11 04:48:05', null, null, '1', '28');
INSERT INTO `customertransaction` VALUES ('48', '26', '2017-07-05', '1', 'Debit For Credit Bill - 420', '1', '5600', '1', '1', '1', '1', '2017-08-11 04:49:05', null, null, '1', '29');
INSERT INTO `customertransaction` VALUES ('49', '26', '2017-07-05', '1', 'Debit For Credit Bill - 421', '1', '403', '1', '1', '1', '1', '2017-08-11 04:50:05', null, null, '1', '30');
INSERT INTO `customertransaction` VALUES ('50', '31', '2017-07-05', '1', 'Debit For Credit Bill - 422', '1', '4500', '1', '1', '1', '1', '2017-08-11 04:51:31', null, null, '1', '31');
INSERT INTO `customertransaction` VALUES ('51', '31', '2017-07-05', '1', 'Debit For Credit Bill - 423', '1', '302', '1', '1', '1', '1', '2017-08-11 04:54:17', null, null, '1', '32');
INSERT INTO `customertransaction` VALUES ('52', '109', '2017-07-05', '1', 'Debit For Credit Bill - 424', '1', '2500', '1', '1', '1', '1', '2017-08-11 04:54:57', null, null, '1', '33');
INSERT INTO `customertransaction` VALUES ('53', '23', '2017-07-05', '1', 'Debit For Credit Bill - 425', '1', '5750', '1', '1', '1', '1', '2017-08-11 04:55:44', null, null, '1', '34');
INSERT INTO `customertransaction` VALUES ('54', '23', '2017-07-05', '1', 'Debit For Credit Bill - 426', '1', '1008', '1', '1', '1', '1', '2017-08-11 04:56:23', null, null, '1', '35');
INSERT INTO `customertransaction` VALUES ('55', '25', '2017-07-05', '1', 'Debit For Credit Bill - 427', '1', '5040', '1', '1', '1', '1', '2017-08-11 04:57:37', null, null, '1', '36');
INSERT INTO `customertransaction` VALUES ('56', '118', '2017-07-05', '1', 'Debit For Credit Bill - 428', '1', '6000', '1', '1', '1', '1', '2017-08-11 05:01:01', null, null, '1', '37');
INSERT INTO `customertransaction` VALUES ('57', '118', '2017-07-05', '1', 'Debit For Credit Bill - 429', '1', '403', '1', '1', '1', '1', '2017-08-11 05:01:38', null, null, '1', '38');
INSERT INTO `customertransaction` VALUES ('58', '28', '2017-07-05', '1', 'Debit For Credit Bill - 430', '1', '7500', '1', '1', '1', '1', '2017-08-11 05:02:40', null, null, '1', '39');
INSERT INTO `customertransaction` VALUES ('59', '44', '2017-07-05', '1', 'Debit For Credit Bill - 431', '1', '10350', '1', '1', '1', '1', '2017-08-11 05:04:40', null, null, '1', '40');
INSERT INTO `customertransaction` VALUES ('60', '43', '2017-07-05', '2', 'Debit For Cash bill - 432', '1', '3750', '1', '1', '1', '1', '2017-08-11 05:05:28', null, null, '1', '41');
INSERT INTO `customertransaction` VALUES ('61', '43', '2017-07-05', '2', 'Credit For Cash bill - 432', '2', '3750', '1', '1', '1', '1', '2017-08-11 05:05:28', null, null, '1', '41');
INSERT INTO `customertransaction` VALUES ('62', '11', '2017-07-05', '2', 'Debit For Cash bill - 433', '1', '1600', '1', '1', '1', '1', '2017-08-11 05:07:41', null, null, '1', '42');
INSERT INTO `customertransaction` VALUES ('63', '11', '2017-07-05', '2', 'Credit For Cash bill - 433', '2', '1600', '1', '1', '1', '1', '2017-08-11 05:07:41', null, null, '1', '42');
INSERT INTO `customertransaction` VALUES ('64', '10', '2017-07-05', '1', 'Debit For Credit Bill - 434', '1', '1400', '1', '1', '1', '1', '2017-08-11 05:08:35', null, null, '1', '43');
INSERT INTO `customertransaction` VALUES ('65', '73', '2017-07-05', '1', 'Debit For Credit Bill - 435', '1', '765000', '1', '1', '1', '1', '2017-08-11 05:10:35', null, null, '1', '44');
INSERT INTO `customertransaction` VALUES ('66', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 396', '2', '140184', '1', '1', '1', '1', '2017-08-11 07:00:03', null, null, '3', '13');
INSERT INTO `customertransaction` VALUES ('67', '61', '2017-07-08', '1', 'Purchase Debit for Credit Bill Number - 397', '2', '997920', '1', '1', '1', '1', '2017-08-11 07:05:47', null, null, '3', '14');
INSERT INTO `customertransaction` VALUES ('68', '61', '2017-07-09', '1', 'Purchase Debit for Credit Bill Number - 388', '2', '139709', '1', '1', '1', '1', '2017-08-11 07:07:29', null, null, '3', '15');
INSERT INTO `customertransaction` VALUES ('69', '61', '2017-07-07', '1', 'Purchase Debit for Credit Bill Number - 398', '2', '139709', '1', '1', '1', '1', '2017-08-11 07:11:09', null, null, '3', '16');
INSERT INTO `customertransaction` VALUES ('70', '61', '2017-07-12', '1', 'Purchase Debit for Credit Bill Number - 402', '2', '1379905', '1', '1', '1', '1', '2017-08-11 07:13:49', null, null, '3', '17');
INSERT INTO `customertransaction` VALUES ('71', '61', '2017-07-12', '1', 'Purchase Debit for Credit Bill Number - 403', '2', '1327483', '1', '1', '1', '1', '2017-08-11 07:15:09', null, null, '3', '18');
INSERT INTO `customertransaction` VALUES ('72', '61', '2017-07-12', '1', 'Purchase Debit for Credit Bill Number - 404', '2', '760320', '1', '1', '1', '1', '2017-08-11 07:16:20', null, null, '3', '19');
INSERT INTO `customertransaction` VALUES ('73', '61', '2017-07-12', '1', 'Purchase Debit for Credit Bill Number - 405', '2', '381823', '1', '1', '1', '1', '2017-08-11 07:17:59', null, null, '3', '20');
INSERT INTO `customertransaction` VALUES ('74', '61', '2017-07-14', '1', 'Purchase Debit for Credit Bill Number - 410', '2', '760320', '1', '1', '1', '1', '2017-08-11 07:19:10', null, null, '3', '21');
INSERT INTO `customertransaction` VALUES ('75', '61', '2017-07-14', '1', 'Purchase Debit for Credit Bill Number - 411', '2', '375170', '1', '1', '1', '1', '2017-08-11 07:20:18', null, null, '3', '22');
INSERT INTO `customertransaction` VALUES ('76', '61', '2017-07-14', '1', 'Purchase Debit for Credit Bill Number - 409', '2', '386219', '1', '1', '1', '1', '2017-08-11 07:21:28', null, null, '3', '23');
INSERT INTO `customertransaction` VALUES ('77', '61', '2017-07-14', '1', 'Purchase Debit for Credit Bill Number - 407', '2', '776320', '1', '1', '1', '1', '2017-08-11 07:23:13', null, null, '3', '24');
INSERT INTO `customertransaction` VALUES ('79', '102', '2017-07-05', '1', 'Debit For Credit Bill - 436', '1', '27200', '1', '1', '1', '1', '2017-08-11 08:12:14', null, null, '1', '45');
INSERT INTO `customertransaction` VALUES ('80', '61', '2017-07-15', '1', 'Purchase Debit for Credit Bill Number - 413', '2', '1165920', '1', '1', '1', '1', '2017-08-11 08:24:31', null, null, '3', '26');
INSERT INTO `customertransaction` VALUES ('81', '3', '2017-07-01', '2', 'Debit For Cash bill - 395', '1', '7250', '1', '1', '1', '1', '2017-08-11 08:26:31', null, null, '1', '46');
INSERT INTO `customertransaction` VALUES ('82', '3', '2017-07-01', '2', 'Credit For Cash bill - 395', '2', '7250', '1', '1', '1', '1', '2017-08-11 08:26:31', null, null, '1', '46');
INSERT INTO `customertransaction` VALUES ('83', '2', '2017-07-01', '1', 'Debit For Credit Bill - 394', '1', '1380000', '1', '1', '1', '1', '2017-08-11 08:27:13', null, null, '1', '47');
INSERT INTO `customertransaction` VALUES ('87', '3', '2017-08-11', '1', 'Debit For Credit Bill - 2', '1', '12200', '1', '1', '1', '1', '2017-08-11 12:27:40', null, null, '1', '51');
INSERT INTO `customertransaction` VALUES ('88', '3', '2017-08-11', '1', 'Debit For Credit Bill - 1', '1', '8000', '1', '1', '1', '1', '2017-08-11 12:50:55', null, null, '1', '52');

-- ----------------------------
-- Table structure for `customertype`
-- ----------------------------
DROP TABLE IF EXISTS `customertype`;
CREATE TABLE `customertype` (
  `customerTypeId` int(1) NOT NULL AUTO_INCREMENT,
  `customerTypeName` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`customerTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of customertype
-- ----------------------------
INSERT INTO `customertype` VALUES ('1', 'Purchase');
INSERT INTO `customertype` VALUES ('2', 'Sales');

-- ----------------------------
-- Table structure for `daytransaction`
-- ----------------------------
DROP TABLE IF EXISTS `daytransaction`;
CREATE TABLE `daytransaction` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `transactionTable` int(3) NOT NULL,
  `transactionType` int(3) NOT NULL,
  `transactionDetailId` int(3) NOT NULL DEFAULT '0',
  `transactionDescription` text NOT NULL,
  `activeFlag` tinyint(2) DEFAULT NULL,
  `amount` double NOT NULL,
  `customerId` tinyint(5) NOT NULL,
  `accountYearRefId` double NOT NULL,
  `companyRefId` double NOT NULL,
  `created_By` int(3) NOT NULL,
  `updated_By` int(3) NOT NULL,
  `created_Timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_Timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of daytransaction
-- ----------------------------
INSERT INTO `daytransaction` VALUES ('15', '2017-07-05', '3', '1', '3', 'Purchase Debit for Credit Bill Number - 387', '1', '1378179', '61', '1', '1', '1', '0', '2017-08-10 12:40:27', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('16', '2017-07-05', '3', '2', '3', 'Goods Credit for Credit Bill Number - 387', '1', '1378179', '61', '1', '1', '1', '0', '2017-08-10 12:40:27', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('17', '2017-07-06', '3', '1', '4', 'Purchase Debit for Credit Bill Number - 390', '1', '145560', '61', '1', '1', '1', '0', '2017-08-10 12:43:18', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('18', '2017-07-06', '3', '2', '4', 'Goods Credit for Credit Bill Number - 390', '1', '145560', '61', '1', '1', '1', '0', '2017-08-10 12:43:18', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('19', '2017-07-05', '3', '1', '5', 'Purchase Debit for Credit Bill Number - 388', '1', '1157687', '61', '1', '1', '1', '0', '2017-08-10 12:46:08', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('20', '2017-07-05', '3', '2', '5', 'Goods Credit for Credit Bill Number - 388', '1', '1157687', '61', '1', '1', '1', '0', '2017-08-10 12:46:08', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('21', '2017-07-06', '3', '1', '6', 'Purchase Debit for Credit Bill Number - 389', '1', '1018920', '61', '1', '1', '1', '0', '2017-08-10 12:48:27', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('22', '2017-07-06', '3', '2', '6', 'Goods Credit for Credit Bill Number - 389', '1', '1018920', '61', '1', '1', '1', '0', '2017-08-10 12:48:27', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('23', '2017-07-07', '3', '1', '7', 'Purchase Debit for Credit Bill Number - 391', '1', '1018920', '61', '1', '1', '4', '0', '2017-08-10 12:55:27', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('24', '2017-07-07', '3', '2', '7', 'Goods Credit for Credit Bill Number - 391', '1', '1018920', '61', '1', '1', '4', '0', '2017-08-10 12:55:27', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('25', '2017-07-03', '1', '2', '5', 'Goods Debit for Credit Bill Number - 396', '1', '5400', '4', '1', '1', '1', '0', '2017-08-10 13:00:02', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('26', '2017-07-03', '1', '1', '5', 'Sales Credit for Credit Bill Number - 396', '1', '5400', '4', '1', '1', '1', '0', '2017-08-10 13:00:02', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('27', '2017-07-03', '1', '2', '6', 'Goods Debit for Cash Bill Number - 397', '1', '4050', '4', '1', '1', '1', '0', '2017-08-10 13:03:26', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('28', '2017-07-03', '1', '1', '6', 'Sales Credit for Cash Bill Number - 397', '1', '4050', '4', '1', '1', '1', '0', '2017-08-10 13:03:26', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('29', '2017-07-03', '1', '1', '6', 'Cash Payment for Cash Bill Number - 397', '1', '4050', '4', '1', '1', '1', '0', '2017-08-10 13:03:26', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('30', '2017-07-03', '1', '2', '7', 'Goods Debit for Credit Bill Number - 398', '1', '4200', '35', '1', '1', '1', '0', '2017-08-10 13:04:35', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('31', '2017-07-03', '1', '1', '7', 'Sales Credit for Credit Bill Number - 398', '1', '4200', '35', '1', '1', '1', '0', '2017-08-10 13:04:35', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('32', '2017-07-03', '1', '2', '8', 'Goods Debit for Credit Bill Number - 399', '1', '302', '35', '1', '1', '1', '0', '2017-08-10 13:05:24', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('33', '2017-07-03', '1', '1', '8', 'Sales Credit for Credit Bill Number - 399', '1', '302', '35', '1', '1', '1', '0', '2017-08-10 13:05:24', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('34', '2017-07-03', '1', '2', '9', 'Goods Debit for Cash Bill Number - 400', '1', '1600', '11', '1', '1', '1', '0', '2017-08-10 13:06:16', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('35', '2017-07-03', '1', '1', '9', 'Sales Credit for Cash Bill Number - 400', '1', '1600', '11', '1', '1', '1', '0', '2017-08-10 13:06:16', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('36', '2017-07-03', '1', '1', '9', 'Cash Payment for Cash Bill Number - 400', '1', '1600', '11', '1', '1', '1', '0', '2017-08-10 13:06:16', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('37', '2017-07-03', '1', '2', '10', 'Goods Debit for Cash Bill Number - 401', '1', '4000', '37', '1', '1', '1', '0', '2017-08-10 13:07:00', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('38', '2017-07-03', '1', '1', '10', 'Sales Credit for Cash Bill Number - 401', '1', '4000', '37', '1', '1', '1', '0', '2017-08-10 13:07:00', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('39', '2017-07-03', '1', '1', '10', 'Cash Payment for Cash Bill Number - 401', '1', '4000', '37', '1', '1', '1', '0', '2017-08-10 13:07:00', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('40', '2017-07-03', '1', '2', '11', 'Goods Debit for Credit Bill Number - 402', '1', '7800', '114', '1', '1', '1', '0', '2017-08-10 13:08:00', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('41', '2017-07-03', '1', '1', '11', 'Sales Credit for Credit Bill Number - 402', '1', '7800', '114', '1', '1', '1', '0', '2017-08-10 13:08:00', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('42', '2017-07-03', '1', '2', '12', 'Goods Debit for Credit Bill Number - 403', '1', '605', '114', '1', '1', '1', '0', '2017-08-10 13:08:39', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('43', '2017-07-03', '1', '1', '12', 'Sales Credit for Credit Bill Number - 403', '1', '605', '114', '1', '1', '1', '0', '2017-08-10 13:08:39', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('46', '2017-07-07', '3', '1', '8', 'Purchase Debit for Credit Bill Number - 392', '1', '144104', '61', '1', '1', '1', '0', '2017-08-10 13:22:10', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('47', '2017-07-07', '3', '2', '8', 'Goods Credit for Credit Bill Number - 392', '1', '144104', '61', '1', '1', '1', '0', '2017-08-10 13:22:10', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('48', '2017-07-07', '3', '1', '9', 'Purchase Debit for Credit Bill Number - 393', '1', '146530', '61', '1', '1', '1', '0', '2017-08-10 13:42:14', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('49', '2017-07-07', '3', '2', '9', 'Goods Credit for Credit Bill Number - 393', '1', '146530', '61', '1', '1', '1', '0', '2017-08-10 13:42:14', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('50', '2017-07-07', '3', '1', '10', 'Purchase Debit for Credit Bill Number - 394', '1', '1018920', '61', '1', '1', '1', '0', '2017-08-10 14:02:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('51', '2017-07-07', '3', '2', '10', 'Goods Credit for Credit Bill Number - 394', '1', '1018920', '61', '1', '1', '1', '0', '2017-08-10 14:02:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('52', '2017-07-07', '3', '1', '11', 'Purchase Debit for Credit Bill Number - 395', '1', '997920', '61', '1', '1', '1', '0', '2017-08-10 14:03:44', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('53', '2017-07-07', '3', '2', '11', 'Goods Credit for Credit Bill Number - 395', '1', '997920', '61', '1', '1', '1', '0', '2017-08-10 14:03:44', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('54', '2017-05-25', '3', '1', '12', 'Purchase Debit for Credit Bill Number - EDCIN074', '1', '911880', '82', '1', '1', '1', '0', '2017-08-10 14:46:45', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('55', '2017-05-25', '3', '2', '12', 'Goods Credit for Credit Bill Number - EDCIN074', '1', '911880', '82', '1', '1', '1', '0', '2017-08-10 14:46:45', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('56', '2017-07-03', '1', '2', '13', 'Goods Debit for Credit Bill Number - 404', '1', '3000', '116', '1', '1', '1', '0', '2017-08-11 04:10:08', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('57', '2017-07-03', '1', '1', '13', 'Sales Credit for Credit Bill Number - 404', '1', '3000', '116', '1', '1', '1', '0', '2017-08-11 04:10:08', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('58', '2017-07-03', '1', '2', '14', 'Goods Debit for Credit Bill Number - 405', '1', '252', '116', '1', '1', '1', '0', '2017-08-11 04:28:17', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('59', '2017-07-03', '1', '1', '14', 'Sales Credit for Credit Bill Number - 405', '1', '252', '116', '1', '1', '1', '0', '2017-08-11 04:28:17', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('60', '2017-07-03', '1', '2', '15', 'Goods Debit for Credit Bill Number - 406', '1', '3000', '107', '1', '1', '1', '0', '2017-08-11 04:30:15', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('61', '2017-07-03', '1', '1', '15', 'Sales Credit for Credit Bill Number - 406', '1', '3000', '107', '1', '1', '1', '0', '2017-08-11 04:30:15', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('62', '2017-07-03', '1', '2', '16', 'Goods Debit for Credit Bill Number - 407', '1', '403', '107', '1', '1', '1', '0', '2017-08-11 04:30:58', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('63', '2017-07-03', '1', '1', '16', 'Sales Credit for Credit Bill Number - 407', '1', '403', '107', '1', '1', '1', '0', '2017-08-11 04:30:58', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('64', '2017-07-03', '1', '2', '17', 'Goods Debit for Credit Bill Number - 408', '1', '7500', '20', '1', '1', '1', '0', '2017-08-11 04:31:59', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('65', '2017-07-03', '1', '1', '17', 'Sales Credit for Credit Bill Number - 408', '1', '7500', '20', '1', '1', '1', '0', '2017-08-11 04:31:59', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('66', '2017-07-03', '1', '2', '18', 'Goods Debit for Credit Bill Number - 409', '1', '504', '20', '1', '1', '1', '0', '2017-08-11 04:32:41', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('67', '2017-07-03', '1', '1', '18', 'Sales Credit for Credit Bill Number - 409', '1', '504', '20', '1', '1', '1', '0', '2017-08-11 04:32:41', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('68', '2017-07-03', '1', '2', '19', 'Goods Debit for Credit Bill Number - 410', '1', '2400', '77', '1', '1', '1', '0', '2017-08-11 04:36:03', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('69', '2017-07-03', '1', '1', '19', 'Sales Credit for Credit Bill Number - 410', '1', '2400', '77', '1', '1', '1', '0', '2017-08-11 04:36:03', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('70', '2017-07-03', '1', '2', '20', 'Goods Debit for Credit Bill Number - 411', '1', '302', '77', '1', '1', '1', '0', '2017-08-11 04:37:17', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('71', '2017-07-03', '1', '1', '20', 'Sales Credit for Credit Bill Number - 411', '1', '302', '77', '1', '1', '1', '0', '2017-08-11 04:37:17', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('72', '2017-07-03', '1', '2', '21', 'Goods Debit for Credit Bill Number - 412', '1', '3600', '8', '1', '1', '1', '0', '2017-08-11 04:38:16', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('73', '2017-07-03', '1', '1', '21', 'Sales Credit for Credit Bill Number - 412', '1', '3600', '8', '1', '1', '1', '0', '2017-08-11 04:38:16', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('74', '2017-07-03', '1', '2', '22', 'Goods Debit for Credit Bill Number - 413', '1', '302', '8', '1', '1', '1', '0', '2017-08-11 04:39:15', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('75', '2017-07-03', '1', '1', '22', 'Sales Credit for Credit Bill Number - 413', '1', '302', '8', '1', '1', '1', '0', '2017-08-11 04:39:15', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('76', '2017-07-03', '1', '2', '23', 'Goods Debit for Credit Bill Number - 414', '1', '7500', '77', '1', '1', '1', '0', '2017-08-11 04:40:53', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('77', '2017-07-03', '1', '1', '23', 'Sales Credit for Credit Bill Number - 414', '1', '7500', '77', '1', '1', '1', '0', '2017-08-11 04:40:53', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('78', '2017-07-03', '1', '2', '24', 'Goods Debit for Credit Bill Number - 415', '1', '4200', '117', '1', '1', '1', '0', '2017-08-11 04:42:48', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('79', '2017-07-03', '1', '1', '24', 'Sales Credit for Credit Bill Number - 415', '1', '4200', '117', '1', '1', '1', '0', '2017-08-11 04:42:48', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('80', '2017-07-04', '1', '2', '25', 'Goods Debit for Cash Bill Number - 416', '1', '1600', '11', '1', '1', '1', '0', '2017-08-11 04:44:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('81', '2017-07-04', '1', '1', '25', 'Sales Credit for Cash Bill Number - 416', '1', '1600', '11', '1', '1', '1', '0', '2017-08-11 04:44:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('82', '2017-07-04', '1', '1', '25', 'Cash Payment for Cash Bill Number - 416', '1', '1600', '11', '1', '1', '1', '0', '2017-08-11 04:44:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('83', '2017-07-05', '1', '2', '26', 'Goods Debit for Credit Bill Number - 417', '1', '6600', '112', '1', '1', '1', '0', '2017-08-11 04:45:43', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('84', '2017-07-05', '1', '1', '26', 'Sales Credit for Credit Bill Number - 417', '1', '6600', '112', '1', '1', '1', '0', '2017-08-11 04:45:43', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('85', '2017-07-05', '1', '2', '27', 'Goods Debit for Credit Bill Number - 418', '1', '12000', '46', '1', '1', '1', '0', '2017-08-11 04:47:12', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('86', '2017-07-05', '1', '1', '27', 'Sales Credit for Credit Bill Number - 418', '1', '12000', '46', '1', '1', '1', '0', '2017-08-11 04:47:12', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('87', '2017-07-05', '1', '2', '28', 'Goods Debit for Credit Bill Number - 419', '1', '806', '46', '1', '1', '1', '0', '2017-08-11 04:48:05', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('88', '2017-07-05', '1', '1', '28', 'Sales Credit for Credit Bill Number - 419', '1', '806', '46', '1', '1', '1', '0', '2017-08-11 04:48:05', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('89', '2017-07-05', '1', '2', '29', 'Goods Debit for Credit Bill Number - 420', '1', '5600', '26', '1', '1', '1', '0', '2017-08-11 04:49:05', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('90', '2017-07-05', '1', '1', '29', 'Sales Credit for Credit Bill Number - 420', '1', '5600', '26', '1', '1', '1', '0', '2017-08-11 04:49:05', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('91', '2017-07-05', '1', '2', '30', 'Goods Debit for Credit Bill Number - 421', '1', '403', '26', '1', '1', '1', '0', '2017-08-11 04:50:05', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('92', '2017-07-05', '1', '1', '30', 'Sales Credit for Credit Bill Number - 421', '1', '403', '26', '1', '1', '1', '0', '2017-08-11 04:50:05', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('93', '2017-07-05', '1', '2', '31', 'Goods Debit for Credit Bill Number - 422', '1', '4500', '31', '1', '1', '1', '0', '2017-08-11 04:51:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('94', '2017-07-05', '1', '1', '31', 'Sales Credit for Credit Bill Number - 422', '1', '4500', '31', '1', '1', '1', '0', '2017-08-11 04:51:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('95', '2017-07-05', '1', '2', '32', 'Goods Debit for Credit Bill Number - 423', '1', '302', '31', '1', '1', '1', '0', '2017-08-11 04:54:17', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('96', '2017-07-05', '1', '1', '32', 'Sales Credit for Credit Bill Number - 423', '1', '302', '31', '1', '1', '1', '0', '2017-08-11 04:54:17', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('97', '2017-07-05', '1', '2', '33', 'Goods Debit for Credit Bill Number - 424', '1', '2500', '109', '1', '1', '1', '0', '2017-08-11 04:54:57', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('98', '2017-07-05', '1', '1', '33', 'Sales Credit for Credit Bill Number - 424', '1', '2500', '109', '1', '1', '1', '0', '2017-08-11 04:54:57', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('99', '2017-07-05', '1', '2', '34', 'Goods Debit for Credit Bill Number - 425', '1', '5750', '23', '1', '1', '1', '0', '2017-08-11 04:55:44', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('100', '2017-07-05', '1', '1', '34', 'Sales Credit for Credit Bill Number - 425', '1', '5750', '23', '1', '1', '1', '0', '2017-08-11 04:55:44', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('101', '2017-07-05', '1', '2', '35', 'Goods Debit for Credit Bill Number - 426', '1', '1008', '23', '1', '1', '1', '0', '2017-08-11 04:56:23', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('102', '2017-07-05', '1', '1', '35', 'Sales Credit for Credit Bill Number - 426', '1', '1008', '23', '1', '1', '1', '0', '2017-08-11 04:56:23', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('103', '2017-07-05', '1', '2', '36', 'Goods Debit for Credit Bill Number - 427', '1', '5040', '25', '1', '1', '1', '0', '2017-08-11 04:57:37', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('104', '2017-07-05', '1', '1', '36', 'Sales Credit for Credit Bill Number - 427', '1', '5040', '25', '1', '1', '1', '0', '2017-08-11 04:57:37', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('105', '2017-07-05', '1', '2', '37', 'Goods Debit for Credit Bill Number - 428', '1', '6000', '118', '1', '1', '1', '0', '2017-08-11 05:01:01', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('106', '2017-07-05', '1', '1', '37', 'Sales Credit for Credit Bill Number - 428', '1', '6000', '118', '1', '1', '1', '0', '2017-08-11 05:01:01', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('107', '2017-07-05', '1', '2', '38', 'Goods Debit for Credit Bill Number - 429', '1', '403', '118', '1', '1', '1', '0', '2017-08-11 05:01:38', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('108', '2017-07-05', '1', '1', '38', 'Sales Credit for Credit Bill Number - 429', '1', '403', '118', '1', '1', '1', '0', '2017-08-11 05:01:38', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('109', '2017-07-05', '1', '2', '39', 'Goods Debit for Credit Bill Number - 430', '1', '7500', '28', '1', '1', '1', '0', '2017-08-11 05:02:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('110', '2017-07-05', '1', '1', '39', 'Sales Credit for Credit Bill Number - 430', '1', '7500', '28', '1', '1', '1', '0', '2017-08-11 05:02:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('111', '2017-07-05', '1', '2', '40', 'Goods Debit for Credit Bill Number - 431', '1', '10350', '44', '1', '1', '1', '0', '2017-08-11 05:04:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('112', '2017-07-05', '1', '1', '40', 'Sales Credit for Credit Bill Number - 431', '1', '10350', '44', '1', '1', '1', '0', '2017-08-11 05:04:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('113', '2017-07-05', '1', '2', '41', 'Goods Debit for Cash Bill Number - 432', '1', '3750', '43', '1', '1', '1', '0', '2017-08-11 05:05:28', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('114', '2017-07-05', '1', '1', '41', 'Sales Credit for Cash Bill Number - 432', '1', '3750', '43', '1', '1', '1', '0', '2017-08-11 05:05:28', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('115', '2017-07-05', '1', '1', '41', 'Cash Payment for Cash Bill Number - 432', '1', '3750', '43', '1', '1', '1', '0', '2017-08-11 05:05:28', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('116', '2017-07-05', '1', '2', '42', 'Goods Debit for Cash Bill Number - 433', '1', '1600', '11', '1', '1', '1', '0', '2017-08-11 05:07:41', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('117', '2017-07-05', '1', '1', '42', 'Sales Credit for Cash Bill Number - 433', '1', '1600', '11', '1', '1', '1', '0', '2017-08-11 05:07:41', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('118', '2017-07-05', '1', '1', '42', 'Cash Payment for Cash Bill Number - 433', '1', '1600', '11', '1', '1', '1', '0', '2017-08-11 05:07:41', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('119', '2017-07-05', '1', '2', '43', 'Goods Debit for Credit Bill Number - 434', '1', '1400', '10', '1', '1', '1', '0', '2017-08-11 05:08:35', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('120', '2017-07-05', '1', '1', '43', 'Sales Credit for Credit Bill Number - 434', '1', '1400', '10', '1', '1', '1', '0', '2017-08-11 05:08:35', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('121', '2017-07-05', '1', '2', '44', 'Goods Debit for Credit Bill Number - 435', '1', '765000', '73', '1', '1', '1', '0', '2017-08-11 05:10:35', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('122', '2017-07-05', '1', '1', '44', 'Sales Credit for Credit Bill Number - 435', '1', '765000', '73', '1', '1', '1', '0', '2017-08-11 05:10:35', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('123', '2017-07-07', '3', '1', '13', 'Purchase Debit for Credit Bill Number - 396', '1', '140184', '61', '1', '1', '1', '0', '2017-08-11 07:00:03', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('124', '2017-07-07', '3', '2', '13', 'Goods Credit for Credit Bill Number - 396', '1', '140184', '61', '1', '1', '1', '0', '2017-08-11 07:00:03', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('125', '2017-07-08', '3', '1', '14', 'Purchase Debit for Credit Bill Number - 397', '1', '997920', '61', '1', '1', '1', '0', '2017-08-11 07:05:47', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('126', '2017-07-08', '3', '2', '14', 'Goods Credit for Credit Bill Number - 397', '1', '997920', '61', '1', '1', '1', '0', '2017-08-11 07:05:47', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('127', '2017-07-09', '3', '1', '15', 'Purchase Debit for Credit Bill Number - 388', '1', '139709', '61', '1', '1', '1', '0', '2017-08-11 07:07:29', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('128', '2017-07-09', '3', '2', '15', 'Goods Credit for Credit Bill Number - 388', '1', '139709', '61', '1', '1', '1', '0', '2017-08-11 07:07:29', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('129', '2017-07-07', '3', '1', '16', 'Purchase Debit for Credit Bill Number - 398', '1', '139709', '61', '1', '1', '1', '0', '2017-08-11 07:11:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('130', '2017-07-07', '3', '2', '16', 'Goods Credit for Credit Bill Number - 398', '1', '139709', '61', '1', '1', '1', '0', '2017-08-11 07:11:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('131', '2017-07-12', '3', '1', '17', 'Purchase Debit for Credit Bill Number - 402', '1', '1379905', '61', '1', '1', '1', '0', '2017-08-11 07:13:49', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('132', '2017-07-12', '3', '2', '17', 'Goods Credit for Credit Bill Number - 402', '1', '1379905', '61', '1', '1', '1', '0', '2017-08-11 07:13:49', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('133', '2017-07-12', '3', '1', '18', 'Purchase Debit for Credit Bill Number - 403', '1', '1327483', '61', '1', '1', '1', '0', '2017-08-11 07:15:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('134', '2017-07-12', '3', '2', '18', 'Goods Credit for Credit Bill Number - 403', '1', '1327483', '61', '1', '1', '1', '0', '2017-08-11 07:15:09', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('135', '2017-07-12', '3', '1', '19', 'Purchase Debit for Credit Bill Number - 404', '1', '760320', '61', '1', '1', '1', '0', '2017-08-11 07:16:20', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('136', '2017-07-12', '3', '2', '19', 'Goods Credit for Credit Bill Number - 404', '1', '760320', '61', '1', '1', '1', '0', '2017-08-11 07:16:20', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('137', '2017-07-12', '3', '1', '20', 'Purchase Debit for Credit Bill Number - 405', '1', '381823', '61', '1', '1', '1', '0', '2017-08-11 07:17:59', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('138', '2017-07-12', '3', '2', '20', 'Goods Credit for Credit Bill Number - 405', '1', '381823', '61', '1', '1', '1', '0', '2017-08-11 07:17:59', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('139', '2017-07-14', '3', '1', '21', 'Purchase Debit for Credit Bill Number - 410', '1', '760320', '61', '1', '1', '1', '0', '2017-08-11 07:19:10', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('140', '2017-07-14', '3', '2', '21', 'Goods Credit for Credit Bill Number - 410', '1', '760320', '61', '1', '1', '1', '0', '2017-08-11 07:19:10', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('141', '2017-07-14', '3', '1', '22', 'Purchase Debit for Credit Bill Number - 411', '1', '375170', '61', '1', '1', '1', '0', '2017-08-11 07:20:18', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('142', '2017-07-14', '3', '2', '22', 'Goods Credit for Credit Bill Number - 411', '1', '375170', '61', '1', '1', '1', '0', '2017-08-11 07:20:18', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('143', '2017-07-14', '3', '1', '23', 'Purchase Debit for Credit Bill Number - 409', '1', '386219', '61', '1', '1', '1', '0', '2017-08-11 07:21:28', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('144', '2017-07-14', '3', '2', '23', 'Goods Credit for Credit Bill Number - 409', '1', '386219', '61', '1', '1', '1', '0', '2017-08-11 07:21:28', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('145', '2017-07-14', '3', '1', '24', 'Purchase Debit for Credit Bill Number - 407', '1', '776320', '61', '1', '1', '1', '0', '2017-08-11 07:23:13', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('146', '2017-07-14', '3', '2', '24', 'Goods Credit for Credit Bill Number - 407', '1', '776320', '61', '1', '1', '1', '0', '2017-08-11 07:23:13', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('149', '2017-07-05', '1', '2', '45', 'Goods Debit for Credit Bill Number - 436', '1', '27200', '102', '1', '1', '1', '0', '2017-08-11 08:12:14', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('150', '2017-07-05', '1', '1', '45', 'Sales Credit for Credit Bill Number - 436', '1', '27200', '102', '1', '1', '1', '0', '2017-08-11 08:12:14', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('151', '2017-07-15', '3', '1', '26', 'Purchase Debit for Credit Bill Number - 413', '1', '1165920', '61', '1', '1', '1', '0', '2017-08-11 08:24:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('152', '2017-07-15', '3', '2', '26', 'Goods Credit for Credit Bill Number - 413', '1', '1165920', '61', '1', '1', '1', '0', '2017-08-11 08:24:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('153', '2017-07-01', '1', '2', '46', 'Goods Debit for Cash Bill Number - 395', '1', '7250', '3', '1', '1', '1', '0', '2017-08-11 08:26:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('154', '2017-07-01', '1', '1', '46', 'Sales Credit for Cash Bill Number - 395', '1', '7250', '3', '1', '1', '1', '0', '2017-08-11 08:26:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('155', '2017-07-01', '1', '1', '46', 'Cash Payment for Cash Bill Number - 395', '1', '7250', '3', '1', '1', '1', '0', '2017-08-11 08:26:31', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('156', '2017-07-01', '1', '2', '47', 'Goods Debit for Credit Bill Number - 394', '1', '1380000', '2', '1', '1', '1', '0', '2017-08-11 08:27:13', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('157', '2017-07-01', '1', '1', '47', 'Sales Credit for Credit Bill Number - 394', '1', '1380000', '2', '1', '1', '1', '0', '2017-08-11 08:27:13', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('164', '2017-08-11', '1', '2', '51', 'Goods Debit for Credit Bill Number - 2', '1', '12200', '3', '1', '1', '1', '0', '2017-08-11 12:27:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('165', '2017-08-11', '1', '1', '51', 'Sales Credit for Credit Bill Number - 2', '1', '12200', '3', '1', '1', '1', '0', '2017-08-11 12:27:40', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('166', '2017-08-11', '1', '2', '52', 'Goods Debit for Credit Bill Number - 1', '1', '8000', '3', '1', '1', '1', '0', '2017-08-11 12:50:55', '0000-00-00 00:00:00');
INSERT INTO `daytransaction` VALUES ('167', '2017-08-11', '1', '1', '52', 'Sales Credit for Credit Bill Number - 1', '1', '8000', '3', '1', '1', '1', '0', '2017-08-11 12:50:55', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `developertable`
-- ----------------------------
DROP TABLE IF EXISTS `developertable`;
CREATE TABLE `developertable` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of developertable
-- ----------------------------
INSERT INTO `developertable` VALUES ('1', 'Active');
INSERT INTO `developertable` VALUES ('2', 'Inactive');
INSERT INTO `developertable` VALUES ('3', 'Incomplete');
INSERT INTO `developertable` VALUES ('4', 'Complete');

-- ----------------------------
-- Table structure for `gsthsncode`
-- ----------------------------
DROP TABLE IF EXISTS `gsthsncode`;
CREATE TABLE `gsthsncode` (
  `hsnCode` varchar(20) NOT NULL DEFAULT '0',
  `hsnType` int(1) DEFAULT '1',
  `description` text NOT NULL,
  `cgstRate` double NOT NULL,
  `sgstRate` double NOT NULL,
  `igstRate` double NOT NULL,
  `vatRate` double DEFAULT NULL,
  `cstRate` double DEFAULT NULL,
  `activeFlag` int(1) DEFAULT NULL,
  PRIMARY KEY (`hsnCode`),
  KEY `gstHSNTypeRef` (`hsnType`),
  CONSTRAINT `gsthsncode_ibfk_1` FOREIGN KEY (`hsnType`) REFERENCES `gsttype` (`gstTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gsthsncode
-- ----------------------------
INSERT INTO `gsthsncode` VALUES ('07130000', '1', 'Orid Dal,Toor Dal,Moong Dal,Orid Split,Orid Split Black', '0', '0', '0', '0', '0', '1');
INSERT INTO `gsthsncode` VALUES ('09011200', '1', 'Raw coffee', '0', '0', '0', '5', '2', '1');
INSERT INTO `gsthsncode` VALUES ('09012000', '1', 'Roasted Coffee', '2.5', '2.5', '5', '5', '0', '1');
INSERT INTO `gsthsncode` VALUES ('09092000', '1', 'Coriander Seeds', '2.5', '2.5', '5', '0', '0', '1');
INSERT INTO `gsthsncode` VALUES ('15119020', '1', 'Refined Palm Oil', '2.5', '2.5', '5', '0', '0', '1');
INSERT INTO `gsthsncode` VALUES ('15121910', '1', 'Refined Sunflower Oil', '2.5', '2.5', '5', '0', '0', '1');
INSERT INTO `gsthsncode` VALUES ('21013010', '1', 'Chicory', '6', '6', '12', '5', '0', '1');
INSERT INTO `gsthsncode` VALUES ('23025000', '1', 'Orid Dust', '0', '0', '0', '0', '0', '1');

-- ----------------------------
-- Table structure for `gsttype`
-- ----------------------------
DROP TABLE IF EXISTS `gsttype`;
CREATE TABLE `gsttype` (
  `gstTypeId` int(1) NOT NULL AUTO_INCREMENT,
  `gstTypeName` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`gstTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gsttype
-- ----------------------------
INSERT INTO `gsttype` VALUES ('1', 'product');
INSERT INTO `gsttype` VALUES ('2', 'service');

-- ----------------------------
-- Table structure for `items`
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `ItemId` bigint(20) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(200) NOT NULL,
  `packingFactor` double DEFAULT NULL,
  `billFactor` double DEFAULT NULL,
  `UnitPrice` double NOT NULL,
  `commodityRefId` varchar(20) DEFAULT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `Discount` double DEFAULT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activeFlag` int(2) DEFAULT NULL,
  PRIMARY KEY (`ItemId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Items Details';

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES ('3', 'ORID DAL', '1', '1', '0', '2', null, '0', '0', '0', '2017-08-08 18:36:25', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('4', 'ROASTED COFFEE', '1', '1', '0', '1', null, '0', '0', '0', '2017-08-09 14:50:35', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('5', 'TOOR DAL', '1', '1', '0', '3', null, '0', '0', '0', '2017-08-09 14:50:41', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('6', 'MOONG DAL', '1', '1', '0', '4', null, '0', '0', '0', '2017-08-09 14:50:50', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('7', 'ORID SPLIT', '1', '1', '0', '5', null, '0', '0', '0', '2017-08-09 14:51:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('8', 'ORID SPLIT  BLACK', '1', '1', '0', '6', null, '0', '0', '0', '2017-08-09 14:51:10', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('9', 'RAW COFFEE', '1', '1', '0', '7', null, '0', '0', '0', '2017-08-09 14:51:18', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('10', 'CORIANDER SEEDS', '1', '1', '0', '8', null, '0', '0', '0', '2017-08-09 14:51:27', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('11', 'REFINED PALM OIL', '1', '1', '0', '9', null, '0', '0', '0', '2017-08-09 14:51:37', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('12', 'ORID DUST', '1', '1', '0', '12', null, '0', '0', '0', '2017-08-09 13:47:13', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('13', 'REFINED SUNFLOWER OIL', '1', '1', '0', '10', null, '0', '0', '0', '2017-08-09 14:51:49', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('14', 'CHICORY', '1', '1', '0', '11', null, '0', '0', '0', '2017-08-09 14:51:54', '0', '0000-00-00 00:00:00', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('1', 'admin', 'admin', '1', '1', null, '2017-07-19 11:56:10', '1', '1');
INSERT INTO `login` VALUES ('2', 'admin', 'admin', '2', '1', null, '2017-08-05 17:41:34', '1', '1');
INSERT INTO `login` VALUES ('3', 'admin', 'admin', '3', '1', null, '2017-08-05 17:41:40', '1', '1');
INSERT INTO `login` VALUES ('4', 'bill', 'bill', '1', '2', null, null, '1', '1');
INSERT INTO `login` VALUES ('5', 'bill', 'bill', '2', '2', null, '2017-08-10 18:23:40', '1', '1');
INSERT INTO `login` VALUES ('6', 'bill', 'bill', '3', '2', null, '2017-08-10 18:23:51', '1', '1');

-- ----------------------------
-- Table structure for `modeofpayment`
-- ----------------------------
DROP TABLE IF EXISTS `modeofpayment`;
CREATE TABLE `modeofpayment` (
  `modeId` int(2) NOT NULL AUTO_INCREMENT,
  `modeName` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`modeId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of modeofpayment
-- ----------------------------
INSERT INTO `modeofpayment` VALUES ('1', 'cash');

-- ----------------------------
-- Table structure for `openingstock`
-- ----------------------------
DROP TABLE IF EXISTS `openingstock`;
CREATE TABLE `openingstock` (
  `commodityStockId` bigint(20) NOT NULL AUTO_INCREMENT,
  `commodityRefId` bigint(20) NOT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `accountYearRefId` bigint(20) NOT NULL,
  `UOMRefId` bigint(20) DEFAULT NULL,
  `createdBy` bigint(20) DEFAULT NULL,
  `createdTimeStamp` timestamp NULL DEFAULT NULL,
  `openingUOMQuantity` double NOT NULL,
  `closingUOMQuantity` double NOT NULL,
  `trialUOMQuantity` double NOT NULL,
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`commodityStockId`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of openingstock
-- ----------------------------
INSERT INTO `openingstock` VALUES ('1', '1', '1', '1', '1', '1', '2017-08-05 18:36:25', '0', '-368', '-368', '0', '2017-08-11 17:57:40');
INSERT INTO `openingstock` VALUES ('2', '2', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '285950', '285950', '0', '2017-08-11 18:20:55');
INSERT INTO `openingstock` VALUES ('3', '3', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '-125', '-125', '0', '2017-08-11 13:56:31');
INSERT INTO `openingstock` VALUES ('4', '4', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '-2525', '-2525', '0', '2017-08-11 10:40:35');
INSERT INTO `openingstock` VALUES ('5', '5', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '-2500', '-2500', '0', '2017-08-11 10:40:35');
INSERT INTO `openingstock` VALUES ('6', '6', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '0', '0', '0', '2017-08-08 17:16:49');
INSERT INTO `openingstock` VALUES ('7', '7', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '4000', '4000', '0', '2017-08-10 20:16:45');
INSERT INTO `openingstock` VALUES ('8', '8', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '0', '0', '0', '2017-08-08 17:16:51');
INSERT INTO `openingstock` VALUES ('9', '9', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '0', '0', '0', '2017-08-08 17:16:53');
INSERT INTO `openingstock` VALUES ('10', '10', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '0', '0', '0', '2017-08-08 17:16:55');
INSERT INTO `openingstock` VALUES ('11', '11', '1', '1', '1', '1', '0000-00-00 00:00:00', '0', '-105.5', '-105.5', '0', '2017-08-11 10:31:38');
INSERT INTO `openingstock` VALUES ('12', '12', '1', '1', '2', '1', '2017-08-22 19:10:17', '25', '0', '0', '1', '2017-08-23 18:46:46');

-- ----------------------------
-- Table structure for `purchasebill`
-- ----------------------------
DROP TABLE IF EXISTS `purchasebill`;
CREATE TABLE `purchasebill` (
  `purchaseBillID` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchaseBillDisplayNumber` varchar(50) NOT NULL,
  `purchaseBillDate` date DEFAULT NULL,
  `CustomerID` bigint(20) DEFAULT NULL,
  `ProductDiscount` double(10,2) DEFAULT NULL,
  `TotalDiscount` double(10,2) DEFAULT NULL,
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
  `createdTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `purchaseBillType` int(2) NOT NULL,
  `purchaseBillStatus` int(2) NOT NULL,
  `purchaseBillStage` int(2) NOT NULL,
  `purchaseBillLock` int(2) NOT NULL DEFAULT '0',
  `purchaseBillGSTType` int(2) DEFAULT NULL,
  `transport` varchar(200) DEFAULT NULL,
  `bundle` int(4) DEFAULT NULL,
  `addressRefId` double(20,0) DEFAULT NULL,
  `vatTotal` double DEFAULT NULL,
  `cstTotal` double DEFAULT '0',
  `vatCstFlag` int(1) DEFAULT '0',
  PRIMARY KEY (`purchaseBillID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchasebill
-- ----------------------------
INSERT INTO `purchasebill` VALUES ('3', '387', '2017-07-05', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1378179.2', '0', '-0.2', '1378179', '1', '1', '1', '2017-08-10 18:10:27', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN64L5544', '480', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('4', '390', '2017-07-06', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '145560', '0', '0', '145560', '1', '1', '1', '2017-08-10 18:13:18', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN64P3638', '60', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('5', '388', '2017-07-05', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1157687.2', '0', '-0.2', '1157687', '1', '1', '1', '2017-08-10 18:16:08', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN30AM4156', '480', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('6', '389', '2017-07-06', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1018920', '0', '0', '1018920', '1', '1', '1', '2017-08-10 18:18:27', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN64P3638', '420', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('7', '391', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1018920', '0', '0', '1018920', '1', '1', '4', '2017-08-10 18:25:27', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN69F6811', '420', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('8', '392', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '144104.4', '0', '-0.4', '144104', '1', '1', '1', '2017-08-10 18:52:10', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN69AF6811', '60', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('9', '393', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '146530.4', '0', '-0.4', '146530', '1', '1', '1', '2017-08-10 19:12:14', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'tn69ac2666', '60', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('10', '394', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1018920', '0', '0', '1018920', '1', '1', '1', '2017-08-10 19:32:40', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN69AC2666', '420', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('11', '395', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '997920', '0', '0', '997920', '1', '1', '1', '2017-08-10 19:33:44', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN64L6655', '420', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('12', 'EDCIN074', '2017-05-25', '82', '0.00', '0.00', '0', '0', '0', '0.00', '0', '894000', '0', '0', '911880', '1', '1', '1', '2017-08-10 20:16:45', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '2', '', '40', '81', '0', '17880', '1');
INSERT INTO `purchasebill` VALUES ('13', '396', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '140184', '0', '0', '140184', '1', '1', '1', '2017-08-11 12:30:03', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'tn64l6655', '60', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('14', '397', '2017-07-08', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '997920', '0', '0', '997920', '1', '1', '1', '2017-08-11 12:35:47', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN67BZ8808', '420', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('15', '388', '2017-07-09', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '139708.8', '0', '0.2', '139709', '1', '1', '1', '2017-08-11 12:37:29', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN67BZ8808', '60', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('16', '398', '2017-07-07', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '139708.8', '0', '0.2', '139709', '1', '1', '1', '2017-08-11 12:41:09', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN67BZ8808', '60', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('17', '402', '2017-07-12', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1379904.8', '0', '0.2', '1379905', '1', '1', '1', '2017-08-11 12:43:49', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN24AH5595', '480', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('18', '403', '2017-07-12', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1327483.2', '0', '-0.2', '1327483', '1', '1', '1', '2017-08-11 12:45:09', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN28BB2088', '480', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('19', '404', '2017-07-12', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '760320', '0', '0', '760320', '1', '1', '1', '2017-08-11 12:46:20', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN32J2399', '320', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('20', '405', '2017-07-12', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '381823.2', '0', '-0.2', '381823', '1', '1', '1', '2017-08-11 12:47:59', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN32J2399', '160', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('21', '410', '2017-07-14', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '760320', '0', '0', '760320', '1', '1', '1', '2017-08-11 12:49:10', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN72L4730', '320', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('22', '411', '2017-07-14', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '375170.4', '0', '-0.4', '375170', '1', '1', '1', '2017-08-11 12:50:18', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN72L4730', '160', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('23', '409', '2017-07-14', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '386219.2', '0', '-0.2', '386219', '1', '1', '1', '2017-08-11 12:51:28', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN61C5006', '160', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('24', '407', '2017-07-14', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '776320', '0', '0', '776320', '1', '1', '1', '2017-08-11 12:53:13', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN61C5006', '320', '100', null, '0', '0');
INSERT INTO `purchasebill` VALUES ('26', '413', '2017-07-15', '61', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1165920', '0', '0', '1165920', '1', '1', '1', '2017-08-11 13:54:31', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', 'TN52H6502', '320', '100', null, '0', '0');

-- ----------------------------
-- Table structure for `purchasebillitem`
-- ----------------------------
DROP TABLE IF EXISTS `purchasebillitem`;
CREATE TABLE `purchasebillitem` (
  `ID` double NOT NULL AUTO_INCREMENT,
  `purchaseBillRefId` bigint(20) NOT NULL,
  `itemRefId` bigint(20) DEFAULT NULL,
  `commodityRefId` bigint(20) DEFAULT NULL,
  `unitrate` double(30,2) DEFAULT NULL,
  `Discount` double DEFAULT NULL,
  `Quantity` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `chessRate` double NOT NULL,
  `chessTotal` double NOT NULL,
  `cgstRate` double NOT NULL,
  `cgstTotal` double NOT NULL,
  `sgstRate` double NOT NULL,
  `sgstTotal` double NOT NULL,
  `igstRate` double NOT NULL,
  `igstTotal` double NOT NULL,
  `UOMRefId` bigint(20) DEFAULT NULL,
  `packingfactor` double DEFAULT NULL,
  `totalUOMQuantity` double DEFAULT NULL,
  `purchaseBillDate` date NOT NULL,
  `hsnCodeRefId` varchar(20) DEFAULT NULL,
  `purchaseCustomerRefId` bigint(20) NOT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `accountYearRefId` bigint(20) NOT NULL,
  `purchaseBillType` int(2) NOT NULL,
  `purchaseBillGSTType` int(2) DEFAULT NULL,
  `purchaseBillBags` int(11) DEFAULT NULL,
  `vatRate` double DEFAULT NULL,
  `vatTotal` double DEFAULT NULL,
  `cstRate` double DEFAULT NULL,
  `cstTotal` double DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of purchasebillitem
-- ----------------------------
INSERT INTO `purchasebillitem` VALUES ('3', '3', '3', '2', '57.52', '0', '23960', '1378179.2', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '23960', '2017-07-05', '07130000', '61', '1', '1', '1', '1', '480', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('4', '4', '3', '2', '48.52', '0', '3000', '145560', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '3000', '2017-07-06', '07130000', '61', '1', '1', '1', '1', '60', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('5', '5', '3', '2', '48.52', '0', '23860', '1157687.2', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '23860', '2017-07-05', '07130000', '61', '1', '1', '1', '1', '480', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('6', '6', '3', '2', '48.52', '0', '21000', '1018920', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '21000', '2017-07-06', '07130000', '61', '1', '1', '1', '1', '420', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('7', '7', '3', '2', '48.52', '0', '21000', '1018920', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '21000', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '420', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('8', '8', '3', '2', '48.52', '0', '2970', '144104.4', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2970', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '60', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('9', '9', '3', '2', '48.52', '0', '3020', '146530.4', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '3020', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '60', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('10', '10', '3', '2', '48.52', '0', '21000', '1018920', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '21000', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '420', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('11', '11', '3', '2', '47.52', '0', '21000', '997920', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '21000', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '420', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('12', '12', '9', '7', '244.00', '0', '2000', '488000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2000', '2017-05-25', null, '82', '1', '1', '1', '2', '20', '0', '0', '2', '9295.24');
INSERT INTO `purchasebillitem` VALUES ('13', '12', '9', '7', '203.00', '0', '2000', '406000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2000', '2017-05-25', null, '82', '1', '1', '1', '2', '20', '0', '0', '2', '7733.33');
INSERT INTO `purchasebillitem` VALUES ('14', '13', '3', '2', '47.52', '0', '2950', '140184', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2950', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '60', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('15', '14', '3', '2', '47.52', '0', '21000', '997920', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '21000', '2017-07-08', '07130000', '61', '1', '1', '1', '1', '420', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('16', '15', '3', '2', '47.52', '0', '2940', '139708.8', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2940', '2017-07-09', '07130000', '61', '1', '1', '1', '1', '60', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('17', '16', '3', '2', '47.52', '0', '2940', '139708.8', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2940', '2017-07-07', '07130000', '61', '1', '1', '1', '1', '60', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('18', '17', '3', '2', '57.52', '0', '23990', '1379904.8', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '23990', '2017-07-12', '07130000', '61', '1', '1', '1', '1', '480', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('19', '18', '3', '2', '55.52', '0', '23910', '1327483.2', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '23910', '2017-07-12', '07130000', '61', '1', '1', '1', '1', '480', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('20', '19', '3', '2', '47.52', '0', '16000', '760320', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '16000', '2017-07-12', '07130000', '61', '1', '1', '1', '1', '320', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('21', '20', '3', '2', '47.52', '0', '8035', '381823.2', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '8035', '2017-07-12', '07130000', '61', '1', '1', '1', '1', '160', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('22', '21', '3', '2', '47.52', '0', '16000', '760320', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '16000', '2017-07-14', '07130000', '61', '1', '1', '1', '1', '320', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('23', '22', '3', '2', '47.52', '0', '7895', '375170.4', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '7895', '2017-07-14', '07130000', '61', '1', '1', '1', '1', '160', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('24', '23', '3', '2', '48.52', '0', '7960', '386219.2', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '7960', '2017-07-14', '07130000', '61', '1', '1', '1', '1', '160', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('25', '24', '3', '2', '48.52', '0', '16000', '776320', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '16000', '2017-07-14', '07130000', '61', '1', '1', '1', '1', '320', null, null, null, null);
INSERT INTO `purchasebillitem` VALUES ('27', '26', '3', '2', '55.52', '0', '21000', '1165920', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '21000', '2017-07-15', '07130000', '61', '1', '1', '1', '1', '320', null, null, null, null);

-- ----------------------------
-- Table structure for `salesbill`
-- ----------------------------
DROP TABLE IF EXISTS `salesbill`;
CREATE TABLE `salesbill` (
  `salesBillID` bigint(20) NOT NULL AUTO_INCREMENT,
  `salesBillNumber` bigint(20) NOT NULL,
  `salesBillDisplayNumber` varchar(50) NOT NULL,
  `salesBillDate` date DEFAULT NULL,
  `CustomerID` bigint(20) DEFAULT NULL,
  `ProductDiscount` double(10,2) DEFAULT NULL,
  `TotalDiscount` double(10,2) DEFAULT NULL,
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
  `createdTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updatedBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `salesBillType` int(2) NOT NULL,
  `salesBillStatus` int(2) NOT NULL,
  `salesBillStage` int(2) NOT NULL,
  `salesBillLock` int(2) NOT NULL DEFAULT '0',
  `salesBillGSTType` int(2) DEFAULT NULL,
  `transport` varchar(200) DEFAULT NULL,
  `bundle` int(4) DEFAULT NULL,
  `addressRefId` double(20,0) DEFAULT NULL,
  `cstTotal` double DEFAULT NULL,
  `vatTotal` double DEFAULT NULL,
  `accountRefId` double DEFAULT NULL,
  `vatCstFlag` int(1) DEFAULT NULL,
  PRIMARY KEY (`salesBillID`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salesbill
-- ----------------------------
INSERT INTO `salesbill` VALUES ('5', '396', '396', '2017-07-03', '4', '0.00', '0.00', '128.57', '128.57', '0', '0.00', '0', '5142.8', '0', '0.06', '5400', '1', '1', '1', '2017-08-10 18:30:02', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '0', '98', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('6', '397', '397', '2017-07-03', '4', '0.00', '0.00', '96.43', '96.43', '0', '0.00', '0', '3857.1', '0', '0.04', '4050', '1', '1', '1', '2017-08-10 18:33:26', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '1', '98', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('7', '398', '398', '2017-07-03', '35', '0.00', '0.00', '100', '100', '0', '0.00', '0', '4000.05', '0', '-0.05', '4200', '1', '1', '1', '2017-08-10 18:34:35', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '34', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('8', '399', '399', '2017-07-03', '35', '0.00', '0.00', '16.2', '16.2', '0', '0.00', '0', '270', '0', '-0.4', '302', '1', '1', '1', '2017-08-10 18:35:24', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '34', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('9', '400', '400', '2017-07-03', '11', '0.00', '0.00', '38.1', '38.1', '0', '0.00', '0', '1523.84', '0', '-0.04', '1600', '1', '1', '1', '2017-08-10 18:36:16', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '1', '85', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('10', '401', '401', '2017-07-03', '37', '0.00', '0.00', '0', '0', '0', '0.00', '0', '4000', '0', '0', '4000', '1', '1', '1', '2017-08-10 18:37:00', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '1', '36', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('11', '402', '402', '2017-07-03', '114', '0.00', '0.00', '185.72', '185.72', '0', '0.00', '0', '7428.6', '0', '-0.04', '7800', '1', '1', '1', '2017-08-10 18:38:00', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '118', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('12', '403', '403', '2017-07-03', '114', '0.00', '0.00', '32.4', '32.4', '0', '0.00', '0', '540', '0', '0.2', '605', '1', '1', '1', '2017-08-10 18:38:39', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '118', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('13', '404', '404', '2017-07-03', '116', '0.00', '0.00', '71.43', '71.43', '0', '0.00', '0', '2857.2', '0', '-0.06', '3000', '1', '1', '1', '2017-08-11 09:40:08', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '120', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('14', '405', '405', '2017-07-03', '116', '0.00', '0.00', '13.5', '13.5', '0', '0.00', '0', '225', '0', '0', '252', '1', '1', '1', '2017-08-11 09:58:17', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '120', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('15', '406', '406', '2017-07-03', '107', '0.00', '0.00', '71.43', '71.43', '0', '0.00', '0', '2857.2', '0', '-0.06', '3000', '1', '1', '1', '2017-08-11 10:00:15', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '111', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('16', '407', '407', '2017-07-03', '107', '0.00', '0.00', '21.6', '21.6', '0', '0.00', '0', '360', '0', '-0.2', '403', '1', '1', '1', '2017-08-11 10:00:58', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '111', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('17', '408', '408', '2017-07-03', '20', '0.00', '0.00', '178.57', '178.57', '0', '0.00', '0', '7142.75', '0', '0.11', '7500', '1', '1', '1', '2017-08-11 10:01:59', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '19', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('18', '409', '409', '2017-07-03', '20', '0.00', '0.00', '27', '27', '0', '0.00', '0', '450', '0', '0', '504', '1', '1', '1', '2017-08-11 10:02:41', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '19', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('19', '410', '410', '2017-07-03', '77', '0.00', '0.00', '57.14', '57.14', '0', '0.00', '0', '2285.7', '0', '0.02', '2400', '1', '1', '1', '2017-08-11 10:06:03', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '121', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('20', '411', '411', '2017-07-03', '77', '0.00', '0.00', '16.2', '16.2', '0', '0.00', '0', '270', '0', '-0.4', '302', '1', '1', '1', '2017-08-11 10:07:17', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '121', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('21', '412', '412', '2017-07-03', '8', '0.00', '0.00', '85.71', '85.71', '0', '0.00', '0', '3428.55', '0', '0.03', '3600', '1', '1', '1', '2017-08-11 10:08:16', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '7', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('22', '413', '413', '2017-07-03', '8', '0.00', '0.00', '16.2', '16.2', '0', '0.00', '0', '270', '0', '-0.4', '302', '1', '1', '1', '2017-08-11 10:09:15', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '7', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('23', '414', '414', '2017-07-03', '77', '0.00', '0.00', '0', '0', '0', '0.00', '0', '7500', '0', '0', '7500', '1', '1', '1', '2017-08-11 10:10:53', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '3', '121', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('24', '415', '415', '2017-07-03', '117', '0.00', '0.00', '100', '100', '0', '0.00', '0', '4000.05', '0', '-0.05', '4200', '1', '1', '1', '2017-08-11 10:12:48', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '122', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('25', '416', '416', '2017-07-04', '11', '0.00', '0.00', '38.1', '38.1', '0', '0.00', '0', '1523.84', '0', '-0.04', '1600', '1', '1', '1', '2017-08-11 10:14:09', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '1', '85', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('26', '417', '417', '2017-07-05', '112', '0.00', '0.00', '157.14', '157.14', '0', '0.00', '0', '6285.6', '0', '0.12', '6600', '1', '1', '1', '2017-08-11 10:15:43', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '116', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('27', '418', '418', '2017-07-05', '46', '0.00', '0.00', '285.71', '285.71', '0', '0.00', '0', '11428.4', '0', '0.18', '12000', '1', '1', '1', '2017-08-11 10:17:12', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '45', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('28', '419', '419', '2017-07-05', '46', '0.00', '0.00', '43.2', '43.2', '0', '0.00', '0', '720', '0', '-0.4', '806', '1', '1', '1', '2017-08-11 10:18:05', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '45', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('29', '420', '420', '2017-07-05', '26', '0.00', '0.00', '133.34', '133.34', '0', '0.00', '0', '5333.4', '0', '-0.08', '5600', '1', '1', '1', '2017-08-11 10:19:05', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '25', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('30', '421', '421', '2017-07-05', '26', '0.00', '0.00', '21.6', '21.6', '0', '0.00', '0', '360', '0', '-0.2', '403', '1', '1', '1', '2017-08-11 10:20:05', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '25', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('31', '422', '422', '2017-07-05', '31', '0.00', '0.00', '107.14', '107.14', '0', '0.00', '0', '4285.65', '0', '0.07', '4500', '1', '1', '1', '2017-08-11 10:21:31', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '30', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('32', '423', '423', '2017-07-05', '31', '0.00', '0.00', '16.2', '16.2', '0', '0.00', '0', '270', '0', '-0.4', '302', '1', '1', '1', '2017-08-11 10:24:17', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '30', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('33', '424', '424', '2017-07-05', '109', '0.00', '0.00', '59.52', '59.52', '0', '0.00', '0', '2381', '0', '-0.04', '2500', '1', '1', '1', '2017-08-11 10:24:57', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '113', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('34', '425', '425', '2017-07-05', '23', '0.00', '0.00', '136.91', '136.91', '0', '0.00', '0', '5476.25', '0', '-0.07', '5750', '1', '1', '1', '2017-08-11 10:25:44', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '22', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('35', '426', '426', '2017-07-05', '23', '0.00', '0.00', '54', '54', '0', '0.00', '0', '900', '0', '0', '1008', '1', '1', '1', '2017-08-11 10:26:23', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '22', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('36', '427', '427', '2017-07-05', '25', '0.00', '0.00', '270', '270', '0', '0.00', '0', '4500', '0', '0', '5040', '1', '1', '1', '2017-08-11 10:27:37', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '2', '24', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('37', '428', '428', '2017-07-05', '118', '0.00', '0.00', '142.85', '142.85', '0', '0.00', '0', '5714.2', '0', '0.1', '6000', '1', '1', '1', '2017-08-11 10:31:01', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '123', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('38', '429', '429', '2017-07-05', '118', '0.00', '0.00', '21.6', '21.6', '0', '0.00', '0', '360', '0', '-0.2', '403', '1', '1', '1', '2017-08-11 10:31:38', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '123', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('39', '430', '430', '2017-07-05', '28', '0.00', '0.00', '0', '0', '0', '0.00', '0', '7500', '0', '0', '7500', '1', '1', '1', '2017-08-11 10:32:40', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '2', '27', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('40', '431', '431', '2017-07-05', '44', '0.00', '0.00', '0', '0', '0', '0.00', '0', '10350', '0', '0', '10350', '1', '1', '1', '2017-08-11 10:34:40', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '3', '43', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('41', '432', '432', '2017-07-05', '43', '0.00', '0.00', '0', '0', '0', '0.00', '0', '3750', '0', '0', '3750', '1', '1', '1', '2017-08-11 10:35:28', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '1', '42', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('42', '433', '433', '2017-07-05', '11', '0.00', '0.00', '38.1', '38.1', '0', '0.00', '0', '1523.84', '0', '-0.04', '1600', '1', '1', '1', '2017-08-11 10:37:41', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '1', '85', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('43', '434', '434', '2017-07-05', '10', '0.00', '0.00', '33.33', '33.33', '0', '0.00', '0', '1333.35', '0', '-0.01', '1400', '1', '1', '1', '2017-08-11 10:38:35', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '1', '84', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('44', '435', '435', '2017-07-05', '73', '0.00', '0.00', '0', '0', '0', '0.00', '0', '765000', '0', '0', '765000', '1', '1', '1', '2017-08-11 10:40:35', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '200', '72', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('45', '436', '436', '2017-07-05', '102', '0.00', '0.00', '0', '0', '0', '0.00', '0', '27200', '0', '0', '27200', '1', '1', '1', '2017-08-11 13:42:14', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '40', '106', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('46', '395', '395', '2017-07-01', '3', '0.00', '0.00', '0', '0', '0', '0.00', '0', '7250', '0', '0', '7250', '1', '1', '1', '2017-08-11 13:56:31', '0', '0000-00-00 00:00:00', '2', '0', '1', '0', '1', '', '2', '2', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('47', '394', '394', '2017-07-01', '2', '0.00', '0.00', '0', '0', '0', '0.00', '0', '1380000', '0', '0', '1380000', '1', '1', '1', '2017-08-11 13:57:13', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '2', '', '400', '1', null, null, '7', '0');
INSERT INTO `salesbill` VALUES ('51', '2', '2', '2017-08-11', '3', '0.00', '0.00', '0', '0', '0', '0.00', '0', '12000', '0', '0', '12200', '1', '1', '1', '2017-08-11 17:57:40', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '', '60', '2', '0', '200', null, '1');
INSERT INTO `salesbill` VALUES ('52', '1', '1', '2017-08-11', '3', '0.00', '0.00', '0', '0', '0', '0.00', '0', '8000', '0', '0', '8000', '1', '1', '1', '2017-08-11 18:20:55', '0', '0000-00-00 00:00:00', '1', '0', '1', '0', '1', '100', '40', '2', '0', '0', null, '1');

-- ----------------------------
-- Table structure for `salesbillitem`
-- ----------------------------
DROP TABLE IF EXISTS `salesbillitem`;
CREATE TABLE `salesbillitem` (
  `ID` double NOT NULL AUTO_INCREMENT,
  `salesBillRefId` bigint(20) NOT NULL,
  `itemRefId` bigint(20) DEFAULT NULL,
  `commodityRefId` bigint(20) DEFAULT NULL,
  `unitrate` double(30,2) DEFAULT NULL,
  `Discount` double DEFAULT NULL,
  `Quantity` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `chessRate` double NOT NULL,
  `chessTotal` double NOT NULL,
  `cgstRate` double NOT NULL,
  `cgstTotal` double NOT NULL,
  `sgstRate` double NOT NULL,
  `sgstTotal` double NOT NULL,
  `igstRate` double NOT NULL,
  `igstTotal` double NOT NULL,
  `UOMRefId` bigint(20) DEFAULT NULL,
  `packingfactor` double DEFAULT NULL,
  `totalUOMQuantity` double DEFAULT NULL,
  `salesBillDate` date NOT NULL,
  `hsnCodeRefId` varchar(20) DEFAULT NULL,
  `salesCustomerRefId` bigint(20) NOT NULL,
  `companyRefId` bigint(20) NOT NULL,
  `accountYearRefId` bigint(20) NOT NULL,
  `salesBillType` int(2) NOT NULL,
  `salesBillGSTType` int(2) DEFAULT NULL,
  `salesBillBags` int(11) DEFAULT NULL,
  `cstRate` double DEFAULT NULL,
  `cstTotal` double DEFAULT NULL,
  `vatRate` double DEFAULT NULL,
  `vatTotal` double DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salesbillitem
-- ----------------------------
INSERT INTO `salesbillitem` VALUES ('8', '5', '4', '1', '257.14', '0', '20', '5142.8', '0', '0', '2.5', '128.57', '2.5', '128.57', '0', '0', '1', '1', '20', '2017-07-03', '09012000', '4', '1', '1', '1', '1', '0', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('9', '6', '4', '1', '257.14', '0', '15', '3857.1', '0', '0', '2.5', '96.43', '2.5', '96.43', '0', '0', '1', '1', '15', '2017-07-03', '09012000', '4', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('10', '7', '4', '1', '266.67', '0', '15', '4000.05', '0', '0', '2.5', '100', '2.5', '100', '0', '0', '1', '1', '15', '2017-07-03', '09012000', '35', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('11', '8', '14', '11', '90.00', '0', '3', '270', '0', '0', '6', '16.2', '6', '16.2', '0', '0', '1', '1', '3', '2017-07-03', '21013010', '35', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('12', '9', '4', '1', '190.48', '0', '8', '1523.84', '0', '0', '2.5', '38.1', '2.5', '38.1', '0', '0', '1', '1', '8', '2017-07-03', '09012000', '11', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('13', '10', '3', '2', '80.00', '0', '50', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-03', '07130000', '37', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('14', '11', '4', '1', '247.62', '0', '30', '7428.6', '0', '0', '2.5', '185.72', '2.5', '185.72', '0', '0', '1', '1', '30', '2017-07-03', '09012000', '114', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('15', '12', '14', '11', '90.00', '0', '6', '540', '0', '0', '6', '32.4', '6', '32.4', '0', '0', '1', '1', '6', '2017-07-03', '21013010', '114', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('16', '13', '4', '1', '238.10', '0', '12', '2857.2', '0', '0', '2.5', '71.43', '2.5', '71.43', '0', '0', '1', '1', '12', '2017-07-03', '09012000', '116', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('17', '14', '14', '11', '90.00', '0', '2.5', '225', '0', '0', '6', '13.5', '6', '13.5', '0', '0', '1', '1', '2.5', '2017-07-03', '21013010', '116', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('18', '15', '4', '1', '238.10', '0', '12', '2857.2', '0', '0', '2.5', '71.43', '2.5', '71.43', '0', '0', '1', '1', '12', '2017-07-03', '09012000', '107', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('19', '16', '14', '11', '90.00', '0', '4', '360', '0', '0', '6', '21.6', '6', '21.6', '0', '0', '1', '1', '4', '2017-07-03', '21013010', '107', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('20', '17', '4', '1', '285.71', '0', '25', '7142.75', '0', '0', '2.5', '178.57', '2.5', '178.57', '0', '0', '1', '1', '25', '2017-07-03', '09012000', '20', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('21', '18', '14', '11', '90.00', '0', '5', '450', '0', '0', '6', '27', '6', '27', '0', '0', '1', '1', '5', '2017-07-03', '21013010', '20', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('22', '19', '4', '1', '228.57', '0', '10', '2285.7', '0', '0', '2.5', '57.14', '2.5', '57.14', '0', '0', '1', '1', '10', '2017-07-03', '09012000', '77', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('23', '20', '14', '11', '90.00', '0', '3', '270', '0', '0', '6', '16.2', '6', '16.2', '0', '0', '1', '1', '3', '2017-07-03', '21013010', '77', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('24', '21', '4', '1', '228.57', '0', '15', '3428.55', '0', '0', '2.5', '85.71', '2.5', '85.71', '0', '0', '1', '1', '15', '2017-07-03', '09012000', '8', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('25', '22', '14', '11', '90.00', '0', '3', '270', '0', '0', '6', '16.2', '6', '16.2', '0', '0', '1', '1', '3', '2017-07-03', '21013010', '8', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('26', '23', '3', '2', '85.00', '0', '50', '4250', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-03', '07130000', '77', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('27', '23', '5', '3', '65.00', '0', '25', '1625', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '25', '2017-07-03', '07130000', '77', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('28', '23', '6', '4', '65.00', '0', '25', '1625', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '25', '2017-07-03', '07130000', '77', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('29', '24', '4', '1', '266.67', '0', '15', '4000.05', '0', '0', '2.5', '100', '2.5', '100', '0', '0', '1', '1', '15', '2017-07-03', '09012000', '117', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('30', '25', '4', '1', '190.48', '0', '8', '1523.84', '0', '0', '2.5', '38.1', '2.5', '38.1', '0', '0', '1', '1', '8', '2017-07-04', '09012000', '11', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('31', '26', '4', '1', '314.28', '0', '20', '6285.6', '0', '0', '2.5', '157.14', '2.5', '157.14', '0', '0', '1', '1', '20', '2017-07-05', '09012000', '112', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('32', '27', '4', '1', '285.71', '0', '40', '11428.4', '0', '0', '2.5', '285.71', '2.5', '285.71', '0', '0', '1', '1', '40', '2017-07-05', '09012000', '46', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('33', '28', '14', '11', '90.00', '0', '8', '720', '0', '0', '6', '43.2', '6', '43.2', '0', '0', '1', '1', '8', '2017-07-05', '21013010', '46', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('34', '29', '4', '1', '266.67', '0', '20', '5333.4', '0', '0', '2.5', '133.34', '2.5', '133.34', '0', '0', '1', '1', '20', '2017-07-05', '09012000', '26', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('35', '30', '14', '11', '90.00', '0', '4', '360', '0', '0', '6', '21.6', '6', '21.6', '0', '0', '1', '1', '4', '2017-07-05', '21013010', '26', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('36', '31', '4', '1', '285.71', '0', '15', '4285.65', '0', '0', '2.5', '107.14', '2.5', '107.14', '0', '0', '1', '1', '15', '2017-07-05', '09012000', '31', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('37', '32', '14', '11', '90.00', '0', '3', '270', '0', '0', '6', '16.2', '6', '16.2', '0', '0', '1', '1', '3', '2017-07-05', '21013010', '31', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('38', '33', '4', '1', '238.10', '0', '10', '2381', '0', '0', '2.5', '59.53', '2.5', '59.53', '0', '0', '1', '1', '10', '2017-07-05', '09012000', '109', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('39', '34', '4', '1', '219.05', '0', '25', '5476.25', '0', '0', '2.5', '136.91', '2.5', '136.91', '0', '0', '1', '1', '25', '2017-07-05', '09012000', '23', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('40', '35', '14', '11', '90.00', '0', '10', '900', '0', '0', '6', '54', '6', '54', '0', '0', '1', '1', '10', '2017-07-05', '21013010', '23', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('41', '36', '14', '11', '90.00', '0', '50', '4500', '0', '0', '6', '270', '6', '270', '0', '0', '1', '1', '50', '2017-07-05', '21013010', '25', '1', '1', '1', '1', '2', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('42', '37', '4', '1', '285.71', '0', '20', '5714.2', '0', '0', '2.5', '142.85', '2.5', '142.85', '0', '0', '1', '1', '20', '2017-07-05', '09012000', '118', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('43', '38', '14', '11', '90.00', '0', '4', '360', '0', '0', '6', '21.6', '6', '21.6', '0', '0', '1', '1', '4', '2017-07-05', '21013010', '118', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('44', '39', '3', '2', '75.00', '0', '100', '7500', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '100', '2017-07-05', '07130000', '28', '1', '1', '1', '1', '2', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('45', '40', '3', '2', '72.00', '0', '50', '3600', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-05', '07130000', '44', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('46', '40', '3', '2', '75.00', '0', '50', '3750', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-05', '07130000', '44', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('47', '40', '5', '3', '60.00', '0', '50', '3000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-05', '07130000', '44', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('48', '41', '3', '2', '75.00', '0', '50', '3750', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-05', '07130000', '43', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('49', '42', '4', '1', '190.48', '0', '8', '1523.84', '0', '0', '2.5', '38.1', '2.5', '38.1', '0', '0', '1', '1', '8', '2017-07-05', '09012000', '11', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('50', '43', '4', '1', '266.67', '0', '5', '1333.35', '0', '0', '2.5', '33.33', '2.5', '33.33', '0', '0', '1', '1', '5', '2017-07-05', '09012000', '10', '1', '1', '1', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('51', '44', '3', '2', '83.00', '0', '5000', '415000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '5000', '2017-07-05', '07130000', '73', '1', '1', '1', '1', '100', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('52', '44', '6', '4', '70.00', '0', '2500', '175000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2500', '2017-07-05', '07130000', '73', '1', '1', '1', '1', '50', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('53', '44', '7', '5', '70.00', '0', '2500', '175000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2500', '2017-07-05', '07130000', '73', '1', '1', '1', '1', '50', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('54', '45', '12', '12', '13.60', '0', '2000', '27200', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2000', '2017-07-05', '23025000', '102', '1', '1', '1', '1', '40', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('55', '46', '3', '2', '80.00', '0', '50', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-01', '07130000', '3', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('56', '46', '5', '3', '65.00', '0', '50', '3250', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '50', '2017-07-01', '07130000', '3', '1', '1', '2', '1', '1', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('57', '47', '3', '2', '64.00', '0', '10000', '640000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '10000', '2017-07-01', '07130000', '2', '1', '1', '1', '2', '200', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('58', '47', '3', '2', '74.00', '0', '10000', '740000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '10000', '2017-07-01', '07130000', '2', '1', '1', '1', '2', '200', null, null, null, null);
INSERT INTO `salesbillitem` VALUES ('63', '51', '4', '1', '200.00', '0', '20', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '20', '2017-08-11', null, '3', '1', '1', '1', '1', '20', '0', '0', '5', '200');
INSERT INTO `salesbillitem` VALUES ('64', '51', '3', '2', '200.00', '0', '20', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '20', '2017-08-11', null, '3', '1', '1', '1', '1', '20', '0', '0', '0', '0');
INSERT INTO `salesbillitem` VALUES ('65', '51', '3', '2', '200.00', '0', '20', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '20', '2017-08-11', null, '3', '1', '1', '1', '1', '20', '0', '0', '0', '0');
INSERT INTO `salesbillitem` VALUES ('66', '52', '3', '2', '200.00', '0', '20', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '20', '2017-08-11', null, '3', '1', '1', '1', '1', '20', '0', '0', '0', '0');
INSERT INTO `salesbillitem` VALUES ('67', '52', '3', '2', '200.00', '0', '20', '4000', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '20', '2017-08-11', null, '3', '1', '1', '1', '1', '20', '0', '0', '0', '0');

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

-- ----------------------------
-- Table structure for `state`
-- ----------------------------
DROP TABLE IF EXISTS `state`;
CREATE TABLE `state` (
  `stateId` bigint(20) NOT NULL AUTO_INCREMENT,
  `stateName` varchar(200) DEFAULT NULL,
  `countryRefiId` bigint(20) DEFAULT NULL,
  `activeFlag` int(1) DEFAULT '1',
  `stateCode` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`stateId`),
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
  `stockId` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `updatedTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updatedBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`stockId`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of stock
-- ----------------------------
INSERT INTO `stock` VALUES ('10', '2', '1', '23960', '2017-07-05', '1', '1', '1', '4', '3', '1', '2017-08-10 18:10:27', '0', '2017-08-10 12:40:27');
INSERT INTO `stock` VALUES ('11', '2', '1', '3000', '2017-07-06', '1', '1', '1', '4', '4', '1', '2017-08-10 18:13:18', '0', '2017-08-10 12:43:18');
INSERT INTO `stock` VALUES ('12', '2', '1', '23860', '2017-07-05', '1', '1', '1', '4', '5', '1', '2017-08-10 18:16:08', '0', '2017-08-10 12:46:08');
INSERT INTO `stock` VALUES ('13', '2', '1', '21000', '2017-07-06', '1', '1', '1', '4', '6', '1', '2017-08-10 18:18:27', '0', '2017-08-10 12:48:27');
INSERT INTO `stock` VALUES ('14', '2', '1', '21000', '2017-07-07', '1', '1', '1', '4', '7', '4', '2017-08-10 18:25:27', '0', '2017-08-10 12:55:27');
INSERT INTO `stock` VALUES ('15', '1', '1', '20', '2017-07-03', '1', '1', '2', '2', '8', '1', '2017-08-10 18:30:02', '0', '2017-08-10 13:00:02');
INSERT INTO `stock` VALUES ('16', '1', '1', '15', '2017-07-03', '1', '1', '2', '2', '9', '1', '2017-08-10 18:33:26', '0', '2017-08-10 13:03:26');
INSERT INTO `stock` VALUES ('17', '1', '1', '15', '2017-07-03', '1', '1', '2', '2', '10', '1', '2017-08-10 18:34:35', '0', '2017-08-10 13:04:35');
INSERT INTO `stock` VALUES ('18', '11', '1', '3', '2017-07-03', '1', '1', '2', '2', '11', '1', '2017-08-10 18:35:24', '0', '2017-08-10 13:05:24');
INSERT INTO `stock` VALUES ('19', '1', '1', '8', '2017-07-03', '1', '1', '2', '2', '12', '1', '2017-08-10 18:36:16', '0', '2017-08-10 13:06:16');
INSERT INTO `stock` VALUES ('20', '2', '1', '50', '2017-07-03', '1', '1', '2', '2', '13', '1', '2017-08-10 18:37:00', '0', '2017-08-10 13:07:00');
INSERT INTO `stock` VALUES ('21', '1', '1', '30', '2017-07-03', '1', '1', '2', '2', '14', '1', '2017-08-10 18:38:00', '0', '2017-08-10 13:08:00');
INSERT INTO `stock` VALUES ('22', '11', '1', '6', '2017-07-03', '1', '1', '2', '2', '15', '1', '2017-08-10 18:38:39', '0', '2017-08-10 13:08:39');
INSERT INTO `stock` VALUES ('24', '2', '1', '2970', '2017-07-07', '1', '1', '1', '4', '8', '1', '2017-08-10 18:52:10', '0', '2017-08-10 13:22:10');
INSERT INTO `stock` VALUES ('25', '2', '1', '3020', '2017-07-07', '1', '1', '1', '4', '9', '1', '2017-08-10 19:12:14', '0', '2017-08-10 13:42:14');
INSERT INTO `stock` VALUES ('26', '2', '1', '21000', '2017-07-07', '1', '1', '1', '4', '10', '1', '2017-08-10 19:32:40', '0', '2017-08-10 14:02:40');
INSERT INTO `stock` VALUES ('27', '2', '1', '21000', '2017-07-07', '1', '1', '1', '4', '11', '1', '2017-08-10 19:33:44', '0', '2017-08-10 14:03:44');
INSERT INTO `stock` VALUES ('28', '7', '1', '2000', '2017-05-25', '1', '1', '1', '4', '12', '1', '2017-08-10 20:16:45', '0', '2017-08-10 14:46:45');
INSERT INTO `stock` VALUES ('29', '7', '1', '2000', '2017-05-25', '1', '1', '1', '4', '13', '1', '2017-08-10 20:16:45', '0', '2017-08-10 14:46:45');
INSERT INTO `stock` VALUES ('30', '1', '1', '12', '2017-07-03', '1', '1', '2', '2', '16', '1', '2017-08-11 09:40:08', '0', '2017-08-11 04:10:08');
INSERT INTO `stock` VALUES ('31', '11', '1', '2.5', '2017-07-03', '1', '1', '2', '2', '17', '1', '2017-08-11 09:58:17', '0', '2017-08-11 04:28:17');
INSERT INTO `stock` VALUES ('32', '1', '1', '12', '2017-07-03', '1', '1', '2', '2', '18', '1', '2017-08-11 10:00:15', '0', '2017-08-11 04:30:15');
INSERT INTO `stock` VALUES ('33', '11', '1', '4', '2017-07-03', '1', '1', '2', '2', '19', '1', '2017-08-11 10:00:58', '0', '2017-08-11 04:30:58');
INSERT INTO `stock` VALUES ('34', '1', '1', '25', '2017-07-03', '1', '1', '2', '2', '20', '1', '2017-08-11 10:01:59', '0', '2017-08-11 04:31:59');
INSERT INTO `stock` VALUES ('35', '11', '1', '5', '2017-07-03', '1', '1', '2', '2', '21', '1', '2017-08-11 10:02:41', '0', '2017-08-11 04:32:41');
INSERT INTO `stock` VALUES ('36', '1', '1', '10', '2017-07-03', '1', '1', '2', '2', '22', '1', '2017-08-11 10:06:03', '0', '2017-08-11 04:36:03');
INSERT INTO `stock` VALUES ('37', '11', '1', '3', '2017-07-03', '1', '1', '2', '2', '23', '1', '2017-08-11 10:07:17', '0', '2017-08-11 04:37:17');
INSERT INTO `stock` VALUES ('38', '1', '1', '15', '2017-07-03', '1', '1', '2', '2', '24', '1', '2017-08-11 10:08:16', '0', '2017-08-11 04:38:16');
INSERT INTO `stock` VALUES ('39', '11', '1', '3', '2017-07-03', '1', '1', '2', '2', '25', '1', '2017-08-11 10:09:15', '0', '2017-08-11 04:39:15');
INSERT INTO `stock` VALUES ('40', '2', '1', '50', '2017-07-03', '1', '1', '2', '2', '26', '1', '2017-08-11 10:10:53', '0', '2017-08-11 04:40:53');
INSERT INTO `stock` VALUES ('41', '3', '1', '25', '2017-07-03', '1', '1', '2', '2', '27', '1', '2017-08-11 10:10:53', '0', '2017-08-11 04:40:53');
INSERT INTO `stock` VALUES ('42', '4', '1', '25', '2017-07-03', '1', '1', '2', '2', '28', '1', '2017-08-11 10:10:53', '0', '2017-08-11 04:40:53');
INSERT INTO `stock` VALUES ('43', '1', '1', '15', '2017-07-03', '1', '1', '2', '2', '29', '1', '2017-08-11 10:12:48', '0', '2017-08-11 04:42:48');
INSERT INTO `stock` VALUES ('44', '1', '1', '8', '2017-07-04', '1', '1', '2', '2', '30', '1', '2017-08-11 10:14:09', '0', '2017-08-11 04:44:09');
INSERT INTO `stock` VALUES ('45', '1', '1', '20', '2017-07-05', '1', '1', '2', '2', '31', '1', '2017-08-11 10:15:43', '0', '2017-08-11 04:45:43');
INSERT INTO `stock` VALUES ('46', '1', '1', '40', '2017-07-05', '1', '1', '2', '2', '32', '1', '2017-08-11 10:17:12', '0', '2017-08-11 04:47:12');
INSERT INTO `stock` VALUES ('47', '11', '1', '8', '2017-07-05', '1', '1', '2', '2', '33', '1', '2017-08-11 10:18:05', '0', '2017-08-11 04:48:05');
INSERT INTO `stock` VALUES ('48', '1', '1', '20', '2017-07-05', '1', '1', '2', '2', '34', '1', '2017-08-11 10:19:05', '0', '2017-08-11 04:49:05');
INSERT INTO `stock` VALUES ('49', '11', '1', '4', '2017-07-05', '1', '1', '2', '2', '35', '1', '2017-08-11 10:20:05', '0', '2017-08-11 04:50:05');
INSERT INTO `stock` VALUES ('50', '1', '1', '15', '2017-07-05', '1', '1', '2', '2', '36', '1', '2017-08-11 10:21:31', '0', '2017-08-11 04:51:31');
INSERT INTO `stock` VALUES ('51', '11', '1', '3', '2017-07-05', '1', '1', '2', '2', '37', '1', '2017-08-11 10:24:17', '0', '2017-08-11 04:54:17');
INSERT INTO `stock` VALUES ('52', '1', '1', '10', '2017-07-05', '1', '1', '2', '2', '38', '1', '2017-08-11 10:24:57', '0', '2017-08-11 04:54:57');
INSERT INTO `stock` VALUES ('53', '1', '1', '25', '2017-07-05', '1', '1', '2', '2', '39', '1', '2017-08-11 10:25:44', '0', '2017-08-11 04:55:44');
INSERT INTO `stock` VALUES ('54', '11', '1', '10', '2017-07-05', '1', '1', '2', '2', '40', '1', '2017-08-11 10:26:23', '0', '2017-08-11 04:56:23');
INSERT INTO `stock` VALUES ('55', '11', '1', '50', '2017-07-05', '1', '1', '2', '2', '41', '1', '2017-08-11 10:27:37', '0', '2017-08-11 04:57:37');
INSERT INTO `stock` VALUES ('56', '1', '1', '20', '2017-07-05', '1', '1', '2', '2', '42', '1', '2017-08-11 10:31:01', '0', '2017-08-11 05:01:01');
INSERT INTO `stock` VALUES ('57', '11', '1', '4', '2017-07-05', '1', '1', '2', '2', '43', '1', '2017-08-11 10:31:38', '0', '2017-08-11 05:01:38');
INSERT INTO `stock` VALUES ('58', '2', '1', '100', '2017-07-05', '1', '1', '2', '2', '44', '1', '2017-08-11 10:32:40', '0', '2017-08-11 05:02:40');
INSERT INTO `stock` VALUES ('59', '2', '1', '50', '2017-07-05', '1', '1', '2', '2', '45', '1', '2017-08-11 10:34:40', '0', '2017-08-11 05:04:40');
INSERT INTO `stock` VALUES ('60', '2', '1', '50', '2017-07-05', '1', '1', '2', '2', '46', '1', '2017-08-11 10:34:40', '0', '2017-08-11 05:04:40');
INSERT INTO `stock` VALUES ('61', '3', '1', '50', '2017-07-05', '1', '1', '2', '2', '47', '1', '2017-08-11 10:34:40', '0', '2017-08-11 05:04:40');
INSERT INTO `stock` VALUES ('62', '2', '1', '50', '2017-07-05', '1', '1', '2', '2', '48', '1', '2017-08-11 10:35:28', '0', '2017-08-11 05:05:28');
INSERT INTO `stock` VALUES ('63', '1', '1', '8', '2017-07-05', '1', '1', '2', '2', '49', '1', '2017-08-11 10:37:41', '0', '2017-08-11 05:07:41');
INSERT INTO `stock` VALUES ('64', '1', '1', '5', '2017-07-05', '1', '1', '2', '2', '50', '1', '2017-08-11 10:38:35', '0', '2017-08-11 05:08:35');
INSERT INTO `stock` VALUES ('65', '2', '1', '5000', '2017-07-05', '1', '1', '2', '2', '51', '1', '2017-08-11 10:40:35', '0', '2017-08-11 05:10:35');
INSERT INTO `stock` VALUES ('66', '4', '1', '2500', '2017-07-05', '1', '1', '2', '2', '52', '1', '2017-08-11 10:40:35', '0', '2017-08-11 05:10:35');
INSERT INTO `stock` VALUES ('67', '5', '1', '2500', '2017-07-05', '1', '1', '2', '2', '53', '1', '2017-08-11 10:40:35', '0', '2017-08-11 05:10:35');
INSERT INTO `stock` VALUES ('68', '2', '1', '2950', '2017-07-07', '1', '1', '1', '4', '14', '1', '2017-08-11 12:30:03', '0', '2017-08-11 07:00:03');
INSERT INTO `stock` VALUES ('69', '2', '1', '21000', '2017-07-08', '1', '1', '1', '4', '15', '1', '2017-08-11 12:35:47', '0', '2017-08-11 07:05:47');
INSERT INTO `stock` VALUES ('70', '2', '1', '2940', '2017-07-09', '1', '1', '1', '4', '16', '1', '2017-08-11 12:37:29', '0', '2017-08-11 07:07:29');
INSERT INTO `stock` VALUES ('71', '2', '1', '2940', '2017-07-07', '1', '1', '1', '4', '17', '1', '2017-08-11 12:41:09', '0', '2017-08-11 07:11:09');
INSERT INTO `stock` VALUES ('72', '2', '1', '23990', '2017-07-12', '1', '1', '1', '4', '18', '1', '2017-08-11 12:43:49', '0', '2017-08-11 07:13:49');
INSERT INTO `stock` VALUES ('73', '2', '1', '23910', '2017-07-12', '1', '1', '1', '4', '19', '1', '2017-08-11 12:45:09', '0', '2017-08-11 07:15:09');
INSERT INTO `stock` VALUES ('74', '2', '1', '16000', '2017-07-12', '1', '1', '1', '4', '20', '1', '2017-08-11 12:46:20', '0', '2017-08-11 07:16:20');
INSERT INTO `stock` VALUES ('75', '2', '1', '8035', '2017-07-12', '1', '1', '1', '4', '21', '1', '2017-08-11 12:47:59', '0', '2017-08-11 07:17:59');
INSERT INTO `stock` VALUES ('76', '2', '1', '16000', '2017-07-14', '1', '1', '1', '4', '22', '1', '2017-08-11 12:49:10', '0', '2017-08-11 07:19:10');
INSERT INTO `stock` VALUES ('77', '2', '1', '7895', '2017-07-14', '1', '1', '1', '4', '23', '1', '2017-08-11 12:50:18', '0', '2017-08-11 07:20:18');
INSERT INTO `stock` VALUES ('78', '2', '1', '7960', '2017-07-14', '1', '1', '1', '4', '24', '1', '2017-08-11 12:51:28', '0', '2017-08-11 07:21:28');
INSERT INTO `stock` VALUES ('79', '2', '1', '16000', '2017-07-14', '1', '1', '1', '4', '25', '1', '2017-08-11 12:53:13', '0', '2017-08-11 07:23:13');
INSERT INTO `stock` VALUES ('81', '12', '1', '2000', '2017-07-05', '1', '1', '2', '2', '54', '1', '2017-08-11 13:42:14', '0', '2017-08-11 08:12:14');
INSERT INTO `stock` VALUES ('82', '2', '1', '21000', '2017-07-15', '1', '1', '1', '4', '27', '1', '2017-08-11 13:54:31', '0', '2017-08-11 08:24:31');
INSERT INTO `stock` VALUES ('83', '2', '1', '50', '2017-07-01', '1', '1', '2', '2', '55', '1', '2017-08-11 13:56:31', '0', '2017-08-11 08:26:31');
INSERT INTO `stock` VALUES ('84', '3', '1', '50', '2017-07-01', '1', '1', '2', '2', '56', '1', '2017-08-11 13:56:31', '0', '2017-08-11 08:26:31');
INSERT INTO `stock` VALUES ('85', '2', '1', '10000', '2017-07-01', '1', '1', '2', '2', '57', '1', '2017-08-11 13:57:13', '0', '2017-08-11 08:27:13');
INSERT INTO `stock` VALUES ('86', '2', '1', '10000', '2017-07-01', '1', '1', '2', '2', '58', '1', '2017-08-11 13:57:13', '0', '2017-08-11 08:27:13');
INSERT INTO `stock` VALUES ('91', '1', '1', '20', '2017-08-11', '1', '1', '2', '2', '63', '1', '2017-08-11 17:57:40', '0', '2017-08-11 12:27:40');
INSERT INTO `stock` VALUES ('92', '2', '1', '20', '2017-08-11', '1', '1', '2', '2', '64', '1', '2017-08-11 17:57:40', '0', '2017-08-11 12:27:40');
INSERT INTO `stock` VALUES ('93', '2', '1', '20', '2017-08-11', '1', '1', '2', '2', '65', '1', '2017-08-11 17:57:40', '0', '2017-08-11 12:27:40');
INSERT INTO `stock` VALUES ('94', '2', '1', '20', '2017-08-11', '1', '1', '2', '2', '66', '1', '2017-08-11 18:20:55', '0', '2017-08-11 12:50:55');
INSERT INTO `stock` VALUES ('95', '2', '1', '20', '2017-08-11', '1', '1', '2', '2', '67', '1', '2017-08-11 18:20:55', '0', '2017-08-11 12:50:55');

-- ----------------------------
-- Table structure for `tablereference`
-- ----------------------------
DROP TABLE IF EXISTS `tablereference`;
CREATE TABLE `tablereference` (
  `referenceId` int(3) NOT NULL AUTO_INCREMENT,
  `referenceTable` varchar(30) NOT NULL,
  PRIMARY KEY (`referenceId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tablereference
-- ----------------------------
INSERT INTO `tablereference` VALUES ('1', 'salesbill');
INSERT INTO `tablereference` VALUES ('2', 'salesbillitem');
INSERT INTO `tablereference` VALUES ('3', 'purchasebill');
INSERT INTO `tablereference` VALUES ('4', 'purchasebillitem');
INSERT INTO `tablereference` VALUES ('5', 'test');

-- ----------------------------
-- Table structure for `uom`
-- ----------------------------
DROP TABLE IF EXISTS `uom`;
CREATE TABLE `uom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of uom
-- ----------------------------
INSERT INTO `uom` VALUES ('1', 'Kg');
INSERT INTO `uom` VALUES ('2', 'Nos');
INSERT INTO `uom` VALUES ('3', 'Tons');
INSERT INTO `uom` VALUES ('4', 'Bags');
INSERT INTO `uom` VALUES ('5', 'LITER');
INSERT INTO `uom` VALUES ('6', 'CU FT');
INSERT INTO `uom` VALUES ('7', 'gm');
INSERT INTO `uom` VALUES ('8', 'bot');
INSERT INTO `uom` VALUES ('9', 'Meter');
INSERT INTO `uom` VALUES ('10', 'Roll');
INSERT INTO `uom` VALUES ('11', 'mm');
INSERT INTO `uom` VALUES ('12', 'HOURS');
INSERT INTO `uom` VALUES ('13', 'Inch');
INSERT INTO `uom` VALUES ('14', 'Deg');
INSERT INTO `uom` VALUES ('15', 'DEGRE');
INSERT INTO `uom` VALUES ('16', 'volum');
INSERT INTO `uom` VALUES ('17', 'DAY');
INSERT INTO `uom` VALUES ('18', 'min');
INSERT INTO `uom` VALUES ('19', 'PSI');
INSERT INTO `uom` VALUES ('20', 'Can');
INSERT INTO `uom` VALUES ('21', '%');
INSERT INTO `uom` VALUES ('22', 'cm');
INSERT INTO `uom` VALUES ('23', '°C');
INSERT INTO `uom` VALUES ('24', 'Meq/k');
INSERT INTO `uom` VALUES ('25', 'M/V');
INSERT INTO `uom` VALUES ('28', 'KM');
INSERT INTO `uom` VALUES ('29', 'R/F');
INSERT INTO `uom` VALUES ('30', 'ML');
INSERT INTO `uom` VALUES ('31', 'BOX');
INSERT INTO `uom` VALUES ('32', 'Amps');
INSERT INTO `uom` VALUES ('33', 'Kg/Scm');
INSERT INTO `uom` VALUES ('34', 'R amp');
INSERT INTO `uom` VALUES ('35', 'units');
INSERT INTO `uom` VALUES ('36', 'DATE');
INSERT INTO `uom` VALUES ('37', 'MONTH');
INSERT INTO `uom` VALUES ('38', 'sqmtr');
INSERT INTO `uom` VALUES ('39', 'Shift');
INSERT INTO `uom` VALUES ('40', 'HSU');
INSERT INTO `uom` VALUES ('41', '°C');
INSERT INTO `uom` VALUES ('42', 'KwH');
INSERT INTO `uom` VALUES ('43', 'PPM');
INSERT INTO `uom` VALUES ('44', 'Volts');
INSERT INTO `uom` VALUES ('45', 'week');
INSERT INTO `uom` VALUES ('46', 'TDS');
INSERT INTO `uom` VALUES ('47', 'RPM');
INSERT INTO `uom` VALUES ('48', 'Green');
INSERT INTO `uom` VALUES ('49', '+ VE');
INSERT INTO `uom` VALUES ('50', '- VE');
INSERT INTO `uom` VALUES ('51', 'Red');
INSERT INTO `uom` VALUES ('52', 'kg/cm');
INSERT INTO `uom` VALUES ('53', 'cycle');
INSERT INTO `uom` VALUES ('54', 'SP/GR');
INSERT INTO `uom` VALUES ('55', 'Rs.');
INSERT INTO `uom` VALUES ('56', 'Ohms');
INSERT INTO `uom` VALUES ('57', 'WEEK');
INSERT INTO `uom` VALUES ('58', 'KVA');
INSERT INTO `uom` VALUES ('59', 'SACHE');
INSERT INTO `uom` VALUES ('60', 'KW');
INSERT INTO `uom` VALUES ('61', 'INCH');
INSERT INTO `uom` VALUES ('62', 'MLBAR');
INSERT INTO `uom` VALUES ('63', 'Gap');
INSERT INTO `uom` VALUES ('64', 'KATTU');
INSERT INTO `uom` VALUES ('65', 'gm');
INSERT INTO `uom` VALUES ('66', 'AM');
INSERT INTO `uom` VALUES ('67', 'PM');
INSERT INTO `uom` VALUES ('68', 'TIMES');
INSERT INTO `uom` VALUES ('69', 'Tread');
INSERT INTO `uom` VALUES ('70', 'BATCH');
INSERT INTO `uom` VALUES ('71', 'Pouch');
INSERT INTO `uom` VALUES ('72', 'Round');
INSERT INTO `uom` VALUES ('73', 'M Ohm');
INSERT INTO `uom` VALUES ('74', 'FFA');
INSERT INTO `uom` VALUES ('75', 'CUBIC');
INSERT INTO `uom` VALUES ('76', 'UNIT');
INSERT INTO `uom` VALUES ('77', 'LOAD');
INSERT INTO `uom` VALUES ('78', 'SFT');
INSERT INTO `uom` VALUES ('79', 'Page');
INSERT INTO `uom` VALUES ('80', 'sq/f');
INSERT INTO `uom` VALUES ('81', 'KL');
INSERT INTO `uom` VALUES ('82', 'TRIP');
INSERT INTO `uom` VALUES ('83', 'Feet');
INSERT INTO `uom` VALUES ('84', 'Watts');
INSERT INTO `uom` VALUES ('85', 'SET');
INSERT INTO `uom` VALUES ('86', 'Room');
INSERT INTO `uom` VALUES ('87', 'font');
INSERT INTO `uom` VALUES ('88', 'Bun');
INSERT INTO `uom` VALUES ('89', 'BLUE');
INSERT INTO `uom` VALUES ('90', '/SET');
INSERT INTO `uom` VALUES ('91', 'ACRE');
INSERT INTO `uom` VALUES ('92', 'HP');
INSERT INTO `uom` VALUES ('93', 'sq mm');
INSERT INTO `uom` VALUES ('94', 'Mic');
INSERT INTO `uom` VALUES ('95', 'Coat');
INSERT INTO `uom` VALUES ('96', 'MFD');
INSERT INTO `uom` VALUES ('97', 'VISIT');
INSERT INTO `uom` VALUES ('98', 'YEAR');
INSERT INTO `uom` VALUES ('99', 'Pkt.');
INSERT INTO `uom` VALUES ('100', 'visco');
INSERT INTO `uom` VALUES ('101', 'torq');
INSERT INTO `uom` VALUES ('102', 'HZ');
INSERT INTO `uom` VALUES ('103', 'pH');
INSERT INTO `uom` VALUES ('104', 'Nouni');
INSERT INTO `uom` VALUES ('105', 'lengt');
INSERT INTO `uom` VALUES ('106', '.');
INSERT INTO `uom` VALUES ('107', '.');
INSERT INTO `uom` VALUES ('108', 'Sec');
INSERT INTO `uom` VALUES ('109', 'Newton');

-- ----------------------------
-- Table structure for `villagecustomer`
-- ----------------------------
DROP TABLE IF EXISTS `villagecustomer`;
CREATE TABLE `villagecustomer` (
  `villagePartyId` bigint(20) NOT NULL AUTO_INCREMENT,
  `billRefId` bigint(20) DEFAULT NULL,
  `billType` int(2) DEFAULT NULL,
  `customerName` varchar(200) DEFAULT NULL,
  `customerTown` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`villagePartyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of villagecustomer
-- ----------------------------

-- ----------------------------
-- Table structure for `villagecustomer_copy`
-- ----------------------------
DROP TABLE IF EXISTS `villagecustomer_copy`;
CREATE TABLE `villagecustomer_copy` (
  `villagePartyId` bigint(20) NOT NULL AUTO_INCREMENT,
  `billRefId` bigint(20) DEFAULT NULL,
  `billType` int(2) DEFAULT NULL,
  `customerName` varchar(200) DEFAULT NULL,
  `customerTown` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`villagePartyId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of villagecustomer_copy
-- ----------------------------
