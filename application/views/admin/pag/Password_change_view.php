<?php if (isset($success) AND $success === false) { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span>Password does not match <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/account/password"); ?>">Sair</a></span>

        </div>
    </div>
    <?php
} else if (isset($success) AND $success === true) {
    ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">

            <span>Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/account/password"); ?>">Sair</a></span>

        </div>
    </div>
    <?php
} else if (isset($success) AND $success === 200) { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span>Character special no allowed <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/account/password"); ?>">Sair</a></span>

        </div>
    </div>
<?php } ?>

<div class="flex-container">
    <div class="alert alert-primary text-center m-2" role="alert">
        Update Password
    </div>

    <div class="line">
        <?php echo form_open('admin/account/password', 'POST'); ?>

        <div class="form-group">
            <label for="exampleInputAccount">Alterar Senha</label>
            <input type="text" class="form-control" id="exampleInputAccount" disabled value="<?= $user_name ?>">
        </div>

        <div class="form-group">
            <label for="target_password1">Password Velho</label>
            <input type="password" class="form-control" id="target_password1" name="form_password1" maxlength="16" required>
            <small id="emailHelp" class="form-text text-muted"> Must be 8-16 characters long.</small>
        </div>

        <div class="form-group">
            <label for="target_password2">Novo Password</label>
            <input type="password" class="form-control" id="target_password2" name="form_password2" maxlength="16" required>
            <small id="emailHelp" class="form-text text-muted"> Must be 8-16 characters long.</small>
        </div>

        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6Le5EngUAAAAALPipllSwnV5O1g_gEJD1WKhvzoK"></div>
        </div>

        <button type="submit" class="btn btn-change-password btn-dark">Enter</button>
        <?php echo validation_errors(); ?>
        <?php echo form_close(); ?>
    </div>

</div>
<?php