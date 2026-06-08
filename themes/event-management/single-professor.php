<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner('', '', '');
?>

<?php while(have_posts()) : the_post(); ?>
    <?php
    $professor_id = get_the_ID();

    $professor_seminars = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type'      => 'seminar',
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'seminar_professor',
                'compare' => 'LIKE',
                'value'   => '"' . $professor_id . '"',
            ),
        ),
    ));

    $professor_likes = new WP_Query(array(
        'post_type'      => 'like',
        'post_status'    => 'any',
        'fields'         => 'ids',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'professor_like_id',
                'compare' => '=',
                'value'   => $professor_id,
                'type'    => 'NUMERIC',
            ),
        ),
    ));

    $current_user_like_id = 0;
    $exist_like           = 'no';
    if(is_user_logged_in()) {
        $current_user_like = new WP_Query(array(
            'post_type'      => 'like',
            'post_status'    => 'any',
            'fields'         => 'ids',
            'posts_per_page' => 1,
            'author'         => get_current_user_id(),
            'meta_query'     => array(
                array(
                    'key'     => 'professor_like_id',
                    'compare' => '=',
                    'value'   => $professor_id,
                    'type'    => 'NUMERIC',
                ),
            ),
        ));

        if(!empty($current_user_like->posts)) {
            $exist_like = 'yes';
            $current_user_like_id = (int) $current_user_like->posts[0];
        }
        wp_reset_postdata();
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="single-child-box p-0 rounded d-flex">
                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-3 d-flex align-items-center justify-content-center bg-primary">
                    <h4 class="my-0">
                        <a href="<?php echo esc_url(em_theme_get_archive_url('professor', '/professors/')); ?>"><i class="fa-solid fa-home mx-1" aria-hidden="true"></i><?php esc_html_e('All professors', 'event-management-theme'); ?></a>
                    </h4>
                </div>

                <div class="col-6 col-sm-5 col-md-4 col-lg-3 col-xl-2 d-flex align-items-center justify-content-center bg-secondary">
                    <div class="post-meta">
                        <span class="professor-title text-white"><?php echo esc_html(get_the_title()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="post-information mt-5">
                <div class="row justify-content-center align-items-center">
                    <div class="justify-content-center col-9 col-md-3 my-2 d-flex align-items-center">
                        <span class="bg-info px-4 py-2 text-warning">
                            <?php esc_html_e('Seminars:', 'event-management-theme'); ?>
                            <?php if ($professor_seminars->have_posts()) : ?>
                                <?php while($professor_seminars->have_posts()) : $professor_seminars->the_post(); ?>
                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a><?php echo $professor_seminars->current_post + 1 < $professor_seminars->post_count ? esc_html(', ') : ''; ?>
                                <?php endwhile; wp_reset_postdata(); ?>
                            <?php else : ?>
                                <?php esc_html_e('None yet', 'event-management-theme'); ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="col-9 col-md-3 my-2">
                        <h1 class="post-title text-center"><?php echo esc_html(get_the_title($professor_id)); ?></h1>
                    </div>
                    <div class="col-12 p-0 col-sm-10 bg-secondary col-md-5 my-2 rounded professor-meta d-flex justify-content-center">
                        <h4 class="p-2 m-0 border-end"><span class="text-white"><?php esc_html_e('Field:', 'event-management-theme'); ?></span> <?php echo wp_kses_post(em_theme_get_professor_fields($professor_id, true) ?: __('N/A', 'event-management-theme')); ?></h4>
                        <h4 class="p-2 m-0 border-end"><span class="text-white"><?php esc_html_e('Education:', 'event-management-theme'); ?></span> <?php echo esc_html(em_theme_get_field('professor_education') ?: __('N/A', 'event-management-theme')); ?></h4>
                        <h4 class="p-2 m-0"><span class="text-white"><?php esc_html_e('Age:', 'event-management-theme'); ?></span> <?php echo esc_html(em_theme_get_field('professor_age') ?: __('N/A', 'event-management-theme')); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row my-5 flex-column-reverse flex-sm-row">
            <div class="col-12 col-sm-8">
                <div class="post-content"><?php the_content(); ?></div>
            </div>

            <div class="col-12 col-sm-4 professor-sidebar-column">
                <aside class="professor-profile-panel" aria-label="<?php esc_attr_e('Professor profile actions', 'event-management-theme'); ?>">
                    <div class="professor-likes d-flex justify-content-end" data-like="<?php echo esc_attr($current_user_like_id); ?>" data-exist="<?php echo esc_attr($exist_like); ?>" data-professor="<?php echo esc_attr($professor_id); ?>">
                        <button type="button" class="like-area px-3 py-2 border-0" <?php disabled(!is_user_logged_in()); ?>>
                            <span class="like-btn">
                                <i class="<?php echo 'no' === $exist_like ? 'fa-regular fa-heart' : 'fa-solid fa-heart'; ?> text-danger" aria-hidden="true"></i>
                            </span>
                            <span class="likes-count text-danger"><?php echo esc_html(count($professor_likes->posts)); ?></span>
                        </button>
                    </div>
                    <div class="post-thumbnail my-3"><?php echo wp_kses_post(em_theme_post_thumbnail('large')); ?></div>
                </aside>
            </div>
        </div>

    </div>
    <?php wp_reset_postdata(); ?>
<?php endwhile; ?>

<?php 
if(comments_open()) {
    comments_template();
}
get_footer();
?>
