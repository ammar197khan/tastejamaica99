<?php

include 'includes/config/common-files.php';
$notifications_arr1 = array('signup' => 
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


function send_notification1($type, $arr)
{
    global $notifications_arr1, $domain,$db;
    $notification_file = $notifications_arr1[$type]['file'];
    // echo $notification_file;
    // die();
    $notification_subject = $notifications_arr1[$type]['subject'];
    $user_name = $arr['f_name'] . ' ' . $arr['l_name'];
    $to = $arr['email'];
    if($type=='forget_password'){
        $otp_row=$db->fetch_array_by_query('select * from forget_passwords where user_id ='.intval($arr['id']).' order by id desc');
    }
    if($type=='business_approved'){
        $business_row=$db->fetch_array_by_query('select * from get_listed where user_id ='.intval($arr['id']).' order by id desc');
    }
    include 'taste-jamaica-smtp.php';
    // include 'hostinger-email.php';

    return true;
}

 $notifiable_row = $db->fetch_array_by_query('select * from user_profile where email="horacebritton84@gmail.com"');
 $notifiable_row['email']='fixitdevelopers01@gmail.com';
//  $notifiable_row = $db->fetch_array_by_query('select * from user_profile where email="mohsinmalik866@gmail.com"');

send_notification1('business_approved',$notifiable_row);
?>