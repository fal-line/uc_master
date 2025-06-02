// $(document).ready(function () {
//     $("input").on("change", function () {
//         $("#commit-button").attr("disabled", false);
//         $("#commit-button").removeClass("btn-secondary");
//         $("#commit-button").addClass("btn-success");
//     });
// });

$(document).ready(function () {
    $("#cartModal").modal("toggle");

    $("#refresh").click(function () {
        location.reload();
    });
});
