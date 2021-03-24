<?php if (isset($success) AND $success === true) { ?>

    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">

            <span>Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/menu"); ?>">Sair</a></span>

        </div>
    </div>

    <?php
} else if (isset($success) AND $success === false) {
    ?>

    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">
            <span> Error <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/menu"); ?>">Sair</a></span>
        </div>
    </div>

<?php } ?>


<div class="menu-all">

    <form method="GET" id="form-checkbox">
        <div class="row ">

            <div class="col-sm-3">

                <ul class="list-group">

                    <li class="list-group">
                        <div class="custom-control custom-checkbox">

                            <?php if ($val_password == 1) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck1" name="password_active" value="0">
                                <label class="custom-control-label " for="customCheck1">Password Change
                                    <span class="badge badge-success">ON</span></label>

                            <?php } else if ($val_password == 0) { ?>

                                <input type="radio" class="custom-control-input m-0" id="customCheck1" name="password_active" value="1">
                                <label class="custom-control-label " for="customCheck1">Password Change
                                    <span class="badge badge-danger">OFF</span></label>
                            <?php } ?>

                        </div>
                    </li>
                    <li class="list-group">
                        <div class="custom-control custom-checkbox">

                            <?php if ($val_nick == 1) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck2" name="nick_name_active" value="0">
                                <label class="custom-control-label" for="customCheck2">NickName Change
                                    <span class="badge badge-success">ON</span></label>
                            <?php } else if ($val_nick == 0) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck2" name="nick_name_active" value="1">
                                <label class="custom-control-label" for="customCheck2">NickName Change
                                    <span class="badge badge-danger">OFF</span></label>
                            <?php } ?>

                        </div>
                    </li>
                    <li class="list-group">
                        <div class="custom-control custom-checkbox">
                            <?php if ($val_email == 1) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck3" name="email_active" value="0">
                                <label class="custom-control-label" for="customCheck3">Email Change
                                    <span class="badge badge-success">ON</span></label>
                            <?php } else if ($val_email == 0) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck3" name="email_active" value="1">
                                <label class="custom-control-label" for="customCheck3">Email Change
                                    <span class="badge badge-danger">OFF</span></label>
                            <?php } ?>
                        </div>
                    </li>
                    <li class="list-group">
                        <div class="custom-control custom-checkbox">
                            <?php if ($val_unlock == 1) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck4" name="unlock_active" value="0">
                                <label class="custom-control-label" for="customCheck4">Char Unlock
                                    <span class="badge badge-success">ON</span></label>
                            <?php } else if ($val_unlock == 0) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck4" name="unlock_active" value="1">
                                <label class="custom-control-label" for="customCheck4">Char Unlock
                                    <span class="badge badge-danger">OFF</span></label>
                            <?php } ?>
                        </div>
                    </li>
                </ul>

            </div>


            <div class="col-sm-3">

                <ul class="list-group">
                    <li class="list-group">
                        <div class="custom-control custom-checkbox">
                            <?php if ($val_send_email_register == 1) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck5" name="send_email_active" value="0">
                                <label class="custom-control-label" for="customCheck5">Send Email Register
                                    <span class="badge badge-success">ON</span></label>
                            <?php } else if ($val_send_email_register == 0) { ?>
                                <input type="radio" class="custom-control-input m-0" id="customCheck5" name="send_email_active" value="1">
                                <label class="custom-control-label" for="customCheck5">Send Email Register
                                    <span class="badge badge-danger">OFF</span></label>
                            <?php } ?>
                        </div>
                    </li>
                </ul>

            </div>

        </div>
    </form>
    <div class="row">
        <div class="col-md-6">
            <div class="chartLine">
                <canvas id="myChart"></canvas>
                <form method="POST" id="sub_clear" class="text-center">
                    <label for="Clear"></label>
                    <input hidden="hidden" name="form_statistic" id="Clear" value="1">
                    <input type="submit" class="btn btn-dark w-100" value="Clean">
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <h6 class="text-info text-center">Space for future projetc WebSite vipcriativo.com,email:vipcriato.web@gmail.com</h6>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="adm_msg text-center">
                <?php echo form_open('admin/menu/announce', 'POST'); ?>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Announcements: Your Event
                        <i class="fas fa-bed"></i></label>
                    <textarea class="form-control w-100 m-auto" id="exampleFormControlTextarea1" name="form_announce" rows="3" maxlength="50"></textarea>
                </div>

                <div class="form-group">
                    <label for="btnAdmSend"></label>
                    <input type="submit" class="btn btn-dark" id="btnAdmSend" value="Enviar">
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>

    </div>

</div>


<script>

    $(function () {


        // if ($('input[type="checkbox"]').change(function () {
        //     //$('input[type=checkbox].check-on:checked').submit();
        //     if ($(this).is(':checked')) {
        //         $("#form-checkbox").submit();
        //     }else {
        //         $("#form-checkbox").submit();
        //     }
        //
        // })) ;
        $('input[type=radio]').click('change', function () {
            if ($(this).closest("#form-checkbox").submit()) {
            }
        });
    });


    var ctx = document.getElementById('myChart').getContext('2d');
    var chart = new Chart(ctx, {
// The type of chart we want to create
        type: 'line',

// The data for our dataset
        data: {
            labels: ["Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sabado", "Domingo"],
            datasets: [{
                label: "Register of week",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: [<?php echo $monday?>, <?=$tuesday?>, <?=$wednesday?>, <?=$thursday?>, <?=$friday?>, <?=$saturday?>, <?=$sunday?>],

            }]
        },

//Configuration options go here
        options: {}
    });
</script>
