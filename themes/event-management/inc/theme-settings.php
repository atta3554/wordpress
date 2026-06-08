<?php
/**
 * Theme settings page and helpers.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_get_banner_setting_fields()
{
    return array(
        'global_archive'     => __('Global archive banner', 'event-management-theme'),
        'archive_events'     => __('Events archive banner', 'event-management-theme'),
        'archive_seminars'   => __('Seminars archive banner', 'event-management-theme'),
        'archive_professors' => __('Professors archive banner', 'event-management-theme'),
    );
}

function em_theme_get_banner_settings()
{
    $settings = get_option('em_theme_banner_images', array());

    return is_array($settings) ? array_map('absint', $settings) : array();
}

function em_theme_get_banner_image_url($key, $size = 'page_banner_size')
{
    $settings      = em_theme_get_banner_settings();
    $attachment_id = !empty($settings[$key]) ? absint($settings[$key]) : 0;

    if (!$attachment_id) {
        return '';
    }

    return wp_get_attachment_image_url($attachment_id, $size) ?: '';
}

function em_theme_get_asset_banner_image_url($filename)
{
    $relative_path = '/assets/images/' . ltrim($filename, '/');

    if (!file_exists(get_theme_file_path($relative_path))) {
        return '';
    }

    return get_theme_file_uri($relative_path);
}

function em_theme_get_archive_banner_image_url()
{
    if (is_post_type_archive('event')) {
        return em_theme_get_banner_image_url('archive_events')
            ?: em_theme_get_banner_image_url('global_archive')
            ?: em_theme_get_asset_banner_image_url('events.png');
    }

    if (is_post_type_archive('seminar')) {
        return em_theme_get_banner_image_url('archive_seminars')
            ?: em_theme_get_banner_image_url('global_archive')
            ?: em_theme_get_asset_banner_image_url('seminars.png');
    }

    if (is_post_type_archive('professor')) {
        return em_theme_get_banner_image_url('archive_professors')
            ?: em_theme_get_banner_image_url('global_archive')
            ?: em_theme_get_asset_banner_image_url('professors.png');
    }

    if (is_archive()) {
        return em_theme_get_banner_image_url('global_archive')
            ?: em_theme_get_asset_banner_image_url('archive.png');
    }

    return '';
}

function em_theme_register_settings_page()
{
    add_theme_page(
        __('Event Management Theme Settings', 'event-management-theme'),
        __('Theme Settings', 'event-management-theme'),
        'manage_options',
        'em-theme-settings',
        'em_theme_render_settings_page'
    );
}
add_action('admin_menu', 'em_theme_register_settings_page');

function em_theme_enqueue_settings_assets($hook_suffix)
{
    if ('appearance_page_em-theme-settings' !== $hook_suffix) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script('jquery');
    wp_add_inline_script(
        'jquery-core',
        "
        jQuery(function($) {
            $('.em-theme-upload-banner').on('click', function(event) {
                event.preventDefault();

                const button = $(this);
                const row = button.closest('.em-theme-banner-field');
                const frame = wp.media({
                    title: button.data('title'),
                    button: { text: button.data('button') },
                    multiple: false
                });

                frame.on('select', function() {
                    const attachment = frame.state().get('selection').first().toJSON();
                    row.find('.em-theme-banner-id').val(attachment.id);
                    row.find('.em-theme-banner-preview').html('<img src=\"' + attachment.url + '\" alt=\"\" style=\"max-width: 320px; height: auto; display: block; margin-top: 10px;\" />');
                    row.find('.em-theme-remove-banner').prop('disabled', false);
                });

                frame.open();
            });

            $('.em-theme-remove-banner').on('click', function(event) {
                event.preventDefault();

                const row = $(this).closest('.em-theme-banner-field');
                row.find('.em-theme-banner-id').val('');
                row.find('.em-theme-banner-preview').empty();
                $(this).prop('disabled', true);
            });
        });
        "
    );
}
add_action('admin_enqueue_scripts', 'em_theme_enqueue_settings_assets');

function em_theme_save_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (
        empty($_POST['em_theme_settings_nonce'])
        || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['em_theme_settings_nonce'])), 'em_theme_save_settings')
    ) {
        return;
    }

    $posted_images = isset($_POST['em_theme_banner_images']) && is_array($_POST['em_theme_banner_images'])
        ? wp_unslash($_POST['em_theme_banner_images'])
        : array();

    $settings = array();

    foreach (em_theme_get_banner_setting_fields() as $key => $label) {
        $settings[$key] = isset($posted_images[$key]) ? absint($posted_images[$key]) : 0;
    }

    update_option('em_theme_banner_images', $settings, false);

    add_settings_error(
        'em_theme_settings',
        'settings_updated',
        __('Theme settings saved.', 'event-management-theme'),
        'updated'
    );
}

function em_theme_render_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    em_theme_save_settings_page();

    $settings = em_theme_get_banner_settings();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Event Management Theme Settings', 'event-management-theme'); ?></h1>
        <?php settings_errors('em_theme_settings'); ?>

        <form method="post" action="">
            <?php wp_nonce_field('em_theme_save_settings', 'em_theme_settings_nonce'); ?>

            <table class="form-table" role="presentation">
                <tbody>
                    <?php foreach (em_theme_get_banner_setting_fields() as $key => $label) : ?>
                        <?php
                        $attachment_id = !empty($settings[$key]) ? absint($settings[$key]) : 0;
                        $preview_url   = $attachment_id ? wp_get_attachment_image_url($attachment_id, 'medium') : '';
                        ?>
                        <tr class="em-theme-banner-field">
                            <th scope="row">
                                <label for="em-theme-banner-<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label>
                            </th>
                            <td>
                                <input
                                    id="em-theme-banner-<?php echo esc_attr($key); ?>"
                                    class="em-theme-banner-id"
                                    type="hidden"
                                    name="em_theme_banner_images[<?php echo esc_attr($key); ?>]"
                                    value="<?php echo esc_attr($attachment_id); ?>"
                                >

                                <button
                                    type="button"
                                    class="button em-theme-upload-banner"
                                    data-title="<?php esc_attr_e('Choose banner image', 'event-management-theme'); ?>"
                                    data-button="<?php esc_attr_e('Use this image', 'event-management-theme'); ?>"
                                >
                                    <?php esc_html_e('Choose Image', 'event-management-theme'); ?>
                                </button>

                                <button type="button" class="button em-theme-remove-banner" <?php disabled(!$attachment_id); ?>>
                                    <?php esc_html_e('Remove', 'event-management-theme'); ?>
                                </button>

                                <div class="em-theme-banner-preview">
                                    <?php if ($preview_url) : ?>
                                        <img src="<?php echo esc_url($preview_url); ?>" alt="" style="max-width: 320px; height: auto; display: block; margin-top: 10px;">
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php submit_button(__('Save Settings', 'event-management-theme')); ?>
        </form>
    </div>
    <?php
}
