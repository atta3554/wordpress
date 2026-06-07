<?php

function themePostTypes() {

    //Event post type
    $event_labels = array(
        'name'          =>'events',
        'add_new_item'  =>'Add New Event',
        'add_new'       =>'Add New Event',
        'edit_item'     =>'Edit Event',
        'all_items'     =>'All events',
        'singular_name' =>'event'
    );

    register_post_type('event' , array(
        'capability_type' => array('event', 'events'),
        'map_meta_cap'    => true,
        'supports'        => array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
        'has_archive'     => true,
        'rewrite'         => array('slug'=>'events'),
        'public'          => true,
        'show_in_rest'    => true,
        'menu_icon'       =>'dashicons-calendar',
        'labels'          => $event_labels
    ));


    //Professor post type
    $professor_label = array(
        'name'          =>'professors',
        'add_new'       =>'Add New Professor',
        'add_new_item'  =>'Add New Professor',
        'edit_item'     =>'Edit Professor',
        'all_items'     =>'All professors',
        'singular_name' =>'professor'
    );

    register_post_type('professor' , array(
        'capability_type' => array('professor', 'professors'),
        'map_meta_cap'    => true,
        'supports'        => array('title', 'editor', 'excerpt', 'thumbnail', 'comments'),
        'has_archive'     => true,
        'rewrite'         => array('slug'=>'professors'),
        'public'          => true,
        'show_in_rest'    => true,
        'menu_icon'       =>'dashicons-welcome-learn-more',
        'labels'          => $professor_label
    ));


    //Seminar post type
    $seminar_labels = array(
        'name'          => 'seminars',
        'add_new_item'  => 'Add New Seminar',
        'add_new'       => 'Add New Seminar',
        'all_items'     => 'All Seminars',
        'edit_item'     => 'Edit Seminar',
        'singular_name' => 'seminar'
    );

    register_post_type('seminar', array(
        'capability_type' => array('seminar', 'seminars'),
        'map_meta_cap'    => true,
        'public'          => true,
        'show_in_rest'    => true,
        'supports'        => array('title', 'editor', 'thumbnail', 'comments', 'excerpt'),
        'has_archive'     => true,
        'rewrite'         => array('slug'=> 'seminars'),
        'menu_icon'       =>'dashicons-awards',
        'labels'          => $seminar_labels,
    ));


    //Note post type
    $note_labels = array(
      'name'          => 'notes',
      'add_new_item'  => 'Add New note',
      'add_new'       => 'Add New note',
      'all_items'     => 'All notes',
      'edit_item'     => 'Edit note',
      'singular_name' => 'note'
    );

    register_post_type('note', array(
        'capability_type'     => array('note', 'notes'),
        'map_meta_cap'        => true,
        'public'              => false,
        'show_ui'             => true,
        'show_in_rest'        => true,
        'supports'            => array('title', 'editor', 'author'),
        'menu_icon'           =>'dashicons-welcome-write-blog',
        'exclude_from_search' => true,
        'labels'              => $note_labels
    ));


    //Like post type
    $like_labels = array(
        'name'          => 'likes',
        'add_new_item'  => 'Add New like',
        'add_new'       => 'Add New like',
        'all_items'     => 'All likes',
        'edit_item'     => 'Edit like',
        'singular_name' => 'like'
    );

    register_post_type('like', array(
        'public'    => false,
        'show_ui'   => true,
        'supports'  => array('title'),
        'menu_icon' => 'dashicons-heart',
        'labels'    => $like_labels
    ));

}

add_action('init' , 'themePostTypes');

