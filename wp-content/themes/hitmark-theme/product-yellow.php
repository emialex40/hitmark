<?php
/**
 *  Template Name: W żółtym stylu
 */

get_header();

$prod_img = get_field('tmp_img');
$products = get_field('tmp_repeater');
$books = get_field('add_book');
$galleries = get_field('tmp_include_gallery');
$ad_field = get_field('dp_dostepne_modele');
$flags = get_field('flags');
?>
<section class="product" style="background-image: url(<?php echo $prod_img['sizes']['bigest-thumb']; ?>);">
    <div class="container container_header">
        <div class="row">
            <div class="col-12 header_wrap">
                <h1 class="product_header bg_yellow text_dark"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>

<article class="product_content product_content_yellow">
    <div class="container">
        <div class="row falgs_row">
            <div class="col-12">
                <img src="<?php echo $flags['sizes']['large'] ?>" alt="<?php echo $flags['title']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php the_field('tmp_content'); ?>
            </div>
        </div>
    </div>
</article>

<?php
if ($ad_field) :
    $ad_field_group = get_field('dodatkowe_pole');
    ?>
<section class="product_list product_list_ad">
    <div class="container">
        <div class="row">
            <div class="col-12 product_list_all">
                <div class="product_list_item js-open">
                    <div class="product_list_wrap">
                        <div class="product_list_title text_dark h3"><?php echo $ad_field_group['dt_nazwa_produktu']; ?>
                        </div>
                    </div>
                    <div class="product_list_btn bg_yellow"><i class="fal fa-plus"></i></div>
                    <div class="product_list_desc js-desc">
                        <div class="product_list_desc_flex">
                            <div class="product_list_desc_cont list_yellow_dots js-desc">
                                <?php echo $ad_field_group['dt_opis_produktu']; ?></div>
                            <div class="product_list_desc_line bg_yellow"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($ad_field) : $ad_field_group = get_field('dodatkowe_pole'); ?>
<div class="ad_title_block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="ad_title"><?php echo $ad_field_group['dp_modele_title']; ?></h3>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($products) : ?>
<section class="product_list">
    <div class="container">
        <div class="row">
            <?php foreach ($products as $product) : ?>
            <div class="col-12 product_list_all">
                <div class="product_list_item js-open">
                    <div class="product_list_wrap">
                        <div class="product_list_title text_dark h3"><?php echo $product['tmp_product_name']; ?></div>
                    </div>
                    <div class="product_list_btn bg_yellow"><i class="fal fa-plus"></i></div>
                </div>
                <div class="product_list_desc js-desc">
                    <div class="product_list_desc_flex">
                        <div class="product_list_desc_cont list_yellow_dots"><?php echo $product['tmp_product_desc']; ?>
                        </div>
                        <div class="product_list_desc_line bg_yellow"></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($books) : ?>
<section class="product_book">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product_book_wrap bg_yellow">
                    <h2 class="product_book_title text_dark"><?php the_field('tmp_book_section'); ?></h2>
                    <div class="product_book_link">
                        <?php foreach ($books as $item) : ?>
                        <div class="product_book_link_row">
                            <a class="product_book_item text_dark" href="<?php echo $item['tmp_book_link']; ?>">
                                <i class="fal fa-arrow-circle-down"></i> <?php echo $item['tmp_book_name']; ?>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- gallery beginning -->
<?php if ($galleries) : ?>
<section class="gallery bg_grey">
    <div class="container container_big">
        <div class="row gallery_title_row">
            <h2 class="gallery_title text_dark"><?php the_field('gl_title_block'); ?></h2>
        </div>
        <div id="gallery_row" class="row gallery_row">
            <!--            start loop-->
            <?php
                $count = 0;

                foreach ($galleries as $gallery) :
                    setup_postdata($gallery);
                    $gallery_imgs = get_field('galeria', $gallery->ID);

                    foreach ($gallery_imgs as $gallery_img) :
                        $count++;
                        $img = $gallery_img['gl_add_image'];
                        $hide = ' style="display: none;"';
                        ?>
            <div class="col-md-4 col-12 gallery_item" <?php echo ($count > 6) ? $hide : ''; ?>>
                <a class="gallery_big" href="<?php echo $img['sizes']['bigest-thumb']; ?>"
                    data-fancybox="<?php echo $gallery->post_title; ?>"
                    data-caption="<?php echo ($img['description'] !== '') ? $img['description'] : $img['title']; ?>">
                    <img class="gallery_img" src="<?php echo $img['sizes']['gallery-thumb']; ?>"
                        alt="<?php echo $img['title']; ?>">
                </a>
            </div>
            <?php endforeach; ?>
            <?php endforeach; ?>
            <!--            loop end-->
        </div>
        <div class="row gallery_btn_row">
            <a class="gallery_btn gallery_btn_yellow text_dark js-show"
                href="javascript:;"><?php the_field('gl_button_text') ?></a>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); endif; ?>
<!-- gallery end -->

<?php get_footer(); ?>
