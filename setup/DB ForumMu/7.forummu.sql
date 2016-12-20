-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 04:37 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forummu`
--

-- --------------------------------------------------------

--
-- Table structure for table `postparsed`
--

CREATE TABLE `postparsed` (
  `postid` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `styleid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `languageid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hasimages` smallint(6) NOT NULL DEFAULT '0',
  `pagetext_html` mediumtext,
  PRIMARY KEY (`postid`,`styleid`,`languageid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `postrelease`
--

CREATE TABLE `postrelease` (
  `secretkey` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postrelease`
--

INSERT INTO `postrelease` (`secretkey`) VALUES
('ycPd0impjU');

-- --------------------------------------------------------

--
-- Table structure for table `post_thanks`
--

CREATE TABLE `post_thanks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `date` int(10) NOT NULL,
  `postid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postid` (`postid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `post_thanks`
--

INSERT INTO `post_thanks` (`id`, `userid`, `username`, `date`, `postid`) VALUES
(2, 4, 'KangTa', 1402329662, 31),
(4, 4, 'KangTa', 1403842835, 48),
(5, 4, 'KangTa', 1403951311, 47),
(6, 4, 'KangTa', 1403951340, 64),
(8, 8, 'GameMaster', 1403954016, 64),
(11, 4, 'KangTa', 1404011007, 70),
(12, 18, 'kingfirer1', 1404036772, 81),
(13, 23, 'phanbinh_1990', 1404108512, 74),
(15, 8, 'GameMaster', 1404108855, 102),
(16, 8, 'GameMaster', 1404108859, 99),
(17, 8, 'GameMaster', 1404109348, 103),
(18, 18, 'kingfirer1', 1404115366, 110),
(19, 8, 'GameMaster', 1404139838, 115),
(20, 8, 'GameMaster', 1404140768, 79),
(21, 18, 'kingfirer1', 1404148289, 114),
(22, 18, 'kingfirer1', 1404198239, 125),
(23, 4, 'KangTa', 1404199561, 125),
(24, 8, 'GameMaster', 1404261204, 138),
(25, 8, 'GameMaster', 1404261205, 128),
(26, 8, 'GameMaster', 1404261208, 127),
(27, 18, 'kingfirer1', 1404322270, 154),
(28, 4, 'KangTa', 1404403672, 185),
(29, 18, 'kingfirer1', 1404577095, 217),
(30, 18, 'kingfirer1', 1404577188, 214),
(31, 18, 'kingfirer1', 1404630211, 224),
(32, 18, 'kingfirer1', 1404639376, 226),
(33, 4, 'KangTa', 1404700175, 259),
(34, 4, 'KangTa', 1404700178, 256),
(35, 36, 'tramsociu', 1404706363, 260),
(36, 18, 'kingfirer1', 1404709352, 260),
(37, 18, 'kingfirer1', 1404727076, 295),
(38, 4, 'KangTa', 1404727391, 297),
(39, 4, 'KangTa', 1404727393, 296),
(40, 18, 'kingfirer1', 1404795022, 350),
(41, 18, 'kingfirer1', 1404814338, 367),
(42, 4, 'KangTa', 1404829946, 376),
(43, 18, 'kingfirer1', 1404832619, 380),
(44, 18, 'kingfirer1', 1404832711, 383),
(45, 18, 'kingfirer1', 1404838100, 390),
(46, 18, 'kingfirer1', 1404913900, 405),
(47, 18, 'kingfirer1', 1404918679, 408),
(48, 1, 'Administrator', 1404921837, 413),
(49, 4, 'KangTa', 1404959390, 425),
(50, 1, 'Administrator', 1404968695, 448),
(51, 18, 'kingfirer1', 1404972705, 446),
(52, 1, 'Administrator', 1404997054, 474),
(53, 80, 'Lee SÃºn', 1405019322, 31),
(54, 1, 'Administrator', 1447050387, 12),
(56, 1, 'Administrator', 1447054970, 15),
(57, 104, 'bqngoc', 1447056920, 14),
(58, 104, 'bqngoc', 1448545037, 9);

-- --------------------------------------------------------

--
-- Table structure for table `prefix`
--

CREATE TABLE `prefix` (
  `prefixid` varchar(25) NOT NULL DEFAULT '',
  `prefixsetid` varchar(25) NOT NULL DEFAULT '',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `options` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prefixid`),
  KEY `prefixsetid` (`prefixsetid`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prefix`
--

INSERT INTO `prefix` (`prefixid`, `prefixsetid`, `displayorder`, `options`) VALUES
('tb1', 'tb1', 10, 1),
('sk1', 'sk1', 10, 1),
('hd1', 'hd1', 10, 1),
('hd11', 'bl1', 10, 1),
('hd111', 'hd11', 10, 1),
('mb11', 'muaban', 10, 1),
('tl', 'tlc1', 10, 1),
('skhapdan', 'sk1', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `prefixpermission`
--

CREATE TABLE `prefixpermission` (
  `prefixid` varchar(25) NOT NULL DEFAULT '',
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  KEY `prefixsetid` (`prefixid`,`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prefixset`
--

CREATE TABLE `prefixset` (
  `prefixsetid` varchar(25) NOT NULL DEFAULT '',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`prefixsetid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prefixset`
--

INSERT INTO `prefixset` (`prefixsetid`, `displayorder`) VALUES
('tb1', 10),
('sk1', 10),
('hd1', 10),
('tlc1', 10),
('bl1', 10),
('hd11', 10),
('muaban', 10);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` varchar(25) NOT NULL DEFAULT '',
  `title` varchar(50) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `version` varchar(25) NOT NULL DEFAULT '',
  `active` smallint(5) unsigned NOT NULL DEFAULT '1',
  `url` varchar(250) NOT NULL DEFAULT '',
  `versioncheckurl` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`productid`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `title`, `description`, `version`, `active`, `url`, `versioncheckurl`) VALUES
('skimlinks', 'Skimlinks Plugin', 'Official Skimlinks plugin for vBulletin', '4.2.0', 0, '', ''),
('forumrunner', 'Forum Runner', 'Adds push notification for your users using Forum Runner on the iPhone/iPod/iPad.  Also takes care of notifying users that your forum supports Forum Runner if they are viewing from a supported device.', '4.2.0', 0, '', ''),
('postrelease', 'PostRelease', 'Official PostRelease plugin for vBulletin', '4.2.0', 0, 'http://www.postrelease.com', ''),
('sub_forum_manager', 'Mod Sub-Forum', 'Sub-Forum Manager by Hasann', '4.0.1', 1, 'http://www.vbulletin-tr.com', 'http://www.vbulletin.org/forum/misc.php?do=productcheck&pid=sub_forum_manager'),
('vietvbb_topstats_vb4', 'Mod thá»‘ng kÃª Diá»…n Ä‘Ã n', '[AJAX]Advanced Forum Statistics', '4.0.4', 1, '', ''),
('post_thanks', 'Post Thank You Hack', 'Post Thank You Hack', '7.83', 1, 'http://www.vbulletin.org/forum/misc.php?do=producthelp&pid=post_thanks', ''),
('gd_davatar', 'Mod Avatas máº·c Ä‘á»‹nh', 'A default avatar for posts, profiles, etc.', '2.0.2', 1, 'http://www.vbulletin.org/forum/showthread.php?t=227947', 'http://version.geekydesigns.com/index.xml'),
('ads_on_category_vb4', 'Ads On Category', 'Ads On Category', '2.0', 1, 'http://vietvbb.vn/up/hackdb.php?do=findrelease&productid=ads_on_category_vb4', 'http://vietvbb.vn/up/hackdb.php?do=productcheck&productid=ads_on_category_vb4'),
('vsachatbox', 'VSa - ChatBox', 'VSa - ChatBox', '3.1.6', 1, 'http://www.vbulletin.org/forum/showthread.php?t=235271', 'http://www.vbulletin.org/forum/misc.php?do=productcheck&pid=vsachatbox');

-- --------------------------------------------------------

--
-- Table structure for table `productcode`
--

CREATE TABLE `productcode` (
  `productcodeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` varchar(25) NOT NULL DEFAULT '',
  `version` varchar(25) NOT NULL DEFAULT '',
  `installcode` mediumtext,
  `uninstallcode` mediumtext,
  PRIMARY KEY (`productcodeid`),
  KEY `productid` (`productid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `productcode`
--

INSERT INTO `productcode` (`productcodeid`, `productid`, `version`, `installcode`, `uninstallcode`) VALUES
(1, 'skimlinks', '*', 'echo ''<p>The Skimlinks installation must be executed via the install system.</p>\r\n<p>To continue to the Skimlinks installation, click <a href="../install/upgrade.php?version=skimlinks&amp;only=1">here</a>.'';\r\ndie();', '$db->query_write(\r\n			"DROP TABLE IF EXISTS " . TABLE_PREFIX . "skimlinks");\r\n	'),
(2, 'forumrunner', '*', 'echo ''<p>The Forum Runner installation must be executed via the install system.</p>\r\n<p>To continue to the Forum Runner installation, click <a href="../install/upgrade.php?version=forumrunner&amp;only=1">here</a>.'';\r\ndie();', '$db->query("DROP TABLE IF EXISTS " . TABLE_PREFIX . "forumrunner_push_data");\r\n$db->query("DROP TABLE IF EXISTS " . TABLE_PREFIX . "forumrunner_push_users");'),
(3, 'postrelease', '*', 'echo ''<p>The PostRelease installation must be executed via the install system.</p>\r\n<p>To continue to the PostRelease installation, click <a href="../install/upgrade.php?version=postrelease&amp;only=1">here</a>.'';\r\ndie();', '$db->query_write("DROP TABLE IF EXISTS " . TABLE_PREFIX . "postrelease");'),
(4, 'vietvbb_topstats_vb4', '', '$db->query_write("ALTER TABLE " . TABLE_PREFIX . "user ADD topxtab VARCHAR(25) NOT NULL DEFAULT ''0''");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "user ADD topxmenu VARCHAR(20) NOT NULL DEFAULT ''0''");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "user ADD topxresult INT(3) NOT NULL DEFAULT ''0''");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "session ADD topxtab VARCHAR(25) NOT NULL DEFAULT ''0''");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "session ADD topxmenu VARCHAR(20) NOT NULL DEFAULT ''0''");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "session ADD topxresult INT(3) NOT NULL DEFAULT ''0''");', '$db->query_write("ALTER TABLE " . TABLE_PREFIX . "user DROP topxtab");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "user DROP topxmenu");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "user DROP topxresult");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "session DROP topxtab");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "session DROP topxmenu");\r\n$db->query_write("ALTER TABLE " . TABLE_PREFIX . "session DROP topxresult");'),
(5, 'post_thanks', '*', 'if (!file_exists(DIR . ''/post_thanks.php'') OR !file_exists(DIR . ''/clientscript/post_thanks.js'') OR !file_exists(DIR . ''/includes/functions_post_thanks.php'') OR !file_exists(DIR . ''/includes/xml/cpnav_post_thanks.xml'') OR !file_exists(DIR . ''/includes/xml/hooks_post_thanks.xml''))\r\n{\r\n	print_dots_stop();\r\n	print_cp_message(''Please upload the files that came with this Hack before installing or upgrading!'');\r\n}', ''),
(6, 'post_thanks', '6.01', '$db->hide_errors();\r\n\r\n$db->query_write("CREATE TABLE IF NOT EXISTS`". TABLE_PREFIX ."post_thanks` (\r\n    `id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,\r\n    `userid` INT(10) NOT NULL,\r\n    `username` VARCHAR(50) NOT NULL,\r\n    `date` INT(10) NOT NULL,\r\n    `postid` INT(10) NOT NULL)\r\n    ");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."post_thanks` ADD INDEX ( `postid` )");\r\n\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."user` ADD `post_thanks_user_amount` INT( 10 ) UNSIGNED DEFAULT ''0'' NOT NULL");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."post` ADD `post_thanks_amount` INT( 10 ) UNSIGNED DEFAULT ''0'' NOT NULL");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."user` ADD `post_thanks_thanked_posts` INT( 10 ) UNSIGNED DEFAULT ''0'' NOT NULL");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."user` ADD `post_thanks_thanked_times` INT( 10 ) UNSIGNED DEFAULT ''0'' NOT NULL");\r\n\r\n$db->show_errors();', '$db->hide_errors();\r\n\r\n$db->query_write("DROP TABLE IF EXISTS " . TABLE_PREFIX . "post_thanks");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."user` DROP `post_thanks_user_amount`");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."post` DROP `post_thanks_amount`");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."user` DROP `post_thanks_thanked_posts`");\r\n$db->query_write("ALTER TABLE `". TABLE_PREFIX ."user` DROP `post_thanks_thanked_times`");\r\n\r\n$db->show_errors();'),
(8, 'ads_on_category_vb4', '1.0.3', '$db->hide_errors();\r\n		$vbulletin->db->query_write("ALTER TABLE `". TABLE_PREFIX ."forum` ADD `ads_code` TEXT DEFAULT ''''");\r\n		$db->show_errors();', '$db->hide_errors();		\r\n		$vbulletin->db->query_write("ALTER TABLE `". TABLE_PREFIX ."forum` DROP `ads_code`");\r\n		$db->show_errors();'),
(9, 'vsachatbox', '3.0', '\r\n		$vbulletin->db->hide_errors();\r\n		$vbulletin->db->query_write(" \r\n		CREATE TABLE IF NOT EXISTS `". TABLE_PREFIX ."vsa_chatbox` (\r\n			`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,\r\n			`userid` INT(10) NOT NULL,\r\n			`userip` VARCHAR(20) NOT NULL,\r\n			`dateline` INT(10) NOT NULL,\r\n			`message` TEXT NOT NULL,\r\n			`textprop` TEXT NOT NULL)\r\n		");\r\n		$vbulletin->db->show_errors();', '$vbulletin->db->hide_errors();\r\n		$vbulletin->db->query_write("DROP TABLE IF EXISTS `" . TABLE_PREFIX . "vsa_chatbox` ");\r\n		$vbulletin->db->show_errors();');

-- --------------------------------------------------------

--
-- Table structure for table `productdependency`
--

CREATE TABLE `productdependency` (
  `productdependencyid` int(11) NOT NULL AUTO_INCREMENT,
  `productid` varchar(25) NOT NULL DEFAULT '',
  `dependencytype` varchar(25) NOT NULL DEFAULT '',
  `parentproductid` varchar(25) NOT NULL DEFAULT '',
  `minversion` varchar(50) NOT NULL DEFAULT '',
  `maxversion` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`productdependencyid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `productdependency`
--

INSERT INTO `productdependency` (`productdependencyid`, `productid`, `dependencytype`, `parentproductid`, `minversion`, `maxversion`) VALUES
(1, 'skimlinks', 'vbulletin', '', '4.2.0', '4.3.0 Alpha 1'),
(2, 'forumrunner', 'vbulletin', '', '4.2.0', '4.3.0 Alpha 1'),
(3, 'postrelease', 'vbulletin', '', '4.2.0', '4.3.0 Alpha 1'),
(4, 'post_thanks', 'vbulletin', '', '4.0.0', '');

-- --------------------------------------------------------

--
-- Table structure for table `profileblockprivacy`
--

CREATE TABLE `profileblockprivacy` (
  `userid` int(10) unsigned NOT NULL,
  `blockid` varchar(255) NOT NULL,
  `requirement` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`blockid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profilefield`
--

CREATE TABLE `profilefield` (
  `profilefieldid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `profilefieldcategoryid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `required` smallint(6) NOT NULL DEFAULT '0',
  `hidden` smallint(6) NOT NULL DEFAULT '0',
  `maxlength` smallint(6) NOT NULL DEFAULT '250',
  `size` smallint(6) NOT NULL DEFAULT '25',
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  `editable` smallint(6) NOT NULL DEFAULT '1',
  `type` enum('input','select','radio','textarea','checkbox','select_multiple') NOT NULL DEFAULT 'input',
  `data` mediumtext,
  `height` smallint(6) NOT NULL DEFAULT '0',
  `def` smallint(6) NOT NULL DEFAULT '0',
  `optional` smallint(5) unsigned NOT NULL DEFAULT '0',
  `searchable` smallint(6) NOT NULL DEFAULT '0',
  `memberlist` smallint(6) NOT NULL DEFAULT '0',
  `regex` varchar(255) NOT NULL DEFAULT '',
  `form` smallint(6) NOT NULL DEFAULT '0',
  `html` smallint(6) NOT NULL DEFAULT '0',
  `perline` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`profilefieldid`),
  KEY `editable` (`editable`),
  KEY `profilefieldcategoryid` (`profilefieldcategoryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `profilefield`
--

INSERT INTO `profilefield` (`profilefieldid`, `profilefieldcategoryid`, `required`, `hidden`, `maxlength`, `size`, `displayorder`, `editable`, `type`, `data`, `height`, `def`, `optional`, `searchable`, `memberlist`, `regex`, `form`, `html`, `perline`) VALUES
(1, 0, 0, 0, 16384, 50, 1, 1, 'textarea', '', 0, 0, 0, 1, 1, '', 0, 0, 0),
(2, 0, 0, 0, 100, 25, 2, 1, 'input', '', 0, 0, 0, 1, 1, '', 0, 0, 0),
(3, 0, 0, 0, 100, 25, 3, 1, 'input', '', 0, 0, 0, 1, 1, '', 0, 0, 0),
(4, 0, 0, 0, 100, 25, 4, 1, 'input', '', 0, 0, 0, 1, 1, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profilefieldcategory`
--

CREATE TABLE `profilefieldcategory` (
  `profilefieldcategoryid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  `location` varchar(25) NOT NULL DEFAULT '',
  `allowprivacy` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`profilefieldcategoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profilevisitor`
--

CREATE TABLE `profilevisitor` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `visitorid` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `visible` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`visitorid`,`userid`),
  KEY `userid` (`userid`,`visible`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profilevisitor`
--

INSERT INTO `profilevisitor` (`userid`, `visitorid`, `dateline`, `visible`) VALUES
(103, 1, 1446913992, 1),
(1, 104, 1447046790, 1),
(104, 1, 1447515444, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ranks`
--

CREATE TABLE `ranks` (
  `rankid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `minposts` int(10) unsigned NOT NULL DEFAULT '0',
  `ranklevel` smallint(5) unsigned NOT NULL DEFAULT '0',
  `rankimg` mediumtext,
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `stack` smallint(5) unsigned NOT NULL DEFAULT '0',
  `display` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rankid`),
  KEY `grouprank` (`usergroupid`,`minposts`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE `reminder` (
  `reminderid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `text` mediumtext,
  `duedate` int(10) unsigned NOT NULL DEFAULT '0',
  `adminonly` smallint(5) unsigned NOT NULL DEFAULT '1',
  `completedby` int(10) unsigned NOT NULL DEFAULT '0',
  `completedtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`reminderid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reputation`
--

CREATE TABLE `reputation` (
  `reputationid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postid` int(10) unsigned NOT NULL DEFAULT '1',
  `userid` int(10) unsigned NOT NULL DEFAULT '1',
  `reputation` int(11) NOT NULL DEFAULT '0',
  `whoadded` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(250) DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`reputationid`),
  UNIQUE KEY `whoadded_postid` (`whoadded`,`postid`),
  KEY `userid` (`userid`),
  KEY `multi` (`postid`,`userid`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reputationlevel`
--

CREATE TABLE `reputationlevel` (
  `reputationlevelid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `minimumreputation` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reputationlevelid`),
  KEY `reputationlevel` (`minimumreputation`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `reputationlevel`
--

INSERT INTO `reputationlevel` (`reputationlevelid`, `minimumreputation`) VALUES
(1, -999999),
(2, -50),
(3, -10),
(4, 0),
(5, 10),
(6, 50),
(7, 150),
(8, 250),
(9, 350),
(10, 450),
(11, 550),
(12, 650),
(13, 1000),
(14, 1500),
(15, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `routeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userrequest` varchar(50) NOT NULL,
  `packageid` int(10) unsigned NOT NULL,
  `class` varbinary(50) NOT NULL,
  PRIMARY KEY (`routeid`),
  UNIQUE KEY `userrequest` (`userrequest`),
  UNIQUE KEY `packageid` (`packageid`,`class`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
