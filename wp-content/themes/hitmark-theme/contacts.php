<?php
/**
 *  Template Name: Kontakty
 */
get_header();

$prod_img = get_field('ct_image');
$galleries = get_field('ct_galeria');


?>
<section class="product contacts" style="background-image: url(<?php echo $prod_img['sizes']['bigest-thumb']; ?>);">
    <div class="container container_header">
        <div class="row">
            <div class="col-12 header_wrap">
                <h1 class="product_header bg_red text_white"><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>

<article class="product_content">
    <div class="container">
        <div class="row">
            <div class="col-12 default_page list_red_dots">
                <?php the_field('ct_content'); ?>
            </div>
        </div>
    </div>
</article>

<?php
    $args = [
        'post_type'     => 'contacts',
        'numberposts' => -1,
        'post_status'   => 'publish',
        'order' => 'ASC',
    ];

    $posts = get_posts($args);

    if ( $posts ) :
?>
<section class="managers">
    <div class="container">
        <div class="row">
            <h2 class="col-12 managers_choose_title text_red"><?php the_field('skontaktuj_title') ?></h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="managers_choose">
                    <select name="manage" id="manage" class="managers_list dropdown" style="display: none;"
                        data-visible-options="<?php echo count($posts); ?>"
                        data-search-limit="<?php echo count($posts); ?>">
                        <option value="0">województwo</option>
                        <?php foreach ($posts as $post) : ?>
                        <option value="<?php echo $post->ID ?>"><?php echo $post->post_title; ?></option>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </select>
                    <div class="managers_choose_arrow"></div>
                </div>
                <div id="result" class="managers_result"></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<section class="product_book">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="service product_book_wrap bg_red">
                    <strong class="service_title text_white h2"><?php the_field('ct_title'); ?></strong>
                    <div class="product_book_link contact_link">
                        <div class="contact_col_left">
                            <p><span class="service_name text_white"><?php the_field('ct_name'); ?></span></p>
                            <div class="service_name text_white"><?php the_field('ct_addres'); ?></div>
                            <p class="service_name text_white"><?php the_field('ct_nip'); ?></p>
                        </div>
                        <div class="contact_col">
                            <p>
                                <?php $phone = get_field('ct_phone'); ?>
                                <span class="service_name text_white">tel. </span>
                                <a class="service_item text_white"
                                    href="tel:<?php echo phone_format($phone); ?>"><?php echo $phone; ?>
                                </a>
                            </p>
                            <p>
                                <span class="service_name text_white">e-mail. </span>
                                <a class="service_item text_white"
                                    href="mailto:<?php the_field('ct_email'); ?>"><?php the_field('ct_email'); ?>
                                </a>
                            </p>
                            <p>
                                <span class="service_name text_white">&nbsp</span>

                            </p>
                            <p>
                                <?php $phones = get_field('ct_phone_service'); ?>
                                <span class="service_name text_white">serwis 24h tel. </span>
                                <a class="service_item text_white"
                                    href="tel:<?php echo phone_format($phones); ?>"><?php echo $phones; ?>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($galleries) : ?>
<section class="gallery bg_grey">
    <div class="container container_big">
        <div class="row gallery_title_row">
            <h2 class="gallery_title text_red"><?php the_field('ct_gal_header'); ?></h2>
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
            <a class="gallery_btn text_red js-show" href="javascript:;"><?php the_field('ct_gal_btn') ?></a>
        </div>
    </div>
</section>
<?php wp_reset_postdata(); endif; ?>


<?php get_footer(); ?>
