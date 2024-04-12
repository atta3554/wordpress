<?php get_header();  ?>

<?php while(have_posts()) : the_post(); pageBanner('', '', ''); ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box rounded d-flex">
                <div class="col-2 d-flex align-items-center justify-content-center bg-primary">
                    <h4 class='my-0'>
                        <a href="<?php echo get_post_type_archive_link('event') ?>"><i class="fa-solid fa-home mx-1"></i>All Events</a>
                    </h4>
                </div>

                <div class="col-2 d-flex align-items-center justify-content-center bg-secondary">
                    <div class="post-meta">
                        <span class="professor-title text-white"><?php the_title() ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="post-container my-5">
                <div class="post-informations"><h2 class="post-title text-center"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2></div>
                <div class="post-thumbnail my-3"><img class='w-100 h-100' src="<?php the_post_thumbnail_url(); ?>" alt="thumbnail"></div>                        
                <div class="post-content"><span class="post-excerpt"><?php the_content(); ?></span></div>
            </div>
        </div>
    </div>

<?php endwhile; ?>
<?php 
if(comments_open()) {
    comments_template();
}
get_footer() ?>
