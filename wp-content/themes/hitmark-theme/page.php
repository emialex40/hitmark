<?php
    get_header();

    $prod_img = get_field('df_bg');
    $style = get_field('style_temp');
    $txt_bool = get_field('text_yes');
    $text = get_field('df_text');

    if ( $style == 'Czerwony Styl' ) {
        $bg_color = ' bg_red';
        $txt_color = ' text_white';
        $list = ' list_red_dots';
        $txt_bottom = ' text_red';
    }

    if ( $style == 'Żółty Styl' ) {
        $bg_color = ' bg_yellow';
        $txt_color = ' text_dark';
        $list = ' list_yellow_dots';
        $txt_bottom = ' text_dark';
    }

?>
<section class="product" style="background-image: url(<?php echo $prod_img['sizes']['bigest-thumb']; ?>);">
    <div class="container container_header">
        <div class="row">
            <div class="col-12 header_wrap">
                <h1 class="product_header<?php echo $bg_color; ?><?php echo $txt_color; ?>"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>

<article class="product_content">
    <div class="container">
        <div class="row">
            <div class="col-12 default_page<?php echo $list; ?>">
                <?php the_content(); ?>
            </div>
        </div>
        <?php if ($txt_bool) : ?>
        <div class="row" bottom_row>
            <div class="col-12">
                <span class="bottom_text<?php echo $txt_bottom; ?>"><?php echo $text; ?></span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</article>
<?php get_footer(); ?>
