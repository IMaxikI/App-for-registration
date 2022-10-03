$('#submit-reg').click(function (e) {
    e.preventDefault();

    const user = {
        login: $('#login').val(),
        password: $('#password').val(),
        confirm_password: $('#confirm_password').val(),
        email: $('#email').val(),
        name: $('#name').val()
    };

    clearError();

    if (checkInputs(user)) {
        $.ajax({
            url: '/php/registration.php',
            method: 'post',
            dataType: 'json',
            data: user,
            success: function (data) {
                alert('Registration completed successfully. Log in!');
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

