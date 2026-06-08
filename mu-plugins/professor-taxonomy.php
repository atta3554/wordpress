<?php
/**
 * Professor taxonomies for the Event Management project.
 *
 * Move this file to wp-content/mu-plugins/professor-taxonomy.php.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'event_management_register_professor_field_taxonomy', 0);
add_action('init', 'event_management_maybe_flush_professor_field_rewrites', 99);
add_action('init', 'event_management_migrate_professor_field_meta_to_taxonomy', 30);
add_filter('acf/prepare_field/name=professor_field', 'event_management_hide_deprecated_professor_field_acf_field');

function event_management_register_professor_field_taxonomy()
{
    $labels = array(
        'name'                       => __('Professor Fields', 'event-management-theme'),
        'singular_name'              => __('Professor Field', 'event-management-theme'),
        'search_items'               => __('Search Professor Fields', 'event-management-theme'),
        'all_items'                  => __('All Professor Fields', 'event-management-theme'),
        'parent_item'                => __('Parent Professor Field', 'event-management-theme'),
        'parent_item_colon'          => __('Parent Professor Field:', 'event-management-theme'),
        'edit_item'                  => __('Edit Professor Field', 'event-management-theme'),
        'view_item'                  => __('View Professor Field', 'event-management-theme'),
        'update_item'                => __('Update Professor Field', 'event-management-theme'),
        'add_new_item'               => __('Add New Professor Field', 'event-management-theme'),
        'new_item_name'              => __('New Professor Field Name', 'event-management-theme'),
        'not_found'                  => __('No professor fields found.', 'event-management-theme'),
        'menu_name'                  => __('Fields', 'event-management-theme'),
    );

    register_taxonomy(
        'professor_field',
        array('professor'),
        array(
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_in_menu'      => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'show_in_quick_edit'=> true,
            'query_var'         => true,
            'meta_box_cb'       => 'post_categories_meta_box',
            'rewrite'           => array(
                'slug'       => 'professor-fields',
                'with_front' => false,
            ),
            'capabilities'      => array(
                'manage_terms' => 'manage_categories',
                'edit_terms'   => 'manage_categories',
                'delete_terms' => 'manage_categories',
                'assign_terms' => 'edit_professors',
            ),
        )
    );
}

function event_management_maybe_flush_professor_field_rewrites()
{
    if (get_option('event_management_professor_field_taxonomy_version') === '2') {
        return;
    }

    flush_rewrite_rules(false);
    update_option('event_management_professor_field_taxonomy_version', '2');
}

function event_management_migrate_professor_field_meta_to_taxonomy()
{
    if (get_option('event_management_professor_field_meta_migrated') === '1' || !taxonomy_exists('professor_field')) {
        return;
    }

    $professor_ids = get_posts(array(
        'post_type'      => 'professor',
        'post_status'    => 'any',
        'fields'         => 'ids',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'professor_field',
                'compare' => 'EXISTS',
            ),
        ),
    ));

    foreach ($professor_ids as $professor_id) {
        $raw_field = get_post_meta($professor_id, 'professor_field', true);
        $field_names = is_array($raw_field) ? $raw_field : array($raw_field);
        $field_names = array_filter(array_map('event_management_sanitize_professor_field_term_name', $field_names));

        if (empty($field_names)) {
            continue;
        }

        wp_set_object_terms((int) $professor_id, $field_names, 'professor_field', false);
    }

    update_option('event_management_professor_field_meta_migrated', '1');
}

function event_management_sanitize_professor_field_term_name($field_name)
{
    return trim(wp_strip_all_tags((string) $field_name));
}

function event_management_hide_deprecated_professor_field_acf_field($field)
{
    return false;
}
