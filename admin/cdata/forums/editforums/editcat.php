<div id="" style="width:70%;float: left;">
    <div id="center-column" class="middle">

        <?php
        require('./config.php');
        ?>
        <div id="" class="left_forums">
            <div class="col_1">
                <div class="tieude">
                    <span style="text-algin:center;"><strong>CATAGORIS</strong> </span>
                    <span>
				<select style="width:150px" id="mySelect" name="mySelect" class="cmuc"> <!-- onchange="showUser(this.value)" -->
					<option value="0">--Select--</option>
                    <?php
                    $catsql = "SELECT * FROM categories;";
                    $catresult1 = $db->query($catsql);
                    if ($catresult1->num_rows == 0) {
                        echo "<font style='color:red'>Non-Object!</font>";
                    } else {

                        while ($catrow1 = $catresult1->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $catrow1['id']; ?>"><?php echo $catrow1['name']; ?></option>
                        <?php }
                    }
                    ?>										
				</select>
			</span>
                    <span style="float:right;"><strong>Delete multiple rows in mysql</strong> </span>
                </div>


                <!--button type="button" onclick="myFunction()">Try it</button><p id="demo"></p-->

                <?php
                //$selectOption = $_POST['mySelect'];
                //$test = explode('|', $_POST['mySelect']);

                //echo $('div.mySelect select').val('val2');
                //$q = intval($_GET['q']); //echo $q;

                $form_data = "account=" . 6 . "&accnhan={$account}";
                @file_get_contents($config_basedir . "/admin.php?" . $form_data);
                ?>

                <div id="txtHint" class="sb">

                    <li>
                        <span><input class="checkbx" name="checkbox[]" type="checkbox" id="checkbox[]" value=""></span>
                        <span class="cotid">ID</span>
                        <span class="cotid">Cat_id</span>
                        <span class="cotname">Name</span>
                        <!--span class ="cotdescri">Description</span-->
                    </li>
                </div>

                <script type="text/javascript">

                    $(document).ready(function () {
                        $(".cmuc").change(function () {
                            var id = $(this).val();
                            var id = 'id=' + id;
                            //alert(cate_name);
                            $.ajax({
                                type: "POST",
                                url: "fech_select.php",
                                data: id,
                                cache: false,
                                success: function (html) {
                                    $(".sb").html(html);
                                    //alert("Dang them sub muasam");
                                }
                            });
                        });

                        $(".ccmuc").change(function () {
                            var id = $(this).val();
                            var id = 'id=' + id;
                            //alert(cate_name);
                            $.ajax({
                                type: "POST",
                                url: "fech_select_mess.php",
                                data: id,
                                cache: false,
                                success: function (html) {
                                    $(".csb").html(html);
                                    //alert("Dang them sub muasam");
                                }
                            });
                        });

                    });
                </script>
                <!--script type="text/javascript">
                    function myFunction(){ //run some code when "onchange" event fires
                        var x = document.getElementById("mySelect").value;
                        document.getElementById("demo").innerHTML = x;
                    }
                </script>
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
                      xmlhttp.open("GET","div.php?q="+str,true);
                      xmlhttp.send();
                    }
                </script-->

                <!--div id="txtHint"><b>Person info will be listed here.</b></div-->
            </div>
        </div>
    </div>
</div>


<div style="width:15%;float: left;">
    <div id="" class="content">
        <div id="right-column" class="tab2">
            <strong class="h">INFO</strong>
            <div class="box">Detectand eliminate viruses and Trojan horses, even new and unknown ones.Detect and
                eliminate viruses and Trojan horses, even new and
            </div>
        </div>
    </div>
</div>