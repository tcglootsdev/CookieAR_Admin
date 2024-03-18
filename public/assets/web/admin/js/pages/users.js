window.CookieARWebAdminPage = (() => {
    let tableUsers = null;

    let ptModalPurchaseHistory = null;

    const loadAndDisplayUsers = () => {
        if (tableUsers) {
            tableUsers.ajax.reload();
            return;
        }
        tableUsers = $(".pg-users-table").DataTable({
            responsive: true,
            columns: [
                {title: 'No', data: '_no'},
                {title: 'Username', data: '_username'},
                {title: 'FullName', data: '_fullname'},
                {title: 'Email', data: '_email'},
                {title: 'Phone', data: '_phone'},
                {title: 'Address', data: '_address'},
                {title: 'Actions', data: '_actions'},
            ],
            ajax: {
                type: 'get',
                url: '/web/users',
                dataType: 'json',
                dataSrc: (response) => {
                    if (!response.status) {
                        CookieARWebAdmin.alert('error', response.error);
                        return [];
                    }
                    const {data: users} = response;
                    const badgeUndefined = '<span class="badge badge-warning">Undefined</span>';
                    for (let i = 0; i < users.length; i++) {
                        users[i]._no = i + 1;
                        users[i]._username = users[i].username;
                        users[i]._fullname = users[i].First_name + (users[i].Last_name ? ' ' + users[i].Last_name : '');
                        users[i]._email = users[i].email;
                        users[i]._phone = users[i].phone;
                        users[i]._address =
                            users[i].Address +
                            (users[i].Address_optional ? ', ' + users[i].Address_optional : '') +
                            (users[i].City ? ', ' + users[i].City : '') +
                            (users[i].Zipcode ? ', ' + users[i].Zipcode : '');
                        users[i]._actions = '<div class="btn-group">';
                        users[i]._actions += '<a data-id="' + users[i].id + '" class="btn btn-sm btn-icon btn-primary pg-users-purchase-history"><i class="fas fa-bread-slice fs-2"></i></a>';
                        users[i]._actions += '</div>';
                        if (!users[i]._username) users[i]._username = badgeUndefined;
                        if (!users[i]._fullname) users[i]._fullname = badgeUndefined;
                        if (!users[i]._email) users[i]._email = badgeUndefined;
                        if (!users[i]._phone) users[i]._phone = badgeUndefined;
                        if (!users[i]._address) users[i]._address = badgeUndefined;
                    }
                    return users;
                }
            },
            drawCallback: () => {
                setClickEvent();
            }
        });
    }

    const setClickEvent = () => {
        $('.pg-users-purchase-history').off('click').click(function () {
            const userId = $(this).data('id');
            ptModalPurchaseHistory.showModal(userId);
        });
    };

    return {
        init: function () {
            PtMenu.setActive('users');
            ptModalPurchaseHistory = PtModalPurchaseHistory.getInstance('pg-users-modal-purchase-history');
            ptModalPurchaseHistory.init();
            loadAndDisplayUsers();
        }
    }
})();
