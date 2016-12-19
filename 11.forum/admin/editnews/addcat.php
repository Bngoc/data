<div id="" style="width:70%;float: left;">
<div id="center-column" class="middle">
	<div class="content left_forums">


	<div class="top-bar"><h1>Contents</h1></div>
	<br>
  <div class="select-bar"></div>
	<div class="table">
	<center>
	<!--                                -------------------                                   -->	
		
		<div id="" class ="left_forums">
		<div class="col_1">
		<form name="form1" method="post" action="">
		<div class ="tieude formapa">
			<span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
			<span class ="cotid"> ID </span>
			<span class="cotname">Name</span>
		</div>
			<ul class="navgray">
				<?php
				$catsql = "SELECT * FROM categories;";
				$catresult =$db->query($catsql);
				if($catresult ->num_rows==0){
					echo"
						<font style='color:red'>Non-Object!</font>
					";
				}
				else{
					while($catrow = $catresult->fetch_assoc()) {
						//echo $catrow['name']; exit();
				?>
				 <li>
					<input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $catrow['id']; ?>">
					<span class ="cotid"><?php echo $catrow['id'];?></span>
					<span class="cotname"><?php echo $catrow['name']; ?></span>
					<!--a class="dm_a" href="#" title="Áo kiểu" target="_self">Áo kiểu</a-->
				 </li>
				 <?php 
				 }
				}
				 ?>
				 
			</ul>
		</form>
			 </div>
		</div>
		
	<!--                                -------------------                                   -->
	</center>
	</div>
</div>

</div>

</div>
<div style="width:15%;float: left;">
	<div id="" class="content">
		<div id="right-column" class="tab2" >
			<strong class="h">INFO</strong>
			<div class="box">Detectand eliminate viruses and Trojan horses, even new and unknown ones.Detect and eliminate viruses and Trojan horses, even new and </div>
		</div>
	</div>
</div>