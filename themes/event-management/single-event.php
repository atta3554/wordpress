<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php while(have_posts()) : the_post(); em_theme_page_banner('', '', ''); ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box rounded d-flex">
                <div class="col-6 col-sm-4 col-lg-3 d-flex align-items-center justify-content-center bg-primary">
                    <h4 class="my-0">
                        <a href="<?php echo esc_url(em_theme_get_archive_url('event', '/events/')); ?>"><i class="fa-solid fa-home mx-1" aria-hidden="true"></i><?php esc_html_e('All Events', 'event-management-theme'); ?></a>
                    </h4>
                </div>

                <div class="col-6 col-sm-4 col-lg-3 d-flex align-items-center justify-content-center bg-secondary">
                    <div class="post-meta">
                        <span class="professor-title text-white"><?php echo esc_html(get_the_title()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <article <?php post_class('post-container my-5'); ?>>
            <div class="post-informations"><h1 class="post-title text-center"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h1></div>
            <div class="post-thumbnail my-3"><?php echo wp_kses_post(em_theme_post_thumbnail('large')); ?></div>
            <div class="post-content"><?php the_content(); ?></div>
        </article>
    </div>

<?php endwhile; ?>
<?php 
if(comments_open()) {
    comments_template();
}
get_footer();
?>
