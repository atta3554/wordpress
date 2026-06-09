<?php
/**
 * Custom login page routing.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_redirect_default_login_page()
{
    if ('GET' !== ($_SERVER['REQUEST_METHOD'] ?? '')) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';

    if (false === strpos($request_uri, 'wp-login.php')) {
        return;
    }

    $action = isset($_GET['action']) ? sanitize_key(wp_unslash($_GET['action'])) : 'login';
    
    if (!in_array($action, array('login', 'register'), true)) {
        return;
    }

    wp_safe_redirect('register' === $action ? home_url('/register/') : home_url('/login/'));
    exit;
}
add_action('init', 'em_theme_redirect_default_login_page');

function em_theme_login_error_redirect($error_message)
{
    wp_safe_redirect(add_query_arg('login', 'failed', home_url('/login/')));
    exit;
}
add_filter('login_errors', 'em_theme_login_error_redirect');
