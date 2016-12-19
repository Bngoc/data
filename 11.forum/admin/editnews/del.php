<?php if($mod=='editnews') {?> 

<div id="" style="width:70%;float: left;">
<div id="center-column" class="middle">
	<div class="left_forums">
		<div class="col_1 tab4">
			<div class="tieude">
				<span style="text-algin:center;"><strong>FORUMS</strong> </span>
				<span>
				
				<select style="width:150px" id="mySelect" name="Users" class="ccmuc"><!-- onchange="showUser()" -->
					<option value="0">--Select--</option>
					<?php 
					$catsql = "SELECT * FROM categories;";
					$catresult =$db->query($catsql);
					if($catresult ->num_rows==0){
						//echo"<font style='color:red'>Non-Object!</font>";
						echo " ";
					}
					else{
						while($catrow = $catresult ->fetch_assoc()){
						?>
						<optgroup label="<?php echo $catrow['name']; ?>" style="font:bold;">
						<?php
						$catsql1 = "SELECT * FROM forums WHERE cat_id =" . $catrow['id'] . ";";
						$catresult1 =$db->query($catsql1);
						if($catresult1 ->num_rows==0){
							//echo"<font style='color:red'>Non-Object!</font>";
							echo " ";
						}
						else{
							
							while($catrow1 = $catresult1 ->fetch_assoc()){
						?>
							<option id="<?php echo $catrow1['id']; ?>" value="<?php echo $catrow1['id']; ?>"><?php echo $catrow1['name']; ?></option>
						<?php 
							}
						}?>
						</optgroup>
						<?php
						}
					}
					?>										
				</select>
				</span>
				<span style="float:right;color:red"><strong>Delete multiple rows in mysql</strong> </span>
			</div>
			
			<script type="text/javascript">
				  /*$(document).ready(function() {
					  var url = window.location.href;
					$("#mySelect").focusin(function() {
					  var UsersSelect = $('#mySelect').val();
					  $("#mySelect").load("admin.php?mod=editnews&act=del");
					  $('select[name="Users"]').val(UsersSelect);
					});
				  });
				  */
				  $(function() {
						if (localStorage.getItem('mySelect')) {
							$("#mySelect option").eq(localStorage.getItem('mySelect')).prop('selected', true);
						}

						$("#mySelect").on('change', function() {
							localStorage.setItem('mySelect', $('option:selected', this).index());
						});
					});
				</script>
			
			<!-- -------------------------- App pp new phan trang-------------------------- -->
			<?php
				/*
				require_once './includes/get_member.php';

				// Load thư viện phân trang
				include_once './includes/pagination.php';

				// Connect DB
				//connect();

				// Phân trang
				$config = array(
					'current_page'  => isset($_GET['page']) ? $_GET['page'] : 1,
					'total_record'  => count_all_member(), // tổng số thành viên
					'limit'         => 5,
					'link_full'     => 'admin.php?mod=editcatagoris&act=delc&page={page}',
					'link_first'    => 'admin.php?mod=editcatagoris&act=delc',
					'range'         => 9
				);

				$paging = new Pagination();
				$paging->init($config);

				// Lấy limit, start
				$limit = $paging->get_config('limit');
				$start = $paging->get_config('start');

				// Lấy danh sách thành viên
				$member = get_all_member($limit, $start);

				// Kiểm tra nếu là ajax request thì trả kết quả
				if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
					die (json_encode(array(
						'member' => $member,
						'paging' => $paging->html()
					)));
				}*/
			?>
		<!--
			<div id="content">
            <div id="list">
                <table border="1" cellspacing="0" cellpadding="5">
                    <?php //foreach ($member as $item){ ?>
                    <tr>
                        <td>
                           <?php //echo $item['id']; ?>  
                        </td>
                        <td>
                           <?php //echo $item['date']; ?> 
                        </td>
                        <td>
                           <?php //echo $item['user_id']; ?>  
                        </td>
                        <td>
                           <?php //echo $item['forum_id']; ?>  
                        </td>
                        <td>
                           <?php //echo $item['subject']; ?>  
                        </td>
                    </tr>
                    <?php //} ?>
                </table>
            </div>
            <div id="paging">
                <?php //echo $paging->html(); ?>
            </div>
        </div>
         <script language="javascript">
             $('#paging a').live('click', function (e){
				 e.preventDefault();
                 var url = $(this).attr('href'); //lay duong dan tren url
                 alert(url);
                 $.ajax({
                     url : url,
                     type : 'get',
                     dataType : 'json',
                     success : function (result)
                     {
                         //  kiểm tra kết quả đúng định dạng không
                         if (result.hasOwnProperty('member') && result.hasOwnProperty('paging'))
                         {
                             var html = '<table border="1" cellspacing="0" cellpadding="5">';
                             // lặp qua danh sách thành viên và tạo html
                             $.each(result['member'], function (key, item){
                                html += '<tr>';
                                html += '<td>'+item['id']+'</td>'; 
                                html += '<td>'+item['username']+'</td>'; 
                                html += '<td>'+item['email']+'</td>'; 
                                html += '<td>'+item['fullname']+'</td>'; 
                                html += '<td>'+item['phone']+'</td>'; 
                                html += '</tr>';
                             });
                             
                             html += '</table>';
                             
                             // Thay đổi nội dung danh sách thành viên
                             $('#list').html(html);
                             
                             // Thay đổi nội dung phân trang
                             $('#paging').html(result['paging']);
                             
                             // Thay đổi URL trên website
                             window.history.pushState({path:url},'',url);
                         }
                     }
                 });
                 return false;
             });
         </script>
		 -->
			<!--  -------------------------- end phan trang --------------------- -->
			
			<!-- new start func pagination -->
			
			
			<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
			
			<script>
			$(document).ready(function(){
					
				$('#mySelect').change(function(){
					var $parentID=$('#mySelect').val();

				
					// PHƯƠNG THỨC SHOW HÌNH LOADING
					//function loading_show(){
						//$('#loading').html("<img src='images/image-loading-animation.gif'/>").fadeIn('fast');
					//}

					// PHƯƠNG THỨC ẨN HÌNH LOADING
					//function loading_hide(){
						//$('#loading').fadeOut('fast');
					//}             

					// PHƯƠNG THỨC LOAD KẾT QUẢ 
					function loadData(page){
						//loading_show();  
						//alert($parentID);
						$.ajax
						({
							type: "POST",
							url: "admin/load_data.php",
							data: "page="+page+"&q="+$parentID,
							success: function(msg)
							{
								$(document).ajaxComplete(function(event, request, settings){
									//loading_hide();
									$("#condata").html(msg);
									//alert(msg);
								});
								
							},
							error : function(error) {}
						});
					}

					// LOAD GIÁ TRỊ MẶC ĐỊNH PAGE = 1 CHO LẦN ĐẦU TIÊN
					 loadData(1); 

					// LOAD KẾT QUẢ CHO TRANG
					$(document).on('click','#condata .pagination li.active',function(){
						var page = $(this).attr('p');
						loadData(page);
					});           

					// PHƯƠNG THỨC DÙNG ĐỂ HIỆN KẾT QUẢ KHI NHẬP GIÁ TRỊ PAGE VÀO TEXTBOX
					// BẠN CÓ THỂ MỞ TEXTBOX LÊN TRONG CLASS PHÂN TRANG
					$(document).on('click','#go_btn',function(e){ //$('#go_btn').live('click',function(e){
						e.preventDefault();
						var page = parseInt($('#goto').val());
						var no_of_pages = parseInt($('.total').attr('a'));
						if(page != 0 && page <= no_of_pages){
							loadData(page);
						}else{
							alert('HÃY NHẬP GIÁ TRỊ TỪ 1 ĐẾN '+no_of_pages);
							$('.goto').val("").focus();
							return false;
						}
					});
					
					});
				});
			
			</script>
			<div id="condata">
				<div class="data"></div>
				<div class="pagination"></div>
			 </div> <!-- end func pagination -->
			
			
		<div>
			<a href ="admin.php?mod=editcatagoris&act=delc&k=ok"> OK newstopics </a>
		</div>
		<?php if(isset($_GET['k']) == 'ok'){ 
			$oks = $_POST['k'];
		?>
		
			<script> alert('oks'); </script>
			<div style="color:red;">
			<input class ="" style="color:red;" value="Check ok!"></input>
			
			</div>
		<?php } ?>
		</div> <!-- end col_1 tab2 -->
		
	</div>
</div>

</div>
<!--
	<script type="text/javascript">
		function showUser(str) {
		  /*
		  if (str=="") {
			document.getElementById("txtHint").innerHTML="";
			return;
		  } 
		  if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			  document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		  }
		  */
		  xmlhttp.open("GET","admin/load_data.php?q="+str,true);
		  xmlhttp.send();
		}
	</script>
-->
<?php } ?>
<div style="width:15%;float: left;">
	<div id="" class="content">
		<div id="right-column" class="tab4" >
			<strong class="h">INFO</strong>
			<div class="box">Detectand eliminate viruses and Trojan horses, even new and unknown ones.Detect and eliminate viruses and Trojan horses, even new and </div>
		</div>
	</div>
</div>