<?php

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

get_header(); 

pageBanner('Past Events', "hope don't losse any event again", '');

$today = date('Ymd');
$pastEvents = new WP_Query(array(
    'paged'=> get_query_var('paged' , 1),
    'post_type'=>'event', 
    'meta_key'=> 'event_date', 
    'orderby'=> 'meta_value_num', 
    'order'=> 'ASC', 
    'meta_query'=> array(array(
        'key'=> 'event_date',
        'compare'=> '<',
        'type'=> 'NUMERIC',
        'value'=> $today
    ))
)); 
?>

<div class="container rounded my-5 main py-5 d-flex">
    <div class="swiper">
        <div class="swiper-wrapper mb-0 mb-md-5">
            <?php while($pastEvents->have_posts()) {
                $pastEvents->the_post(); ?>
                <div class="swiper-slide border rounded"><?php get_template_part('template-part/content', 'pastEvents'); ?></div>
            <?php } ?>
        </div>
        <div class="swiper-pagination"></div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</div>


<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-6 text-center"><?php echo paginate_links(array(
        'total'=> $pastEvents->max_num_pages,
        '   '   
    )); ?></div></div>
</div>


<?php get_footer() ?>


