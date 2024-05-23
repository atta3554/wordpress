<?php

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

// config SMTP 
add_action( 'phpmailer_init', 'send_smtp_email' );

function send_smtp_email( $phpmailer ) {
  $phpmailer->isSMTP();
  $phpmailer->Host =       SMTP_HOST;
  $phpmailer->Username =   SMTP_USER;
  $phpmailer->Password =   SMTP_PASSWORD;
  $phpmailer->From =       SMTP_FROM;
  $phpmailer->FromName =   SMTP_FROMNAME;
  $phpmailer->Port =       SMTP_PORT;
  $phpmailer->SMTPAuth =   SMTP_AUTH;
  $phpmailer->SMTPSecure = SMTP_SECURE;
  // $phpmailer->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER; ----> enable when need to DEBUG and it logs complete workflow and proccess on screen
}



// enable errors in error log
add_action( 'wp_mail_failed', function ( $error ) {
  // the "3" means write the message to the file as defined in the third parameter
  error_log( $error->get_error_message(), 3, WP_CONTENT_DIR . '/debug.log' );
} );




// set from email if phpmailerinit couldn't set
function set_from()
{
    return '_mainaccount@atacookies.ir';
}

add_filter('wp_mail_from', 'set_from');
?>