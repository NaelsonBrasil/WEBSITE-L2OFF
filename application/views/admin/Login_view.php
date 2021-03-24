<html>
<head>
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url("assets/img/icon.png") ?>"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <link rel="shortcut icon" type="image/png" href="<?= base_url("assets/images/icon.png") ?>"/>
    <link rel="stylesheet" href="<?= base_url("assets/css/internal.css"); ?>">
    <link rel="stylesheet" href="<?= base_url("assets/css/bootstrap.min.css"); ?>">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

</head>
<body id="lg-body">

<div class="container">


    <div class="display-msg">
        <div class="alert display-alert alert-danger" role="alert">
            <?php echo $this->lang->line('login_error'); ?>
            <a role="button" class="btn btn-alert btn-danger" href="<?php echo site_url("admin/login"); ?>">Sair</a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3 col-md-3 text-center" id="lg-title-process">
            <h5 class="text-secondary m-1"><i class="fas fa-lock" id="lg-icon-process"></i>UCP</h5>
        </div>
    </div>

    <div class="row" id="login-enter">

        <div class="col-sm-4 col-md-4">

            <?php echo form_open('', 'id="form_login" onsubmit="return false"'); ?>

            <div class="form-group">

                <label for="target_username">
                    <small class="text-secondary"><?php echo $this->lang->line('text_label_login'); ?></small>
                </label>
                <input type="text" class="form-control" name="form_username" id="target_username" maxlength="50" required>
                <small id="inf_username" class="form-text"></small>

            </div>

            <div class="form-group">

                <label for="target_password">
                    <small class="text-secondary"><?php echo $this->lang->line('text_label_password'); ?></small>
                </label>
                <input type="password" class="form-control" name="form_password" id="target_password" maxlength="16" required>
                <small id="inf_password" class="form-text"></small>

            </div>

            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Le5EngUAAAAALPipllSwnV5O1g_gEJD1WKhvzoK" style="margin-left: 25px !important;"></div>
            </div>

            <button type="submit" class="btn w-100 btn-dark"><?php echo $this->lang->line('btn_enter'); ?></button>

            <br>
            <br>

            <small class="text-secondary"><?php echo $this->lang->line('text_jump_create'); ?> <a href="<?= base_url("admin/register") ?>"><?php echo $this->lang->line('btn_jump_create'); ?></a>
            </small>

            <h3 class="text-danger text-center m-1"><?php if (isset($errInfo)) echo $errInfo; ?></h3>
            <h5 class="text-success text-center m-1"><?php if (isset($successInfo)) echo $successInfo; ?></h5>

            <?php echo form_close(); ?>

        </div>

    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="<?= base_url("assets/js/bootstrap.min.js"); ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/js/global.js"); ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/js/tools.js"); ?>"></script>
<script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>
<script type="application/javascript">


    //Return objects and values form
    function post(data) {

        return new Promise(function (resolve, reject) {
            $(function () {

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('admin/Login_controllers/verify'); ?>',
                    data: {form_username: data, csrf_protection: $('input[name="csrf_protection"]').val()},
                    dataType: 'json',
                    success: function (json) {
                        resolve(json.success);
                    }
                });
            });
        });
    }


    $(function () {

        $('#target_username').on('blur', function () {

            post($(this).val()).then(function (val) {
                //console.log(val);
                if (val === true) {

                    $('#target_username').css('border', 'solid 1px #6ACA5C');
                    $("#inf_username").text("Ok").css('color', '#6ACA5C');

                } else {

                    $('#target_username').css('border', 'solid 1px #ca6b70');
                    $("#inf_username").text("Does not exist!").css('color', '#ca6b70');

                }

            });

        });

        $('#target_username').on('blur', function () {

            if (checkPregMatch($(this).val()) === false) {

                $(this).css('color', '#ca6b70');
                $('#inf_username').text('Special character error').css('color', '#ca6b70');

            }

        });


        $('#form_login').bind('submit', function (e) {

            e.preventDefault();
            var dataForm = $(this).serialize();

            console.log(dataForm);

            $.ajax({

                type: 'POST',
                url: '<?= base_url("admin/Login_controllers/loginValidation"); ?>',
                data: dataForm,
                dataType: 'json',
                success: function (json) {

                    if (json.success === true) {
                        window.location.href = "<?= base_url("logged") ?>";
                    }

                    if (json.success === false) {
                        $('.display-msg').css('display', 'inline');
                    }

                }, error: function (json) {
                    alert("Ajax failed");
                }
            });
        });

    });

</script>


</body>
</html>
<?php
