
$(document).ready(function(){

    var appendVariant = function(num) {
        var offset = "";
        if (num > 0) {
            offset = 'col-sm-offset-3 '
        }
        $("#variants").append('<div class="' + offset + 'col-sm-6">' +
                              '<input type="text" name="pattern[' + num +
                              ']" id="pattern[' + num + ']" class="form-control">' +
                              '</div>');
    }


    var variants = 0;

    $("#addVariant").click(function() {
        appendVariant(variants);
        variants++;
    });

    //add initial variant on load
    appendVariant(variants);
    variants++;
});
