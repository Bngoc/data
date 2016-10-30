<?php

list($dashboard, $username, $greeting_message) = _GL('dashboard, username, greeting_message');
cn_snippet_messages();
//cn_snippet_bc();
?>
<!-------------------------------------------------- -->
{content}
<div id="maincol">
    <div id="maincol_content">

        <div id="news_wrapper">
            <div id="news">

                <div class="news_n"></div>
                <div class="news_c">
                    <div class="news_content">
                        <div class="title_newshome">

                            <div class="clear"></div>
                        </div>

                        <div id="mainhome_content">
                            <div class="newsitem" style="padding: 0px;">
                                <div class="newsitem_n"></div>
                                <div class="newsitem_c">
                                    <div class="post-head">
                                        <br>
                                    </div>
                                    <div class="post" style="padding-left: 20px;">
                                        <div class="entry">

                                            <ul>
                                                <?php

                                                ?>
                                                <div class="tindiendan">
                                                    <div class="thehientindiendan">
                                                        <div class="clear"></div>
                                                        <div class="clear"></div>

                                                        <script type="text/javascript">
                                                            function thread(threadid, title, poster, threaddate, threadtime) {
                                                                this.threadid = threadid;
                                                                this.title = title;
                                                                this.poster = poster;
                                                                this.threaddate = threaddate;
                                                                this.threadtime = threadtime;
                                                            }
                                                            var threads = new Array(15);
                                                            threads[0] = new thread(228737, 'Cần Bán Ipad air 2 64gb màu gold', 'bombom_101087', '03-13-2016', '11:39 PM');
                                                            threads[1] = new thread(228736, 'Cần Mua màn hình LCD 15\'', 'lienvietbk', '03-13-2016', '11:36 PM');
                                                            threads[2] = new thread(228735, 'Cần Bán Sam sung a8 còn 7 tháng bh chính hãng', 'bombom_101087', '03-13-2016', '11:36 PM');
                                                            threads[3] = new thread(228734, 'Cần Bán Bán lumia 1520', 'bombom_101087', '03-13-2016', '11:32 PM');
                                                            threads[4] = new thread(228733, 'Cần Bán Bb9700,nokia 5233', 'Smartphoneviet', '03-13-2016', '11:18 PM');
                                                            threads[5] = new thread(228732, 'Cần Bán 5 trắng,5s gold', 'Smartphoneviet', '03-13-2016', '11:15 PM');
                                                            threads[6] = new thread(228731, 'TẠI Sao Lại cấm oto Qua cầu việt Trì', 'nhonguoiyeu', '03-13-2016', '10:48 PM');
                                                            threads[7] = new thread(228730, 'Cần Bán jupiter Fi đỏ đen JG', 'thanhtu', '03-13-2016', '10:28 PM');
                                                            threads[8] = new thread(228729, 'Cần Bán nhà thừa cái ổ 500gb của con asus bán dc bn ạ', 'duydodang', '03-13-2016', '10:00 PM');
                                                            threads[9] = new thread(228728, 'Cần Bán samsung galaxy A7 gold', 'phuongxu97', '03-13-2016', '09:10 PM');
                                                            threads[10] = new thread(228727, 'Cần Bán 6700c bạc ra đi', 'nguyenquangminh', '03-13-2016', '09:02 PM');
                                                            threads[11] = new thread(228726, 'Cần Bán xả mấy em 5s gold 16g', 'nguyenquangminh', '03-13-2016', '08:25 PM');
                                                            threads[12] = new thread(228725, 'Khác Cho Thuê Nhà Ở Khu Vực Đền Hùng', 'A.Triệu', '03-13-2016', '04:24 PM');
                                                            threads[13] = new thread(228724, 'Cần Bán Bài thuốc chữa hoàn toàn chứng bệnh viêm amidan', 'anhcof12345', '03-13-2016', '04:19 PM');
                                                            threads[14] = new thread(228723, 'Cần Bán Bán BB Z10-003', 'tyhnqd', '03-13-2016', '04:19 PM');
                                                        </script>
                                                        <script type="text/javascript" align="left">
                                                            <!--
                                                            var max = 8;

                                                            if (threads.length < max) max = threads.length;

                                                            for (i = 0; i < max; i++) {
                                                                if (threads[i].title.length > 100) {
                                                                    threads[i].title = threads[i].title.substring(0, 100) + '...';
                                                                }

                                                                document.write('<img src="./images/post_old.gif"> <a href="http://bien19.biz/forum/showthread.php?t=' + threads[i]['threadid'] + '" target="_blank">' + threads[i]['title'] + '</a><br>');

                                                            }

                                                            //-->
                                                        </script>


                                                        <p>&nbsp;</p>
                                                    </div>
                                                </div>
                                            </ul>
                                            <p>&nbsp;</p>
                                        </div>
                                    </div>

                                </div>

                                <div class="newsitem_s"></div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="news_s"></div>
                <div class="clear"></div>

            </div>
        </div> <!-- news_wrapper //-->


    </div>


</div>   <!--  maincol //-->


<script type="text/javascript">

    var montharray = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December")
    var serverdate = new Date()

    var ap = "AM";
    if (serverdate.getHours() > 11) {
        ap = "PM";
    }

    function padlength(what) {
        var output = (what.toString().length == 1) ? "0" + what : what
        return output
    }

    function padhourlength(what) {
        var output = (what > 12) ? what - 12 : what
        output = (output.toString().length == 1) ? "0" + output : output
        return output
    }

    function displaytime() {
        serverdate.setSeconds(serverdate.getSeconds() + 1);
        var datestring = montharray[serverdate.getMonth()].substring(0, 3) + " " + padlength(serverdate.getDate()) + ", " + serverdate.getFullYear();
        var timestring = padhourlength(serverdate.getHours()) + ":" + padlength(serverdate.getMinutes()) + ":" + padlength(serverdate.getSeconds()) + " " + ap;


        document.getElementById("serverclock_date").innerHTML = datestring;
        document.getElementById("serverclock_time").innerHTML = timestring;
    }

    window.onload = function () {
        setInterval("displaytime()", 1000)
    }
</script>

<div id="rightcol">
    <div id="server_info">
        <ul>
            <li>Kinh nghi?m : <strong>200 EXP</strong></li>
            <li>T? l? roi d? : <strong>60%</strong></li>
            <li>Server : <strong>Full ss6.2</strong></li>
            <li>Antihack : <strong>ICM Protect</strong></li>
        </ul>
    </div>

    <div id="serverclock">
        <div id="serverclock_date"></div>
        <div id="serverclock_time"></div>
    </div>

    <div class="facebook">
        <div class="facebook_content">
            <div class="ranking_list">
                <div class="ranking_sub">
                    <p class="left_sub">TT</p>
                    <p class="right_center">Character</p>
                    <p class="right_sub">Reset</p>
                </div>

                <table>
                    <colgroup>
                        <col width="26px;">
                        <col width="">
                    </colgroup>
                    <tbody>
                    <?php if (!is_array($char) && !is_object($char)) settype($char, 'array');
                    foreach ($char as $char) { ?>
                        <tr style="height:20px">
                            <th><?php echo $char[stt] ?></th>
                            <td style="float:left; font-size:11px"><?php echo $char[name] ?></td>
                            <th><b><?php echo $char[reset] ?></b></th>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div> <!-- rightcol //-->
</div> <!--  //-->  </div> <!--  //-->
<div class="clear"></div>  








