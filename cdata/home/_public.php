<?php

list($dataNotifyForum, $get_paging, $result_RankingTop10) = _GL('dataNotifyForum, get_paging, result_RankingTop10');
echo cn_snippet_messages();
//cn_snippet_bc();
?>
<!-------------------------------------------------- -->

<div id="maincol">
    <div id="maincol_content">

        <div id="news_wrapper">
            <div id="news">
                <div class="news_n"></div>
                <div class="news_c">
                    <div class="news_content">
                        <div class="title_newshome">erlkelkrler</div>
                        <div class="clear"></div>
                        <div id="mainhome_content">
                            <div class="newsitem" style="padding: 0px;">
                                <div class="newsitem_n"></div>
                                <div class="newsitem_c">
                                    <div class="postForum">
                                        <div class="entry">
                                            <?php
                                            if ($dataNotifyForum) {
                                                foreach ($dataNotifyForum as $key => $item) {
                                                    echo '<div class="row-notify"><span class="topx-content-tab"><img src = "/images/post_new.gif" border = "0">&nbsp;';
//                                                    echo '<b class="nofify-Forum">'. $item['keywords'] .'</b>';
                                                    echo '<i class="time-nofify-Forum time-' . $item['nameColor'] . '">' . date('d-m-Y h:i A', $item['lastpost']) . '</i>&nbsp;';
                                                    echo '<a class="overtext" href="' . cn_url_modify(array('reset')) . '/forum/showthread.php?' . $item['threadid'] . '-' . $item['urlForum'] . '&amp;goto=newpost" >' . $item['title'];
                                                    echo '</a></span> <div class="col-right"><a href="/forum/member.php?' . $item['postuserid'] . '-' . $item['postusername'] . '">' . $item['titleUser'] . '</a></div></div>';
                                                }
                                            } else {
                                                echo '<div class="no-notify-forum">Chưa có thông báo mới nhất từ forum!</div>';
                                            } ?>

                                        </div>
                                        <?php echo $get_paging; ?>
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

    var montharray = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var serverdate = new Date();

    var ap = "AM";
    if (serverdate.getHours() > 11) {
        ap = "PM";
    }

    function padlength(what) {
        var output = (what.toString().length == 1) ? "0" + what : what;
        return output
    }

    function padhourlength(what) {
        var output = (what > 12) ? what - 12 : what;
        output = (output.toString().length == 1) ? "0" + output : output;
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
        <div class="news_n"></div>
        <ul class="news_c custom-info-server">
            <li>Kinh nghiệm: <strong>200 EXP</strong></li>
            <li>Tỉ lệ rơi đồ: <strong>60%</strong></li>
            <li>Server: <strong>Full ss6.2</strong></li>
            <li>Antihack: <strong>ICM Protect</strong></li>
        </ul>
        <div class="news_s"></div>
    </div>

    <div id="serverclock">
        <div id="serverclock_date"></div>
        <div id="serverclock_time"></div>
    </div>

    <div class="facebook">
        <div class="facebook_content">
            <div class="ranking_list">
                <table class="ranking_sub">
                    <tr>
                        <th class="title-ranking">TT</th>
                        <th class="title-ranking">Character</th>
                        <th class="title-ranking">RL/RS</th>
                    </tr>
                    <?php if ($result_RankingTop10) {
                        foreach ($result_RankingTop10 as $key => $its) {
                            echo '<tr><td><img src="/images/rankingTop15/' . ($key + 1) . '.gif" alt="' . ($key + 1) . '.gif"></td><td>' . $its['Name'] . '</td><td>' . $its['Relifes'] . '/' . $its['Resets'] . '</td></tr>';
                        }
                    } ?>
                </table>
            </div>
        </div>
    </div>
</div> <!-- rightcol //-->
<div class="clear"></div>








