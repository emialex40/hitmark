<?php
/**
 *  Template Name: Serwis
 */

get_header();

$prod_img = get_field('sv_hero_image');
$products = get_field('sv_add_service');
$books = get_field('sv_contacts');


?>
    <section class="product" style="background-image: url(<?php echo $prod_img['sizes']['bigest-thumb']; ?>);">
        <div class="container container_header">
            <div class="row">
                <div class="col-12 header_wrap">
                    <h1 class="product_header bg_red text_white"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </section>

<?php
$content = get_field('sv_content');
if ($content !== '') :
    ?>
    <article class="product_content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php the_field('sv_content'); ?>
                </div>
            </div>
        </div>
    </article>
<?php endif; ?>

<?php if ($products) : ?>
    <section class="product_list<?php echo (!$content) ? ' add_padding' : ''; ?>">
        <div class="container">
            <div class="row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-12 product_list_all">
                        <div class="product_list_item js-open">
                            <div class="product_list_wrap">
                                <div class="product_list_title text_red h3"><?php echo $product['sv_name_service']; ?></div>
                            </div>
                            <div class="product_list_btn bg_red"><i class="fal fa-plus"></i></div>
                        </div>

                        <div class="product_list_desc js-desc">
                            <div class="product_list_desc_flex">
                                <div class="product_list_desc_cont list_red_dots"><?php echo $product['sv_desc_service']; ?></div>
                                <div class="product_list_desc_line bg_red"></div>
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
                    <div class="service product_book_wrap bg_red">
                        <strong class="service_title text_white h3"><?php the_field('sv_desc'); ?></strong>
                        <div class="product_book_link">
                            <?php foreach ($books as $item) : ?>
                                <div class="service_link_row">
                                    <span class="service_name text_white"><?php echo $item['sv_name']; ?></span>
                                    <a class="service_item text_white"
                                       href="tel:<?php echo phone_format($item['sv_phone']); ?>">tel. <?php echo $item['sv_phone']; ?>
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

<?php get_footer(); ?>