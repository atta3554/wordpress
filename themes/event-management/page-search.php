<?php
/*
Template Name: Search Page
*/

if (!defined('ABSPATH')) {
    exit;
}

get_header();
em_theme_page_banner(__('Search Page', 'event-management-theme'), __('Search across the website', 'event-management-theme'), '');
?>

<div class="container my-5">
    <?php get_search_form(); ?>
</div>

<?php get_footer(); ?>
