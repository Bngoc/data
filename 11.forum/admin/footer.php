<?php if (!defined('BQN_MU')) { die('Access restricted'); }?>
		</div>
	</div>
</div>
<!-- --------------------footer--------------------- -->
<div id="footer"> 
	<div id="bttop" style="display: block;">BACK TO TOP</div>	
	Copyright © 2015 &nbsp; <a href="mailto:jono AT jonobacon DOT org">Jono Bacon</a>
</div>

<!--
<script type="text/javascript">
	$(document).ready(function() {
		 //var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
		 //$("#cssmenu ul li a").each(function(){
			 // if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
			//  $(this).addClass("active");
		// })
		
			
		var url = new String(window.location);
		url =  url.substring(url.lastIndexOf("/")+1);
		alert(url);
		/*<?php
			//if(isset($_GET['mod'])){
			//	$kd =$_GET['mod'];
				//echo "bat mod php: " . $kd;
				//}
		?>
		/*< ? b php echo ==  < ? = * /
*/	
		<?php //if(isset($_GET['mod'])){
			?>
			var mod = "<?php// echo $_GET['mod']?>"; 
			mod = "#"+mod;
			alert(mod);
			
			//$(".content div").hide(); //Hide all content
			//$("#cssmenu li").attr("class",""); //Reset id's
			//$(this).parent().attr("class","active"); // Activate this
			//$('.' + $(this).attr('name')).fadeIn();
			
			$("#cssmenu li").removeClass('active');
			$("#cssmenu li").find("a[href='"+mod+"']").parent().addClass('active');
			
			
			
		<?php
		//}
		//else{
		?>
			//mod = "admin.php?mod=editconfig;
			//$("#cssmenu li").removeClass('active');
			//$("#cssmenu li").find("a[href='"+mod+"']").parent().addClass('active');
		<?php //} ?>
	});
</script>
-->



<script>

$(document).ready(function(){
		//$("#add_err").css('display', 'none', 'important');
		 $(".btnEnter").click(function(){	
			  username=$("#loginUser").val();
			  password=$("#loginPass").val();
			  $.ajax({
			   type: "POST",
			   url: "admin/login.php",
				data: "names="+username+"&pwds="+password,
			   success: function(html){ 
				alert(html);
				if(html == 'true')    {
				 //$("#add_err").html("right username or password");
				 //window.location="dashboard.php";
				 alert('Dang nhap thang cong');
				}
				else{
				//$("#add_err").css('display', 'inline', 'important');
				 //$("#add_err").html("<img src='images/alert.png' />Wrong username or password");
				 alert('dang sai');
				}
			   }//,
			   //beforeSend:function()
			  // {
				//$("#add_err").css('display', 'inline', 'important');
				//$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...")
			   //}
			  });
			return false;
		});
	});
</script>
<!--
<script>
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // store the currently selected tab in the hash value
    $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
        var id = $(e.target).attr("href").substr(1);
        window.location.hash = id;
    });

    // on load of the page: switch to the currently selected tab
    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');
</script>
-->
</body>
<html>