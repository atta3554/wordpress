<?php
/**
 * REST search endpoint.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_get_search_results($request)
{
    $keyword = sanitize_text_field($request->get_param('keyword'));
    $results = array(
        'pages'      => array(),
        'posts'      => array(),
        'events'     => array(),
        'professors' => array(),
        'seminars'   => array(),
    );

    if (strlen($keyword) < 2) {
        return rest_ensure_response($results);
    }

    $main_query = new WP_Query(
        array(
            'post_type'      => array('page', 'post', 'professor', 'event', 'seminar'),
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'no_found_rows'  => true,
            's'              => $keyword,
        )
    );

    while ($main_query->have_posts()) {
        $main_query->the_post();
        $post_type = get_post_type();

        $item = array(
            'title'     => html_entity_decode(get_the_title(), ENT_QUOTES, get_bloginfo('charset')),
            'URL'       => get_permalink(),
            'excerpt'   => em_theme_trimmed_excerpt(24),
            'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
        );

        if ('post' === $post_type) {
            $item['author'] = get_the_author();
            $item['authorURL'] = get_author_posts_url(get_the_author_meta('ID'));
            $results['posts'][] = $item;
        }

        if ('page' === $post_type) {
            unset($item['thumbnail']);
            $results['pages'][] = $item;
        }

        if ('event' === $post_type) {
            $event_date = em_theme_get_event_datetime();
            $item['date'] = $event_date ? $event_date->format('Ymd') : '';
            unset($item['thumbnail']);
            $results['events'][] = $item;
        }

        if ('professor' === $post_type) {
            $item['id'] = get_the_ID();
            $results['professors'][] = $item;
        }

        if ('seminar' === $post_type) {
            $results['seminars'][] = $item;
        }
    }
    wp_reset_postdata();

    if ($results['professors']) {
        $professor_related_seminars_query = array('relation' => 'OR');

        foreach ($results['professors'] as $item) {
            $professor_related_seminars_query[] = array(
                'key'     => 'seminar_professor',
                'compare' => 'LIKE',
                'value'   => '"' . absint($item['id']) . '"',
            );
        }

        $seminars_custom_fields_query = new WP_Query(
            array(
                'post_type'      => 'seminar',
                'post_status'    => 'publish',
                'posts_per_page' => 10,
                'no_found_rows'  => true,
                'meta_query'     => $professor_related_seminars_query,
            )
        );

        while ($seminars_custom_fields_query->have_posts()) {
            $seminars_custom_fields_query->the_post();

            $results['seminars'][] = array(
                'title'     => html_entity_decode(get_the_title(), ENT_QUOTES, get_bloginfo('charset')),
                'URL'       => get_permalink(),
                'excerpt'   => em_theme_trimmed_excerpt(24),
                'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
            );
        }
        wp_reset_postdata();

        $results['seminars'] = array_values(array_unique($results['seminars'], SORT_REGULAR));
    }

    return rest_ensure_response($results);
}

function em_theme_register_search_api()
{
    register_rest_route(
        'ataRoute/v1',
        'search',
        array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'em_theme_get_search_results',
            'permission_callback' => '__return_true',
            'args'                => array(
                'keyword' => array(
                    'required'          => true,
                    'sanitize_callback' => 'sanitize_text_field',
                    'validate_callback' => function($value) {
                        return is_string($value);
                    },
                ),
            ),
        )
    );
}
add_action('rest_api_init', 'em_theme_register_search_api');
