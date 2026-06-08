<?php
if (!defined('ABSPATH')) {
    exit;
}

$event_date = em_theme_get_event_datetime();
?>
<h2 class="past_event-title my-4 text-center"><?php echo esc_html(get_the_title()); ?></h2>
<div class="past_event-info my-2 d-flex align-items-center justify-content-around">
    <div class="past_event-thumbnail"><?php echo wp_kses_post(em_theme_post_thumbnail('medium', 'past_event-thumbnail__image')); ?></div>
    <div class="past_event-date my-4 d-flex flex-column justify-content-center rounded-circle bg-secondary">
        <?php if ($event_date) : ?>
            <h4 class="event-month text-white text-center"><?php echo esc_html($event_date->format('M')); ?></h4>
            <h4 class="event-date text-white text-center"><?php echo esc_html($event_date->format('d')); ?></h4>
        <?php else : ?>
            <h4 class="event-month text-white text-center"><?php esc_html_e('TBA', 'event-management-theme'); ?></h4>
        <?php endif; ?>
    </div>
</div>
<div class="past_event-excerpt text-center my-4"><?php echo esc_html(em_theme_trimmed_excerpt(18)); ?></div>
<div class="text-center d-flex justify-content-center read-more"><a class="py-3 px-5 rounded bg-primary" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read More', 'event-management-theme'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
