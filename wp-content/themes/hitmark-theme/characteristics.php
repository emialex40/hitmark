<?php
/**
 *  Template Name: Karty charakterystyk
 *
 */
get_header();

$prod_img = get_field('df_bg');
$style = get_field('style_temp');
$txt_bool = get_field('text_yes');
$text = get_field('df_text');

if ($style == 'Czerwony Styl') {
    $bg_color = ' bg_red';
    $txt_color = ' text_white';
    $list = ' list_red_dots';
    $txt_bottom = ' text_red';
}

if ($style == 'Żółty Styl') {
    $bg_color = ' bg_yellow';
    $txt_color = ' text_dark';
    $list = ' list_yellow_dots';
    $txt_bottom = ' text_dark';
}

$category = get_field('category');


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

<section class="product_content">
    <div class="container">
        <div class="row">
            <div class="col-12 default_page<?php echo $list; ?>">
                <?php
                $args = [
                    'post_type' => 'charakts',
                    'order' => 'ASC',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'charakts_cat',
                            'field' => 'id',
                            'terms' => $category
                        )
                    )
                ];

                $query = new WP_Query($args);
                $count = 1;

                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();

                        $files = get_field('add_files');

                        ?>
                        <div class="post_item">
                            <h4 class="product_list_title text_red h3"><?php the_title(); ?></h4>
                            <div class="product_chars">
                                <?php
                                $uls = array_chunk($files, 4);

                                foreach ($uls as $ul) :

                                    ?>
                                    <div class="product_chars_wrap">
                                        <?php foreach ($ul as $file) : ?>
                                            <div class="product_chars_wrap_item">
                                                <a href="<?php echo $file['pdf_link']; ?>" download><span><i
                                                                class="fal fa-long-arrow-down"></i></span>
                                                    <?php echo $file['pdf_name']; ?></a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php
                            $count = count($files);
                            if ($count > 20) :
                                ?>
                                <div class="post_more">
                                    <a class="post_more_btn"
                                       href="javascript:;"><?php esc_html_e('pokaż więcej', 'button'); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; endif;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
