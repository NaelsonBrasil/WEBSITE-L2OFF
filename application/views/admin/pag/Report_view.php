<br>
<!--<div class="alert alert-primary text-center" role="alert">-->
<!--    <span>Amount of report posted </span>-->
<!--</div>-->

<?php if(isset($success) AND $success === true){ ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">
            Send com success
            <a role="button" class="btn btn-alert btn-success" href="<?php echo site_url("admin/report"); ?>">Sair</a>
        </div>
    </div>
<?php } ?>

<?php if(isset($success) AND $success === false){ ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">
            Error
            <a role="button" class="btn btn-alert btn-danger" href="<?php echo site_url("admin/report"); ?>">Sair</a>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-6 text-center">

       <ul class="category">
           <li><a href="#" class="btn-category">Server</a></li>
           <li><a href="#" class="btn-category">Website</a></li>
       </ul>

    </div>
</div>

<br>

<div class="row">
    <small class="col-md-12 text-center">

      <?php echo form_open('admin/report/created','POST'); ?>

        <div class="form-group m-auto">
        <label for="Select"></label>
        <select class="custom-select custom-select-sm w-25" id="Select" name="category">
          <option selected>Select category report</option>
          <option value="1">Server</option>
          <option value="2">Website</option>
        </select>
       </div>

        <div class="form-group text-left">
            <label for="Title"></label>
            <input type="text" name="title" id="Title" class="form-control m-auto w-25" maxlength="50" placeholder="Title">
        </div>

        <div class="form-group text-left">
            <label for="Text"></label>
            <textarea class="form-control m-auto" id="Text" rows="3" name="content" maxlength="150"></textarea>
        </div>

        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6Le5EngUAAAAALPipllSwnV5O1g_gEJD1WKhvzoK" style="margin-left: 35% !important;"></div>
        </div>

      <?php if($vip === 1){ ?>
          <button type="submit" class="btn btn-notice btn-dark text-center w-50">Send</button>
      <?php }else{ ?>
          <button type="submit" class="btn btn-notice btn-dark text-center w-50" disabled>Send</button><br>
          <small>Do you need to be vip member</small>

      <?php } ?>

      <?php echo validation_errors(); ?>
      <?php echo form_close(); ?>

    </div>
</div>
