<div class="status">
    <ul>
        <li>Auth&ensp;<img src="<?= base_url('assets/images/layout/absolute/on.png') ?>"></li>
        <li>Game&ensp;<img src="<?= base_url('assets/images/layout/absolute/on.png') ?>"></li>
        <li>Npc&ensp;<img src="<?= base_url('assets/images/layout/absolute/off.png') ?>"></li>
    </ul>
    <div class="rate"><p>Rate&ensp; Exp:75x - SP:120x -Adenas 75x</p></div>
</div>

<div class="top-server">
    <h3>Top Server</h3>
    <ul>
        <li><img src="<?= base_url('assets/images/layout/absolute/top.png') ?>">&ensp;<a href="#">Top 200 Server</a>
        </li>
        <li><img src="<?= base_url('assets/images/layout/absolute/top.png') ?>">&ensp;<a href="#">Top JBrasil</a></li>
        <li><img src="<?= base_url('assets/images/layout/absolute/top.png') ?>">&ensp;<a href="#">Top Game</a></li>
    </ul>
</div>

<div class="rank-title">
    <div class="border-tag-right1"><p class="text-center">Ranking</p></div>
</div>

<div class="rank">
    <div><h6 class="text-light" style="line-height: 20px">PVP</h6></div>
    <ul>
      <?php for ($i = 0; $i < $rank_rp_size; $i++) { ?>
        <?php if ($i == 0) { ?>
              <li>
                  <marquee><?= ($i + 1) ?> º <?= $nick_rp_public[$i] ?> - PVP&ensp;<small style="color: #CE5700"><?= $pvp_rp_public[$i] ?>&ensp;</small>&ensp;PK&ensp;<small style="color: #CE5700"><?= $pk_rp_public[$i] ?></small>
                  </marquee>
              </li>
        <?php } else { ?>
              <li>
                  <small><?= ($i + 1) ?> º <?= $nick_rp_public[$i] ?> - PVP&ensp;<small style="color: #CE5700"><?= $pvp_rp_public[$i] ?>&ensp;
                          <small>PK&ensp;<small style="color: #CE5700"><?= $pk_rp_public[$i] ?></small></small>
              </li>
        <?php } ?>
      <?php } ?>
    </ul>

</div>


<div class="rank">

    <div><h6 class="text-light" style="line-height: 20px">PK</h6></div>
    <ul>
      <?php for ($i = 0; $i < $rank_rk_size; $i++) { ?>

        <?php if ($i == 0) { ?>
              <li>
                  <marquee><?= ($i + 1) ?> º <?= $nick_rk_public[$i] ?> - PVP&ensp;<small style="color: #CE5700"><?= $pvp_rk_public[$i] ?>&ensp;</small>&ensp;PK&ensp;<small style="color: #CE5700"><?= $pk_rk_public[$i] ?></small>
                  </marquee>
              </li>
        <?php } else { ?>
              <li>
                  <small><?= ($i + 1) ?> º <?= $nick_rk_public[$i] ?> - PVP&ensp;<small style="color: #CE5700"><?= $pvp_rk_public[$i] ?>&ensp;
                          <small>PK&ensp;<small style="color: #CE5700"><?= $pk_rk_public[$i] ?></small></small>
              </li>
        <?php } ?>
      <?php } ?>
    </ul>

</div>