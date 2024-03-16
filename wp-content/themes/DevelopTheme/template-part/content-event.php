    <div class="col-9">
        <div class="post-container">
            <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
            <!-- <div class="post-tags my-3 d-flex justify-content-between"> <?php /* the_tags('<span class="tag bg-secondary px-2">' , '<i class="fa-solid fa-tag pl-2"></i></span><span class="tag bg-secondary px-2">' ,'<i class="fa-solid fa-tag"></i></span>') */ ?></div>
            <div class="post-meta"><h4 class="post-author">writed By : <?php /* the_author_posts_link() */ ?></h4><h4 class="post-date">Published On <?php /* the_time('y.m.d') */ ?></h4></div>
            <div class="post-categories bg-warning px-4 py-2 text-center"><?php /* echo get_the_Category_list(',')  */ ?></div> --> 
            <div class="post-thumbnail my-3 w-25 h-25"><img class='w-100 h-100' src="<?php the_post_thumbnail_url(); ?>" alt="thumbnail"></div>                        
            <div class="post-excerpt"><p class="post-excerpt mb-4"><?php if(has_excerpt()) {echo wp_trim_words(get_the_excerpt() , 10);} else {echo wp_trim_words(get_the_content() , 10);} ?></p></div>
            <div class="mx-4 py-3 px-4 w-25 text-center bg-primary read-more"><a class='text-nowrap' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></div>
        </div>
    </div>
    
    <?php $timeFormat = new DateTime(get_field('event_date')); ?>
    <div class="col-3 d-flex align-items-center">
        <div class="event-date px-5 py-4 rounded-circle bg-warning">
            <h4 class="event-month text-white text-center"><?php echo $timeFormat->format('M'); ?></h4>
            <h4 class="event-date text-white text-center"><?php echo $timeFormat->format('d'); ?></h4>
        </div>
    </div>

    