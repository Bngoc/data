function log(msg) {
    try {
        console.log(msg);
    } catch (err) {
    }
}

// ================== Panel Loading ==========================
function show_pane(num, total, contentid) {
    var target, bold, abstract_t;
    // minimize all panes, and unbold title, change number back to grey color
    for (var i = 1; i <= total; i++) {
        target = document.getElementById('news_content_wrapper_' + i);
        abstract_t = document.getElementById('news_abstract_' + i);
        bold = document.getElementById('news_title_' + i);
        //icon	= document.getElementById('news_content_wrapper' + pane + '_' + i);
        if (num == i) {
            target.style.display = "";
            abstract_t.style.display = "none";
            bold.style.fontWeight = "bold";
            //$("#"+target.id+'_content').load('/?m=news&a=contents&id='+contentid);
            $("#" + target.id + '_content').load('/modules/news/contents.php?id=' + contentid);
            // icon.src='/templates/common/images/main_contents_icon_0' + i + '.gif';
        } else {
            target.style.display = "none";
            abstract_t.style.display = "";
            bold.style.fontWeight = "";
            // icon.src='/templates/common/images/main_contents_icon_0' + i + '.gif';
        }
    }
}

// ================== Event Box Rotator ======================
// Set variables
var currentEvent = 1;
var rotateInterval = 7000;
var events = new Array;
var delayTimer = 0;
var nextEvent = 1;
var prevEvent = 0;

var numEvents = 0;

function delayEventTimer() {
    delayTimer = 1;
}

function setOverlayLink(event_id) {
    if ($('#event_image_' + event_id).parents("a").attr("href")) {
        $('#event_box_link').attr("href", $('#event_image_' + event_id).parents("a").attr("href"));
        $('#event_box_link_area').css("cursor", "pointer");
    } else {
        $('#event_box_link').attr("href", "#");
        $('#event_box_link_area').css("cursor", "default");
    }
}

function fadeinEvent(event_id, speed) {
    if (event_id != currentEvent) {
        prevEvent = currentEvent;
        currentEvent = event_id;

        $("#event_image_" + prevEvent).css("z-index", "3");
        $("#event_image_" + currentEvent).css("z-index", "4");

        $("#event_image_" + prevEvent).fadeTo(speed, 0.0);
        $("#event_image_" + currentEvent).fadeTo(speed, 1.0);

        $("#event_button_" + prevEvent).attr("src", "/modules/home/images/event_button_" + prevEvent + ".png");
        $("#event_button_" + currentEvent).attr("src", "/modules/home/images/event_button_" + currentEvent + "a.png");
        setOverlayLink(currentEvent);
    }
}

function rotateEventBox() {
    if (delayTimer == 0) {
        nextEvent++;
        if (nextEvent > numEvents) {
            nextEvent = 1;
        }
        fadeinEvent(nextEvent, '1.0');
    } else {
        delayTimer = 0;
    }
    setTimeout("rotateEventBox()", rotateInterval);
}

function gotoEvent(event_id) {
    fadeinEvent(event_id, '0.5');
    delayTimer = 0;
    delayEventTimer();
}

function initEventBox() {
    numEvents = $(".event_image").length;
    for (i = 1; i <= numEvents; i++) {
        $("#event_button_" + i).show();
        if (i != 1) {
            $("#event_image_" + i).animate({
                opacity: 0
            }, 0);
        }
    }
    for (i = 1; i <= numEvents; i++) {
        $('#event_button_' + i).show();
        if (i != 1) {
            $('#event_image_' + i).show();
        }
    }

    $("#event_image_1").css("z-index", "4");
    setOverlayLink(1);
    setTimeout("rotateEventBox()", rotateInterval);
}