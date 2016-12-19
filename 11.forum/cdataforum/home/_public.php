<?php

list($dashboard, $username, $greeting_message) = _GL('dashboard, username, greeting_message');
cn_snippet_messages();
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
                        <div class="title_newshome">

                            <div class="clear"></div>
                        </div>

                        <div id="mainhome_content">
                            <div class="newsitem" style="padding: 0px;">
                                <div class="newsitem_n"></div>
                                <div class="newsitem_c">
                                    <div class="post" style="padding-left: 20px;">
                                        <div class="entry">
                                            <img src="/images/post_old.gif"><a href="">flelekjmglkemjgleklg</a>
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








