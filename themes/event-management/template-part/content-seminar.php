<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="col-9 col-sm-6 col-lg-3 my-4">
    <article <?php post_class('post-container p-4'); ?>>
        <h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
        <div class="post-thumbnail my-3"><?php echo wp_kses_post(em_theme_post_thumbnail('medium_large')); ?></div>
        <div class="post-content">
            <span class="post-excerpt"><?php echo esc_html(em_theme_trimmed_excerpt(14)); ?></span>
            <span class="mx-1 read-more"><a class="text-danger text-nowrap" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read More', 'event-management-theme'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></span>
        </div>
    </article>
</div>
