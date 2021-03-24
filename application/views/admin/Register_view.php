<html>
<head>
    <title>Register</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url("assets/img/icon.png") ?>"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url("assets/css/internal.css"); ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/bootstrap.min.css"); ?>">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="<?= base_url("assets/images/icon.png") ?>"/>

</head>
<body id="rg-body">

<div class="container">

    <div class="row">
        <div class="col-sm-3 col-md-3 text-center" id="rg-title-process">
            <div class="text-secondary " id="title-register">
                <i class="fas fa-lock" id="rg-icon-process"></i><?php echo $this->lang->line('text_create_account'); ?>
            </div>

        </div>

    </div>
    <div class="row">

        <?php echo form_open('', 'id="form_data" onsubmit="return false"'); ?>

            <div class="col-12">
                <h6><strong class="text-light"><?php echo $this->lang->line('text_rules_register'); ?></strong></h6>
                <article style="overflow-y: auto; height: 200px; width: 100%; margin: auto; background-color: white; border: 5px solid rgba(228,228,228,0.88);">

                    <?php $xml = simplexml_load_file("config/terms.xml");
                    foreach ($xml->terms_register_en->info as $key => $item) { ?>
                    <small class="text-secondary p-2 rules-register"><?= $item ?></small>
                    <hr/>
                    <?php 
                } ?>

                </article>
                <br>
                <div class="text-center">
                    <span class="text-light"><?php echo $this->lang->line('text_rules_confirm_register'); ?></span>&ensp;&ensp;&ensp;<input class="form-check-input" type="checkbox" value="" id="form_check" style="margin-top: 8px !important;" required>
                </div>
            </div>
            <br>
            <div class="col-sm-4 col-md-4" id="form-register">
                <br>
                <div class="alert alert-info m-2" role="alert" style="font-size: 14px">
                    <?php echo $this->lang->line('text_allowed_part1_register'); ?>
                     [ <small class="text-danger">+._</small> ] <?php echo $this->lang->line('text_allowed_part2_register'); ?><br>
                </div>
                <input type="hidden" name="form_random" id="target_random" value="<?= $random ?>">
                Prefix: <strong><?= $random ?></strong>


                <div class="form-group">
                    <label for="target_name"></label>
                    <input type="text" class="form-control" name="form_name" id="target_name" placeholder="User" maxlength="16" required autocomplete="off">
                    <small id="inf_name" class="form-text"></small>
                </div>

                <div class="form-group">
                    <label for="target_password1"></label>
                    <input type="password" class="form-control" name="form_password1" id="target_password1" placeholder="Password" maxlength="16" required autocomplete="off">
                    <small id="inf_password1" class="form-text"></small>
                </div>

                <div class="form-group">
                    <label for="Password2"></label>
                    <input type="password" class="form-control" name="form_password2" id="target_password2" placeholder="Confirm" maxlength="16" required autocomplete="off">
                    <small id="inf_password2" class="form-text"></small>
                </div>


                <div class="form-group">
                    <label for="target_email"></label>
                    <input type="email" class="form-control" name="form_email" id="target_email" placeholder="Email" maxlength="40" required autocomplete="off">
                    <small id="inf_email" class="form-text"><?php echo $this->lang->line('text_allowed_part2_register'); ?></small>
                </div>

                <div class="form-group">
                    <label for="target_quizOne"></label>
                    <input type="text" class="form-control" name="form_quizOne" id="target_quizOne" placeholder="quiz 1" maxlength="30" required autocomplete="off">
                    <small id="inf_quizOne" class="form-text"></small>
                </div>

                <div class="form-group">
                    <label for="target_quizTwo"></label>
                    <input type="text" class="form-control" name="form_quizTwo" id="target_quizTwo" placeholder="quiz 2" maxlength="30" required autocomplete="off">
                    <small id="inf_quizTwo" class="form-text"></small>
                </div>

                <div class="form-group">
                    <label for="target_answerOne"></label>
                    <input type="text" class="form-control" name="form_answerOne" id="target_answerOne" placeholder="answer 1" maxlength="30" required autocomplete="off">
                    <small id="inf_answerOne" class="form-text"></small>
                </div>

                <div class="form-group">
                    <label for="target_answerTwo"></label>
                    <input type="text" class="form-control" name="form_answerTwo" id="target_answerTwo" placeholder="answer 2" maxlength="30" required autocomplete="off">
                    <small id="inf_answerTwo" class="form-text"></small>
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6Le5EngUAAAAALPipllSwnV5O1g_gEJD1WKhvzoK" style="margin-left: 25px !important;"></div>
                </div>

                <button type="submit" class="btn w-100 btn-dark" id="register-acc"> <?php echo $this->lang->line('btn_register_account'); ?> </button>
                <br>
                <div class="loading-spinner" id="loading"></div>
                <small class="text-secondary"><?php echo $this->lang->line('btn_redirect_login'); ?> <a href="<?= base_url("admin/login") ?>"><?php echo $this->lang->line('btn_login'); ?></a></small>
                <br>
                <h3 class="text-danger text-center m-1">
                    <?php if (isset($errInfo)) echo $errInfo; ?>
                </h3>
                <h5 class="text-success text-center m-1">
                    <?php if (isset($successInfo)) echo $successInfo; ?>
                </h5>
        <?php echo form_close(); ?>
    </div>
</div>




<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?= base_url("assets/js/bootstrap.min.js"); ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/js/tools.js"); ?>"></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>


<script type="application/javascript">

    var name = "#target_name";
    var email = "#target_email";
    var password1 = "#target_password1";
    var password2 = "#target_password2";
    var quizOne = "#target_quizOne";
    var quizTwo = "#target_quizTwo";
    var answerOne = "#target_answerOne";
    var answerTwo = "#target_answerTwo";

    //Return objects and values form
    function post(input,token,type) {

        switch (type) {
            case 'username':

                    return new Promise(function (resolve, reject) {
                    $(function () {

                        console.log("username: "+input);
                        console.log("Token: "+token);

                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url("admin/Register_controllers/verify"); ?>',
                            data: {form_username: input, csrf_protection: token},
                            dataType: 'json',
                            success: function (json) {
                                resolve(json.verify);
                            }
                        });
                    });
                });
                break;

            case 'email':
                
                    return new Promise(function (resolve, reject) {
                    $(function () {

                        console.log("Email: "+input);
                        console.log("Token: "+token);

                        $.ajax({
                            type: 'POST',
                            url: '<?= base_url("admin/Register_controllers/verify"); ?>',
                            data: {form_email: input, csrf_protection: token},
                            dataType: 'json',
                            success: function (json) {
                                resolve(json.verify);
                            }
                        });
                    });
                });
                break;

            default:
                console.console.log("Exception verify username or email validation!");
                break;
        }
    }

    $(function () {
        //Name
        $(name).on('blur', function () {

            if (checkPregMatch($(this).val()) === true) {

                post( $(this).val(), $('input[name="csrf_protection"]').val(),'username').then(function (val) {

                    if (val === false) {
                        $(name).css('border', 'solid 1px #6ACA5C');
                        $("#inf_name").text("Ok").css('color', '#6ACA5C');
                    } else if(val === true) {
                        $(name).css('border', 'solid 1px #ca6b70');
                        $("#inf_name").text("Already exist registered").css('color', '#ca6b70');
                    }

                });

            } else {
                $(this).css('border', 'solid 1px #ca6b70');
                $("#inf_name").text("Character special invalid").css('color', '#ca6b70');
            }

        });

        //Email
        $(email).on('blur', function () {

            if (checkPregMatch($(this).val()) === true) {

                //console.log("Email:"+$(this).val());   
                post($(this).val(), $('input[name="csrf_protection"]').val(),'email').then(function (val) {

                    if (val === false) {
                        $(email).css('border', 'solid 1px #6ACA5C');
                        $("#inf_email").text("Ok").css('color', '#6ACA5C');
                    } else if(val === true){
                        $(email).css('border', 'solid 1px #ca6b70');
                        $("#inf_email").text("Already exist registered").css('color', '#ca6b70');
                    }

                });

            } else {
                $(this).css('border', 'solid 1px #ca6b70');
                $("#inf_email").text("Character special invalid").css('color', '#ca6b70');
            }
        });


        //Quiz One
        $(quizOne).on('blur', function () {

            if (checkPregMatch($(this).val()) === true) {
                $(this).css('border', 'solid 1px #6ACA5C');
                $("#inf_quizOne").text("Ok").css('color', '#6ACA5C');

            } else {
                $(this).css('border', 'solid 1px #ca6b70');
                $("#inf_quizOne").text("Character special invalid").css('color', '#ca6b70');
            }

        });


        //Quiz Two
        $(quizTwo).on('blur', function () {

            if (checkPregMatch($(this).val()) === true) {
                $(this).css('border', 'solid 1px #6ACA5C');
                $("#inf_quizTwo").text("Ok").css('color', '#6ACA5C');

            } else {
                $(this).css('border', 'solid 1px #ca6b70');
                $("#inf_quizTwo").text("Character special invalid").css('color', '#ca6b70');
            }

        });

        //Answer One
        $(answerOne).on('blur', function () {

            if (checkPregMatch($(this).val()) === true) {
                $(this).css('border', 'solid 1px #6ACA5C');
                $("#inf_answerOne").text("Ok").css('color', '#6ACA5C');

            } else {
                $(this).css('border', 'solid 1px #ca6b70');
                $("#inf_answerOne").text("Character special invalid").css('color', '#ca6b70');
            }

        });


        //Answer Two
        $(answerTwo).on('blur', function () {

            if (checkPregMatch($(this).val()) === true) {
                $(this).css('border', 'solid 1px #6ACA5C');
                $("#inf_answerTwo").text("Ok").css('color', '#6ACA5C');

            } else {
                $(this).css('border', 'solid 1px #ca6b70');
                $("#inf_answerTwo").text("Character special invalid").css('color', '#ca6b70');
            }

        });

    });


    $(function () {

        $('#form_data').bind('submit', function (e) {

            e.preventDefault();



                if (checkPregMatch($(name).val()) === true &&
                    checkPregMatch($(email).val()) === true &&
                    checkPregMatch($(password1).val()) === true &&
                    checkPregMatch($(password2).val()) === true &&
                    checkPregMatch($(quizOne).val()) === true &&
                    checkPregMatch($(quizTwo).val()) === true &&
                    checkPregMatch($(answerOne).val()) === true &&
                    checkPregMatch($(answerOne).val()) === true) {

                    //console.log($(this).serialize());

                    $('#loading').show();

                    $.ajax({

                        type: 'POST',
                        url: '<?php echo base_url('admin/Register_controllers/account'); ?>',
                        dataType: 'json',
                        data: $(this).serialize(),
                        success: function (json) {

                            if (json.nException === true) { alert("Error validation"); }

                            if (json.nCaptcha === true) {

                                alert("Error reCaptcha in 1ms reload");
                                location.reload();
                            }

                            if (json.success === false) { alert("Error Register"); }

                            if (json.success === true) {
                                
                                $('#loading').hide();

                                switch (confirm("Create with Success! Download?")) {
                                    case true:
                                        download("account", "Login: "  + $(name).val() + $("#target_random").val() + "\r\n" + "Password: " + $(password1).val());                               
                                        setTimeout(function() { window.location.href = "<?= base_url("admin/login") ?>"; }, 1000);
                                        break;
                                        case false:
                                        setTimeout( function() { window.location.href = "<?= base_url("admin/login") ?>"; }, 9000);
                                        break;
                                    default:
                                        alert("Error");
                                        break;
                                }
                            }
                        },error: function () {  alert("Failed request"); }
                    });
             } else { alert("Error character special"); }
        });
    });
</script>
</body>
</html>

