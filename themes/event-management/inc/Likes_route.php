<?php 

add_action('rest_api_init', 'registerLikeRoute');

function registerLikeRoute() {
    register_rest_route('ataRoute/v1', 'like', array(
        'methods'=> 'POST',
        'callback'=> 'likeProfessor',
        'permission_callback'=> 'is_user_logged_in'
    ));

    register_rest_route('ataRoute/v1', 'like', array(
        'methods'=> 'DELETE',
        'callback'=> 'disLikeProfessor',
        'permission_callback'=> 'is_user_logged_in'
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
        return new WP_Error('invalid_professor_id', 'invalid professor id', array('status'=> 400));
    }
}

function disLikeProfessor($data) {
    $currentLike= sanitize_text_field($data['like']);

    if(get_current_user_id() == get_post_field('post_author', $currentLike) AND get_post_type($currentLike) == 'like') {
        wp_delete_post($currentLike, true);
        return 'like deleted successfully';
    } else {
        return new WP_Error('forbidden_like_delete', "you don't have permission to delete this post", array('status'=> 403));
    }
}

?>
