document.addEventListener("DOMContentLoaded", function() {
    const redirectUrl = document.getElementById("redirectUrl");

    if (redirectUrl) {
        setTimeout(function() {
            window.location.href = redirectUrl.value;
        }, 1000);
    }
});

