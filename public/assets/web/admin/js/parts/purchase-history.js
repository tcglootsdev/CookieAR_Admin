(() => {
    if (window.PtPurchaseHistory !== undefined) return;
    window.PtPurchaseHistory = function () {
        const partId = 'pt-purchase-history';

        const getInstance = (assignedId) => {
            const realId = '.' + partId + '.' + assignedId;

            let tablePurchaseHistory = null;

            const setData = (userId) => {
                const url = '/web/users/' + userId + '/purchase-history';
                if (tablePurchaseHistory) {
                    tablePurchaseHistory.ajax.url(url).load();
                    return;
                }
                tablePurchaseHistory = $(realId + " .pt-purchase-history-table").DataTable({
                    responsive: true,
                    columns: [
                        {title: 'Name', data: '_name'},
                        {title: 'Service', data: '_service'},
                        {title: 'Price', data: 'price'},
                        {title: 'Address', data: '_address'},
                        {title: 'Billing', data: '_billing'},
                        {title: 'Ship Fee', data: 'ship_fee'},
                        {title: 'Token', data: '_token'},
                    ],
                    ajax: {
                        type: 'get',
                        url,
                        dataType: 'json',
                        dataSrc: (response) => {
                            if (!response.status) {
                                CookieARWebAdmin.alert('error', response.error);
                                return [];
                            }
                            const {data: transactions} = response;
                            const badgeUndefined = '<span class="badge badge-warning">Undefined</span>';
                            for (let i = 0; i < transactions.length; i++) {
                                let package = {};
                                try {
                                    package = JSON.parse(transactions[i].packages);
                                } catch (e) {}
                                transactions[i]._name = package.name;
                                transactions[i]._service = package.service;
                                transactions[i]._address =
                                    package.address.street +
                                    (package.address.city ? ', ' + package.address.city : '') +
                                    (package.address.state ? ', ' + package.address.state : '') +
                                    (package.address.postalcode ? ', ' + package.address.postalcode : '');
                                transactions[i]._billing =
                                    package.billing.street +
                                    (package.billing.city ? ', ' + package.billing.city : '') +
                                    (package.billing.state ? ', ' + package.billing.state : '') +
                                    (package.billing.postalcode ? ', ' + package.billing.postalcode : '');
                                transactions[i]._token = package.token;
                                if (!transactions[i]._name) transactions[i]._name = badgeUndefined;
                                if (!transactions[i]._service) transactions[i]._service = badgeUndefined;
                                if (!transactions[i]._address) transactions[i]._address = badgeUndefined;
                                if (!transactions[i]._billing) transactions[i]._billing = badgeUndefined;
                                if (!transactions[i]._token) transactions[i]._token = badgeUndefined;
                            }
                            return transactions;
                        }
                    },
                });
            }

            return {
                init: () => {
                },
                setData
            }
        }

        return {
            getInstance
        }
    }();
})();
