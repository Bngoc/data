 [*] A>
	 1. 1433 ---> connect sql server
	    > Download Microsoft SQL 2k5 Server Management Studio Express
	    ->>>> Phan quyen DB
	    ->>>> Run Server Management Studio Express AD
	    ->>>> Attach DB vao Server Management Studio Express
	 2. IIS
	     Programs and Features Click Turn Windows features on or off
	     > Internet Information Service > Web Management Tools & World Wide Web Services

		-> chmod thu muc data.....
		-> iis --> php .. them thu muc php [php-cgi.exe]
		-> IUSR
	 3. CONFIG PHP.INI
		http://www.microsoft.com/web/downloads/platform.aspx
			--> CGI.
				--> fastcgi.impersonate = 1
				--> cgi.fix_pathinfo = 0
				--> cgi.force_redirect = 0
				--> extension_dir = "./ext"
				--> error_log=”C:php_errors.log”

				--> extension = PHP_MYSQL.PHP
				--> extension = php_com_dotnet.dll (them vao)
				--> extension = php_openssl.dll
				--> extension=php_mbstring.dll
				--> extension=php_gd2.dll
				--> extension=php_curl.dll
				--> extension=php_fileinfo.dll
				--> extension=php_sockets.dll
				--> extension=php_mysqli.dll
			3.1. php-CGI.exe
				--> X86 setup / php-5.6.27-nts-Win32-VC11-x86 =>  http://windows.php.net/downloads/releases/php-5.6.27-nts-Win32-VC11-x86.zip
			3.2. running PHP 5.5.x
				--> x86 setup / vcredist_x86.exe
				--> x64 setup / vcredist_x64.exe
				==> cv9 cho hdh php x86 + vc9 x86
			3.4 them moi truong cho thu muc chua giai nen 3.1
			3.5 Handler Mappings
				--> Add module Mappings
					=> 	Request path: *.php
						Module: FastCGImodule
						Executable: C:\thu muc giai nen\php-cgi.exe
						Name: FastCGI
				--> date.timezone ='Asia/Bangkok'
			3.6 add site ... thu muc chua data ...
			3.7
				--> edit binlding 	- wwww.omidev.info
											-  omidev.info  ===> F
									- *
			3.8 add permission ... IUSR ... X Full
			3.9 dri .. browser enabled
			3.10  Microsoft Web Platform Installer 3.0.
				url rewrite + Translate .htaccess Content to IIS web.config

			3.11
				access ????
			3.12
				gifnoc
					iusr +  iis_iusrs ---> modify

	4. CO ERR TAT - MO DEBUG INIT.PHP [BOTH]
		IIS -> Edit Feature Settings…
			500 -> Detailed errors


	5. truy cap vao  ...../admin.php
		-> php_com_dotnet.dll


 [*] B>
	0. chay odbc
		-> x86 Or x64
		==> TitanLinkServer.exe not renpoding
			Fix -==> Port=55970		Port=55906	Port=55962		Port=55960		Port=55999	Port=55557
			Fix -==> ServerODBC=MuOnline
			Fix -==> ServerODBC=MuOnlineJoinDB

	1. attach db them vao (detact huy)
		->  them 3 ? 4
			-> permission -> user Full

		-> firevall offline
		-> open port 1433 .... lien quan rang ... inbound oubount

	2. run sql

	3. Allow remote connect to this server [sql server]

 [*] C> Cau hinh cho forum
	1. Mysql => https://dev.mysql.com/downloads/workbench/
	2. -> Vao duong dan dan <pacth>/data/forum/includes/config.php
		-> mo = notepad++ thay doi cho phu hop


 [*] D> cau hinh tren /admin.php
    1. time zone  (0 -> +7)
    2. allow regiter
    3. character
    4. cashshop

 [*] E>
	1. Hex main + Hex main config
		Keyword serach -=> connect
		Keyword serach -=> AVCKeyGenerater..... serial....
		keyword serach -=> connect.mu
		keyword serach -=> connect
		keyword serach -=> BufTimeControl
		keyword serach -=> mu.exe
	2.



 [*] F> Cau hinh ranking top50 Table character [Task scheduler for Win]
		1. pacth php.exe => [program/srcipt]
			==> <patch> /php/php5.5.12/php.exe
				EX: C:\wamp\bin\php\php5.5.12\php.exe
		2. Path file update RankingTopAutoUpdate => [add arguments (optional)]
			==> -f <patch> /core/cronJobRankingTopAutoUpdate.php
				EX: -f  C:\wamp\www\bqn\data\core\cronJobRankingTopAutoUpdate.php
		3. start in (optional)
			=-> <pacth>\core\
			EX: C:\wamp\www\bqn\data\core\
		4. Triggers => Set time
			HD 		-=> video kem theo
			Video 	-=> "/setup/config RankingTopAutoUpdate.wmv

		5. security
		    5.1> IIS
		        C1. IIS -> URL Rewrite -> Add rules -> request bloking (Block access -> URL Path; Block request -> Matches the..; Pttern ... -> /core/cronJobRankingTopAutoUpdate.php; How to ..-> Abort Requset) ... HD ==> https://www.iis.net/learn/extensions/url-rewrite-module/request-blocking-rule-template
		        C2. IIS -> request feltring - > URL -> Deny sequence ...  /core/cronJobRankingTopAutoUpdate.php
		    5.2> PHP Apache ....
		        -> .htaccess deny file

[*] G> Cau hinh choi De
        1. Cau hinh tu tuong nhu Ranking Top 50 [ Task scheduler for Win]
        2. Default Tra ket qua la 8:0 ngay hom sau (thoi gian tra ket qua tu 0 den 17:45 (default) thoi gian ket thuc nhan ghi de;
        3. file auto --> -f <patch> /core/cronJobResultDeAutoUpdate.php

 Z>
	1.open port
		--> Connecting to SQL Server remotely on AWS involves 3 main factors:
			AWS --> Windows Security --> SQL Server Settings/Security.

			Connections can easily fail because each area has specific requirements. I'll go through the check-list:

			AWS:
			1. In AWS management console, go to Security Groups, click on the group that applies to your windows server, make sure MS SQL TCP port 1433 is open to 0.0.0.0 or your specific client IP. If not, you'll need to add it.
			2. Note the Public IP of your server

			WINDOWS:
			1. RDP to the Amazon Windows server, Start > Administrative Tools > Local Security Policy
			2. Click Windows Firewall with Advanced Security, Windows Firewall Properties, Click the "Public Profile" tab, set Firewall State to "ON", Inbound to Block, Outbound to Allow (or block depending on your application). OK.
			3. Expand the Windows Firewall (on the left Pane), R-Click the Inbound Rule, Click New Rule.
			4. Click Port option, Next > , for TCP, enter 1433 Next >, Allow the connection, Next >, Next > , give it a name (SQL-PORT-ACCESS)

			SQL-SERVER:
			1. Login to SQL Server with SSMS (SQL Server Management Studio) using the default windows authentication.
			2. On the left-pane, R-click the top server listing (with the database icon, the very first listing), and select "Properties"
			3. Properties window, click Security on the left pane, choose the "SQL Server and Windows Auth"
			4. Click Connections, check the "Allow Remote Connections" option ... Click OK.
			5. Open the SQL Configuration Manager, Start > Programs > Microsoft SQL Server > Configuration Tools > SQL Server Configuration Manager
			6. SQL Server Network Configuration (Expand), select Protocols for MSSQL, R-Click TCP , select Properties (TCP should be enabled)
			7. Click IP Addresses tab, check that IP1 is enabled, Dynamic Ports is 0, TCP port is 1433
			8. Scroll all the way down to IPAll section, Enter 0 in TCP Dynamic Ports, and 1433 in TCP Port. OK...
			9. Back on the left pane, click, SQL Server Services, R-Click the SQL Server option, and select "Restart".
			(NOTE: Unlike earlier comments posted here, SQL Browser server does not impact connectivity, browser service only lists available servers, if you have your specific connection parms, no need to start or worry about the browser)

			TESTING:
			You don't have go to your remote client to test, start by trying to connect from the same SSMS window on the server. This reduces all the other things that can go wrong at first, if you can connect here, you have some confirmation that it works. If it doesn't work from your own server, the issues are related to Windows security and SQL security and setup. So, under the Object Explorer (SQL server Management Studio), click "Connect" > Database Engine... In the Server name:, enter your PUBLIC IP, a comma, then 1433. Example, if your public IP is 54.4.4.4 , enter 54.4.4.4,1433, select the authentication as "SQL Server", enter the login user and password. If you're using "sa", remember to change the password. If your connection works locally, then you can try your remote client connection. At this point you know your SQL server and user settings are correct. Next, try using SSMS on another computer. If that fails, probably the firewall needs a 2nd look...

			Good place to understand issues, is the SQL logs easily accessible from SSMS, on the left pane, expand Management, then SQL Server Logs, current log will list any problems.

			So, those are all the parts involved -- miss one and you'll be frustrated, but start by reducing the pieces when testing.

			I was able to connect to AWS Windows Server, running SQL Express, from a Windows Mobile device... it works like a charm.
			Good Luck!



 Alter TABLE [dbo].[MEMB_INFO] ADD [acl] [smallint] NOT NULL DEFAULT (2)
 Alter TABLE [dbo].[MEMB_INFO] ADD [ban_login] [int] NOT NULL DEFAULT (0)
 Alter TABLE [dbo].[MEMB_INFO] ADD [num_login] [smallint] NOT NULL DEFAULT (0)
 Alter TABLE [dbo].[MEMB_INFO] ADD [jewel_feather] [int] NULL DEFAULT (0)

 ALTER TABLE [dbo].[MEMB_INFO] ADD [token_regist] VARCHAR (255) NULL
 Alter TABLE [dbo].[MEMB_INFO] ADD [date_resgit_email] [int] NULL DEFAULT (0)
 ALTER TABLE [dbo].[MEMB_INFO] ALTER COLUMN [memb__pwdmd5] nvarchar(100) NOT NULL


 ALTER TABLE [dbo].[Character] ADD [PhutUyThacOn_dutru] [int] NOT NULL DEFAULT (0)
 ALTER TABLE [dbo].[Character] ADD [PhutUyThacOff_dutru] [int] NOT NULL DEFAULT (0)
 ALTER TABLE [dbo].[Character] ADD [uythaconline_time] [int] NOT NULL DEFAULT (0)
 ALTER TABLE [dbo].[Character] ADD [UyThacOnline_Daily] [int] NOT NULL DEFAULT (0)
 ALTER TABLE [dbo].[Character] ADD [UyThacOffline_Daily] [int] NOT NULL DEFAULT (0)

CREATE TABLE [dbo].[Account_Info](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[UserAcc] [char](50) NOT NULL,
	[Pwd] [nvarchar](max) NOT NULL,
	[AdLevel] [int] NOT NULL,
	[Email] [nvarchar](50) NULL,
	[Ban] [int] NULL,
	[NumLogin] [tinyint] NULL,
	[Lastdate] [int] NULL,
	[Time_At] [datetime] NULL,
	[hash] [nvarchar](max) NULL
) ON [PRIMARY]
GO

/********** --------------- ***************/
USE [MuOnline]
GO
/****** Object:  Table [dbo].[WriteDe]    Script Date: 01/18/2017 23:01:42 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[WriteDe](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[AccountID] [nchar](10) NOT NULL,
	[WriteDe] [smallint] NOT NULL,
	[timestamp] [datetime] NOT NULL,
	[Action] [smallint] NOT NULL,
	[Vpoint] [int] NOT NULL,
	[Result] [smallint] NULL,
 CONSTRAINT [PK_WriteDe] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[ResultDe]    Script Date: 01/18/2017 23:01:42 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[ResultDe](
	[ID] [int] IDENTITY(1,1) NOT NULL,
	[ResultDe] [smallint] NOT NULL,
	[timesDe] [datetime] NOT NULL,
	[OptionResult] [text] NULL,
 CONSTRAINT [PK_ResultDe] PRIMARY KEY CLUSTERED
(
	[ID] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Default [DF_WriteDe_Action]    Script Date: 01/18/2017 23:01:42 ******/
ALTER TABLE [dbo].[WriteDe] ADD  CONSTRAINT [DF_WriteDe_Action]  DEFAULT ((0)) FOR [Action]
GO

/* ------------------------------------------------------ */

USE [MuOnline]
GO

/****** Object:  Table [dbo].[DoanhThu]    Script Date: 02/05/2017 11:37:20 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[DoanhThu](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[timeCard] [datetime] NOT NULL,
	[money] [int] NOT NULL,
	[card_type] [varchar](20) NULL
) ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[DoanhThu] ADD  CONSTRAINT [DF__DoanhThu__month__6339AFF7]  DEFAULT ((1)) FOR [timeCard]
GO

ALTER TABLE [dbo].[DoanhThu] ADD  CONSTRAINT [DF__DoanhThu__money__642DD430]  DEFAULT ((0)) FOR [money]
GO

/* ------------------------------------------------------ */
USE [MuOnline]
GO

/****** Object:  Table [dbo].[CardPhone]    Script Date: 02/05/2017 11:33:13 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

SET ANSI_PADDING ON
GO

CREATE TABLE [dbo].[CardPhone](
	[stt] [int] IDENTITY(1,1) NOT NULL,
	[accountID] [varchar](20) NOT NULL,
	[Name] [varchar](10) NULL,
	[menhgia] [int] NOT NULL,
	[card_type] [varchar](20) NOT NULL,
	[card_num] [varchar](20) NOT NULL,
	[card_serial] [varchar](20) NOT NULL,
	[addvpoint] [varchar](20) NOT NULL,
	[timenap] [datetime] NOT NULL,
	[times_tamp] [int] NOT NULL,
	[status] [text] NULL,
	[timeduyet] [int] NULL,
	[teknet_status] [tinyint] NULL,
	[teknet_check_wait] [tinyint] NULL,
	[teknet_check_last] [int] NULL,
	[card_num_md5] [varchar](35) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

GO

SET ANSI_PADDING OFF
GO

ALTER TABLE [dbo].[CardPhone] ADD  CONSTRAINT [DF_CardPhone_timenap]  DEFAULT (NULL) FOR [timenap]
GO

ALTER TABLE [dbo].[CardPhone] ADD  CONSTRAINT [DF__CardPhone__kingn__5E94F66B]  DEFAULT ((0)) FOR [teknet_status]
GO

ALTER TABLE [dbo].[CardPhone] ADD  CONSTRAINT [DF__CardPhone__kingn__5F891AA4]  DEFAULT ((0)) FOR [teknet_check_wait]
GO


/*---- table List file api clound --- */

CREATE TABLE [dbo].[ListFileApiCloud](
    	[id] [int] IDENTITY(1,1) NOT NULL,
    	[nameFile] [nvarchar](50) NOT NULL,
    	[alias] [ntext] NOT NULL,
    	[typeApi] [smallint] NULL,
     CONSTRAINT [PK_ListFileApiCloud] PRIMARY KEY CLUSTERED
    (
    	[id] ASC
    )WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
    ) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]

    GO

    ALTER TABLE [dbo].[ListFileApiCloud] ADD  CONSTRAINT [DF_ListFileApiCloud_typeApi]  DEFAULT ((0)) FOR [typeApi]
    GO
