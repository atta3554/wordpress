<?php
get_header();?>

<?php while(have_posts()) : the_post(); pageBanner('', '', ''); ?>
<div class="container">
    <div class="row">
        <div class="single-child-box rounded d-flex">
            <div class="col-6 col-sm-4 col-lg-3 d-flex align-items-center justify-content-center bg-primary">
                <h4 class='my-0'>
                    <a href="<?php echo get_post_type_archive_link('seminar') ?>"><i class="fa-solid fa-home mx-1"></i>All seminars</a>
                </h4>
            </div>
            
            <div class="col-6 col-sm-4 col-lg-3 d-flex align-items-center justify-content-center bg-secondary">
                <div class="post-meta">
                    <span class="professor-title text-white"><?php the_title() ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row my-5">
            <?php $seminarProfessor = get_field('seminar_professor'); ?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="seminar-informations my-2 d-flex flex-column align-items-center position-sticky bg-dark px-sm-3 px-md-4 px-2 pb-1 rounded">
                        <h2 class='post-title text-center text-white py-2'><?php echo get_the_title() ?></h2>
                        <div class="featured-image"><img class='w-100 h-100' src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="thumbnail"></div>
                        <?php if($seminarProfessor) : ?>
                        <span class='ms-2 d-flex text-white my-3'>Professors : <br></span>
                        <div class="w-100 row justify-content-center">
                            <?php foreach($seminarProfessor as $s) :?> 
                                <div class="col-5 position-relative p-0 mx-1 my-2">
                                    <a class='seminar-professor-informations overflow-hidden w-100 d-flex' href="<?php echo get_the_permalink($s) ?>">
                                        <img class='seminar-professor-image w-100 h-100' src="<?php echo get_the_post_thumbnail_url($s) ?>" alt="">
                                        <span class="seminar-professor-title position-absolute bottom-0 start-0 end-0 text-center"><?php echo get_the_title($s) ?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif;?>
                        <a class='w-100 mx-auto my-4 py-2 px-4 justify-content-center d-flex rounded bg-primary align-items-center' href="#">Buy Ticket <i class="ms-2 fa-solid fa-cart-shopping"></i></a>
                    </div>
                </div>
                <div class="col-12 seminar-content col-sm-6 col-lg-9"><?php echo get_the_content() ?></div>
    </div>


</div>

<?php endwhile; ?>

<?php
if(comments_open()) {
    comments_template();
}
get_footer() ?>