$.get({
    url: '/php/checkAuthorization.php',
    method: 'get',
    dataType: 'json',
    success: function (data) {
        if (!data.isAuth) {
            window.location.href = data.redirect;
        }
        $('#welcome-text').text('Hello ' + getCookie('name'));
    }
});

$('#exit').click(function (e) {
    e.preventDefault();

    $.get({
        url: '/php/logout.php',
        method: 'get',
        dataType: 'json',
        success: function (data) {
            window.location.href = data.redirect;
        }
    });
});

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}