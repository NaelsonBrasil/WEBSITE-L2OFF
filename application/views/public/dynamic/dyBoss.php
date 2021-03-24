<div class="raid">
    <p class="raid-title">Raid Boss</p>
    <img class="" src="<?= base_url('assets/images/layout/separator.png') ?>">
</div>
<?php

if ($boss): ?>
  <?php foreach ($boss as $boss): ?>


        <div class="text-light list-raid">&ensp;
          <?php if ($boss->alive == 0) { ?>
              <img class="raid-status" src="<?= base_url('assets/images/layout/offline.png') ?>">
          <?php } else { ?>
              <img class="raid-status" src="<?= base_url('assets/images/layout/online.png') ?>">
          <?php } ?>
            &ensp;<?= str_replace("_", " ", ucfirst($boss->npc_db_name)) ?></div>

  <?php endforeach; ?>

    <div style="margin-left: 5px;">
        <br>
        <span><?= $pagination; ?></span>
    </div>
<?php endif; ?>

