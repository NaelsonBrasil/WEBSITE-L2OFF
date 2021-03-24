<?php if (isset($success) AND $success === true) { ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">

            <span>Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/tools/unlock"); ?>">Sair</a></span>

        </div>
    </div>
    <?php
} else if (isset($success) AND $success === false) {
    ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span> Error <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/tools/unlock"); ?>">Sair</a></span>

        </div>
    </div>
    <?php
} else if (isset($success) AND $success === 200) {
    ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span>Only 1-9 and Special [-]  Error <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/tools/unlock"); ?>">Sair</a></span>

        </div>
    </div>
    <?php
}
?>

    <div class="flex-container">
        <div class="alert alert-primary text-center m-2" role="alert">
            Update Loc
        </div>

        <div class="line">
            <?php echo form_open('admin/tools/unlock', 'POST'); ?>

            <div class="form-group">
                <label for="exampleInputAccount">Unlock Character</label>
                <input type="text" class="form-control" id="exampleInputAccount" disabled value="<?= $x_loc0 . " " . $y_loc0 . " " . $z_loc0 ?>">
            </div>

            <div class="form-group">
                <label for="target_char">Select char name</label>
                <select name="form_char" class="form-control text-danger" id="target_char" <?php if (count($charName) == 0) { ?> disabled="disabled" <?php } ?> >

                    <?php for ($i = 0; $i < count($charName); $i++) { ?>
                        <option value="<?= $charId[$i] ?>" class="text-primary"><?= $charName[$i] ?></option>
                    <?php } ?>

                </select>
            </div>

            <div class="form-group">

                <label for="exampleInputPassword1">Insert</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="form_xloc" placeholder="x loc" maxlength="15" value="<?php if (!empty($x_loc1)) echo $x_loc1;else{ ?>  <?php echo"disabled";}?> ">
                <input type="text" class="form-control" id="exampleInputPassword1" name="form_yloc" placeholder="y loc" maxlength="15" value="<?php if (!empty($y_loc1)) echo $y_loc1;else{ ?>  <?php echo"disabled";}?> ">
                <input type="text" class="form-control" id="exampleInputPassword1" name="form_zloc" placeholder="z loc" maxlength="15" value="<?php if (!empty($z_loc1)) echo $z_loc1;else{ ?>  <?php echo"disabled";}?> ">

                <small id="emailHelp" class="form-text text-muted"> In order</small>

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
<?php