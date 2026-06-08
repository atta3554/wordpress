<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
        </main>

        <footer class="site-footer">

            <div class="footer-container py-4 px-2 bg-info">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="site-footer__col-one">
                            <h2 class="school-logo-text school-logo-text--alt-color"><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a></h2>
                            <p class="text-white mb-0">&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html(get_bloginfo('name')); ?></p>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="site-footer__col-three">
                            <h3 class="headline headline--small text-white"><?php esc_html_e('Quick Access', 'event-management-theme'); ?></h3>
                            <nav class="nav-list" aria-label="<?php esc_attr_e('Footer menu', 'event-management-theme'); ?>">
                                <?php
                                $footer_menu_location = has_nav_menu('Secondary Menu') ? 'Secondary Menu' : 'footer';
                                wp_nav_menu(array(
                                    'theme_location' => $footer_menu_location,
                                    'container'      => false,
                                    'fallback_cb'    => false,
                                    'menu_class'     => 'list-unstyled',
                                ));
                                ?>
                                <?php if (!has_nav_menu('Secondary Menu') && !has_nav_menu('footer')) : ?>
                                    <ul class="list-unstyled">
                                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'event-management-theme'); ?></a></li>
                                        <li><a href="<?php echo esc_url(home_url('/events/')); ?>"><?php esc_html_e('Events', 'event-management-theme'); ?></a></li>
                                        <li><a href="<?php echo esc_url(home_url('/seminars/')); ?>"><?php esc_html_e('Seminars', 'event-management-theme'); ?></a></li>
                                    </ul>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>

                    <div class="col-6 col-md-4">
                        <div class="site-footer__col-four">
                        <h3 class="headline headline--small text-white"><?php esc_html_e('Connect With Us', 'event-management-theme'); ?></h3>
                        <nav aria-label="<?php esc_attr_e('Social links', 'event-management-theme'); ?>">
                            <ul class="min-list social-icons-list group list-unstyled d-flex gap-3">
                                <li><a href="#" class="social-color-facebook" aria-label="Facebook"><i class="fs-4 my-2 fa-brands fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="social-color-twitter" aria-label="Twitter"><i class="fs-4 my-2 fa-brands fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="social-color-youtube" aria-label="YouTube"><i class="fs-4 my-2 fa-brands fa-youtube" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="social-color-linkedin" aria-label="LinkedIn"><i class="fs-4 my-2 fa-brands fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#" class="social-color-instagram" aria-label="Instagram"><i class="fs-4 my-2 fa-brands fa-instagram" aria-hidden="true"></i></a></li>
                            </ul>
                        </nav>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
        <?php wp_footer(); ?>
        </section>
    </body>
</html>
