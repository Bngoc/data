function saveRef() {
    var expDays = 365; // Cookie should last one year.
    var expires = new Date();
    var now = expires.getTime();
    expires.setTime(expires.getTime() + (expDays * 24 * 60 * 60 * 1000));
    if (getCookie('referrer') == null) {
        setCookie('referrer', document.referrer, expires);
        setCookie('referral_time', now, expires);
        setCookie('referral_href', window.location.href, expires);
    }
    // Referer is a common mispelling of referrer, even to be found in the HTTP
    // specification, however, not in the DOM specification.
}

function getCookie(key) { // Cookie functions
    var cookieValue = null;

    if (key) {
        var cookieSearch = key + "=";
        if (document.cookie) {
            var cookieArray = document.cookie.split(";");
            for (var i = 0; i < cookieArray.length; i++) {
                var cookieString = cookieArray[i];
                // skip past leading spaces
                while (cookieString.charAt(0) == ' ') {
                    cookieString = cookieString.substr(1);
                }
                // extract the actual value
                if (cookieString.indexOf(cookieSearch) == 0) {
                    cookieValue = cookieString.substr(cookieSearch.length);
                }
            }
        }
    }
    return cookieValue;
}

function setCookie(key, val) {
    if (key) {
        var date = new Date();

        if (val != null) {
            // expires in twenty years
            date.setTime(date.getTime() + (20 * 365 * 24 * 60 * 60 * 1000));
            document.cookie = key + "=" + val + "; expires=" + date.toGMTString() + "; domain=gpotato.com; path=/";
        } else {
            // expires yesterday
            date.setTime(date.getTime() - (24 * 60 * 60 * 1000));
            document.cookie = key + "=; expires=" + date.toGMTString();
        }
    }
}

saveRef();
