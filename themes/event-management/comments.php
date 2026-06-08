<?php
if (!defined('ABSPATH')) {
    exit;
}

if (post_password_required()) {
    return;
}

$comment_form_args = array(
    'fields' => array(
        'author'  => '<div class="col-12 my-3"><label class="screen-reader-text" for="author">' . esc_html__('Name', 'event-management-theme') . '</label><input class="col-12 col-sm-9 col-lg-6 py-2 px-3" id="author" name="author" placeholder="' . esc_attr__('Name', 'event-management-theme') . '" required></div>',
        'email'   => '<div class="col-12 my-3"><label class="screen-reader-text" for="email">' . esc_html__('Email', 'event-management-theme') . '</label><input class="col-12 col-sm-9 col-lg-6 py-2 px-3" id="email" name="email" type="email" placeholder="' . esc_attr__('Email', 'event-management-theme') . '" required></div>',
        'url'     => '<div class="col-12 my-3"><label class="screen-reader-text" for="url">' . esc_html__('Website', 'event-management-theme') . '</label><input class="col-12 col-sm-9 col-lg-6 py-2 px-3" id="url" name="url" type="url" placeholder="' . esc_attr__('Website', 'event-management-theme') . '"></div>',
        'cookies' => '<div class="col-12"><label><input name="wp-comment-cookies-consent" type="checkbox" value="yes"> ' . esc_html__('Save my name, email, and website in this browser for the next time I comment.', 'event-management-theme') . '</label></div>',
    ),
    'comment_field'       => '<div class="col-12"><label class="screen-reader-text" for="comment">' . esc_html__('Comment', 'event-management-theme') . '</label><textarea id="comment" rows="10" class="col-12 col-sm-9 col-lg-6 rounded px-2 py-1" name="comment" aria-required="true" placeholder="' . esc_attr__('Comment', 'event-management-theme') . '" required></textarea></div>',
    'label_submit'        => __('Send comment', 'event-management-theme'),
    'title_reply'         => __('Your Comment', 'event-management-theme'),
    'title_reply_to'      => __('Reply', 'event-management-theme'),
    'cancel_reply_link'   => __('Cancel Reply', 'event-management-theme'),
    'comment_notes_before'=> '<p class="my-2">' . esc_html__('Leave your comment here.', 'event-management-theme') . '</p>',
    'id_submit'           => 'comment-submit',
    'class_submit'        => 'bg-secondary text-white my-4 px-2 py-1',
);

$comment_list_args = array(
    'max_depth'         => 4,
    'style'             => 'div',
    'per_page'          => 12,
    'avatar_size'       => 80,
    'reverse_top_level' => true,
    'reverse_children'  => true,
);
?>

<div id="comments" class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center my-3"><?php esc_html_e('Comments', 'event-management-theme'); ?></h2>
            <?php if(!get_comments_number()) : ?>
                <p class="my-5 text-center"><?php esc_html_e('There are no comments yet.', 'event-management-theme'); ?></p>
            <?php else : ?>
                <?php wp_list_comments($comment_list_args); ?>
            <?php endif; ?>

            <?php
            if(get_post_type() === 'post' || is_user_logged_in()) {
                comment_form($comment_form_args);
            } else {
                printf(
                    '<p class="text-center">%s</p><p class="text-center"><a class="mx-2 py-1 px-2 bg-primary rounded text-white" href="%s">%s <i class="mx-1 fa-solid fa-arrow-right" aria-hidden="true"></i></a></p>',
                    esc_html__('Please log in to leave a comment.', 'event-management-theme'),
                    esc_url(home_url('/login/')),
                    esc_html__('Login', 'event-management-theme')
                );
            }
            ?>
        </div>
    </div>
</div>
