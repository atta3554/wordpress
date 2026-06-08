<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<form role="search" method="get" class="search-form d-flex gap-2 justify-content-center my-4" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="screen-reader-text" for="search-field"><?php esc_html_e('Search for:', 'event-management-theme'); ?></label>
    <input id="search-field" class="search-field px-3 py-2 rounded" type="search" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="<?php esc_attr_e('Search...', 'event-management-theme'); ?>">
    <button class="search-submit px-4 py-2 bg-primary text-white rounded border-0" type="submit"><?php esc_html_e('Search', 'event-management-theme'); ?></button>
</form>
