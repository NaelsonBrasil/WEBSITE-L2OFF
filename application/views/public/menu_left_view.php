<div class="panel-title">
    <div class="border-tag-left1"><p class="text-center">Painel Admin</p></div>
</div>

<div class="login">

    <form method="post" id="public_login" onsubmit="return false">
        <input type="text" placeholder="Sign In" maxlength="16" name="username" class="form-control" id="login">
        <div class="input-group input-login">
            <input type="password" class="form-control" placeholder="password" name="password" maxlength="16" id="pwd">
            <span class="input-group-btn"><button class="btn btn-dark btn-captcha" type="button">Captcha</button></span>
        </div>

        <div class="capt">
            <div class="input-group" id="input-captcha">
                <i class="fas fa-times close-captcha"></i>
                <div class="g-recaptcha" data-sitekey="6Le5EngUAAAAALPipllSwnV5O1g_gEJD1WKhvzoK" style="margin-left: 30px; margin-top: 20px;"></div>
               <button class="btn btn-submit-public btn-danger" type="submit" value="Check">Enter</button>
            </div>
        </div>

    </form>
    <div class="recover-password"><a href="#">Recover Password?</a></div>

</div>

<div class="menu">
    <ul>
        <li><a href="<?= base_url() ?>">Home</a></li>
        <li><a href="<?= base_url('/admin/register') ?>">Register</a></li>
        <li><a href="<?= base_url('/info') ?>">Information</a></li>
        <li><a href="<?= base_url('/contact') ?>">Contact</a></li>
        <li><a href="<?= base_url('boss') ?>">RaidBoss</a></li>
        <li><a href="http://vipcriativo.com/">Forum</a></li>
    </ul>
</div>


<div class="gallery-title">
    <div class="border-tag-left2"><p class="text-center">Gallery</p></div>
</div>
<div class="gallery">
    <ul>
      <?php for ($i = 0; $i < $amount_img_up_public; $i++) { ?>
          <li>
              <div><img width="100"  height="100" id="gry-id<?=$i?>" src="<?= base_url("uploaded/" . $gallery_name_public[$i]); ?>"></div>
          </li>
      <?php } ?>
    </ul>
</div>