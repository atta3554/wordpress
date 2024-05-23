<?php

/*
  plugin name: word Count Plugin
  description: a simple plugin that counts words and characters and estimates read time for posts
  version: 1.0
  Author: ata
  Text Domain: wcpdomain
  Domain Path: /languages 
*/

class AtaFirstPlugin{
    function __construct() {
        add_action('admin_menu', array($this, 'AdminPage')); //show plugin option in dashboard settings menu
        add_action('admin_init', array($this, 'setSettings')); //set demanding settings and capatibilities for plugin setting page
        add_filter('the_content', array($this, 'showInfo'));
        add_action('init', array($this, 'translatePlugin'));
    }

    function translatePlugin() {
        load_plugin_textdomain('wcpdomain', false, dirname(plugin_basename(__FILE__)). '/languages');
    }

    function showInfo($content) {
        if( (is_main_query() AND is_single() AND get_post_type() == 'post') AND
            (get_option('wcp-wordcount', '1') OR get_option('wcp-charCount', '0') OR get_option('wcp-readTime', '1')) ) {

            $html = '<h3>' . esc_html(get_option('wcp-headline', 'Post Statistics')) . '</h3><p>';
        
            if(get_option('wcp-wordcount', '1') OR get_option('wcp-readTime', '1')) {
                $wordCount = str_word_count(strip_tags($content));
            }

            if(get_option('wcp-wordcount', '1')) {
                $html .= esc_html__('This Post Has', 'wcpdomain') . ' ' . $wordCount . ' ' . esc_html__('Words', 'wcpdomain') . '.<br>';
            }

            if(get_option('wcp-charCount', '0')) {
                $html .= esc_html__('This Post Has', 'wcpdomain') . ' ' . strlen(strip_tags($content)) . ' ' . esc_html__('Characters', 'wcpdomain') . '.<br>';
            }

            if(get_option('wcp-readTime', '1')) {
                $html .= esc_html__('This Post Takes', 'wcpdomain') . ' ' . round($wordCount/225) . ' ' . esc_html__('Minute(s) To Read', 'wcpdomain') . '.<br>';
            }

            $html .= '</p>';

            if(get_option('wcp-Location', '0') == '0') {
                return $html . $content; 
            }
            return $content . $html;
        }

        return $content;
    }

    function setSettings() {
        // Display Location Settings
        register_setting('wordCountPlugin', 'wcp-Location', array('sanitize_callback'=> array($this, 'sanitize_wcp_location'), 'default'=> '0'));
        add_settings_field('wcp-Location', 'Display Location', array($this, 'displayLocationHTML'), 'word-count-settings', 'wcp_first_section');

        // HeadLine Text Settings
        register_setting('wordCountPlugin', 'wcp-headline', array('sanitize_callback'=> 'sanitize_text_field', 'default'=> 'Post Statistics'));
        add_settings_field('wcp-headline', 'Headline Text', array($this, 'displayHeadlineHTML'), 'word-count-settings', 'wcp_first_section');

        // word Count Settings
        register_setting('wordCountPlugin', 'wcp-wordcount', array('sanitize_callback'=> 'sanitize_text_field', 'default'=> '1'));
        add_settings_field('wcp-wordcount', 'word count', array($this, 'checkBoxHTML'), 'word-count-settings', 'wcp_first_section', array('theName'=> "wcp-wordcount"));
        
        // character Count Settings
        register_setting('wordCountPlugin', 'wcp-charCount', array('sanitize_callback'=> 'sanitize_text_field', 'default'=> '0'));
        add_settings_field('wcp-charCount', 'character Count', array($this, 'checkBoxHTML'), 'word-count-settings', 'wcp_first_section', array('theName'=> "wcp-charCount"));

        // Read Time Settings
        register_setting('wordCountPlugin', 'wcp-readTime', array('sanitize_callback'=> 'sanitize_text_field', 'default'=> '1'));
        add_settings_field('wcp-readTime', 'Read Time', array($this, 'checkBoxHTML'), 'word-count-settings', 'wcp_first_section', array('theName'=> "wcp-readTime"));

        add_settings_section('wcp_first_section', null, null, 'word-count-settings');
    }

    function sanitize_wcp_location($input) {
        if($input != '0' AND $input != '1') {
            add_settings_error('wcp-Location', 'wcp_location_err', "don't try to manipulate Datas");
            return get_option('wcp-Location');
        }
        return $input;
    }

    // reusable checkBoxHTML function
    function checkBoxHTML($args) { ?> 
        <input type="checkbox" value="1" name="<?php echo $args['theName'] ?>" <?php checked(get_option($args['theName']), '1') ?> >
    <?php }

    /*function displayreadTimeHTML () {?>
        <input type="checkbox" name="wcp-readTime" value='1' <?php checked(get_option('wcp-readTime'), '1') ?> >
    <?php }

    function displaycharCountHTML() {?> 
        <input type="checkbox" name="wcp-charCount" value='1' <?php checked(get_option('wcp-charCount'), '1') ?> >
    <?php }

    function displayWordCountHTML () {?> 
        <input type="checkbox" name="wcp-wordcount" value='1' <?php checked(get_option('wcp-wordcount'), '1') ?> >
    <?php } */

    function displayHeadlineHTML() {?> 
        <input type="text" name="wcp-headline" value="<?php echo esc_attr(get_option('wcp-headline')) ?>" >
    <?php } 
    

    function displayLocationHTML() { ?>
        <select name="wcp-Location">
            <option value="0" <?php selected(get_option('wcp-Location'), '0') ?> >Beginning of the Post</option>
            <option value="1" <?php selected(get_option('wcp-Location'), '1') ?> >End of the Post</option>
        </select>
    <?php }

    function AdminPage() {
        add_options_page('word count settings', esc_html__('word count', 'wcpdomain'), 'manage_options', 'word-count-settings', array($this, 'showContent'));
    }

    function showContent() { ?>
        <div class="wrap">
            <h1>word count settings page</h1>
        </div>
        <form action="options.php" method="POST">
            <?php 
            settings_fields('wordCountPlugin');
            do_settings_sections('word-count-settings');
            submit_button();
            ?>
        </form>
    <?php }
}


$ataFirstPlugin = new AtaFirstPlugin();