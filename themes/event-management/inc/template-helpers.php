<?php
/**
 * Small template helpers used throughout the theme.
 *
 * @package EventManagementTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

function em_theme_get_field($selector, $post_id = false)
{
    if (function_exists('get_field')) {
        return get_field($selector, $post_id);
    }

    $post_id = $post_id ? $post_id : get_the_ID();

    return get_post_meta($post_id, $selector, true);
}

function em_theme_the_field($selector, $post_id = false)
{
    echo esc_html(em_theme_get_field($selector, $post_id));
}

function em_theme_asset_version($relative_path)
{
    $path = get_theme_file_path($relative_path);

    return file_exists($path) ? (string) filemtime($path) : wp_get_theme()->get('Version');
}

function em_theme_get_archive_url($post_type, $fallback = '/')
{
    $url = get_post_type_archive_link($post_type);

    return $url ? $url : home_url($fallback);
}

function em_theme_get_professor_fields($post_id = null, $linked = false)
{
    $post_id = $post_id ? $post_id : get_the_ID();
    $terms = get_the_terms($post_id, 'professor_field');

    if (!is_wp_error($terms) && !empty($terms)) {
        if (!$linked) {
            return implode(', ', wp_list_pluck($terms, 'name'));
        }

        $links = array();

        foreach ($terms as $term) {
            $term_link = get_term_link($term);

            if (is_wp_error($term_link)) {
                continue;
            }

            $links[] = sprintf(
                '<a class="professor-field-link" href="%s">%s</a>',
                esc_url($term_link),
                esc_html($term->name)
            );
        }

        return implode(esc_html__(', ', 'event-management-theme'), $links);
    }

    $legacy_field = em_theme_get_field('professor_field', $post_id);

    return is_string($legacy_field) ? $legacy_field : '';
}

function em_theme_get_event_datetime($post_id = null)
{
    $post_id = $post_id ? $post_id : get_the_ID();
    $raw_date = em_theme_get_field('event_date', $post_id);

    if (!$raw_date) {
        return null;
    }

    if (is_numeric($raw_date)) {
        $date = DateTime::createFromFormat('Ymd', (string) $raw_date);
    } else {
        try {
            $date = new DateTime((string) $raw_date);
        } catch (Exception $exception) {
            $date = false;
        }
    }

    return $date instanceof DateTime ? $date : null;
}

function em_theme_post_thumbnail($size = 'large', $classes = 'w-100 h-100', $post_id = null)
{
    $post_id = $post_id ? $post_id : get_the_ID();

    if (!has_post_thumbnail($post_id)) {
        return '<div class="post-thumbnail__placeholder d-flex align-items-center justify-content-center text-center bg-warning text-muted">'
            . esc_html__('No image available', 'event-management-theme')
            . '</div>';
    }

    return get_the_post_thumbnail(
        $post_id,
        $size,
        array(
            'class' => $classes,
            'alt'   => the_title_attribute(
                array(
                    'echo' => false,
                    'post' => $post_id,
                )
            ),
        )
    );
}

function em_theme_trimmed_excerpt($words = 18, $post_id = null)
{
    $post_id = $post_id ? $post_id : get_the_ID();
    $excerpt = has_excerpt($post_id) ? get_the_excerpt($post_id) : get_post_field('post_content', $post_id);

    return wp_trim_words(wp_strip_all_tags($excerpt), $words);
}

function em_theme_render_pagination($args = array())
{
    $links = paginate_links($args);

    if ($links) {
        echo wp_kses_post($links);
    }
}
