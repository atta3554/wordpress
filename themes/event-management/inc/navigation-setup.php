<?php
/**
 * Default editable menu setup.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_get_default_primary_menu_items()
{
    $items = array();

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id) {
        $items[] = array(
            'title'     => __('Home', 'event-management-theme'),
            'type'      => 'post_type',
            'object'    => 'page',
            'object_id' => $front_page_id,
            'url'       => get_permalink($front_page_id),
        );
    } else {
        $items[] = array(
            'title' => __('Home', 'event-management-theme'),
            'type'  => 'custom',
            'url'   => home_url('/'),
        );
    }

    foreach (
        array(
            'seminar'   => __('Seminars', 'event-management-theme'),
            'event'     => __('Events', 'event-management-theme'),
            'professor' => __('Professors', 'event-management-theme'),
        ) as $post_type => $title
    ) {
        $archive_url = get_post_type_archive_link($post_type);

        if (!$archive_url) {
            continue;
        }

        $items[] = array(
            'title'  => $title,
            'type'   => 'post_type_archive',
            'object' => $post_type,
            'url'    => $archive_url,
        );
    }

    $posts_page_id = (int) get_option('page_for_posts');
    $blog_page     = $posts_page_id ? get_post($posts_page_id) : get_page_by_path('blog');

    if ($blog_page instanceof WP_Post) {
        $items[] = array(
            'title'     => __('Blog', 'event-management-theme'),
            'type'      => 'post_type',
            'object'    => 'page',
            'object_id' => $blog_page->ID,
            'url'       => get_permalink($blog_page),
        );
    } else {
        $items[] = array(
            'title' => __('Blog', 'event-management-theme'),
            'type'  => 'custom',
            'url'   => home_url('/blog/'),
        );
    }

    return $items;
}

function em_theme_menu_item_exists($menu_id, $item)
{
    $menu_items = wp_get_nav_menu_items($menu_id);

    if (!$menu_items) {
        return false;
    }

    foreach ($menu_items as $menu_item) {
        if (!empty($item['object_id']) && (int) $menu_item->object_id === (int) $item['object_id']) {
            return true;
        }

        if (!empty($item['object']) && $menu_item->object === $item['object'] && $menu_item->type === $item['type']) {
            return true;
        }

        if (!empty($item['url']) && untrailingslashit($menu_item->url) === untrailingslashit($item['url'])) {
            return true;
        }
    }

    return false;
}

function em_theme_add_default_menu_items($menu_id)
{
    foreach (em_theme_get_default_primary_menu_items() as $item) {
        if (em_theme_menu_item_exists($menu_id, $item)) {
            continue;
        }

        $menu_item_data = array(
            'menu-item-title'  => $item['title'],
            'menu-item-url'    => $item['url'],
            'menu-item-status' => 'publish',
            'menu-item-type'   => $item['type'],
        );

        if (!empty($item['object'])) {
            $menu_item_data['menu-item-object'] = $item['object'];
        }

        if (!empty($item['object_id'])) {
            $menu_item_data['menu-item-object-id'] = $item['object_id'];
        }

        wp_update_nav_menu_item($menu_id, 0, $menu_item_data);
    }
}

function em_theme_setup_default_primary_menu()
{
    $locations        = get_theme_mod('nav_menu_locations', array());
    $primary_location = 'Primary Menu';

    if (!empty($locations[$primary_location]) && wp_get_nav_menu_object($locations[$primary_location])) {
        return;
    }

    $menu_name = __('Event Management Primary Menu', 'event-management-theme');
    $menu      = wp_get_nav_menu_object($menu_name);
    $menu_id   = $menu ? (int) $menu->term_id : wp_create_nav_menu($menu_name);

    if (is_wp_error($menu_id)) {
        return;
    }

    em_theme_add_default_menu_items($menu_id);

    $locations[$primary_location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}
