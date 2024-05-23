<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

get_header(); 
pageBanner('Events', "keep Update with Us to don't loose our Events", ''); 
?>


<div class="container rounded my-5 main py-5">
    <?php while(have_posts()) : ?>
        <div class="row border rounded justify-content-center my-5 p-4">
            <?php 
            the_post(); 
            get_template_part('template-part/content', get_post_type());
            ?>
        </div>
    <?php endwhile; ?>

    <div class="row">
        <div class="all-past-events text-center"> search for past events? <a class='text-danger text-nowrap' href="<?php echo site_url('/past-events') ?>">See All past Events <i class="fa-solid fa-arrow-right"></i></a></div>
    </div>
    
</div>


<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-6 text-center"><?php echo paginate_links(); ?></div></div>
</div>


<?php get_footer() ?>


