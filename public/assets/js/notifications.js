/**
 * Notifications configuration for SweetAlert2 and Toastr
 */

// Toastr configuration
toastr.options = {
    closeButton: true,
    newestOnTop: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};

// SweetAlert2 default configuration
if (typeof Swal !== "undefined") {
    window.Swal = Swal.mixin({
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        reverseButtons: true,
        customClass: {
            container: "swal-container-class",
            popup: "swal-popup-class",
        },
        buttonsStyling: true,
        focusConfirm: false,
        allowOutsideClick: false,
        position: "center",
        heightAuto: false,
        backdrop: true,
    });
}

/**
 * Delete confirmation dialog
 * @param {string} url - The URL to redirect to after confirmation
 * @param {string} title - The title of the dialog
 * @param {string} text - The text of the dialog
 * @returns {Promise} - The promise returned by SweetAlert2
 */
function confirmDelete(
    url,
    title = "Are you sure?",
    text = "You won't be able to revert this!"
) {
    if (typeof Swal === "undefined") {
        if (confirm(title + "\n" + text)) {
            window.location.href = url;
        }
        return;
    }

    return Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel",
        backdrop: true,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

/**
 * Form submit confirmation dialog
 * @param {string} formId - The ID of the form to submit
 * @param {string} title - The title of the dialog
 * @param {string} text - The text of the dialog
 * @returns {Promise} - The promise returned by SweetAlert2
 */
function confirmSubmit(
    formId,
    title = "Are you sure?",
    text = "Please confirm to proceed"
) {
    if (typeof Swal === "undefined") {
        if (confirm(title + "\n" + text)) {
            document.getElementById(formId).submit();
        }
        return;
    }

    return Swal.fire({
        title: title,
        text: text,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, proceed!",
        cancelButtonText: "No, cancel",
        backdrop: true,
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
