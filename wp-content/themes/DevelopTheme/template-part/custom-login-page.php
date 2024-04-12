<?php
/*
Template Name: custom login page
*/

session_start();

if(is_user_logged_in()) {
    wp_redirect(site_url(''));
    exit;
}

get_header();
pageBanner('', '', '');

$err_codes = isset( $_SESSION["err_codes"] ) ? $_SESSION["err_codes"] : 0;

function display_error_message( $err_code ){
    global $error;
    // Invalid username.
    if ( in_array( 'invalid_username', $err_code ) ) {
        $error = '<strong CLASS="text-danger">ERROR</strong>: Invalid username.';
    }
    // Incorrect password.
    if ( in_array( 'incorrect_password', $err_code ) ) {
        $error = '<strong CLASS="text-danger">ERROR</strong>: The password you entered is incorrect.';
    }
    // Empty username.
    if ( in_array( 'empty_username', $err_code ) ) {
        $error = '<strong CLASS="text-danger">ERROR</strong>: The username field is empty.';
    }
    // Empty password.
    if ( in_array( 'empty_password', $err_code ) ) {
        $error = '<strong CLASS="text-danger">ERROR</strong>: The password field is empty.';
    }
    // Empty username and empty password.
    if( in_array( 'empty_username', $err_code )  &&  in_array( 'empty_password', $err_code )){
        $error = '<strong CLASS="text-danger">ERROR</strong>: The username and password are empty.';
    }
    // Incorrect username and password.
    if( in_array( 'invalid_username', $err_code )  &&  in_array( 'incorrect_password', $err_code )){
        $error = '<strong CLASS="text-danger">ERROR</strong>: The username and password are invalid.';
    }
    return $error;
} ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-9 col-sm-6 col-md-5 border rounded p-5">
            <h4 class="text-center py-2">sing in to your account</h4>
        <?php

        if( $err_codes !== 0 ){
        echo display_error_message(  $err_codes );
        }
        
        if ( ! is_user_logged_in() ) {
    $args = array(
        'redirect' => admin_url(), // redirect to admin dashboard.
        'form_id' => 'custom_loginform',
        'label_username' => __( 'Username:' ),
        'label_password' => __( 'Password:' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in' => __( 'Log In' ),
        'remember' => true
    );
    wp_login_form( $args );
} ?>
        </div>
    </div>
</div>


<?php get_footer();

session_unset();
session_destroy();
?>