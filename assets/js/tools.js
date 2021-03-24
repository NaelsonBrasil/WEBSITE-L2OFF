//vipcriativo.web@gmail.com

// Download file
function download(fileName, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', fileName);
    element.click();
}

var onloadCallback = function () {

    grecaptcha.ready(function () {
        grecaptcha.execute('6LeZFHgUAAAAAHB4LeS5zE_Jvn434gRD-8spfvl0', {action: 'action_name'})
            .then(function (token) {
                // Verify the token on the server.
            });
    });

};

// Verify if ok equal true or false
function checkPregMatch(str) {
    var filter = /^[a-zA-Z0-9_.+ @]+$/;
    return (filter.test(str)) ? true : false;
}