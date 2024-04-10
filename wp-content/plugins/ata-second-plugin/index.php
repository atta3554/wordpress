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
    }

    function ourMenu() {
        add_menu_page('words Filter plugin', 'Word Filter', 'manage_options', 'ataWordFilter', array($this, 'wordFilterPage'), 'dashicons-smiley', 100);
        add_submenu_page('ataWordFilter', 'words Filter plugin', 'Words List', 'manage_options', 'ataWordFilter', array($this, 'wordFilterPage'));
        add_submenu_page('ataWordFilter', 'words Filter plugin options', 'Options', 'manage_options', 'word-filter-options', array($this, 'wordFiltersubPage'));
    }

    function wordFiltersubPage() { ?>
        Hello
    <?php }

    function wordFilterPage() { ?>
        Hello World
    <?php }
}



$wordFilter = new WordFilterPlugin();