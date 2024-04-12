<?php $logo = get_theme_mod('custom_logo'); $logomain = wp_get_attachment_image_src($logo , 'full'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php wp_head(); ?>
</head>
<body>
    <section id='website-wrapper'>
    <header class='position-absolute w-100'>
        <div class="container">
            <div class="row py-3">
                
                <div class="col-3 site-logo">
                    <img src="<?php echo $logomain[0] ?>" alt="">
                </div>

                <div class="col-9 d-flex align-items-center justify-content-end">
                    <div class="position-relative">
                        <a class="humburgur-menu mx-3" href="javascript:void(0)"><i class="fa-solid fa-bars fs-2"></i></a>   
                        <div class="nav-container">
                            <nav class="d-flex align-items-center">
                                <?php wp_nav_menu(array(
                                    'menu'=>'Primary Menu',
                                    'menu_class'=>'d-flex px-1 mx-0 list-unstyled justify-content-around my-0',
                                    'container'=>'ul' 
                                )) ?>
                                
                                <?php if(!is_user_logged_in()) {?>
                                    <div class="my-2 login bg-primary py-2 px-4 text-white mx-2 rounded"><a href="<?php echo site_url('/login'); ?>">Login</a></div>
                                    <div class="my-2 register bg-secondary py-2 px-4 text-white mx-2 rounded"><a href="<?php echo site_url('/register') ?>">Register</a></div>
                                <?php }
                                else { ?>
                                    <div class="login bg-primary px-2 pb-1 text-white mx-2 my-2 text-center rounded"><a href="<?php echo site_url('/my-notes') ?>">My Notes</a></div>
                                    <div class="register bg-secondary text-white d-flex mx-2 my-2 text-center rounded">
                                    <a class='d-flex w-100 justify-content-between align-items-center pe-2' href="<?php echo wp_logout_url() ?>">
                                        <span class='user-avatar'><?php echo get_avatar(get_current_user_id(), 40) ?></span>
                                        <span class='px-2'>Log Out</span>
                                    </a>
                                    </div>
                                <?php } ?>
                                <div class="search-icon my-2 text-center"><a href="<?php echo esc_url(site_url('/search')) ?>"><i class="fa-solid fa-magnifying-glass fs-3"></i></a></div>
                            </nav>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </header>

    <main>
