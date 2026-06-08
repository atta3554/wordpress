<?php
/**
 * Theme activation orchestration.
 *
 * Theme-owned activation work lives here. Custom post types and capabilities
 * are intentionally handled by mu-plugins.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_after_switch_theme()
{
    if (function_exists('em_theme_setup_required_pages')) {
        em_theme_setup_required_pages();
    }

    if (function_exists('em_theme_setup_default_primary_menu')) {
        em_theme_setup_default_primary_menu();
    }

    flush_rewrite_rules();
}
add_action('after_switch_theme', 'em_theme_after_switch_theme');
