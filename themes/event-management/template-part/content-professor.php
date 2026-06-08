<?php
if (!defined('ABSPATH')) {
    exit;
}

$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
?>
<div class="col-12 col-sm-9 col-md-3 my-4 mx-2 mx-sm-3 mx-md-2">
    <article <?php post_class('professor-container position-relative p-4 border rounded'); ?> <?php if ($thumbnail_url) : ?>style="background-image: url('<?php echo esc_url($thumbnail_url); ?>')"<?php endif; ?>>
        <?php if (!$thumbnail_url) : ?>
            <div class="post-thumbnail__placeholder d-flex align-items-center justify-content-center h-100 text-muted"><?php esc_html_e('No image available', 'event-management-theme'); ?></div>
        <?php endif; ?>
        <div class="post-overlay d-flex justify-content-center align-items-end">
            <h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
            <span class="ms-2 mb-2 text-center read-more"><a class="text-primary" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read More', 'event-management-theme'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></span>
        </div>
    </article>
</div>
