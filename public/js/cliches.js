
$(document).ready(function(){
    var variants = 1;

    $("#addVariant").click(function() {

        var newVariantNumber = variants + 1;
        $("#variants").append('<div class="col-sm-offset-3 col-sm-6">' +
                              '<input type="text" name="pattern' + newVariantNumber +
                              '" id="pattern' + newVariantNumber + '" class="form-control">' +
                              '</div>');
        variants++;
    });

});
