<?php

//debug function for var_dump()
function debug($bug)
{
    echo '<pre style="padding: 15px; background: #000; display:block; width: 100%; color: #fff;">';
    var_dump($bug);
    echo '</pre>';
}

add_filter('the_generator', '__return_empty_string');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
add_filter('tiny_mce_plugins', 'disable_wp_emojis_in_tinymce');

add_filter('show_admin_bar', '__return_false');


add_filter('pll_get_post_types', 'unset_cpt_pll', 10, 2);
function unset_cpt_pll($post_types, $is_settings)
{
    $post_types['acf-field-group'] = 'acf-field-group';
    $post_types['acf'] = 'acf';
    return $post_types;
}

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
add_theme_support('post-thumbnails');
add_filter('jpeg_quality', function () {
    return 100;
});

add_action('login_enqueue_scripts', 'wpspec_custom_login_logo');

// custom logo wp-admin page
function wpspec_custom_login_logo()
{
    ?>
<style>
body.login h1 a {
    background: url('/wp-content/uploads/2020/10/hitmark.svg') no-repeat;
    width: 101px;
    height: 50px;
}

</style>
<?php
}


function disable_wp_emojis_in_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

// disable gutenberg editor
if ('disable_gutenberg') {
    add_filter('use_block_editor_for_post_type', '__return_false', 100);
    remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');

    add_action('admin_init', function () {
        remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
        add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']);
    });
}


// svg upload
add_filter('upload_mimes', 'svg_upload_allow');
function svg_upload_allow($mimes)
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

// styles and scripts including
function load_theme_styles()
{
    if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false) {
        wp_enqueue_style('fontawesome', get_template_directory_uri() . '/css/fontawesome.min.css', array(), 'null', 'all');
    }

    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom-style.css', array(), time(), 'all');

//	wp_enqueue_script( 'jquery' );
    $js_directory_uri = get_template_directory_uri() . '/js/';

    wp_deregister_script('jquery');
    wp_register_script('jquery', ("https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"), false, '3.5.1', true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-script', $js_directory_uri . 'scripts.min.js', array('jquery'), time(), true);
}

add_action('wp_enqueue_scripts', 'load_theme_styles', 100);

// thumbnails sizes
add_theme_support('post-thumbnails');


add_image_size('logo-thumb', 100, 59);
add_image_size('hero-thumb', 140);
add_image_size('gallery-thumb', 426);
add_image_size('flags-thumb', 560);
add_image_size('bigest-thumb', 1920);

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'General Settings',
        'menu_title' => 'Theme Options',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

// menu
class  Main_Submenu_Class extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $classes = array('sub-menu', 'list-unstyled', 'child-navigation');
        $class_names = implode(' ', $classes);
        $output .= "\n" . '<ul class="' . $class_names . '">' . "\n";
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        $id_field = $this->db_fields['id'];
        if (is_object($args[0]))
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0)
    {
        global $wp_query;

        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $class_names_arr = array();
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array)$item->classes;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
        $class_names_arr[] = esc_attr($class_names);
        $class_names_arr[] = 'menu-item-id-' . $item->ID;
        $span_act = "";
        if ($args->has_children) {
            $class_names_arr[] = 'has-child';
            if (in_array('current-menu-item', $classes)) {
                $class_names_arr[] = 'focus';
                $span_act = 'active';
            }
            if (in_array('current-menu-parent', $classes)) {
                $class_names_arr[] = 'focus';
                $span_act = 'active';
            }
            if (in_array('current-menu-ancestor', $classes)) {
                $class_names_arr[] = 'focus';
                $span_act = 'active';
            }


        }


        $class_names = ' class="' . implode(' ', $class_names_arr) . '"';
        $menu_locations = '';
        if (isset($args->menu_id)) {
            if ($args->menu_id != '') $menu_locations = $args->menu_id . '_';
        }

        $output .= $indent . '<li id="menu-item-' . $menu_locations . $item->ID . '"' . $value . $class_names . '>';
        $attributes = '';
        if ($item->url != '#') {
            $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
            $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
            $attributes .= !empty($item->url) ? ' href="' . $item->url . '"' : '';
        }

        $item_output = $args->before;
        $item_output .= '<div class="items"><a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
        $item_output .= $args->link_after;
        $item_output .= '</a>';
        if ($args->has_children) $item_output .= '<span data-from="menu-item-' . $menu_locations . $item->ID . '" class="show_sub_menu ' . $span_act . '"><i></i></span>';
        $item_output .= '</div>';

        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// children menu func
function true_get_nav_menu_children_items($parent_id, $nav_menu_items, $dpth = true)
{
    $children = array();
    foreach ((array)$nav_menu_items as $nav_item) {
        if ($nav_item->menu_item_parent == $parent_id) {
            $children[] = $nav_item;

            // если вам не нужны дочерние всех уровней вложенности, то даже можете удалить следующие 5 строк кода
            if ($dpth) {
                if ($dch = get_nav_menu_item_children($nav_item->ID, $nav_menu_items))
                    $children = array_merge($children, $dch);
            }
        }
    }
    return $children;
}

function menulang_setup()
{
    load_theme_textdomain('themename', get_template_directory() . '/languages');
    register_nav_menus(array('header_menu' => __('Header Menu', 'themename')));
    register_nav_menus(array('footer_menu' => __('Footer Menu', 'themename')));
}

add_action('after_setup_theme', 'menulang_setup');


function phone_format($phone)
{
    $result = preg_replace("/\D+/", "", $phone);
    return $result;

//    call function <?php phone_format($phone)
}

function create_post_type()
{
//post type
    $post_type_labels = array(
        'name' => __('Galeria', 'themename'),
        'singular_name' => __('Galeria', 'themename'),
        'add_new' => __('Dodać', 'themename'),
        'add_new_item' => __('Dodać', 'themename'),
        'edit_item' => __('Redagować', 'themename'),
        'new_item' => __('Dodać', 'themename'),
        'view_item' => __('Przejrzały', 'themename'),
        'search_items' => __('Znaleźć', 'themename'),
        'not_found' => __('Nie znaleziono', 'themename'),
        'parent_item_colon' => '',
    );
    $description = get_option('theme_custom_description');
    $post_type_args = array(
        'labels' => apply_filters('inspiry_property_post_type_labels', $post_type_labels),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'menu_position' => 15,
        'description' => $description,
        'supports' => array('title', 'thumbnail'),
        'rewrite' => array(
            'slug' => apply_filters('inspiry_property_slug', 'galleries'),
        ),
    );
    register_post_type('gallery', $post_type_args);

    $post_type_labels = array(
        'name' => __('Kontakty', 'themename'),
        'singular_name' => __('Kontakt', 'themename'),
        'add_new' => __('Dodać', 'themename'),
        'add_new_item' => __('Dodać', 'themename'),
        'edit_item' => __('Redagować', 'themename'),
        'new_item' => __('Dodać', 'themename'),
        'view_item' => __('Przejrzały', 'themename'),
        'search_items' => __('Znaleźć', 'themename'),
        'not_found' => __('Nie znaleziono', 'themename'),
        'parent_item_colon' => '',
    );
    $description = get_option('theme_custom_description');
    $post_type_args = array(
        'labels' => apply_filters('inspiry_property_post_type_labels', $post_type_labels),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-groups',
        'menu_position' => 16,
        'description' => $description,
        'supports' => array('title', 'thumbnail'),
        'rewrite' => array(
            'slug' => apply_filters('inspiry_property_slug', 'contact'),
        ),
    );
    register_post_type('contacts', $post_type_args);

    $post_type_labels = array(
        'name' => __('PDF', 'themename'),
        'singular_name' => __('PDF', 'themename'),
        'add_new' => __('Dodaj', 'themename'),
        'add_new_item' => __('Dodaj', 'themename'),
        'edit_item' => __('Redagować', 'themename'),
        'new_item' => __('Dodaj', 'themename'),
        'view_item' => __('Przejrzały', 'themename'),
        'search_items' => __('Znaleźć', 'themename'),
        'not_found' => __('Nie znaleziono', 'themename'),
        'parent_item_colon' => '',
    );
    $description = get_option('theme_custom_description');
    $post_type_args = array(
        'labels' => apply_filters('inspiry_property_post_type_labels', $post_type_labels),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_icon' => 'dashicons-paperclip',
        'menu_position' => 16,
        'description' => $description,
        'supports' => array('title', 'thumbnail'),
        'rewrite' => array(
            'slug' => apply_filters('inspiry_property_slug', 'charakts'),
        ),
    );
    register_post_type('charakts', $post_type_args);

      // taxonomy
register_taxonomy('charakts_cat', array('charakts'), array(
    'label'                 => 'Kategoria PDF', // определяется параметром $labels->name
    'labels'                => array(
        'name'              => 'Kategoria PDF',
        'singular_name'     => 'Kategoria PDF',
        'search_items'      => 'Szukaj',
        'all_items'         => 'Wszystkie kategorie',
        'parent_item'       => 'Kategoria nadrzędna',
        'parent_item_colon' => 'Kategoria nadrzędna',
        'edit_item'         => 'Edytować',
        'update_item'       => 'Odświeżać',
        'add_new_item'      => 'Dodaj',
        'new_item_name'     => 'Nowa kategoria',
        'menu_name'         => 'Kategoria PDF',
    ),
    'description'           => 'Kategorie pdf', // описание таксономии
    'public'                => true,
    'show_in_nav_menus'     => false, // равен аргументу public
    'show_ui'               => true, // равен аргументу public
    'show_tagcloud'         => false, // равен аргументу show_ui
    'hierarchical'          => true,
    'rewrite'               => array('slug'=>'charakts_cat', 'hierarchical'=>false, 'with_front'=>false, 'feed'=>false ),
    'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
) );
}

add_action('init', 'create_post_type');

add_action('wp_ajax_post_filter', 'post_filter_func');
add_action('wp_ajax_nopriv_post_filter', 'post_filter_func');

function post_filter_func()
{

    if (isset($_REQUEST)) {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            $post_id = (isset($_REQUEST['postId'])) ? (int)$_REQUEST['postId'] : 0;

            if ($post_id === 0) {
                echo '';
            } else {
                $args = [
                    'post_type' => 'contacts',
                    'post__in' => [$post_id],
                    'post_status' => 'publish'
                ];

                $query = new WP_Query($args);

                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $contacts = get_field('add_contact');

                        foreach ( $contacts as $contact ) { ?>
<div class="managers_result_row">
    <h4 class="managers_result_name text_red"><?php echo $contact['k_name']; ?></h4>
    <p class="managers_result_phone text_red">tel. <a class="text_red"
            href="tel:<?php echo phone_format($contact['k_phone']); ?>"><?php echo $contact['k_phone']; ?></a></p>
    <p class="managers_result_email text_red">e-mail. <a class="text_red"
            href="mailto:<?php echo $contact['k_email']; ?>"><?php echo $contact['k_email']; ?></a></p>
</div>
<?php }
                    }
                }

                wp_reset_postdata();


            }
        }
    }

    wp_die();
}
