<form name="frmRegister" method="post" action="index.php?module=lostinfo" onSubmit="return CheckFormRegister();">
    <table style="width: 100%" cellpadding="2">
        <tr>
            <td colspan="3" class="sub_title_1st">THÔNG TIN TÀI KHO?N<br/></td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo $img_url; ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Nh?p tên tài kho?n</td>
            <td class="bizwebform_col_2"><input name="Account" id="bizwebform" type="text" maxlength="10"
                                                autocomplete="off" onchange="findUser(this.value);"/></td>
            <td class="bizwebform_col_3" id="UserID"></td>
        </tr>
        <tr>
            <td colspan="3" class="sub_title_1st"><br/>THÔNG TIN B?O M?T</td>
        </tr>
        <tr>
            <td colspan="3">
                <div class="vertical-img"><img src="<?php echo $img_url; ?>/vertical-separator.jpg" width="640"
                                               height="1px"/></div>
                <br/></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu h?i bí m?t</td>
            <td class="bizwebform_col_2">
                <select size="1" name="Question" id="bizwebselect" onchange="checkQuestion(this.value);">
                    <option>-- Ch?n câu h?i bí m?t --</option>
                    <option value="myPet" <?php if ($_POST['Question'] == 'myPet') { ?> selected="selected" <?php } ?> >
                        Tên con v?t yêu thích?
                    </option>
                    <option
                        value="mySchool" <?php if ($_POST['Question'] == 'mySchool') { ?> selected="selected" <?php } ?> >
                        Tru?ng c?p 1 c?a b?n tên gì?
                    </option>
                    <option
                        value="bestFriends" <?php if ($_POST['Question'] == 'bestFriends') { ?> selected="selected" <?php } ?> >
                        Ngu?i b?n yêu quý nh?t?
                    </option>
                    <option
                        value="favorGames" <?php if ($_POST['Question'] == 'favorGames') { ?> selected="selected" <?php } ?> >
                        Trò choi b?n thích nh?t?
                    </option>
                    <option
                        value="unforgetArea" <?php if ($_POST['Question'] == 'unforgetArea') { ?> selected="selected" <?php } ?> >
                        Noi d? l?i k? ni?m khó quên nh?t?
                    </option>
                </select>
            </td>
            <td class="bizwebform_col_3" id="checkQuestionID"></td>
        </tr>
        <tr>
            <td class="bizwebform_col_1">Câu tr? l?i bí m?t</td>
            <td class="bizwebform_col_2"><input name="Answer" id="bizwebform" type="text" maxlength="40"
                                                autocomplete="off" onchange="checkAnswer(this.value);"/></td>
            <td class="bizwebform_col_3" id="AnswerID"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding:20px; text-align:center"></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:center">
                <input type="hidden" value="lostinfo" name="action"/>
                <input type="image" src="<?php echo $img_url; ?>/capnhat.png" style="padding-right:10px">
                <img style="cursor:pointer" border="0" src="<?php echo $img_url; ?>/cancel.png"
                     style="padding-left:10px">
            </td>
        </tr>
    </table>
</form>
<table style="width: 100%" cellpadding="2">
    <tr>
        <td colspan="3" style="padding:20px; text-align:center"></td>
    </tr>
    <tr>
        <td colspan="3" class="sub_title_1st">HU?NG D?N<br/></td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="vertical-img"><img src="<?php echo $img_url; ?>/vertical-separator.jpg" width="640"
                                           height="1px"/></div>
            <br/></td>
    </tr>
</table>
<div class="sub_ranking">
    <table id="tbl_ranking">
        <colgroup>
            <col width="690"/>
            <col width="10"/>
        </colgroup>
        <thead>
        <tr>
            <th class="lbg">Luu ý</th>
            <th class="rbg"></th>
        </tr>
        </thead>
        </tbody>
        <tr>
            <td>- M?t kh?u s? du?c l?p 1 cách ng?u nhiên.</td>
        </tr>
        <tr>
            <td>- Thông tin s? du?c g?i vào Email c?a tài kho?n: M?t kh?u, Câu h?i bí m?t, Câu tr? l?i bí m?t.</td>
        </tr>
        </tbody>
    </table>
</div>
<!-- ----------------------------------------------- -->
<form action="<?php echo PHP_SELF; ?>" method="POST">

    <input type="hidden" name="register"/>
    <input type="hidden" name="lostpass"/>

    <table>
        <tr>
            <td>Username</td>
            <td>Email</td>
            <td>Secret word (optional)</td>
        </tr>
        <tr>
            <td><input style="width: 150px;" type="text" name="username"/>
            <td><input style="width: 200px;" type="text" name="email"/></td>
            <td><input style="width: 150px;" type="text" name="secret"/></td>
            <td><input type="submit" value="Send me the Confirmation"></td>
        </tr>
    </table>

    <br/>
    <h3>Tips:</h3>
    <ol>
        <li>If the username and email match in our users database, and email with furher instructions will be sent to
            you.
        </li>
        <li>2. A secret word to protect against unauthorized distribution of letters, as an attacker can get your name
            and e-mail.
            A secret word can not contain spaces!
        </li>
    </ol>

</form>
						