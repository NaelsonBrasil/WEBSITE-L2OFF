<script type="application/javascript">

    var loadFile = function (event) {

        if (event.target.files[0].type === "image/jpeg" || event.target.files[0].type === "image/png") {

            var img = new Image();
            img.src = URL.createObjectURL(event.target.files[0]);
            img.onload = function () {

                if (this.width <= 32 && this.height <= 32) {
                    $('#upload_preview').attr('src', this.src);
                } else {
                    var restult = confirm("Size allowed 32/32; Click ok for reload pag!");
                    if (restult === true) window.location.reload();
                }
            };

        } else {
            var restult = confirm("type image allowed png or jpeg; Click ok for reload pag!");
            if (restult === true) window.location.reload();
        }

    };


    $(function () {
        $(".img-uploaded").click(function () {
            $('.list-uploaded').remove();
            $('#upload').val("");
            window.location.reload();
        });
    });


    $(function () {
        $('.upload-delete').click(function (e) {

            e.preventDefault();
            $.ajax({
                url: '<?= base_url('admin/Store_controllers/deleteRegister') ?>',
                type: 'POST',
                data: {token: $(this).val()},
                dataType: 'json',
                success: function (json) {
                    if (json.deleted === true) {
                        let url = ' <?= site_url('admin/add/item'); ?>';
                        window.location.href = url;
                    }

                },
                error: function (result) {
                    alert("Error");
                }
            });

        });
    });

    $(document).ready(function () {

        $("#dtBox").DateTimePicker();

    });
</script>


<?php if (isset($success) AND $success === true) { ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">

            <span>Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url('admin/add/item'); ?>">Sair</a></span>

        </div>
    </div>
<?php } ?>


<?php if (isset($success) AND $success === false) { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span>Exception <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url('admin/add/item'); ?>">Sair</a></span>

        </div>
    </div>
<?php } ?>

<br>
<div class="alert alert-primary text-center" role="alert">
    <span>Items: </span> <span class="badge badge-danger"><?= $donateCountItem; ?></span>
</div>

<div class="row">
    <div class="col-md-12 text-center">

        <ul class="k4b4it3_gallery_vipcriativo_gmail_com ">
            <?php for ($i = 0; $i < $donateCountItem; $i++) {
                $j = $i + 1; ?>
                <li class="vpct_li">
                    <div>
                        <img style="border-radius: 30px !important;" width="32" height="32" src="<?= base_url("uploaded/icon/" . $donateIconName[$i]);?>">
                    </div>
                    <br>
                    <button type="button" class="upload-delete" value="<?= $donateToken[$i] ?>">
                        <i class="fas fa-trash-alt"></i></button>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-6">

        <ul class="main-uploaded">

            <li class="wd-20 list-uploaded">
                <div class="bg-success text-center text-light primary-selected">New</div>
                <div class="img-uploaded">
                    <span class="delete-icon"><i class="fas fa-trash-alt"></i></span><img src="<?= base_url("assets/images/icon-uploaded.svg") ?>" id="upload_preview" class="img-list-selected">
                </div>
            </li>
        </ul>

    </div>

    <div class="col-md-6">

        <form method="POST" enctype="multipart/form-data" action="<?php echo site_url("admin/add/item"); ?>">

            <div class="form-group">
                <label for="target_itemName" class="m-auto"></label>
                <input type="text" name="form_item_name" class="form-control w-50  m-auto" id="target_item_name" placeholder="Item name" maxlength="50" required>
            </div>

            <!--  DateTime Input  -->
            <div class="form-group text-center">
                <label for="date_time" class="m-auto">DateTime Registered:</label>
                <input type="text" name="form_date_time" id="date_time" class="form-control w-50  m-auto" data-field="datetime" readonly required>
                <div id="dtBox"></div>
            </div>

            <div class="form-group">
                <label for="target_id_number" class="m-auto"></label>
                <input type="text" name="form_id_number" class="form-control w-50  m-auto" id="target_id_number" placeholder="Id Item" maxlength="11" required>
            </div>

            <div class="form-group text-center">
                <label for="target_value" class="m-auto">Example: 0.5 or 1.00</label>
                <input type="text" name="form_item_price" class="form-control w-50  m-auto" id="target_value" placeholder="Item Price" maxlength="11" required>
            </div>

            <div class="form-group text-center">
                <label for="target_bonus" class="m-auto">Bonus Optional, Example: 10...1000...</label>
                <input type="text" name="form_item_bonus" class="form-control w-50  m-auto" id="target_bonus" placeholder="Item Bonus" maxlength="11">
            </div>

            <div class="upload-controller wd-20 m-auto">

                <div class="bg-danger text-center text-light select-upload wd-100">Icon</div>
                <div class="text-center">
                    <label for="upload"><i class="fas fa-camera camera-icon"></i></label>
                    <input type="file" name="upload_name" class="upload-input" id="upload" accept="image/*" onchange="loadFile(event)">
                </div>

            </div>

            <input type="submit" class="btn w-100 btn-dark " value="Create" <?php if ($amount_live >= 3) echo "disabled"; ?>>
        </form>

    </div>

</div>
