<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

get_header();
pageBanner('Search Page', 'Search for anything that you want', '');

while(have_posts()) {
    the_post();
    get_search_form();
}

get_footer() 

?>
