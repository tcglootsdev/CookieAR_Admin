(() => {
    if (window.PtMenu !== undefined) return;
    window.PtMenu = function () {
        const partId = 'pt-menu';
        const realId = '.' + partId;

        const setActive = (menuId) => {
            $(realId + ' .pt-menu-' + menuId).addClass('show');
        }

        return {
            setActive
        }
    }();
})();
