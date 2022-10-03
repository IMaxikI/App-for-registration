$('#submit-aut').click(function (e) {
    e.preventDefault();

    const user = {
        login: $('#login').val(),
        password: $('#password').val(),
    };

    clearError();

    if (checkInputs(user)) {
        $.ajax({
            url: '/php/authorization.php',
            method: 'post',
            dataType: 'json',
            data: user,
            success: function (data) {
                window.location.href = data.redirect;
            },
            error: function (error) {
                handleError(error.responseJSON);
            }
        });
    } else {
        $('#message').text('Enter all fields!');
    }
});

