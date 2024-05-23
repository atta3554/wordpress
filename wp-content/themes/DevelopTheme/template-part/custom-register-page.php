<?php 
/*
Template Name: custom register page
*/

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

if(is_user_logged_in()) {
    wp_redirect( esc_url( home_url() ) );
    exit;
}

get_header();
pageBanner('', '', '');

global $wpdb;
$showForm= true;

if($_POST) {
    $userName= $wpdb->_escape($_POST['userName-register']);
    $userEmail= $wpdb->_escape($_POST['user_Email-register']);
    $userPassword= $wpdb->_escape($_POST['user_password-register']);
    $userPassConfirm= $wpdb->_escape($_POST['user_confirm_password-register']);

    $emailSubject= 'Your Account Information';
    $emailContent= "
    your account has created successfully!
    Here is your login data:
    userName: {$userName},
    Email: {$userEmail},
    passWord: {$userPassword},
    remember to save them in a safe area.
    Thank you for choosing us.
    ";

    $errors= array();

    if(strpos($userName, ' ')) {
        $errors['espace_name'] = 'userName can\'t has espace';
    } 

    if(empty($userName)) {
        $errors['empty_name'] = 'userName is empty';
    } 

    if(username_exists($userName)) {
        $errors['exist_name'] = 'this userName is already taken';
    } 

    if(!is_email($userEmail)) {
        $errors['invalid_email'] = 'your email is not valid';
    }

    if(email_exists($userEmail)) {
        $errors['exist_email'] = 'this email is already taken';
    }

    if(strcmp($userPassword, $userPassConfirm)) {
        $errors['differrent_password'] = 'passwords don\'t match';
    }

    if(!count($errors)) {
        $userId= wp_create_user($userName, $userPassword, $userEmail);
        if(!is_wp_error($userId)) {
            echo '<p class="py-5 px-5"></p><h1 class="text-center">Your account created successfully</h1>';
            echo '<p class="px-3"></p><a href="' . site_url('/login') . '"><h4 class="text-center text-danger">Now you can Log in to your account <i class="fa-solid fa-arrow-right"></i></h4></a><p class="py-5 px-5"></p>';

            if ( wp_mail( $userEmail, $emailSubject, $emailContent ) ) {
                echo "<h4 class='text-center mt-3'>an Email contains your account's data have been sent to your entered email address</h4>
                <h4 class='text-center pt-3'>it may go to your spam folder. Check it too. </h4><p class='py-5 px-5'></p>";
            } else {
                echo '<h4 class="text-center mt-3">Email sending failed.</h4><p class="py-5 px-5"></p>';
            }

            $showForm= false;
        } else {
            echo '<h1 class="text-center">An error Accoured During sending email</h1>';
        }
    } else {
        echo '<div class="container my-4">';
        foreach($errors as $err=>$val) {
            echo '<h2 class="text-center"><strong class="text-danger">ERROR: </strong>' .$val;
        }
        echo '</div>';
    }
     
    
}

if($showForm) :
?>

<div class="container d-flex flex-column align-items-center my-4">
    
<div class="row justify-content-center">
    <div class="col-12">
    <h2 class='my-4'>Please Enter Your correct informations</h2>
    <form class='mt-4 border rounded py-sm-3 py-1 px-3 px-sm-5' id="user_register-form" method="POST" action="">
        <div class="d-flex gap-4 justify-content-between my-2">
            <p class="d-flex">
                <label role="button" for="userName-register">UserName</label>
            </p>
            <div>
                <input type="text" class='py-1 px-2 rounded' id="userName-register" name="userName-register" placeholder="enter your username..." >
            </div>
        </div>

        <div class="d-flex gap-4 justify-content-between my-2">
            <p class="d-flex">
                <label role="button" for="user_Email-register">Email</label>
            </p>
            <div>
                <input type="email" class='py-1 px-2 rounded' id="user_Email-register" name="user_Email-register" placeholder="enter your email..." >
            </div>
        </div>

        <div class="d-flex gap-4 justify-content-between my-2">
            <p class="d-flex">
                <label role="button" for="user_password-register">password</label>
            </p>
            <div>
                <input type="password" class='py-1 px-2 rounded' id="user_password-register" name="user_password-register" placeholder="enter your password..." >
            </div>
        </div>

        <div class="d-flex gap-4 justify-content-between my-2">
            <p class="d-flex">
                <label role="button" for="user_confirm_password-register">confirm password</label>
            </p>
            <div>
                <input type="password" class='py-1 px-2 rounded' id="user_confirm_password-register" name="user_confirm_password-register" placeholder="enter your password again..." >
            </div>
        </div>

        <div class="d-flex justify-content-center my-5">
            <input type="submit" class='py-2 px-5 bg-primary text-white rounded' name='submitRegister' >
        </div>
    </form>
    <p class="mb-5"></p>
    </div>
</div>
</div>

<?php 
endif;
get_footer();
?>