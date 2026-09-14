$(document).ready(function () {

    let path = window.location.pathname,
        arrPath = path.split('/');

    $('a.nav-link, a.dropdown-item').removeClass('active');

    if (arrPath[arrPath.length - 1] == '') {
        $('a.nav-link.Home').addClass('active');
        return;
    }

    let namePage = arrPath[arrPath.length - 1];
    namePage = namePage.charAt(0).toUpperCase() + namePage.slice(1);

    let currentItem = $(`a.dropdown-item.${namePage}`);
    currentItem.addClass('active');
    currentItem.closest('.dropdown').find('.dropdown-toggle').addClass('active');
});