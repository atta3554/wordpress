<?php
require_once get_template_directory() . '/inc/search_route.php';
require_once get_template_directory() . '/inc/Likes_route.php';
require_once get_template_directory() . '/inc/custom-login.php';


function pageBanner($title = '', $subtitle = '', $photo = '') {
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
        $subtitle = get_field('page_banner_description', $queriedObjectId);
    }

    if(!$photo && $queriedObjectId && !is_home() && !is_archive()) {
        $bannerBackground = get_field('page_banner_background', $queriedObjectId);

        if($bannerBackground && isset($bannerBackground['sizes']['testSize'])) {
            $photo = $bannerBackground['sizes']['testSize'];
        }
    }

?>

    <!-- Hero Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="banner-section px-0" <?php if($photo) : ?> style="background-image: url('<?php echo esc_url($photo); ?>');" <?php endif; ?>>
                <div class="cover w-100 h-100 px-5 d-flex flex-column justify-content-center">
                    <h1 class="hero-title text-white">welcome to <?php echo esc_html($title); ?></h1>
                    <p class="hero-description text-white"><?php echo esc_html($subtitle); ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section -->

<?php 
}




/************************************* Send Author name for posts ***********************************************/
function ataCustomApi() {
    register_rest_field('post', 'postAuthor', array(
        'get_callback'=> function() {return get_the_author();}
    ));
}

add_action('rest_api_init', 'ataCustomApi');




// make thumbnails and titles and logo dynamic and add new image size
function ataDynamics() {
    
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_image_size('testSize', 1500, 400, true);
}

add_action('after_setup_theme' , 'ataDynamics');




// Test new Role 
function addNewRole() {
    if(!wp_roles()->is_role('teacher')) {
        add_role('teacher', 'teacher', array('read'=> true));
    }
}

add_action('after_setup_theme', 'addNewRole');




// redirect admin
function redirectAdmin( $redirect_to, $request, $user ) {
    global $user;
    if(isset($user->roles) AND is_array($user->roles)) {
        if(in_array('administrator', $user->roles)) {
            return site_url();
        } else {
            return $redirect_to;
        }
    }
}

add_filter('login_redirect', 'redirectAdmin', 10, 3);






// Register nav menus
function ataMenus() {
    
    $menu = array(
        'Primary Menu'=>'header menu',
        'Secondary Menu'=>'footer menu'
    );

    register_nav_menus($menu);

}

add_action('init' , 'ataMenus');

function ataPrimaryMenuFallback($args) {
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
function ataStyles() {
    wp_enqueue_style('atafontawesome',get_template_directory_uri().'/assets/fontawesome-css/fontawesome.min.css');
    wp_enqueue_style('atafontawesomebrand',get_template_directory_uri().'/assets/fontawesome-css/brands.min.css');
    wp_enqueue_style('atafontawesomesolid',get_template_directory_uri().'/assets/fontawesome-css/solid.min.css');
    wp_enqueue_style('atafontawesomeregular',get_template_directory_uri().'/assets/fontawesome-css/regular.min.css');
    wp_enqueue_style('ataCustomizedBootstrap',get_template_directory_uri().'/build/index.css');
    wp_enqueue_style('mainStyles',get_template_directory_uri().'/style.css');
    wp_enqueue_script('mainScripts', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);

    wp_localize_script('mainScripts', 'themeData', array(
        'root_url'=> get_site_url(),
        'nonce'=> wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts' , 'ataStyles');




//show just correct events that doesnt pasts on events archive page
function showCorrectEvents($query) {
    
    $today = date('Ymd');
    if(!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
    $query->set('meta_key', 'event_date');
    $query->set('meta_type', 'DATE');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array('key'=> 'event_date', 'compare'=> '>=', 'value'=>$today));
    }
}

add_action('pre_get_posts' , 'showCorrectEvents');




//remove label before archive titles on archive pages
function my_theme_archive_title( $title ) {
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

add_filter( 'get_the_archive_title', 'my_theme_archive_title' );




//redirect user to front-end after login
function redirectUser() {
    $currentUser = wp_get_current_user();

    if(count($currentUser->roles) === 1 AND $currentUser->roles[0]=== 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

add_action('admin_init', 'redirectUser');




//disable Admin bar for subscriber
function hideAdminBar() {
    $currentUser = wp_get_current_user();

    if(count($currentUser->roles)=== 1 AND $currentUser->roles[0]=== 'subscriber')
    show_admin_bar(false);
}

add_action('wp_loaded', 'hideAdminBar');




//customize Logo URL of Login page
function CustomizeLogin() {
    return esc_url(site_url('/'));
}

add_filter('login_headerurl', 'CustomizeLogin');




//Customize Login page
function CustomizeloginPage() {
    wp_enqueue_style('mainStyles',get_template_directory_uri().'/style.css');
}

add_action('login_enqueue_scripts', 'CustomizeloginPage');




//Customize Login page title
function CustomizeLoginTitle() {
    return get_bloginfo('name');
}

add_filter('login_headertitle', 'CustomizeLoginTitle');




// put Limits for notes and set Notes status to private and secure notes
function enforceNoteLimit($prepared_post, $request) {
    if(empty($prepared_post->ID) && count_user_posts(get_current_user_id(), 'note') >= 5) {
        return new WP_Error('note_limit_reached', 'limit note count! delete some notes first', array('status'=> 400));
    }

    return $prepared_post;
}

add_filter('rest_pre_insert_note', 'enforceNoteLimit', 10, 2);

function noteSettings($data, $postarr) {

    $PostId= $postarr['ID'];
    if($data['post_type']=== 'note') {
        $data['post_content']= sanitize_textarea_field($data['post_content']);
        $data['post_title']= sanitize_text_field($data['post_title']);
    }
    if($data['post_type']=== 'note' AND $data['post_status'] !== 'trash') {
        $data['post_status']= 'private';
    }
    
    return $data;
}

add_filter('wp_insert_post_data', 'noteSettings', 10, 2);




/***************************************** test ****************************************
 function login_redirect( $redirect_to, $request, $user ) {

    if ( is_a ( $user , 'WP_User' ) && $user->exists() ) {

        if ( $user->roles[0] === 'administrator ' ) {

            $redirect_to = site_url('/blog');

        }

    }

    return $redirect_to;
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );




function WebP_upload_mimes( $existing_mimes ) { 
	$existing_mimes['WebP'] = 'image/WebP';
	return $existing_mimes;
}

add_filter( 'mime_types', 'WebP_upload_mimes' ); */
