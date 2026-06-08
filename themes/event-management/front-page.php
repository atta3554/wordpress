<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

$today = current_time('Ymd');

$upcoming_events = new WP_Query(array(
    'post_type'      => 'event',
    'post_status'    => 'publish',
    'posts_per_page' => 5,
    'meta_key'       => 'event_date',
    'orderby'        => 'meta_value_num',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'     => 'event_date',
            'compare' => '>=',
            'value'   => $today,
            'type'    => 'NUMERIC',
        ),
    ),
));

$featured_professors = new WP_Query(array(
    'post_type'      => 'professor',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$featured_seminars = new WP_Query(array(
    'post_type'      => 'seminar',
    'post_status'    => 'publish',
    'posts_per_page' => 8,
    'orderby'        => 'date',
    'order'          => 'DESC',
));

$event_fallback_image = function_exists('em_theme_get_asset_banner_image_url') ? em_theme_get_asset_banner_image_url('events.png') : '';
?>

<section class="front-hero position-relative overflow-hidden">
    <canvas class="front-hero__canvas" aria-hidden="true"></canvas>
    <div class="swiper front-events-swiper front-hero__slider">
        <div class="swiper-wrapper">
            <?php if ($upcoming_events->have_posts()) : ?>
                <?php while($upcoming_events->have_posts()) : $upcoming_events->the_post(); ?>
                    <?php
                    $event_date = em_theme_get_event_datetime();
                    $image_url  = get_the_post_thumbnail_url(get_the_ID(), 'page_banner_size') ?: $event_fallback_image;
                    ?>
                    <article class="swiper-slide front-hero__slide" <?php if ($image_url) : ?>style="background-image: url('<?php echo esc_url($image_url); ?>');"<?php endif; ?>>
                        <div class="front-hero__shade"></div>
                        <div class="container front-hero__content">
                            <div class="front-hero__meta">
                                <?php if ($event_date) : ?>
                                    <span><?php echo esc_html($event_date->format('M d')); ?></span>
                                <?php endif; ?>
                                <span><?php esc_html_e('Upcoming Event', 'event-management-theme'); ?></span>
                            </div>
                            <h1 class="front-hero__title"><?php echo esc_html(get_the_title()); ?></h1>
                            <p class="front-hero__excerpt"><?php echo esc_html(em_theme_trimmed_excerpt(22)); ?></p>
                            <a class="front-hero__link" href="<?php echo esc_url(get_permalink()); ?>">
                                <?php esc_html_e('View Event', 'event-management-theme'); ?>
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <article class="swiper-slide front-hero__slide" <?php if ($event_fallback_image) : ?>style="background-image: url('<?php echo esc_url($event_fallback_image); ?>');"<?php endif; ?>>
                    <div class="front-hero__shade"></div>
                    <div class="container front-hero__content">
                        <div class="front-hero__meta"><span><?php esc_html_e('Upcoming Events', 'event-management-theme'); ?></span></div>
                        <h1 class="front-hero__title"><?php echo esc_html(get_bloginfo('name')); ?></h1>
                        <p class="front-hero__excerpt"><?php esc_html_e('New events will appear here as soon as they are published.', 'event-management-theme'); ?></p>
                        <a class="front-hero__link" href="<?php echo esc_url(em_theme_get_archive_url('event', '/events/')); ?>">
                            <?php esc_html_e('Browse Events', 'event-management-theme'); ?>
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>
            <?php endif; ?>
        </div>
        <div class="front-hero__controls">
            <button class="front-hero__nav front-events-prev" type="button" aria-label="<?php esc_attr_e('Previous event', 'event-management-theme'); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
            <div class="front-events-pagination"></div>
            <button class="front-hero__nav front-events-next" type="button" aria-label="<?php esc_attr_e('Next event', 'event-management-theme'); ?>"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
        </div>
    </div>
</section>

<section class="front-featured front-featured--professors">
    <div class="container">
        <div class="front-section-heading">
            <h2><?php esc_html_e('Featured Professors', 'event-management-theme'); ?></h2>
            <a href="<?php echo esc_url(em_theme_get_archive_url('professor', '/professors/')); ?>"><?php esc_html_e('View All', 'event-management-theme'); ?></a>
        </div>

        <div class="swiper front-featured-swiper front-professors-swiper">
            <div class="swiper-wrapper">
                <?php if ($featured_professors->have_posts()) : ?>
                    <?php while($featured_professors->have_posts()) : $featured_professors->the_post(); ?>
                        <article class="swiper-slide front-card front-card--professor">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="front-card__media">
                                <?php echo wp_kses_post(em_theme_post_thumbnail('medium_large', 'front-card__image')); ?>
                            </a>
                            <div class="front-card__body">
                                <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                                <p>
                                  <strong><?php echo em_theme_get_professor_fields(get_the_ID(), true) ?: 'N/A'; ?></strong>
                                </p>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="front-featured-controls">
                <button class="front-featured-nav front-professors-prev" type="button" aria-label="<?php esc_attr_e('Previous professor', 'event-management-theme'); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
                <div class="front-featured-pagination front-professors-pagination"></div>
                <button class="front-featured-nav front-professors-next" type="button" aria-label="<?php esc_attr_e('Next professor', 'event-management-theme'); ?>"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</section>

<section class="front-featured front-featured--seminars">
    <div class="container">
        <div class="front-section-heading">
            <h2><?php esc_html_e('Featured Seminars', 'event-management-theme'); ?></h2>
            <a href="<?php echo esc_url(em_theme_get_archive_url('seminar', '/seminars/')); ?>"><?php esc_html_e('View All', 'event-management-theme'); ?></a>
        </div>

        <div class="swiper front-featured-swiper front-seminars-swiper">
            <div class="swiper-wrapper">
                <?php if ($featured_seminars->have_posts()) : ?>
                    <?php while($featured_seminars->have_posts()) : $featured_seminars->the_post(); ?>
                        <article class="swiper-slide front-card front-card--seminar">
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="front-card__media">
                                <?php echo wp_kses_post(em_theme_post_thumbnail('medium_large', 'front-card__image')); ?>
                            </a>
                            <div class="front-card__body">
                                <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                                <p><?php echo esc_html(em_theme_trimmed_excerpt(14)); ?></p>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="front-featured-controls">
                <button class="front-featured-nav front-seminars-prev" type="button" aria-label="<?php esc_attr_e('Previous seminar', 'event-management-theme'); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
                <div class="front-featured-pagination front-seminars-pagination"></div>
                <button class="front-featured-nav front-seminars-next" type="button" aria-label="<?php esc_attr_e('Next seminar', 'event-management-theme'); ?>"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
