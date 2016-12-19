<?php if (!defined('BQN_MU')) { die('Access restricted'); }
//if($mod=='editnews') 
{



	
//list($editconfigs, $editcats, $editforums, $editnews, $editusers, $entries_total, $userlist) = _GL('editconfigs, editcats, editforums, editnews, editusers, entries_total:intval, userlist'); // tabs menu
list($mod, $act, $start, $page, $per_page, $source, $entries_total, $showed, $ndraft) = _GL('mod, act, start, page, per_page, source, entries_total, showview, numdraft'); // cho duong dan 
list($sort, $dir, $YS, $MS, $DS, $com_filter) = _GL('sort, dir, year_selected, mon_selected, day_selected, com_filter'); // sap xep theo sort (ngay comment tac gia)
list($forums_filters, $users_filters) = _GL('forums_filters, users_filters');

list($myyear, $myy_mon, $myym_day, $orderview, $sum_recode_topics, $paginationview, $db) = _GL('sqlyear, sqlyearmon, sqlyearmonday, sqlordershow, sum_recode_topics, pagination, db');



$i = 0;
$page= intval($page);
  
			  
 //require_once (SERVDIR."/forum/config.php");  
// global $db;
   
   echo "page: " . $page . "<br>";
	echo "per_page: " . $per_page . "<br>";
	echo "sort: " . $sort . "<br>";
	echo "dir: " . $dir . "<br>";
	echo "YS: " . $YS . "<br>";
	//echo "MS: " . $MS . "<br>";
	//echo "DS: " . $DS . "<br>";
	//echo "year: " . $year . "<br>";
	//echo "forums_filters: " . $forums_filters . "<br>";
	//echo "users_filters: " . $users_filters . "<br>";
	//echo "com_filter: " . $com_filter . "<br>";
    //echo "SELECT year:" .$myy . "<br>";
    //echo "SELECT month:" .$myym . "<br>";
    //echo "SELECT day:" .$myymd . "<br> <br>";
	
		
		//----------------------------------
				echo "order limit: <br><br>";
				echo $orderview . "<br><br>";
				//----------------------------------
	/*
	if(!empty($forums_filters)){
	arsort($forums_filters);	
	foreach($forums_filters as $vl => $k){
		print "id_F " . $vl . " <br>";
	}
	}
	arsort($users_filters);
	foreach($users_filters as $vl => $k){
		print "id_U " . $vl . " <br>";
	}
    */
?> 



			<div class="tieude top-bar">
				<span> <h1><strong>TOPICS</strong></h1></span>
				<span style="float:right;color:red"><strong>Delete multiple rows in mysql</strong> </span>
			</div>
			<div class="select-bar"></div>
			<br>
			 <!-- ket thuc ham select cat va forum -->
			
			<div class ="clearfloat"></div>
			
			<!-- start written cutephp -->
			<div class="panel">
				<div style="float: right;">
					Entries on page: <?php foreach (array(25, 50, 100, 250) as $_per_page) { echo ' <a href="'.cn_url_modify('mod=editnews', 'page',"per_page=$_per_page").'" '.($per_page == $_per_page ? 'class="b"' : '').'>'.$_per_page.'</a> '; } ?>
					<a style="color: #008080;" href="#" onclick="DoDiv('filters'); return false;">[Change filters]</a>
				</div>

				<?php

			echo i18n('Showed <b>%1</b> ', $showed);
			echo i18n(' from total <b>%1</b> ', $entries_total);

    ?>
			</div>
			
						
			<div class="source">

				<div style="float: right;">
					<div><b>sort by</b>  /
					<?php

						// sort method
						echo ' <a href="'.cn_url_modify('mod=editnews', 'sort=date').'" '.($sort == 'date'?'class="bd"':'').' title= "Sort by date">date</a> /';
						echo ' <a href="'.cn_url_modify('mod=editnews', 'sort=comments').'" '.($sort == 'comments'?'class="bd"':'').'title="Sort by comments">comments</a> /';
						echo ' <a href="'.cn_url_modify('mod=editnews', 'sort=author').'" '.($sort == 'author'?'class="bd"':'').' title ="Sort by author">author</a> ';

						// sort order
						echo ' &nbsp; <a href="'.cn_url_modify('mod=editnews', 'dir=a').'" '.($dir == 'a'? 'class="bd"':'').' title="Sort by ascending">&uarr; ASC</a> &nbsp; ';
						echo ' <a href="'.cn_url_modify('mod=editnews', 'dir=d').'" '.($dir == 'd'?'class="bd"':'').' title="Sorted by descending">&darr; DESC</a> ';

					?>
					</div>
				</div>

				Source:
				<a href="<?php echo cn_url_modify('mod=editnews', 'source,page'); ?>" <?php if ($source == '') { echo 'class="b"'; } ?>>Active</a> /
				<a href="<?php echo cn_url_modify( 'mod=editnews', 'page','source=draft'); ?>" <?php if ($source == 'draft') { echo 'class="b"'; } ?> > Draft (<?php echo $ndraft; ?>) </a>
				<div style="clear:both;"></div>

				<div style="<?php if (empty($forums_filters) && empty($users_filters)) { echo 'display: none;'; } ?>" id="filters">

					
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">

						<?php echo cn_snippet_get_hidden(); //an cac input name value?>
						<table width="100%">
							<tr>
								<td>By category</td>
								<td>By user</td>
							</tr>
							<tr>
								<td style="width: 45%;">
									<select name="forum_filters" style="width: 100%;" class ="subforum">
										<option value="0">--Show all--</option>
										<?php 
										$catsql = "SELECT * FROM categories;";
										$catresult =$db->query($catsql);
										if($catresult ->num_rows!=0){
											while($catrow = $catresult ->fetch_assoc()){
												$getidcat = intval($catrow['id']);
												
												$itemname = UTF8ToEntities($catrow['name']);
												
												//----------------------------------------------
												/*												
												//convert to right encoding
												if(getoption('frontend_encoding')!='UTF-8'&& function_exists('iconv'))
												{
													$bkp=$comment;
													$comment=  iconv(getoption('frontend_encoding'),'UTF-8//TRANSLIT' , $comment);
													if(!$comment)
													{
														$comment=$bkp;
													}
												}
												*/
												//----------------------------------------------
											?>
											<optgroup label="<?php echo $itemname; ?>" style="font:bold;">
											<?php
											$catsql1 = "SELECT id, name FROM forums WHERE cat_id =" . $getidcat . ";";
											$catresult1 =$db->query($catsql1);
											if($catresult1 ->num_rows!=0){
												while($catrow1 = $catresult1 ->fetch_assoc()){
													$getidfor = intval($catrow1['id']);
													$namefor = UTF8ToEntities($catrow1['name']);
													
											?>
												<option id="<?php echo $getidfor; ?>" value="<?php echo $getidfor; ?>"><?php echo $namefor; ?></option>
											<?php 
												}
											}?>
											</optgroup>
											<?php
											}
										}
										?>
									</select>
								</td>

								
								<td style="width: 45%;">
								
									<select name="user_filters" style="width:100%;" class ="subusers">
										<option value="">-- Show --</option> 
										<?php
										?>
									</select>
									
								</td>

								<td colspan="2"><input type="submit" value=" Add new filter " /></td>

							</tr>
							<tr>

								<td><?php
									if(!empty($forums_filters) && isset($forums_filters)){
										arsort($forums_filters);
										foreach ($forums_filters as $id) { 
											$myfsql = "SELECT name FROM forums WHERE id =" . $id . ";";
											$fresult =$db->query($myfsql);
											if($fresult ->num_rows!=0){
												$frow_name = $fresult ->fetch_assoc();
												
												echo ' [<a href="' . cn_url_modify('mod=editnews', "rm_forum_filter=$id") . '" style="color: red;">&ndash;</a>] <b>' . UTF8ToEntities($frow_name['name']) . '</b> &nbsp; ';                                 
											}
										}
									}
									?>
								</td>

								<td><?php
									if(!empty($users_filters)){
										arsort($users_filters);
										foreach ($users_filters as $id) {
											$myusersql = "SELECT username FROM users WHERE id =" . $id . ";";
											$myuserresult =$db->query($myusersql);
											if($myuserresult ->num_rows!=0){
												$frow_user_name = $myuserresult ->fetch_assoc();
												echo ' [<a href="'.cn_url_modify('mod=editnews', "rm_user_filter=$id").'" style="color: red;">&ndash;</a>] <b>'.UTF8ToEntities($frow_user_name['username']) . '</b> &nbsp; ';
											}
										}
									}
									?>
								</td>
							</tr>

						</table>
					</form>

				</div>

			</div>

			<br/>
			
			<!-- end written sutephp -->
			<script type="text/javascript">
				$(document).ready(function(){
					$(".subforum").change(function(){
						var id=$(this).val();
						var id = 'id='+ id;
						$.ajax({
							type: "POST",
							url: "admin/cdata/editnews/subuser.php",
							data: id,
							cache: false,
							success: function(html){
								$(".subusers").html(html);
							}
						});
					});
				});
			</script>
			<!-- start w test -->
				
			<!-- end written test -->
			<!-- -----------------------------------start App cutephp------------------------------------- -->
				<?php // --------------------------------------------------------------------------------------------------------------- ?>
				<?php 
					//  -------------------------------------------------------------------------------------------
				
			
	//  -------------------------------------------------------------------------------------------
	
				
				?>

				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">

					<?php cn_form_open('mod, source, archive_id'); ?>
					<input type="hidden" name="act" value="massaction">

					<table width="100%" class="std-table">
					<tr valign="top">

						<!-- Browse periods -->
						<td style="background: #f8f8f8; border: 0; display: block;width:15%" id="browse_dates">

							<!-- news list -->
							<table class="std-table" width="100%">
								<tr><th><nobr><a href="<?php echo cn_url_modify('mod=editnews', 'mon,day,year'); ?>">All periods</a></nobr></th></tr>
								<tr>
									<td>
										<?php 
											$yresult =$db->query($myyear);
											if($yresult ->num_rows !=0){
												while($yearrow = $yresult ->fetch_assoc()){
												$yc = $yearrow['year'];?>
												<div class="years<?php if ($yc== $YS){ echo '-b' . ($MS ? '' : 'wm'); } ?>">
													<a href="<?php echo cn_url_modify('mod=editnews', 'mon,day', "year=$yc"); ?> "><?php echo $yc; ?></a>
												</div>
												<?php if ($YS == $yc){
													$resultm =$db->query($myy_mon);
													if($resultm ->num_rows !=0){
													while($rowm = $resultm ->fetch_assoc()){
														$mc = $rowm['mon'];?>
														<div class="mons<?php if ($mc == $MS) { echo '-b' . ($DS ? '' : 'wm');} ?>">
															<a href="<?php echo cn_url_modify('mod=editnews', 'day', "year=$yc", "mon=$mc"); ?>"><?php echo $mc; ?></a>
														</div>
														<?php if ($mc == $MS){
															$resultd =$db->query($myym_day);
															if($resultd ->num_rows !=0){
															while($rowd = $resultd ->fetch_assoc()){
																$dc = $rowd['day'];
																$mysql_tem = $sum_recode_topics . " AND YEAR(topics.date) = '" . $yc . "' AND MONTHNAME(topics.date) = '" . $mc . "' AND DAY(topics.date) = '". $dc ."' GROUP BY topics.id;";
																$resul_num_topics_full_date =$db->query($mysql_tem);
																$sum_topic = $resul_num_topics_full_date ->num_rows;
																
																//echo "msyql temple sum recode topics. $mysql_tem <br>";
															 ?>
																<div class="days<?php if ($dc == $DS){ echo '-b';} ?>">
																	<a href="<?php echo cn_url_modify('mod=editnews', "year=$yc", "mon=$mc", "day=$dc"); ?>"><?php echo $dc; ?></a> 
															<?php if($sum_topic != 0){ echo '<small>(' . $sum_topic . ')</small>'; } ?>
																</div>
															<?php }
															}
														}
													}
												}
												}
											}
										}
										
										 ?>
									</td>
								</tr>
							</table>

							<!-- category list -->
							<?php //if ($category) { ?>
								<br/>
								<table class="std-table" width="100%">
									<tr><th><nobr><a href="<?php echo cn_url_modify('mod=editnews', 'forum_filters'); ?>">All categories</a></nobr></th></tr>
									<tr>
										<td >
											<div>
												<a <?php //if ($cat_filter === '-') { echo 'class="bold" '; } ?>href="<?php echo cn_url_modify('mod=editnews', 'forum_filters'); ?>">Free news only</a>
											</div>
											<hr/>
											<?php
											   // foreach ($category as $id => $cat)
												{
													//echo '<div style="word-wrap:break-word; width: 150px;"><a '. 1 . 'href="'.cn_url_modify('mod=editnews', "cat_filter=2").'">'. 3 . '</b></div>';
												}
											?>
										</td>
									</tr>
								</table>
							<?php //} ?>
						</td>

						<!-- List news entries -->

						<td style="border: 0;width:85%;">

						<table width="100%" class="std-table">

							<?php //if ($showed)
								$resultedit =$db->query($orderview);
									if($resultedit ->num_rows !=0){ 
								?>

								<tr>
									<?php //echo hook('template/editnews/list_header_before'); ?>
									<th title="Subject">Title</th>
									<th width="1" align="center" title="Comments number">Com</th>
									<th align="center" title="Name forums">Forums</th>
									<th width="50" align="center"title="Date">Date</th>
									<th align="center" title="Author">Author</th>
									<?php //echo hook('template/editnews/list_header_after'); ?>
									<th width="1" align="center"><input style="border: 0; background: transparent;" type=checkbox name=master_box title="Check All" onclick="check_uncheck_all('selected_news[]');"> </th>
								</tr>

								<?php //foreach ($entries as $ID => $entry) 
									while($rowedit = $resultedit ->fetch_assoc()){
										$nv_user = db_user_by_name($rowedit['username']);
								?>

									<tr style="background: <?php echo ($i++%2? '#F7F6F4' : '#FFFFFF'); ?>" class="hover"  >

										<?php //hook('template/editnews/list_item_before', array($ID, $entry)); ?>
										<td>
											<div style="word-wrap: break-word; */width:200px;*/">
											<?php //if ($entry['can']) 
											 if (test('Nvs', $nv_user, TRUE) || test('Nvg', $nv_user) || test('Nva'))
											{
												$topicid = $rowedit['topicid'];
												$subjects = UTF8ToEntities($rowedit['subject']);
																							
												//$title = $entry['title'] ? $entry['title'] : '<no title:'.(isset($entry['id']) ? $entry['id'] : 0).'>';?>
												<a title="<?php echo $subjects; ?>" href="<?php  echo cn_url_modify(array('reset'), 'mod=editnews', 'act=edit', "id=$topicid"); ?>"><?php echo $subjects; ?></a>
											<?php } 
											else 
											{
												echo $subjects;                                 
											}
											?>
											</div>
										</td>
										<td align='center'><?php $com = isset($rowedit['com']) ? $rowedit['com'] : $rowedit['com']; echo $rowedit['com']; ?></td>
										<td align=''><?php

											// show category name(s)
											//$_fors = count($forums_filters);

											// No category
											//if (count($forums_filters)==0)
											//{ 
												//echo '-';                                     
											//}
											// Single category
											//if ($_fors == 1)
											{  
												echo '<a href="'.cn_url_modify('mod=editnews', 'forum_filters='.$rowedit['forum_id']).'">' . UTF8ToEntities($rowedit['nameforum']) . '</a>';                                                                        
												
											}
											// Multiply
											/*else{
												$_cat_name = array();
												foreach ($entry['cats'] as $_cid) 
												{ 
													if(isset($category[$_cid]))
													{
														$_cat_name[] = $category[$_cid]['name'];                                         
													}
												}
												echo '<a href="'.cn_url_modify('mod=editnews', 'forum_filters='.join(',', $rowedit['forum_id'])).'" title="'.join(', ', $_cat_name).'"><b>multiply</b></a>';
											}*/

										?></td>
										<td align="center" title="<?php echo $rowedit['date']; ?>"><nobr><?php echo date("Y-m-d h:ia", strtotime($rowedit['date'])); ?></nobr></td>
										<td align="center"><a href="<?php echo cn_url_modify('mod=editnews', 'user_filters='.$rowedit['user_id']); ?>"><?php echo UTF8ToEntities($rowedit['username']); ?></a><sup></td>
										<?php //hook('template/editnews/list_item_after', array($ID, $entry)); ?>
										<td align="center"><?php //if ($entry['can']) { ?><input name="selected_news[]" value="<?php echo $rowedit['topicid']; ?>" style="border:0;" type='checkbox'><?php //} ?></td>

									</tr>

								<?php } ?>

							<?php } 
							else 
							{ ?>
								<tr>
									<td style="background: #ff8080; color: white; padding: 16px; text-align: center;">
									--- No news were found matching your criteria ---<br>
									</td>
								</tr>
							<?php } ?>

						</table>

					</td>
				</tr>
			</table>

					<div class="list-footer">
						<div class="actions">

								With selected:
								<select name="subaction"> <!--subaction-->
									<option value="">-- Choose Action --</option>
									<?php if (test('Nud')) { ?><option value="mass_delete">Delete news</option><?php } ?>
									<?php if (test('Nua')) { ?><option value="switch_to_html">Switch to HTML</option><?php } ?>
									<option value="mass_move_to_cat">Change category</option>
									<?php //hook('template/editnews/actions'); ?>
								</select>

								<input type="submit" value="Go">
						</div>

						<!-- Make pagination -->
						<?php //if ($page || $has_next) { ?>
							<div class="pagination">
								<?php
								/*
									if ($page - $per_page >= 0)
									{
										echo '<a href="'.cn_url_modify('mod=editnews', 'page='.($page - $per_page)).'">&lt;&lt; Prev page</a>';
									}
									elseif ($page && $page < $per_page)
									{
										echo '<a href="'.cn_url_modify('mod=editnews', 'page').'">&lt;&lt; Prev page</a>';
									}
									else
									{
										echo '&lt;&lt; Prev page';
									}

									echo ' [<b>'.intval($page / 4).'</b>] ';

									if ($has_next) 
									{
										echo '<a href="'.cn_url_modify('mod=editnews', 'page='.($page + $per_page)).'">Next page &gt;&gt;</a>';
									}
									*/
									
								echo $paginationview; 
								?>
							</div>
						<?php //} ?>
					</div>

				</form>
				
			<!-- ----------------------------------end app cutephp----------------------------------------- -->
				
				
				
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
			
			
			<!--
			<script>
			$(document).ready(function(){
				 //var x = document.getElementById("mySelect").selectedIndex;
				//alert(document.getElementsByTagName("option")[x].value);
				
				
				//				
					
				
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
			 </div> <!-- end func pagination 
			
			-->
		
		
		

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
<!--
<div style="width:15%;float: left;">
	<div id="" class="content">
		<div id="right-column" class="tab2" >
			<strong class="h">INFO</strong>
			<div class="box">Detectand eliminate viruses and Trojan horses, even new and unknown ones.Detect and eliminate viruses and Trojan horses, even new and </div>
		</div>
	</div>
</div>
-->