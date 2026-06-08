<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="col-lg-3 col-sm-6 col-12 my-4 mx-4">
    <article <?php post_class('post-container p-4 border rounded'); ?>>
        <h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
        <div class="post-tags my-3 d-flex justify-content-between">
            <?php the_tags('<span class="tag bg-secondary px-2">', '<i class="fa-solid fa-tag pl-2" aria-hidden="true"></i></span><span class="tag bg-secondary px-2">', '<i class="fa-solid fa-tag" aria-hidden="true"></i></span>'); ?>
        </div>
        <div class="post-meta">
            <h4 class="post-author"><?php esc_html_e('Written by:', 'event-management-theme'); ?> <?php the_author_posts_link(); ?></h4>
            <h4 class="post-date"><?php esc_html_e('Published on', 'event-management-theme'); ?> <?php echo esc_html(get_the_date()); ?></h4>
        </div>
        <div class="post-categories bg-warning px-4 py-2 text-center"><?php echo wp_kses_post(get_the_category_list(',')); ?></div>
        <div class="post-thumbnail my-3">
            <?php echo wp_kses_post(em_theme_post_thumbnail('medium_large')); ?>
        </div>
        <div class="post-content">
            <span class="post-excerpt"><?php echo esc_html(em_theme_trimmed_excerpt(14)); ?></span>
            <span class="mx-4 read-more"><a class="text-danger text-nowrap" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read More', 'event-management-theme'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></span>
        </div>
    </article>
</div>
