<?php 
$pages = get_pages(array('title_li'=>NULL, 'child_of'=>get_the_ID())); 
$parentPage = wp_get_post_parent_id(get_the_ID()); 
$havePages = sizeof($pages);
?>
<?php get_header();?>



<?php while(have_posts()) :the_post(); pageBanner('', '', '');?>

    <!-- check if is parent page  -->
    <?php 
    if($parentPage) : ?>
        <div class="container">
            <div class="row">
                <div class="single-child-box rounded d-flex ">
                    <div class="col-6 col-sm-5 col-md-4 col-lg-3 d-flex align-items-center justify-content-center bg-primary"><h4 class='my-0 parent-page'><a href="<?php echo the_permalink($parentPage) ?>"><i class="fa-solid fa-home mx-1"></i><?php echo get_the_title($parentPage) ?></a></h4></div>
                    <div class="col-6 col-sm-5 col-md-4 col-lg-3 d-flex align-items-center justify-content-center bg-secondary"><a href="<?php echo the_permalink() ?>"><?php echo the_title() ?></a></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- check if has child page -->
    <?php if($havePages) : ?>
        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <div class="col-9 col-sm-6 col-md-4 col-lg-3 parent-pages-box px-0 rounded overflow-hidden bg-primary">
                    <h3 class='bg-secondary'><a class='text-dark' href="<?php the_permalink()?>"><?php the_title() ?></a></h3>
                    <?php wp_list_pages(array('title_li'=>NULL, 'child_of'=>get_the_ID())); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php endwhile; ?>


<?php get_footer() ?>
