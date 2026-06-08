<?php
/**
 * Drop-in ACF field groups for the Event Management project.
 *
 * Move this file to wp-content/mu-plugins/acf-fields.php.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('acf/init', 'event_management_register_acf_field_groups');

function event_management_register_acf_field_groups()
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key'                   => 'group_event_management_event_details',
        'title'                 => __('Event Details', 'event-management-theme'),
        'fields'                => array(
            array(
                'key'               => 'field_event_management_event_date',
                'label'             => __('Event Date', 'event-management-theme'),
                'name'              => 'event_date',
                'type'              => 'date_picker',
                'instructions'      => __('Used for upcoming and past event ordering.', 'event-management-theme'),
                'required'          => 1,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'display_format'    => 'F j, Y',
                'return_format'     => 'Ymd',
                'first_day'         => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'event',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));

    acf_add_local_field_group(array(
        'key'                   => 'group_event_management_professor_details',
        'title'                 => __('Professor Details', 'event-management-theme'),
        'fields'                => array(
            array(
                'key'               => 'field_event_management_professor_field',
                'label'             => __('Field', 'event-management-theme'),
                'name'              => 'professor_field',
                'type'              => 'text',
                'instructions'      => '',
                'required'          => 1,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '40',
                    'class' => '',
                    'id'    => '',
                ),
                'default_value'     => '',
                'placeholder'       => __('Computer Science, Management, Design...', 'event-management-theme'),
                'prepend'           => '',
                'append'            => '',
                'maxlength'         => '',
            ),
            array(
                'key'               => 'field_event_management_professor_education',
                'label'             => __('Education', 'event-management-theme'),
                'name'              => 'professor_education',
                'type'              => 'text',
                'instructions'      => '',
                'required'          => 1,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '40',
                    'class' => '',
                    'id'    => '',
                ),
                'default_value'     => '',
                'placeholder'       => __('PhD, MSc, Professor...', 'event-management-theme'),
                'prepend'           => '',
                'append'            => '',
                'maxlength'         => '',
            ),
            array(
                'key'               => 'field_event_management_professor_age',
                'label'             => __('Age', 'event-management-theme'),
                'name'              => 'professor_age',
                'type'              => 'number',
                'instructions'      => '',
                'required'          => 1,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '20',
                    'class' => '',
                    'id'    => '',
                ),
                'default_value'     => '',
                'placeholder'       => '',
                'prepend'           => '',
                'append'            => '',
                'min'               => 18,
                'max'               => '',
                'step'              => 1,
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'professor',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));

    acf_add_local_field_group(array(
        'key'                   => 'group_event_management_seminar_details',
        'title'                 => __('Seminar Details', 'event-management-theme'),
        'fields'                => array(
            array(
                'key'               => 'field_event_management_seminar_professor',
                'label'             => __('Professor', 'event-management-theme'),
                'name'              => 'seminar_professor',
                'type'              => 'relationship',
                'instructions'      => __('Connect this seminar to one or more professors.', 'event-management-theme'),
                'required'          => 1,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'post_type'         => array(
                    0 => 'professor',
                ),
                'taxonomy'          => '',
                'filters'           => array(
                    0 => 'search',
                ),
                'elements'          => array(
                    0 => 'featured_image',
                ),
                'min'               => 1,
                'max'               => '',
                'return_format'     => 'id',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'seminar',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));

    acf_add_local_field_group(array(
        'key'                   => 'group_event_management_page_banner',
        'title'                 => __('Page Banner', 'event-management-theme'),
        'fields'                => array(
            array(
                'key'               => 'field_event_management_page_banner_description',
                'label'             => __('Banner Description', 'event-management-theme'),
                'name'              => 'page_banner_description',
                'type'              => 'textarea',
                'instructions'      => '',
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'default_value'     => '',
                'placeholder'       => '',
                'maxlength'         => '',
                'rows'              => 3,
                'new_lines'         => 'br',
            ),
            array(
                'key'               => 'field_event_management_page_banner_background',
                'label'             => __('Banner Background', 'event-management-theme'),
                'name'              => 'page_banner_background',
                'type'              => 'image',
                'instructions'      => __('Recommended size: 1500x400 or larger.', 'event-management-theme'),
                'required'          => 0,
                'conditional_logic' => 0,
                'wrapper'           => array(
                    'width' => '',
                    'class' => '',
                    'id'    => '',
                ),
                'return_format'     => 'id',
                'preview_size'      => 'medium',
                'library'           => 'all',
                'min_width'         => '',
                'min_height'        => '',
                'min_size'          => '',
                'max_width'         => '',
                'max_height'        => '',
                'max_size'          => '',
                'mime_types'        => 'jpg,jpeg,png,webp',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'page',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'event',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'seminar',
                ),
            ),
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'professor',
                ),
            ),
        ),
        'menu_order'            => 10,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
        'show_in_rest'          => 0,
    ));
}
