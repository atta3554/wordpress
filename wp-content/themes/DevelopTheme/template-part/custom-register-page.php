<?php 
/*
Template Name: custom register page
*/

get_header();
pageBanner('', '', '');

global $wpdb;
$showForm= true;

if($_POST) {
    $userName= $wpdb->_escape($_POST['userName-register']);
    $userEmail= $wpdb->_escape($_POST['user_Email-register']);
    $userPassword= $wpdb->_escape($_POST['user_password-register']);
    $userPassConfirm= $wpdb->_escape($_POST['user_confirm_password-register']);

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
            echo '<p class="py-5 px-5"></p><h1 class="text-center">Your account created successfully</h1><p class="py-5 px-5"></p>';
            $showForm= false;
        } else {
            echo '<h1 class="text-center">An error Accoured</h1>';
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