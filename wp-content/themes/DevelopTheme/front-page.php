<?php

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

get_header(); 

?>

<div id="main-slider">
    <div class="camera_wrap">
        <div data-thumb="<?php echo get_theme_file_uri() . '/assets/camera/slides/thumbs/bridge.jpg'; ?>" data-src="<?php echo get_theme_file_uri() . '/assets/camera/slides/bridge.jpg'; ?>"></div>
        <div data-thumb="<?php echo get_theme_file_uri() . '/assets/camera/slides/thumbs/leaf.jpg'; ?>" data-src="<?php echo get_theme_file_uri() . '/assets/camera/slides/leaf.jpg'; ?>"></div>
        <div data-thumb="<?php echo get_theme_file_uri() . '/assets/camera/slides/thumbs/road.jpg'; ?>" data-src="<?php echo get_theme_file_uri() . '/assets/camera/slides/road.jpg'; ?>"></div>
        <div data-thumb="<?php echo get_theme_file_uri() . '/assets/camera/slides/thumbs/sea.jpg'; ?>" data-src="<?php echo get_theme_file_uri() . '/assets/camera/slides/sea.jpg'; ?>"></div>
        <div data-thumb="<?php echo get_theme_file_uri() . '/assets/camera/slides/thumbs/shelter.jpg'; ?>" data-src="<?php echo get_theme_file_uri() . '/assets/camera/slides/shelter.jpg'; ?>"></div>
        <div data-thumb="<?php echo get_theme_file_uri() . '/assets/camera/slides/thumbs/tree.jpg'; ?>" data-src="<?php echo get_theme_file_uri() . '/assets/camera/slides/tree.jpg'; ?>"></div>
    </div>
</div>

<script>
    jQuery('.camera_wrap').camera({
        pagination: false,
        thumbnails: true,
        height: '40%'
        
    });
</script>

<div class="container-fluid most-post-types">
    <div class="row">
        <div class="col-12 col-md most-professors bg-secondary py-5">
            <h3 class='text-center mb-4'>From our Professors</h3>
            <?php $homeProfessors = new WP_Query(array(
                'posts_per_page'=> -1,
                'post_type'=>'professor',
                'meta_key'=> 'professor_education', 
                'orderby'=> 'meta_value',
                'order'=> 'ASC',
                'meta_query'=> array(
                    array(
                        'key'=> 'professor_education',
                        'compare'=> '>',
                        'value'=> 'Bachelor'
                        )
                    )
                ));
            while($homeProfessors->have_posts()) : $homeProfessors->the_post(); ?>
                <div class="row my-3">
                    <div class="col-3 d-flex justify-content-center">
                        <div class="post-info d-flex flex-column justify-content-center rounded-circle align-items-center pb-2 bg-warning text-center">
                            <span class="professor-degree">Degree:</span>
                            <span class="professor-degree"><a href="<?php echo get_the_permalink() ?>"><?php the_field('professor_education'); ?></a></span>
                        </div>
                    </div>

                    <div class="col-9">
                        <h6 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h6>
                        <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt() , 10); ?> <span class="read-more"><a class='text-danger text-nowrap' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></span></p>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
            <div class="all-professors text-center my-3"><a class='btn px-4 py-2 bg-primary text-white' href="<?php echo get_post_type_archive_link('professor') ?> ">View All professors</a></div>
        </div>

        <div class="col-12 col-md most-posts bg-warning py-5">
            <h3 class='text-center mb-4'>From our Blog</h3>
            <?php $homePosts = new WP_Query(array('posts_per_page' => 2)); while($homePosts->have_posts()) : $homePosts->the_post() ?>
                <div class="row my-3">
                    <div class="col-3 d-flex justify-content-center">
                        <div class="post-info d-flex flex-column justify-content-center rounded-circle bg-secondary text-center">
                            <span class="published-month text-white fs-4"><?php the_time('m') ?></span>
                            <span class="published-day text-white fs-4"><?php the_time('d') ?></span>
                        </div>
                    </div>

                    <div class="col-9">
                        <h6 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h6>
                        <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt() , 10); ?> <span class="read-more"><a class='text-danger text-nowrap' href="<?php the_permalink() ?>">Read More <i class="fa-solid fa-arrow-right"></i></a></span></p>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
            <div class="all-posts text-center my-3"><a class='btn px-4 py-2 bg-primary text-white' href="<?php the_permalink(12); ?>">View All Posts</a></div>
        </div>
    </div>


</div>

<div class="container-fluid animation-container px-0">
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="row first-hover_animation justify-content-center align-items-center">
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
        <div class="hexagon"></div>
    </div>
    <div class="position-absolute d-flex first-hover_animation-text inset-0 align-items-center justify-content-center">
        <h2 class="text-center text-white">Are you Ready?!</h2>
    </div>
</div>


<?php get_footer() ?>
