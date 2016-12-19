<div id="" style="width:70%;float: left;">
<div id="center-column" class="middle">
	<div class="content left_forums">
		<div class="col_1 tab2">
			<div class="tieude">
				<span style="text-algin:center;"><strong>FORUMS</strong> </span>
				<span>
				
				<select style="width:150px" id="mySelect" name="" class="ccmuc" onchange="showUser(this.value)" >
					<option value="0">--Select--</option>
					<?php 
					$catsql = "SELECT * FROM categories;";
					$catresult =$db->query($catsql);
					if($catresult ->num_rows==0){
						echo"<font style='color:red'>Non-Object!</font>";
					}
					else{
						while($catrow = $catresult ->fetch_assoc()){
						?>
						<optgroup label="<?php echo $catrow['name']; ?>">
						<?php
						$catsql1 = "SELECT * FROM forums WHERE cat_id =" . $catrow['id'] . ";";
						$catresult1 =$db->query($catsql1);
						if($catresult1 ->num_rows==0){
							echo"<font style='color:red'>Non-Object!</font>";
						}
						else{
							
							while($catrow1 = $catresult1 ->fetch_assoc()){
						?>
							<option value="<?php echo $catrow1['id']; ?>"><?php echo $catrow1['name']; ?></option>
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
				<span style="float:right;"><strong>Delete multiple rows in mysql</strong> </span>
			</div>
			
			<div id="txtHint" class ="csb"></div>
			<?php 
			//if($_REQUEST){$sb_name = $_REQUEST['id']; echo $sb_name;}
				//$q = intval($_GET['q']); echo $q;
			//$selectOption = $_GET['id']; ECHO $selectOption; ?>
			<!--<li>
				<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
				<span class ="cotid" >ID</span>
				<span class ="cotid">Date</span>
				<span class ="cotname">User_Id</span>
				<span class ="cotdescri">Forum_Id</span>
				<span class ="cotdescri">Subject</span>
			</li>
			<!-- ----------------------------------------------------- -->
			<?php
			//$row_per_page=3;//<span class="Apple-tab-span" style="white-space: pre;"> </span>; //Số dòng trên 1 trang

			/*
			if ($rows>$row_per_page) 
				$page=ceil($rows/$row_per_page);
			else $page=1; //nếu số dòng trong CSDL nhỏ hơn hoặc bằng số dòng trên 1 trang thì chỉ có 1 trang để hiển thị

			if(isset($_GET['start']) && (int)$_GET['start'])
				 $start=$_GET['start']; //dòng bắt đầu từ nơi ta muốn lấy
			else $start=0;

			$sql=mysql_query("select * from dangky order by id asc limit $start,$row_per_page"); //bắt đầu lấy dữ liệu (^)_(^)
			*/
			?>
			
			<!--<form name="form1" method="post" action="">
				<li>
				<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
				<span class ="cotid" >ID</span>
				<span class ="cotid">Date</span>
				<span class ="cotname">User_Id</span>
				<span class ="cotdescri">Forum_Id</span>
				<span class ="cotdescri">Subject</span>
				<li>
				<?php 
				/*	$id = $_REQUEST['id'];
					echo $id; 
					exit();
					$catsql1 = "SELECT * FROM topics WHERE forum_id=".$id.";";
					$catresult1 =$db->query($catsql1);
					$numrows =$catresult1 ->num_rows;
				// ------------------------------------------
				
				if ($numrows>$row_per_page) 
					$page=ceil($numrows/$row_per_page);
				else $page=1; //nếu số dòng trong CSDL nhỏ hơn hoặc bằng số dòng trên 1 trang thì chỉ có 1 trang để hiển thị

				if(isset($_GET['start']) && (int)$_GET['start'])
					 $start=$_GET['start']; //dòng bắt đầu từ nơi ta muốn lấy
				else $start=0;
				
				$limitrows=$db ->query("SELECT * FROM topics WHERE forum_id=" . $id . " order by id asc limit " .$start . "," . $row_per_page . ";"); //bắt đầu lấy dữ liệu (^)_(^)
				//-- ------------------------------------------  -->
				if($numrows==0){
					echo"<font style='color:red'>Non-Object!</font>";
				}
				else{
					while($catrow1 = $limitrows ->fetch_assoc()){ 
				*/?>
				<li>
					<span><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $catrow1['id']; ?>"></span>
					<span class ="cotid" ><?php// echo $catrow1['id']; ?></span>
					<span class ="cotid"><?php //echo $catrow1['date']; ?></span>
					<span class ="cotname"><?php //echo $catrow1['user_id']; ?></span>
					<span class ="cotname"><?php //echo $catrow1['forum_id']; ?></span>
					<span class ="cotdescri"><?php //echo $catrow1['subject']; ?></span>
				</li>

				<?php
				/*	}
				}
					$page_cr=($start/$row_per_page)+1;
					for($i=1;$i<=$page;$i++){
						if ($page_cr!=$i) echo "<div class='phantrang'><a href='admin.php?mod=Catagoris&act=delcat&id=" . $id ."&start=".$row_per_page*($i-1)."'>$i&nbsp;</a>"."</div>";
						else echo "<div class='phantrang'>".$i." "."</div>";
					}
				*/
				?>

				<li>
				<span><input name="delete" type="submit" id="delete" value="Delete"></span>
				</li>

				<?php
				/*
				// Check if delete button active, start this 
				if($delete){
				for($i=0;$i<$count;$i++){
				$del_id = $checkbox[$i];
				$sql = "DELETE FROM $tbl_name WHERE id='$del_id'";
				$result = mysql_query($sql);
				}
				// if successful redirect to delete_multiple.php 
				if($result){
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=delete_multiple.php\">";
				}
				}
				mysql_close();
				
				*/?>

			</form>
			
			
			<!-- --------------------------------------------------------- -->
		<!--/div-->
			
		</div>
	</div>
</div>

</div>
<!--
	<script type="text/javascript">
		
		$(document).ready(function(){
			/*
			$(".cmuc").change(function(){
				var id=$(this).val();
				var id = 'id='+ id;
				//alert(cate_name);
				$.ajax({
					type: "POST",
					//url: "fech_select.php",
					url: "fech_select.php",
					data: id,
					cache: false,
					success: function(html)
					{
						$(".sb").html(html);
						//alert("Dang them sub muasam");
					} 
				});
			});
			*/
			
			$(".ccmuc").change(function(){
				var id=$(this).val();
				var id = 'id='+ id;
				//alert(cate_name);
				$.ajax({
					type: "POST",
					url: "admin/fech_select_mess.php",
					data: id,
					cache: false,
					success: function(html)
					{
						$(".csb").html(html);
						alert("Dang them sub muasam");
					} 
				});
			});
			
		});
	</script>
		-->
	<script type="text/javascript">
		function showUser(str) {
		  
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
		  xmlhttp.open("GET","admin/getuser.php?q="+str,true);
		  xmlhttp.send();
		}
	</script>
		
	<script type="text/javascript">
		function myFunction(){ //run some code when "onchange" event fires
			var x = document.getElementById("mySelect").value;
			document.getElementById("demo").innerHTML = x;
		}
	</script>

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