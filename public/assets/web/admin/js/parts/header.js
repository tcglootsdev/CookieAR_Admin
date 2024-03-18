(() => {
    if (window.PtHeader !== undefined) return;
    window.PtHeader = function () {
        const partId = 'pt-header';
        const realId = '.' + partId;

        const setClickEvent = () => {
            $(realId + ' .pt-header-signout').click(() => {
                CookieARWeb.ajax('post', '/web/auth/signout', { _token: csrf_token }, (success, data, error) => {
                    if (success) {
                        window.location.href = '/user';
                    } else {
                        CookieARWebAdmin.alert(error);
                    }
                });
            });
        }

        return {
            init: function () {
                setClickEvent();
            }
        }
    }();
})();
