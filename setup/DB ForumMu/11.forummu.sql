-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 04:39 AM
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
-- Table structure for table `threadrate`
--

CREATE TABLE `threadrate` (
  `threadrateid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `vote` smallint(6) NOT NULL DEFAULT '0',
  `ipaddress` char(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`threadrateid`),
  KEY `threadid` (`threadid`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `threadrate`
--

INSERT INTO `threadrate` (`threadrateid`, `threadid`, `userid`, `vote`, `ipaddress`) VALUES
(2, 56, 19, 5, '183.97.98.10'),
(3, 78, 80, 5, '117.0.37.133');

-- --------------------------------------------------------

--
-- Table structure for table `threadread`
--

CREATE TABLE `threadread` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  `readtime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`threadid`),
  KEY `readtime` (`readtime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `threadredirect`
--

CREATE TABLE `threadredirect` (
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  `expires` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`threadid`),
  KEY `expires` (`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `threadviews`
--

CREATE TABLE `threadviews` (
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `threadid` (`threadid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upgradelog`
--

CREATE TABLE `upgradelog` (
  `upgradelogid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `script` varchar(50) NOT NULL DEFAULT '',
  `steptitle` varchar(250) NOT NULL DEFAULT '',
  `step` smallint(5) unsigned NOT NULL DEFAULT '0',
  `startat` int(10) unsigned NOT NULL DEFAULT '0',
  `perpage` smallint(5) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `only` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`upgradelogid`),
  KEY `script` (`script`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=135 ;

--
-- Dumping data for table `upgradelog`
--

INSERT INTO `upgradelog` (`upgradelogid`, `script`, `steptitle`, `step`, `startat`, `perpage`, `dateline`, `only`) VALUES
(1, 'install', '', 3, 0, 0, 1399423136, 0),
(2, 'install', '', 4, 0, 0, 1399423138, 0),
(3, 'install', '', 5, 0, 0, 1399423173, 0),
(4, 'install', '', 6, 0, 0, 1399423190, 0),
(5, 'install', '', 0, 0, 0, 1399423222, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `membergroupids` char(250) NOT NULL DEFAULT '',
  `displaygroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `passworddate` date NOT NULL DEFAULT '0000-00-00',
  `email` char(100) NOT NULL DEFAULT '',
  `styleid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parentemail` char(50) NOT NULL DEFAULT '',
  `homepage` char(100) NOT NULL DEFAULT '',
  `icq` char(20) NOT NULL DEFAULT '',
  `aim` char(20) NOT NULL DEFAULT '',
  `yahoo` char(32) NOT NULL DEFAULT '',
  `msn` char(100) NOT NULL DEFAULT '',
  `skype` char(32) NOT NULL DEFAULT '',
  `showvbcode` smallint(5) unsigned NOT NULL DEFAULT '0',
  `showbirthday` smallint(5) unsigned NOT NULL DEFAULT '2',
  `usertitle` char(250) NOT NULL DEFAULT '',
  `customtitle` smallint(6) NOT NULL DEFAULT '0',
  `joindate` int(10) unsigned NOT NULL DEFAULT '0',
  `daysprune` smallint(6) NOT NULL DEFAULT '0',
  `lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
  `lastactivity` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpostid` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` int(10) unsigned NOT NULL DEFAULT '0',
  `reputation` int(11) NOT NULL DEFAULT '10',
  `reputationlevelid` int(10) unsigned NOT NULL DEFAULT '1',
  `timezoneoffset` char(4) NOT NULL DEFAULT '',
  `pmpopup` smallint(6) NOT NULL DEFAULT '0',
  `avatarid` smallint(6) NOT NULL DEFAULT '0',
  `avatarrevision` int(10) unsigned NOT NULL DEFAULT '0',
  `profilepicrevision` int(10) unsigned NOT NULL DEFAULT '0',
  `sigpicrevision` int(10) unsigned NOT NULL DEFAULT '0',
  `options` int(10) unsigned NOT NULL DEFAULT '33570831',
  `birthday` char(10) NOT NULL DEFAULT '',
  `birthday_search` date NOT NULL DEFAULT '0000-00-00',
  `maxposts` smallint(6) NOT NULL DEFAULT '-1',
  `startofweek` smallint(6) NOT NULL DEFAULT '1',
  `ipaddress` char(15) NOT NULL DEFAULT '',
  `referrerid` int(10) unsigned NOT NULL DEFAULT '0',
  `languageid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `emailstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `threadedmode` smallint(5) unsigned NOT NULL DEFAULT '0',
  `autosubscribe` smallint(6) NOT NULL DEFAULT '-1',
  `pmtotal` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pmunread` smallint(5) unsigned NOT NULL DEFAULT '0',
  `salt` char(30) NOT NULL DEFAULT '',
  `ipoints` int(10) unsigned NOT NULL DEFAULT '0',
  `infractions` int(10) unsigned NOT NULL DEFAULT '0',
  `warnings` int(10) unsigned NOT NULL DEFAULT '0',
  `infractiongroupids` varchar(255) NOT NULL DEFAULT '',
  `infractiongroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `adminoptions` int(10) unsigned NOT NULL DEFAULT '0',
  `profilevisits` int(10) unsigned NOT NULL DEFAULT '0',
  `friendcount` int(10) unsigned NOT NULL DEFAULT '0',
  `friendreqcount` int(10) unsigned NOT NULL DEFAULT '0',
  `vmunreadcount` int(10) unsigned NOT NULL DEFAULT '0',
  `vmmoderatedcount` int(10) unsigned NOT NULL DEFAULT '0',
  `socgroupinvitecount` int(10) unsigned NOT NULL DEFAULT '0',
  `socgroupreqcount` int(10) unsigned NOT NULL DEFAULT '0',
  `pcunreadcount` int(10) unsigned NOT NULL DEFAULT '0',
  `pcmoderatedcount` int(10) unsigned NOT NULL DEFAULT '0',
  `gmmoderatedcount` int(10) unsigned NOT NULL DEFAULT '0',
  `assetposthash` varchar(32) NOT NULL DEFAULT '',
  `fbuserid` varchar(255) NOT NULL DEFAULT '',
  `fbjoindate` int(10) unsigned NOT NULL DEFAULT '0',
  `fbname` varchar(255) NOT NULL DEFAULT '',
  `logintype` enum('vb','fb') NOT NULL DEFAULT 'vb',
  `fbaccesstoken` varchar(255) NOT NULL DEFAULT '',
  `newrepcount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `topxtab` varchar(25) NOT NULL DEFAULT '0',
  `topxmenu` varchar(20) NOT NULL DEFAULT '0',
  `topxresult` int(3) NOT NULL DEFAULT '0',
  `post_thanks_user_amount` int(10) unsigned NOT NULL DEFAULT '0',
  `post_thanks_thanked_posts` int(10) unsigned NOT NULL DEFAULT '0',
  `post_thanks_thanked_times` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`),
  KEY `usergroupid` (`usergroupid`),
  KEY `username` (`username`),
  KEY `birthday` (`birthday`,`showbirthday`),
  KEY `birthday_search` (`birthday_search`),
  KEY `referrerid` (`referrerid`),
  KEY `fbuserid` (`fbuserid`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `usergroupid`, `membergroupids`, `displaygroupid`, `username`, `password`, `passworddate`, `email`, `styleid`, `parentemail`, `homepage`, `icq`, `aim`, `yahoo`, `msn`, `skype`, `showvbcode`, `showbirthday`, `usertitle`, `customtitle`, `joindate`, `daysprune`, `lastvisit`, `lastactivity`, `lastpost`, `lastpostid`, `posts`, `reputation`, `reputationlevelid`, `timezoneoffset`, `pmpopup`, `avatarid`, `avatarrevision`, `profilepicrevision`, `sigpicrevision`, `options`, `birthday`, `birthday_search`, `maxposts`, `startofweek`, `ipaddress`, `referrerid`, `languageid`, `emailstamp`, `threadedmode`, `autosubscribe`, `pmtotal`, `pmunread`, `salt`, `ipoints`, `infractions`, `warnings`, `infractiongroupids`, `infractiongroupid`, `adminoptions`, `profilevisits`, `friendcount`, `friendreqcount`, `vmunreadcount`, `vmmoderatedcount`, `socgroupinvitecount`, `socgroupreqcount`, `pcunreadcount`, `pcmoderatedcount`, `gmmoderatedcount`, `assetposthash`, `fbuserid`, `fbjoindate`, `fbname`, `logintype`, `fbaccesstoken`, `newrepcount`, `topxtab`, `topxmenu`, `topxresult`, `post_thanks_user_amount`, `post_thanks_thanked_posts`, `post_thanks_thanked_times`) VALUES
(1, 6, '', 0, 'Administrator', '323b78c930c35e0316b5144a806dc2e3', '2015-11-07', 'hoangtrungno.1@gmail.com', 0, '', '', '', '', '', '', '', 2, 2, '<center><b><font color=red>Administrator</font></center></b>', 0, 1399423200, 0, 1450011182, 1450526477, 1448477301, 34, 20, 10, 1, '7', 0, 0, 0, 0, 0, 11552855, '', '0000-00-00', -1, 1, '', 0, 0, 0, 0, -1, 0, 0, '|vr;eK!DrB{m,}2bc/`[?5r_5#gJ(w', 0, 0, 0, '', 0, 0, 166, 1, 0, 0, 0, 0, 0, 0, 0, 0, '75bea5ac630d0d846d9119e51058cafe', '', 0, '', 'vb', '', 0, 'latest_posts_custom6', 'top_starters', 0, 5, 3, 3),
(103, 2, '', 0, 'bqngoc119', '323b78c930c35e0316b5144a806dc2e3', '2015-11-07', 'ngocttj@gmail.com', 0, '', '', '', '', '', '', '', 1, 0, '<center><b><font color="#996633">ThÃ nh ViÃªn</font></b></center>', 0, 1446910560, 0, 1446910707, 1446910560, 0, 0, 0, 10, 5, '7', 0, 0, 0, 0, 0, 45108311, '11-13-2015', '1990-11-13', -1, -1, '', 0, 0, 0, 0, -1, 0, 0, '7)0cxU"=6)M9N.[kTc&[h6s{zb_SOU', 0, 0, 0, '', 0, 0, 8, 0, 1, 0, 0, 0, 0, 0, 0, 0, '', '', 0, '', 'vb', '', 0, '0', '0', 0, 0, 0, 0),
(104, 2, '', 0, 'bqngoc', 'f6a47855559da5efe657ed9ebfe9cf54', '2015-11-26', 'boylove.ngocit@gmail.com', 0, '', '', '', '', '', '', '', 1, 0, '<center><b><font color="#996633">ThÃ nh ViÃªn</font></b></center>', 0, 1447044240, 0, 1448545026, 1448547060, 1447565460, 24, 8, 10, 5, '7', 0, 0, 0, 0, 0, 45108311, '', '0000-00-00', -1, -1, '', 0, 2, 0, 0, -1, 0, 0, 'lU=gT$H''#AJ{LA@"UBV?T6,N.?JXVL', 0, 0, 0, '', 0, 0, 18, 1, 0, 0, 0, 0, 0, 0, 0, 0, '8e7120b710dda265547d7a4c011dcfb0', '', 0, '', 'vb', '', 0, '0', '0', 0, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `useractivation`
--

CREATE TABLE `useractivation` (
  `useractivationid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `activationid` varchar(40) NOT NULL DEFAULT '',
  `type` smallint(5) unsigned NOT NULL DEFAULT '0',
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `emailchange` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`useractivationid`),
  UNIQUE KEY `userid` (`userid`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `userban`
--

CREATE TABLE `userban` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `displaygroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `usertitle` varchar(250) NOT NULL DEFAULT '',
  `customtitle` smallint(6) NOT NULL DEFAULT '0',
  `adminid` int(10) unsigned NOT NULL DEFAULT '0',
  `bandate` int(10) unsigned NOT NULL DEFAULT '0',
  `liftdate` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`),
  KEY `liftdate` (`liftdate`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userchangelog`
--

CREATE TABLE `userchangelog` (
  `changeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `fieldname` varchar(250) NOT NULL DEFAULT '',
  `newvalue` varchar(250) NOT NULL DEFAULT '',
  `oldvalue` varchar(250) NOT NULL DEFAULT '',
  `adminid` int(10) unsigned NOT NULL DEFAULT '0',
  `change_time` int(10) unsigned NOT NULL DEFAULT '0',
  `change_uniq` varchar(32) NOT NULL DEFAULT '',
  `ipaddress` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`changeid`),
  KEY `userid` (`userid`,`change_time`),
  KEY `change_time` (`change_time`),
  KEY `change_uniq` (`change_uniq`),
  KEY `fieldname` (`fieldname`,`change_time`),
  KEY `adminid` (`adminid`,`change_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `userchangelog`
--

INSERT INTO `userchangelog` (`changeid`, `userid`, `fieldname`, `newvalue`, `oldvalue`, `adminid`, `change_time`, `change_uniq`, `ipaddress`) VALUES
(1, 4, 'usergroupid', '6', '2', 1, 1402226195, 'd668df3a55d4236c24b01ba6faeeb090', 1177008545),
(2, 8, 'membergroupids', '5', '', 4, 1402330088, 'e27da6efe384c89384abbf76abb0420d', 1963440654),
(3, 8, 'usergroupid', '11', '2', 4, 1402330602, 'f62ff3d07e916bf33c93a7cfe93133f8', 1963440654),
(4, 4, 'username', 'KangTa', 'Mr_Ha', 4, 1404027532, '85f508021ee1ca907846836d12b36d58', 1892017477),
(5, 28, 'membergroupids', '7', '', 4, 1404145090, 'ee23f45b2c73f8d0bc60a555b7dd7c79', 1963444775),
(6, 36, 'usergroupid', '7', '2', 1, 1404740041, '2dfcfb843f1eda85ef3c099f095e8593', 1908019924),
(7, 99, 'membergroupids', '6', '', 4, 1405008169, '4cced479e19c52ea9652977de15dd977', 1892017477),
(8, 99, 'usergroupid', '6', '2', 4, 1405008216, 'd874cd0353a2d73347e0addf5dafaf4f', 1892017477),
(9, 99, 'membergroupids', '', '6', 4, 1405008216, 'd874cd0353a2d73347e0addf5dafaf4f', 1892017477),
(10, 103, 'membergroupids', '7', '', 1, 1446911391, 'ecd769e1f55b375340b93f2779ed461a', 0);

-- --------------------------------------------------------

--
-- Table structure for table `usercss`
--

CREATE TABLE `usercss` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `selector` varchar(30) NOT NULL DEFAULT '',
  `property` varchar(30) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`,`selector`,`property`),
  KEY `property` (`property`,`userid`,`value`(20))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usercsscache`
--

CREATE TABLE `usercsscache` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `cachedcss` text,
  `buildpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userfield`
--

CREATE TABLE `userfield` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `temp` mediumtext,
  `field1` mediumtext,
  `field2` mediumtext,
  `field3` mediumtext,
  `field4` mediumtext,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userfield`
--

INSERT INTO `userfield` (`userid`, `temp`, `field1`, `field2`, `field3`, `field4`) VALUES
(1, NULL, '', '', '', ''),
(17, NULL, NULL, NULL, NULL, NULL),
(4, NULL, '', '', '', ''),
(19, NULL, NULL, NULL, NULL, NULL),
(25, NULL, NULL, NULL, NULL, NULL),
(8, NULL, '', '', '', ''),
(20, NULL, NULL, NULL, NULL, NULL),
(21, NULL, NULL, NULL, NULL, NULL),
(22, NULL, NULL, NULL, NULL, NULL),
(23, NULL, NULL, NULL, NULL, NULL),
(24, NULL, NULL, NULL, NULL, NULL),
(18, NULL, NULL, NULL, NULL, NULL),
(26, NULL, NULL, NULL, NULL, NULL),
(27, NULL, NULL, NULL, NULL, NULL),
(28, NULL, '', '', '', ''),
(29, NULL, '', '', '', ''),
(30, NULL, NULL, NULL, NULL, NULL),
(31, NULL, NULL, NULL, NULL, NULL),
(32, NULL, NULL, NULL, NULL, NULL),
(33, NULL, NULL, NULL, NULL, NULL),
(34, NULL, NULL, NULL, NULL, NULL),
(35, NULL, NULL, NULL, NULL, NULL),
(36, NULL, '', '', '', ''),
(37, NULL, NULL, NULL, NULL, NULL),
(38, NULL, NULL, NULL, NULL, NULL),
(39, NULL, NULL, NULL, NULL, NULL),
(40, NULL, NULL, NULL, NULL, NULL),
(41, NULL, NULL, NULL, NULL, NULL),
(42, NULL, NULL, NULL, NULL, NULL),
(43, NULL, NULL, NULL, NULL, NULL),
(44, NULL, '', '', '', ''),
(45, NULL, NULL, NULL, NULL, NULL),
(46, NULL, NULL, NULL, NULL, NULL),
(47, NULL, '', '', '', ''),
(48, NULL, NULL, NULL, NULL, NULL),
(49, NULL, NULL, NULL, NULL, NULL),
(50, NULL, NULL, NULL, NULL, NULL),
(51, NULL, NULL, NULL, NULL, NULL),
(52, NULL, NULL, NULL, NULL, NULL),
(53, NULL, NULL, NULL, NULL, NULL),
(54, NULL, NULL, NULL, NULL, NULL),
(55, NULL, NULL, NULL, NULL, NULL),
(56, NULL, NULL, NULL, NULL, NULL),
(57, NULL, NULL, NULL, NULL, NULL),
(58, NULL, NULL, NULL, NULL, NULL),
(59, NULL, NULL, NULL, NULL, NULL),
(60, NULL, NULL, NULL, NULL, NULL),
(61, NULL, NULL, NULL, NULL, NULL),
(62, NULL, NULL, NULL, NULL, NULL),
(73, NULL, NULL, NULL, NULL, NULL),
(64, NULL, NULL, NULL, NULL, NULL),
(65, NULL, NULL, NULL, NULL, NULL),
(66, NULL, NULL, NULL, NULL, NULL),
(67, NULL, NULL, NULL, NULL, NULL),
(68, NULL, NULL, NULL, NULL, NULL),
(69, NULL, NULL, NULL, NULL, NULL),
(70, NULL, NULL, NULL, NULL, NULL),
(71, NULL, NULL, NULL, NULL, NULL),
(72, NULL, NULL, NULL, NULL, NULL),
(74, NULL, NULL, NULL, NULL, NULL),
(75, NULL, NULL, NULL, NULL, NULL),
(76, NULL, NULL, NULL, NULL, NULL),
(77, NULL, NULL, NULL, NULL, NULL),
(78, NULL, NULL, NULL, NULL, NULL),
(79, NULL, NULL, NULL, NULL, NULL),
(80, NULL, '', '', '', ''),
(81, NULL, NULL, NULL, NULL, NULL),
(82, NULL, NULL, NULL, NULL, NULL),
(83, NULL, NULL, NULL, NULL, NULL),
(84, NULL, NULL, NULL, NULL, NULL),
(85, NULL, NULL, NULL, NULL, NULL),
(86, NULL, NULL, NULL, NULL, NULL),
(87, NULL, NULL, NULL, NULL, NULL),
(88, NULL, NULL, NULL, NULL, NULL),
(89, NULL, NULL, NULL, NULL, NULL),
(90, NULL, NULL, NULL, NULL, NULL),
(91, NULL, NULL, NULL, NULL, NULL),
(92, NULL, NULL, NULL, NULL, NULL),
(93, NULL, NULL, NULL, NULL, NULL),
(94, NULL, '', '', '', ''),
(95, NULL, NULL, NULL, NULL, NULL),
(96, NULL, NULL, NULL, NULL, NULL),
(97, NULL, NULL, NULL, NULL, NULL),
(98, NULL, NULL, NULL, NULL, NULL),
(99, NULL, '', '', '', ''),
(100, NULL, NULL, NULL, NULL, NULL),
(101, NULL, NULL, NULL, NULL, NULL),
(102, NULL, NULL, NULL, NULL, NULL),
(103, NULL, '', '', '', ''),
(104, NULL, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `usergroup`
--

CREATE TABLE `usergroup` (
  `usergroupid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `usertitle` char(100) NOT NULL DEFAULT '',
  `passwordexpires` smallint(5) unsigned NOT NULL DEFAULT '0',
  `passwordhistory` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pmquota` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pmsendmax` smallint(5) unsigned NOT NULL DEFAULT '5',
  `opentag` text NOT NULL,
  `closetag` char(100) NOT NULL DEFAULT '',
  `canoverride` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ispublicgroup` smallint(5) unsigned NOT NULL DEFAULT '0',
  `forumpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `pmpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `calendarpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `wolpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `adminpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `genericpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `genericpermissions2` int(10) unsigned NOT NULL DEFAULT '0',
  `genericoptions` int(10) unsigned NOT NULL DEFAULT '0',
  `signaturepermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `visitormessagepermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `attachlimit` int(10) unsigned NOT NULL DEFAULT '0',
  `avatarmaxwidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `avatarmaxheight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `avatarmaxsize` int(10) unsigned NOT NULL DEFAULT '0',
  `profilepicmaxwidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `profilepicmaxheight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `profilepicmaxsize` int(10) unsigned NOT NULL DEFAULT '0',
  `sigpicmaxwidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sigpicmaxheight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sigpicmaxsize` int(10) unsigned NOT NULL DEFAULT '0',
  `sigmaximages` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sigmaxsizebbcode` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sigmaxchars` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sigmaxrawchars` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sigmaxlines` smallint(5) unsigned NOT NULL DEFAULT '0',
  `usercsspermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `albumpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `albumpicmaxwidth` smallint(5) unsigned NOT NULL DEFAULT '0',
  `albumpicmaxheight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `albummaxpics` int(10) unsigned NOT NULL DEFAULT '0',
  `albummaxsize` int(10) unsigned NOT NULL DEFAULT '0',
  `socialgrouppermissions` int(10) unsigned NOT NULL DEFAULT '0',
  `pmthrottlequantity` int(10) unsigned NOT NULL DEFAULT '0',
  `groupiconmaxsize` int(10) unsigned NOT NULL DEFAULT '0',
  `maximumsocialgroups` int(10) unsigned NOT NULL DEFAULT '0',
  `sigmaxvideos` smallint(5) unsigned NOT NULL DEFAULT '0',
  `vbblog_general_permissions` int(10) unsigned NOT NULL DEFAULT '0',
  `vbblog_entry_permissions` int(10) unsigned NOT NULL DEFAULT '0',
  `vbblog_comment_permissions` int(10) unsigned NOT NULL DEFAULT '0',
  `vbblog_customblocks` int(10) unsigned NOT NULL DEFAULT '0',
  `vbblog_custompages` int(10) unsigned NOT NULL DEFAULT '0',
  `vbcmspermissions` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`usergroupid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `usergroup`
--

INSERT INTO `usergroup` (`usergroupid`, `title`, `description`, `usertitle`, `passwordexpires`, `passwordhistory`, `pmquota`, `pmsendmax`, `opentag`, `closetag`, `canoverride`, `ispublicgroup`, `forumpermissions`, `pmpermissions`, `calendarpermissions`, `wolpermissions`, `adminpermissions`, `genericpermissions`, `genericpermissions2`, `genericoptions`, `signaturepermissions`, `visitormessagepermissions`, `attachlimit`, `avatarmaxwidth`, `avatarmaxheight`, `avatarmaxsize`, `profilepicmaxwidth`, `profilepicmaxheight`, `profilepicmaxsize`, `sigpicmaxwidth`, `sigpicmaxheight`, `sigpicmaxsize`, `sigmaximages`, `sigmaxsizebbcode`, `sigmaxchars`, `sigmaxrawchars`, `sigmaxlines`, `usercsspermissions`, `albumpermissions`, `albumpicmaxwidth`, `albumpicmaxheight`, `albummaxpics`, `albummaxsize`, `socialgrouppermissions`, `pmthrottlequantity`, `groupiconmaxsize`, `maximumsocialgroups`, `sigmaxvideos`, `vbblog_general_permissions`, `vbblog_entry_permissions`, `vbblog_comment_permissions`, `vbblog_customblocks`, `vbblog_custompages`, `vbcmspermissions`) VALUES
(1, 'Unregistered / Not Logged In', '', 'Guest', 0, 0, 50, 0, '', '', 0, 0, 655371, 0, 1, 0, 0, 1, 0, 104, 0, 16, 0, 80, 80, 20000, 100, 100, 65535, 500, 100, 10000, 4, 7, 500, 1000, 0, 0, 192, 600, 600, 100, 0, 131136, 0, 65535, 0, 1, 262512, 834, 3008, 0, 0, 0),
(2, '<b><font color="Olive">ThÃ nh ViÃªn</font></b>', '', '<center><b><font color="#996633">ThÃ nh ViÃªn</font></b></center>', 0, 0, 50, 5, '<img src="images/icontruocnick/member.gif"><font color="#996633 ">', '</font></b>', 0, 0, 12318203, 3, 63, 1, 0, 1546131143, 5, 62, 137211, 63, 0, 200, 200, 20000, 200, 200, 65535, 500, 100, 10000, 4, 3, 250, 250, 0, 191, 255, 600, 600, 100, 0, 251767, 0, 65535, 5, 1, 519166, 40959, 3022, 5, 5, 0),
(3, 'Users Awaiting Email Confirmation', '', '', 0, 0, 50, 1, '', '', 0, 0, 655371, 0, 1, 0, 0, 67, 0, 56, 0, 16, 0, 80, 80, 20000, 100, 100, 65535, 500, 100, 10000, 4, 7, 500, 1000, 0, 0, 192, 600, 600, 100, 0, 131136, 0, 65535, 5, 1, 262512, 834, 3008, 0, 0, 0),
(4, 'Users Awaiting Moderation', '', '', 0, 0, 50, 1, '', '', 0, 0, 655371, 0, 1, 0, 0, 67, 0, 56, 0, 16, 0, 80, 80, 20000, 100, 100, 65535, 500, 100, 10000, 4, 7, 500, 1000, 0, 0, 192, 600, 600, 100, 0, 131136, 0, 65535, 5, 1, 262512, 834, 3008, 0, 0, 0),
(5, '<font color=green>Super Moderators</font>', '', '<center><b><font color=green>Super Moderators</font></center></b>', 0, 0, 50, 0, '<img src="images/icontruocnick/smod.gif"><font color=green>', '</font></b></span>', 0, 0, 100663291, 7, 63, 13, 1, 1575966447, 7, 63, 499711, 63, 0, 80, 80, 20000, 200, 200, 65535, 500, 100, 10000, 4, 7, 500, 1000, 0, 191, 255, 600, 600, 100, 0, 262143, 0, 65535, 5, 1, 524286, 57343, 3038, 10, 10, 0),
(6, '<font color=red>Administrator</font>', '', '<center><b><font color=red>Administrator</font></center></b>', 65535, 360, 50, 5, '<img src=''images/icontruocnick/admin.gif'' border=''0''><font color=red><b>', '</font></b>', 0, 0, 134217727, 7, 63, 31, 3, 2147483583, 7, 55, 499711, 63, 0, 300, 300, 20000, 200, 200, 65535, 500, 100, 10000, 0, 7, 0, 0, 0, 191, 255, 600, 600, 100, 0, 262143, 0, 65535, 5, 0, 524286, 57343, 3038, 10, 10, 1),
(7, '<font color=blue>Moderators</font>', '', '<center><b><font color=blue>Moderators</font></center></b>', 0, 0, 50, 5, '<font color=blue><img src="images/icontruocnick/mod.gif">', '</font></b></span>', 0, 0, 79426043, 7, 63, 13, 0, 1575950031, 7, 62, 235519, 63, 0, 80, 80, 20000, 200, 200, 65535, 500, 100, 10000, 4, 3, 250, 250, 0, 191, 255, 600, 600, 100, 0, 262143, 0, 65535, 5, 1, 519166, 40959, 3022, 5, 5, 0),
(8, 'Banned Users', '', 'Vi pháº¡m quy Ä‘á»‹nh', 0, 0, 0, 0, '<img src="http://forum.muhpvn.net/images/ranksten/ban.gif"><b><font color="White"><s><u>', '</s></u></i></font>', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 80, 80, 20000, 100, 100, 65535, 500, 100, 10000, 4, 7, 500, 1000, 0, 0, 0, 600, 600, 100, 0, 0, 0, 65535, 5, 1, 0, 0, 0, 0, 0, 0),
(9, '<font color=DarkRed>GameMaster</font>', '', 'Cá»™ng TÃ¡c ViÃªn', 0, 0, 500, 0, '<span style=''background: url(http://forum.muhpvn.net/images/ranks/01.gif)''><img src="http://forum.muhpvn.net/images/ranksten/gm.gif"><font color=DarkRed>', '</b></font></span>', 0, 0, 4186107, 7, 63, 15, 3, 1575968495, 0, 55, 499711, 63, 0, 150, 150, 20000, 200, 200, 65535, 500, 100, 10000, 5, 7, 500, 1000, 0, 191, 255, 600, 600, 100, 0, 262143, 0, 65535, 5, 1, 524286, 57343, 3038, 10, 10, 1),
(11, '<b><font color=Indigo>ThÃ nh viÃªn tÃ¢m huyáº¿t</font></b>', '', '<b><font color=Indigo>ThÃ nh viÃªn tÃ¢m huyáº¿t</font></b>', 0, 0, 0, 5, '<img src="http://forum.muhpvn.net/images/ranksten/mem.gif"><font color=Indigo>', '</font></b></span>', 0, 0, 12317179, 7, 63, 15, 0, 1575950031, 1, 63, 499711, 63, 1000000, 80, 80, 20000, 200, 200, 65535, 0, 0, 0, 0, 7, 0, 0, 0, 191, 255, 0, 0, 0, 0, 262143, 0, 0, 0, 0, 519166, 40959, 3022, 5, 5, 0),
(14, '<b><font color=#ff0066>Máº­t Vá»¥</font></b>', '', '<b><font color=#ff0066>Máº­t Vá»¥</font></b>', 0, 0, 0, 5, '<img src="http://forum.muhpvn.net/images/ranksten/mem.gif"><font color=#ff0066>', '</font></b></span>', 0, 0, 12317179, 7, 63, 15, 0, 1575950031, 1, 63, 98304, 63, 1000000, 50, 50, 20000, 100, 100, 25000, 0, 0, 0, 0, 7, 0, 0, 0, 191, 255, 0, 0, 0, 0, 262143, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, '<font color=#daa520>VIP</font>', '', '<center><b><font color=Red>ThÃ nh ViÃªn VIP</center></b></font>', 0, 0, 0, 5, '<span style=''background: url(http://diendan.musatthu.us/images/ranks/01.gif) scroll 0% 0% transparent;  ; font-weight: bold''><img src="http://diendan.musatthu.us/images/ranksten/admin.gif"> <font color=#daa520>', '</font></b></span>', 0, 0, 651271, 0, 0, 1, 0, 2626563, 0, 41, 0, 0, 1000000, 50, 50, 20000, 100, 100, 25000, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usergroupleader`
--

CREATE TABLE `usergroupleader` (
  `usergroupleaderid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`usergroupleaderid`),
  KEY `ugl` (`userid`,`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usergrouprequest`
--

CREATE TABLE `usergrouprequest` (
  `usergrouprequestid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(250) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`usergrouprequestid`),
  UNIQUE KEY `userid` (`userid`,`usergroupid`),
  KEY `usergroupid` (`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE `userlist` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `relationid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('buddy','ignore') NOT NULL DEFAULT 'buddy',
  `friend` enum('yes','no','pending','denied') NOT NULL DEFAULT 'no',
  PRIMARY KEY (`userid`,`relationid`,`type`),
  KEY `relationid` (`relationid`,`type`,`friend`),
  KEY `userid` (`userid`,`type`,`friend`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlist`
--

INSERT INTO `userlist` (`userid`, `relationid`, `type`, `friend`) VALUES
(71, 4, 'buddy', 'pending'),
(80, 4, 'buddy', 'pending'),
(1, 103, 'buddy', 'pending'),
(104, 1, 'buddy', 'yes'),
(1, 104, 'buddy', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `usernote`
--

CREATE TABLE `usernote` (
  `usernoteid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `posterid` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(100) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `message` mediumtext,
  `title` varchar(255) NOT NULL DEFAULT '',
  `allowsmilies` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usernoteid`),
  KEY `userid` (`userid`),
  KEY `posterid` (`posterid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `usernote`
--

INSERT INTO `usernote` (`usernoteid`, `userid`, `posterid`, `username`, `dateline`, `message`, `title`, `allowsmilies`) VALUES
(1, 104, 1, '', 1447046669, 'dm vlgbekslfgw;)', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userpromotion`
--

CREATE TABLE `userpromotion` (
  `userpromotionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usergroupid` int(10) unsigned NOT NULL DEFAULT '0',
  `joinusergroupid` int(10) unsigned NOT NULL DEFAULT '0',
  `reputation` int(11) NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `posts` int(10) unsigned NOT NULL DEFAULT '0',
  `strategy` smallint(6) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL DEFAULT '2',
  PRIMARY KEY (`userpromotionid`),
  KEY `usergroupid` (`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usertextfield`
--

CREATE TABLE `usertextfield` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `subfolders` mediumtext,
  `pmfolders` mediumtext,
  `buddylist` mediumtext,
  `ignorelist` mediumtext,
  `signature` mediumtext,
  `searchprefs` mediumtext,
  `rank` mediumtext,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertextfield`
--

INSERT INTO `usertextfield` (`userid`, `subfolders`, `pmfolders`, `buddylist`, `ignorelist`, `signature`, `searchprefs`, `rank`) VALUES
(1, NULL, NULL, '103 104', '', '', NULL, ''),
(17, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(4, NULL, NULL, NULL, NULL, '[COLOR="#0000FF"][SIZE=4]HÃ£y cÃ¹ng Admin Mu ThiÃªn Kim xÃ¢y dá»±ng 1 cá»™ng Ä‘á»“ng Game Mu lá»›n máº¡nh.HÃ£y Like Fanpage cá»§a chÃºng tÃ´i trÃªn FaceBook lÃ  báº¡n Ä‘Ã£ gÃ³p pháº§n xÃ¢y dá»±ng hÃ¬nh áº£nh cho MU ThiÃªn Kim ngÃ y 1 lá»›n máº¡nh rá»“i Ä‘Ã³[/SIZE][/COLOR]', NULL, ''),
(8, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(18, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(19, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(20, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(21, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(22, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(23, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(24, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(25, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(26, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(27, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(28, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(29, NULL, NULL, NULL, NULL, '', NULL, ''),
(30, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(31, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(32, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(33, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(34, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(35, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(36, NULL, NULL, NULL, NULL, '[FONT=Arial Black][COLOR="#FF0000"][B]- TrÃ¢m Sociuu -[/B][/COLOR][/FONT]\r\n[url]https://www.facebook.com/lunatram1995[/url] ;)) ;))', NULL, ''),
(37, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(38, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(39, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(40, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(41, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(42, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(43, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(44, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(45, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(46, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(47, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(48, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(49, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(50, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(51, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(52, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(53, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(54, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(55, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(56, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(57, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(58, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(59, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(60, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(61, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(62, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(73, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(64, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(65, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(66, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(67, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(68, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(69, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(70, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(71, NULL, NULL, '4', '', NULL, NULL, ''),
(72, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(74, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(75, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(76, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(77, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(78, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(79, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(80, NULL, NULL, '4', '', NULL, NULL, ''),
(81, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(82, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(83, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(84, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(85, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(86, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(87, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(88, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(89, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(90, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(91, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(92, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(93, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(94, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(95, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(96, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(97, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(98, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(99, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(100, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(101, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(102, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(103, NULL, NULL, NULL, NULL, 'dwdwdw', NULL, NULL),
(104, NULL, NULL, '1', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usertitle`
--

CREATE TABLE `usertitle` (
  `usertitleid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `minposts` int(10) unsigned NOT NULL DEFAULT '0',
  `title` char(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`usertitleid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `usertitle`
--

INSERT INTO `usertitle` (`usertitleid`, `minposts`, `title`) VALUES
(1, 0, 'Junior Member'),
(2, 30, 'Member'),
(3, 100, 'Senior Member');

-- --------------------------------------------------------

--
-- Table structure for table `visitormessage`
--

CREATE TABLE `visitormessage` (
  `vmid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `postuserid` int(10) unsigned NOT NULL DEFAULT '0',
  `postusername` varchar(100) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `state` enum('visible','moderation','deleted') NOT NULL DEFAULT 'visible',
  `title` varchar(255) NOT NULL DEFAULT '',
  `pagetext` mediumtext,
  `ipaddress` int(10) unsigned NOT NULL DEFAULT '0',
  `allowsmilie` smallint(5) unsigned NOT NULL DEFAULT '0',
  `reportthreadid` int(10) unsigned NOT NULL DEFAULT '0',
  `messageread` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vmid`),
  KEY `postuserid` (`postuserid`,`userid`,`state`),
  KEY `userid` (`userid`,`dateline`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `visitormessage_hash`
--

CREATE TABLE `visitormessage_hash` (
  `postuserid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `dupehash` varchar(32) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `postuserid` (`postuserid`,`dupehash`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vsa_chatbox`
--

CREATE TABLE `vsa_chatbox` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `userip` varchar(20) NOT NULL,
  `dateline` int(10) NOT NULL,
  `message` text NOT NULL,
  `textprop` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `vsa_chatbox`
--

INSERT INTO `vsa_chatbox` (`id`, `userid`, `userip`, `dateline`, `message`, `textprop`) VALUES
(32, 104, '::1', 1447047704, 'lkj', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(31, 1, '::1', 1447047696, 'k;', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(30, 1, '::1', 1447047695, 'lk', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(29, 1, '::1', 1447047694, ',m', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(28, 1, '::1', 1447047666, ',kn', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(27, 104, '::1', 1447047660, 'tgi', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(26, 1, '::1', 1447047598, 'dgdgdfhfj', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(25, 1, '::1', 1447045955, ':confused:', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(24, 1, '::1', 1447045902, ':confused:', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(23, 1, '::1', 1447045887, 'kll', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(22, 104, '::1', 1447044614, 'dss', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(21, 1, '::1', 1447044579, '4t455', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(20, 104, '::1', 1447044505, 'csd', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(19, 104, '::1', 1447044338, 'ds', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(18, 104, '::1', 1447044335, 'knsd', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(33, 104, '::1', 1447047707, 'ikjp', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(34, 104, '::1', 1447047708, 'ijoihpih\\', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(35, 104, '::1', 1447047709, 'ojpj\\', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(36, 104, '::1', 1447047710, 'ho', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(37, 104, '::1', 1447047711, 'hohiu', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(38, 104, '::1', 1447047711, 'h', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(39, 104, '::1', 1447047712, 'h', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(40, 104, '::1', 1447047712, 'j', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(41, 104, '::1', 1447047713, 'j', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(42, 104, '::1', 1447047713, 'h', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(43, 104, '::1', 1447047713, 'j', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(44, 104, '::1', 1447047714, 'j', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(45, 104, '::1', 1447047715, 'h''', 'a:4:{s:5:"color";s:5:"Black";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(46, 1, '::1', 1447523753, 'heh', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(47, 1, '::1', 1447523754, 'yikti', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(48, 1, '::1', 1447523755, 'tut', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(49, 1, '::1', 1447523757, 'e', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(50, 1, '::1', 1447523760, '/', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(51, 1, '::1', 1447523763, 'lon', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(52, 1, '::1', 1447523799, 'drgrgegerg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(53, 1, '::1', 1447523801, 'ete', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(54, 1, '::1', 1447523802, 'wrw', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(55, 1, '::1', 1448122036, 'cxcxc', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(56, 1, '::1', 1448122049, ':D :p :p :p', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(57, 1, '::1', 1448122526, 'he dang bai tuyen /n', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(58, 1, '::1', 1448122534, 'he dang bai tuyen \\n', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(59, 1, '::1', 1448122545, 'he dang bai tuyen  \\t', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(60, 1, '::1', 1448122550, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(61, 1, '::1', 1448122551, 'g', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(62, 1, '::1', 1448122551, 'ggg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(63, 1, '::1', 1448122551, 'g', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(64, 1, '::1', 1448122552, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(65, 1, '::1', 1448122552, 'g', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(66, 1, '::1', 1448122552, 'g', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(67, 1, '::1', 1448122553, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(68, 1, '::1', 1448122553, 'g', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(69, 1, '::1', 1448122554, 'ggg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(70, 1, '::1', 1448122554, 'ggg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(71, 1, '::1', 1448122554, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(72, 1, '::1', 1448122555, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(73, 1, '::1', 1448122555, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(74, 1, '::1', 1448122556, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(75, 1, '::1', 1448122556, 'ggg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(76, 1, '::1', 1448122557, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(77, 1, '::1', 1448122557, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(78, 1, '::1', 1448122558, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(79, 1, '::1', 1448122558, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}'),
(80, 1, '::1', 1448122558, 'gg', 'a:4:{s:5:"color";s:3:"Red";s:4:"bold";s:0:"";s:6:"italic";s:0:"";s:9:"underline";s:0:"";}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
