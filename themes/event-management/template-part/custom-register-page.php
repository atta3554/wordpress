<?php
/*
Template Name: custom register page
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

$show_form = true;
$errors    = array();
$success   = false;

if ('POST' === ($_SERVER['REQUEST_METHOD'] ?? '')) {
    if (!isset($_POST['event_management_register_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['event_management_register_nonce'])), 'event_management_register')) {
        $errors[] = __('Security check failed. Please try again.', 'event-management-theme');
    }

    $user_name         = isset($_POST['userName-register']) ? sanitize_user(wp_unslash($_POST['userName-register']), true) : '';
    $user_email        = isset($_POST['user_Email-register']) ? sanitize_email(wp_unslash($_POST['user_Email-register'])) : '';
    $user_password     = isset($_POST['user_password-register']) ? (string) wp_unslash($_POST['user_password-register']) : '';
    $user_pass_confirm = isset($_POST['user_confirm_password-register']) ? (string) wp_unslash($_POST['user_confirm_password-register']) : '';

    if (!$user_name) {
        $errors[] = __('Username is required.', 'event-management-theme');
    }

    if (preg_match('/\s/', $user_name)) {
        $errors[] = __('Username cannot contain spaces.', 'event-management-theme');
    }

    if ($user_name && username_exists($user_name)) {
        $errors[] = __('This username is already taken.', 'event-management-theme');
    }

    if (!is_email($user_email)) {
        $errors[] = __('Please enter a valid email address.', 'event-management-theme');
    }

    if ($user_email && email_exists($user_email)) {
        $errors[] = __('This email is already registered.', 'event-management-theme');
    }

    if (strlen($user_password) < 8) {
        $errors[] = __('Password must be at least 8 characters.', 'event-management-theme');
    }

    if ($user_password !== $user_pass_confirm) {
        $errors[] = __('Passwords do not match.', 'event-management-theme');
    }

    if (!$errors) {
        $user_id = wp_create_user($user_name, $user_password, $user_email);

        if (!is_wp_error($user_id)) {
            $new_user = new WP_User($user_id);
            $new_user->set_role('subscriber');
            wp_new_user_notification($user_id, null, 'both');
            $success   = true;
            $show_form = false;
        } else {
            $errors[] = $user_id->get_error_message();
        }
    }
}
?>

<div class="container d-flex flex-column align-items-center my-4">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-md-8 col-lg-6">
            <?php if ($success) : ?>
                <div class="alert alert-success text-center" role="alert">
                    <?php esc_html_e('Your account has been created successfully. You can now log in.', 'event-management-theme'); ?>
                </div>
                <p class="text-center"><a class="btn bg-primary text-white" href="<?php echo esc_url(home_url('/login/')); ?>"><?php esc_html_e('Go to Login', 'event-management-theme'); ?></a></p>
            <?php endif; ?>

            <?php if ($errors) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach ($errors as $error) : ?>
                        <p class="mb-1"><?php echo esc_html($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_form) : ?>
                <h2 class="my-4 text-center"><?php esc_html_e('Create your account', 'event-management-theme'); ?></h2>
                <form class="mt-4 border rounded py-sm-3 py-1 px-3 px-sm-5" id="user_register-form" method="POST" action="<?php echo esc_url(get_permalink()); ?>">
                    <?php wp_nonce_field('event_management_register', 'event_management_register_nonce'); ?>
                    <div class="d-flex gap-4 justify-content-between my-2 flex-column flex-sm-row">
                        <label for="userName-register"><?php esc_html_e('Username', 'event-management-theme'); ?></label>
                        <input type="text" class="py-1 px-2 rounded" id="userName-register" name="userName-register" value="<?php echo isset($user_name) ? esc_attr($user_name) : ''; ?>" required>
                    </div>

                    <div class="d-flex gap-4 justify-content-between my-2 flex-column flex-sm-row">
                        <label for="user_Email-register"><?php esc_html_e('Email', 'event-management-theme'); ?></label>
                        <input type="email" class="py-1 px-2 rounded" id="user_Email-register" name="user_Email-register" value="<?php echo isset($user_email) ? esc_attr($user_email) : ''; ?>" required>
                    </div>

                    <div class="d-flex gap-4 justify-content-between my-2 flex-column flex-sm-row">
                        <label for="user_password-register"><?php esc_html_e('Password', 'event-management-theme'); ?></label>
                        <input type="password" class="py-1 px-2 rounded" id="user_password-register" name="user_password-register" required minlength="8">
                    </div>

                    <div class="d-flex gap-4 justify-content-between my-2 flex-column flex-sm-row">
                        <label for="user_confirm_password-register"><?php esc_html_e('Confirm password', 'event-management-theme'); ?></label>
                        <input type="password" class="py-1 px-2 rounded" id="user_confirm_password-register" name="user_confirm_password-register" required minlength="8">
                    </div>

                    <div class="d-flex justify-content-center my-5">
                        <input type="submit" class="py-2 px-5 bg-primary text-white rounded" name="submitRegister" value="<?php esc_attr_e('Register', 'event-management-theme'); ?>">
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
