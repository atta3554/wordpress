<?php 

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

add_action('rest_api_init', 'registerSearchApi')

?>