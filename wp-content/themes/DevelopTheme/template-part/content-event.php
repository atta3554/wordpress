    <div class="col-12 col-sm-9"> 
        <div class="post-container d-flex flex-column align-items-center align-items-lg-start">
            <h3 class="post-title text-center text-md-start"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <div class="post-thumbnail col-12 col-sm-9 col-lg-4 my-3"><img class='w-100 h-100' src="<?php the_post_thumbnail_url(); ?>" alt="thumbnail"></div>                        
            <div class="post-excerpt col-12 col-sm-9 col-lg-4"><p class="post-excerpt mb-4"><?php if(has_excerpt()) {echo wp_trim_words(get_the_excerpt() , 10);} else {echo wp_trim_words(get_the_content() , 10);} ?></p></div>
            <div class=" py-3 px-4 col-12 col-sm-9 col-lg-4 text-center bg-primary read-more"><a class='text-nowrap' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></div>
        </div>
    </div>
    
    <?php $timeFormat = new DateTime(get_field('event_date')); ?>
    <div class="col-6 col-sm-3 my-4 d-flex align-items-center">
        <div class="event-date px-5 py-4 rounded-circle bg-warning">
            <h4 class="event-month text-white text-center"><?php echo $timeFormat->format('M'); ?></h4>
            <h4 class="event-date text-white text-center"><?php echo $timeFormat->format('d'); ?></h4>
        </div>
    </div>

    