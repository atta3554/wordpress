<?php

/*
  plugin Name: Our World Filter Plugin
  Description: Replaces a list of words.
  Version: 0.1
  Author: ata
*/

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

class WordFilterPlugin{
    function __construct() {
        add_action('admin_menu', array($this, 'ourMenu'));
        add_filter('the_content', array($this, 'filterWords'));
    }

    function ourMenu() {
        // add_menu_page('words Filter plugin', 'Word Filter', 'manage_options', 'ataWordFilter', array($this, 'wordFilterPage'), 'data:image/svg+xml;base64, PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+Cg==', 100);
        $mainPageHook = add_menu_page('words Filter plugin', 'Word Filter', 'manage_options', 'ataWordFilter', array($this, 'wordFilterPage'), plugin_dir_url(__FILE__) . 'custom.svg', 100);
        add_submenu_page('ataWordFilter', 'words Filter plugin', 'Words List', 'manage_options', 'ataWordFilter', array($this, 'wordFilterPage'));
        add_submenu_page('ataWordFilter', 'words Filter plugin options', 'Options', 'manage_options', 'word-filter-options', array($this, 'wordFiltersubPage'));
        add_action("load-{$mainPageHook}", array($this, 'mainPageAssets'));
    }

    // template for option sub menu
    function wordFiltersubPage() { ?>
        Hello
    <?php }

    // template for main menu
    function wordFilterPage() { ?>
        <div class="wrap">
            <h1>word Filter</h1>
            <?php if($_POST) $this->handleForm() ?>
            <form method="post">
                <?php wp_nonce_field('save_filter_words', 'ourNonce'); ?>
                <label for="wordsToFilter"> Enter a <strong>comma-seprated</strong> list of words to filter from your site content:<br></label>
                <div><?php echo get_option('words_to_filter') ?></div>
                <div class="word_filter-style" style="margin:20px 0;">
                    <textarea name="wordsToFilter" id="wordsToFilter" placeholder="book, tree, table, ..." ><?php echo trim(esc_textarea(get_option('words_to_filter'))); ?></textarea>
                </div>
                <input type="submit" value="save changes" id="submit" name="submit">
            </form>
        </div>
    <?php }

    // register custom styles for plugin admin page
    function mainPageAssets() {
        wp_enqueue_style('wordFilterAdminCSS', plugin_dir_url(__FILE__). 'styles.css');
    }

    // handle inputed datas
    function handleForm() {
    if(wp_verify_nonce($_POST['ourNonce'], 'save_filter_words') AND current_user_can('manage_options')) {
        update_option('words_to_filter', sanitize_text_field(trim($_POST['wordsToFilter']))); ?>
        <div class="updated">
            <p>your words have been saved successfully.</p>
        </div>
    <?php } else { ?>
        <div class="error">
            <p>Sorry! you don't have permission to do that</p>
        </div>
    <?php }   

    }

    // plugin logic
    function filterWords($content) {
        if(get_option('words_to_filter')) {
            $badWords= explode(',', get_option('words_to_filter'));
            $trimedBadWords= array_map('trim', $badWords);
            return str_replace($trimedBadWords, '&&&&', $content);
        }
    }

}



$wordFilter = new WordFilterPlugin();