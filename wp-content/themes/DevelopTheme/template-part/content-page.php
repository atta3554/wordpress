<?php if(! defined('ABSPATH')) exit;  //Exit if accessed directly ?>

<div class="col-3 my-4 mx-4">
    <div class="post-container p-4 border rounded">
        <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
        <div class="post-meta"><h4 class="post-author">writed By : <?php the_author_posts_link() ?></h4><h4 class="post-date">Published On <?php the_time('y.m.d') ?></h4></div>
        <div class="post-content"><span class="post-excerpt"><?php echo wp_trim_words(get_the_content() , 10); ?></span></div>
    </div>
</div>