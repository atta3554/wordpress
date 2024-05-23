<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

get_header();
pageBanner('Search Results', 'Found your Search Results through our website', '');
?>
<div class="container">
    <?php 
    if(have_posts()) { ?>

        <div class="row my-5">
            <h2 class="post-title text-center">From Our Professors</h2>
            <?php while(have_posts()) {
                the_post();
                if(get_post_type()=== 'professor') get_template_part('template-part/content', get_post_type());
            } ?>
        </div>

        <div class="row my-5">
            <h2 class="post-title text-center">From Our Events</h2>
            <?php while(have_posts()) {
                the_post();
                if(get_post_type()=== 'event') : ?>
                        <div class="row"><?php get_template_part('template-part/content', get_post_type()); ?></div>
                <?php endif;?>
            <?php } ?>
        </div>

        <div class="row my-5">
            <h2 class="post-title text-center">From Our Seminars</h2>
            <?php while(have_posts()) {
                the_post();
                if(get_post_type()=== 'seminar') get_template_part('template-part/content', get_post_type());
            } ?> 
        </div>

        <div class="row my-5">
            <h2 class="post-title text-center">From Our Blog</h2>
            <?php while(have_posts()) {
                the_post();
                if(get_post_type()=== 'post') get_template_part('template-part/content', get_post_type());
            } ?> 
        </div>

        <div class="row my-5">
            <h2 class="post-title text-center">From Our Pages</h2>
            <?php while(have_posts()) {
                the_post();
                if(get_post_type()=== 'page') get_template_part('template-part/content', get_post_type());
            } ?> 
        </div>

    <?php } 
    
    else {
        echo 'nothing matches your search';
    } ?>
</div>


<?php
get_search_form();
get_footer(); 
?>


