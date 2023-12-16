// public/js/navbar.js

document.addEventListener("DOMContentLoaded", function () {
    let currentUrl = window.location.href;

    // Loop through each navbar link and check if it matches the current URL
    document.querySelectorAll(".navbar-link").forEach(function (link) {
        if (link.href === currentUrl) {
            link.classList.add("active");
        } else {
            link.classList.remove("active");
        }
    });
});
