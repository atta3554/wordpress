<?php

function themePostTypes() {

    //Event post type
    register_post_type('event' , array(
        'capability_type'=> 'event',
        'map_meta_cap'=> true,
        'supports'=>array('title', 'editor', 'excerpt', 'thumbnail'),
        'has_archive'=>true,
        'rewrite'=>array('slug'=>'events'),
        'public'=>true,
        'show_in_rest'=>true,
        'labels'=>array(
            'name'=>'events',
            'add_new_item'=>'Add New Event',
            'add_new'=>'Add New Event',
            'edit_item'=>'Edit Event',
            'all_items'=>'All events',
            'singular_name'=>'event'
        ),
        'menu_icon'=>'dashicons-calendar',
    ));


    //Professor post type
    register_post_type('professor' , array(
        'capability_type'=> 'professor',
        'map_meta_cap'=> true,
        'supports'=>array('title', 'editor', 'excerpt', 'thumbnail'),
        'has_archive'=>true,
        'rewrite'=>array('slug'=>'professors'),
        'public'=>true,
        'show_in_rest'=>true,
        'labels'=>array(
            'name'=>'professors',
            'add_new'=>'Add New Professor',
            'add_new_item'=>'Add New Professor',
            'edit_item'=>'Edit Professor',
            'all_items'=>'All professors',
            'singular_name'=>'professor'
        ),
        'menu_icon'=>'dashicons-welcome-learn-more'
    ));


    //Seminar post type
    register_post_type('seminar', array(
        'capability_type'=> 'seminar',
        'map_meta_cap'=> true,
        'public'=> true,
        'show_in_rest'=> true,
        'supports'=>array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive'=> true,
        'rewrite'=>array('slug'=> 'seminars'),
        'labels'=>array(
            'name'=> 'seminars',
            'add_new_item'=> 'Add New Seminar',
            'add_new'=> 'Add New Seminar',
            'all_items'=> 'All Seminars',
            'edit_item'=> 'Edit Seminar',
            'singular_name'=> 'seminar'
        ),
        'menu_icon'=>'dashicons-awards'
    ));


    //Note post type
    register_post_type('note', array(
        'capability_type'=> 'note',
        'map_meta_cap'=> true,
        'public'=> false,
        'show_ui'=> true,
        'show_in_rest'=> true,
        'supports'=>array('title', 'editor'),
        'labels'=>array(
            'name'=> 'notes',
            'add_new_item'=> 'Add New note',
            'add_new'=> 'Add New note',
            'all_items'=> 'All notes',
            'edit_item'=> 'Edit note',
            'singular_name'=> 'note'
        ),
        'menu_icon'=>'dashicons-welcome-write-blog'
    ));


    //Like post type
    register_post_type('like', array(
        'public'=> false,
        'show_ui'=> true,
        'supports'=>array('title'),
        'labels'=>array(
            'name'=> 'likes',
            'add_new_item'=> 'Add New like',
            'add_new'=> 'Add New like',
            'all_items'=> 'All likes',
            'edit_item'=> 'Edit like',
            'singular_name'=> 'like'
        ),
        'menu_icon'=>'dashicons-heart'
    ));
}

add_action('init' , 'themePostTypes');

