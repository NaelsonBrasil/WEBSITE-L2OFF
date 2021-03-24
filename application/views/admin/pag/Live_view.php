<script type="application/javascript">

    var loadFile = function (event) {

        if (event.target.files[0].type === "image/jpeg" || event.target.files[0].type === "image/png") {

            var img = new Image();
            img.src = URL.createObjectURL(event.target.files[0]);
            img.onload = function () {

                if (this.width <= 256 && this.height <= 200) {
                    $('#upload_preview').attr('src', this.src);
                } else {
                    var restult = confirm("Size allowed 256/200; Click ok for reload pag!");
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
                url: '<?= base_url("admin/live/deleted") ?>',
                type: 'POST',
                data: {btnId: this.id, token: $(this).val()},
                dataType: 'json',
                success: function (json) {
                    if (json.deleted === true) {
                        let url = ' <?= site_url("admin/live"); ?>';
                        window.location.href = url;
                    }

                },
                error: function (result) {
                    alert("Error");
                }
            });

        });
    });

    $(function () {$("#dtBox").DateTimePicker();});
</script>


<?php if (isset($success) AND $success === true) { ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">

            <span>Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/live"); ?>">Sair</a></span>

        </div>
    </div>
<?php } ?>


<?php if (isset($success) AND $success === false) { ?>
    <div class="exception">
        <div class="alert display-alert alert-danger" role="alert">

            <span>Empty <a role="button" class="btn btn-exception btn-alert btn-danger" href="<?php echo site_url("admin/live"); ?>">Sair</a></span>

        </div>
    </div>
<?php } ?>

<br>
<div class="alert alert-primary text-center" role="alert">
    <span>Channels Registered</span> <span class="badge badge-success"><?= $amount_live ?></span>
</div>

<div class="row">
    <div class="col-md-12 text-center">

        <ul class="k4b4it3_gallery_vipcriativo_gmail_com ">
            <?php for ($i = 0; $i < $amount_live; $i++) {
                $j = $i + 1; ?>
                <li class="vpct_li">
                    <div>
                        <img style="border-radius: 10% !important;" width="180" height="150" src="<?= base_url("uploaded/miniature/" . $live_miniature[$i]); ?>">
                    </div>
                    <br>
                    <button type="button" class="upload-delete" id="<?php echo "btn-id" . $j; ?>" value="<?= $live_token[$i] ?>">
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

        <form method="POST" enctype="multipart/form-data" action="<?php echo site_url("admin/live/uploaded"); ?>">

            <div class="form-group">
                <label for="nickname" class="m-auto"></label>
                <input type="text" name="nickname" class="form-control w-50  m-auto" id="nickname" placeholder="nick" maxlength="16" required>
            </div>

            <!--  DateTime Input  -->
            <div class="form-group text-center">
                <label for="date_time" class="m-auto">DateTime :</label>
                <input type="text" name="date_time" id="date_time" class="form-control w-50  m-auto" data-field="datetime" readonly required>
                <div id="dtBox"></div>
            </div>

            <div class="form-group">
                <label for="url" class="m-auto"></label>
                <input type="text" name="url" class="form-control w-50  m-auto" id="url" placeholder="url channel" maxlength="50" required>
            </div>

            <div class="upload-controller wd-20 m-auto">

                <div class="bg-danger text-center text-light select-upload wd-100">Miniature</div>
                <div class="text-center">
                    <label for="upload"><i class="fas fa-camera camera-icon"></i></label>
                    <input type="file" name="upload_name" class="upload-input" id="upload" accept="image/*" onchange="loadFile(event)">
                </div>

            </div>

            <input type="submit" class="btn w-100 btn-dark " value="Send" <?php if ($amount_live >= 3) echo "disabled"; ?>>
        </form>

    </div>
</div>
<?php