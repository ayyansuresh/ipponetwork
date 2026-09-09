/*
Navicat MySQL Data Transfer

Source Server         : LocalEarms
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : cidambaram

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2017-07-19 12:26:10
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
  PRIMARY KEY  (`accountId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of account
-- ----------------------------
INSERT INTO `account` VALUES ('1', '1', 'Cash In Hand', 'cash', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of accountopeningbalance
-- ----------------------------
INSERT INTO `accountopeningbalance` VALUES ('1', '1', '0', '0', '0', '1', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=1405 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of commodity
-- ----------------------------
INSERT INTO `commodity` VALUES ('1', 'AADADODA ILAI(ADUSI LEAVES)', '1', '1211');
INSERT INTO `commodity` VALUES ('2', 'AALAM PAZHAM', '1', '1211');
INSERT INTO `commodity` VALUES ('3', 'AAVARA ILAI (GOL SENNA)', '1', '1211');
INSERT INTO `commodity` VALUES ('4', 'AAVARA VIDHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('5', 'ADUTHINNA PALAI', '1', '1211');
INSERT INTO `commodity` VALUES ('6', 'ARASA VIDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('7', 'ARASAM PAZHAM', '1', '1211');
INSERT INTO `commodity` VALUES ('8', 'ASWAGANDHA SEEDS', '1', '1211');
INSERT INTO `commodity` VALUES ('9', 'ATHIMADURAM (SPECIAL)', '1', '1211');
INSERT INTO `commodity` VALUES ('10', 'AUVRIKKAI (SENNA PODS)', '1', '1211');
INSERT INTO `commodity` VALUES ('11', 'AVARAMPOO', '1', '1211');
INSERT INTO `commodity` VALUES ('12', 'AVURI LEAVES (No.2)SENNA LEAVE', '1', '1211');
INSERT INTO `commodity` VALUES ('13', 'AVURI LEAVES(No.1)SENNA LEAVES', '1', '1211');
INSERT INTO `commodity` VALUES ('14', 'AVURI VIDHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('15', 'BISHOP WEED', '1', '1211');
INSERT INTO `commodity` VALUES ('16', 'CHAKARAKOLLI(GURMARPATHA)', '1', '1211');
INSERT INTO `commodity` VALUES ('17', 'CHAMAI', '1', '1211');
INSERT INTO `commodity` VALUES ('18', 'CHEVIAM(CHAVAK)', '1', '1211');
INSERT INTO `commodity` VALUES ('19', 'CHIRUTHEKKU', '1', '1211');
INSERT INTO `commodity` VALUES ('20', 'CHITHARATHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('21', 'CHOLAM ', '1', '1104');
INSERT INTO `commodity` VALUES ('22', 'DEVDAR CHIPS', '1', '1211');
INSERT INTO `commodity` VALUES ('23', 'DIKAMALLY', '1', '1211');
INSERT INTO `commodity` VALUES ('24', 'DIL SEEDS', '1', '1211');
INSERT INTO `commodity` VALUES ('25', 'ELANEER PINCI', '1', '1211');
INSERT INTO `commodity` VALUES ('26', 'ELUPPAM POO', '1', '1211');
INSERT INTO `commodity` VALUES ('27', 'GUNNY', '1', '1211');
INSERT INTO `commodity` VALUES ('28', 'KAAKUMARI (ZOOGALI)', '1', '1211');
INSERT INTO `commodity` VALUES ('29', 'KADUKKAI', '1', '1211');
INSERT INTO `commodity` VALUES ('30', 'KADUKKAI THODU', '1', '1211');
INSERT INTO `commodity` VALUES ('31', 'KALAPAI KILANGU (GLORIA SUPERB', '1', '1211');
INSERT INTO `commodity` VALUES ('32', 'KALICHIKAI(SAGAR KOTTA)', '1', '1211');
INSERT INTO `commodity` VALUES ('33', 'KALPASAM (STONE MASS)', '1', '1211');
INSERT INTO `commodity` VALUES ('34', 'KANDANGATHIRI', '1', '1211');
INSERT INTO `commodity` VALUES ('35', 'KANDANGATHIRI (No.1)', '1', '1211');
INSERT INTO `commodity` VALUES ('36', 'KANNUPULAI(CHIRUPULAI)', '1', '1211');
INSERT INTO `commodity` VALUES ('37', 'KARBOGARISI(BAVANCHI)', '1', '1211');
INSERT INTO `commodity` VALUES ('38', 'KARISLANGANI(BRINGRAJ)', '1', '1211');
INSERT INTO `commodity` VALUES ('39', 'KARUDA KILANGU', '1', '1211');
INSERT INTO `commodity` VALUES ('40', 'KARUDA KODI VEER(ESWARI MOOL)', '1', '1211');
INSERT INTO `commodity` VALUES ('41', 'KARUDAKODI VER (No.2)', '1', '1211');
INSERT INTO `commodity` VALUES ('42', 'KARUPPU VETIVAER(GURU VEER)', '1', '1211');
INSERT INTO `commodity` VALUES ('43', 'KASTURI MANJAL (AMBA HALDI)', '1', '1211');
INSERT INTO `commodity` VALUES ('44', 'KASTURI METHI(DRY VEGETABLES)', '1', '1211');
INSERT INTO `commodity` VALUES ('45', 'KATHALAI VATHOL(ALOE VERA)', '1', '1211');
INSERT INTO `commodity` VALUES ('46', 'KATHIRI VEER', '1', '1211');
INSERT INTO `commodity` VALUES ('47', 'KAMBU', '1', '1211');
INSERT INTO `commodity` VALUES ('48', 'KEEVANELLY(NO.1 BOOMI AMLA)', '1', '1211');
INSERT INTO `commodity` VALUES ('49', 'KODIVELLI (CHITRAKMOOL)', '1', '1211');
INSERT INTO `commodity` VALUES ('50', 'KOLINJI ILAI (SARPUNGA)', '1', '1211');
INSERT INTO `commodity` VALUES ('51', 'KONNAKKAI  VIDHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('52', 'KORAI KILANGU(NAGARMOOTHA)', '1', '1211');
INSERT INTO `commodity` VALUES ('53', 'KOYYA KAI', '1', '1211');
INSERT INTO `commodity` VALUES ('54', 'KEPPAI', '1', '1104');
INSERT INTO `commodity` VALUES ('55', 'KUMUTI VATHOL (INDRIN PHAL)', '1', '1211');
INSERT INTO `commodity` VALUES ('56', 'KUNDUMANI (No.1)', '1', '1211');
INSERT INTO `commodity` VALUES ('57', 'KUNDUMANI(LAL GUNJ)', '1', '1211');
INSERT INTO `commodity` VALUES ('58', 'KUPPAIMENI', '1', '1211');
INSERT INTO `commodity` VALUES ('59', 'KURINJAN THANDU', '1', '1211');
INSERT INTO `commodity` VALUES ('60', 'KUVAPUL VIDHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('61', 'KUTHIRAIVALI', '1', '1104');
INSERT INTO `commodity` VALUES ('62', 'MAHALI (ANANTMOOL)', '1', '1211');
INSERT INTO `commodity` VALUES ('63', 'MAHALINGA PATTAI(VARUN CHALL)', '1', '1211');
INSERT INTO `commodity` VALUES ('64', 'MAHILAM POO', '1', '1211');
INSERT INTO `commodity` VALUES ('65', 'MALANKARAIKAI', '1', '1211');
INSERT INTO `commodity` VALUES ('66', 'MANATHAKALI VATHOL', '1', '1211');
INSERT INTO `commodity` VALUES ('67', 'MARAMANJAL (DHADU HALDI)', '1', '1211');
INSERT INTO `commodity` VALUES ('68', 'MARATI MOGGU', '1', '1211');
INSERT INTO `commodity` VALUES ('69', 'MARATTI MOGGU (No.1)', '1', '1211');
INSERT INTO `commodity` VALUES ('70', 'MARIKOLUNTHU(MOGGI POO)Dhavana', '1', '1211');
INSERT INTO `commodity` VALUES ('71', 'MARUTHAN KAI', '1', '1211');
INSERT INTO `commodity` VALUES ('72', 'MARUTHANI VIDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('73', 'MARUVU', '1', '1211');
INSERT INTO `commodity` VALUES ('74', 'MATHULAI ODU', '1', '1211');
INSERT INTO `commodity` VALUES ('75', 'MEEVANELLY(BOOMI AMLA)', '1', '1211');
INSERT INTO `commodity` VALUES ('76', 'MINI APPLE', '1', '1211');
INSERT INTO `commodity` VALUES ('77', 'MOKANAI SARANAIVER(WHITE PUNAR', '1', '1211');
INSERT INTO `commodity` VALUES ('78', 'MURUKKAM POO', '1', '1211');
INSERT INTO `commodity` VALUES ('79', 'MURUNGA BISIN', '1', '1211');
INSERT INTO `commodity` VALUES ('80', 'MURUNGA PATTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('81', 'MURUNGA VIDHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('82', 'MURUNGAI POO', '1', '1211');
INSERT INTO `commodity` VALUES ('83', 'NAIYURVI CHEDI(KADALADI)', '1', '1211');
INSERT INTO `commodity` VALUES ('84', 'NAKADUGU (KURASANI AJWAN)', '1', '1211');
INSERT INTO `commodity` VALUES ('85', 'NAKKOTTAN PAZHAM', '1', '1211');
INSERT INTO `commodity` VALUES ('86', 'NANMUGAPUL (MAYIL CHIKKI)', '1', '1211');
INSERT INTO `commodity` VALUES ('87', 'NATHA SOORI CHEDI', '1', '1211');
INSERT INTO `commodity` VALUES ('88', 'NAVA PATTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('89', 'NERUNJIL (GOKKRU)', '1', '1211');
INSERT INTO `commodity` VALUES ('90', 'NERVALAM (JAMAL KOTTA)', '1', '1211');
INSERT INTO `commodity` VALUES ('91', 'NETTILINGA VIDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('92', 'NILAPANAI(KALI MUSLI)', '1', '1211');
INSERT INTO `commodity` VALUES ('93', 'NILAVAGAI', '1', '1211');
INSERT INTO `commodity` VALUES ('94', 'NILAVEMBU', '1', '1211');
INSERT INTO `commodity` VALUES ('95', 'NOONA (MANJANATHI PALAM)Morind', '1', '1211');
INSERT INTO `commodity` VALUES ('96', 'ORITHAL THAMARAI(RATAN FRUSH)', '1', '1211');
INSERT INTO `commodity` VALUES ('97', 'PACHILAI (DESI PANNADI)', '1', '1211');
INSERT INTO `commodity` VALUES ('98', 'PADAVALAM (No.2)', '1', '1211');
INSERT INTO `commodity` VALUES ('99', 'PALATTAM KULAI', '1', '1211');
INSERT INTO `commodity` VALUES ('100', 'PAPADAPUL', '1', '1211');
INSERT INTO `commodity` VALUES ('101', 'PAPAYA LEAVES', '1', '1211');
INSERT INTO `commodity` VALUES ('102', 'PAVAKAI VATHOL(KARILA', '1', '1211');
INSERT INTO `commodity` VALUES ('103', 'PEI INJAM (BIDARI GAND)', '1', '1211');
INSERT INTO `commodity` VALUES ('104', 'PEI INJAM POO', '1', '1211');
INSERT INTO `commodity` VALUES ('105', 'PIRANDAI (HARJOR)', '1', '1211');
INSERT INTO `commodity` VALUES ('106', 'PIRINCHI ILAI', '1', '1211');
INSERT INTO `commodity` VALUES ('107', 'PONKURANDI (KADALURINCHI)', '1', '1211');
INSERT INTO `commodity` VALUES ('108', 'POOLANKILANGU ( KACHUR)', '1', '1211');
INSERT INTO `commodity` VALUES ('109', 'PULIYAM PATTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('110', 'PUNAI KALI VIDHAI', '1', '1211');
INSERT INTO `commodity` VALUES ('111', 'PUNAI KALI VIDHAI(WHITE)', '1', '1211');
INSERT INTO `commodity` VALUES ('112', 'PUNAIKALI VIDHAI(SMALL)', '1', '1211');
INSERT INTO `commodity` VALUES ('113', 'PUNGAM POO', '1', '1211');
INSERT INTO `commodity` VALUES ('114', 'RED PEI ENJAM', '1', '1211');
INSERT INTO `commodity` VALUES ('115', 'RETHA POOTHALI PATTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('116', 'ROJAPOO', '1', '1211');
INSERT INTO `commodity` VALUES ('117', 'SABJA', '1', '1211');
INSERT INTO `commodity` VALUES ('118', 'SANAPPA VEDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('119', 'SARANAI VEER(PUNARNOVAMOOL)', '1', '1211');
INSERT INTO `commodity` VALUES ('120', 'SAURIKODI (PIRASARNI)(CHANDVEL', '1', '1211');
INSERT INTO `commodity` VALUES ('121', 'SAVUKKU VIDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('122', 'SEA-SHELL', '1', '1211');
INSERT INTO `commodity` VALUES ('123', 'SEA-SHELL (CHIPS)', '1', '1211');
INSERT INTO `commodity` VALUES ('124', 'SEENTHAL KODI', '1', '1211');
INSERT INTO `commodity` VALUES ('125', 'SEETHA KAI', '1', '1211');
INSERT INTO `commodity` VALUES ('126', 'SEMBARUTHI POO', '1', '1211');
INSERT INTO `commodity` VALUES ('127', 'SERAN KOTTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('128', 'SHEKAI', '1', '1211');
INSERT INTO `commodity` VALUES ('129', 'SOAPNUT', '1', '1211');
INSERT INTO `commodity` VALUES ('130', 'SONAGAPUL', '1', '1211');
INSERT INTO `commodity` VALUES ('131', 'STAR SEEDS', '1', '1211');
INSERT INTO `commodity` VALUES ('132', 'SAMMAI', '1', '1104');
INSERT INTO `commodity` VALUES ('133', 'SINNAPU VIDHAI', '1', '1104');
INSERT INTO `commodity` VALUES ('134', 'THADARI POO', '1', '1211');
INSERT INTO `commodity` VALUES ('135', 'THAEL KOTIMUL (KAKANAS)', '1', '1211');
INSERT INTO `commodity` VALUES ('136', 'THALISPATHRI', '1', '1211');
INSERT INTO `commodity` VALUES ('137', 'THAMARAI KOTTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('138', 'THANIKKAI', '1', '1211');
INSERT INTO `commodity` VALUES ('139', 'THEKKU VIDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('140', 'THINAI', '1', '1104');
INSERT INTO `commodity` VALUES ('141', 'THOODU VALAI', '1', '1211');
INSERT INTO `commodity` VALUES ('142', 'THOTTA SINUNGI', '1', '1211');
INSERT INTO `commodity` VALUES ('143', 'TRIFLA', '1', '1211');
INSERT INTO `commodity` VALUES ('144', 'TULSI LEAVES', '1', '1211');
INSERT INTO `commodity` VALUES ('145', 'ULAVA VEDAI', '1', '1211');
INSERT INTO `commodity` VALUES ('146', 'UMATA VEDAI(DHATURA BEEJ)', '1', '1211');
INSERT INTO `commodity` VALUES ('147', 'USILAI ILAI', '1', '1211');
INSERT INTO `commodity` VALUES ('148', 'VAEPILAI (NEEM LEAVES)', '1', '1211');
INSERT INTO `commodity` VALUES ('149', 'VALAMPURI', '1', '1211');
INSERT INTO `commodity` VALUES ('150', 'VALLARAI ( BIRAMI)', '1', '1211');
INSERT INTO `commodity` VALUES ('151', 'VARAGU', '1', '1104');
INSERT INTO `commodity` VALUES ('152', 'VASAMBU (GODAWACH)', '1', '1211');
INSERT INTO `commodity` VALUES ('153', 'VEEPAM POO', '1', '1211');
INSERT INTO `commodity` VALUES ('154', 'VELLARAGU (NAIPHUTI)', '1', '1211');
INSERT INTO `commodity` VALUES ('155', 'VEMPADAM PATTAI', '1', '1211');
INSERT INTO `commodity` VALUES ('156', 'VETTYVEER (KHUS KHUS)', '1', '1211');
INSERT INTO `commodity` VALUES ('157', 'VILVA LEAVES', '1', '1211');
INSERT INTO `commodity` VALUES ('158', 'VILVAKAI', '1', '1211');
INSERT INTO `commodity` VALUES ('159', 'VISHNU KIRANTHI(SANGUPUSHBI)', '1', '1211');
INSERT INTO `commodity` VALUES ('160', 'YALLI SEEDS', '1', '1211');
INSERT INTO `commodity` VALUES ('161', 'YANAI KALICHIKAI', '1', '1211');
INSERT INTO `commodity` VALUES ('162', 'YANAI NERUNJIL (BADA GOKKRU)', '1', '1211');

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
INSERT INTO `company` VALUES ('1', 'A.S.Chindambaram & Co', '');

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
INSERT INTO `companyaddress` VALUES ('1', '1', '69 A,Ramachandran Street', null, '1', '31', '28', '626001', '', null, null, null, '1');

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
  UNIQUE KEY `customerGSTNumber` USING BTREE (`gstNumber`),
  KEY `customerCompanyRefId` (`companyRefId`),
  KEY `customerCreatedBy` (`createdBy`),
  KEY `customerGstTypeRefId` (`partyGstType`),
  KEY `customerTypeRefId` (`cutomerType`),
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
INSERT INTO `customertype` VALUES ('3', 'Both Sales and Purchase');

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
  `hsnCode` varchar(20) NOT NULL default '0',
  `hsnType` int(1) default '1',
  `description` text NOT NULL,
  `cgstRate` double NOT NULL,
  `sgstRate` double NOT NULL,
  `igstRate` double NOT NULL,
  `activeFlag` int(1) default NULL,
  PRIMARY KEY  (`hsnCode`),
  KEY `gstHSNTypeRef` (`hsnType`),
  CONSTRAINT `gsthsncode_ibfk_1` FOREIGN KEY (`hsnType`) REFERENCES `gsttype` (`gstTypeId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gsthsncode
-- ----------------------------
INSERT INTO `gsthsncode` VALUES ('1104', '1', 'Cereal grains otherwise worked (for example, rolled, flaked, pearled, sliced or kibbled), except rice of heading 1006; germ of cereals, whole, rolled, flaked or ground [other than hulled cereal grains]', '2.5', '2.5', '5', '1');
INSERT INTO `gsthsncode` VALUES ('1211', '1', 'Plants and parts of plants (including seeds and fruits), of a kind used primarily in perfumery, in pharmacy or for insecticidal, fungicidal or similar purpose, frozen or dried, whether or not cut, crushed or powdered', '2.5', '2.5', '5', '1');

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
INSERT INTO `gsttype` VALUES ('1', 'product');
INSERT INTO `gsttype` VALUES ('2', 'service');

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
  `commodityRefId` varchar(20) default NULL,
  `Description` varchar(200) default NULL,
  `Discount` double default NULL,
  `companyRefId` bigint(20) NOT NULL,
  `createdBy` bigint(20) NOT NULL,
  `updatedTimeStamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `updatedBy` bigint(20) NOT NULL,
  `createdTimeStamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `activeFlag` int(2) default NULL,
  PRIMARY KEY  (`ItemId`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COMMENT='Items Details';

-- ----------------------------
-- Records of items
-- ----------------------------
INSERT INTO `items` VALUES ('1', 'AADADODA ILAI(ADUSI LEAVES)', '1', '1', '0', '1', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('2', 'AALAM PAZHAM', '1', '1', '0', '2', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('3', 'AAVARA ILAI (GOL SENNA)', '1', '1', '0', '3', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('4', 'AAVARA VIDHAI', '1', '1', '0', '4', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('5', 'ADUTHINNA PALAI', '1', '1', '0', '5', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('6', 'ARASA VIDAI', '1', '1', '0', '6', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('7', 'ARASAM PAZHAM', '1', '1', '0', '7', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('8', 'ASWAGANDHA SEEDS', '1', '1', '0', '8', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('9', 'ATHIMADURAM (SPECIAL)', '1', '1', '0', '9', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('10', 'AUVRIKKAI (SENNA PODS)', '1', '1', '0', '10', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('11', 'AVARAMPOO', '1', '1', '0', '11', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('12', 'AVURI LEAVES (No.2)SENNA LEAVE', '1', '1', '0', '12', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('13', 'AVURI LEAVES(No.1)SENNA LEAVES', '1', '1', '0', '13', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('14', 'AVURI VIDHAI', '1', '1', '0', '14', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('15', 'BISHOP WEED', '1', '1', '0', '15', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('16', 'CHAKARAKOLLI(GURMARPATHA)', '1', '1', '0', '16', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('17', 'CHAMAI', '1', '1', '0', '17', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('18', 'CHEVIAM(CHAVAK)', '1', '1', '0', '18', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('19', 'CHIRUTHEKKU', '1', '1', '0', '19', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('20', 'CHITHARATHAI', '1', '1', '0', '20', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('21', 'CHOLAM ', '1', '1', '0', '21', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('22', 'DEVDAR CHIPS', '1', '1', '0', '22', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('23', 'DIKAMALLY', '1', '1', '0', '23', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('24', 'DIL SEEDS', '1', '1', '0', '24', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('25', 'ELANEER PINCI', '1', '1', '0', '25', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('26', 'ELUPPAM POO', '1', '1', '0', '26', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('27', 'GUNNY', '1', '1', '0', '27', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('28', 'KAAKUMARI (ZOOGALI)', '1', '1', '0', '28', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('29', 'KADUKKAI', '1', '1', '0', '29', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('30', 'KADUKKAI THODU', '1', '1', '0', '30', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('31', 'KALAPAI KILANGU (GLORIA SUPERB', '1', '1', '0', '31', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('32', 'KALICHIKAI(SAGAR KOTTA)', '1', '1', '0', '32', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('33', 'KALPASAM (STONE MASS)', '1', '1', '0', '33', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('34', 'KANDANGATHIRI', '1', '1', '0', '34', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('35', 'KANDANGATHIRI (No.1)', '1', '1', '0', '35', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('36', 'KANNUPULAI(CHIRUPULAI)', '1', '1', '0', '36', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('37', 'KARBOGARISI(BAVANCHI)', '1', '1', '0', '37', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('38', 'KARISLANGANI(BRINGRAJ)', '1', '1', '0', '38', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('39', 'KARUDA KILANGU', '1', '1', '0', '39', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('40', 'KARUDA KODI VEER(ESWARI MOOL)', '1', '1', '0', '40', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('41', 'KARUDAKODI VER (No.2)', '1', '1', '0', '41', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('42', 'KARUPPU VETIVAER(GURU VEER)', '1', '1', '0', '42', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('43', 'KASTURI MANJAL (AMBA HALDI)', '1', '1', '0', '43', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('44', 'KASTURI METHI(DRY VEGETABLES)', '1', '1', '0', '44', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('45', 'KATHALAI VATHOL(ALOE VERA)', '1', '1', '0', '45', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('46', 'KATHIRI VEER', '1', '1', '0', '46', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('47', 'KAMBU', '1', '1', '0', '47', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('48', 'KEEVANELLY(NO.1 BOOMI AMLA)', '1', '1', '0', '48', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('49', 'KODIVELLI (CHITRAKMOOL)', '1', '1', '0', '49', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('50', 'KOLINJI ILAI (SARPUNGA)', '1', '1', '0', '50', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('51', 'KONNAKKAI  VIDHAI', '1', '1', '0', '51', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('52', 'KORAI KILANGU(NAGARMOOTHA)', '1', '1', '0', '52', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('53', 'KOYYA KAI', '1', '1', '0', '53', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('54', 'KEPPAI', '1', '1', '0', '54', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('55', 'KUMUTI VATHOL (INDRIN PHAL)', '1', '1', '0', '55', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('56', 'KUNDUMANI (No.1)', '1', '1', '0', '56', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('57', 'KUNDUMANI(LAL GUNJ)', '1', '1', '0', '57', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('58', 'KUPPAIMENI', '1', '1', '0', '58', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('59', 'KURINJAN THANDU', '1', '1', '0', '59', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('60', 'KUVAPUL VIDHAI', '1', '1', '0', '60', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('61', 'KUTHIRAIVALI', '1', '1', '0', '61', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('62', 'MAHALI (ANANTMOOL)', '1', '1', '0', '62', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('63', 'MAHALINGA PATTAI(VARUN CHALL)', '1', '1', '0', '63', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('64', 'MAHILAM POO', '1', '1', '0', '64', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('65', 'MALANKARAIKAI', '1', '1', '0', '65', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('66', 'MANATHAKALI VATHOL', '1', '1', '0', '66', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('67', 'MARAMANJAL (DHADU HALDI)', '1', '1', '0', '67', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('68', 'MARATI MOGGU', '1', '1', '0', '68', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('69', 'MARATTI MOGGU (No.1)', '1', '1', '0', '69', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('70', 'MARIKOLUNTHU(MOGGI POO)Dhavana', '1', '1', '0', '70', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('71', 'MARUTHAN KAI', '1', '1', '0', '71', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('72', 'MARUTHANI VIDAI', '1', '1', '0', '72', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('73', 'MARUVU', '1', '1', '0', '73', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('74', 'MATHULAI ODU', '1', '1', '0', '74', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('75', 'MEEVANELLY(BOOMI AMLA)', '1', '1', '0', '75', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('76', 'MINI APPLE', '1', '1', '0', '76', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('77', 'MOKANAI SARANAIVER(WHITE PUNAR', '1', '1', '0', '77', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('78', 'MURUKKAM POO', '1', '1', '0', '78', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('79', 'MURUNGA BISIN', '1', '1', '0', '79', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('80', 'MURUNGA PATTAI', '1', '1', '0', '80', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('81', 'MURUNGA VIDHAI', '1', '1', '0', '81', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('82', 'MURUNGAI POO', '1', '1', '0', '82', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('83', 'NAIYURVI CHEDI(KADALADI)', '1', '1', '0', '83', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('84', 'NAKADUGU (KURASANI AJWAN)', '1', '1', '0', '84', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('85', 'NAKKOTTAN PAZHAM', '1', '1', '0', '85', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('86', 'NANMUGAPUL (MAYIL CHIKKI)', '1', '1', '0', '86', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('87', 'NATHA SOORI CHEDI', '1', '1', '0', '87', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('88', 'NAVA PATTAI', '1', '1', '0', '88', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('89', 'NERUNJIL (GOKKRU)', '1', '1', '0', '89', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('90', 'NERVALAM (JAMAL KOTTA)', '1', '1', '0', '90', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('91', 'NETTILINGA VIDAI', '1', '1', '0', '91', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('92', 'NILAPANAI(KALI MUSLI)', '1', '1', '0', '92', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('93', 'NILAVAGAI', '1', '1', '0', '93', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('94', 'NILAVEMBU', '1', '1', '0', '94', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('95', 'NOONA (MANJANATHI PALAM)Morind', '1', '1', '0', '95', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('96', 'ORITHAL THAMARAI(RATAN FRUSH)', '1', '1', '0', '96', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('97', 'PACHILAI (DESI PANNADI)', '1', '1', '0', '97', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('98', 'PADAVALAM (No.2)', '1', '1', '0', '98', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('99', 'PALATTAM KULAI', '1', '1', '0', '99', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('100', 'PAPADAPUL', '1', '1', '0', '100', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('101', 'PAPAYA LEAVES', '1', '1', '0', '101', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('102', 'PAVAKAI VATHOL(KARILA', '1', '1', '0', '102', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('103', 'PEI INJAM (BIDARI GAND)', '1', '1', '0', '103', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('104', 'PEI INJAM POO', '1', '1', '0', '104', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('105', 'PIRANDAI (HARJOR)', '1', '1', '0', '105', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('106', 'PIRINCHI ILAI', '1', '1', '0', '106', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('107', 'PONKURANDI (KADALURINCHI)', '1', '1', '0', '107', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('108', 'POOLANKILANGU ( KACHUR)', '1', '1', '0', '108', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('109', 'PULIYAM PATTAI', '1', '1', '0', '109', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('110', 'PUNAI KALI VIDHAI', '1', '1', '0', '110', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('111', 'PUNAI KALI VIDHAI(WHITE)', '1', '1', '0', '111', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('112', 'PUNAIKALI VIDHAI(SMALL)', '1', '1', '0', '112', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('113', 'PUNGAM POO', '1', '1', '0', '113', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('114', 'RED PEI ENJAM', '1', '1', '0', '114', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('115', 'RETHA POOTHALI PATTAI', '1', '1', '0', '115', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('116', 'ROJAPOO', '1', '1', '0', '116', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('117', 'SABJA', '1', '1', '0', '117', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('118', 'SANAPPA VEDAI', '1', '1', '0', '118', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('119', 'SARANAI VEER(PUNARNOVAMOOL)', '1', '1', '0', '119', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('120', 'SAURIKODI (PIRASARNI)(CHANDVEL', '1', '1', '0', '120', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('121', 'SAVUKKU VIDAI', '1', '1', '0', '121', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('122', 'SEA-SHELL', '1', '1', '0', '122', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('123', 'SEA-SHELL (CHIPS)', '1', '1', '0', '123', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('124', 'SEENTHAL KODI', '1', '1', '0', '124', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('125', 'SEETHA KAI', '1', '1', '0', '125', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('126', 'SEMBARUTHI POO', '1', '1', '0', '126', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('127', 'SERAN KOTTAI', '1', '1', '0', '127', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('128', 'SHEKAI', '1', '1', '0', '128', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('129', 'SOAPNUT', '1', '1', '0', '129', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('130', 'SONAGAPUL', '1', '1', '0', '130', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('131', 'STAR SEEDS', '1', '1', '0', '131', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('132', 'SAMMAI', '1', '1', '0', '132', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('133', 'SINNAPU VIDHAI', '1', '1', '0', '133', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('134', 'THADARI POO', '1', '1', '0', '134', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('135', 'THAEL KOTIMUL (KAKANAS)', '1', '1', '0', '135', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('136', 'THALISPATHRI', '1', '1', '0', '136', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('137', 'THAMARAI KOTTAI', '1', '1', '0', '137', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('138', 'THANIKKAI', '1', '1', '0', '138', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('139', 'THEKKU VIDAI', '1', '1', '0', '139', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('140', 'THINAI', '1', '1', '0', '140', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('141', 'THOODU VALAI', '1', '1', '0', '141', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('142', 'THOTTA SINUNGI', '1', '1', '0', '142', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('143', 'TRIFLA', '1', '1', '0', '143', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('144', 'TULSI LEAVES', '1', '1', '0', '144', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('145', 'ULAVA VEDAI', '1', '1', '0', '145', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('146', 'UMATA VEDAI(DHATURA BEEJ)', '1', '1', '0', '146', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('147', 'USILAI ILAI', '1', '1', '0', '147', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('148', 'VAEPILAI (NEEM LEAVES)', '1', '1', '0', '148', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('149', 'VALAMPURI', '1', '1', '0', '149', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('150', 'VALLARAI ( BIRAMI)', '1', '1', '0', '150', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('151', 'VARAGU', '1', '1', '0', '151', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('152', 'VASAMBU (GODAWACH)', '1', '1', '0', '152', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('153', 'VEEPAM POO', '1', '1', '0', '153', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('154', 'VELLARAGU (NAIPHUTI)', '1', '1', '0', '154', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('155', 'VEMPADAM PATTAI', '1', '1', '0', '155', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('156', 'VETTYVEER (KHUS KHUS)', '1', '1', '0', '156', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('157', 'VILVA LEAVES', '1', '1', '0', '157', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('158', 'VILVAKAI', '1', '1', '0', '158', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('159', 'VISHNU KIRANTHI(SANGUPUSHBI)', '1', '1', '0', '159', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('160', 'YALLI SEEDS', '1', '1', '0', '160', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('161', 'YANAI KALICHIKAI', '1', '1', '0', '161', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `items` VALUES ('162', 'YANAI NERUNJIL (BADA GOKKRU)', '1', '1', '0', '162', '', '0', '1', '0', '2017-07-19 12:15:03', '0', '0000-00-00 00:00:00', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('1', 'admin', 'admin', '1', '1', null, '2017-07-19 11:56:10', '1', '1');

-- ----------------------------
-- Table structure for `modeofpayment`
-- ----------------------------
DROP TABLE IF EXISTS `modeofpayment`;
CREATE TABLE `modeofpayment` (
  `modeId` int(2) NOT NULL auto_increment,
  `modeName` varchar(200) default NULL,
  PRIMARY KEY  (`modeId`)
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
  PRIMARY KEY  (`commodityStockId`)
) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of openingstock
-- ----------------------------
INSERT INTO `openingstock` VALUES ('1', '1', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('2', '2', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('3', '3', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('4', '4', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('5', '5', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('6', '6', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('7', '7', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('8', '8', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('9', '9', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('10', '10', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('11', '11', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('12', '12', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('13', '13', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('14', '14', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('15', '15', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('16', '16', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('17', '17', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('18', '18', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('19', '19', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('20', '20', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('21', '21', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('22', '22', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('23', '23', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('24', '24', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('25', '25', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('26', '26', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('27', '27', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('28', '28', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('29', '29', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('30', '30', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('31', '31', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('32', '32', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('33', '33', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('34', '34', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('35', '35', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('36', '36', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('37', '37', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('38', '38', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('39', '39', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('40', '40', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('41', '41', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('42', '42', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('43', '43', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('44', '44', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('45', '45', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('46', '46', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('47', '47', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('48', '48', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('49', '49', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('50', '50', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('51', '51', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('52', '52', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('53', '53', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('54', '54', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('55', '55', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('56', '56', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('57', '57', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('58', '58', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('59', '59', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('60', '60', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('61', '61', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('62', '62', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('63', '63', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('64', '64', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('65', '65', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('66', '66', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('67', '67', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('68', '68', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('69', '69', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('70', '70', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('71', '71', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('72', '72', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('73', '73', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('74', '74', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('75', '75', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('76', '76', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('77', '77', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('78', '78', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('79', '79', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('80', '80', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('81', '81', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('82', '82', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('83', '83', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('84', '84', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('85', '85', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('86', '86', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('87', '87', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('88', '88', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('89', '89', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('90', '90', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('91', '91', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('92', '92', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('93', '93', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('94', '94', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('95', '95', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('96', '96', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('97', '97', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('98', '98', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('99', '99', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('100', '100', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('101', '101', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('102', '102', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('103', '103', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('104', '104', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('105', '105', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('106', '106', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('107', '107', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('108', '108', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('109', '109', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('110', '110', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('111', '111', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('112', '112', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('113', '113', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('114', '114', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('115', '115', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('116', '116', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('117', '117', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('118', '118', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('119', '119', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('120', '120', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('121', '121', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('122', '122', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('123', '123', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('124', '124', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('125', '125', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('126', '126', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('127', '127', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('128', '128', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('129', '129', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('130', '130', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('131', '131', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('132', '132', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('133', '133', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('134', '134', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('135', '135', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('136', '136', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('137', '137', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('138', '138', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('139', '139', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('140', '140', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('141', '141', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('142', '142', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('143', '143', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('144', '144', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('145', '145', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('146', '146', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('147', '147', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('148', '148', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('149', '149', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('150', '150', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('151', '151', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('152', '152', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('153', '153', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('154', '154', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('155', '155', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('156', '156', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('157', '157', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('158', '158', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('159', '159', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('160', '160', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('161', '161', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('162', '162', '1', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('163', '1', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('164', '2', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('165', '3', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('166', '4', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('167', '5', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('168', '6', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('169', '7', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('170', '8', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('171', '9', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('172', '10', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('173', '11', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('174', '12', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('175', '13', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('176', '14', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('177', '15', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('178', '16', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('179', '17', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('180', '18', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('181', '19', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('182', '20', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('183', '21', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('184', '22', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('185', '23', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('186', '24', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('187', '25', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('188', '26', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('189', '27', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('190', '28', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('191', '29', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('192', '30', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('193', '31', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('194', '32', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('195', '33', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('196', '34', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('197', '35', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('198', '36', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('199', '37', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('200', '38', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('201', '39', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('202', '40', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('203', '41', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('204', '42', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('205', '43', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('206', '44', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('207', '45', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('208', '46', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('209', '47', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('210', '48', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('211', '49', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('212', '50', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('213', '51', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('214', '52', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('215', '53', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('216', '54', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('217', '55', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('218', '56', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('219', '57', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('220', '58', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('221', '59', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('222', '60', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('223', '61', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('224', '62', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('225', '63', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('226', '64', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('227', '65', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('228', '66', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('229', '67', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('230', '68', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('231', '69', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('232', '70', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('233', '71', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('234', '72', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('235', '73', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('236', '74', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('237', '75', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('238', '76', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('239', '77', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('240', '78', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('241', '79', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('242', '80', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('243', '81', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('244', '82', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('245', '83', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('246', '84', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('247', '85', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('248', '86', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('249', '87', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('250', '88', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('251', '89', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('252', '90', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('253', '91', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('254', '92', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('255', '93', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('256', '94', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('257', '95', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('258', '96', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('259', '97', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('260', '98', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('261', '99', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('262', '100', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('263', '101', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('264', '102', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('265', '103', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('266', '104', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('267', '105', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('268', '106', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('269', '107', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('270', '108', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('271', '109', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('272', '110', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('273', '111', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('274', '112', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('275', '113', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('276', '114', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('277', '115', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('278', '116', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('279', '117', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('280', '118', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('281', '119', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('282', '120', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('283', '121', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('284', '122', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('285', '123', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('286', '124', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('287', '125', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('288', '126', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('289', '127', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('290', '128', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('291', '129', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('292', '130', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('293', '131', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('294', '132', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('295', '133', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('296', '134', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('297', '135', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('298', '136', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('299', '137', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('300', '138', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('301', '139', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('302', '140', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('303', '141', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('304', '142', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('305', '143', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('306', '144', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('307', '145', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('308', '146', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('309', '147', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('310', '148', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('311', '149', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('312', '150', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('313', '151', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('314', '152', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('315', '153', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('316', '154', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('317', '155', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('318', '156', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('319', '157', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('320', '158', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('321', '159', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('322', '160', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('323', '161', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');
INSERT INTO `openingstock` VALUES ('324', '162', '2', '1', '1', null, null, '0', '0', '0', '0', '0000-00-00 00:00:00');

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
INSERT INTO `salesbillprefix` VALUES ('1', '1', '1', 'ASC/17-18/', '4', '1');
INSERT INTO `salesbillprefix` VALUES ('2', '1', '1', 'ASC/I/17-18/', '4', '2');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tablereference
-- ----------------------------
INSERT INTO `tablereference` VALUES ('1', 'salesbill');
INSERT INTO `tablereference` VALUES ('2', 'salesbillitem');

-- ----------------------------
-- Table structure for `uom`
-- ----------------------------
DROP TABLE IF EXISTS `uom`;
CREATE TABLE `uom` (
  `id` int(10) NOT NULL auto_increment,
  `name` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`)
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
