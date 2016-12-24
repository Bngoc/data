var clock = {
    weekDays: ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"],
    monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
    serverDate: {}, // server date obj
    localDate: {}, // local date obj
    dateOffset: {}, // offset ammount
    nowDate: {}, // adjusted date
    dateString: {}, // formated
    el: {}, // element to update
    timeout: {}, // timeout handle
    init: function (date, id, interval) {
        this.calculateOffset(date);
        this.el = document.getElementById(id);
        this.updateClock(interval);
    },
    calculateOffset: function (serverDate) {
        this.serverDate = new Date(serverDate);
        this.localDate = new Date();
        this.dateOffset = this.serverDate - this.localDate;
    },
    updateClock: function (interval) {
        this.nowDate = new Date();
        this.nowDate.setTime(this.nowDate.getTime() + this.dateOffset);
        this.dateFormat(this.nowDate);
        this.el.innerHTML = this.dateString;
        var me = this;
        this.timeout = setTimeout(function () {
            me.updateClock(interval)
        }, interval);
    },
    stopClock: function () {
        clearTimeout(this.timeout);
    },
    dateFormat: function (dateObj) {
        this.dateString = '<span>' + this.digit(dateObj.getHours()) + ':' + this.digit(dateObj.getMinutes()) + ':' + this.digit(dateObj.getSeconds()) + '</span>';
        this.dateString += '  ';
        this.dateString += this.digit(dateObj.getDate()) + '/';
        this.dateString += this.monthNames[dateObj.getMonth()] + '/';
        this.dateString += dateObj.getFullYear();
    },
    digit: function (str) {
        str = String(str);
        str = str.length == 1 ? "0" + str : str;
        return str;
    }
};

var intVal = '0123456789.';
var upVal = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var lowVal = 'abcdefghijklmnopqrstuvwxyz';
var etcVal = ' !"#$%&\'()*+-./~,:;<=>?@[\\]^_`{|}';

var enterVal = '\r\n';
var totalVal = intVal + upVal + lowVal + etcVal + enterVal;

var totalVal1 = intVal + lowVal;
var totalVal2 = intVal + upVal + lowVal;
var notify_img_load = '<div style="padding:2px;"><img src="images/spinner_grey.gif" /></div>';
var notify_img_apccet = '<img style="margin-right:10px" src="images/checkbullet.gif">';
var notify_img_deline = '<img style="margin-right:5px" src="images/alert_icon.gif">';
//var notify_str_deline = 'không hợp lệ';
var notify_str_xd = 'không xác định.';

var arr_error = new Array();
var index = 0;
var index_error = 0;

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

function getId(id) {
    if (document.all) return (document.all[id]);
    else if (document.getElementById) return (document.getElementById(id));
    else if (document.layers) return (document.layers[id]);
    else return null;
}

function check_symbol(value) {
    if (value) {
        for (var i = 0; i < value.length; i++)
            if (-1 != etcVal.indexOf(value.charAt(i))) return true;

        return false;
    }
}
function IsMatchingCode(str) { //IsMatchingCode
    var myRegExp = /(([a-z]{1,}[0-9]{1,})|([0-9]{1,}[a-z]{1,}))[a-z0-9]{0,}/;
    return myRegExp.test(str); // c1
    // if (str.search(myRegExp) == -1) return false;
    // else return true;
}

function check_cap(value) {
    if (value) {
        for (var i = 0; i < value.length; i++)
            if (-1 != upVal.indexOf(value.charAt(i))) return true;

        return false;
    }
}

function addpoint(id) {
    getId(id).value++;
}
function subpoint(id) {
    getId(id).value--;
}

function updateRangeValue() {
    var point_dutru = getId("point_dutru");
    var intNumberValue = getId("intNumberValue");
    intNumberValue.innerHTML = point_dutru.value;
}

function _getpoint() {
//$(".txt-add-sub").on("input change", function() {
    //do something
    $("#rut-point").html($(".formrange").val());
//});
}

function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txt-add-sub").each(function () {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseInt(this.value);
            //$(this).css("background-color", "#FEFFB0");
        }
        else if (this.value.length != 0) {
            $(this).css("background-color", "red");
        }

    });
    var point = raw_p = $('#sum-point').val();
    var haveAddPoint = $('#haveAddPoint').val();
    point -= sum;
    if (point > haveAddPoint) {
        //point = "Point hiện có " + raw_p;
        $(".hd-sms").css("background-color", "red");
    }
    else {
        $(".hd-sms").css("background-color", "#008AA9");
    }

    $('.hd-sms').val(point);
    //return true;
}

$(function () {
    calculateSum();
    _getpoint();
    $(".txt-add-sub").on("keydown keyup", function () {
        calculateSum();
    });

    $(".formrange").on("input change", function () {
        _getpoint();
    });

    $(".button").on("click", function () {

        var $button = $(this);
        var oldValue = parseInt($button.parent().find("input").val());
        if (isNaN(oldValue)) oldValue = 0;
        //var a = $(this).parent().attr('class');alert(oldValue);

//alert($button.parent().find("input").attr('name'));
//alert($button.parent().find("input").attr('id'));
//alert($button.parent().find("input").attr('class'));

        /*
         //add only if the value is number
         if (!isNaN(oldValue) && oldValue.length != 0) {
         //sum += parseFloat(this.value);
         $button.parent().find("input").css("background-color", "#FEFFB0");
         }
         else if (oldValue.length != 0){
         $button.parent().find("input").css("background-color", "red");
         }
         */

        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
        calculateSum();
    });
});

function cap_char(str) {
    if (str) {
        var pv = str.charAt(0);
        var str_ = pv.toUpperCase() + str.substr(1);
        return str_;
    }
    return '';
}


function isAlphabetKey(evt, id) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode >= 48 && charCode <= 57) || (charCode >= 97 && charCode <= 122)) {
        //document.getElementById(id).innerHTML = notify_img_apccet;
        return true;
    }
    else {
        document.getElementById(id).innerHTML = notify_img_deline + '<span style="color:#FF0000">Chỉ được sử dụng chữ thường, số!</span>';
        return false;
    }
}
function isNumKey(evt, id) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode >= 48 && charCode <= 57) {
        document.getElementById(id).innerHTML = '';//notify_img_apccet;
        //arr_error[id] = 0;
        return true;
    }
    else {
        document.getElementById(id).innerHTML = notify_img_deline + '<span style="color:#FF0000">Chỉ được sử dụng số!</span>';
        arr_error[id] = 1;
        return false;
    }
}

function verifyEmail(value, id){
    if (!ischeckEmail(value)) {
        getId(id).innerHTML = covertStrBool('Địa chỉ email không hợp lệ.', false, 2);
        return false;
    } else{
        getId(id).innerHTML = notify_img_apccet;
    }
}

function ischeckEmail(value) {
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filter.test(value))
        return false;
    else return true;
}
function vali_num7(value, num) {
    if (num)
        var pattern_ = '^[0-9]{' + num + '}$';
    else
        var pattern_ = '/^[0-9]$/';
    var pattern = new RegExp(pattern_);
    if (pattern.test(value))
        return true;
    else
        return false;
}

function proce_notify_err(str_val, str_smg_default) {
    var html_err_ = '';

    if (str_val)
        html_err_ = cap_char(str_val + ' ' + (typeof str_smg_default !== 'undefined' ? str_smg_default : notify_str_xd));
    else
        html_err_ = cap_char(notify_str_xd);

    return notify_img_deline + '<span style="color:#FF0000">' + html_err_ + '</span>';
}

function covertStrBool(str_val, bool, number) {
    var img_notify = '';
    if (number == 1) {
        img_notify  = notify_img_load;
    }else if (number == 2) {
        img_notify  = notify_img_deline;
    }else if (number == 3){
        img_notify  = notify_img_apccet;
    }
    var html_err_ = cap_char(str_val);
    var color_text = '';
    if (!bool){
        color_text = '#FF0000';
    }

    return img_notify + '<span style="color:'+ color_text +'">' + html_err_ + '</span>';
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


function menuLayer_open(idname) {
    document.getElementById(idname).style.display = "block";
}
function menuLayer_close(idname) {
    document.getElementById(idname).style.display = "none";
}

//function validateFormOnSubmit(contact) {
function validateFormOnSubmit() {
    var checkValiFormRegist = false;
    for (var key in arr_error){
        if (arr_error[key]) {
            checkValiFormRegist = true;
            break;
        }
    }

    if(!checkValiFormRegist) {
        alert('Vui lòng kiểm tra lại thông tin đăng ký!');
        return false;
    }
}

function findNewUser(value, id, notify_smg) {
    var test_ = 'user_account';

    document.getElementById(id).innerHTML = notify_img_load;
    if (value.length < 4) {
        getId(id).innerHTML = covertStrBool("Tối thiểu 4 kí tự.", false, 2);
        arr_error[id] = 1;
        //index++;
        return false;
    }
    else if (check_symbol(value)) {
        getId(id).innerHTML = covertStrBool("Không sử dụng ký tự đặc biệt.", false, 2);
        arr_error[id] = 1;
        //index++;
        return false;
    }
    else if (!IsMatchingCode(value)) {
        getId(id).innerHTML = covertStrBool("Sử dụng ký tự thường và số.", false, 2);
        arr_error[id] = 1;
        //index++;
        return false;
    }
    else {
        proce_user_from(value, test_, id, notify_smg);
    }
}
function check_num(value, num, id, notify_smg) {
    document.getElementById(id).innerHTML = notify_img_load;
    if (!vali_num7(value, num)) {
        getId(id).innerHTML = covertStrBool("Mã gồm có " + num + " chữ số.", false, 2);// proce_notify_err(notify_smg);
        arr_error[id] = 1;
        return false;
    }
    else {
        getId(id).innerHTML = notify_img_apccet;
        arr_error[id] = 0;
        return true;
    }
}
function checkEmail(value, id) {
    var test_ = 'user_email';
    document.getElementById(id).innerHTML = notify_img_load;

    setTimeout("proce_user_from('" + value + "','" + test_ + "','" + id + "','email')", 300);
}

function proce_user_from(value, act, id, str_smg) { // kt findNewUserTrue
    if (act && id) {

        var action = '';
        var check_ = '';
        var html_err = proce_notify_err(str_smg);
        if (value) {
            if (act == 'user_account') {
                action = 'checkid';
                check_ = 'check_user';
            }
            else if (act == 'user_email') {
                if (!ischeckEmail(value)) {
                    getId(id).innerHTML = covertStrBool('Địa chỉ email không hợp lệ.', false, 2); //html_err;
                    arr_error[id] = 1;
                    return false;
                }
                action = 'checkid';
                check_ = 'check_email';
            }
            else if (act == 'user_character') {
                if (!ischeckEmail(value)) {
                    getId(id).innerHTML = html_err;
                    return false;
                }
                action = 'checkid';
                check_ = 'check_answer';
            }
            else if (act == 'user_character') {
                if (!ischeckEmail(value)) {
                    getId(id).innerHTML = html_err;
                    return false;
                }
                action = 'checkid';
                check_ = 'check_finduser';
            }
            else if (act == 'user_character') {
                if (!ischeckEmail(value)) {
                    getId(id).innerHTML = html_err;
                    return false;
                }
                action = 'checkname';
                check_ = 'check_char';
            }
            else {
                action = check_ = '';
            }
        }

        if (value && action && check_) {
            var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            xmlhttp.open("GET", 'checkForm.php?action=' + action + '&check=' + check_ + '&id=' + value, false);
            xmlhttp.send();

            var str_ = xmlhttp.responseText;
            if (xmlhttp.responseText != 'OK') {
                index++;
                arr_error[id] = 1;
                getId(id).innerHTML = proce_notify_err(str_, '');
            } else {
                index--;
                arr_error[id] = 0;
                getId(id).innerHTML = notify_img_apccet;
            }
        }
    }
}

function pwd_strength(id_value, id_color, id_notify) {

    var cv;
    var fld = getId(id_value);
    var pst = getId(id_color);
    var pid = getId(id_notify);

    var ln = fld.value.length;
    var pv = fld.value.charAt(0);
    var disp = 0;
    if (ln > 2)
        for (var i = 0; i < ln; i++) {
            cv = fld.value.charAt(i);
            disp += (cv - pv) * (cv - pv);
            pv = cv;
        }

    if (disp) disp = Math.log(ln * (2.72 + disp));
    // Password strong level
    if (ln == 0) {
        pst.style.backgroundColor = 'red';
        pid.value = 'Enter password';
    }
    else if (disp < 5) {
        pst.style.backgroundColor = 'red';
        pid.value = 'Very poor';
    }
    else if (disp < 9) {
        pst.style.backgroundColor = '#c08000';
        pid.value = 'Weak';
    }
    else if (disp < 11) {
        pst.style.backgroundColor = '#f0e080';
        pid.value = 'Normal';
    }
    else {
        pst.style.backgroundColor = '#008000';
        pid.value = 'Strong password';
    }
}

function verify_valida(value, name_source, id_smg, str_notify) {
    if (val_source1 = document.getElementsByName(name_source)) {
        var val_source = val_source1[0].value;

        notify_ = typeof str_notify !== 'undefined' ? str_notify : '';
        if (value) {
            if (value != val_source) {
                getId(id_smg).innerHTML = proce_notify_err(notify_, "không giống nhau!");
                arr_error[id_smg] = 1;
            } else {
                getId(id_smg).innerHTML = notify_img_apccet;
                arr_error[id_smg] = 0;
            }
        }
    }
}

function valid_pass(value, id_smg, str_notify) {
    arr_error[id_smg] = 1;
    if (value == "") {
        getId(id_smg).innerHTML = proce_notify_err("Bạn chưa nhập", str_notify);
    }else if(value.length < 6) {
        getId(id_smg).innerHTML = covertStrBool('Mật khẩu dài hơn 6 kí tự', false, 2);
    }else {
        getId(id_smg).innerHTML = '';
        arr_error[id_smg] = 0;
    }
}

function checkPhoneNumber(value, id) {
    getId(id).innerHTML = notify_img_load;
    setTimeout("isNumberPhone('" + value + "', '"+ id +"')", 500);
}
function isNumberPhone(value, id) {
    arr_error[id] = 1;
    var dff = /(\(\+84\)|0)\d{2,3}[-]\d{4}[-]\d{3}$/;
    var pattern = new RegExp(dff);
    if (pattern.test(value)) {
        getId(id).innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
        arr_error[id] = 0;
        return true;
    }else {
        getId(id).innerHTML = notify_img_deline + '<span style="color:#FF0000">Số điện thoại không hợp lệ</span>';
        return false;
    }
}

function renderPhoneTel(value, id) {

    var spaceTemp = '-';

    if (value.length) {
        var textFirst = value.charAt(0);
        var checkText = '';
        var checkTextbool = false;
        if (textFirst == '0') {
            checkTextbool = true;
            checkText = '0';
        } else if (textFirst == '+' || textFirst == '(') {
            checkText = '+';
            value = value.replace(/\(\+84\)/g, '0');
        } else {
            getId(id).value = '';
            return false;
        }

        var cloneValue = value.replace(/\-/g, '');
        var result = checkText;
        var text7 = text73 = '';

        if (cloneValue.length > 1) {
            var chekbool = false;

            var textSecc = cloneValue.charAt(1);
            if (textSecc == '1') {
                chekbool = true;
                if (cloneValue.length >= 2) result += cloneValue.charAt(1);
                if (cloneValue.length >= 3) result += cloneValue.charAt(2);
                if (cloneValue.length >= 4) result += cloneValue.charAt(3) + spaceTemp;
            } else if (textSecc == '8' || textSecc == '9') {
                if (cloneValue.length >= 2) result += cloneValue.charAt(1);
                if (cloneValue.length >= 3) result += cloneValue.charAt(2) + spaceTemp;
            } else {
                if (!checkTextbool) {
                    result = result.replace(/\+/, '(+84)');
                }
                getId(id).value = result;
                return false;
            }

            if (chekbool && cloneValue.length > 4) {
                if (cloneValue.length >= 5) text7 += cloneValue.charAt(4);
                if (cloneValue.length >= 6) text7 += cloneValue.charAt(5);
                if (cloneValue.length >= 7) text7 += cloneValue.charAt(6);
                if (cloneValue.length >= 8) text7 += cloneValue.charAt(7) + spaceTemp;
                if (cloneValue.length >= 9) text73 += cloneValue.charAt(8)
                if (cloneValue.length >= 10) text73 += cloneValue.charAt(9)
                if (cloneValue.length >= 11) text73 += cloneValue.charAt(10)
                if (cloneValue.length >= 12) {
                }
            }

            if (!chekbool && cloneValue.length > 3) {
                if (cloneValue.length >= 4) text7 += cloneValue.charAt(3);
                if (cloneValue.length >= 5) text7 += cloneValue.charAt(4);
                if (cloneValue.length >= 6) text7 += cloneValue.charAt(5);
                if (cloneValue.length >= 7) text7 += cloneValue.charAt(6) + spaceTemp;
                if (cloneValue.length >= 8) text7 += cloneValue.charAt(7)
                if (cloneValue.length >= 9) text7 += cloneValue.charAt(8)
                if (cloneValue.length >= 10) text7 += cloneValue.charAt(9)
                if (cloneValue.length >= 11) {
                }
            }
        }
        if (!checkTextbool) {
            result = result.replace(/\+/, '(+84)');
        }

        getId(id).value = result + text7 + text73;
    }
}

function checkQuestion(value, id) {
    getId(id).innerHTML = notify_img_load;
    setTimeout("checkQuestionTrue('" + value + "', '"+ id +"')", 100);
}
function checkQuestionTrue(value, id) {
    arr_error[id] = 1;
    if (value == '') {
        getId(id).innerHTML = notify_img_deline + '<span style="color:#FF0000">Hãy chọn một câu hỏi</span>';
    } else {
        arr_error[id] = 0;
        getId(id).innerHTML = '';
    }
}

function checkAnswer(value, id) {
    getId(id).innerHTML = "<div style='padding:2px;'><img src=/images/spinner_grey.gif /></div>"
    setTimeout("checkAnswerTrue('" + value + "', '"+ id +"')", 100);
}
function checkAnswerTrue(value, id) {
    arr_error[id] = 1;
    if (value.length < 4) {
        getId(id).innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Câu trả lời cần có 4 ký tự</span>';
    } else if (value.length > 15) {
        getId(id).innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Câu trả lời tối đa 15 ký tự</span>';
    } else {
        arr_error[id] = 0;
        getId(id).innerHTML = '';
    }
}

function checkCaptcha(value, id) {
    arr_error[id] = 1;
    if (value.length == '') {
        getId(id).innerHTML = '<img style="margin-right:5px" src="/images/alert_icon.gif"><span style="color:#FF0000">Chưa nhập mã Captcha</span>';
    } else {
        arr_error[id] = 0;
        getId(id).innerHTML = '';
    }
}


// function checkPassword(id, value) {
//     document.getElementById(id).innerHTML = notify_img_load;
//     //setTimeout("checkPasswordTrue('"+id+"','"+value+"')", 300);
//     setTimeout("valid_Password('" + id + "','" + value + "')", 300);
// }
// function checkPasswordTrue(id, value) {
//
//
//     if (!NumACheck(document.frmRegister.Password.value)) {
//         document.getElementById('Password').innerHTML = '<img style="margin-right:5px" src="images/alert_icon.gif"><span style="color:#FF0000">Mật khẩu không hợp lệ</span>';
//         document.frmRegister.Password.focus();
//         document.frmRegister.Password.value = "";
//         alert("Mật khẩu không được sử dụng dấu cách.");
//         return false;
//     }
//     if (Specialcheck(document.frmRegister.Password.value)) {
//         document.getElementById('Password').innerHTML = notify_img_deline + '<span style="color:#FF0000">Mật khẩu không hợp lệ</span>';
//         document.frmRegister.Password.focus();
//         document.frmRegister.Password.value = "";
//         alert("Mật khẩu không được sử dụng ký tự đặc biệt.");
//         return false;
//     }
//     else
//         document.getElementById('Password').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
// }

//
// function RecheckPassword(id) {
//     document.getElementById('RePassword').innerHTML = notify_img_load;
//     setTimeout("RecheckPasswordTrue('" + id + "')", 500);
// }
// function RecheckPasswordTrue(id) {
//     if ((document.frmRegister.Password.value) != (document.frmRegister.RePassword.value)) {
//         document.getElementById('RePassword').innerHTML = notify_img_deline + '<span style="color:#FF0000">Mật khẩu không giống nhau</span>';
//         document.getElementById('Password').innerHTML = notify_img_deline + '<span style="color:#FF0000">Vui lòng điền lại mật khẩu</span>';
//         alert("Vui lòng kiểm tra lại mật khẩu của bạn");
//         document.frmRegister.Password.focus();
//         document.frmRegister.Password.value = "";
//         document.frmRegister.RePassword.value = "";
//         //return false;
//     }
//     else
//         document.getElementById('RePassword').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
// }

//
// function checkEmail1111(value, id) {
//     document.getElementById(id).innerHTML = notify_img_load;
//     setTimeout("checkEmailTrue('" + id + "','" + value + "','Email')", 1000);
// }
// // function checkEmailTrue(id, value, str_smg) {
//     var hj = proce_notify_err(str_smg);
//     if (!ischeckEmail(value)) {
//         getId(id).innerHTML = proce_notify_err(str_smg);
//         //document.frmRegister.Password.focus();
//         //document.frmRegister.Password.value = "";
//
//         alert("Please provide a valid email address.");
//         return false;
//     }
//     var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
//     xmlhttp.open("GET", 'checkForm.php?action=checkid&check=check_email&id=' + value, false);
//     xmlhttp.send(null);
//     document.getElementById(id).innerHTML = xmlhttp.responseText;
//     cells = id.getElementsByTagName("script");
//     for (var i = 0; i < cells.length; i++) {
//         eval(cells[i].innerHTML);
//     }
// }


// function RecheckEmail(id) {
//     document.getElementById('RecheckEmail').innerHTML = notify_img_load;
//     setTimeout("RecheckEmailTrue('" + id + "')", 1500);
// }
// function RecheckEmailTrue(id) {
//     if ((document.frmRegister.Email.value) != (document.frmRegister.ReEmail.value)) {
//         document.getElementById('RecheckEmail').innerHTML = notify_img_deline + '<span style="color:#FF0000">Email không giống nhau</span>';
//         document.getElementById('checkEmailID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Vui lòng điền lại Email</span>';
//         alert("Vui lòng kiểm tra lại Email của bạn");
//         document.frmRegister.Email.focus();
//         document.frmRegister.Email.value = "";
//         document.frmRegister.ReEmail.value = "";
//         //return false;
//     }
//     else
//         document.getElementById('RecheckEmail').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
// }


// function checkAnswer(id) {
//     document.getElementById('AnswerID').innerHTML = notify_img_load;
//     setTimeout("checkAnswerTrue('" + id + "')", 1000);
// }
// function checkAnswerTrue(id) {
//     if (Specialcheck(document.frmRegister.Answer.value)) {
//         document.getElementById('AnswerID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Câu trả lời bí mật không hợp lệ</span>';
//         document.frmRegister.Answer.focus();
//         document.frmRegister.Answer.value = "";
//         alert("Câu trả lời bí mật không được sử dụng ký tự đặc biệt.");
//         return false;
//     }
//     else if (document.frmRegister.Answer.value.length < 4) {
//         document.getElementById('AnswerID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Câu trả lời cần có ít nhất 4 ký tự</span>';
//         alert("Câu trả lời bí mật cần có ít nhất 4 ký tự");
//     }
//     else
//         document.getElementById('AnswerID').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
// }





function CheckFormRegister() {
    if (document.frmRegister.Account.value == '') {
        alert("Vui lòng kiểm tra tên đăng nhập.");
        return false;
    }
    if (document.frmRegister.Account.value.length < 4) {
        alert("Vui lòng điền tên đăng nhập. Tên đăng nhập phải có ít nhất 4 ký tự !");
        document.frmRegister.Account.focus();
        document.frmRegister.Account.value = "";
        return false;
    }
    if (document.frmRegister.Password.value.length < 6) {
        alert("Vui lòng nhập mật khẩu của bạn. Mật khẩu phải có ít nhất 6 ký tự !");
        document.frmRegister.Password.focus();
        document.frmRegister.Password.value = "";
        return false;
    }
    if ((document.frmRegister.Password.value) != (document.frmRegister.RePassword.value)) {
        alert("Vui lòng kiểm tra lại mật khẩu của bạn");
        document.frmRegister.Password.focus();
        document.frmRegister.Password.value = "";
        document.frmRegister.RePassword.value = "";
        return false;
    }
    if ((document.frmRegister.Email.value.indexOf("@", 0) == -1 || document.frmRegister.Email.value.indexOf(".", 0) == -1)) {
        alert("Địa chỉ Email không hợp lệ");
        return false;
    }
    if ((document.frmRegister.Email.value) != (document.frmRegister.ReEmail.value)) {
        alert("Vui lòng kiểm tra lại Email của bạn");
        document.frmRegister.Email.focus();
        document.frmRegister.Email.value = "";
        document.frmRegister.ReEmail.value = "";
        return false;
    }
    if (document.frmRegister.PhoneNumber.value.length < 9) {
        alert("Vui lòng kiểm tra lại số điện thoại của bạn");
        document.frmRegister.PhoneNumber.focus();
        document.frmRegister.PhoneNumber.value = "";
        return false;
    }
    if (document.frmRegister.Question.value.length < 4) {
        alert("Vui lòng kiểm tra lại câu hỏi bí mật của bạn");
        document.frmRegister.Question.focus();
        document.frmRegister.Question.value = "";
        return false;
    }
    if (document.frmRegister.Answer.value.length < 4) {
        alert("Vui lòng kiểm tra lại câu trả lời bí mật của bạn");
        document.frmRegister.Answer.focus();
        document.frmRegister.Answer.value = "";
        return false;
    }
    if (document.frmRegister.vImageCodP.value.length != 6) {
        alert("Vui lòng kiểm tra lại Mã xác nhận");
        document.frmRegister.vImageCodP.focus();
        document.frmRegister.vImageCodP.value = "";
        return false;
    }
    return true;
}


function findUser(id) {
    document.getElementById(id).innerHTML = notify_img_load;
    setTimeout("findUserTrue('" + id + "')", 1000);
}
function findUserTrue(id) {
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.open("GET", 'checkForm.php?action=finduser&id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('UserID').innerHTML = xmlhttp.responseText;
    cells = UserID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}


function findAnswer(id) {
    document.getElementById('AnswerID').innerHTML = notify_img_load;
    setTimeout("findAnswerTrue('" + id + "')", 1000);
}
function findAnswerTrue(id) {
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.open("GET", 'checkForm.php?action=findanswer&id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('AnswerID').innerHTML = xmlhttp.responseText;
    cells = AnswerID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}


function isNumberKey(evt, id) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        document.getElementById(id).innerHTML = notify_img_deline + '<span style="color:#FF0000">Chỉ được sử dụng số</span>';
        //alert('Bạn chỉ được dùng số, không dùng chữ')
        return false;
    }
    document.getElementById(id).innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
    return true;
}


function CheckFormTranfer() {
    if (document.frmTranfer.Account.value == '') {
        document.getElementById('UserID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Tài khoản nhận không hợp lệ</span>';
        document.frmTranfer.Account.focus();
        return false;
    }
    if (document.frmTranfer.VpointTranfer.value < 10) {
        document.getElementById('VpointTranferID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Nhập số tiền muốn chuyển</span>';
        document.frmTranfer.VpointTranfer.focus();
        document.frmTranfer.VpointTranfer.value = "0";
        return false;
    }
    if (document.frmTranfer.Answer.value.length < 4) {
        document.getElementById('AnswerID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Vui lòng điền câu trả lời bí mật</span>';
        document.frmTranfer.Answer.focus();
        return false;
    }
    return true;
}

function checkCardSerial(id) {
    var strSerial = id.replace("PM", "");
    document.getElementById('CardSerialID').innerHTML = notify_img_load;
    setTimeout("checkCardSerialTrue('" + strSerial + "')", 2000);
}
function checkCardSerialTrue(id) {
    var CardSerialLength;
    switch (document.frmnapthe.CardType.value) {
        case "VTC":
            CardSerialLength = 12;
            break;
        case "Gate":
            CardSerialLength = 10;
            break;
        case "Viettel":
            CardSerialLength = 11;
            break;
        case "Mobi":
            CardSerialLength = 9;
            break;
        case "Vina":
            CardSerialLength = 9;
            break;
        default:
            CardSerialLength = 12;
            break;
    }
    if (document.frmnapthe.CardSerial.value.replace(" ", "").length != CardSerialLength) {
        document.getElementById('CardSerialID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
        alert("Serial thẻ không hợp lệ.\nSerial thẻ phải có " + CardSerialLength + " ký tự. Bạn không được sử dụng dấu cách.");
        document.frmnapthe.CardSerial.focus();
        if (document.frmnapthe.CardType.value == "VTC")
            document.frmnapthe.CardSerial.value = "PM";
        else
            document.frmnapthe.CardSerial.value = "";
    }
    else if (((id / id) != 1) && (id != 0) && (document.frmnapthe.CardType.value == "VTC")) {
        document.getElementById('CardSerialID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
        alert("Serial thẻ không hợp lệ.\nSerial thẻ chỉ bao gồm chữ PM và 10 chữ số.");
        document.frmnapthe.CardSerial.focus();
        if (document.frmnapthe.CardType.value == "VTC")
            document.frmnapthe.CardSerial.value = "PM";
        else
            document.frmnapthe.CardSerial.value = "";
    }
    else
        document.getElementById('CardSerialID').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
}


function checkCardCode(id) {
    document.getElementById('CardCodeID').innerHTML = notify_img_load;
    setTimeout("checkCardCodeTrue('" + id + "')", 2000);
}
function checkCardCodeTrue(id) {
    var CardCodeLength;
    switch (document.frmnapthe.CardType.value) {
        case "VTC":
            CardCodeLength = 12;
            break;
        case "Gate":
            CardCodeLength = 10;
            break;
        case "Viettel":
            CardCodeLength = 13;
            break;
        case "Mobi":
            CardCodeLength = 14;
            break;
        case "Vina":
            CardCodeLength = 12;
            break;
        default:
            CardCodeLength = 12;
            break;
    }
    if (document.frmnapthe.CardCode.value.replace(" ", "").length != CardCodeLength) {
        document.getElementById('CardCodeID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        alert("Mã số thẻ không hợp lệ.\nMã số thẻ phải có " + CardCodeLength + " ký tự. Bạn không được sử dụng dấu cách.");
        document.frmnapthe.CardCode.focus();
        document.frmnapthe.CardCode.value = "";
    }
    else if (((id / id) != 1) && (id != 0)) {
        document.getElementById('CardCodeID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        alert("Mã số thẻ không hợp lệ.\nMã số thẻ chỉ bao gồm " + CardCodeLength + " chữ số.");
        document.frmnapthe.CardCode.focus();
        document.frmnapthe.CardCode.value = "";
    }
    else
        document.getElementById('CardCodeID').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
}


function checkDenominations(id) {
    document.getElementById('DenominationsID').innerHTML = notify_img_load;
    setTimeout("checkDenominationsTrue('" + id + "')", 1000);
}
function checkDenominationsTrue(id) {
    if (document.frmnapthe.Denominations.value == '') {
        document.getElementById('DenominationsID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Hãy chọn mệnh giá thẻ nạp</span>';
        alert("Hãy chọn mệnh giá thẻ nạp của bạn.");
    }
    else
        document.getElementById('DenominationsID').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
}


function CheckFormNapThe() {
    var CardSerialLength;
    var CardCodeLength;
    switch (document.frmnapthe.CardType.value) {
        case "VTC":
            CardSerialLength = 12;
            CardCodeLength = 12;
            break;
        case "Gate":
            CardSerialLength = 10;
            CardCodeLength = 10;
            break;
        case "Viettel":
            CardSerialLength = 11;
            CardCodeLength = 13;
            break;
        case "Mobi":
            CardSerialLength = 9;
            CardCodeLength = 14;
            break;
        case "Vina":
            CardSerialLength = 9;
            CardCodeLength = 12;
            break;
        default:
            CardSerialLength = 12;
            CardCodeLength = 12;
            break;
    }
    if (document.frmnapthe.CardSerial.value.length < CardSerialLength) {
        document.getElementById('checkCardSerialID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
        document.frmnapthe.CardSerial.focus();
        if (document.frmnapthe.CardType.value == "VTC")
            document.frmnapthe.CardSerial.value = "PM";
        else
            document.frmnapthe.CardSerial.value = "";
        return false;
    }
    if (document.frmnapthe.CardCode.value.length < CardCodeLength) {
        document.getElementById('CardCodeID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        document.frmnapthe.CardCode.focus();
        document.frmnapthe.CardCode.value = "";
        return false;
    }
    if (document.frmnapthe.Denominations.value == '') {
        document.getElementById('DenominationsID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Hãy chọn mệnh giá thẻ nạp</span>';
        document.frmnapthe.Denominations.focus();
        return false;
    }
    return true;
}


function CheckCodeVerify(value) {
    if (value.length == 6) {
        document.getElementById('msg_vImageCodP').innerHTML = '<img style="margin-right:10px" src="images/checkbullet.gif">';
    }
    else
        document.getElementById('msg_vImageCodP').innerHTML = notify_img_deline + '<span style="color:#FF0000">Mã xác nhận không hợp lệ</span>';
}


function CheckFormChangeName() {
    if (document.frmChangeName.NewName.value == '') {
        document.getElementById('NewNameID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Vui lòng nhập tên Nhân vật</span>';
        document.frmChangeName.NewName.focus();
        return false;
    }
    if (document.frmChangeName.NewName.value.length < 4) {
        alert("Vui lòng điền tên nhân vật. Tên nhân vật phải có ít nhất 4 ký tự !");
        document.frmChangeName.NewName.focus();
        document.frmChangeName.NewName.value = "";
        return false;
    }
    return true;
}

function findNewName(id) {
    document.getElementById('NewNameID').innerHTML = notify_img_load;
    setTimeout("findNewNameTrue('" + id + "')", 1500);
}
function findNewNameTrue(id) {
    if (Specialcheck(document.frmChangeName.NewName.value)) {
        document.getElementById('NewNameID').innerHTML = notify_img_deline + '<span style="color:#FF0000">Tài khoản không hợp lệ</span>';
        document.frmChangeName.NewName.focus();
        document.frmChangeName.NewName.value = "";
        alert("Tên nhân vật không được sử dụng ký tự đặc biệt.");
        return false;
    }
    var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    xmlhttp.open("GET", 'checkForm.php?action=checkname&id=' + id, false);
    xmlhttp.send(null);
    document.getElementById('NewNameID').innerHTML = xmlhttp.responseText;
    cells = NewNameID.getElementsByTagName("script");
    for (var i = 0; i < cells.length; i++) {
        eval(cells[i].innerHTML);
    }
}

// JavaScript Document
var mouse_is_inside = false;

$(document).ready(function () {

    $('.pao').click(function () {
        if ($('.box_login').is(":hidden")) {
            $('.box_login').slideDown('fast');
            $("i.down").toggleClass("downup");
        } else {
            $('.box_login').slideUp('fast');
            $("i.down").toggleClass("downup");
        }
    });

    $('.box_login').hover(
        function () {
            mouse_is_inside = true;
        }, function () {
            mouse_is_inside = false;
            $('.box_login').hide(600);
            $("i.down").removeClass("downup");
            $("i.down").addClass("down");
        });

    $("body").mouseup(function () {
        if (!mouse_is_inside) {
            $('.box_login').hide(500);
            $("i.down").removeClass("downup");
            $("i.down").addClass("down");
        }
    });

});