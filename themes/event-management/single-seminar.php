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
                    <a href="<?php echo esc_url(em_theme_get_archive_url('seminar', '/seminars/')); ?>"><i class="fa-solid fa-home mx-1" aria-hidden="true"></i><?php esc_html_e('All seminars', 'event-management-theme'); ?></a>
                </h4>
            </div>
            
            <div class="col-6 col-sm-4 col-lg-3 d-flex align-items-center justify-content-center bg-secondary">
                <div class="post-meta">
                    <span class="professor-title text-white"><?php echo esc_html(get_the_title()); ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row my-5">
        <?php
        $seminar_professor = em_theme_get_field('seminar_professor');
        $seminar_professor = is_array($seminar_professor) ? $seminar_professor : array_filter(array($seminar_professor));
        ?>
        <div class="col-12 col-sm-6 col-lg-3">
            <aside class="seminar-informations my-2 d-flex flex-column align-items-center position-sticky bg-dark px-sm-3 px-md-4 px-2 pb-1 rounded">
                <h1 class="post-title h2 text-center text-white py-2"><?php echo esc_html(get_the_title()); ?></h1>
                <div class="featured-image"><?php echo wp_kses_post(em_theme_post_thumbnail('medium_large')); ?></div>
                <?php if($seminar_professor) : ?>
                    <span class="ms-2 d-flex text-white my-3"><?php esc_html_e('Professors:', 'event-management-theme'); ?></span>
                    <div class="w-100 row justify-content-center">
                        <?php foreach($seminar_professor as $professor_item) : ?>
                            <?php
                            $professor_id = is_object($professor_item) ? $professor_item->ID : absint($professor_item);
                            if (!$professor_id) {
                                continue;
                            }
                            ?>
                            <div class="col-5 position-relative p-0 mx-1 my-2">
                                <a class="seminar-professor-informations overflow-hidden w-100 d-flex" href="<?php echo esc_url(get_permalink($professor_id)); ?>">
                                    <?php echo wp_kses_post(em_theme_post_thumbnail('medium', 'seminar-professor-image w-100 h-100', $professor_id)); ?>
                                    <span class="seminar-professor-title position-absolute bottom-0 start-0 end-0 text-center"><?php echo esc_html(get_the_title($professor_id)); ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif;?>
                <a class="w-100 mx-auto my-4 py-2 px-4 justify-content-center d-flex rounded bg-primary align-items-center" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Buy Ticket', 'event-management-theme'); ?> <i class="ms-2 fa-solid fa-ticket" aria-hidden="true"></i></a>
            </aside>
        </div>
        <article <?php post_class('col-12 seminar-content col-sm-6 col-lg-9'); ?>><?php the_content(); ?></article>
    </div>
</div>

<?php endwhile; ?>

<?php
if(comments_open()) {
    comments_template();
}
get_footer();
?>
