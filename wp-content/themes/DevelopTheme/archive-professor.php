<?php get_header(); pageBanner('Professors', 'our master compiled from the best ones throghout the world', ''); ?>


<div class="container rounded my-5 main py-5">
    <div class='row'>
        <?php while(have_posts()) {
            the_post();
            get_template_part('template-part/content', 'professor');
        } ?>
    </div>
</div>


<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-6 text-center"><?php echo paginate_links(); ?></div></div>
</div>


<?php get_footer() ?>


