<?php 
session_start();
// Redirect to custom Login Page from default Login page
function redirect_login_page() {
    $login_url  = home_url( '/login' );
    $url = basename($_SERVER['REQUEST_URI']); // get requested URL
    isset( $_REQUEST['redirect_to'] ) ? ( $url   = "wp-login.php" ): 0; // if users ssend request to wp-admin
    if( $url  == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET')  {
        wp_redirect( $login_url );
        exit;
    }
}
add_action('init','redirect_login_page');




// error handling for user login
function error_handler($errors) {
    $login_page  = home_url( '/login' );
    global $errors;
    $err_codes = $errors->get_error_codes(); // get WordPress built-in error codes
    $_SESSION["err_codes"] =  $err_codes;
    wp_redirect( $login_page ); // keep users on the same page
    exit;
}
add_filter( 'login_errors', 'error_handler');



