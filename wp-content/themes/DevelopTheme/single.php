<?php get_header(); ?>
<?php while(have_posts()) : the_post(); pageBanner('', '', ''); ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box rounded p-0 d-flex">
                <div class="col-3 col-sm-2 d-flex align-items-center justify-content-center bg-primary">
                    <h4 class='my-0'>
                        <a href="<?php echo site_url('Blog') ?>"><i class="fa-solid fa-home mx-1"></i><?php echo get_the_title(12) ?></a>
                    </h4>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 col-9 d-flex align-items-center justify-content-center bg-secondary">
                    <div class="post-meta">
                        <span class="post-author">writed By : <?php the_author_posts_link() ?></span><span class="post-date"> Published On <?php the_time('y.m.d') ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="post-container my-5">
                <div class="post-informations d-flex flex-column flex-sm-row justify-content-between">
                    <div class="post-tags d-flex justify-content-between"><?php the_tags('<span class="tag bg-secondary p-1 p-sm-2">' , '<i class="fa-solid fa-tag pl-2"></i></span><span class="tag bg-secondary p-1 p-sm-2">' ,'<i class="fa-solid fa-tag"></i></span>') ?></div>
                    <h2 class="post-title text-center"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                    <div class="post-categories bg-warning px-2 px-sm-4 py-2 text-center"><?php echo get_the_Category_list(',') ?></div>
                </div>
                <div class="post-thumbnail my-3"><img class='w-100 h-100' src="<?php the_post_thumbnail_url(); ?>" alt="thumbnail"></div>                        
                <div class="post-content"><?php the_content(); ?></div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php get_footer() ?>
