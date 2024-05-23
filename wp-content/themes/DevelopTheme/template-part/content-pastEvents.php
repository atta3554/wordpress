<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

$timeFormat = new DateTime(get_field('event_date')); 
?>

<h2 class="past_event-title my-4 text-center"><?php the_title(); ?></h2>
<div class="past_event-info my-2 d-flex align-items-center justify-content-around">
    <img class='past_event-thumbnail' src="<?php the_post_thumbnail_url('medium'); ?>" alt="">
    <div class="past_event-date my-4 d-flex flex-column justify-content-center rounded-circle bg-secondary">
        <h4 class="event-month text-white text-center"><?php echo $timeFormat->format('M'); ?></h4>
        <h4 class="event-date text-white text-center"><?php echo $timeFormat->format('d'); ?></h4>
    </div>
</div>
<div class="past_event-excerpt text-center my-4"><?php echo (has_excerpt()) ? the_excerpt() : wp_trim_words(get_the_content(), 10) ?></div>
<div class="text-center d-flex justify-content-center read-more"><a class='py-3 px-5 rounded bg-primary' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></div>
