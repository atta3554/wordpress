<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php while(have_posts()) : the_post(); ?>
    <?php
    em_theme_page_banner('', '', '');
    $pages       = get_pages(array('title_li' => null, 'child_of' => get_the_ID()));
    $parent_page = wp_get_post_parent_id(get_the_ID());
    $have_pages  = count($pages);
    ?>

    <?php if($parent_page) : ?>
        <div class="container">
            <div class="row">
                <div class="single-child-box rounded d-flex">
                    <div class="col-6 col-sm-5 col-md-4 col-lg-3 d-flex align-items-center justify-content-center bg-primary"><h4 class="my-0 parent-page"><a href="<?php echo esc_url(get_permalink($parent_page)); ?>"><i class="fa-solid fa-home mx-1" aria-hidden="true"></i><?php echo esc_html(get_the_title($parent_page)); ?></a></h4></div>
                    <div class="col-6 col-sm-5 col-md-4 col-lg-3 d-flex align-items-center justify-content-center bg-secondary"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($have_pages) : ?>
        <div class="container my-5">
            <div class="row d-flex justify-content-center">
                <div class="col-9 col-sm-6 col-md-4 col-lg-3 parent-pages-box px-0 rounded overflow-hidden bg-primary">
                    <h3 class="bg-secondary"><a class="text-dark" href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                    <?php wp_list_pages(array('title_li' => null, 'child_of' => get_the_ID())); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container my-5">
        <article <?php post_class('page-content'); ?>>
            <?php the_content(); ?>
            <?php
            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'event-management-theme'),
                'after'  => '</div>',
            ));
            ?>
        </article>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
