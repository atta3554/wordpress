<?php get_header(); pageBanner('', '', ''); ?>

<div class="container-fluid most-post-types">
    <div class="row">
        <div class="col most-professors bg-secondary py-5">
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
                        <div class="post-time d-flex flex-column justify-content-center rounded-circle align-items-center pb-2 bg-warning text-center">
                            <span class="professor-degree text-white">Degree:</span>
                            <span class="professor-degree text-white"><a href="<?php echo get_the_permalink() ?>"><?php the_field('professor_education'); ?></a></span>
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

        <div class="col most-posts bg-warning py-5">
            <h3 class='text-center mb-4'>From our Blog</h3>
            <?php $homePosts = new WP_Query(array('posts_per_page' => 2)); while($homePosts->have_posts()) : $homePosts->the_post() ?>
                <div class="row my-3">
                    <div class="col-3 d-flex justify-content-center">
                        <div class="post-time d-flex flex-column justify-content-center rounded-circle bg-secondary text-center">
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

<?php get_footer() ?>
