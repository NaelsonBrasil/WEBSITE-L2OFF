<?php if (isset($success) AND $success === true) { ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">
            <span>Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/account/nickname"); ?>">Sair</a></span>
        </div>
    </div>
<?php } else if (isset($success) AND $success === 200) { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">
            <span>Password does not match <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/account/nickname"); ?>">Sair</a></span>
        </div>
    </div>
<?php } else if (isset($success) AND $success === false) { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">
            <span>Error <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/account/nickname"); ?>">Sair</a></span>
        </div>
    </div>
<?php } ?>

    <div class="flex-container">
        <div class="alert alert-primary text-center m-2" role="alert">
            Update NickName
        </div>


        <div class="line">
          <?php echo form_open('admin/account/nickname', 'POST'); ?>
            <div class="form-group">
                <label for="exampleInputAccount">Password</label>
                <input type="password" class="form-control" id="exampleInputAccount" disabled value="<?= $password ?>">
            </div>

            <div class="form-group">

                <label for="target_char">Select char name</label>
                <select name="form_char" class="form-control text-danger" id="target_char" <?php if (count($char_name) == 0) { ?> disabled="disabled" <?php } ?> >

                  <?php for ($i = 0; $i < count($char_name); $i++) { ?>
                      <option value="<?= $char_id[$i] ?>" class="text-primary"><?= $char_name[$i] ?></option>
                  <?php } ?>

                </select>

            </div>

            <div class="form-group">
                <label for="Nickname">Novo nome apelido</label>
                <input type="text" class="form-control" id="Nickname" name="form_nick"
                       <?php if (empty($nick_name)) echo "disabled" ?>
                       maxlength="16" autocomplete="off" placeholder="<?php if (empty($nick_name)) echo "none"; else echo "Nick"; ?>">
                <small id="emailHelp" class="form-text text-muted"> Must be 8-16 characters long.
                </small>
            </div>

          <?php ?>
            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6Le5EngUAAAAALPipllSwnV5O1g_gEJD1WKhvzoK"></div>
            </div>

            <button type="submit" class="btn btn-change-password btn-dark">Enter</button>
          <?php echo validation_errors(); ?>
          <?php echo form_close(); ?>
        </div>


    </div>
