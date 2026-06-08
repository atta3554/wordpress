<?php
if (!defined('ABSPATH')) {
    exit;
}

$event_date = em_theme_get_event_datetime();
?>
<div class="col-12 col-sm-9"> 
    <div class="post-container d-flex flex-column align-items-center align-items-lg-start">
        <h3 class="post-title text-center text-md-start"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
        <div class="post-thumbnail col-12 col-sm-9 col-lg-4 my-3"><?php echo wp_kses_post(em_theme_post_thumbnail('medium_large')); ?></div>
        <div class="post-excerpt col-12 col-sm-9 col-lg-4"><p class="post-excerpt mb-4"><?php echo esc_html(em_theme_trimmed_excerpt(16)); ?></p></div>
        <div class="py-3 px-4 col-12 col-sm-9 col-lg-4 text-center bg-primary read-more"><a class="text-nowrap" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read More', 'event-management-theme'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
    </div>
</div>

<div class="col-6 col-sm-3 my-4 d-flex align-items-center">
    <div class="event-date px-5 py-4 rounded-circle bg-warning">
        <?php if ($event_date) : ?>
            <h4 class="event-month text-white text-center"><?php echo esc_html($event_date->format('M')); ?></h4>
            <h4 class="event-date text-white text-center"><?php echo esc_html($event_date->format('d')); ?></h4>
        <?php else : ?>
            <h4 class="event-month text-white text-center"><?php esc_html_e('TBA', 'event-management-theme'); ?></h4>
        <?php endif; ?>
    </div>
</div>
