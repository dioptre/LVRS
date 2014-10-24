<?php snippet('header') ?>

<?php snippet('menu') ?>

<div class="bg-slider-wrapper">
    <div class="flexslider bg-slider">
        <ul class="slides">
            <li class="slide slide-1"  style="background-image: url('<?php echo $site->files()->find(html($site->coverpic()))->url() ?>')"></li>
           <!-- <li class="slide slide-2"></li>
            <li class="slide slide-3"></li>-->
        </ul>
    </div>
</div><!--//bg-slider-wrapper-->

<section class="promo section section-on-bg">
    <div class="container text-center">
        <h2 class="title">
            <?php echo html($page->covertitle()) ?>
        </h2>
        <p class="intro">
            <?php echo html($page->coversubtitle()) ?>
        </p>
        <p><a class="btn btn-cta btn-cta-primary" href="<?php echo html($site->signupurl()) ?>">
            <?php echo html($page->coverbtn()) ?>
        </a></p>
        <!-- <button type="button" class="play-trigger btn-link " data-toggle="modal" data-target="#modal-video"><i class="fa fa-youtube-play"></i> Watch the video</button> -->
    </div><!--//container-->
</section><!--//promo-->


<div class="sections-wrapper">
    <?php
        foreach($page->children()->visible() as $section) {
            snippet($section->template(), array('data' => $section));
        }
    ?>
</div>


<?php snippet('footer') ?>