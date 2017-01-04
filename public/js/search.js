





//class representing the input text with the text itself separated from its HTML tags
var SeparatedHTML = function(inputHTML) {
    this.plainText = '';
    this.matchArray = [];

    var tagBody = '(?:[^"\'>]|"[^"]*"|\'[^\']*\')*';
    var tagOrComment = new RegExp(
        '(<(?:'
        // Comment body.
        + '!--(?:(?:-*[^->])*--+|-?)'
        // Special "raw text" elements whose content should be elided.
        + '|script\\b' + tagBody + '>[\\s\\S]*?</script\\s*'
        + '|style\\b' + tagBody + '>[\\s\\S]*?</style\\s*'
        // Regular name
        + '|/?[a-z]'
        + tagBody
        + ')>)',
        'gi');

    var prevIndex = 0;
    while ((tagArray = tagOrComment.exec(inputHTML)) !== null) {
        var matchStartIndex = tagOrComment.lastIndex - tagArray[0].length;
        this.plainText += inputHTML.substring(prevIndex, matchStartIndex);
        this.matchArray.push({index: matchStartIndex, tag: tagArray[0]});
        prevIndex = tagOrComment.lastIndex;
    }
    this.plainText += inputHTML.substring(prevIndex);
}

SeparatedHTML.prototype.getPlainText = function() {
    return this.plainText;
}

SeparatedHTML.prototype.getTagList = function() {
    return this.matchArray;
}










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
        //document.getElementById("inputSearchText").innerHTML = highlightedText;
    }


    //requests matches from the server for the given plain text input
    //returns promise which resolves to array of matches from the server
    var requestMatches = function(plainTextInput) {
        return new Promise(function(resolve, reject) {

            var xhr = new XMLHttpRequest();
            var url = "api/search";
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
                    resolve(true);
                }
            }
            xhr.send(params);
        });
    };


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
        var inputSearchText = document.getElementById("inputSearchText").innerHTML;

        var separatedInput = new SeparatedHTML(inputSearchText);

        console.log(separatedInput.getPlainText());
        console.log(separatedInput.getTagList());

        requestMatches(separatedInput.getPlainText()).then(function(response) {
            console.log("Success!", response);

            //












        });
    }, 1500);

    document.getElementById("inputSearchText").addEventListener("paste", submitSearchRequest);
    document.getElementById("inputSearchText").addEventListener("keyup", submitSearchRequest);
});
