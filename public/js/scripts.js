$(function () {
    $(".alert-info, .alert-success").delay(3200).fadeOut();
});


$(function () {
    $(".delete-item").click(function (e) {
        e.preventDefault();
        aHref = $(this).attr('href');
        bootbox.confirm("Are you sure that you want to delete this?", function (conf) {
            if (conf) {
                window.location.href = aHref;
            }
        });
    })
});