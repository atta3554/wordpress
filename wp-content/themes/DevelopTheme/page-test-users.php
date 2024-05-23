<?php 

if(! defined('ABSPATH')) exit;  //Exit if accessed directly

$users = get_users();
// print_r($users);

foreach ($users as $key => $value) {
    print_r($value->data);
}
?>