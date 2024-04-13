<?php 
include 'includes/config/common-files.php';
// $arr=array();
// $arr['locked']='yes';
// $db->update(intval($auth_row['id']),$arr,'user_profile');
$db->delete(intval($auth_row['id']),'user_profile');
$a->logout();
// die('here we are ');
?>