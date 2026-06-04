<?php 

$comment_send = 'Send comment';
$comment_reply = 'Your Comment';
$comment_reply_to = 'Reply';

$comment_author = 'Name';
$comment_email = 'E-Mail';
$comment_body = 'Comment';
$comment_url = 'Website';
$comment_cookies_1 = ' By commenting you accept the';
$comment_cookies_2 = ' Privacy Policy';

$comment_before = '<h6 class="my-2">Leave your comment here.</h6>';

$comment_cancel = 'Cancel Reply';

$comment_form_args = array(
    'fields' => array(
        'author' => '<div class="col-12 my-3"><input class="col-12 col-sm-9 col-lg-6 py-2 px-3" id="author" name="author" placeholder="' . $comment_author .'"></div>',
        'email' => '<div class="col-12 my-3"><input class="col-12 col-sm-9 col-lg-6 py-2 px-3" id="email" name="email" placeholder="' . $comment_email .'"></div>',
        'url' => '<div class="col-12 my-3"><input class="col-12 col-sm-9 col-lg-6 py-2 px-3" id="url" name="url" placeholder="' . $comment_url .'"></div>',
        'cookies' => '<div class="col-12"><input type="checkbox" required>' . $comment_cookies_1 . '<a class="text-danger" href="' . get_privacy_policy_url() . '">' . $comment_cookies_2 . '</a></div>',
    ),
    'comment_field' => '<div class="col-12"><textarea id="comment" rows="10" class="col-12 col-sm-9 col-lg-6 rounded px-2 py-1" name="comment" aria-required="true" placeholder="' . $comment_body .'"></textarea></div>',
    'label_submit' => __( $comment_send ),
    'title_reply' => __( $comment_reply ),
    'title_reply_to' => __( $comment_reply_to ),
    'cancel_reply_link' => __( $comment_cancel ),
    'comment_notes_before' => __( $comment_before),
    'id_submit' => 'comment-submit',
    'class_submit'=>'bg-secondary text-white my-4 px-2 py-1'
);

$comment_list_args= array(
    'max_depth'=> 4,
    'style'=> 'div',
    'per_page'=>12,
    'avatar_size'=>120,
    'reverse_top_level'=>true,
    'reverse_children'=>true,

);

?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center my-3">Comments</h2>
            <?php if(!get_comments_number()) : ?>
                <h2 class="my-5 text-center">there is no comment's for this <?php echo get_post_type(); ?></h2>
            <?php endif;
            if(get_comments_number()) {
                print_r(wp_list_comments($comment_list_args));
            }
            if(get_post_type() == 'post') {
                comment_form( $comment_form_args );
            } else {
                if(is_user_logged_in()) {
                    comment_form( $comment_form_args );
                }
                else {
                    echo '<h4 class="text-center">Just logged in users can comment for ' . get_post_type() . 's </h4>';
                    echo '<h6 class="text-center">please log in to your account in order to leave a comment. <a class="mx-2 py-1 px-2 bg-primary rounded text-white" href="' . site_url('/login') . '">Login<i class="mx-1 fa-solid fa-arrow-right"></i><a/></h6>';
                }
            }
            
            ?>
        </div>
    </div>
</div>
