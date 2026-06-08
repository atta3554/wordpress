<?php
/*
Template Name: Past Events
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner(__('Past Events', 'event-management-theme'), __("Review the events you may have missed", 'event-management-theme'), '');

$today       = current_time('Ymd');
$paged       = max(1, (int) get_query_var('paged'));
$past_events = new WP_Query(array(
    'paged'      => $paged,
    'post_type'  => 'event',
    'post_status'=> 'publish',
    'meta_key'   => 'event_date',
    'orderby'    => 'meta_value_num',
    'order'      => 'DESC',
    'meta_query' => array(array(
        'key'     => 'event_date',
        'compare' => '<',
        'type'    => 'NUMERIC',
        'value'   => $today,
    )),
)); 
?>

<div class="container rounded my-5 main py-5 d-flex">
    <?php if ($past_events->have_posts()) : ?>
        <div class="swiper legacy-events-swiper">
            <div class="swiper-wrapper mb-0 mb-md-5">
                <?php while($past_events->have_posts()) : $past_events->the_post(); ?>
                    <div class="swiper-slide border rounded"><?php get_template_part('template-part/content', 'pastEvents'); ?></div>
                <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    <?php else : ?>
        <p class="text-center w-100"><?php esc_html_e('No past events are available yet.', 'event-management-theme'); ?></p>
    <?php endif; ?>
</div>

<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-12 text-center"><?php em_theme_render_pagination(array('total' => $past_events->max_num_pages, 'current' => $paged)); ?></div></div>
</div>

<?php
wp_reset_postdata();
get_footer();
?>
