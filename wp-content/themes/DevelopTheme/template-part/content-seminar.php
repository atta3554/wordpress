<?php if(! defined('ABSPATH')) exit;  //Exit if accessed directly ?>

<div class="col-9 col-sm-6 col-lg-3 my-4 ">
    <div class="post-container p-4">
        <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
        <div class="post-thumbnail my-3"><img class='w-100 h-100' src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="thumbnail"></div>                        
        <div class="post-content"><span class="post-excerpt"><?php if(has_excerpt()) echo wp_trim_words(get_the_excerpt() , 10); else echo wp_trim_words(get_the_content() , 10); ?></span> <span class="mx-1 read-more"><a class='text-danger text-nowrap' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></span></div>
    </div>
</div>