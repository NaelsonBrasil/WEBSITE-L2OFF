<script type="application/javascript">
    $(function () {
        $('.delete-news').click(function (e) {
            e.preventDefault();
            console.log(this.id + "" + $(this).val());
            $.ajax({
                url: "<?= base_url('admin/notice/deleted') ?>",
                type: "POST",
                data: {btnId: this.id, token: $(this).val()},
                dataType: "json",
                success: function (json) {

                    //Nao sei explicar o por que se eu colocar if para de funcionar
                    let url = ' <?= site_url("admin/notice"); ?>';
                    window.location.href = url;

                },
                error: function (result) {
                    alert("Error");
                }
            });

        });
    });
</script>
<br>
<div class="alert alert-primary text-center" role="alert">
    <span>Amount of news published</span> <span class="badge badge-success"><?= $amount_news ?></span>
</div>

<?php if (isset($success) AND $success === true) { ?>
    <div class="exception">
        <div class="alert display-alert alert-success" role="alert">
            <span> Success <a role="button" class="btn btn-exception btn-alert btn-success" href="<?php echo site_url("admin/notice"); ?>">Sair</a></span>
        </div>
    </div>
<?php } ?>

<div class="row">

    <div class="col-md-12 text-center">

        <ul class="notice-ul">
          <?php for ($i = 0; $i < $amount_news; $i++) { ?>
              <li class="notice-title"><p class="text-info"><?= $notice_title[$i] ?></p></li>
              <li class="notice-msg text-secondary"><?= $notice_text[$i] ?>
                  <small class="text-danger">&nbsp;<?= $notice_date[$i] ?>&nbsp;<?= $notice_time[$i] ?>&nbsp;</small>
                  <button type="button" class="delete-news" id="<?php echo "news" . $i; ?>" value="<?= $notice_token[$i] ?>"><i class="fas fa-trash-alt"></i></button>
              </li>
              <hr/>
          <?php } ?>
        </ul>

    </div>

</div>

<div class="row">
    <div class="col-md-12 text-center">

      <?php echo form_open('admin/notice/sent', 'POST'); ?>

        <div class="form-group text-left">
            <label for="msg-title"></label>
            <input type="text" name="title" id="msg-title" class="form-control w-50" maxlength="50" placeholder="Title">
        </div>

        <div class="form-group text-left">
            <label for="msg-text"></label>
            <textarea class="form-control" id="msg-text" rows="3" name="text" maxlength="350" placeholder="Text Message"></textarea>
        </div>

      <?php if ($amount_news < 4) { ?>
          <button type="submit" class="btn btn-notice btn-dark text-center w-50">Send</button>
      <?php } else { ?>
          <button type="submit" class="btn btn-notice btn-dark text-center w-50" disabled>Send</button>
      <?php } ?>

      <?php echo validation_errors(); ?>
      <?php echo form_close(); ?>

    </div>
</div>