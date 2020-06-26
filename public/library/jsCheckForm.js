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
var notify_img_load = '<div style="padding:2px;"><img src="/public/images/spinner_grey.gif" /></div>';
var notify_img_apccet = '<img style="margin-right:10px" src="/public/images/checkbullet.gif">';
var notify_img_deline = '<img style="margin-right:5px" src="/public/images/alert_icon.gif">';
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


// function Specialcheck(value) {
//     var blankCount = 0;
//     var Speccount = 0;
//
//     for (var i = 0; i < value.length; i++) {
//         if (value.substring(i, i + 1) == " ") {
//             blankCount = blankCount + 1;
//
//         }
//         for (j = 0; j < etcVal.length; j++) {
//             if (value.substring(i, i + 1) == etcVal.charAt(j)) {
//                 Speccount = Speccount + 1;
//             }
//         }
//     }
//
//     if (blankCount > 0 || Speccount > 0) {
//         return true;
//     } else {
//         return false;
//     }
// }

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
        for (var i = 0; i < value.length; i++){
            if (-1 != upVal.indexOf(value.charAt(i))) return true;
        }

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

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
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

function verifyEmail(value, id) {
    if (!ischeckEmail(value)) {
        getId(id).innerHTML = covertStrBool('Địa chỉ email không hợp lệ.', false, 2);
        return false;
    } else {
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
        img_notify = notify_img_load;
    } else if (number == 2) {
        img_notify = notify_img_deline;
    } else if (number == 3) {
        img_notify = notify_img_apccet;
    }
    var html_err_ = cap_char(str_val);
    var color_text = '';
    if (!bool) {
        color_text = '#FF0000';
    }

    return img_notify + '<span style="color:' + color_text + '">' + html_err_ + '</span>';
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

function validateFormOnSubmit($op) {
    var checkValiFormRegist = false;
    for (var key in arr_error) {
        if (arr_error[key]) {
            checkValiFormRegist = true;
            break;
        }
    }

    if (!checkValiFormRegist) {
        alert('Vui lòng kiểm tra lại thông tin!');
        return false;
    }
    if ($op) {
        var verifyDel = confirm($op);
        if (!verifyDel) {
            return false;
        }
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
        getId(id).innerHTML = covertStrBool("Mã gồm có " + num + " chữ số.", false, 2);
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
    } else if (value.length < 6) {
        getId(id_smg).innerHTML = covertStrBool('Mật khẩu dài hơn 6 kí tự', false, 2);
    } else {
        getId(id_smg).innerHTML = '';
        arr_error[id_smg] = 0;
    }
}

function checkPhoneNumber(value, id) {
    getId(id).innerHTML = notify_img_load;
    setTimeout("isNumberPhone('" + value + "', '" + id + "')", 500);
}
function isNumberPhone(value, id) {
    arr_error[id] = 1;
    var dff = /(\(\+84\)|0)\d{2,3}[-]\d{4}[-]\d{3}$/;
    var pattern = new RegExp(dff);
    if (pattern.test(value)) {
        getId(id).innerHTML = '<img style="margin-right:10px" src="/public/images/checkbullet.gif">';
        arr_error[id] = 0;
        return true;
    } else {
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
    setTimeout("checkQuestionTrue('" + value + "', '" + id + "')", 100);
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
    getId(id).innerHTML = "<div style='padding:2px;'><img src=/public/images/spinner_grey.gif /></div>"
    setTimeout("checkAnswerTrue('" + value + "', '" + id + "')", 100);
}
function checkAnswerTrue(value, id) {
    arr_error[id] = 1;
    if (value.length < 4) {
        getId(id).innerHTML = '<img style="margin-right:5px" src="/public/images/alert_icon.gif"><span style="color:#FF0000">Câu trả lời cần có 4 ký tự</span>';
    } else if (value.length > 15) {
        getId(id).innerHTML = '<img style="margin-right:5px" src="/public/images/alert_icon.gif"><span style="color:#FF0000">Câu trả lời tối đa 15 ký tự</span>';
    } else {
        arr_error[id] = 0;
        getId(id).innerHTML = '';
    }
}

function checkCaptcha(value, id) {
    arr_error[id] = 1;
    if (value.length == '') {
        getId(id).innerHTML = '<img style="margin-right:5px" src="/public/images/alert_icon.gif"><span style="color:#FF0000">Chưa nhập mã Captcha</span>';
    } else {
        arr_error[id] = 0;
        getId(id).innerHTML = '';
    }
}

function checkCardSerial(val, opt,  idSms) {
    // var strSerial = id.replace("PM", "");
    getId(idSms).innerHTML = notify_img_load;
    setTimeout("checkCardSerialTrue('" + val + "', '" + opt + "', '" + idSms + "')", 500);
}

function checkCardSerialTrue(value, opt, idSms) {
    var CardSerialLength;
    switch (value) {
        case "vtc":
            CardSerialLength = 12;
            break;
        case "gate":
            CardSerialLength = 10;
            break;
        case "viettel":
            CardSerialLength = 11;
            break;
        case "mobi":
            CardSerialLength = 9;
            break;
        case "vina":
            CardSerialLength = 9;
            break;
        default:
            // CardSerialLength = 12;
            break;
    }
    if (value.length != CardSerialLength) {
        getId(idSms).innerHTML = notify_img_deline + '<span style = "color:#FF0000"> Serial thẻ không hợp lệ </span> ';
//         document.frmnapthe.CardSerial.focus();
//         if (document.frmnapthe.CardType.value == "VTC")
//             document.frmnapthe.CardSerial.value = "PM";
//         else
//             document.frmnapthe.CardSerial.value = "";
    }
    else if (((id / id) != 1) && (id != 0)) {
        // else if (((id / id) != 1) && (id != 0) && (document.frmnapthe.CardType.value == "VTC")) {
        getId(idSms).innerHTML = notify_img_deline + '<span style="color:#FF0000">Serial thẻ không hợp lệ</span>';
//         document.frmnapthe.CardSerial.focus();
//         if (document.frmnapthe.CardType.value == "VTC")
//             document.frmnapthe.CardSerial.value = "PM";
//         else
//             document.frmnapthe.CardSerial.value = "";
    } else {
        getId(idSms).innerHTML = '<img style="margin-right:10px" src="/public/images/checkbullet.gif">';
    }
}

function checkCardCode(val, opt,  idSms) {
    getId(idSms).innerHTML = notify_img_load;
    setTimeout("checkCardCodeTrue('" + val + "', '" + opt + "', '" + idSms + "')", 500);
}
function checkCardCodeTrue(value, opt, idSms) {
    var CardCodeLength;
    switch (opt) {
        case "vtc":
            CardCodeLength = 12;
            break;
        case "gate":
            CardCodeLength = 10;
            break;
        case "viettel":
            CardCodeLength = 13;
            break;
        case "mobi":
            CardCodeLength = 14;
            break;
        case "vina":
            CardCodeLength = 12;
            break;
        default:
            // CardCodeLength = 12;
            break;
    }
    if (value.length != CardCodeLength) {
        getId(idSms).innerHTML = notify_img_deline + '<span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        // document.frmnapthe.CardCode.focus();
        // document.frmnapthe.CardCode.value = "";
    }
    else if (((id / id) != 1) && (id != 0)) {
        getId(idSms).innerHTML = notify_img_deline + '<span style="color:#FF0000">Mã số thẻ không hợp lệ</span>';
        // document.frmnapthe.CardCode.focus();
        // document.frmnapthe.CardCode.value = "";
    } else {
        getId(idSms).innerHTML = '<img style="margin-right:10px" src="/public/images/checkbullet.gif">';
    }
}

// JavaScript Document
var mouse_is_inside = false;

$(document).ready(function () {

    $('body').on('click', '.pao', function () {
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

    $("#changeNumber, .changeNumber").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
            // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
