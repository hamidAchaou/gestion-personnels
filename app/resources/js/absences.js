import "https://code.jquery.com/jquery-3.6.0.min.js";

function submitForm() {
    document.getElementById("importForm").submit();
}

$(document).ready(function () {
    $("#filterSelectMotif").change(function () {
        var neededUrl = window.location.pathname;
        var motif = $(this).val();
        $.ajax({
            url: neededUrl + "/filter-by-motif",
            method: "GET",
            data: { motif: motif },
            success: function (data) {
                console.log(data);
                var newData = $(data);

                $("tbody").html(newData.find("tbody").html());
                $("#card-footer").html(newData.find("#card-footer").html());
                var paginationHtml = newData.find(".pagination").html();
                if (paginationHtml) {
                    $(".pagination").html(paginationHtml);
                } else {
                    $(".pagination").html("");
                }
                // }
            },
            error: function (xhr) {
                console.error("Error:", xhr.responseText);
            },
        });
    });

    $("#date_debut, #date_fin").change(function () {
        var neededUrl = window.location.pathname;
        var date_debut = $("#date_debut").val();
        var date_fin = $("#date_fin").val();

        if (date_debut && date_fin) {
            $.ajax({
                url: neededUrl + "/filter-by-date",
                method: "GET",
                data: { date_debut: date_debut, date_fin: date_fin },
                success: function (data) {
                    console.log(data);
                    var newData = $(data);

                    $("tbody").html(newData.find("tbody").html());
                    $("#card-footer").html(newData.find("#card-footer").html());
                    var paginationHtml = newData.find(".pagination").html();
                    if (paginationHtml) {
                        $(".pagination").html(paginationHtml);
                    } else {
                        $(".pagination").html("");
                    }
                },
                error: function (xhr) {
                    console.error("Error:", xhr.responseText);
                },
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("select-all");
    const motifCheckboxes = document.querySelectorAll(".motif-checkbox");

    selectAllCheckbox.addEventListener("change", function () {
        motifCheckboxes.forEach(function (checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });
    motifCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            if (!checkbox.checked) {
                selectAllCheckbox.checked = false;
            } else if (
                Array.from(motifCheckboxes).every((chk) => chk.checked)
            ) {
                selectAllCheckbox.checked = true;
            }
        });
    });


});


const JourferieSelectAllCheckbox = document.getElementById("Jourferie-select-all");
const jourFerieCheckboxes = document.querySelectorAll(".jourFerie-checkbox");

JourferieSelectAllCheckbox.addEventListener("change", function () {
    jourFerieCheckboxes.forEach(function (checkbox) {
        checkbox.checked = JourferieSelectAllCheckbox.checked;
    });
});
jourFerieCheckboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        if (!checkbox.checked) {
            JourferieSelectAllCheckbox.checked = false;
        } else if (
            Array.from(motifCheckboxes).every((chk) => chk.checked)
        ) {
            JourferieSelectAllCheckbox.checked = true;
        }
    });
});
