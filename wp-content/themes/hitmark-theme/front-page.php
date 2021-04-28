<?php
    get_header();

    $hero_bg_arr = get_field('hero_background');
    $hero_bg = $hero_bg_arr['sizes']['bigest-thumb'];
    $hero_img = get_field('hero_pic');
    $hero_icons = get_field('hero_icons');
    $bottom_image = get_field('front_bottom');

?>

<!-- TODO: hero section beginning-->
<section id="hero" class="hero" style="background-image: url(<?php echo $hero_bg; ?>);">
    <div class="container container_header">
        <div class="row hero_row">
            <div class="hero_img">
                <img class="hero_img_desc" src="<?php echo $hero_img['hero_pic_desc']; ?>" alt="hero img" width="145">
                <img class="hero_img_mob" src="<?php echo $hero_img['hero_pic_mob']; ?>" alt="hero img">
            </div>
            <div class="col-12 hero_content">
                <div class="hero_icons">
                    <div class="hero_icons_item">
                        <img src="<?php echo $hero_icons['hiro_add_icon1']; ?>" alt="hero_icon" width="116" height="116">
                    </div>
                    <div class="hero_icons_item">
                        <img src="<?php echo $hero_icons['hiro_add_icon2']; ?>" alt="hero_icon" width="144" height="130">
                    </div>
                </div>
                <h1 class="hero_header text_white"><?php the_field('hero_text'); ?></h1>
            </div>
        </div>
    </div>
    <a class="hero_arrow" href="#content"></a>
</section>
<!-- hero section end -->

<!-- text section beginning -->
<section id="content" class="content">
    <div class="container">
        <div class="row">
            <article class="col-12">
                <h2 class="content_header"><?php the_field('front_title'); ?></h2>
                <div class="content_wrapper">
                    <div class="content_show"><?php the_field('front_text_show'); ?></div>
                    <div class="content_hide"><?php the_field('front_hide_text'); ?></div>
                    <a href="javascript:;" class="content_more text_red"><?php the_field('front_btn_text'); ?></a>
                </div>
            </article>
        </div>
    </div>
</section>
<!-- text section end -->

<!-- bottom section beginning -->
<section class="front_bottom" style="background-image: url(<?php echo $bottom_image['sizes']['bigest-thumb']; ?>);"></section>
<!-- bottom section end -->


<?php get_footer(); ?>  