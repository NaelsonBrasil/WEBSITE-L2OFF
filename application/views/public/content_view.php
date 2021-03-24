
<div class="download-main">
    <h3 class="text-secondary">Interlude-L2OFF</h3>
    <a href="<?=base_url('/download')?>"><img src="<?= base_url('assets/images/layout/absolute/download-main.png') ?>"></a>
</div>

<div class="slider-vipcriativo">

    <div class="carousel m-auto slider-vipcriativo-com">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">


            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active circle">
                    <div class="target"></div>
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1" class="circle">
                    <div class="target"></div>
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"
                    class="circle">
                    <div class="target"></div>
                </li>
            </ol>


            <div class="info-slider">
                <small class="text-justify">To welcome lineage2</small>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="<?= base_url('assets/images/layout/slider/slide1.png') ?>" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="<?= base_url('assets/images/layout/slider/slide2.png') ?>" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="<?= base_url('assets/images/layout/slider/slide3.png') ?>" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>


        </div>
    </div>

</div>

<div class="dynamic">
  <?php $this->load->view($pag_dynamic); ?>
</div>
