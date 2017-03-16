$(document).ready(function(){

    $(".cotd-list-note, .cotd-list-date").keydown(function() {
        $clicheRow = $(this).closest(".cotd-cliche-row");
        $clicheRow.find(".cotd-list-date input").first().removeClass("to-be-removed");
        $clicheRow.find(".cotd-list-note input").first().removeClass("to-be-removed");
    });

    $(".cotd-list-note, .cotd-list-date").change(function() {
        if ($(this).length > 0) {
            $clicheRow = $(this).closest(".cotd-cliche-row");
            $clicheRow.find(".cotd-list-cbox").first().prop('checked', true);

            $clicheRow.addClass("to-be-added");
        }
    });

    $(".cotd-list-cbox").change(function() {
        if (this.checked) {

            $clicheRow = $(this).closest(".cotd-cliche-row");

            $clicheRow.find(".cotd-list-date input").first().removeClass("to-be-removed");
            $clicheRow.find(".cotd-list-note input").first().removeClass("to-be-removed");
            $clicheRow.addClass("to-be-added");
        } else {
            $clicheRow = $(this).closest(".cotd-cliche-row");

            $clicheRow.find(".cotd-list-date input").first().addClass("to-be-removed");
            $clicheRow.find(".cotd-list-note input").first().addClass("to-be-removed");
            $clicheRow.removeClass("to-be-added");
        }
    });
});

