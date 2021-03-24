<?php if ($notice): ?>
<?php foreach ($notice as $notice): ?>

<div class="notice-title">
    <h3>  <?= $notice->title ?></h3>
</div>

<div class="notice">

    <small class="notice-text">
      <?= $notice->text ?>
      <?php endforeach; ?>
    </small>
    <div class="pagination-notice">
      <?= $pagination; ?>
      <?php endif; ?>
    </div>
</div>


<div class="video">

<!--    <div>-->
<!--        <iframe width="250" height="180" src="https://www.youtube.com/embed/BjHOxAc_-mk">-->
<!--        </iframe>-->
<!--        <p class="text-light">Live with: <strong class="text-primary">Lorem</strong></p>-->
<!--    </div>-->
<!---->
<!--    <div>-->
<!--        <iframe width="250" height="180" src="https://www.youtube.com/embed/BjHOxAc_-mk">-->
<!--        </iframe>-->
<!--        <p class="text-light">Live with: <strong class="text-primary">Lorem</strong></p>-->
<!--    </div>-->
<!---->
<!--    <div>-->
<!--        <iframe width="250" height="180" src="https://www.youtube.com/embed/BjHOxAc_-mk">-->
<!--        </iframe>-->
<!--        <p class="text-light">Live with: <strong class="text-primary">Lorem</strong></p>-->
<!--    </div>-->

</div>
<div class="text-light vip"><a href="http://vipcriativo.com/">Vip</a></div>