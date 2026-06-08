<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <section id="website-wrapper">
    <header class="position-absolute w-100 site-header">
        <div class="container">
            <div class="row py-3 align-items-center">
                
                <div class="col-3 d-flex align-items-center site-logo">
                    <a class="site-logo__link text-white" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(get_bloginfo('name')); ?>"><?php em_theme_render_logo() ?></a>
                </div>

                <div class="col-9 d-flex align-items-center justify-content-end">
                    <div class="position-relative w-100">
                        <button class="humburgur-menu mx-3 site-header__menu-toggle" type="button" aria-label="<?php esc_attr_e('Toggle navigation', 'event-management-theme'); ?>" aria-controls="primary-navigation" aria-expanded="false">
                            <i class="fa-solid fa-bars fs-2" aria-hidden="true"></i>
                        </button>
                        <div id="primary-navigation" class="nav-container d-flex align-items-center justify-content-between">
                            <nav class="d-flex align-items-center" aria-label="<?php esc_attr_e('Primary menu', 'event-management-theme'); ?>">
                                <?php wp_nav_menu(array(
                                    'theme_location'=> has_nav_menu('Primary Menu') ? 'Primary Menu' : 'primary',
                                    'menu_class'=>'d-flex px-1 mx-2 mx-0 list-unstyled justify-content-around my-0',
                                    'container'=> false,
                                    'fallback_cb'=> 'em_theme_primary_menu_fallback'
                                )) ?>    
                            </nav>
                            <div class="d-flex align-items-center header-actions">
                              <?php if(!is_user_logged_in()) {?>
                                  <div class="my-2 login bg-primary py-2 px-4 text-white mx-2 rounded"><a href="<?php echo esc_url(home_url('/login/')); ?>"><?php esc_html_e('Login', 'event-management-theme'); ?></a></div>
                                  <div class="my-2 register bg-secondary py-2 px-4 text-white mx-2 rounded"><a href="<?php echo esc_url(home_url('/register/')); ?>"><?php esc_html_e('Register', 'event-management-theme'); ?></a></div>
                              <?php }
                              else { ?>
                                  <div class="login text-white mx-2 my-2 text-center p-2 bg-primary rounded">
                                    <a class="lh-1 p-2" href="<?php echo esc_url(home_url('/my-notes/')); ?>"><?php esc_html_e('My Notes', 'event-management-theme'); ?></a>
                                  </div>
                                  <div class="register bg-secondary text-white d-flex mx-2 my-2 text-center rounded">
                                    <a class="d-flex w-100 justify-content-between align-items-center pe-2" href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>">
                                        <span class="user-avatar"><?php echo wp_kses_post(get_avatar(get_current_user_id(), 45)); ?></span>
                                        <span class="p-2"><?php esc_html_e('Log Out', 'event-management-theme'); ?></span>
                                    </a>
                                  </div>
                              <?php } ?>
                              <div class="search-icon my-2 text-center"><a href="<?php echo esc_url(home_url('/search/')); ?>" aria-label="<?php esc_attr_e('Search', 'event-management-theme'); ?>"><i class="fa-solid fa-magnifying-glass fs-3" aria-hidden="true"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </header>

    <main id="main-content">
