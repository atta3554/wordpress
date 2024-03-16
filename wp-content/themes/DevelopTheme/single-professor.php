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
// print_r($currentUserLike->posts);

// if ($currentUserLike) echo $currentUserLike;
// print_r($currentUserLike->posts[0]->ID);
// echo get_post_field('post_author', $currentUserLike->posts[0]->ID);
// echo get_current_user_id();
// echo get_post_type($currentUserLike->posts[0]->ID);
wp_reset_postdata();

?>




<?php while(have_posts()) : the_post(); ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box rounded d-flex">
                <div class="col-2 d-flex align-items-center justify-content-center bg-primary">
                    <h4 class='my-0'>
                        <a href="<?php echo get_post_type_archive_link('professor') ?>"><i class="fa-solid fa-home mx-1"></i>All professors</a>
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
            <div class="post-information mt-5">
                <div class="row">
                    <div class="col-4">
                        <span class='bg-warning px-4 py-2'>Seminars :
                            <?php while($eventsSeminars->have_posts()) : $eventsSeminars->the_post(); ?>
                                <a href="<?php the_permalink() ?>"><?php echo get_the_title() ?></a>,
                            <?php endwhile; wp_reset_postdata(); ?>
                        </span>
                    </div>
                    <div class="col-4">
                        <div class="post-informations"><h2 class="post-title text-center"><?php the_title() ?></h2></div>
                    </div>
                    <div class="col-4">

                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-9">
                <div class="post-content"><span class="post-excerpt"><?php the_content(); ?></span><span class="mx-4 read-more"></span></div>
            </div>

            <div class="col-3">
                <div class="professor-likes d-flex justify-content-end" data-like='<?php if($currentUserLike) if($currentUserLike->posts) echo $currentUserLike->posts[0]->ID; ?>' data-exist=<?php echo $existLike ?> data-professor=<?php the_ID(); ?>>
                    <div class="like-area px-3 py-2" role='button'>
                        <span class="like-btn">
                            <i class="fa <?php if($existLike== 'no') echo 'fa-heart-o';
                             else echo 'fa-heart'; ?> text-danger"></i> 
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
