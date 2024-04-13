<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING);
// $path_includes = str_replace("/includes", "", dirname(__FILE__)) . "/";
$path_includes =  dirname(__FILE__) . "/";
$domain = $_SERVER['HTTP_HOST'];
// echo $path_includes;
// die();
require_once($path_includes . "configuration/config.php");
require_once($path_includes . "configuration/functions.php");
$db = load_class('Database');
$imsg = load_class('InfoMessages');
$a = load_class('UserAuth');
$auth_id = $a->get_user_session_id();
$auth_row = $a->auth_row($db);
// print_r($auth_row);
// die();
// echo intval($auth_id);
$file_name = basename(parse_url(basename($_SERVER['REQUEST_URI']), PHP_URL_PATH));
// DIE('YES');

$parish_dropdown = array(
    "Clarendon" => "Clarendon",
    "Hanover" => "Hanover",
    "Kingston" => "Kingston",
    "Manchester" => "Manchester",
    "Portland" => "Portland",
    "Saint_Andrew" => "Saint Andrew",
    "Saint_Ann" => "Saint Ann",
    "Saint_Catherine" => "Saint Catherine",
    "Saint_Elizabeth" => "Saint Elizabeth",
    "Saint_James" => "Saint James",
    "Saint_Mary" => "Saint Mary",
    "Saint_Thomas" => "Saint Thomas",
    "Trelawny" => "Trelawny",
    "Westmoreland" => "Westmoreland"
);

$notifications_arr = array('signup' => 
array(
    'file' => 'notifications/signup-notification.php', 
    'subject' => 'Welcome to Taste Jamaica '
),
 'personalSignup' => array(
    'file' => 'notifications/personal-profile-notification.php', 
    'subject' => 'Welcome to Taste Jamaica - Your Culinary Adventure Begins!'
 ),
 'getListed' => array(
    'file' => 'notifications/getlisted-notification.php', 
    'subject' => 'Restaurant Listing Submission Received - Taste Jamaica'
 ),
 'forget_password' => array(
    'file' => 'notifications/forget-notification.php', 
    'subject' => 'Taste Jamaica Password Reset Request'
 ),
 'business_approved' => array(
    'file' => 'notifications/business-approval-notification.php', 
    'subject' => 'Congratulations! Your Restaurant Listing is Approved on Taste Jamaica'
)
);


function send_notification($type, $arr)
{
    global $notifications_arr, $domain,$db;
    $notification_file = $notifications_arr[$type]['file'];
    $notification_subject = $notifications_arr[$type]['subject'];
    $user_name = $arr['f_name'] . ' ' . $arr['l_name'];
    $to = $arr['email'];
    if($type=='forget_password'){
        $otp_row=$db->fetch_array_by_query('select * from forget_passwords where user_id ='.intval($arr['id']).' order by id desc');
    }
    if($type=='business_approved'){
        $business_row=$db->fetch_array_by_query('select * from get_listed where user_id ='.intval($arr['id']).' order by id desc');
    }
    // include 'hostinger-email.php';
    include 'taste-jamaica-smtp.php';

    return true;
}
