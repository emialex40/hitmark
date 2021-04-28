<!DOCTYPE HTML>
<html>
<head <?php language_attributes(); ?>>
    <title><?php wp_title(''); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/wp-content/themes/hitmark-theme/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;700&display=swap">

    <?php
    wp_head();
    $favicon = get_option('theme_favicon');
    $logo = get_field('header_logo', 'option');
    ?>
    <meta name='apple-itunes-app' content='app-id=​myAppStoreID​'>
    <link rel="icon" href="<?php print $favicon; ?>" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php print $favicon; ?>" type="image/x-icon"/>

    <?php if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false) : ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" />
    <?php endif; ?>
</head>
<body <?php body_class(); ?>>
<script>
</script>
<div id="root">
    <div class="app">
        <div class="app_main">
            <header id="header" class="header<?php echo is_front_page() ? ' bg_white' : ''; ?>">
                <div class="container container_header">
                    <div class="row header_block">
                        <div class="col-md-3 col-3 header_logo">
                            <div class="logo">
                                    <?php if (!is_front_page()) {
                                        echo '<a href="' . get_home_url() . '">';
                                    } ?>
                                <object type="image/svg+xml" data="<?php echo $logo; ?>">
                                    <img src="<?php echo $logo; ?>" alt="Logo">
                                </object>
                                    <?php if (!is_front_page()) echo '</a>'; ?>
                            </div>
                        </div>
                        <nav class="header_menu">
                            <?php
                            if (has_nav_menu('header_menu')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'header_menu',
                                    'menu_class' => 'header_menu_links',
                                    'container' => '',
                                    'container_class' => '',
                                    'menu_id' => 'header_menu_links',
                                    'depth' => 1,
                                    'walker' => new Main_Submenu_Class()));
                            }

                            $menu = wp_get_nav_menu_items('Header Menu', array());
                            $children1 = true_get_nav_menu_children_items(15, $menu, 0);
                            $children2 = true_get_nav_menu_children_items(19, $menu, 0);

                            ?>
                            
                            <div class="header_menu_sub">
                                <ul class="header_menu_sub_list">
                                   <?php foreach ($children1 as $child1) : ?>
                                        <li class="header_menu_sub_item">
                                            <div class="item">
                                                <a href="<?php echo $child1->url ?>"><?php echo $child1->title; ?></a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <ul class="header_menu_sub_list header_menu_sub_right">
                                    <?php foreach ($children2 as $child2) : ?>
                                        <li class="header_menu_sub_item">
                                            <div class="item">
                                                <a href="<?php echo $child2->url ?>"><?php echo $child2->title; ?></a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        </nav>
                        <div class="col-2 offset-7 mob_menu header_mob_menu">
                            <button id="hamburger_header" class="hamburger hamburger--collapse" type="button"><span
                                        class="hamburger-box"><span class="hamburger-inner"></span></span></button>
                        </div>
                    </div>
                </div>
            </header>
            <main>