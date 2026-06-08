<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner(__('Professors', 'event-management-theme'), __('Meet the people leading our seminars and events', 'event-management-theme'));
?>

<div class="container rounded my-5 main py-5">
    <h1 class="text-center"><?php esc_html_e('From our professors', 'event-management-theme'); ?></h1>
    <div class="row justify-content-center">
        <?php if (have_posts()) : ?>
            <?php while(have_posts()) : the_post(); ?>
                <?php get_template_part('template-part/content', 'professor'); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center"><?php esc_html_e('No professors have been added yet.', 'event-management-theme'); ?></p>
        <?php endif; ?>
    </div>
    <p class="text-center"><?php esc_html_e('Open each professor profile to view their information and seminars.', 'event-management-theme'); ?></p>
</div>

<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-12 text-center"><?php em_theme_render_pagination(); ?></div></div>
</div>

<?php get_footer(); ?>
