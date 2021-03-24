<ul class="list-left">
    <li class="li-primary"><a href="<?php echo site_url("admin"); ?>"><i
                    class="fas fa-tachometer-alt icon-menu-left"></i>DashBoard</a></li>
    <div class="separator" id="sp1"></div>

  <?php if (strcmp($ini_login_adm, $user_name) === 0 AND $list_acc_level === 1) { ?>

      <li class="btn-adm ext-primary"><i class="fas fa-bars icon-menu-left-ext"></i><?php echo $this->lang->line('admin-title'); ?>
          <ul class="li-secondary">
              <li><a href="<?= site_url("admin/menu"); ?>"><?php echo $this->lang->line('btn_menu'); ?></a></li>
              <li><a href="<?= site_url("admin/gallery"); ?>"><?php echo $this->lang->line('btn_gallery'); ?></a></li>
              <li><a href="<?= site_url("admin/notice"); ?>"><?php echo $this->lang->line('btn_news'); ?></a></li>
              <li><a href="<?= site_url("admin/live"); ?>"><?php echo $this->lang->line('btn_live'); ?></a></li>
              <li><a href="<?= site_url("admin/add/item"); ?>"><?php echo $this->lang->line('btn_register_item'); ?></a></li>
          </ul>
      </li>

      <div class="separator" id="sp2"></div>

  <?php } ?>

    <li class="ext-primary"><i class="fas fa-shopping-cart icon-menu-left-ext"></i><?php echo $this->lang->line('shop'); ?>

        <ul class="li-secondary">
            <li><a href="<?= site_url("admin/cart"); ?>"><?php echo $this->lang->line('btn_cart'); ?></a></li>
            <li><a href="<?= site_url("admin/order"); ?>"><?php echo $this->lang->line('btn_order'); ?></a></li>
            <li><a href="<?= site_url("admin/donated"); ?>"><?php echo $this->lang->line('btn_donate'); ?></a></li>
        </ul>
        
    </li>

    <div class="separator" id="sp2"></div>
    <li class="ext-primary"><i class="fas fa-exchange-alt icon-menu-left-ext"></i><?php echo $this->lang->line('change'); ?>
        <ul class="li-secondary">
          <?php if ($val_password == 1) { ?>
              <li><a href="<?= site_url("admin/account/password"); ?>"><?php echo $this->lang->line('btn_password'); ?></a></li>
          <?php } ?>
          <?php if ($val_nick == 1) { ?>
              <li><a href="<?= site_url("admin/account/nickname"); ?>"><?php echo $this->lang->line('btn_nick_name'); ?></a></li>
          <?php } ?>
          <?php if ($val_email == 1) { ?>
              <li><a href="<?= site_url("admin/account/email"); ?>"><?php echo $this->lang->line('btn_email'); ?></a></li>
          <?php } ?>
        </ul>
    </li>
    <div class="separator" id="sp3"></div>
    <li class="ext-primary"><i class="fas fa-toolbox icon-menu-left-ext"></i><?php echo $this->lang->line('tools'); ?>
        <ul class="li-secondary">
          <?php if ($val_unlock == 1) { ?>
              <li><a href="<?= site_url("admin/tools/unlock"); ?>"><?php echo $this->lang->line('btn_unlock'); ?></a></li>
          <?php } ?>

        </ul>
    </li>
    <div class="separator" id="sp3"></div>
    <li class="ext-primary"><i class="fas fa-bug icon-menu-left-ext"></i><?php echo $this->lang->line('title-report'); ?>
        <ul class="li-secondary">
          <?php if ($val_unlock == 1) { ?>
              <li><a href="<?= site_url("admin/report"); ?>"><?php echo $this->lang->line('btn_help'); ?></a></li>
          <?php } ?>

        </ul>
    </li>
    <li class="separator" id="sp4"></li>
    <li class="li-primary"><a href="<?= site_url(""); ?>"><i class="fas icon-menu-left fa-eye"></i><?php echo $this->lang->line('title-view'); ?></a></li>

</ul>


<?php
