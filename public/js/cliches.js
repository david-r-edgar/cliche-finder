
$(document).ready(function(){

    var appendVariant = function(num) {
        $("#variants").append('<div class="row"><div class="col-sm-9">' +
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


    $("#display_name").change(function() {
        if ($("#pattern\\[0\\]").val().length <= 0) {
            $("#pattern\\[0\\]").val($("#display_name").val());
        }
    });
});
