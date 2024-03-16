<?php
// require_once get_template_directory_uri() . '/inc/search_route.php';
// require_once get_template_directory_uri() . '/inc/likes_route.php';

/******************************************* likes-route *****************************************/

add_action('rest_api_init', 'registerLikeRoute');

function registerLikeRoute() {
    register_rest_route('ataRoute/v1', 'like', array(
        'methods'=> 'POST',
        'callback'=> 'likeProfessor'
    ));

    register_rest_route('ataRoute/v1', 'like', array(
        'methods'=> 'DELETE',
        'callback'=> 'disLikeProfessor'
    ));
}


function likeProfessor($data) {

    $currentProfessorId= sanitize_text_field($data['professorId']);

    $currentUserLike = new WP_Query(array(
        'post_type'=> 'like',
        'author'=> get_current_user_id(),
        'meta_query'=> array(
            array(
             'key'=> 'professor_like_id',
             'compare'=> '=',
             'value'=> $currentProfessorId
            )
        )
    ));

    if($currentUserLike->found_posts == 0 AND get_post_type($currentProfessorId) === 'professor') {
        if(is_user_logged_in()){
            return wp_insert_post(array(
                'post_type'=> 'like',
                'post_status'=> 'publish',
                'title'=> 'created with php',
                'author'=> get_current_user_id(),
                'meta_input'=> array(
                    'professor_like_id'=> $currentProfessorId
                )
            ));
        } else {
            die(json_encode('only logged in users can like professors'));
        }
    } else {
        if(!is_user_logged_in() AND get_post_type($currentProfessorId) === 'professor') {
            die(json_encode('only logged in users can like professors'));
        } else {
            die(json_encode('invalid professor id'));
        }
    }
}

function disLikeProfessor($data) {
    $currentLike= sanitize_text_field($data['like']);

    if(get_current_user_id() == get_post_field('post_author', $currentLike) AND get_post_type($currentLike) == 'like') {
        wp_delete_post($currentLike, true);
        return 'like deleted successfully';
    } else {
        die(json_encode("you don't have permission to delete this post"));
    }
}

/******************************************* likes-route *****************************************/









/******************************************* search-route *****************************************/

// Prepare Datas for new API route
function getSearchResults($data) {

    $allResults= array(
        'pages'=> array(),
        'posts'=> array(),
        'events'=> array(),
        'professors'=> array(),
        'seminars'=> array(),
    );


    $mainQuery= new WP_QUERY(array(
        'post_type'=> array('page', 'post', 'professor', 'event', 'seminar'),
        's'=> $data['keyword']
    ));

    while($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if(get_post_type()== 'page')
        array_push($allResults['pages'], array(
            'title'=> get_the_title(),
            'URL'=> get_the_permalink(),
            'excerpt'=> get_the_excerpt()
        ));

        if(get_post_type()== 'post')
        array_push($allResults['posts'], array(
            'title'=> get_the_title(),
            'URL'=> get_the_permalink(),
            'thumbnail'=> get_the_post_thumbnail_url(0, 'medium'),
            'excerpt'=> get_the_excerpt(),
            'author'=> get_the_author_posts_link()
        ));

        if(get_post_type()== 'event')
        array_push($allResults['events'], array(
            'title'=> get_the_title(),
            'URL'=> get_the_permalink(),
            'excerpt'=> get_the_excerpt(),
            'date'=> get_field('event_date')
        ));

        if(get_post_type()== 'professor')
        array_push($allResults['professors'], array(
            'title'=> get_the_title(),
            'URL'=> get_the_permalink(),
            'thumbnail'=> get_the_post_thumbnail_url(0, 'medium'),
            'excerpt'=> get_the_excerpt(),
            'id'=> get_the_id(0)
        ));

        if(get_post_type()== 'seminar')
        array_push($allResults['seminars'], array(
            'title'=> get_the_title(),
            'URL'=> get_the_permalink(),
            'excerpt'=> get_the_excerpt(),
            'thumbnail'=> get_the_post_thumbnail_url(0, 'medium'),
        ));
    }



    // show related Seminars for searched professor
    if($allResults['professors']) {

        $professorRelatedSeminarsQuery= array('relation'=> 'OR') ;
        foreach($allResults['professors'] as $item) {
            array_push($professorRelatedSeminarsQuery, array(
                'key'=> 'seminar_professor',
                'compare'=> "LIKE",
                'value'=> $item['id']
            ));

        }

        $seminarsCustomFieldsQuery= new WP_QUERY(array(
            'post_type'=> array('seminar'),
            'meta_query'=> $professorRelatedSeminarsQuery
        ));

        while($seminarsCustomFieldsQuery->have_posts()) {
            $seminarsCustomFieldsQuery->the_post();

            array_push($allResults['seminars'], array(
                'title'=> get_the_title(),
                'URL'=> get_the_permalink(),
                'excerpt'=> get_the_excerpt(),
                'thumbnail'=> get_the_post_thumbnail_url(0, 'medium'),
            ));
        }

        $allResults['seminars']= array_unique($allResults['seminars'], SORT_REGULAR);
    }
    // show related Seminars for searched professor

    return $allResults;
}




// Register new Api route
function registerSearchApi() {
    register_rest_route('ataRoute/v1', 'search', array(
        'methods'=> WP_REST_SERVER::READABLE,
        'callback'=> 'getSearchResults'
    ));
}

add_action('rest_api_init', 'registerSearchApi');

/******************************************* search-route *****************************************/




function pageBanner($title, $subtitle, $photo) {
    
    if(!$title) $title= get_the_title();

    if(!$subtitle) $subtitle= get_field('page_banner_description');

    if(get_field('page_banner_background') AND !is_home() AND !is_archive()) $photo = get_field('page_banner_background')['sizes']['testSize'];
    else if(!get_field('page_banner_background') or is_home() or is_archive()) $photo= get_theme_file_uri().'/assets/h-62.webp';

?>

    <!-- Hero Section -->
    <div class="container-fluid">
        <div class="row">
            <div class="banner-section px-0" style="background-image: url('<?php echo $photo ?>');<?php if(!is_archive() AND !is_home()) echo 'background-position: center top; background-size:contain;' ?>">
                <div class="cover w-100 h-100 px-5 d-flex flex-column justify-content-center">
                    <h1 class="hero-title text-white">welcome to <?php echo $title ?></h1>
                    <p class="hero-description text-white"><?php echo $subtitle ?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Section -->

<?php  }




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




// Register nav menus
function ataMenus() {
    
    $menu = array(
        'Primary Menu'=>'header menu',
        'Secondary Menu'=>'footer menu'
    );

    register_nav_menus($menu);

}

add_action('init' , 'ataMenus');




// register styles and scripts and prepare incumbent Datas for Front-End
function ataStyles() {
    wp_enqueue_style('atafontawesome',get_template_directory_uri().'/assets/fontawesome-css/fontawesome.min.css');
    wp_enqueue_style('atafontawesomebrand',get_template_directory_uri().'/assets/fontawesome-css/brands.min.css');
    wp_enqueue_style('atafontawesomesolid',get_template_directory_uri().'/assets/fontawesome-css/solid.min.css');
    wp_enqueue_style('atafontawesomeregular',get_template_directory_uri().'/assets/fontawesome-css/regular.min.css');
    wp_enqueue_style('atabootstrap',get_template_directory_uri().'/assets/bootstrap/bootstrap.min.css');
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
function noteSettings($data, $postarr) {

    $PostId= $postarr['ID'];
    if($data['post_type']=== 'note') {
        if( (count_user_posts(get_current_user_id(), 'note') > 4 ) AND (!$PostId)) {
            die(json_encode(array("error"=> 'limit note count! delete some notes first')));
        }

        $data['post_content']= sanitize_textarea_field($data['post_content']);
        $data['post_title']= sanitize_text_field($data['post_title']);
    }
    if($data['post_type']=== 'note' AND $data['post_status'] !== 'trash') {
        $data['post_status']= 'private';
    }
    
    return $data;
}

add_filter('wp_insert_post_data', 'noteSettings', 10, 2);





