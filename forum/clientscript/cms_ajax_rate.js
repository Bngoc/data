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
function vB_AJAX_CMSRate_Init(D){var C=fetch_object(D);if(AJAX_Compatible&&(typeof vb_disable_ajax=="undefined"||vb_disable_ajax<2)&&C){for(var B=0;B<C.elements.length;B++){if(C.elements[B].type=="submit"){var E=C.elements[B];var A=document.createElement("input");A.type="button";A.className=E.className;A.value=E.value;A.onclick=vB_AJAX_CMSRate.prototype.form_click;E.parentNode.insertBefore(A,E);E.parentNode.removeChild(E)}}}}function vB_AJAX_CMSRate(A){this.formobj=A;this.pseudoform=new vB_Hidden_Form("content.php?"+nodeid+"/rate");this.pseudoform.add_variable("ajax",1);this.pseudoform.add_variable("s",fetch_sessionhash());this.pseudoform.add_variable("securitytoken",SECURITYTOKEN);this.pseudoform.add_variables_from_object(A);this.output_element_id="cmsrating_current"}vB_AJAX_CMSRate.prototype.handle_ajax_response=function(E){if(E.responseXML){var B=E.responseXML.getElementsByTagName("error");if(B.length){YAHOO.vBulletin.vBPopupMenu.close_all();alert(B[0].firstChild.nodeValue)}else{var F=E.responseXML.getElementsByTagName("voteavg");if(F.length&&F[0].firstChild&&F[0].firstChild.nodeValue!=""){fetch_object(this.output_element_id).innerHTML=F[0].firstChild.nodeValue}YAHOO.vBulletin.vBPopupMenu.close_all();var C=YAHOO.util.Dom.get("rating_ratedyes");var A=YAHOO.util.Dom.get("rating_ratedno");if(C&&A){A.style.display="none";C.style.display=""}var D=E.responseXML.getElementsByTagName("message");if(D.length){alert(D[0].firstChild.nodeValue)}}}};vB_AJAX_CMSRate.prototype.rate=function(){if(this.pseudoform.fetch_variable("vote")!=null){YAHOO.util.Connect.asyncRequest("POST",fetch_ajax_url("content.php?"+nodeid+"/rate&vote="+PHP.urlencode(this.pseudoform.fetch_variable("vote"))),{success:this.handle_ajax_response,failure:this.handle_ajax_error,timeout:vB_Default_Timeout,scope:this},this.pseudoform.build_query_string())}};vB_AJAX_CMSRate.prototype.handle_ajax_error=function(A){vBulletin_AJAX_Error_Handler(A);this.formobj.submit()};vB_AJAX_CMSRate.prototype.form_click=function(){var A=new vB_AJAX_CMSRate(this.form);A.rate();return false};