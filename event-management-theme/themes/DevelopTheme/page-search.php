<?php 
get_header();
pageBanner('Search Page', 'Search for anything that you want', '');

while(have_posts()) {
    the_post();
    get_search_form();
}

get_footer() 

?>
