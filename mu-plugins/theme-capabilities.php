<?php

function theme_install_custom_capabilities() {

    if (get_option('theme_custom_caps_installed') === '2') {
        return;
    }

    $administrator = get_role('administrator');

    if (!$administrator) {
        return;
    }

    $post_types = array(
        array('event', 'events'),
        array('professor', 'professors'),
        array('seminar', 'seminars'),
        array('note', 'notes'),
    );

    foreach ($post_types as $post_type) {

        $singular = $post_type[0];
        $plural   = $post_type[1];

        $capabilities = array(
            "edit_{$singular}",
            "read_{$singular}",
            "delete_{$singular}",

            "edit_{$plural}",
            "edit_others_{$plural}",
            "publish_{$plural}",
            "read_private_{$plural}",

            "delete_{$plural}",
            "delete_private_{$plural}",
            "delete_published_{$plural}",
            "delete_others_{$plural}",

            "edit_private_{$plural}",
            "edit_published_{$plural}",
        );

        foreach ($capabilities as $capability) {
            $administrator->add_cap($capability);
        }
    }

    $subscriber = get_role('subscriber');

    if ($subscriber) {
        $subscriber_note_caps = array(
            'edit_note',
            'read_note',
            'delete_note',
            'edit_notes',
            'publish_notes',
            'delete_notes',
            'edit_published_notes',
            'delete_published_notes',
            'read_private_notes',
            'edit_private_notes',
            'delete_private_notes',
        );

        foreach ($subscriber_note_caps as $capability) {
            $subscriber->add_cap($capability);
        }
    }

    update_option('theme_custom_caps_installed', '2');
}

add_action('init', 'theme_install_custom_capabilities', 20);
