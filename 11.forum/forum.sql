-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2015 at 01:33 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `forums`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `nick` varchar(200) NOT NULL,
  `e-hide` varchar(20) NOT NULL DEFAULT 'off',
  `acl` tinyint(4) DEFAULT NULL,
  `avatar` text NOT NULL,
  `ban` int(4) NOT NULL,
  `numlogin` tinyint(10) NOT NULL,
  `lastdate` date NOT NULL,
  `more` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1446395461 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `nick`, `e-hide`, `acl`, `avatar`, `ban`, `numlogin`, `lastdate`, `more`) VALUES
(1446395457, 'bqngoc119', '2e93501e2e07f4c9d775d85235ea6611', 'ngoctbhy@gmail.com', '', 'off', 1, '', 0, 1, '2015-11-06', ''),
(1446395458, 'bqngoc', '2e93501e2e07f4c9d775d85235ea6611', 'ngoctbhy@gmail.com', '', 'off', 3, '', 0, 1, '2015-11-06', ''),
(1446395459, 'bqngoc1', '2e93501e2e07f4c9d775d85235ea6611', 'ngoctbhy@gmail.com', '', 'off', 2, '', 0, 1, '2015-11-06', ''),
(1446395460, 'bqngoc11', '2e93501e2e07f4c9d775d85235ea6611', 'ngoctbhy@gmail.com', '', 'off', 4, '', 0, 1, '2015-11-06', '');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `acl` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `acl`) VALUES
(1, 'Lục địa mu', 1),
(2, 'Quy&#7873;n L&#7921;c Bóng Ðêm', 1),
(3, 'Cý Dân L&#7909;c Ð&#7883;a MU', 1),
(4, 'MU và Cu&#7897;c S&#7889;ng', 1),
(5, 'Khu V&#7921;c dành cho bài vi&#7871;t b&#7883; xóa b&#7887;', 1),
(6, 'T&#236;nh h&#236;nh di&#7877;n ðàn', 1);

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

CREATE TABLE IF NOT EXISTS `forums` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `cat_id` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `acl` tinyint(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`id`, `cat_id`, `name`, `description`, `acl`) VALUES
(1, 1, 'Thông báo', 'Nh&#7919;ng thông báo m&#7899;i nh&#7845;t c&#7911;a Mu t&#7841;i ðây', 1),
(2, 1, 'Sự kiện Mu Online Việt Nam', 'Các sự kiện nguyên bản Game MU Online và các sự kiện do chính các ðiều hành game phát triển và tổ chức cho các game thủ\r\n', 1),
(3, 2, 'Chiến Binh', 'Là hi&#7879;n thân c&#7911;a s&#7913;c m&#7841;nh và quy&#7873;n l&#7921;c. Trong nh&#7919;ng tr&#7853;n ðánh càn, h&#7885; có th&#7875; gi&#7871;t ch&#7871;t nh&#7919;ng d&#242;ng nhân v&#7853;t khác...', 1),
(4, 1, 'Hướng dẫn | Kinh nghiệm chơi', 'Các bài vi&#7871;t hý&#7899;ng d&#7851;n cách chõi game, các th&#7911; thu&#7853;t ð&#7875; luy&#7879;n nhân v&#7853;t m&#7897;t cách t&#7889;t nh&#7845;t.', 1),
(5, 1, 'Báo L&#7895;i | H&#7887;i ðáp', 'Thông báo các l&#7895;i v&#7873; Game, bugs, lagg, Hack t&#7841;i ðây.', 1),
(6, 1, 'Ðóng góp | Ð&#7873; xu&#7845;t', 'Nh&#7919;ng &#253; ki&#7871;n ðóng góp ð&#7873; xu&#7845;t ðý&#7907;c BQT lýu &#253; và cân nh&#7855;c.', 1),
(7, 1, 'T&#7889; cáo gian l&#7853;n', 'Phong Th&#7847;n B&#7843;ng nh&#7919;ng game th&#7911; sai trái ðý&#7907;c c&#7853;p nh&#7853;t danh sách t&#7841;i ðây', 1),
(8, 2, 'Phù Th&#7911;y', 'Có th&#7875; dùng các phép thu&#7853;t ð&#7875; t&#7845;n công k&#7867; thù. Ngoài ra, anh c&#242;n ta có th&#7875; yêu c&#7847;u s&#7921; h&#7895; tr&#7907; t&#7915; nh&#7919;ng linh h&#7891;n bí &#7849;n', 1),
(9, 2, 'Tiên N&#7919;', 'Là d&#242;ng t&#7897;c ð&#7847;u tiên c&#7911;a MU trý&#7899;c c&#7843; con ngý&#7901;i và yêu tinh. M&#7897;t Tiên n&#7919; &#7903; Noria ð&#227; truy&#7873;n l&#7841;i r&#7857;ng h&#7885; có m&#7897;t v&#7869; ð&#7865;p huy&#7873;n &#7843;o và duyên dán', 1),
(10, 2, 'Ð&#7845;u S&#297;', 'Ð&#7845;u S&#297; có th&#7875; s&#7917; d&#7909;ng m&#7897;t lo&#7841;t các phép thu&#7853;t, k&#7929; nãng và áo giáp mà Chi&#7871;n Binh và Phù Th&#7911;y thý&#7901;ng dùng..', 1),
(11, 2, 'Chúa T&#7875;', 'H&#7885; là d&#242;ng d&#245;i c&#7911;a các nhà l&#227;nh ð&#7841;o, ngý&#7901;i ð&#227; ch&#7881; huy nh&#7919;ng ð&#7897;i quân hùng h&#7853;u...', 1),
(12, 2, 'Thu&#7853;t S&#297;', 'M&#7885;i ngý&#7901;i có th&#7875; nh&#7853;n di&#7879;n Summoner qua v&#7867; b&#7873; ngoài quy&#7871;n r&#361; ð&#7847;y mê ho&#7863;c, s&#7921; l&#7841;nh lùng bí &#7849;n và thanh g&#7853;y phép nh&#7885;n nhý giáo luôn c&#7847;m trên tay...', 1),
(13, 2, 'Chi&#7871;n Binh Thép', 'Rage Fighter thu&#7897;c d&#242;ng t&#7897;c hoàng gia. Là anh hùng th&#7913; 7 c&#7911;a L&#7909;c ð&#7883;a MU...', 1),
(14, 3, 'Th&#7843;o lu&#7853;n chung', 'Nghiêm c&#7845;m: Post bài vi&#7871;t v&#7873; Hack, m&#7845;t ð&#7891; t&#7841;i ðây', 1),
(15, 3, 'H&#7897;i h&#7885;p Offline | Liên hoan', 'Nõi h&#7897;i t&#7909; nh&#7919;ng Thành Viên tham gia Game Mu H&#227;y nhanh tay Ðãng K&#253; n&#7871;u b&#7841;n mu&#7889;n làm l&#227;nh ð&#7841;o c&#7911;a 1 Club Bang H&#7897;i...', 1),
(16, 3, 'Cý dân | Bang h&#7897;i | Liên Minh', 'H&#227;y ch&#7913;ng minh b&#7841;n là ch&#7911; Bang H&#7897;i th&#7889;ng nh&#7845;t 1 l&#7909;c ð&#7883;a MU', 1),
(17, 3, 'Mua bán | Giao d&#7883;ch Account', 'T&#7841;i ðây các b&#7841;n có th&#7875; giao dich mua bán thông qua Ði&#7873;u Hành Game.', 1),
(18, 4, 'Quán bar Lorencia', 'Nõi giao lýu, chém gó. Hay chia s&#7869; nh&#7919;ng c&#7843;m xúc c&#7911;a b&#7841;n!', 1),
(19, 4, 'Gi&#7843;i trí âm nh&#7841;c | Video clip | Phim Online', 'Âm Nh&#7841;c, Video Clip Game, Phim Online... Nghiêm c&#7845;p Post nh&#7919;ng Video, sai quy ð&#7883;nh c&#7911;a Di&#7877;n Ðàn', 1),
(20, 4, 'Thý vi&#7879;n &#7843;nh', '', 1),
(21, 4, 'C&#7843;m ngh&#297; - Chia s&#7867; v&#7873; Mu online', 'H&#227;y chia s&#7867; nh&#7919;ng c&#7843;m ngh&#297; c&#7911;a b&#7841;n v&#7873; Mu m&#236;nh nhé.', 1),
(22, 4, 'Sýu t&#7847;m và sáng tác', 'Nh&#7919;ng bài vãn thõ, sáng tác ðý&#7907;c m&#7885;i ngý&#7901;i yêu thích.', 1),
(23, 5, 'Thùng rác', 'H&#227;y t&#236;m l&#7841;i bài vi&#7871;t c&#7911;a b&#7841;n khi b&#7883; xóa b&#7887; kh&#7887;i Box sai quy ð&#7883;nh nhé...', 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `topic_id` tinyint(4) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `date`, `user_id`, `topic_id`, `subject`, `body`) VALUES
(1, '2015-09-20 12:35:47', 1, 1, 'tra noi bai 1', '[i] Copy Copy\n Delete Delete\n8\n2014-07-09 21:13:24\n1\n11\nCách c&#7897;ng ði&#7875;m DL\nWith selected: Check All With selected: Change Change Delete Delete Export Export \n[/i]\nQuery results operations\nPrint view Print vi[u]ew  Print view (with full texts) Print view (with full texts)  Export Export  Display chart Display chart  Create view Create viewwwww[/u]'),
(7, '2015-09-21 16:18:13', 1, 3, 'fsf', 'fsfs'),
(11, '2015-09-21 16:34:53', 2, 4, 'rwr', 'rwr'),
(12, '2015-09-21 16:57:30', 1, 1, 'etget', 'etet'),
(15, '2015-09-22 21:09:32', 1, 5, 'Cách c&#7897;ng ði&#7875;m cho DK', 'ýeww'),
(16, '2015-09-22 21:10:34', 1, 6, 'C&#7897;ng ði&#7875;m DW', 'ewe'),
(18, '2015-09-22 21:13:25', 1, 8, 'Cách c&#7897;ng ði&#7875;m DL', 's&#7847;'),
(19, '2015-09-22 21:26:44', 1, 9, '[Hý&#7899;ng D&#7851;n] Cách t&#7841;o qu&#7841; tinh và chi&#7871;n m&#227; cho DL', ' Cách t&#7841;o qu&#7841; tinh và chi&#7871;n m&#227; cho DL\r\nCách ép Qu&#7841; Tinh\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n- Ð&#7871;n Lorencia (t&#7885;a ð&#7897; 122-110), t&#236;m g&#7863;p NPC tên là Trainer, nói chuy&#7879;n v&#7899;i NPC ðó, ch&#7885;n ch&#7913;c nãng Tái t&#7841;o linh h&#7891;n.\r\n- B&#7887; vào c&#7917;a s&#7893; : 1 Ng&#7885;c Chaos + 1 Ng&#7885;c Creation + 1 Linh h&#7891;n qu&#7841; tinh + 2 Ng&#7885;c Soul + 2 Ng&#7885;c Bless\r\n- T&#7881; l&#7879; thành công là 60%. Nh&#7845;n k&#7871;t h&#7907;p\r\n- Th&#7845;t b&#7841;i s&#7869; m&#7845;t h&#7871;t nguyên li&#7879;u.\r\nCách ép Chi&#7871;n M&#227;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n- Ð&#7871;n Lorencia (t&#7885;a ð&#7897; 122-110), t&#236;m g&#7863;p NPC tên là Trainer, nói chuy&#7879;n v&#7899;i NPC ðó, ch&#7885;n ch&#7913;c nãng Tái t&#7841;o linh h&#7891;n.\r\n- B&#7887; vào c&#7917;a s&#7893; : 1 Ng&#7885;c Chaos + 1 Ng&#7885;c Creation + 1 Linh h&#7891;n chi&#7871;n m&#227; + 5 Ng&#7885;c Soul + 5 Ng&#7885;c Bless + 5 tri&#7879;u zen.\r\n- T&#7881; l&#7879; thành công là 60%. Nh&#7845;n k&#7871;t h&#7907;p.\r\n- Th&#7845;t b&#7841;i s&#7869; m&#7845;t h&#7871;t nguyên li&#7879;u.\r\nChúc các b&#7841;n s&#7899;m có ð&#7891; ngon^^.'),
(20, '2015-09-22 21:28:45', 1, 10, '[Hý&#7899;ng D&#7851;n] Ch&#7909;p &#7843;nh màn h&#236;nh máy tính', ' Ch&#7909;p &#7843;nh màn h&#236;nh máy tính\r\nXin hý&#7899;ng d&#7851;n các b&#7841;n cách ch&#7909;p h&#236;nh ngoài Desktop b&#7857;ng chýõng tr&#236;nh Paint có s&#7859;n trong Windown, ngoài ra các b&#7841;n c&#361;ng có th&#7875; dùng các ph&#7847;n m&#7873;m khác theo s&#7903; trý&#7901;ng c&#7911;a các b&#7841;n.\r\nBý&#7899;c 1 :\r\nB&#7841;n b&#7845;m phím Print Screen ð&#7875; ch&#7909;p toàn b&#7897; màn h&#236;nh Desktop, \r\n\r\nhttp://d.f6.photo.zdn.vn/upload/original/2011/09/30/8/47/1317347270899150477_574_574.jpg\r\nHo&#7863;c Nh&#7845;n Alt + Print Screen ð&#7875; ch&#7909;p c&#7917;a s&#7893; chýõng tr&#236;nh ðang ch&#7885;n. (nút Print Srceen n&#7857;m phía góc ph&#7843;i trên c&#7911;a bàn phím\r\n\r\n\r\nBý&#7899;c 2 : Ð&#7875; m&#7903; chýõng tr&#236;nh Paint Các b&#7841;n vào Start > All Programs > Accessories > Pain\r\n\r\n\r\nBý&#7899;c 3 : Nh&#7845;n chu&#7897;t ph&#7843;i => Paste ð&#7875; dán h&#236;nh v&#7915;a ch&#7909;p vào Paint ho&#7863;c b&#7845;m t&#7893; h&#7907;p phím Ctrl +V\r\n\r\n \r\n\r\nBý&#7899;c 4 : Dùng các ch&#7913;c nãng c&#7911;a Paint ð&#7875; ch&#7881;nh s&#7917;a h&#236;nh &#7843;nh theo &#253; mu&#7889;n (Khoanh vùng, ðý&#7901;ng ch&#7881;, thêm ch&#7919;....) , sau ðó vào File ==> Save ho&#7863;c Ctrl + S . Ch&#7885;n thý m&#7909;c lýu và ð&#7863;t tên cho &#7843;nh, b&#7845;m OK ð&#7875; lýu h&#236;nh.'),
(21, '2015-09-22 21:32:42', 1, 11, '[Hý&#7899;ng D&#7851;n] Hýõìng dâÞn câÌn biêìt khi tham gia MU Online Viêòt Nam', 'Hýõìng dâÞn câÌn biêìt khi tham gia MU Online Viêòt Nam\nXin chào các b&#7841;n! \nBQT Mu Viêòt Nam chúng tôi có 1 s&#7889; nh&#7919;ng ði&#7873;u lýu &#253; cho các b&#7841;n khi chõi game. \nM&#7901;i b&#7841;n ð&#7885;c hý&#7899;ng d&#7851;n dý&#7899;i ðây ð&#7875; chõi game 1 cách t&#7889;t nh&#7845;t.\n\nHuy&#7871;t Lâu và Qu&#7843;ng trý&#7901;ng qu&#7927; X2 Kinh Nghi&#7879;m\nTh&#7913; 7 và Ch&#7911; Nh&#7853;t hàng tu&#7847;n X2 Kinh Nghi&#7879;m\nX5 ÐiêÒm UÒy Thaìc\n- Saìng 9h>10h\n-ChiêÌu 15h>16h\n-Tôìi 20h>21h\n\nT&#7927; l&#7879; Exp và Drop c&#7911;a Mu Viêòt Nam\nExp 150\nDrop 30\n\n1. V&#7845;n ð&#7873; reset \nKhông c&#7847;n c&#7903;i b&#7887; hay c&#7845;t ð&#7891;.\nvui l&#242;ng h&#227;y C&#7897;ng ði&#7875;m &#7903; web ð&#7875; không b&#7883; m&#7845;t skill nhân v&#7853;t \n2. Lýu &#253; skill m&#361;i tên vô t&#7853;n c&#7911;a ELF\nCác b&#7841;n c&#7897;ng 1500 ði&#7875;m vào ene, xong ðó ði làm nv 1 2 và nhi&#7879;m v&#7909; 220. Xong các nhi&#7879;m v&#7909; b&#7841;n ð&#7893;i nhân v&#7853;t vào l&#7841;i là có skill M&#361;i tên vô t&#7853;n. Khi reset xong các b&#7841;n ch&#7881; c&#7847;n c&#7897;ng vào ene 500>1000 ði&#7875;m là Ok\n\n3. Lýu &#253; các skill buff c&#7911;a nhân v&#7853;t khi s&#7917; d&#7909;ng auto\n(Nh&#7919;ng b&#7841;n nào chýa làm Master th&#236; ko c&#7847;n chú &#253; ð&#7871;n ði&#7873;u này)\nKhi c&#7855;m auto game, 1 vài skill buff k&#7871;t h&#7907;p auto cùng v&#7899;i skill luy&#7879;n s&#7869; d&#7851;n t&#7899;i -> nhân v&#7853;t ch&#7881; ð&#7913;ng buff su&#7889;t\nN&#7871;u th&#7845;y trý&#7901;ng h&#7907;p trên -> ðãng nh&#7853;p website qu&#7843;n l&#253; tài kho&#7843;n - > s&#7917; d&#7909;ng T&#7849;y Ði&#7875;m Master ð&#7875; l&#7845;y l&#7841;i master\n\n4. M&#7845;t s&#7841;ch master + skill do ko c&#7897;ng ði&#7875;m &#7903; website\nCác b&#7841;n nên c&#7897;ng ði&#7875;m &#7903; website ð&#7875; tránh b&#7883; m&#7845;t skill và master\n+ Vào nãng lý&#7907;ng t&#7915; 1000 ði&#7875;m tr&#7903; lên\n\n5. Cày ko lên ði&#7875;m master\nCác b&#7841;n ph&#7843;i ð&#7875; lv 400 - c&#7845;p ð&#7891; 3 ( master ) r&#7891;i b&#7855;t ð&#7847;u cày ði&#7875;m master\nKhi làm master xong các b&#7841;n ð&#7875; cho quái ðánh ch&#7871;t r&#7891;i b&#7855;t ð&#7847;u cày! \n\n6. Làm sao ko ðeo ðý&#7907;c wing 3\n- Các b&#7841;n ph&#7843;i ð&#7875; lv 400 - c&#7845;p ð&#7891; 3 ( master ) m&#7899;i ðeo ðý&#7907;c wing 3\n- Khi làm nhi&#7879;m v&#7909; 3 xong các b&#7841;n ð&#7893;i nhân v&#7853;t xong vào là ðeo ðý&#7907;c\n- M&#7885;i wing 3 ð&#7873;u yêu c&#7847;u lv 400 c&#7845;p ð&#7897; master m&#7899;i ðý&#7907;c phép ðeo\n\n7. Lag game, chõi game gi&#7853;t\n- t&#7855;t b&#7887; ph&#7847;n m&#7873;m di&#7879;t virus ,m&#7885;i ph&#7847;n m&#7873;m di&#7879;t virus ð&#7873;u gây lag game\n\n8. Không vào ðý&#7907;c nh&#7853;n v&#7853;t\nB&#7841;n không vào ðý&#7907;c nhân v&#7853;t, c&#7913; ch&#7885;n nhân v&#7853;t xong là m&#7845;t k&#7871;t n&#7889;i, ch&#7881; có m&#7895;i nhân v&#7853;t ðó b&#7883; v&#7853;y, các nhân v&#7853;t khác th&#236; không sao???\nCách gi&#7843;i quy&#7871;t:\nBý&#7899;c 1 : Ðãng nh&#7853;p trang ch&#7911;, Vào ph&#7847;n Qu&#7843;n l&#253; nhân v&#7853;t. Ch&#7885;n Di chuy&#7875;n nhân v&#7853;t v&#7873; làng ( nhân v&#7853;t b&#7883; l&#7895;i )\nBýõìc 2: Choòn chýìc nãng : Reset l&#7841;i poin rôÌi vào game và c&#7897;ng ði&#7875;m\nLýu &#221;: H&#227;y vào game c&#7897;ng ði&#7875;m, không ðý&#7907;c c&#7897;ng ði&#7875;m trên web. Các l&#7847;n reset sau các b&#7841;n có th&#7875; c&#7897;ng ði&#7875;m trên web b&#236;nh thý&#7901;ng.\n\n9. B&#7883; lag poin, m&#7845;t poin\nDo các b&#7841;n c&#7897;ng quá 65.000 ði&#7875;m vào 1 c&#7897;t ði&#7875;m, v&#236; v&#7853;y s&#7869; b&#7883; âm ði&#7875;m \nCác gi&#7843;i quy&#7871;t: Các b&#7841;n ch&#7881; c&#7847;n reset nhân v&#7853;t là có poin l&#7841;i b&#236;nh thý&#7901;ng.\n\n10. V&#7873; Item vpoin trong game\n- Item vpoin 1.000 và 10.000 khi v&#7913;t ra s&#7869; không sao, nh&#7863;t l&#7841;i ðý&#7907;c\n- Item vpoin 50.000 màu vàng khi v&#7913;t ra s&#7869; là 1 ð&#7889;ng zen. ( Các b&#7841;n lýu &#253; ði&#7873;u này ð&#7875; không b&#7883; m&#7845;t ti&#7873;n 1 cách ðáng ti&#7871;c) \n\n\nChúc các b&#7841;n chõi game vui v&#7867;\nBQT Mu Viêòt Nam kính báo!'),
(24, '2015-09-25 19:31:24', 1, 17, 'fwf', 'g'),
(27, '2015-09-25 19:39:16', 1, 20, 'tde', 'ryry'),
(28, '2015-09-25 19:44:28', 1, 21, 'wtw', 'twt'),
(30, '2015-09-26 13:51:54', 1, 17, 'g', 'g'),
(34, '2015-09-26 18:09:25', 1, 20, '', ''),
(35, '2015-09-26 18:10:04', 1, 21, 'ggrg', '   ggbergegr'),
(42, '2015-09-26 19:06:31', 2, 26, '13', '121'),
(46, '2015-09-26 20:03:47', 1, 24, 'rt3', ' 323ggg'),
(48, '2015-09-27 00:15:02', 1, 30, 'Ewe', 'ewe'),
(49, '2015-09-27 00:15:45', 2, 31, '212', '22'),
(51, '2015-09-27 00:16:14', 1, 33, '323', ' 32'),
(52, '2015-09-27 00:16:25', 1, 32, 'dscs', 'dsd'),
(53, '2015-09-27 00:19:43', 1, 33, 'rer', 'ere'),
(54, '2015-09-28 19:50:02', 1, 34, 'rer', 'ere'),
(55, '2015-09-28 19:52:05', 1, 35, 'asd', 'adad'),
(56, '2015-09-28 20:25:28', 1, 36, 'topcis id = 36, mess id = 56', 'koewewewk'),
(57, '2015-09-28 21:05:36', 1, 36, 'topcis id = 36, mess id = 57', ' ;km;'),
(64, '2015-09-28 22:58:31', 1, 38, 'rfw', 'fwfw'),
(65, '2015-09-28 22:58:56', 1, 33, 'Gweg', 'fwf'),
(66, '2015-09-28 22:59:06', 1, 33, 'Fwff', 'fwf'),
(67, '2015-09-28 22:59:16', 1, 34, 'gw', 'gwgwg'),
(68, '2015-09-29 23:45:28', 1, 35, 'Gegg', ' gggdsds');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `forum_id` tinyint(4) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `bodytopics` text,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `date`, `user_id`, `forum_id`, `subject`, `bodytopics`, `active`) VALUES
(1, '2015-06-09 12:35:47', 2, 1, 'sub 1', '[b]X - Edit - Posted by Admin on 2015-09-22 09:26pm - [Hýớng Dẫn] Cách tạo quạ tinh và chiến mã cho DL[/b]\nCách tạo quạ tinh và chiến mã cho DL Cách ép Quạ Tinh - Ðến Lorencia (tọa ðộ 122-110), tìm gặp NPC tên là Trainer, nói chuyện với NPC ðó, chọn chức nãng Tái tạo linh hồn. - Bỏ vào cửa sổ : 1 Ngọc Chaos + 1 Ngọc Creation + 1 Linh hồn quạ tinh + 2 Ngọc Soul + 2 Ngọc Bless - Tỉ lệ thành công là 60%. Nhấn kết hợp - Thất bại sẽ mất hết nguyên liệu. Cách ép Chiến Mã - Ðến Lorencia (tọa ðộ 122-110), tìm gặp NPC tên là Trainer, nói chuyện với NPC ðó, chọn chức nãng Tái tạo linh hồn. - Bỏ vào cửa sổ : 1 Ngọc Chaos + 1 Ngọc Creation + 1 Linh hồn chiến mã + 5 Ngọc Soul + 5 Ngọc Bless + 5 triệu zen. - Tỉ lệ thành công là 60%. Nhấn k[color=green]ết hợp. - Thất bại sẽ mất hết nguyên liệu. Chúc các bạn sớm có ðồ ngon^^.[/color]\n\n :wink:  :wassat:  :laughing: [img]anhlon.jpg[/img][color=red]   [/color]', 1),
(2, '2015-09-20 12:37:14', 1, 1, 'qw', NULL, 1),
(4, '2015-09-21 16:26:15', 1, 1, 'wg', NULL, 1),
(5, '2014-08-05 21:09:32', 1, 3, 'Cách c&#7897;ng ði&#7875;m cho DK', NULL, 1),
(6, '2015-09-22 21:10:34', 2, 8, 'C&#7897;ng ði&#7875;m DW', NULL, 1),
(8, '2014-07-09 21:13:24', 1, 11, 'Cách c&#7897;ng ði&#7875;m DL', NULL, 1),
(9, '2015-09-22 21:26:44', 1, 4, 'Hưỡng dẫn | Kinh nghiệm chơi', NULL, 1),
(10, '2015-09-22 21:28:45', 2, 4, '[Hý&#7899;ng D&#7851;n] Ch&#7909;p &#7843;nh màn h&#236;nh máy tính', NULL, 1),
(11, '2015-09-22 21:32:42', 1, 4, '[Hý&#7899;ng D&#7851;n] Hýõìng dâÞn câÌn biêìt khi tham gia MU Online Viêòt Nam', NULL, 1),
(12, '2015-04-05 19:18:38', 1, 8, 'sgsgs', NULL, 1),
(13, '2015-09-25 19:22:27', 1, 8, 'sgsgs', NULL, 1),
(14, '2015-09-25 19:22:27', 1, 8, 'sgsgs', NULL, 1),
(15, '2015-09-25 19:30:19', 1, 8, 'sgsgs', NULL, 1),
(18, '2015-09-26 16:17:09', 1, 2, 'ee', NULL, 1),
(19, '2015-09-26 17:00:29', 1, 4, 'Fwfw', NULL, 1),
(22, '2015-09-26 18:44:25', 1, 2, 'wtw', NULL, 1),
(23, '2015-09-26 18:52:38', 1, 4, 'eege', NULL, 1),
(25, '2015-09-26 19:01:07', 2, 4, '123', NULL, 1),
(28, '2015-09-26 19:26:52', 2, 2, 'nkbkooooooooooooooooooooooooooooooooo', NULL, 1),
(29, '2015-09-26 19:33:43', 1, 2, 'eewgwg', NULL, 0),
(31, '2015-09-27 00:15:45', 2, 2, '212', NULL, 0),
(33, '2015-09-27 00:16:14', 1, 2, '323', NULL, 1),
(34, '2015-09-28 19:50:02', 1, 2, 'rer', NULL, 1),
(35, '2015-09-28 19:52:05', 1, 1, 'Gegg', NULL, 1),
(36, '2015-09-28 20:25:28', 2, 1, 'topcis id = 36, mess id = 56', 'Cách tạo quạ t[u]inh và chiến mã ch[/u]o DL Cách ép Quạ Tinh - Ðến Lorencia (tọa ðộ 122-110), tìm gặp NPC tên là Trainer, nói chuyện với NPC ðó, chọn chức nãng Tái tạo linh hồn. - Bỏ vào cửa sổ : 1 Ngọc Chaos + 1 Ngọc Creation + 1 Linh hồn quạ tinh + 2 Ngọc Soul + 2 Ngọc Bless - Tỉ lệ thàn[i]h công là 60%. Nhấn kết hợp - Th[/i]ất b[b]ại sẽ mất hết nguyên liệu[/b]. Cách ép Chiến Mã - Ðến Lorencia (tọa ðộ 122-110), tìm gặp NPC tên là Trainer, nói chuyện với NPC ðó, chọn chức nãng Tái tạo linh hồn. - B[quote]ỏ vào cửa sổ[/quote] : 1 Ngọc Chaos + 1 Ngọc Creation + 1 Linh hồn chiến mã + 5 Ngọc Soul + 5 Ngọc Bless + 5 triệu zen. - Tỉ lệ thành công là 60%. Nhấn kết hợp. - [color=red]Thất bại sẽ mất hết nguyên liệu[/color]. Chúc các bạn s[link=http://google.com]http://google.com[/link]\n', 1),
(38, '2015-09-28 22:58:30', 1, 3, 'rfw', NULL, 1),
(41, '2015-10-05 00:00:00', 1, 1, 'cn_modify_s1bb_H ', 'cn_modify_s1bb_H ', 1),
(42, '2015-11-17 00:00:00', 1, 3, '\r\nactive	tinyint(1)			\r\n1\r\n', NULL, 0),
(43, '2015-11-17 00:00:00', 1, 3, '\r\nactive	tinyint(1)			\r\n1\r\n', NULL, 0),
(44, '2015-11-04 00:00:00', 1, 5, 'sacascdwdwe', NULL, 1),
(45, '2015-11-04 00:00:00', 1, 5, 'sacascdwdwe', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `verifystring` varchar(20) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `date` date NOT NULL,
  `avatar` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `verifystring`, `active`, `date`, `avatar`) VALUES
(1, 'Admin', 'emngockt93', 'ngoctbhy@gmail.com', '&E8/e|]vfD.D,*<+', 1, '0000-00-00', NULL),
(2, 'bqngoc11', '123', 'dgdg@dd.df', 'dvdvdvs', 1, '0000-00-00', NULL),
(3, 'emNgockt93', 'emNgock9', 'boyblock2013@yahoo.com.vn', 'Bi|bydXvkS{e#!oG', 1, '0000-00-00', NULL),
(4, 'bqngoc1', 'qwert12Y', 'yeyeye@fwfw.sf', 'HNuEf(y=IC&+oEI3', 1, '0000-00-00', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
