
$(document).ready(function(){

    var appendVariant = function(num) {
        var offset = "";
        $("#variants").append('<div class="row"><div class="' + offset + 'col-sm-9">' +
                              '<input type="text" name="pattern[' + num +
                              ']" id="pattern[' + num + ']" class="form-control">' +
                              '</div></div>');
    }


    var variants = 0;
    $("#variants input").each(function() {
        variants++;
    });

    $("#addVariant").click(function() {
        appendVariant(variants);
        variants++;
    });
});
