/***********************************************
 * Ajax Includes script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
 * This notice MUST stay intact for legal use
 * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
 ***********************************************/

//To include a page, invoke ajaxinclude("afile.htm") in the BODY of page
//Included file MUST be from the same domain as the page displaying it.

var rootdomain = "http://" + window.location.hostname

function ajaxinclude(url) {
    var page_request = false
    if (window.XMLHttpRequest) // if Mozilla, Safari etc
        page_request = new XMLHttpRequest()
    else if (window.ActiveXObject) { // if IE
        try {
            page_request = new ActiveXObject("Msxml2.XMLHTTP")
        }
        catch (e) {
            try {
                page_request = new ActiveXObject("Microsoft.XMLHTTP")
            }
            catch (e) {
            }
        }
    }
    else
        return false
    page_request.open('GET', url, false)	 //get page synchronously
    page_request.send(null)
//setTimeout('writecontent("+page_request+")', 2000)
    writecontent(page_request)

}

function writecontent(page_request) {
    if (window.location.href.indexOf("http") == -1 || page_request.status == 200)
        document.write(page_request.responseText)
}
//setTimeout('alert(rootdomain)', 5000)
