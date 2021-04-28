<?php
$footer_logo = get_field('footer_logo', 'option');
$footer_phone = get_field('phone', 'option');
$footer_email = get_field('email', 'option');
$menu = wp_get_nav_menu_items('Header Menu', array());
$children1 = true_get_nav_menu_children_items(15, $menu, 0);
$children2 = true_get_nav_menu_children_items(19, $menu, 0);
?>

</main>
</div>
</div>
</div>

<footer id="footer" class="footer bg_dark">
    <div class="container container_big">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-6 footer_left">
                <div class="footer_logo">
                    <div class="logo">
                        <?php if (!is_front_page()) {
                            echo '<a href="' . get_home_url() . '">';
                        } ?>
                        <object type="image/svg+xml" data="<?php echo $footer_logo; ?>">
                            <img src="<?php echo $footer_logo; ?>" alt="Logo">
                        </object>
                        <?php if (!is_front_page()) echo '</a>'; ?>
                    </div>
                </div>

                <div class="footer_info">
                    <a class="footer_phone"
                       href="tel:<?php echo phone_format($footer_phone); ?>"><?php echo $footer_phone; ?></a>
                    <a href="mailto:<?php echo $footer_email; ?>" class="footer_mail"><?php echo $footer_email; ?></a>
                    <div class="footer_address"><?php the_field('address', 'option'); ?></div>
                </div>
            </div>
            <nav class="col-lg-8 col-md-12 col-6 footer_menu">
                <div>
                    <?php
                    if (has_nav_menu('header_menu')) {
                        wp_nav_menu(array(
                            'theme_location' => 'header_menu',
                            'menu_class' => 'footer_menu_links',
                            'container' => '',
                            'container_class' => '',
                            'menu_id' => 'footer_menu_links',
                            'depth' => 1,
                            'walker' => new Main_Submenu_Class()));
                    }
                    ?>

                    <div class="footer_menu_sub">
                        <ul class="footer_menu_sub_list">
                            <?php foreach ($children1 as $child1) : ?>
                                <li class="footer_menu_sub_item">
                                    <div class="item">
                                        <a href="<?php echo $child1->url ?>"><?php echo $child1->title; ?></a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <ul class="footer_menu_sub_list footer_menu_sub_right">
                            <?php foreach ($children2 as $child2) : ?>
                                <li class="footer_menu_sub_item">
                                    <div class="item">
                                        <a href="<?php echo $child2->url ?>"><?php echo $child2->title; ?></a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="footer_menu_mobile">
                      <?php  if (has_nav_menu('header_menu')) {
                        wp_nav_menu(array(
                        'theme_location' => 'header_menu',
                        'menu_class' => 'footer_menu_links_mob',
                        'container' => '',
                        'container_class' => '',
                        'menu_id' => 'footer_menu_links_mob',
                        'depth' => 0,
                        'walker' => new Main_Submenu_Class()));
                        } ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</footer>

<div id="mobile_menu" class="mobile_menu ">
    <a href="javascript:;" class="menu_close"><i class="fal fa-times"></i></a>
    <nav class="mob_menu">
    <?php  if (has_nav_menu('header_menu')) {
        wp_nav_menu(array(
            'theme_location' => 'header_menu',
            'menu_class' => 'mob_menu_links_mob',
            'container' => '',
            'container_class' => '',
            'menu_id' => 'mob_menu_links_mob',
            'depth' => 0,
            'walker' => new Main_Submenu_Class()));
    } ?>
    </nav>
</div>
<div class="bg "></div>
<script>
    var ajax_web_url = '<?php echo admin_url('admin-ajax.php', 'relative') ?>';
</script>


<?php wp_footer(); ?>
</body>
</html>