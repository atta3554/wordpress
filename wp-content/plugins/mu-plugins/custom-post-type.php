<?php

function customPostType() {
    register_post_type('professors' , array(
        'public'=>true,
        'show_in_rest'=>true,
        'labels'=>array(
            'name'=>'professors',
            'add_new_item'=>"Add New Professor",
            'edit_item'=>'Edit Professor',
            'all_items'=>'All professors',
        ),
        'menu_icon'=>'dashicons-welcome-learn-more'
    ));
}

add_action('init' , 'customPostType')

?>  