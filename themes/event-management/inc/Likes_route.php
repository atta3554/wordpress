<?php
/**
 * REST endpoints for professor likes.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', 'em_theme_register_like_routes');

function em_theme_register_like_routes()
{
    register_rest_route(
        'ataRoute/v1',
        'like',
        array(
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => 'em_theme_like_professor',
                'permission_callback' => 'is_user_logged_in',
                'args'                => array(
                    'professorId' => array(
                        'required'          => true,
                        'sanitize_callback' => 'absint',
                    ),
                ),
            ),
            array(
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => 'em_theme_dislike_professor',
                'permission_callback' => 'is_user_logged_in',
                'args'                => array(
                    'like' => array(
                        'required'          => true,
                        'sanitize_callback' => 'absint',
                    ),
                ),
            ),
        )
    );
}

function em_theme_like_professor($request)
{
    $current_professor_id = absint($request->get_param('professorId'));

    if (!$current_professor_id || 'professor' !== get_post_type($current_professor_id) || 'publish' !== get_post_status($current_professor_id)) {
        return new WP_Error('invalid_professor_id', __('Invalid professor id.', 'event-management-theme'), array('status' => 400));
    }

    $current_user_like = new WP_Query(
        array(
            'post_type'      => 'like',
            'post_status'    => 'any',
            'author'         => get_current_user_id(),
            'fields'         => 'ids',
            'posts_per_page' => 1,
            'no_found_rows'  => true,
            'meta_query'     => array(
                array(
                    'key'     => 'professor_like_id',
                    'compare' => '=',
                    'value'   => $current_professor_id,
                    'type'    => 'NUMERIC',
                ),
            ),
        )
    );

    if ($current_user_like->have_posts()) {
        return new WP_Error('duplicate_like', __('You already liked this professor.', 'event-management-theme'), array('status' => 409));
    }

    $like_id = wp_insert_post(
        array(
            'post_type'   => 'like',
            'post_status' => 'publish',
            'post_title'  => sprintf('User %d liked professor %d', get_current_user_id(), $current_professor_id),
            'post_author' => get_current_user_id(),
            'meta_input'  => array(
                'professor_like_id' => $current_professor_id,
            ),
        ),
        true
    );

    if (is_wp_error($like_id)) {
        return $like_id;
    }

    return rest_ensure_response(array('id' => $like_id));
}

function em_theme_dislike_professor($request)
{
    $current_like = absint($request->get_param('like'));

    if (!$current_like || 'like' !== get_post_type($current_like)) {
        return new WP_Error('invalid_like_id', __('Invalid like id.', 'event-management-theme'), array('status' => 400));
    }

    if ((int) get_post_field('post_author', $current_like) !== get_current_user_id()) {
        return new WP_Error('forbidden_like_delete', __('You do not have permission to delete this like.', 'event-management-theme'), array('status' => 403));
    }

    wp_delete_post($current_like, true);

    return rest_ensure_response(array('deleted' => true));
}
