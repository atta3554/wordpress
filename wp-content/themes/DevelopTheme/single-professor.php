<?php get_header(); pageBanner('', '', ''); ?>

<?php
$eventsSeminars = new WP_Query(array(
    'posts_per_page'=> -1,
    'post_type'=> 'seminar',
    'meta_query'=> array(
        array(
            'key'=> 'seminar_professor',
            'compare'=> 'LIKE',
            'value'=> '"' . get_the_ID() . '"',
        )
    )
));
wp_reset_postdata();

$professorLikes = new WP_Query(array(
    'post_type'=> 'like',
    'meta_query'=> array(
        array(
         'key'=> 'professor_like_id',
         'compare'=> '=',
         'value'=> get_the_id()
        )
    )
));
wp_reset_postdata();

$currentUserLike=NULL;
$existLike= 'no';
if(is_user_logged_in()) {

    $currentUserLike = new WP_Query(array(
        'post_type'=> 'like',
        'author'=> get_current_user_id(),
        'meta_query'=> array(
            array(
             'key'=> 'professor_like_id',
             'compare'=> '=',
             'value'=> get_the_id()
            )
        )
    ));

    if($currentUserLike->found_posts) $existLike = 'yes';
}
wp_reset_postdata();

?>




<?php while(have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box p-0 rounded d-flex">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-3 col d-flex align-items-center justify-content-center bg-primary">
                    <h4 class='my-0'>
                        <a href="<?php echo get_post_type_archive_link('professor') ?>"><i class="fa-solid fa-home mx-1"></i>All professors</a>
                    </h4>
                </div>

                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2 col d-flex align-items-center justify-content-center bg-secondary">
                    <div class="post-meta">
                        <span class="professor-title text-white"><?php the_title() ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="post-information mt-5">
                <div class="row justify-content-sm-start justify-content-center align-items-center">
                    <div class="justify-content-center col-9 col-md-3 my-2 d-flex align-items-center">
                        <span class='bg-info px-4 py-2 text-warning'>Seminars :
                            <?php while($eventsSeminars->have_posts()) : $eventsSeminars->the_post(); ?>
                                <a href="<?php the_permalink() ?>"><?php echo get_the_title() ?></a>,
                            <?php endwhile; wp_reset_postdata(); ?>
                        </span>
                    </div>
                    <div class="col-9 col-md-3 my-2">
                        <h2 class="post-title text-center"><?php the_title() ?></h2>
                    </div>
                    <div class="col-12 p-0 col-sm-10 bg-secondary col-md-5 my-2 rounded professor-meta d-flex justify-content-center">
                        <h4 class='p-2 m-0 border-start border-end'><span class='text-white'>field:</span> <?php echo get_field('professor_field') ?></h4>
                        <h4 class='p-2 m-0 border-end'><span class='text-white'>education:</span> <?php echo get_field('professor_education') ?></h4>
                        <h4 class='p-2 m-0 border-end'><span class='text-white'>age:</span> <?php echo get_field('professor_age') ?></h4>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row my-5 flex-column-reverse flex-sm-row">
            <div class="col-9 col-sm-8">
                <div class="post-content"><span class="post-excerpt"><?php the_content(); ?></span><span class="mx-4 read-more"></span></div>
            </div>

            <div class="col-9 col-sm-4">
                <div class="professor-likes d-flex justify-content-end" data-like='<?php if($currentUserLike) if($currentUserLike->posts) echo $currentUserLike->posts[0]->ID; ?>' data-exist=<?php echo $existLike ?> data-professor=<?php the_ID(); ?>>
                    <div class="like-area px-3 py-2" role='button'>
                        <span class="like-btn">
                            <i class="<?php if($existLike== 'no') echo 'fa-regular fa-heart';
                             else echo 'fa-solid fa-heart'; ?> text-danger"></i> 
                        </span>
                        <span class="likes-count text-danger"><?php echo $professorLikes->found_posts ?></span>
                    </div>
                </div>
                <div class="post-thumbnail my-3"><img class='w-100 h-100' src="<?php the_post_thumbnail_url(); ?>" alt="thumbnail"></div>
            </div>
        </div>

    </div>

<?php endwhile; ?>

<?php get_footer() ?>
