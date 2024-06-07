/* ==========================
== Page create
============================= */
function moreDetails() {
    // Remove 'active' class from the "Form" button
    document
        .getElementById("custom-tabs-one-form-tab")
        .classList.remove("active");
    // Add 'active' class to the "Details de calcule" button
    document
        .getElementById("custom-tabs-one-moreDetails-tab")
        .classList.add("active");
}

/* =====================================
== Page Decesion 
=======================================*/
document.getElementById("printButton").addEventListener("click", function() {
    window.print();
});
