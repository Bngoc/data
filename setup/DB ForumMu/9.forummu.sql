-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 04:38 AM
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
-- Table structure for table `subscribediscussion`
--

CREATE TABLE `subscribediscussion` (
  `subscribediscussionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `discussionid` int(10) unsigned NOT NULL,
  `emailupdate` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscribediscussionid`),
  UNIQUE KEY `userdiscussion` (`userid`,`discussionid`),
  KEY `discussionid` (`discussionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscribeevent`
--

CREATE TABLE `subscribeevent` (
  `subscribeeventid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `eventid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastreminder` int(10) unsigned NOT NULL DEFAULT '0',
  `reminder` int(10) unsigned NOT NULL DEFAULT '3600',
  PRIMARY KEY (`subscribeeventid`),
  UNIQUE KEY `subindex` (`userid`,`eventid`),
  KEY `eventid` (`eventid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscribeforum`
--

CREATE TABLE `subscribeforum` (
  `subscribeforumid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `forumid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `emailupdate` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscribeforumid`),
  UNIQUE KEY `subindex` (`userid`,`forumid`),
  KEY `forumid` (`forumid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `subscribeforum`
--

INSERT INTO `subscribeforum` (`subscribeforumid`, `userid`, `forumid`, `emailupdate`) VALUES
(1, 1, 16, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribegroup`
--

CREATE TABLE `subscribegroup` (
  `subscribegroupid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `groupid` int(10) unsigned NOT NULL,
  `emailupdate` enum('daily','weekly','none') NOT NULL DEFAULT 'none',
  PRIMARY KEY (`subscribegroupid`),
  UNIQUE KEY `usergroup` (`userid`,`groupid`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscribethread`
--

CREATE TABLE `subscribethread` (
  `subscribethreadid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  `emailupdate` smallint(5) unsigned NOT NULL DEFAULT '0',
  `folderid` int(10) unsigned NOT NULL DEFAULT '0',
  `canview` smallint(5) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`subscribethreadid`),
  UNIQUE KEY `threadid` (`threadid`,`userid`),
  KEY `userid` (`userid`,`folderid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `subscriptionid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `varname` varchar(100) NOT NULL DEFAULT '',
  `cost` mediumtext,
  `forums` mediumtext,
  `nusergroupid` smallint(6) NOT NULL DEFAULT '0',
  `membergroupids` varchar(255) NOT NULL DEFAULT '',
  `active` smallint(5) unsigned NOT NULL DEFAULT '0',
  `options` int(10) unsigned NOT NULL DEFAULT '0',
  `displayorder` smallint(5) unsigned NOT NULL DEFAULT '1',
  `adminoptions` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscriptionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptionlog`
--

CREATE TABLE `subscriptionlog` (
  `subscriptionlogid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `subscriptionid` smallint(6) NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `pusergroupid` smallint(6) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `expirydate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscriptionlogid`),
  KEY `userid` (`userid`,`subscriptionid`),
  KEY `subscriptionid` (`subscriptionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptionpermission`
--

CREATE TABLE `subscriptionpermission` (
  `subscriptionpermissionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `subscriptionid` int(10) unsigned NOT NULL DEFAULT '0',
  `usergroupid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscriptionpermissionid`),
  UNIQUE KEY `subscriptionid` (`subscriptionid`,`usergroupid`),
  KEY `usergroupid` (`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tachyforumcounter`
--

CREATE TABLE `tachyforumcounter` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `forumid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `threadcount` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `replycount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`forumid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tachyforumpost`
--

CREATE TABLE `tachyforumpost` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `forumid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastposter` varchar(100) NOT NULL DEFAULT '',
  `lastposterid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpostid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastthread` varchar(250) NOT NULL DEFAULT '',
  `lastthreadid` int(10) unsigned NOT NULL DEFAULT '0',
  `lasticonid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `lastprefixid` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`userid`,`forumid`),
  KEY `forumid` (`forumid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tachythreadcounter`
--

CREATE TABLE `tachythreadcounter` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  `replycount` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`threadid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tachythreadpost`
--

CREATE TABLE `tachythreadpost` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `threadid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
  `lastposter` varchar(100) NOT NULL DEFAULT '',
  `lastposterid` int(10) unsigned NOT NULL DEFAULT '0',
  `lastpostid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`threadid`),
  KEY `threadid` (`threadid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
