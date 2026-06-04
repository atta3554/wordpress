<div class="col-lg-3 col-sm-6 col-12 my-4 mx-4">
    <div class="post-container p-4 border rounded">
        <h3 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
        <div class="post-tags my-3 d-flex justify-content-between">
            <?php the_tags('<span class="tag bg-secondary px-2">' , '<i class="fa-solid fa-tag pl-2"></i></span><span class="tag bg-secondary px-2">' ,'<i class="fa-solid fa-tag"></i></span>') ?>
        </div>
        <div class="post-meta">
            <h4 class="post-author">writed By : <?php the_author_posts_link() ?></h4><h4 class="post-date">Published On <?php the_time('y.m.d') ?></h4>
        </div>
        <div class="post-categories bg-warning px-4 py-2 text-center"><?php echo get_the_Category_list(',') ?></div>
        <div class="post-thumbnail my-3">
            <img class='w-100 h-100' src="<?php the_post_thumbnail_url(); ?>" alt="thumbnail">
        </div>
        <div class="post-content">
            <span class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt() , 10); ?></span>
            <span class="mx-4 read-more"><a class='text-danger text-nowrap' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></span>
        </div>
    </div>
</div>