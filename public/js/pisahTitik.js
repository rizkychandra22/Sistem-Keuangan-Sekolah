function numbersonly(input, event) {
    var key = event.which || event.keyCode;
    // Allow only numeric keys, backspace, delete, tab, escape, and enter
    if (key > 31 && (key < 48 || key > 57)) {
        return false;
    }
    return true;
}

function tandaPemisahTitik(input) {
    var value = input.value.replace(/\./g, ''); // Remove all existing dots
    var negative = false;

    if (value.startsWith('-')) {
        negative = true;
        value = value.substring(1); // Remove negative sign for processing
    }

    // Add thousand separators
    var formattedValue = '';
    var length = value.length;

    for (var i = length; i > 0; i--) {
        var j = length - i;
        if (j % 3 === 0 && j !== 0) {
            formattedValue = '.' + formattedValue;
        }
        formattedValue = value.charAt(i - 1) + formattedValue;
    }

    if (negative) {
        formattedValue = '-' + formattedValue;
    }

    input.value = formattedValue;
}

document.addEventListener('DOMContentLoaded', function () {
    var inputs = document.querySelectorAll('input[name="jumlah"]');
    inputs.forEach(function (input) {
        input.addEventListener('keydown', function (event) {
            return numbersonly(input, event);
        });
        input.addEventListener('keyup', function () {
            tandaPemisahTitik(input);
        });
    });
});
