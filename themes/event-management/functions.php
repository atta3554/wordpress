<?php
/**
 * Theme bootstrap and WordPress hooks.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/template-helpers.php';
require_once get_template_directory() . '/inc/theme-settings.php';
require_once get_template_directory() . '/inc/page-setup.php';
require_once get_template_directory() . '/inc/navigation-setup.php';
require_once get_template_directory() . '/inc/theme-activation.php';
require_once get_template_directory() . '/inc/search_route.php';
require_once get_template_directory() . '/inc/Likes_route.php';
require_once get_template_directory() . '/inc/custom-login.php';

function em_theme_page_banner($title = '', $subtitle = '', $photo = '') {
    $queriedObjectId = get_queried_object_id();

    if(!$title) {
        if(is_front_page()) {
            $title = get_bloginfo('name');
        } elseif(is_home()) {
            $title = single_post_title('', false);
        } elseif(is_archive()) {
            $title = get_the_archive_title();
        } elseif($queriedObjectId) {
            $title = get_the_title($queriedObjectId);
        }
    }

    if(!$subtitle && $queriedObjectId) {
        $subtitle = em_theme_get_field('page_banner_description', $queriedObjectId);
    }

    if(!$photo && $queriedObjectId && !is_home() && !is_archive()) {
        $bannerBackground = em_theme_get_field('page_banner_background', $queriedObjectId);

        if(is_array($bannerBackground) && isset($bannerBackground['sizes']['page_banner_size'])) {
            $photo = $bannerBackground['sizes']['page_banner_size'];
        } elseif(is_numeric($bannerBackground)) {
            $photo = wp_get_attachment_image_url((int) $bannerBackground, 'page_banner_size');
        } elseif(is_string($bannerBackground)) {
            $photo = $bannerBackground;
        }
    }

    if(!$photo && is_archive()) {
        $photo = em_theme_get_archive_banner_image_url();
    }

    $title = $title ? $title : get_bloginfo('name');

?>

    <!-- Hero Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="banner-section px-0" <?php if($photo) : ?> style="background-image: url('<?php echo esc_url($photo); ?>');" <?php endif; ?>>
                <div class="cover w-100 h-100 px-5 d-flex flex-column justify-content-center">
                    <h1 class="hero-title text-white"><?php echo esc_html($title); ?></h1>
                    <?php if($subtitle) : ?>
                        <p class="hero-description text-white"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section -->

<?php 
}




/* Logo render */
function em_theme_render_logo() {
  $relative_path = '/assets/images/logo-main.png';
  if (has_custom_logo()) {
      the_custom_logo();
  } else if(file_exists(get_theme_file_path( $relative_path ))) {
      echo '<img src="' . esc_url(get_theme_file_uri($relative_path)) . '" alt="' . esc_attr(get_bloginfo('name')) . '">';
  } else {
      echo '<span class="site-logo__text">' . esc_html(get_bloginfo('name')) . '</span>';
  }
}



/************************************* Send Author name for posts ***********************************************/
function em_theme_register_rest_fields() {
    register_rest_field('post', 'postAuthor', array(
        'get_callback'=> function() {return get_the_author();}
    ));
}

add_action('rest_api_init', 'em_theme_register_rest_fields');




// make thumbnails and titles and logo dynamic and add new image size
function em_theme_setup() {
    load_theme_textdomain('event-management-theme', get_template_directory() . '/languages');

    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_image_size('page_banner_size', 1500, 400, true);
}

add_action('after_setup_theme' , 'em_theme_setup');




// redirect admin
function em_theme_login_redirect( $redirect_to, $request, $user ) {
    if(is_wp_error($user) || !($user instanceof WP_User)) {
        return $redirect_to ? $redirect_to : home_url('/');
    }

    if(in_array('administrator', (array) $user->roles, true)) {
        return $redirect_to ? $redirect_to : admin_url();
    }

    return home_url('/');
}

add_filter('login_redirect', 'em_theme_login_redirect', 10, 3);






// Register nav menus
function em_theme_register_menus() {
    
    $menu = array(
        'primary'=>'Primary Menu',
        'footer'=>'Footer Menu',
        'Primary Menu'=>'header menu',
        'Secondary Menu'=>'footer menu'
    );

    register_nav_menus($menu);

}

add_action('init' , 'em_theme_register_menus');

function em_theme_primary_menu_fallback($args) {
    $menuClass = isset($args['menu_class']) ? $args['menu_class'] : '';
    $items = array(
        array(
            'title'=> 'Home',
            'url'=> home_url('/'),
            'active'=> is_front_page(),
        ),
        array(
            'title'=> 'Professors',
            'url'=> get_post_type_archive_link('professor'),
            'active'=> is_post_type_archive('professor') || is_singular('professor'),
        ),
        array(
            'title'=> 'Events',
            'url'=> get_post_type_archive_link('event'),
            'active'=> is_post_type_archive('event') || is_singular('event'),
        ),
        array(
            'title'=> 'Seminars',
            'url'=> get_post_type_archive_link('seminar'),
            'active'=> is_post_type_archive('seminar') || is_singular('seminar'),
        ),
    );

    echo '<ul class="' . esc_attr($menuClass) . '">';

    foreach($items as $item) {
        if(!$item['url']) {
            continue;
        }

        $itemClasses = 'menu-item';

        if($item['active']) {
            $itemClasses .= ' current-menu-item';
        }

        echo '<li class="' . esc_attr($itemClasses) . '"><a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a></li>';
    }

    echo '</ul>';
}




// register styles and scripts and prepare incumbent Datas for Front-End
function em_theme_enqueue_assets() {
    $asset_file = get_theme_file_path('/build/index.asset.php');
    $asset      = file_exists($asset_file) ? include $asset_file : array('dependencies' => array(), 'version' => em_theme_asset_version('/build/index.js'));

    wp_enqueue_style('atafontawesome', get_template_directory_uri() . '/assets/fontawesome-css/fontawesome.min.css', array(), em_theme_asset_version('/assets/fontawesome-css/fontawesome.min.css'));
    wp_enqueue_style('atafontawesomebrand', get_template_directory_uri() . '/assets/fontawesome-css/brands.min.css', array('atafontawesome'), em_theme_asset_version('/assets/fontawesome-css/brands.min.css'));
    wp_enqueue_style('atafontawesomesolid', get_template_directory_uri() . '/assets/fontawesome-css/solid.min.css', array('atafontawesome'), em_theme_asset_version('/assets/fontawesome-css/solid.min.css'));
    wp_enqueue_style('atafontawesomeregular', get_template_directory_uri() . '/assets/fontawesome-css/regular.min.css', array('atafontawesome'), em_theme_asset_version('/assets/fontawesome-css/regular.min.css'));
    wp_enqueue_style('ataCustomizedBootstrap', get_template_directory_uri() . '/build/index.css', array(), em_theme_asset_version('/build/index.css'));
    wp_enqueue_style('mainStyles', get_stylesheet_uri(), array('ataCustomizedBootstrap'), em_theme_asset_version('/style.css'));
    wp_enqueue_script('mainScripts', get_theme_file_uri('/build/index.js'), isset($asset['dependencies']) ? $asset['dependencies'] : array(), isset($asset['version']) ? $asset['version'] : em_theme_asset_version('/build/index.js'), true);

    wp_localize_script('mainScripts', 'themeData', array(
        'root_url'=> esc_url_raw(home_url()),
        'nonce'=> wp_create_nonce('wp_rest'),
        'is_logged_in'=> is_user_logged_in(),
    ));

    if(is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts' , 'em_theme_enqueue_assets');




//show just correct events that doesnt pasts on events archive page
function em_theme_filter_upcoming_events_archive($query) {
    
    $today = current_time('Ymd');
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key'=> 'event_date',
                'compare'=> '>=',
                'value'=>$today,
                'type'=> 'NUMERIC',
            ),
        ));
    }
}

add_action('pre_get_posts' , 'em_theme_filter_upcoming_events_archive');




//remove label before archive titles on archive pages
function em_theme_archive_title( $title ) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );
	}
 
	return $title;
}

add_filter( 'get_the_archive_title', 'em_theme_archive_title' );




//redirect user to front-end after login
function em_theme_redirect_subscribers_from_admin() {
    $currentUser = wp_get_current_user();

    if(!wp_doing_ajax() && count($currentUser->roles) === 1 AND $currentUser->roles[0]=== 'subscriber') {
        wp_safe_redirect(home_url('/'));
        exit;
    }
}

add_action('admin_init', 'em_theme_redirect_subscribers_from_admin');




//disable Admin bar for subscriber
function em_theme_hide_subscriber_admin_bar() {
    $currentUser = wp_get_current_user();

    if($currentUser instanceof WP_User && count($currentUser->roles)=== 1 AND $currentUser->roles[0]=== 'subscriber') {
    show_admin_bar(false);
    }
}

add_action('wp_loaded', 'em_theme_hide_subscriber_admin_bar');




//customize Logo URL of Login page
function em_theme_login_header_url() {
    return esc_url(home_url('/'));
}

add_filter('login_headerurl', 'em_theme_login_header_url');




//Customize Login page
function em_theme_enqueue_login_styles() {
    wp_enqueue_style('mainStyles', get_stylesheet_uri(), array(), em_theme_asset_version('/style.css'));
}

add_action('login_enqueue_scripts', 'em_theme_enqueue_login_styles');




//Customize Login page title
function em_theme_login_header_text() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'em_theme_login_header_text');
add_filter('login_headertext', 'em_theme_login_header_text');




// put Limits for notes and set Notes status to private and secure notes
function em_theme_enforce_note_limit($prepared_post, $request) {
    if(!is_user_logged_in()) {
        return new WP_Error('rest_forbidden', __('You must be logged in to manage notes.', 'event-management-theme'), array('status'=> 401));
    }

    $note_id = !empty($prepared_post->ID) ? absint($prepared_post->ID) : absint($request['id']);

    if($note_id && (int) get_post_field('post_author', $note_id) !== get_current_user_id()) {
        return new WP_Error('forbidden_note_update', __('You can only update your own notes.', 'event-management-theme'), array('status'=> 403));
    }

    if(!$note_id && count_user_posts(get_current_user_id(), 'note') >= 5) {
        return new WP_Error('note_limit_reached', __('Your note limit has been reached. Delete a note before creating another.', 'event-management-theme'), array('status'=> 400));
    }

    $prepared_post->post_author = get_current_user_id();
    $prepared_post->post_status = 'private';

    return $prepared_post;
}

add_filter('rest_pre_insert_note', 'em_theme_enforce_note_limit', 10, 2);

function em_theme_secure_note_data($data, $postarr) {

    if(isset($data['post_type']) && $data['post_type']=== 'note') {
        $data['post_content']= isset($data['post_content']) ? sanitize_textarea_field($data['post_content']) : '';
        $data['post_title']= isset($data['post_title']) ? sanitize_text_field($data['post_title']) : '';
    }
    if(isset($data['post_type'], $data['post_status']) && $data['post_type']=== 'note' AND $data['post_status'] !== 'trash') {
        $data['post_status']= 'private';
    }
    
    return $data;
}

add_filter('wp_insert_post_data', 'em_theme_secure_note_data', 10, 2);

add_filter('private_title_format', function($format) {
    return '%s';
});
