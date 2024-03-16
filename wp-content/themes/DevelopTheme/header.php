<?php $logo = get_theme_mod('custom_logo'); $logomain = wp_get_attachment_image_src($logo , 'full'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php wp_head(); ?>
</head>
<body>
    <header class='position-absolute w-100'>
        <div class="container">
            <div class="row py-3">
                
                <div class="col-3">
                    <img src="<?php echo $logomain[0] ?>" alt="">
                </div>

                <div class="col-9 d-flex align-items-center justify-content-end">
                    <?php wp_nav_menu(array(
                        'menu'=>'Primary Menu',
                        'menu_class'=>'d-flex px-2 mx-0 list-unstyled justify-content-around my-0',
                        'container'=>'ul'
                    )) ?>
                    <?php if(!is_user_logged_in()) {?>
                        <div class="login px-3 py-2 text-white mx-2 rounded"><a href="<?php echo wp_login_url(); ?>">Login</a></div>
                        <div class="register px-3 py-2 text-white mx-2 rounded"><a href="<?php echo wp_registration_url() ?>">Register</a></div>
                    <?php }
                     else { ?>
                        <div class="login px-2 pb-1 text-white mx-2 rounded"><a href="<?php echo site_url('/my-notes') ?>">My Notes</a></div>
                        <div class="register text-white d-flex mx-2 rounded">
                        <a href="<?php echo wp_logout_url() ?>">
                            <span class='user-avatar'><?php echo get_avatar(get_current_user_id(), 40) ?></span>
                            <span class='px-2'>Log Out</span>
                        </a>
                        </div>
                    <?php } ?>
                    <div class="search-icon"><a href="<?php echo esc_url(site_url('/search')) ?>"><i class="fa-solid fa-magnifying-glass fs-3"></i></a></div>
                </div>
            
            </div>
        </div>
    </header>

    <main>
