<?php 
$users = get_users();
// print_r($users);

foreach ($users as $key => $value) {
    print_r($value->data);
}
?>