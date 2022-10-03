function clearError() {
    const erors = $('.error');

    $.each(erors, function(key, value) {
        value.innerHTML = '';
    });
}

function checkInputs(user) {
    let flagSend = true;
    $('#message').text('');

    $.each(user, function(key, value) {
        $('#' + key).css('border-color', 'black');

        if (value.trim() === '') {
            $('#' + key).css('border-color', 'red');
            flagSend = false;
        }
    });

    return flagSend;
}

function handleError(data) {
    $.each(data, function(key, value) {
        $('#' + key).css('border-color', 'black');

        if (value) {
            $('#' + key).css('border-color', 'red');
            $('.' + key).text(value);
        }
    });
}