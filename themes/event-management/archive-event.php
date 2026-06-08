<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner(__('Events', 'event-management-theme'), __("Keep updated with our upcoming events", 'event-management-theme'));
?>

<div class="container rounded my-5 main py-5">
    <?php if (have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>
            <div class="row border rounded justify-content-center my-5 p-4">
                <?php get_template_part('template-part/content', get_post_type()); ?>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p class="text-center"><?php esc_html_e('No upcoming events are available yet.', 'event-management-theme'); ?></p>
    <?php endif; ?>

    <div class="row">
        <div class="all-past-events text-center">
            <?php esc_html_e('Looking for past events?', 'event-management-theme'); ?>
            <a class="text-danger text-nowrap" href="<?php echo esc_url(home_url('/past-events/')); ?>"><?php esc_html_e('See all past events', 'event-management-theme'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</div>

<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-12 text-center"><?php em_theme_render_pagination(); ?></div></div>
</div>

<?php get_footer(); ?>
