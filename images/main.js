function flashWrite(s, w, h, d, bg, t, f, l) {

    var code = "";
    code = "<object type=\"application/x-shockwave-flash\" ";
    code += "classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" ";
    code += "codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" ";
    code += "width=\"" + w + "\" height=\"" + h + "\" id=\"" + d + "\" align=\"" + l + "\">";

    code += "<param name=\"movie\" value=\"" + s + "\" />";
    code += "<param name=\"quality\" value=\"high\" />";
    code += "<param name=\"wmode\" value=\"" + t + "\" />";
    code += "<param name=\"menu\" value=\"false\" />";
    code += "<param name=\"allowScriptAccess\" value=\"sameDomain\" />";
    code += "<param name=\"swliveconnect\" value=\"true\" />";
    code += "<param name='scale' value='" + f + "' />";
    code += "<param name='salign' value='" + l + "' />";
    code += "<embed src=\"" + s + "\" quality=\"high\" "
    code += "wmode=\"" + t + "\" "
    code += "bgcolor=\"#ffffff\" "
    code += "salign=\"" + l + "\" "
    code += "name=\"" + d + "\" "
    code += "movie=\"" + s + "\" "
    code += "wmode=\"" + t + "\" "
    code += "allowScriptAccess=\"sameDomain\" "
    code += "allowFullScreen=\"false\" "
    code += "menu=\"false\" width=\"" + w + "\" height=\"" + h + "\" "
    code += "type=\"application/x-shockwave-flash\" "
    code += "pluginspage=\"http://www.macromedia.com/go/getflashplayer\"> "
    code += "</embed>"
    code += "</object>"

    document.write(code);
}
function RefreshImage(valImageId) {
    var objImage = document.images[valImageId];
    if (objImage == undefined) {
        return;
    }
    var now = new Date();
    objImage.src = objImage.src.split('?')[0] + '?x=' + now.toUTCString();
}

var intVal = '0123456789.';
var upVal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var lowVal = 'abcdefghijklmnopqrstuvwxyz';
var etcVal = ' ~`!@#$%%^&*()-_=+\|[{]};:\'\",<.>/?';
var enterVal = '\r\n';
var totalVal = intVal + upVal + lowVal + etcVal + enterVal;

var totalVal1 = intVal + lowVal;
var totalVal2 = intVal + upVal + lowVal;

function idpasswdCheck(idchk) {
    var char_cnt, int_cnt;
    char_cnt = 0;
    int_cnt = 0;

    for (var i = 0; i <= idchk.length - 1; i++) {
        ch = idchk.substring(i, i + 1);

        if ((ch >= "A" && ch <= "Z")) {
            char_cnt = char_cnt + 1;
        }
    }

    if (!((char_cnt > 0))) {
        return true;
    } else {
        return false;
    }
}
function tolCheck(value) {
    var i;
    for (i = 0; i < totalVal.length; i++)
        if (value == totalVal.charAt(i)) {
            return true;
        }
    return false;
}

function NumACheck(value) {
    var i;
    for (i = 0; i < value.length; i++)
        if (-1 == totalVal1.indexOf(value.charAt(i))) {
            return false;
        } else {
            return true;
        }
}

function Specialcheck(value) {
    var blankCount = 0;
    var Speccount = 0;

    for (var i = 0; i < value.length; i++) {
        if (value.substring(i, i + 1) == " ") {
            blankCount = blankCount + 1;

        }
        for (j = 0; j < etcVal.length; j++) {
            if (value.substring(i, i + 1) == etcVal.charAt(j)) {
                Speccount = Speccount + 1;
            }
        }
    }

    if (blankCount > 0 || Speccount > 0) {
        return true;
    } else {
        return false;
    }
}

function dataSize(varData) {
    var i, ch;
    var size;

    for (i = 0, size = 0; i < varData.length; i++) {
        ch = varData.charAt(i);
        if (tolCheck(ch)) {
            size++;
        } else {
            size += 2;
        }
    }
    return size;
}
function log_out(B) {

    var A = document.getElementsByTagName("html")[0];
    A.style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
    if (confirm(B)) {
        return true
    } else {
        A.style.filter = "";
        return false
    }
}
function menuLayer_open(idname) {
    document.getElementById(idname).style.display = "block";
}
function menuLayer_close(idname) {
    document.getElementById(idname).style.display = "none";
}


function findCouponCode(coupon) {
    document.getElementById('CouponCode').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("findCouponCodeTrue('" + coupon + "')", 2000);
}


function findCouponCodeTrue(coupon) {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", '/ajax/findcoupon.asp?id=' + coupon, false);
    xmlhttp.send(null);
    document.getElementById('CouponCode').innerHTML = xmlhttp.responseText;
    document.getElementById('CouponCode').style.color = '#ff0000';

    cells = CouponCode.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        //	setTimeout(alert(cells[i].innerHTML), 2000);
        eval(cells[i].innerHTML);
    }
}
function findNewUser(id) {
    document.getElementById('UserID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("findNewUserTrue('" + id + "')", 1000);
}
function findNewUserTrue(id) {


    if (idpasswdCheck(document.frmRegister.Account.value) == false) {
        document.getElementById('UserID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Tài khoản không hợp lệ</span>';
        document.frmRegister.Account.focus();
        document.frmRegister.Account.value = "";
        alert("Tên đăng nhập không hợp lệ.\nTên đăng nhập chỉ được bao gồm chữ và số, không được dùng ký tự đặc biệt, không được dùng chữ HOA.");
        return false;
    }

    if (!NumACheck(document.frmRegister.Account.value)) {
        document.getElementById('UserID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Tài khoản không hợp lệ</span>';
        document.frmRegister.Account.focus();
        document.frmRegister.Account.value = "";
        alert("Tên đăng nhập không hợp lệ.\nTên đăng nhập chỉ được bao gồm chữ và số, không được dùng ký tự đặc biệt hoặc dấu cách.");
        return false;
    }
    if (Specialcheck(document.frmRegister.Account.value)) {
        document.getElementById('UserID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Tài khoản không hợp lệ</span>';
        document.frmRegister.Account.focus();
        document.frmRegister.Account.value = "";
        alert("Tên đăng nhập phải bao gồm từ 4 đến 10 ký tự.\nKhông được phép sử dụng ký tự đặc biệt.");
        return false;
    }

    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", '/ajax/CheckAvailableAccount.asp?id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('UserID').innerHTML = xmlhttp.responseText;

    cells = UserID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}


function checkPassword(id) {
    document.getElementById('Password').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkPasswordTrue('" + id + "')", 1000);
}
function checkPasswordTrue(id) {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", '/ajax/checkPassword.asp?id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('Password').innerHTML = xmlhttp.responseText;

    cells = Password.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}
function RecheckPassword(id) {
    document.getElementById('RePassword').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("RecheckPasswordTrue('" + id + "')", 500);
}
function RecheckPasswordTrue(id) {
    if ((document.frmRegister.Password.value) != (document.frmRegister.RePassword.value)) {

        document.getElementById('RePassword').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Mật khẩu không giống nhau</span>';
        document.getElementById('Password').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Vui lòng điền lại mật khẩu</span>';
        alert("Vui lòng kiểm tra lại mật khẩu của bạn");
        document.frmRegister.Password.focus();
        document.frmRegister.Password.value = "";
        document.frmRegister.RePassword.value = "";
        //return false;
    }
    else
        document.getElementById('RePassword').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
}

function checkEmail(id) {
    document.getElementById('checkEmailID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkEmailTrue('" + id + "')", 1000);
}
function checkEmailTrue(id) {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", '/ajax/checkEmail.asp?id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('checkEmailID').innerHTML = xmlhttp.responseText;

    cells = checkEmailID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}
function RecheckEmail(id) {
    document.getElementById('RecheckEmail').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("RecheckEmailTrue('" + id + "')", 1500);
}
function RecheckEmailTrue(id) {
    if ((document.frmRegister.Email.value) != (document.frmRegister.ReEmail.value)) {

        document.getElementById('RecheckEmail').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Email không giống nhau</span>';
        document.getElementById('checkEmailID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Vui lòng điền lại Email</span>';
        alert("Vui lòng kiểm tra lại Email của bạn");
        document.frmRegister.Email.focus();
        document.frmRegister.Email.value = "";
        document.frmRegister.ReEmail.value = "";
        //return false;
    }
    else
        document.getElementById('RecheckEmail').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
}

function checkDOB(id) {
    document.getElementById('DOBID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkDOBTrue('" + id + "')", 1000);
}
function checkDOBTrue(id) {
    if (document.frmRegister.DOB.value > 2000) {
        document.getElementById('DOBID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Năm sinh không hợp lệ</span>';
        document.frmRegister.DOB.focus();
        document.frmRegister.DOB.value = '';
        alert("Năm sinh không hợp lệ");
    }
    else if (document.frmRegister.DOB.value < 1940) {
        document.getElementById('DOBID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Năm sinh không hợp lệ</span>';
        document.frmRegister.DOB.focus();
        document.frmRegister.DOB.value = '';
        alert("Năm sinh không hợp lệ");
    }
    else if (((id / id) != 1) && (id != 0)) {
        document.getElementById('DOBID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Năm sinh không hợp lệ</span>';
        document.frmRegister.DOB.focus();
        document.frmRegister.DOB.value = '';
        alert("Năm sinh không hợp lệ");
    }
    else {
        document.getElementById('DOBID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}

function checkQuestion(id) {
    document.getElementById('checkQuestionID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkQuestionTrue('" + id + "')", 1000);
}
function checkQuestionTrue(id) {
    if (document.frmRegister.Question.value == '') {
        document.getElementById('checkQuestionID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Hãy chọn  một câu hỏi</span>';
        alert("Hãy chọn  một câu hỏi");
    }
    else {
        document.getElementById('checkQuestionID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}

function checkAnswer(id) {
    document.getElementById('AnswerID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkAnswerTrue('" + id + "')", 1000);
}
function checkAnswerTrue(id) {
    if (document.frmRegister.Answer.value.length < 4) {
        document.getElementById('AnswerID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Câu trả lời cần có 4 ký tự</span>';
        alert("Câu trả lời bí mật cần có ít nhất 4 ký tự");
    }
    else {
        document.getElementById('AnswerID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}
function checkPhoneNumber(id) {
    document.getElementById('PhoneNumberID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("isNumberPhone('" + id + "')", 1000);
}
function isNumberPhone(contents) {

    if (((contents / contents) != 1) && (contents != 0)) {
        document.getElementById('PhoneNumberID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Số điện thoại không hợp lệ</span>';
        document.frmRegister.PhoneNumber.focus();
        document.frmRegister.PhoneNumber.value = "";
        alert('Số điện thoại không hợp lệ');
    }
    else if (document.frmRegister.PhoneNumber.value.length < 9) {
        document.getElementById('PhoneNumberID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Số điện thoại không hợp lệ</span>';
        document.frmRegister.PhoneNumber.focus();
        document.frmRegister.PhoneNumber.value = "";
        alert('Số điện thoại không hợp lệ');
    }
    else {
        document.getElementById('PhoneNumberID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}

function findUser(id) {
    document.getElementById('UserID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("findUserTrue('" + id + "')", 1000);
}
function findUserTrue(id) {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", '/ajax/finduser.asp?id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('UserID').innerHTML = xmlhttp.responseText;

    cells = UserID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}

function findAnswer(id) {
    document.getElementById('AnswerID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("findAnswerTrue('" + id + "')", 1000);
}
function findAnswerTrue(id) {
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    }
    else {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET", '/ajax/findAnswer.asp?id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('AnswerID').innerHTML = xmlhttp.responseText;

    cells = AnswerID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}
var select = {
    action: function (el, state) {
        // state = 0 or 1
        var SelectElement = document.getElementById(el.id);
        var ListElement = SelectElement.getElementsByTagName("ul")[0];
        var ActionElement = ListElement.getElementsByTagName("a");
        if (ListElement.style.display == "block") {
            select.close(ListElement);
            return false;
        } else {
            ListElement.style.display = "block";
        }

        var strSelected = SelectElement.getElementsByTagName("a")[0];
        strSelected.focus();
        for (var i = 0; i < ActionElement.length; i++) {
            if (strSelected.firstChild.nodeValue == ActionElement[i].firstChild.nodeValue) {
                select.elementClass = ActionElement[i];
                select.elementClass.className = "selected";
                ActionElement[i].onclick = function () {
                    return false;
                }
            } else {
                ActionElement[i].onclick = function () {
                    if (this.href.indexOf("javascript") > -1) {
                        eval(this.href);
                    } else if (this.href == "" || this.href.indexOf("#") > -1) {
                    } else if (this.target == "_blank") {
                        window.open(this.href);
                    } else {
                        location.href(this.href);
                    }
                    if (state == 1) {
                        strSelected.firstChild.nodeValue = this.firstChild.nodeValue;
                    }
                    return false;
                }
            }
            ActionElement[i].onmouseover = function () {
                select.elementClass.className = "";
                this.className = "selected";
                select.elementClass = this;
            }
        }

        SelectElement.onmouseover = function () {
            strSelected.onblur = function () {
            }
        }
        SelectElement.onmouseout = function () {
            strSelected.onblur = function () {
                select.close(ListElement);
            }
        }

    },
    close: function (el) {
        select.elementClass.className = "";
        el.style.display = "none";
        return false;
    }
}
function CheckFormNapThe() {
    if (document.frmnapthe.CardCode.value.length < 12) {
        document.getElementById('CardCodeID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
        document.frmnapthe.CardCode.focus();
        document.frmnapthe.CardCode.value = "PM";
        return false;
    }

    if (document.frmnapthe.CardSerial.value.length < 12) {
        document.getElementById('checkCardSerialID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        document.frmnapthe.CardSerial.focus();
        document.frmnapthe.CardSerial.value = "";
        return false;
    }
    if (document.frmnapthe.Denominations.value == '') {
        document.getElementById('DenominationsID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Hãy chọn mệnh giá thẻ nạp</span>';
        document.frmnapthe.Denominations.focus();
        return false;
    }
    return true
}
function checkCardCode(id) {
    var strSerial = id.replace("PM", "");
    document.getElementById('CardCodeID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkCardCodeTrue('" + strSerial + "')", 500);
}
function checkCardCodeTrue(id) {
    if (document.frmnapthe.CardCode.value.replace(" ", "").length != 12) {
        document.getElementById('CardCodeID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
        alert("Serial thẻ không hợp lệ.\nSerial thẻ phải có 12 ký tự. Bạn không được sử dụng dấu cách.");
        document.frmnapthe.CardCode.focus();
        document.frmnapthe.CardCode.value = "PM";
    }
    else if (((id / id) != 1) && (id != 0)) {
        document.getElementById('CardCodeID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
        alert("Serial thẻ không hợp lệ.\nSerial thẻ chỉ bao gồm chữ PM và 10 chữ số.");
        document.frmnapthe.CardCode.focus();
        document.frmnapthe.CardCode.value = "PM";
    }
    else {
        document.getElementById('CardCodeID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}
function checkCardSerial(id) {
    document.getElementById('checkCardSerialID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkCardSerialTrue('" + id + "')", 500);
}
function checkCardSerialTrue(id) {
    if (document.frmnapthe.CardSerial.value.replace(" ", "").length != 12) {
        document.getElementById('checkCardSerialID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        alert("Mã số thẻ không hợp lệ.\nMã số thẻ phải có 12 ký tự. Bạn không được sử dụng dấu cách.");
        document.frmnapthe.CardSerial.focus();
        document.frmnapthe.CardSerial.value = "";
    }
    else if (((id / id) != 1) && (id != 0)) {
        document.getElementById('checkCardSerialID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        alert("Mã số thẻ không hợp lệ.\nMã số thẻ chỉ bao gồm 12 chữ số.");
        document.frmnapthe.CardSerial.focus();
        document.frmnapthe.CardSerial.value = "";
    }
    else {
        document.getElementById('checkCardSerialID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}


function checkDenominations(id) {
    document.getElementById('DenominationsID').innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkDenominationsTrue('" + id + "')", 500);
}
function checkDenominationsTrue(id) {
    if (document.frmnapthe.Denominations.value == '') {
        document.getElementById('DenominationsID').innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Hãy chọn mệnh giá thẻ nạp</span>';
        alert("Hãy chọn mệnh giá thẻ nạp của bạn.");
    }
    else {
        document.getElementById('DenominationsID').innerHTML = '<img style="margin-right:10px" src="/images/checkbullet.gif">';
    }
}

