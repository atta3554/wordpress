<?php
/*
Template Name: custom login page
*/

if (!defined('ABSPATH')) {
    exit;
}

if (is_user_logged_in()) {
    wp_safe_redirect(home_url('/'));
    exit;
}

get_header();
em_theme_page_banner('', '', '');

$login_failed = isset($_GET['login']) && 'failed' === sanitize_key(wp_unslash($_GET['login']));
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 border rounded p-4 p-sm-5">
            <h2 class="text-center py-2"><?php esc_html_e('Sign in to your account', 'event-management-theme'); ?></h2>
            <?php if ($login_failed) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php esc_html_e('Login failed. Please check your username and password.', 'event-management-theme'); ?>
                </div>
            <?php endif; ?>

            <?php
            wp_login_form(
                array(
                    'redirect'       => home_url('/my-notes/'),
                    'form_id'        => 'custom_loginform',
                    'label_username' => __('Username', 'event-management-theme'),
                    'label_password' => __('Password', 'event-management-theme'),
                    'label_remember' => __('Remember Me', 'event-management-theme'),
                    'label_log_in'   => __('Log In', 'event-management-theme'),
                    'remember'       => true,
                )
            );
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
