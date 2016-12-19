<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>TVWebMU - Admin</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<style media="all" type="text/css">@import "admin/images/css.css";</style>
</head>
<body>
<div id="main">
	<div id="header">
		<ul id="top-navigation">
			<li <?php if($mod=='editconfig' || !$mod) { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editconfig">Cấu Hình Chung</a></span></span></li>
			<li <?php if($mod=='editchar') { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editchar">Nhân Vật</a></span></span></li>
			<li <?php if($mod=='editwebshop') { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editwebshop">Webshop</a></span></span></li>
			<li <?php if($mod=='editnapthe') { ?> class="active" <?php } ?> ><span><span><a href="admin.php?mod=editnapthe">Nạp Thẻ</a></span></span></li>
		</ul>
	</div>
	<div id="middle">