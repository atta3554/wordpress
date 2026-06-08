<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="col-lg-3 col-sm-6 col-12 my-4 mx-4">
    <article <?php post_class('post-container p-4 border rounded'); ?>>
        <h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
        <div class="post-meta">
            <h4 class="post-date"><?php esc_html_e('Updated on', 'event-management-theme'); ?> <?php echo esc_html(get_the_modified_date()); ?></h4>
        </div>
        <div class="post-content"><span class="post-excerpt"><?php echo esc_html(em_theme_trimmed_excerpt(14)); ?></span></div>
    </article>
</div>
