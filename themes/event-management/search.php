<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner(__('Search Results', 'event-management-theme'), sprintf(__('Results for "%s"', 'event-management-theme'), get_search_query()), '');

$results_by_type = array(
    'professor' => array(),
    'event'     => array(),
    'seminar'   => array(),
    'post'      => array(),
    'page'      => array(),
);

while (have_posts()) {
    the_post();
    $post_type = get_post_type();
    if (isset($results_by_type[$post_type])) {
        $results_by_type[$post_type][] = get_the_ID();
    }
}
rewind_posts();

$sections = array(
    'professor' => __('From Our Professors', 'event-management-theme'),
    'event'     => __('From Our Events', 'event-management-theme'),
    'seminar'   => __('From Our Seminars', 'event-management-theme'),
    'post'      => __('From Our Blog', 'event-management-theme'),
    'page'      => __('From Our Pages', 'event-management-theme'),
);
?>

<div class="container">
    <?php if (array_filter($results_by_type)) : ?>
        <?php foreach ($sections as $post_type => $section_title) : ?>
            <?php if (!$results_by_type[$post_type]) { continue; } ?>
            <div class="row my-5 justify-content-center">
                <h2 class="post-title text-center"><?php echo esc_html($section_title); ?></h2>
                <?php
                foreach ($results_by_type[$post_type] as $result_id) {
                    $GLOBALS['post'] = get_post($result_id);
                    setup_postdata($GLOBALS['post']);

                    if ('event' === $post_type) {
                        echo '<div class="row">';
                        get_template_part('template-part/content', $post_type);
                        echo '</div>';
                    } else {
                        get_template_part('template-part/content', $post_type);
                    }
                }
                wp_reset_postdata();
                ?>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="text-center my-5"><?php esc_html_e('Nothing matches your search.', 'event-management-theme'); ?></p>
    <?php endif; ?>
</div>

<?php
get_search_form();
get_footer();
?>
