window.CookieARWebAdmin = (() => {
    const alert = (type, text, callback) => {
        if (
            type !== 'success' &&
            type !== 'error' &&
            type !== 'warning'
            && type !== 'info'
            && type !== 'question'
        ) {
            text = type;
            type = 'info';
        }

        Swal.fire({
            text,
            icon: type,
            confirmButtonText: type === 'question' ? 'Yes' : 'Ok',
            cancelButtonText: 'No',
            showCancelButton: type === 'question',
        }).then((eventStatus) => {
            if (eventStatus.isConfirmed && typeof callback === 'function') {
                callback();
            }
        });
    };

    const showPageLoading = () => {
        const loadingElem = document.createElement("div");
        document.body.prepend(loadingElem);
        loadingElem.classList.add("page-loader");
        loadingElem.classList.add("flex-column");
        loadingElem.classList.add("bg-dark");
        loadingElem.classList.add("bg-opacity-25");
        loadingElem.innerHTML = '<span class="spinner-border text-primary" role="status">';
        loadingElem.innerHTML += '<span className="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>';
        KTApp.showPageLoading();
        return loadingElem;
    };

    const hidePageLoading = (loadingElem) => {
        KTApp.hidePageLoading();
        loadingElem.remove();
    }

    return {
        init: () => {
            if (window.PtHeader) {
                PtHeader.init();
            }
            if (window.CookieARWebAdminPage) {
                CookieARWebAdminPage.init();
            }
        },
        alert,
        showPageLoading,
        hidePageLoading,
    }
})();

$(document).ready(() => {
   CookieARWebAdmin.init();
});
