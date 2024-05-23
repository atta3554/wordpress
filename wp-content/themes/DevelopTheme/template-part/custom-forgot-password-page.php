<?php
/*
Template Name: Forgot Password
*/

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

// redirect logged in users to home page
if(is_user_logged_in()){ 
    wp_redirect( esc_url( home_url() ) );
    exit;
}

get_header();
pageBanner('', '', '');

//VAR SETUP
$form_output = '<form class="d-flex flex-column align-items-center" method="post" action="'.get_permalink().'">'.
                    '<input type="email" class="mt-2 px-2 py-1" name="user_login" id="user_login" placeholder="example@gmail.com" /><br>'.
                    '<input type="hidden" name="action" value="reset" />'.
                    '<input class="px-5 py-2 bg-primary border-0 rounded text-white fs-4" type="submit" value="send email" class="button" id="submit" />'.
                '</form>';
if($_POST) {

    $user_login = isset( $_POST['user_login'] ) ? $_POST['user_login'] : '';
    $user_magic_email = trim($user_login);
		 
    if( empty( $user_magic_email ) ) {
        $error_message = 'Please enter an email address to reset your password...';            
    } else if( !is_email( $user_magic_email )) {
        $error_message = 'Invalid e-mail address.';
    } else if( !email_exists( $user_magic_email ) ) {
        $error_message = 'That email address is not in our system.';
    } else {
        $success_message = '<h3>Check your inbox!</h3><p>You should receive an email from us soon...</p>';
        
        //CREATE MAGIC_LINK_ID
        $magic_link_id = wp_generate_password(20);

        //GET USER ID 
        $user = get_user_by( 'email', $user_magic_email );
        $user_id = $user->ID;

        //ATTACH MAGIC_LINK_ID TO USER_META
        update_user_meta($user_id, 'magic_link_id', $magic_link_id);

        //CREATE A MAGIC_LINK_URL
        $magic_link_url = home_url() . '/?magic=' . $magic_link_id . '&id=' . $user_id;

        $to = $user_magic_email;
        $subject = 'Magic login Link Request';
        $body = 'Here is your magic link to login:'.$magic_link_url;
        $headers = array('Content-Type: text/html; charset=UTF-8');

        if(wp_mail( $to, $subject, $body, $headers )) {
            
        } 
    }
} 


?>

<div class="container my-5 mx-5">
    <div class="row justify-content-center">
        <div class="col-9 col-sm-6 col-md-5 d-flex align-items-center flex-column border rounded px-5 py-4">

            <?php if(isset($_GET['ref']) && "magicfail" == $_GET['ref']) : //CHECK IF MAGIC LINK EXPIRED... ?>

                <label for="user_login"><h3>Your Link Expired</h3><p>Request a new link below...</p></label>
                
                <?php echo $form_output;

                elseif (isset( $_POST['action'] ) && 'reset' == $_POST['action']) : //CHECK IF FORM SUBMITTED (action == reset) ?>

                <div class="container"></div>

            <?php else : ?>
                <h3>Forgot your password?</h3>
                <p>We'll send a link to your email address ...</p>
                <label for="user_login">Enter Your Email:</label>
            <?php echo $form_output;
            endif; ?>

        </div>
    </div>
</div>

<?php get_footer();