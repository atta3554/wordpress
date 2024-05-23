<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

get_header(); 
pageBanner('seminars', 'get the best practices for your field', '');?>

    <div class="container border rounded submain py-5">
        <div class="row justify-content-center">
            <?php while(have_posts()) {
                the_post();
                get_template_part('template-part/content', get_post_type());
            } ?>
        </div>
    </div>


<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-6 text-center"><?php echo paginate_links(); ?></div></div>
</div>


<?php get_footer() ?>