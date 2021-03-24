$(function () {
    $('.close-captcha').click(function () {
        $('.capt').css('display', 'none');
        localStorage.clear();
        location.reload(true);
    });


    $('.btn-captcha').click(function () {

        //No need check if val larger that zero
        if ($('#login').val() && $('#pwd').val()) {
            localStorage.setItem("stg_username", $('#login').val());
            localStorage.setItem("stg_password", $('#pwd').val());
            $('.capt').css('display', 'inline');
        } else
            alert("Login Empty");


    });

});



function onLoad() {

    let get_stg_username = localStorage.getItem("stg_username");
    if (typeof(get_stg_username) !== "undefined" && get_stg_username !== null) {
        $('#login').val(get_stg_username);
    }

    //email
    let get_stg_password = localStorage.getItem("stg_password");
    if (typeof(get_stg_password) !== "undefined" && get_stg_password !== null) {
        $('#pwd').val(get_stg_password);
        $('.capt').css('display', 'inline');
    }else
        $('.capt').css('display', 'none');

}