<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
$posts_page_id = (int) get_option('page_for_posts');
$blog_url      = $posts_page_id ? get_permalink($posts_page_id) : home_url('/blog/');
$blog_title    = $posts_page_id ? get_the_title($posts_page_id) : __('Blog', 'event-management-theme');
?>

<?php while(have_posts()) : the_post(); em_theme_page_banner('', '', ''); ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box rounded p-0 d-flex">
                <div class="col-3 col-sm-2 d-flex align-items-center justify-content-center bg-primary">
                    <h4 class="my-0">
                        <a href="<?php echo esc_url($blog_url); ?>"><i class="fa-solid fa-home mx-1" aria-hidden="true"></i><?php echo esc_html($blog_title); ?></a>
                    </h4>
                </div>

                <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 col-9 d-flex align-items-center justify-content-center bg-secondary">
                    <div class="post-meta">
                        <span class="post-author"><?php esc_html_e('Written by:', 'event-management-theme'); ?> <?php the_author_posts_link(); ?></span>
                        <span class="post-date"> <?php esc_html_e('Published on', 'event-management-theme'); ?> <?php echo esc_html(get_the_date()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <article <?php post_class('post-container my-5'); ?>>
            <div class="post-informations d-flex flex-column flex-sm-row justify-content-between">
                <div class="post-tags d-flex justify-content-between"><?php the_tags('<span class="tag bg-secondary p-1 p-sm-2">', '<i class="fa-solid fa-tag pl-2" aria-hidden="true"></i></span><span class="tag bg-secondary p-1 p-sm-2">', '<i class="fa-solid fa-tag" aria-hidden="true"></i></span>'); ?></div>
                <h1 class="post-title text-center"><a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></h1>
                <div class="post-categories bg-warning px-2 px-sm-4 py-2 text-center"><?php echo wp_kses_post(get_the_category_list(',')); ?></div>
            </div>
            <div class="post-thumbnail my-3"><?php echo wp_kses_post(em_theme_post_thumbnail('large')); ?></div>
            <div class="post-content"><?php the_content(); ?></div>
        </article>
    </div>
<?php endwhile; ?>

<?php
if(comments_open()) {
    comments_template();
}
?>

<?php get_footer(); ?>
