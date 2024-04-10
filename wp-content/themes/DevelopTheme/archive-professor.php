<?php get_header(); pageBanner('Professors', 'our master compiled from the best ones throghout the world', ''); ?>


<div class="container rounded my-5 main py-5">
    <h1 class='text-center'>from our professors</h1>
    <div class='row justify-content-center'>
        <?php while(have_posts()) {
            the_post();
            get_template_part('template-part/content', 'professor');
        } ?>
    </div>
    <h4 class="text-center">click on each professor to see information about them and their seminars</h4>
</div>


<div class="container my-5 post-pagination">
    <div class="row justify-content-center"><div class="col-6 text-center"><?php echo paginate_links(); ?></div></div>
</div>


<?php get_footer() ?>


