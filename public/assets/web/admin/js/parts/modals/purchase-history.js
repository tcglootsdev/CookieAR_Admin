(() => {
    if (window.PtModalPurchaseHistory !== undefined) return;
    window.PtModalPurchaseHistory = function () {
        const partId = 'pt-modal-purchase-history';

        const getInstance = (assignedId) => {
            const realId = '.' + partId + '.' + assignedId;

            let ptPurchaseHistory = null;

            const showModal = (userId) => {
                ptPurchaseHistory.setData(userId);
                $(realId).modal('show');
            }

            const hideModal = () => {
                $(realId).modal('hide');
            }

            return {
                init: (params) => {
                    ptPurchaseHistory = PtPurchaseHistory.getInstance(partId + '-' + assignedId + '-purchase-history');
                    ptPurchaseHistory.init();
                },
                showModal,
                hideModal
            }
        }

        return {
            getInstance
        }
    }();
})();
