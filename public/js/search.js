

var replaceNonASCII = function(inputText) {
    //FIXME combine all these?
    var nbspRe = /&nbsp;/g
    var nbspRe2 = /\xa0/g
    return inputText.replace(nbspRe, ' ').replace(nbspRe2, '').replace(/[^\x00-\x7F]/g, "");
}





/**
 * Constructor for class representing the input text with the text itself separated from its HTML tags
 * @param {String} inputHTML - the input text string
 */
var SeparatedHTML = function(inputHTML) {
    this.plainText = '';
    this.tagList = [];

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
    //run through the text, searching for the next tag, and when we find it,
    //save, in their separate places, the plain text before it and the tag itself
    while ((tagArray = tagOrComment.exec(inputHTML)) !== null) {
        var matchStartIndex = tagOrComment.lastIndex - tagArray[0].length;
        this.plainText += replaceNonASCII(inputHTML.substring(prevIndex, matchStartIndex));
        this.tagList.push({index: this.plainText.length, tag: tagArray[0]});
        prevIndex = tagOrComment.lastIndex;
    }
    this.plainText += replaceNonASCII(inputHTML.substring(prevIndex));
}

SeparatedHTML.prototype.getPlainText = function() {
    return this.plainText;
}

SeparatedHTML.prototype.getTagList = function() {
    return this.tagList;
}



/**
 * Combines the list of matched cliches with the list of tags, creating an ordered list
 * which can then be reinserted into the plain text.
 *
 * Where necessary, we further split up the matched cliche ranges, to ensure proper
 * nesting inside original tags.
 *
 * @param {Array} matchedRangeList - array of matched cliches and the ranges they cover
 */
SeparatedHTML.prototype.insertMatches = function(matchedRangeList) {

    var fmtOpen = "<span class=hi-li>";
    var fmtClose = "</span>";

    var combinedTagList = [];

    var tagListIndex = 0;
    for (matchedRange of matchedRangeList) {
        while (undefined !== this.tagList[tagListIndex]
                && this.tagList[tagListIndex].index <= matchedRange.beginPosn) {
            combinedTagList.push({index: this.tagList[tagListIndex].index, tag: this.tagList[tagListIndex].tag});
            tagListIndex ++
        }
        combinedTagList.push({index: matchedRange.beginPosn, tag: fmtOpen}); //"cliche text");
        while (undefined !== this.tagList[tagListIndex]
                && this.tagList[tagListIndex].index < matchedRange.endPosn) {
            combinedTagList.push({index: this.tagList[tagListIndex].index, tag: fmtClose});
            combinedTagList.push({index: this.tagList[tagListIndex].index, tag: this.tagList[tagListIndex].tag});
            combinedTagList.push({index: this.tagList[tagListIndex].index, tag: fmtOpen}); //"cliche text");
            tagListIndex ++;
        }
        combinedTagList.push({index: matchedRange.endPosn, tag: fmtClose});
    }
    while (tagListIndex < this.tagList.length) {
        combinedTagList.push({index: this.tagList[tagListIndex].index, tag: this.tagList[tagListIndex].tag});
        tagListIndex++
    }

    this.tagList = combinedTagList;
}




/**
 * Recombines plainText with the tagList.
 * @return {String} the combined output HTML ready to display
 */
SeparatedHTML.prototype.recombine = function() {
    var outputText = "";
    var plainTextIndex = 0;
    for (var tag of this.tagList) {
        //insert all plain text before the tag
        outputText += this.plainText.substring(plainTextIndex, tag.index);
        //insert the tag
        outputText += tag.tag;
        //update the index into the plain text array
        plainTextIndex = tag.index;
    }
    outputText += this.plainText.substring(plainTextIndex, this.plainText.length);
    return outputText;
}















$(document).ready(function() {

    /**
     * Sort and split up matched cliche ranges obtained from the server.
     *
     * The list of cliches we generate should be ordered by start position,
     * and it should not contain any overlapping ranges.
     * i.e. if two cliche matches overlap, then we should output a range of positions where
     * they overlap, which refers to both cliches
     *
     * @param {Array} matchedCliches - unordered array of cliches matched by the server
     * @return {Array} ordered and non-overlapping array of cliche matches
     */
    var sanitiseMatchedCliches = function(matchedCliches) {

        //utility ordered list class (orders only as items pushed into it)
        function OrderedIntList() {
            this.list = [];
        }
        OrderedIntList.prototype.push = function(value) {
            var valueInserted = false;
            for(elem in this.list) {
                if (this.list[elem] > value) {
                    this.list.splice(elem, 0, value);
                    valueInserted = true;
                    break;
                }
            }
            if (!valueInserted) {
                this.list.push(value);
            }
        }

        //first make a list of all boundary points
        var rangeBoundaries = new OrderedIntList;
        for (match of matchedCliches) {
            rangeBoundaries.push(match.beginPosn);
            rangeBoundaries.push(match.endPosn);
        }

        var sortedNonOverlappingMatches = [];

        //then iterate through list of boundary points
        //for each range between one and the next, create a list item
        //pointing to any cliches matched
        for (boundary in rangeBoundaries.list) {
            //fences & fenceposts - create ranges on end boundary point, so none on first
            if (boundary > 0) {
                var range = {
                    beginPosn: rangeBoundaries.list[boundary-1],
                    endPosn: rangeBoundaries.list[boundary],
                    matches: []
                }
                //search matchedCliches list for all cliches matched in this range
                for (match of matchedCliches) {
                    if ((match.beginPosn <= range.beginPosn && match.endPosn > range.beginPosn)
                        ||
                        (match.beginPosn < range.endPosn && match.endPosn >=range.endPosn)) {
                        range.matches.push({cliche: match.cliche, descr: match.descr});
                    }
                }
                if (range.matches.length) {
                    sortedNonOverlappingMatches.push(range);
                }
            }
        }

        return sortedNonOverlappingMatches;
    }


    /**
     * Requests matches from the server for the given plain text input
     * @param {string} plainTextInput - the input text to look for matches within
     * @return {Promise} promise which resolves to array of matches from the server
     */
    var requestMatches = function(plainTextInput) {
        return new Promise(function(resolve, reject) {

            var xhr = new XMLHttpRequest();
            var url = "api/search";

            var formData = new FormData();
            formData.append("input", plainTextInput);

            xhr.open("POST", url);
            xhr.send(formData);

            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    console.log("server responded:", xhr.responseText);
                    resolve(JSON.parse(xhr.responseText).matches);
                }
            }
        });
    };


    /**
     * Returns a function, that, as long as it continues to be invoked, will not
     * be triggered. The function will be called after it stops being called for
     * N milliseconds. If `immediate` is passed, trigger the function on the
     * leading edge, instead of the trailing.
     */
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

    /**
     * Handler routine to deal with new input.
     */
    var submitSearchRequest = debounce(function() {
        var inputSearchText = document.getElementById("inputSearchText").innerHTML;

        var separatedInput = new SeparatedHTML(inputSearchText);

        if (separatedInput.getPlainText().length > 0) {
            requestMatches(separatedInput.getPlainText()).then(function(matchedCliches) {
                var sortedNonOverlappingMatches = sanitiseMatchedCliches(matchedCliches);
                separatedInput.insertMatches(sortedNonOverlappingMatches);

                //want to put html text back together again
                var highlightedText = separatedInput.recombine();
                document.getElementById("inputSearchText").innerHTML = highlightedText;
            });
        }
    }, 1500);

    document.getElementById("inputSearchText").addEventListener("paste", submitSearchRequest);
    document.getElementById("inputSearchText").addEventListener("keyup", submitSearchRequest);
});
