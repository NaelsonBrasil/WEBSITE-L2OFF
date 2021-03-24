<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php if(isset($title)) echo $title; ?></title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url("assets/images/icon.png") ?>"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?= base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script src="<?= base_url("assets/js/chart/Chart.bundle.min.js"); ?>"></script>
    <script src="<?= base_url("assets/js/DateTimePicker.js"); ?>"></script>
    <script src="<?= base_url("assets/js/i18n/DateTimePicker-i18n.js"); ?>"></script>
    <!-- <script src="<?= base_url("assets/js/i18n/DateTimePicker-ltie9.js"); ?>"></script>[if lt IE 9]-->
    <script type="text/javascript" src="<?= base_url("assets/js/global.js"); ?>"></script>

    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/internal.css"); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/DateTimePicker.css"); ?>">
    <!--<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/DateTimePicker-ltie9.css"); ?>"> [if lt IE 9]-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/report/main.css"); ?>">
    <script type="text/javascript" src="<?= base_url("assets/js/tools.js"); ?>"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>

<div class="container-fluid">
    <div class="row">
   
        <div class="col-md-12" id="bg-top">
            <div class="profile"><div><?= $fist_latter; ?></div></div>

            <div class="lang">

            <ul>
                <form method="post" action="<?php current_url(); ?>" id="county">
                <li id="lang-br" value="1"><img src="<?= base_url('assets/images/lang/br.jpg') ?>" with="70" height="32"></li>
                <li id="lang-en" value="2"><img src="<?= base_url('assets/images/lang/en.jpg') ?>" with="70" height="32"></li>
                <li id="lang-sp" value="3"><img src="<?= base_url('assets/images/lang/sp.jpg') ?>" with="70" height="32"></li>
                <input type="hidden" id="changeLangua" name="form_lang">
                </form>
            </ul> 

            </div>

            <div class="options">
                <ul>
                    <li><a href="<?= base_url('admin/leave') ?>"><button type="button" class="btn btn-light"><?php echo $this->lang->line('btn_exit'); ?></button></a></li>
                </ul>
            </div>

        </div>
    </div>

    <div class="row">

        <div class="col-md-2" id="menu-left">
          <?php $this->load->view($pag_menu); ?>
        </div>

        <div class="col-md-10" id="content">
          <?php if($list_acc_level == 0){ ?>

              <div class="notification">

                  <!--
                   X Changes
                   Y Add functionality
                   Z Bugs fix
                   -->
                  <ul class="list-group">
                      <li><a href="http://vipcriativo.com/" class="text-secondary" target="_blank"><?= pack("H*","5669706372696174766f"); ?></a></li>
                      <li><small><?= pack("H*","464D"); ?> 3.1.9</small></li>
                      <li><small><?= pack("H*","5256"); ?> <?=$version?></small></li>
                  </ul>

              </div>
          <?php } ?>

          <?php $this->load->view($pag_content); ?>

        </div>
    </div>

    <!-- Footer
    <div class="row">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">

           <footer id="footer"><?php $this->load->view($pag_footer); ?></footer>

        </div>
    </div>-->
</div>


</body>
</html>