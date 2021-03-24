<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!doctype html>
<html lang="pt-br">
<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="author" content="vipcriativo.com">
    <meta name="description" content="New game server Lineage 2 Interlude. References: Easy economy, balanced pvp..">
    <meta name="keywords"
          content="server lineage 2, lineage 2 server interlude, opening lineage 2 server, lineage 2 server pvp, interlude server, l2 interlude, lineage 2, interlude, x5000, x5000, server, l2, precious interlude, classic pvp, craft-pvp, л2, craft, l2-precious, lucera, best pvp, lineage 2, balance, maxcheaters, hopzone, topzone, l2network, russia, brazil, greece, poland">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/external.css'); ?>">
    <link rel="shortcut icon" type="image/png" href="<?= base_url("assets/images/icon.png") ?>"/>
    <title>L2 Web</title>

    <style type="text/css">
        .pagination > .active > a, .pagination > li > span {
            color: #ffffff !Important;
            background-color: #2a2a2a !important;
            border: solid 1px #2a2a2a !important;
        }

        .active {
            color: #333333 !important;
            /*background-color: white !important;*/
        }

        .page-link {
            text-decoration: none !important;
            color: white !important;

        }

        .custom-pagination a {
            text-decoration: none !important;
            color: #343434 !important;
        }
    </style>
</head>
<body onload="onLoad()">


<!--Full Div-->
<div class="main">

    <div class="left-col">
      <?php $this->load->view($pag_menu_left); ?>
    </div>

    <div class="center-col">
      <?php $this->load->view($pag_content); ?>
    </div>

    <div class="right-col">
      <?php $this->load->view($pag_menu_right); ?>
    </div>

</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>

<script type="text/javascript" src="<?php echo base_url("assets/js/public/login.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>

<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LeZFHgUAAAAAHB4LeS5zE_Jvn434gRD-8spfvl0', {action: 'action_name'})
            .then(function(token) {
            // Verify the token on the server.
            });
    });
</script>

<script type="application/javascript">
    $(function () {

        $('#public_login').bind('submit', function (e) {
            e.preventDefault();
            // var allDateForm = $(this).serializeArray();
            var allDateForm = $(this).serialize();
            console.log(allDateForm);
            $.ajax({
                url: "<?php echo base_url('/public/validation/index'); ?>",
                type: 'POST',
                dataType: 'json',
                data: allDateForm,
                // data: {allDateForm: allDateForm},
                success: function (json) {
                    if (json.validation === true) alert("Error Empty");
                    if (json.captcha === true) alert("Error Code");
                    if (json.error === true){
                        $('#pwd').css('background-color', '#ff5f61').css('border', ' 1px solid #FF9290');
                        $('#login').css('background-color', '#ff5f61').css('border', ' 1px solid #FF9290');
                        $('.capt').css('display', 'none');
                    }
                    if (json.success === true) {
                        localStorage.clear();
                        $('.capt').css('display', 'none');
                        let url = ' <?= site_url("admin"); ?>';
                        window.location.href = url;
                    }
                }
            });
        });
    })
    ;
</script>

</body>
</html>