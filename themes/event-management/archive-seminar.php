<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner(__('Seminars', 'event-management-theme'), __('Get practical learning from our expert sessions', 'event-management-theme'));
?>

<div class="container border rounded submain py-5">
    <div class="row justify-content-center">
        <?php if (have_posts()) : ?>
            <?php while(have_posts()) : the_post(); ?>
                <?php get_template_part('template-part/content', get_post_type()); ?>
            <?php endwhile; ?>
        <?php else : ?>
            <p class="text-center"><?php esc_html_e('No seminars have been added yet.', 'event-management-theme'); ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-12 text-center"><?php em_theme_render_pagination(); ?></div></div>
</div>

<?php get_footer(); ?>
