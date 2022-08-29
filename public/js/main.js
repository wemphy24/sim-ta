// Sidebar
$(document).ready(function () {
    $(".toggleMenu").click(function () {
        $(".sidebar").toggleClass("hidden");
    });
});

// Dropdown Logout
$(document).ready(function () {
    $(".dropdown").click(function () {
        $(".dropdown-menu").toggleClass("hidden");
    });
});

// Open Modal
$(document).ready(function () {
    $(".openModal").click(function () {
        $(".overlay-modal").toggleClass("hidden");
    });
});

// Close Modal
$(document).ready(function () {
    $(".closeModal").click(function () {
        $(".overlay-modal").toggleClass("hidden");
    });
});
