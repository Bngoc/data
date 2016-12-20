-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 04:34 AM
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
-- Table structure for table `bbcode`
--

CREATE TABLE `bbcode` (
  `bbcodeid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `bbcodetag` varchar(200) NOT NULL DEFAULT '',
  `bbcodereplacement` mediumtext,
  `bbcodeexample` varchar(200) NOT NULL DEFAULT '',
  `bbcodeexplanation` mediumtext,
  `twoparams` smallint(6) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `buttonimage` varchar(250) NOT NULL DEFAULT '',
  `options` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`bbcodeid`),
  UNIQUE KEY `uniquetag` (`bbcodetag`,`twoparams`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bbcode_video`
--

CREATE TABLE `bbcode_video` (
  `providerid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tagoption` varchar(50) NOT NULL DEFAULT '',
  `provider` varchar(50) NOT NULL DEFAULT '',
  `url` varchar(100) NOT NULL DEFAULT '',
  `regex_url` varchar(254) NOT NULL DEFAULT '',
  `regex_scrape` varchar(254) NOT NULL DEFAULT '',
  `embed` mediumtext,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`providerid`),
  UNIQUE KEY `tagoption` (`tagoption`),
  KEY `priority` (`priority`),
  KEY `provider` (`provider`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `bbcode_video`
--

INSERT INTO `bbcode_video` (`providerid`, `tagoption`, `provider`, `url`, `regex_url`, `regex_scrape`, `embed`, `priority`) VALUES
(1, 'hulu', 'Hulu', 'http://www.hulu.com', 'http:\\/\\/www\\.hulu\\.com\\/watch\\/', '<link rel="video_src" href="http://www.hulu.com/embed/([^"]+)"', '<object class="restrain" type="application/x-shockwave-flash" width="512" height="296" data="http://www.hulu.com/embed/{vb:raw code}">\r\n	<param name="movie" value="http://www.hulu.com/embed/{vb:raw code}" />\r\n	<param name="wmode" value="{vb:raw wmode}" />\r\n	<!--[if IE 6]>\r\n	<embed width="512" height="296" type="application/x-shockwave-flash" src="http://www.hulu.com/embed/{vb:raw code}" />\r\n	<![endif]--></object>', 0),
(2, 'youtube', 'YouTube (Long)', 'http://www.youtube.com', 'https?:\\/\\/www\\.youtube\\.com\\/watch\\?.*v=([a-z0-9-_]+)', '', '<iframe class="restrain" title="YouTube video player" width="640" height="390" src="//www.youtube.com/embed/{vb:raw code}?wmode={vb:raw wmode}" frameborder="0"></iframe>', 0),
(3, 'youtube_share', 'YouTube (Short)', 'http://youtu.be', 'http:\\/\\/youtu\\.be\\/([a-z0-9\\-_]+)', '', '<iframe class="restrain" title="YouTube video player" width="640" height="390" src="//www.youtube.com/embed/{vb:raw code}?wmode={vb:raw wmode}" frameborder="0"></iframe>', 0),
(4, 'vimeo', 'Vimeo', 'http://www.vimeo.com', 'https?:\\/\\/(?:www\\.)?vimeo\\.com\\/([0-9]+)', '', '<object class="restrain" type="application/x-shockwave-flash" width="640" height="360" data="//vimeo.com/moogaloop.swf?clip_id={vb:raw code}">\r\n	<param name="movie" value="//vimeo.com/moogaloop.swf?clip_id={vb:raw code}" />\r\n	<param name="wmode" value="{vb:raw wmode}" />\r\n	<!--[if IE 6]>\r\n	<embed width="640" height="360" type="application/x-shockwave-flash" src="//vimeo.com/moogaloop.swf?clip_id={vb:raw code}" />\r\n	<![endif]--></object>', 0),
(5, 'dailymotion', 'Dailymotion', 'http://www.dailymotion.com', 'http:\\/\\/www\\.dailymotion\\.com(?:\\/[^\\/]+)?\\/video\\/([a-z0-9]+)', '', '<object class="restrain" type="application/x-shockwave-flash" width="420" height="339" data="http://www.dailymotion.com/swf/{vb:raw code}">\r\n	<param name="movie" value="http://www.dailymotion.com/swf/{vb:raw code}" />\r\n	<param name="wmode" value="{vb:raw wmode}" />\r\n	<!--[if IE 6]>\r\n	<embed width="420" height="339" type="application/x-shockwave-flash" src="http://www.dailymotion.com/swf/{vb:raw code}" />\r\n	<![endif]--></object>', 0),
(6, 'metacafe', 'Metacafe', 'http://www.metacafe.com', 'http:\\/\\/www\\.metacafe\\.com\\/watch\\/([0-9a-z_\\-\\/]+)', '', '<object class="restrain" type="application/x-shockwave-flash" width="400" height="345" data="http://www.metacafe.com/fplayer/{vb:raw code}.swf">\r\n	<param name="movie" value="http://www.metacafe.com/fplayer/{vb:raw code}.swf" />\r\n	<param name="wmode" value="{vb:raw wmode}" />\r\n	<!--[if IE 6]>\r\n	<embed width="400" height="345" type="application/x-shockwave-flash" src="http://www.metacafe.com/fplayer/{vb:raw code}.swf" />\r\n	<![endif]--></object>', 0),
(7, 'google', 'Google', 'http://video.google.com', 'http:\\/\\/video\\.google\\.com\\/videoplay\\?docid=([0-9\\-]+)', '', '<object class="restrain" type="application/x-shockwave-flash" width="400" height="326" data="http://video.google.com/googleplayer.swf?docid={vb:raw code}">\r\n	<param name="movie" value="http://video.google.com/googleplayer.swf?docid={vb:raw code}" />\r\n	<param name="wmode" value="{vb:raw wmode}" />\r\n	<!--[if IE 6]>\r\n	<embed width="400" height="326" type="application/x-shockwave-flash" src="http://video.google.com/googleplayer.swf?docid={vb:raw code}" />\r\n	<![endif]--></object>', 0),
(8, 'facebook', 'facebook', 'http://www.facebook.com', 'https?:\\/\\/www\\.facebook\\.com\\/(?:video\\/video|photo)\\.php\\?v=([0-9]+)', '', '<object class="restrain" type="application/x-shockwave-flash" width="576" height="432" data="//www.facebook.com/v/{vb:raw code}">\r\n	<param name="movie" value="//www.facebook.com/v/{vb:raw code}" />\r\n	<param name="wmode" value="{vb:raw wmode}" />\r\n	<!--[if IE 6]>\r\n	<embed width="576" height="432" type="application/x-shockwave-flash" src="//www.facebook.com/v/{vb:raw code}" />\r\n	<![endif]--></object>', 0);

-- --------------------------------------------------------

--
-- Table structure for table `block`
--

CREATE TABLE `block` (
  `blockid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blocktypeid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext,
  `url` varchar(100) NOT NULL DEFAULT '',
  `cachettl` int(11) NOT NULL DEFAULT '0',
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  `active` smallint(6) NOT NULL DEFAULT '0',
  `configcache` mediumblob,
  `product` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`blockid`),
  KEY `blocktypeid` (`blocktypeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `block`
--

INSERT INTO `block` (`blockid`, `blocktypeid`, `title`, `description`, `url`, `cachettl`, `displayorder`, `active`, `configcache`, `product`) VALUES
(2, 1, 'Fans page', '', '', 60, 2, 1, 0x613a333a7b733a31323a2268746d6c5f636f6e74656e74223b733a3338363a223c696672616d65207372633d22687474703a2f2f7777772e66616365626f6f6b2e636f6d2f706c7567696e732f6c696b65626f782e7068703f687265663d68747470733a2f2f7777772e66616365626f6f6b2e636f6d2f4e6f69446f436f416e685661436f456d26616d703b77696474683d32353026616d703b6865696768743d32393026616d703b636f6c6f72736368656d653d6c6967687426616d703b73686f775f66616365733d7472756526616d703b6865616465723d7472756526616d703b73747265616d3d66616c736526616d703b73686f775f626f726465723d7472756526616d703b61707049643d36313633363435353530363939313522207363726f6c6c696e673d226e6f22206672616d65626f726465723d223022207374796c653d22626f726465723a6e6f6e653b206f766572666c6f773a68696464656e3b2077696474683a32353070783b206865696768743a32393070783b2220616c6c6f777472616e73706172656e63793d2274727565223e3c2f696672616d653e223b733a31333a2268746d6c5f74656d706c617465223b733a31303a22626c6f636b5f68746d6c223b733a393a2268746d6c5f74797065223b733a343a2268746d6c223b7d, 'vbulletin'),
(3, 1, 'Yahoo há»— trá»£', '', '', 60, 3, 1, 0x613a333a7b733a31323a2268746d6c5f636f6e74656e74223b733a343333373a223c63656e7465723e0d0a3c7374796c6520747970653d22746578742f637373223e0d0a2e74686f696769616e6f6e6c696e65207b0d0a202020206261636b67726f756e643a206e6f6e6520726570656174207363726f6c6c2030203020234544454445443b0d0a20202020626f726465723a2031707820736f6c696420234444444444443b0d0a202020206d617267696e3a2035707820303b0d0a2020202070616464696e673a203370782032707820337078203270783b0d0a7d0d0a2e74686f696769616e6f6e6c696e65207370616e207b0d0a20202020666f6e742d73697a653a203970783b0d0a7d0d0a2e74686f696769616e6f6e6c696e652061207b0d0a2020202070616464696e672d6c6566743a20323570783b0d0a7d0d0a3c2f7374796c653e0d0a3c64697620636c6173733d2274686f696769616e6f6e6c696e65223e0d0a3c623e3c666f6e74207374796c653d226261636b67726f756e643a20236363303030303b666f6e742d73697a653a20313570783b70616464696e673a2031707820313870783b20626f726465723a2031707820736f6c696420233931393139313b20626f726465722d7261646975733a203370783b202d7765626b69742d626f726465722d7261646975733a203370783b202d6d6f7a2d626f726465722d7261646975733a203370783b202d6b68746d6c2d626f726465722d7261646975733a203370783b636f6c6f723a20234646464646463b223e48e1bb97205472e1bba3204ee1baa170205468e1babb2c2054c3a069204b686fe1baa36e3c2f666f6e743e3c2f623e3c62723e0d0a3c7370616e3e5468e1bb9d69206769616e204f6e6c696e65207468c6b0e1bb9d6e6720787579c3aa6e203c62723e31306830302d31326830302c2031336830302d31366830302c2031396830302d32316830303c2f7370616e3e3c2f62723e0d0a3c6120687265663d22796d7367723a73656e64696d3f7479745f732e325f6d797426616d703b6d3d567569206cc3b26e6720676869206c75c3b46e206ee1bb99692064756e67206dc3a02062e1baa16e2063e1baa76e2068e1bb97207472e1bba32c206b6869206e68e1baad6e20c49163206ee1bb99692064756e672068e1bb97207472e1bba3206de1bb9b69207472e1baa3206ce1bb9d69206ce1baa1692e204b68c3b46e672042757a7a212043e1baa36d20c6a16e223e3c696d67207372633d22687474703a2f2f6f70692e7961686f6f2e636f6d2f6f6e6c696e653f753d7479745f732e325f6d797426616d703b6d3d6726616d703b743d3226616d703b6c3d75732220626f726465723d2230223e3c2f613e3c62723e0d0a3c2f6469763e0d0a3c2f63656e7465723e0d0a3c63656e7465723e0d0a3c7374796c6520747970653d22746578742f637373223e0d0a2e74686f696769616e6f6e6c696e65207b0d0a202020206261636b67726f756e643a206e6f6e6520726570656174207363726f6c6c2030203020234544454445443b0d0a20202020626f726465723a2031707820736f6c696420234444444444443b0d0a202020206d617267696e3a2035707820303b0d0a2020202070616464696e673a203370782032707820337078203270783b0d0a7d0d0a2e74686f696769616e6f6e6c696e65207370616e207b0d0a20202020666f6e742d73697a653a203970783b0d0a7d0d0a2e74686f696769616e6f6e6c696e652061207b0d0a2020202070616464696e672d6c6566743a20323570783b0d0a7d0d0a3c2f7374796c653e0d0a3c64697620636c6173733d2274686f696769616e6f6e6c696e65223e0d0a3c623e3c666f6e74207374796c653d226261636b67726f756e643a20233030393930303b666f6e742d73697a653a20313570783b70616464696e673a2031707820313870783b20626f726465723a2031707820736f6c696420233931393139313b20626f726465722d7261646975733a203370783b202d7765626b69742d626f726465722d7261646975733a203370783b202d6d6f7a2d626f726465722d7261646975733a203370783b202d6b68746d6c2d626f726465722d7261646975733a203370783b636f6c6f723a20234646464646463b223e48e1bb97205472e1bba3204be1bbb920546875e1baad742c2042c3a16f204ce1bb97693c2f666f6e743e3c2f623e3c62723e0d0a3c7370616e3e5468e1bb9d69206769616e204f6e6c696e65207468c6b0e1bb9d6e6720787579c3aa6e203c62723e31306830302d31326830302c2031336830302d31366830302c2031396830302d32316830303c2f7370616e3e3c2f62723e0d0a3c6120687265663d22796d7367723a73656e64696d3f7479745f732e325f6d797426616d703b6d3d567569206cc3b26e6720676869206c75c3b46e206ee1bb99692064756e67206dc3a02062e1baa16e2063e1baa76e2068e1bb97207472e1bba32c206b6869206e68e1baad6e20c49163206ee1bb99692064756e672068e1bb97207472e1bba3206de1bb9b69207472e1baa3206ce1bb9d69206ce1baa1692e204b68c3b46e672042757a7a212043e1baa36d20c6a16e223e3c696d67207372633d22687474703a2f2f6f70692e7961686f6f2e636f6d2f6f6e6c696e653f753d7479745f732e325f6d797426616d703b6d3d6726616d703b743d3226616d703b6c3d75732220626f726465723d2230223e3c2f613e3c62723e0d0a3c2f6469763e0d0a3c2f63656e7465723e0d0a3c63656e7465723e0d0a3c7374796c6520747970653d22746578742f637373223e0d0a2e74686f696769616e6f6e6c696e65207b0d0a202020206261636b67726f756e643a206e6f6e6520726570656174207363726f6c6c2030203020234544454445443b0d0a20202020626f726465723a2031707820736f6c696420234444444444443b0d0a202020206d617267696e3a2035707820303b0d0a2020202070616464696e673a203370782032707820337078203270783b0d0a7d0d0a2e74686f696769616e6f6e6c696e65207370616e207b0d0a20202020666f6e742d73697a653a203970783b0d0a7d0d0a2e74686f696769616e6f6e6c696e652061207b0d0a2020202070616464696e672d6c6566743a20323570783b0d0a7d0d0a3c2f7374796c653e0d0a3c64697620636c6173733d2274686f696769616e6f6e6c696e65223e0d0a3c623e3c666f6e74207374796c653d226261636b67726f756e643a20233030303043443b666f6e742d73697a653a20313570783b70616464696e673a2031707820313870783b20626f726465723a2031707820736f6c696420233931393139313b20626f726465722d7261646975733a203370783b202d7765626b69742d626f726465722d7261646975733a203370783b202d6d6f7a2d626f726465722d7261646975733a203370783b202d6b68746d6c2d626f726465722d7261646975733a203370783b636f6c6f723a20234646464646463b223e4769c3a36920c490c3a170205468e1baaf63204dc483742047414d453c2f666f6e743e3c2f623e3c62723e0d0a3c7370616e3e5468e1bb9d69206769616e204f6e6c696e65207468c6b0e1bb9d6e6720787579c3aa6e203c62723e31306830302d31326830302c2031336830302d31366830302c2031396830302d32316830303c2f7370616e3e3c2f62723e0d0a3c6120687265663d22796d7367723a73656e64696d3f7479745f732e325f6d797426616d703b6d3d567569206cc3b26e6720676869206c75c3b46e206ee1bb99692064756e67206dc3a02062e1baa16e2063e1baa76e2068e1bb97207472e1bba32c206b6869206e68e1baad6e20c49163206ee1bb99692064756e672068e1bb97207472e1bba3206de1bb9b69207472e1baa3206ce1bb9d69206ce1baa1692e204b68c3b46e672042757a7a212043e1baa36d20c6a16e223e3c696d67207372633d22687474703a2f2f6f70692e7961686f6f2e636f6d2f6f6e6c696e653f753d7479745f732e325f6d797426616d703b6d3d6726616d703b743d3226616d703b6c3d75732220626f726465723d2230223e3c2f613e3c62723e0d0a3c2f6469763e0d0a3c2f63656e7465723e0d0a3c63656e7465723e0d0a3c7374796c6520747970653d22746578742f637373223e0d0a2e74686f696769616e6f6e6c696e65207b0d0a202020206261636b67726f756e643a206e6f6e6520726570656174207363726f6c6c2030203020234544454445443b0d0a20202020626f726465723a2031707820736f6c696420234444444444443b0d0a202020206d617267696e3a2035707820303b0d0a2020202070616464696e673a203370782032707820337078203270783b0d0a7d0d0a2e74686f696769616e6f6e6c696e65207370616e207b0d0a20202020666f6e742d73697a653a203970783b0d0a7d0d0a2e74686f696769616e6f6e6c696e652061207b0d0a2020202070616464696e672d6c6566743a20323570783b0d0a7d0d0a3c2f7374796c653e0d0a3c64697620636c6173733d2274686f696769616e6f6e6c696e65223e0d0a3c623e3c666f6e74207374796c653d226261636b67726f756e643a20234646303046463b666f6e742d73697a653a20313570783b70616464696e673a2031707820313870783b20626f726465723a2031707820736f6c696420233931393139313b20626f726465722d7261646975733a203370783b202d7765626b69742d626f726465722d7261646975733a203370783b202d6d6f7a2d626f726465722d7261646975733a203370783b202d6b68746d6c2d626f726465722d7261646975733a203370783b636f6c6f723a20234646464646463b223e474d204556454e542047414d453c2f666f6e743e3c2f623e3c62723e0d0a3c7370616e3e5468e1bb9d69206769616e204f6e6c696e65207468c6b0e1bb9d6e6720787579c3aa6e203c62723e31306830302d31326830302c2031336830302d31366830302c2031396830302d32316830303c2f7370616e3e3c2f62723e0d0a3c6120687265663d22796d7367723a73656e64696d3f7479745f732e325f6d797426616d703b6d3d567569206cc3b26e6720676869206c75c3b46e206ee1bb99692064756e67206dc3a02062e1baa16e2063e1baa76e2068e1bb97207472e1bba32c206b6869206e68e1baad6e20c49163206ee1bb99692064756e672068e1bb97207472e1bba3206de1bb9b69207472e1baa3206ce1bb9d69206ce1baa1692e204b68c3b46e672042757a7a212043e1baa36d20c6a16e223e3c696d67207372633d22687474703a2f2f6f70692e7961686f6f2e636f6d2f6f6e6c696e653f753d7479745f732e325f6d797426616d703b6d3d6726616d703b743d3226616d703b6c3d75732220626f726465723d2230223e3c2f613e3c62723e0d0a3c2f6469763e0d0a3c2f63656e7465723e0d0a3c623e3c666f6e74207374796c653d226261636b67726f756e643a20236363303030303b666f6e742d73697a653a20313270783b70616464696e673a20317078203370783b20626f726465723a2031707820736f6c696420233931393139313b20626f726465722d7261646975733a203370783b202d7765626b69742d626f726465722d7261646975733a203370783b202d6d6f7a2d626f726465722d7261646975733a203370783b202d6b68746d6c2d626f726465722d7261646975733a203370783b636f6c6f723a20234646464646463b223e4cc6b07520c3bd3a3c2f666f6e743e3c2f623e3c62723e203c623e567569206cc3b26e6720676869206c75c3b46e206ee1bb99692064756e67206dc3a02062e1baa16e2063e1baa76e2068e1bb97207472e1bba32c206b6869206e68e1baad6e20c49163206ee1bb99692064756e672068e1bb97207472e1bba3206de1bb9b69207472e1baa3206ce1bb9d69206ce1baa1692e204b68c3b46e672042757a7a212043e1baa36d20c6a16e3c2f62723e3c2f7374726f6e673e223b733a31333a2268746d6c5f74656d706c617465223b733a31303a22626c6f636b5f68746d6c223b733a393a2268746d6c5f74797065223b733a343a2268746d6c223b7d, 'vbulletin');

-- --------------------------------------------------------

--
-- Table structure for table `blockconfig`
--

CREATE TABLE `blockconfig` (
  `blockid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` mediumtext,
  `serialized` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blockid`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `blockconfig`
--

INSERT INTO `blockconfig` (`blockid`, `name`, `value`, `serialized`) VALUES
(2, 'html_type', 'html', 0),
(2, 'html_content', '<iframe src="http://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/NoiDoCoAnhVaCoEm&amp;width=250&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=616364555069915" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:290px;" allowtransparency="true"></iframe>', 0),
(2, 'html_template', 'block_html', 0),
(3, 'html_type', 'html', 0),
(3, 'html_content', '<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #cc0000;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">Há»— Trá»£ Náº¡p Tháº», TÃ i Khoáº£n</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #009900;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">Há»— Trá»£ Ká»¹ Thuáº­t, BÃ¡o Lá»—i</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #0000CD;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">GiÃ£i ÄÃ¡p Tháº¯c MÄƒt GAME</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #FF00FF;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">GM EVENT GAME</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<b><font style="background: #cc0000;font-size: 12px;padding: 1px 3px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">LÆ°u Ã½:</font></b><br> <b>Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n</br></strong>', 0),
(3, 'html_template', 'block_html', 0);

-- --------------------------------------------------------

--
-- Table structure for table `blocktype`
--

CREATE TABLE `blocktype` (
  `blocktypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productid` varchar(25) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext,
  `allowcache` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`blocktypeid`),
  UNIQUE KEY `name` (`name`),
  KEY `productid` (`productid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `blocktype`
--

INSERT INTO `blocktype` (`blocktypeid`, `productid`, `name`, `title`, `description`, `allowcache`) VALUES
(1, '', 'html', 'blocktype_html', '', 1),
(2, '', 'newposts', 'blocktype_newposts', '', 1),
(3, '', 'sgdiscussions', 'blocktype_sgdiscussions', '', 1),
(4, '', 'tagcloud', 'blocktype_tagcloud', '', 1),
(5, '', 'threads', 'blocktype_threads', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookmarksite`
--

CREATE TABLE `bookmarksite` (
  `bookmarksiteid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL DEFAULT '',
  `iconpath` varchar(250) NOT NULL DEFAULT '',
  `active` smallint(5) unsigned NOT NULL DEFAULT '0',
  `displayorder` int(10) unsigned NOT NULL DEFAULT '0',
  `url` varchar(250) NOT NULL DEFAULT '',
  `utf8encode` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`bookmarksiteid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bookmarksite`
--

INSERT INTO `bookmarksite` (`bookmarksiteid`, `title`, `iconpath`, `active`, `displayorder`, `url`, `utf8encode`) VALUES
(1, 'Digg', 'bookmarksite_digg.gif', 1, 10, 'http://digg.com/submit?phase=2&amp;url={URL}&amp;title={TITLE}', 0),
(2, 'del.icio.us', 'bookmarksite_delicious.gif', 1, 20, 'http://del.icio.us/post?url={URL}&amp;title={TITLE}', 0),
(3, 'StumbleUpon', 'bookmarksite_stumbleupon.gif', 1, 30, 'http://www.stumbleupon.com/submit?url={URL}&amp;title={TITLE}', 0),
(4, 'Google', 'bookmarksite_google.gif', 1, 40, 'http://www.google.com/bookmarks/mark?op=edit&amp;output=popup&amp;bkmk={URL}&amp;title={TITLE}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `cacheid` varbinary(64) NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `locktime` int(10) unsigned NOT NULL,
  `serialized` enum('0','1') NOT NULL DEFAULT '0',
  `data` mediumtext,
  PRIMARY KEY (`cacheid`),
  KEY `expires` (`expires`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`cacheid`, `expires`, `created`, `locktime`, `serialized`, `data`) VALUES
('vb_types.types', 0, 1446912230, 0, '1', 'a:19:{i:0;a:7:{s:9:"classtype";s:7:"package";s:6:"typeid";s:1:"1";s:9:"packageid";s:1:"1";s:9:"productid";s:9:"vbulletin";s:7:"enabled";s:1:"1";s:5:"class";s:7:"vBForum";s:12:"isaggregator";s:2:"-1";}i:1;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"8";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:5:"Album";s:12:"isaggregator";s:1:"0";}i:2;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"4";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:12:"Announcement";s:12:"isaggregator";s:1:"0";}i:3;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"14";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:8:"Calendar";s:12:"isaggregator";s:1:"0";}i:4;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"13";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:5:"Event";s:12:"isaggregator";s:1:"0";}i:5;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"3";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:5:"Forum";s:12:"isaggregator";s:1:"0";}i:6;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"16";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:10:"Infraction";s:12:"isaggregator";s:1:"0";}i:7;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"9";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:7:"Picture";s:12:"isaggregator";s:1:"0";}i:8;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"10";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:14:"PictureComment";s:12:"isaggregator";s:1:"0";}i:9;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"1";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:4:"Post";s:12:"isaggregator";s:1:"0";}i:10;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"15";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:14:"PrivateMessage";s:12:"isaggregator";s:1:"0";}i:11;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"17";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:9:"Signature";s:12:"isaggregator";s:1:"0";}i:12;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"7";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:11:"SocialGroup";s:12:"isaggregator";s:1:"0";}i:13;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"6";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:21:"SocialGroupDiscussion";s:12:"isaggregator";s:1:"0";}i:14;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"5";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:18:"SocialGroupMessage";s:12:"isaggregator";s:1:"0";}i:15;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:1:"2";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:6:"Thread";s:12:"isaggregator";s:1:"0";}i:16;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"12";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:4:"User";s:12:"isaggregator";s:1:"0";}i:17;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"18";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:8:"UserNote";s:12:"isaggregator";s:1:"0";}i:18;a:7:{s:9:"classtype";s:11:"contenttype";s:6:"typeid";s:2:"11";s:9:"packageid";s:1:"1";s:9:"productid";s:1:"1";s:7:"enabled";s:1:"1";s:5:"class";s:14:"VisitorMessage";s:12:"isaggregator";s:1:"0";}}'),
('forumblock.b1582c14c5137a9c57da3476148c2af1', 1482164592, 1482160992, 0, '0', '<iframe src="http://www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/NoiDoCoAnhVaCoEm&amp;width=250&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=616364555069915" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:290px;" allowtransparency="true"></iframe>'),
('forumblock.70f2cec85a10c46be012535429205fbb', 1482164592, 1482160992, 0, '0', '<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #cc0000;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">Há»— Trá»£ Náº¡p Tháº», TÃ i Khoáº£n</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #009900;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">Há»— Trá»£ Ká»¹ Thuáº­t, BÃ¡o Lá»—i</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #0000CD;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">GiÃ£i ÄÃ¡p Tháº¯c MÄƒt GAME</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<center>\r\n<style type="text/css">\r\n.thoigianonline {\r\n    background: none repeat scroll 0 0 #EDEDED;\r\n    border: 1px solid #DDDDDD;\r\n    margin: 5px 0;\r\n    padding: 3px 2px 3px 2px;\r\n}\r\n.thoigianonline span {\r\n    font-size: 9px;\r\n}\r\n.thoigianonline a {\r\n    padding-left: 25px;\r\n}\r\n</style>\r\n<div class="thoigianonline">\r\n<b><font style="background: #FF00FF;font-size: 15px;padding: 1px 18px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">GM EVENT GAME</font></b><br>\r\n<span>Thá»i gian Online thÆ°á»ng xuyÃªn <br>10h00-12h00, 13h00-16h00, 19h00-21h00</span></br>\r\n<a href="ymsgr:sendim?tyt_s.2_myt&amp;m=Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n"><img src="http://opi.yahoo.com/online?u=tyt_s.2_myt&amp;m=g&amp;t=2&amp;l=us" border="0"></a><br>\r\n</div>\r\n</center>\r\n<b><font style="background: #cc0000;font-size: 12px;padding: 1px 3px; border: 1px solid #919191; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; -khtml-border-radius: 3px;color: #FFFFFF;">LÆ°u Ã½:</font></b><br> <b>Vui lÃ²ng ghi luÃ´n ná»™i dung mÃ  báº¡n cáº§n há»— trá»£, khi nháº­n Ä‘c ná»™i dung há»— trá»£ má»›i tráº£ lá»i láº¡i. KhÃ´ng Buzz! Cáº£m Æ¡n</br></strong>');

-- --------------------------------------------------------

--
-- Table structure for table `cacheevent`
--

CREATE TABLE `cacheevent` (
  `cacheid` varbinary(64) NOT NULL,
  `event` varbinary(50) NOT NULL,
  PRIMARY KEY (`cacheid`,`event`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cacheevent`
--

INSERT INTO `cacheevent` (`cacheid`, `event`) VALUES
('vb_types.types', 'vb_types.contenttype_updated'),
('vb_types.types', 'vb_types.package_updated'),
('vb_types.types', 'vb_types.type_updated');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `calendarid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  `displayorder` smallint(6) NOT NULL DEFAULT '0',
  `neweventemail` text,
  `moderatenew` smallint(6) NOT NULL DEFAULT '0',
  `startofweek` smallint(6) NOT NULL DEFAULT '0',
  `options` int(10) unsigned NOT NULL DEFAULT '0',
  `cutoff` smallint(5) unsigned NOT NULL DEFAULT '0',
  `eventcount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `birthdaycount` smallint(5) unsigned NOT NULL DEFAULT '0',
  `startyear` smallint(5) unsigned NOT NULL DEFAULT '2000',
  `endyear` smallint(5) unsigned NOT NULL DEFAULT '2006',
  `holidays` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`calendarid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `calendar`
--

INSERT INTO `calendar` (`calendarid`, `title`, `description`, `displayorder`, `neweventemail`, `moderatenew`, `startofweek`, `options`, `cutoff`, `eventcount`, `birthdaycount`, `startyear`, `endyear`, `holidays`) VALUES
(1, 'Default Calendar', '', 1, 'a:0:{}', 0, 1, 631, 40, 4, 4, 2011, 2017, 0);

-- --------------------------------------------------------

--
-- Table structure for table `calendarcustomfield`
--

CREATE TABLE `calendarcustomfield` (
  `calendarcustomfieldid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `calendarid` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext,
  `options` mediumtext,
  `allowentry` smallint(6) NOT NULL DEFAULT '1',
  `required` smallint(6) NOT NULL DEFAULT '0',
  `length` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`calendarcustomfieldid`),
  KEY `calendarid` (`calendarid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `calendarmoderator`
--

CREATE TABLE `calendarmoderator` (
  `calendarmoderatorid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `calendarid` int(10) unsigned NOT NULL DEFAULT '0',
  `neweventemail` smallint(6) NOT NULL DEFAULT '0',
  `permissions` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`calendarmoderatorid`),
  KEY `userid` (`userid`,`calendarid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `calendarpermission`
--

CREATE TABLE `calendarpermission` (
  `calendarpermissionid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `calendarid` int(10) unsigned NOT NULL DEFAULT '0',
  `usergroupid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `calendarpermissions` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`calendarpermissionid`),
  KEY `calendarid` (`calendarid`),
  KEY `usergroupid` (`usergroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contentpriority`
--

CREATE TABLE `contentpriority` (
  `contenttypeid` varchar(20) NOT NULL,
  `sourceid` int(10) unsigned NOT NULL,
  `prioritylevel` double(2,1) unsigned NOT NULL,
  PRIMARY KEY (`contenttypeid`,`sourceid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contentread`
--

CREATE TABLE `contentread` (
  `readid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contenttypeid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `contentid` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `readtype` enum('read','view','other') NOT NULL DEFAULT 'other',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `ipid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`contenttypeid`,`contentid`,`userid`,`readtype`),
  UNIQUE KEY `readid` (`readid`),
  KEY `utd` (`userid`,`contenttypeid`,`dateline`),
  KEY `tcd` (`contenttypeid`,`contentid`,`dateline`),
  KEY `dateline` (`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=192 ;

-- --------------------------------------------------------

--
-- Table structure for table `contenttype`
--

CREATE TABLE `contenttype` (
  `contenttypeid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varbinary(50) NOT NULL,
  `packageid` int(10) unsigned NOT NULL,
  `canplace` enum('0','1') NOT NULL DEFAULT '0',
  `cansearch` enum('0','1') NOT NULL DEFAULT '0',
  `cantag` enum('0','1') DEFAULT '0',
  `canattach` enum('0','1') DEFAULT '0',
  `isaggregator` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`contenttypeid`),
  UNIQUE KEY `packageclass` (`packageid`,`class`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `contenttype`
--

INSERT INTO `contenttype` (`contenttypeid`, `class`, `packageid`, `canplace`, `cansearch`, `cantag`, `canattach`, `isaggregator`) VALUES
(1, 'Post', 1, '0', '1', '0', '1', '0'),
(2, 'Thread', 1, '0', '0', '1', '0', '0'),
(3, 'Forum', 1, '0', '1', '0', '0', '0'),
(4, 'Announcement', 1, '0', '0', '0', '0', '0'),
(5, 'SocialGroupMessage', 1, '0', '1', '0', '0', '0'),
(6, 'SocialGroupDiscussion', 1, '0', '0', '0', '0', '0'),
(7, 'SocialGroup', 1, '0', '1', '0', '1', '0'),
(8, 'Album', 1, '0', '0', '0', '1', '0'),
(9, 'Picture', 1, '0', '0', '0', '0', '0'),
(10, 'PictureComment', 1, '0', '0', '0', '0', '0'),
(11, 'VisitorMessage', 1, '0', '1', '0', '0', '0'),
(12, 'User', 1, '0', '0', '0', '0', '0'),
(13, 'Event', 1, '0', '0', '0', '0', '0'),
(14, 'Calendar', 1, '0', '0', '0', '0', '0'),
(15, 'PrivateMessage', 1, '0', '0', '0', '0', '0'),
(16, 'Infraction', 1, '0', '0', '0', '0', '0'),
(17, 'Signature', 1, '0', '0', '0', '0', '0'),
(18, 'UserNote', 1, '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cpsession`
--

CREATE TABLE `cpsession` (
  `userid` int(10) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(32) NOT NULL DEFAULT '',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`userid`,`hash`)
) ENGINE=MEMORY DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
