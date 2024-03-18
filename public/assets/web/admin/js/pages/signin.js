window.CookieARWebAdminPage = (() => {
    const setFormValidation = function () {
        $(".pg-signin-form").validate({
            errorClass: 'app-form-validation-error',
            rules: {
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 6
                }
            },
            messages: {
                username: {
                    required: "Please enter your username.",
                    minlength: "The username must be at least 5 characters long.",
                },
                password: {
                    minlength: "The password must be at least 6 characters long.",
                    required: "Please enter your password.",
                }
            },
            submitHandler: function(element, event) {
                event.preventDefault();
                const data = CookieARWeb.getFormData(element);
                const loadingElem = CookieARWebAdmin.showPageLoading();
                CookieARWeb.ajax('post', '/web/auth/signin', data, (success, data, error) => {
                    CookieARWebAdmin.hidePageLoading(loadingElem);
                    if (!success) {
                        CookieARWebAdmin.alert('warning', error);
                        return;
                    }
                    window.location.href = '/admin';
                });
            },
        });
    }

    return {
        init: function () {
            setFormValidation();
        }
    }
})();
