		<div id="left-column">
			<h3>Chức năng</h3>
<?php if( $mod=='editconfig' || !$mod ) { ?>
			<ul class="nav">
				<li><a href="ad.php?mod=editconfig&act=config">Cấu Hình Web</a></li>
				<li><a href="ad.php?mod=editconfig&act=config_class">Cấu Hình Class</a></li>
				<li><a href="ad.php?mod=editconfig&act=config_chucnang">Cấu hình Chức năng</a></li>
				<li><a href="admin.php?mod=editconfig&act=config_domain">Tên miền chính WebSite</a></li>
				<li><a href="admin.php?mod=editconfig&act=config_antiddos">Hệ thống chống DDOS</a></li>
				<li><a href="admin.php?mod=editconfig&act=activepro">Kích hoạt Phiên Pro</a></li>
<?php if (!$usehost) {?>
				<li class="last"><a href="admin.php?mod=editconfig&act=config_server">Cấu Hình Server</a></li>
<?php } ?>
			</ul>
<?php } ?>
<?php if( $mod=='editchar') { ?>
			<ul class="nav">
				<li><a href="admin.php?mod=editchar&act=reset">Reset</a></li>
				<li><a href="admin.php?mod=editchar&act=resetvip">ResetVIP</a></li>
				<li><a href="admin.php?mod=editchar&act=gioihanrs">Giới hạn Reset</a></li>
				<li><a href="admin.php?mod=editchar&act=hotrotanthu">Hỗ trợ Tân thủ</a></li>
				<li><a href="admin.php?mod=editchar&act=relife">ReLife</a></li>
				<li><a href="admin.php?mod=editchar&act=uythacoffline">Ủy thác Offline</a></li>
				<li><a href="admin.php?mod=editchar&act=uythac_reset">Ủy Thác - Reset</a></li>
				<li><a href="admin.php?mod=editchar&act=uythac_resetvip">Ủy Thác - ResetVIP</a></li>
				<li><a href="admin.php?mod=editchar&act=ruatoi">Rửa tội</a></li>
				<li><a href="admin.php?mod=editchar&act=taydiem">Tẩy điểm</a></li>
				<li><a href="admin.php?mod=editchar&act=thuepoint">Thuê điểm</a></li>
				<li><a href="admin.php?mod=editchar&act=changeclass">Đổi Giới Tính</a></li>
				<li class="last"><a href="admin.php?mod=editchar&act=changename">Đổi Tên</a></li>
			</ul>
<?php } ?>
<?php if( $mod=='editwebshop') { ?>
			<ul class="nav">
				<li><a href="admin.php?mod=editwebshop&act=shop_armor">Giáp trụ</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_wings">Cánh</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_ringpendants">Trang sức</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_shields">Khiên</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_crossbows">Cung - Nỏ</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_weapons">Đao - Kiếm</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_scepters">Quyền trượng</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_staffs">Gậy</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_spears">Thương - Giáo</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_fenrir">Linh hồn sói tinh</a></li>		    	    
				<li><a href="admin.php?mod=editwebshop&act=shop_eventticket">Vé sự kiện</a></li>
				<li><a href="admin.php?mod=editwebshop&act=shop_orther">Các loại khác</a></li>
				<li class="last"><a href="admin.php?mod=editwebshop&act=adddata">Thêm dữ liệu Item</a></li>
			</ul>
<?php } ?>
<?php if( $mod=='editnapthe') { ?>
			<ul class="nav">
				<li><a href="admin.php?mod=editnapthe&act=vtc">Thẻ VTC</a></li>
				<li><a href="admin.php?mod=editnapthe&act=gate">Thẻ Gate</a></li>
				<li><a href="admin.php?mod=editnapthe&act=viettel">Thẻ Viettel</a></li>
				<li><a href="admin.php?mod=editnapthe&act=mobi">Thẻ Mobi</a></li>
				<li class="last"><a href="admin.php?mod=editnapthe&act=vina">Thẻ Vina</a></li>
			</ul>
<?php } ?>
		</div>