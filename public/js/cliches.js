
$(document).ready(function(){

    $("#addVariant").click(function() {
        $("#variants").append('<div class="col-sm-offset-3 col-sm-6">' +
                              '<input type="text" name="patternX" id="patternX" class="form-control">' +
                              '</div>');
    });

});
