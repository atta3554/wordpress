<?php 
/*
  plugin Name: ataFirstBlockType
  Description: my First Block Type Plugin
  Version: 0.1
  Author: ata
*/

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

class AtaFirstBlock {
    function __construct() {
        add_action('enqueue_block_editor_assets', array($this, 'adminAssets'));
    }

    function adminAssets() {
        wp_enqueue_script('ataBlockJs', plugin_dir_url(__FILE__) . 'ataFirstBlock.js', array('wp-blocks'));
    }
}

$ataFirstBlock = new AtaFirstBlock();