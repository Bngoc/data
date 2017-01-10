/*======================================================================*\
 || #################################################################### ||
 || # vBulletin 4.2.0
 || # ---------------------------------------------------------------- # ||
 || # Copyright �2000-2012 vBulletin Solutions Inc. All Rights Reserved. ||
 || # This file may not be redistributed in whole or significant part. # ||
 || # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
 || # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
 || #################################################################### ||
 \*======================================================================*/
var csspreview;
vBulletin.events.systemInit.subscribe(function () {
    var A = YAHOO.util.Dom.get("clear_all_button");
    if (A) {
        YAHOO.util.Event.on(A, "click", clear_css_customizations)
    }
    if (vBulletin.elements.vB_UserCSSPreview) {
        var B;
        for (var C = 0; C < vBulletin.elements.vB_UserCSSPreview.length; C++) {
            B = vBulletin.elements.vB_UserCSSPreview[C][0];
            YAHOO.util.Dom.get(B).style.display = "";
            YAHOO.util.Event.on(B, "click", preview_css_customizations)
        }
        vBulletin.elements.vB_ProfilefieldEditor = null
    }
});
function preview_css_customizations() {
    if (!csspreview) {
        csspreview = new vB_AJAX_CSSPreview()
    }
    csspreview.move_preview(this.parentNode);
    csspreview.fetch_preview(this.form)
}
function vB_AJAX_CSSPreview() {
    this.progress = "preview_progress";
    this.preview_area = "usercss_example"
}
vB_AJAX_CSSPreview.prototype.move_preview = function (A) {
    A.parentNode.appendChild(YAHOO.util.Dom.get(this.preview_area))
};
vB_AJAX_CSSPreview.prototype.fetch_preview = function (B) {
    this.form = B;
    var A = new vB_Hidden_Form(this.form.action);
    A.add_variable("ajax", 1);
    A.add_variables_from_object(this.form);
    this.ajax_request = YAHOO.util.Connect.asyncRequest("POST", fetch_ajax_url(this.form.action), {
        success: this.handle_ajax_response,
        failure: this.handle_ajax_failure,
        timeout: vB_Default_Timeout,
        scope: this
    }, SESSIONURL + "securitytoken=" + SECURITYTOKEN + "&" + A.build_query_string());
    YAHOO.util.Dom.get(this.progress).style.display = ""
};
vB_AJAX_CSSPreview.prototype.handle_ajax_response = function (F) {
    if (F.responseXML) {
        var B = F.responseXML.getElementsByTagName("error");
        if (B.length) {
            alert(B[0].firstChild.nodeValue)
        } else {
            var G = "";
            var A = F.responseXML.getElementsByTagName("css");
            if (A.length && A[0].firstChild) {
                G = A[0].firstChild.nodeValue
            }
            var C = YAHOO.util.Dom.get("vbulletin_user_css");
            if (C) {
                C.parentNode.removeChild(C)
            }
            var E = document.createElement("style");
            E.type = "text/css";
            E.id = "vbulletin_user_css";
            if (E.styleSheet) {
                E.styleSheet.cssText = G
            } else {
                var D = document.createTextNode(G);
                E.appendChild(D)
            }
            document.getElementsByTagName("head")[0].appendChild(E)
        }
    }
    YAHOO.util.Dom.get(this.progress).style.display = "none"
};
vB_AJAX_CSSPreview.prototype.handle_ajax_failure = function (A) {
};
function clear_css_customizations() {
    var B, D, C;
    var A = YAHOO.util.Dom.get("usercss_editor").getElementsByTagName("fieldset");
    for (D = 0; D < A.length; D++) {
        C = A[D].getElementsByTagName("input");
        for (B = 0; B < C.length; B++) {
            if (C[B].type == "text" && C[B].value != "") {
                C[B].focus();
                C[B].value = "";
                if (YAHOO.util.Dom.hasClass(C[B], "pickerinput")) {
                    console.log("Updating preview for %s", C[B].id);
                    update_color_preview(C[B].id)
                }
            }
        }
        C = A[D].getElementsByTagName("select");
        for (B = 0; B < C.length; B++) {
            if (C[B].selectedIndex != 0) {
                C[B].focus();
                C[B].selectedIndex = 0
            }
        }
    }
    YAHOO.util.Dom.get("usercss_editor").scrollIntoView()
}
function goto_css_error(A, C) {
    var B = YAHOO.util.Dom.get("usercss_" + A + "_" + C);
    if (B) {
        B.scrollIntoView();
        B.focus();
        B.select();
        return false
    }
};