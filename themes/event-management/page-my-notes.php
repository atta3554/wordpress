<?php
/*
Template Name: My Notes
*/

if (!defined('ABSPATH')) {
    exit;
}

if(!is_user_logged_in()) {
    wp_safe_redirect(home_url('/'));
    exit;
}

get_header();
$my_notes = new WP_Query(array(
    'post_type'      => 'note',
    'post_status'    => array('private', 'publish'),
    'posts_per_page' => -1,
    'author'         => get_current_user_id(),
)); ?>

<?php while(have_posts()) : the_post(); em_theme_page_banner('', '', '');?>
    <div class="container" id="notes-container">

        <div class="row my-5 justify-content-center">
            <div class="col-12 col-sm-9 new-note-box d-flex flex-column rounded">
                <h2 class="my-2"><?php esc_html_e('Create a new Note', 'event-management-theme'); ?></h2>
                <label class="screen-reader-text" for="new-note-title"><?php esc_html_e('Note title', 'event-management-theme'); ?></label>
                <input type="text" class="note-title my-2" id="new-note-title">
                <label class="screen-reader-text" for="new-note-body"><?php esc_html_e('Note body', 'event-management-theme'); ?></label>
                <textarea class="note-body my-2" id="new-note-body"></textarea>
                <div class="col-12 my-2"><button type="button" class="submit-note my-2 w-100 text-center px-3 py-2 bg-danger text-white rounded border-0"><?php esc_html_e('Create Note', 'event-management-theme'); ?></button></div>
            </div>
        </div>

        <div class="row notes-list justify-content-center justify-content-lg-around gap-xl-4">
            <?php if ($my_notes->have_posts()) : ?>
                <?php while($my_notes->have_posts()) : $my_notes->the_post(); ?>
                    <div class="note-box border rounded py-4 my-5 col-12 col-sm-10 col-md-9 col-lg-6 col-xl-5 d-flex overflow-hidden flex-column" data-id="<?php echo esc_attr(get_the_ID()); ?>">
                        <div class="d-flex flex-column-reverse flex-sm-row px-3 justify-content-between align-items-start align-items-sm-center">
                            <input readonly class="note-title px-3 py-2 my-3" type="text" value="<?php echo esc_attr(get_the_title()); ?>">
                            <div class="d-flex">
                                <button type="button" class="edit-note border rounded px-2 mx-2 bg-transparent"><i class="fa fa-pencil me-2" aria-hidden="true"></i><?php esc_html_e('Edit', 'event-management-theme'); ?></button>
                                <button type="button" class="delete-note border rounded px-2 border-danger text-danger bg-transparent"><i class="fa fa-trash-o me-2" aria-hidden="true"></i><?php esc_html_e('Delete', 'event-management-theme'); ?></button>
                            </div>
                        </div>
                        <textarea readonly class="note-body p-3 w-100 overflow-auto"><?php echo esc_textarea(wp_strip_all_tags(get_the_content(null, false))); ?></textarea>
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="cancel-note mx-auto my-2 bg-primary text-white text-center rounded py-2 border-0">
                                    <i class="fa fa-close me-2" aria-hidden="true"></i><?php esc_html_e('Cancel', 'event-management-theme'); ?>
                                </button>
                            </div>
                            <div class="col-9">
                                <span class="error-message"><?php esc_html_e('Your notes count has reached the limit. Please delete a note.', 'event-management-theme'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-center"><?php esc_html_e('You have not created any notes yet.', 'event-management-theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php 
endwhile;
wp_reset_postdata();
?>

<div class="delete-note__alert-container">
    <div class="delete-note__alert-bg rounded">
        <h2 class="delete-note__alert-content"><?php esc_html_e('Your note was deleted successfully.', 'event-management-theme'); ?></h2>
    </div>
</div>

<?php get_footer(); ?>
