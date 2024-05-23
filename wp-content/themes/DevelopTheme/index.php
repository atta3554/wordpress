<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

$counter = 0;
get_header();
pageBanner('Blog', 'find your favorite articles', '');

if($counter < 2) : ?>
    <div class="container border rounded my-5 main py-5">
        <div class="row justify-content-center">
            <?php while(have_posts() and $counter < 2) {
                the_post();
                get_template_part('template-part/content', get_post_type());
                $counter++; 
            } ?>
        </div>
    </div>
<?php endif; ?>


<?php if($counter > 1) : ?>
    <div class="container border rounded submain py-5">
        <div class="row justify-content-center">
            <?php while(have_posts() and $counter > 1 ) {
                the_post();
                get_template_part('template-part/content', get_post_type());
                $counter++; 
            } ?>
        </div>
    </div>
<?php endif; ?>


<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-6 text-center"><?php echo paginate_links(); ?></div></div>
</div>


<?php get_footer() ?>