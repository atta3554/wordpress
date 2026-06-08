<?php
/**
 * Required frontend pages for theme-specific templates.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_get_required_pages()
{
    return array(
        'my-notes'    => array(
            'title'    => __('My Notes', 'event-management-theme'),
            'template' => 'page-my-notes.php',
        ),
        'past-events' => array(
            'title'    => __('Past Events', 'event-management-theme'),
            'template' => 'page-past-events.php',
        ),
        'search'      => array(
            'title'    => __('Search', 'event-management-theme'),
            'template' => 'page-search.php',
        ),
    );
}

function em_theme_find_page_by_slug($slug)
{
    $pages = get_posts(
        array(
            'name'           => $slug,
            'post_type'      => 'page',
            'post_status'    => array('publish', 'draft', 'pending', 'private', 'future', 'trash'),
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        )
    );

    return $pages ? (int) $pages[0] : 0;
}

function em_theme_ensure_required_page($slug, $args)
{
    $page_id = em_theme_find_page_by_slug($slug);

    if ($page_id) {
        if ('trash' === get_post_status($page_id)) {
            wp_untrash_post($page_id);
        }

        $page_id = wp_update_post(
            array(
                'ID'             => $page_id,
                'post_name'      => $slug,
                'post_status'    => 'publish',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            )
        );
    } else {
        $page_id = wp_insert_post(
            array(
                'post_title'     => $args['title'],
                'post_name'      => $slug,
                'post_type'      => 'page',
                'post_status'    => 'publish',
                'post_content'   => '',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
            )
        );
    }

    if (is_wp_error($page_id) || !$page_id) {
        return 0;
    }

    update_post_meta((int) $page_id, '_wp_page_template', $args['template']);

    return (int) $page_id;
}

function em_theme_setup_required_pages()
{
    $page_ids = array();

    foreach (em_theme_get_required_pages() as $slug => $args) {
        $page_ids[$slug] = em_theme_ensure_required_page($slug, $args);
    }

    update_option('em_theme_required_page_ids', array_filter($page_ids), false);

    return $page_ids;
}
