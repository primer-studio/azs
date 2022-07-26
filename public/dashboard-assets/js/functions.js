/**
 * Smoothly scroll to an element without a jQuery plugin
 * @param margin_top
 * @param duration
 */
$.fn.scrollTOElement = function (margin_top = 50, duration = 500) {
    $([document.documentElement, document.body]).animate({
        scrollTop: $(this).offset().top - margin_top
    }, duration);
}

/**
 * redirect to the given URL
 * @param url
 */
function redirect(url) {
    // similar behavior as an HTTP redirect
    window.location.replace(url);
}

toastr.options = {
    "preventDuplicates": true,
}

function addProcessingNotification(message) {
    var long_life_toastr = toastr;
    long_life_toastr.options = {
        "preventDuplicates": true,
        "timeOut": "50000",
        "progressBar": true,
    }
    long_life_toastr.info(message);
}

function addErrorNotification(message) {
    toastr.options = {
        "newestOnTop": false,
        "progressBar": false,
    }
    toastr.error(message);
}

function addSuccessNotification(message) {
    toastr.options = {
        "newestOnTop": false,
        "progressBar": false,
    }
    toastr.success(message)
}

function addInfoNotification(message) {
    toastr.options = {
        "newestOnTop": false,
        "progressBar": false,
    }
    toastr.info(message)
}

function resetNotifications() {
    // Remove current toasts using animation
    toastr.clear()
}
