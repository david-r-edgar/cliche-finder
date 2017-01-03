
$(document).ready(function() {
    var highlightMatches = function(matchArray) {
        var highlightedText = document.getElementById("inputSearchText").innerText;
        var offset = 0;
        var fmtOpen = "<span class=hi-li>";
        var fmtClose = "</span>";

        //FIXME need to sort first (on server side?)
        for (match in matchArray) {
            console.log(matchArray[match]);
            var posn = matchArray[match].posn + offset;
            highlightedText = highlightedText.substr(0, posn) + fmtOpen + highlightedText.substr(posn);
            offset += fmtOpen.length;
            posn = matchArray[match].posn + matchArray[match].len + offset;
            highlightedText = highlightedText.substr(0, posn) + fmtClose + highlightedText.substr(posn);
            offset += fmtClose.length;
        }
        document.getElementById("inputSearchText").innerHTML = highlightedText;
    }




    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    var submitSearchRequest = debounce(function() {
        var xhr = new XMLHttpRequest();
        var url = "api/search";
        var inputSearchText = document.getElementById("inputSearchText").innerText;
        var inputSearchText = encodeURIComponent(
          document.getElementById("inputSearchText").innerText).replace(/%20/g, "+");
        console.log("inputSearchText:", inputSearchText);
        var params = "input=" + inputSearchText + "&content-type=text/plain";
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                highlightMatches(JSON.parse(xhr.responseText).matches);
            }
        }
        xhr.send(params);
    }, 500);

    document.getElementById("inputSearchText").addEventListener("paste", submitSearchRequest);
    document.getElementById("inputSearchText").addEventListener("keyup", submitSearchRequest);
});
