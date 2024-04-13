<?php
include 'includes/config/common-files.php';
// echo $a->get_session_id() ;
// die('yes');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


if ($a->get_user_session_id() > 0 || $a->get_user_cookie_id() > 0) {
    // die('here we are');
    if (isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] != "") {
        redirect_header(BASE_URL . $_REQUEST['redirect_url']);
    } else {
        redirect_header(BASE_URL . "index.php");
    }
}



// $notifiable_row = $db->fetch_array_by_query('select * from user_profile where email="horacebritton84@gmail.com"');
//  $notifiable_row = $db->fetch_array_by_query('select * from user_profile where email="mohsinmalik866@gmail.com"');

// send_notification('business_approved',$notifiable_row);

if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'sign_up') {
    $user_row = $db->fetch_array_by_query('select * from user_profile where email="' . $_REQUEST['email'] . '"');
    if ($user_row) {
        $_SESSION['error_msg'] = "User Already Exist";
        redirect_header('signup.php');
    }
    
    $arr = array();
    $arr['f_name'] = $_REQUEST['f_name'];
    $arr['l_name'] = $_REQUEST['l_name'];
    $arr['username'] = $_REQUEST['f_name'];
    $arr['email'] = $_REQUEST['email'];
    $arr['user_profile'] = $_REQUEST['user_profile'];
    $arr['password'] = md5($_REQUEST['password']);
    $arr['pass_hint'] = $_REQUEST['password'];
    $arr['term_check'] = $_REQUEST['term_check'];
    // $arr['newsLetter_check'] = $_REQUEST['newsLetter_check'];
    $arr['approve'] = 'no';
    $arr['created_at'] = time();
    $inserted_id = $db->insert($arr, 'user_profile');
    if ($inserted_id > 0) {
        // send_notification('signup',$notifiable_row);
        if($arr['user_profile']=='business'){
            send_notification('signup',$arr);
        }else{
            send_notification('personalSignup',$arr);
        }
        // $imsg->setMessage('Sign Up Successfully!');
        $_SESSION['msg'] = 'Sign Up Successfully!';
        redirect_header('login.php');
    } else {
        $_SESSION['msg'] = 'Error Occure Try Again';

        // $imsg->setMessage('Error Occure Try Again', 'error!');
        redirect_header('signup.php');
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>Signup</title>
</head>
<style>
</style>

<body>
    <?php include 'includes/header.php' ?>
    <section class="bubble_right main_section position-relative mb-5 pb-5" style="background-position: right">
        <div class="bg_images_area">

            <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

            <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
        </div>
        <div class="container position-relative about account_forms">
            <!-- <div class="col-lg-12 clearfix">
                            <div class="span12"> <?php //echo $imsg->getMessage(); 
                                                    ?></div>
                        </div> -->
            <div class="row " style="max-width: 490px;margin: auto">
                <div class="col-md-12 mt-5">
                    <div class="section_heading_box text-center">
                        <h2 class="main_box_heading font-popinns">Sign Up</h2>
                    </div>

                    <?php
                    /*
                    <div class="row my-5 text-center" style="max-width: 300px; margin: auto">
                        <div class="col">
                            <a href="">
                                <span>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="42" height="42" rx="21" fill="#0087D2"></rect>
                                        <path d="M26.8984 21.75L27.4453 18.1562H23.9688V15.8125C23.9688 14.7969 24.4375 13.8594 26 13.8594H27.6016V10.7734C27.6016 10.7734 26.1562 10.5 24.7891 10.5C21.9375 10.5 20.0625 12.2578 20.0625 15.3828V18.1562H16.8594V21.75H20.0625V30.5H23.9688V21.75H26.8984Z" fill="white"></path>
                                    </svg>


                                </span>
                            </a>
                        </div>
                        <div class="col">
                            <a href="">
                                <span>
                                    <svg width="35" height="34" viewBox="0 0 35 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_512_7338)">
                                            <rect width="35" height="34" fill="#2F2929"></rect>
                                            <path d="M20.8298 14.3893L33.8593 0H30.7717L19.4582 12.494L10.4221 0H0L13.6644 18.8932L0 33.9826H3.08776L15.0352 20.7884L24.5779 33.9826H35L20.829 14.3893H20.8298ZM16.6006 19.0596L15.2162 17.1783L4.20032 2.20832H8.94294L17.8328 14.2896L19.2173 16.1709L30.7732 31.8747H26.0306L16.6006 19.0603V19.0596Z" fill="white"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_512_7338">
                                                <rect width="35" height="34" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>


                                </span>
                            </a>
                        </div>
                        <div class="col">
                            <a href="">
                                <span>
                                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="42" height="42" rx="21" fill="#E6021D" />
                                        <path d="M30.5312 20.7344C30.5312 26.2812 26.7422 30.1875 21.1562 30.1875C15.7656 30.1875 11.4688 25.8906 11.4688 20.5C11.4688 15.1484 15.7656 10.8125 21.1562 10.8125C23.7344 10.8125 25.9609 11.7891 27.6406 13.3516L24.9844 15.8906C21.5469 12.5703 15.1406 15.0703 15.1406 20.5C15.1406 23.8984 17.8359 26.6328 21.1562 26.6328C24.9844 26.6328 26.4297 23.8984 26.625 22.4531H21.1562V19.1328H30.375C30.4531 19.6406 30.5312 20.1094 30.5312 20.7344Z" fill="white" />
                                    </svg>



                                </span>
                            </a>
                        </div>
                        <div class="col-12 mt-4">
                            <svg width="204" height="22" viewBox="0 0 204 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M102.545 11.556C102.545 12.522 102.392 13.41 102.086 14.22C101.78 15.024 101.348 15.717 100.79 16.299C100.232 16.881 99.56 17.334 98.774 17.658C97.994 17.976 97.13 18.135 96.182 18.135C95.234 18.135 94.37 17.976 93.59 17.658C92.81 17.334 92.141 16.881 91.583 16.299C91.025 15.717 90.593 15.024 90.287 14.22C89.981 13.41 89.828 12.522 89.828 11.556C89.828 10.59 89.981 9.705 90.287 8.901C90.593 8.091 91.025 7.395 91.583 6.813C92.141 6.225 92.81 5.769 93.59 5.445C94.37 5.121 95.234 4.959 96.182 4.959C97.13 4.959 97.994 5.121 98.774 5.445C99.56 5.769 100.232 6.225 100.79 6.813C101.348 7.395 101.78 8.091 102.086 8.901C102.392 9.705 102.545 10.59 102.545 11.556ZM100.754 11.556C100.754 10.764 100.646 10.053 100.43 9.423C100.214 8.793 99.908 8.262 99.512 7.83C99.116 7.392 98.636 7.056 98.072 6.822C97.508 6.588 96.878 6.471 96.182 6.471C95.492 6.471 94.865 6.588 94.301 6.822C93.737 7.056 93.254 7.392 92.852 7.83C92.456 8.262 92.15 8.793 91.934 9.423C91.718 10.053 91.61 10.764 91.61 11.556C91.61 12.348 91.718 13.059 91.934 13.689C92.15 14.313 92.456 14.844 92.852 15.282C93.254 15.714 93.737 16.047 94.301 16.281C94.865 16.509 95.492 16.623 96.182 16.623C96.878 16.623 97.508 16.509 98.072 16.281C98.636 16.047 99.116 15.714 99.512 15.282C99.908 14.844 100.214 14.313 100.43 13.689C100.646 13.059 100.754 12.348 100.754 11.556ZM106.844 12.618V18H105.107V5.103H108.752C109.568 5.103 110.273 5.187 110.867 5.355C111.461 5.517 111.95 5.754 112.334 6.066C112.724 6.378 113.012 6.756 113.198 7.2C113.384 7.638 113.477 8.13 113.477 8.676C113.477 9.132 113.405 9.558 113.261 9.954C113.117 10.35 112.907 10.707 112.631 11.025C112.361 11.337 112.028 11.604 111.632 11.826C111.242 12.048 110.798 12.216 110.3 12.33C110.516 12.456 110.708 12.639 110.876 12.879L114.638 18H113.09C112.772 18 112.538 17.877 112.388 17.631L109.04 13.023C108.938 12.879 108.827 12.777 108.707 12.717C108.587 12.651 108.407 12.618 108.167 12.618H106.844ZM106.844 11.349H108.671C109.181 11.349 109.628 11.289 110.012 11.169C110.402 11.043 110.726 10.869 110.984 10.647C111.248 10.419 111.446 10.149 111.578 9.837C111.71 9.525 111.776 9.18 111.776 8.802C111.776 8.034 111.521 7.455 111.011 7.065C110.507 6.675 109.754 6.48 108.752 6.48H106.844V11.349Z" fill="#603813" />
                                <line x1="126" y1="12.5" x2="204" y2="12.5" stroke="#FBE50F" />
                                <line y1="12.5" x2="78" y2="12.5" stroke="#FBE50F" />
                            </svg>

                        </div>
                    </div>
                    */
                    ?>
                    <form method="post">
                        <div style="max-width: 400px; margin: auto" class="form-container">


                            <div class="form-group  mb-5">
                                <label for="">User profile</label>
                                <select name="user_profile" id="" class="form-control">
                                    <option value="business">Business</option>
                                    <option value="persional">Personal</option>
                                </select>
                            </div>
                            <div class="form-group  mb-5">
                                <label for="">First Name</label>
                                <div class="input-group mb-3 djustify-content-center">

                                    <input type="text" name="f_name" class="form-control" placeholder="Enter First Name" aria-label="Username">
                                    <span class="input-group-text">
                                        <svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.49219 11.2461C8.73698 11.2461 8.02734 11.1029 7.36328 10.8164C6.69922 10.5299 6.11328 10.1393 5.60547 9.64453C5.11068 9.13672 4.72005 8.55078 4.43359 7.88672C4.14714 7.22266 4.00391 6.51302 4.00391 5.75781C4.00391 4.98958 4.14714 4.27344 4.43359 3.60938C4.72005 2.94531 5.11068 2.36589 5.60547 1.87109C6.11328 1.36328 6.69922 0.966146 7.36328 0.679688C8.02734 0.393229 8.73698 0.25 9.49219 0.25C10.2604 0.25 10.9766 0.393229 11.6406 0.679688C12.3047 0.966146 12.8841 1.36328 13.3789 1.87109C13.8867 2.36589 14.2839 2.94531 14.5703 3.60938C14.8568 4.27344 15 4.98958 15 5.75781C15 6.51302 14.8568 7.22266 14.5703 7.88672C14.2839 8.55078 13.8867 9.13672 13.3789 9.64453C12.8841 10.1393 12.3047 10.5299 11.6406 10.8164C10.9766 11.1029 10.2604 11.2461 9.49219 11.2461ZM9.49219 1.24609C8.88021 1.24609 8.30078 1.36328 7.75391 1.59766C7.20703 1.83203 6.72526 2.15755 6.30859 2.57422C5.90495 2.97786 5.58594 3.45312 5.35156 4C5.11719 4.54688 5 5.13281 5 5.75781C5 6.36979 5.11719 6.94922 5.35156 7.49609C5.58594 8.04297 5.90495 8.52474 6.30859 8.94141C6.72526 9.34505 7.20703 9.66406 7.75391 9.89844C8.30078 10.1328 8.88021 10.25 9.49219 10.25C10.1172 10.25 10.7031 10.1328 11.25 9.89844C11.7969 9.66406 12.2721 9.34505 12.6758 8.94141C13.0924 8.52474 13.418 8.04297 13.6523 7.49609C13.8867 6.94922 14.0039 6.36979 14.0039 5.75781C14.0039 5.13281 13.8867 4.54688 13.6523 4C13.418 3.45312 13.0924 2.97786 12.6758 2.57422C12.2721 2.15755 11.7969 1.83203 11.25 1.59766C10.7031 1.36328 10.1172 1.24609 9.49219 1.24609ZM17.5 20.25H1.50391C1.08724 20.25 0.729167 20.1003 0.429688 19.8008C0.143229 19.5143 0 19.1628 0 18.7461C0 18.7201 0.0520833 18.3685 0.15625 17.6914C0.260417 17.0013 0.61849 16.2526 1.23047 15.4453C1.58203 14.9766 1.9987 14.5599 2.48047 14.1953C2.96224 13.8177 3.5026 13.4987 4.10156 13.2383C4.83073 12.9128 5.64453 12.6654 6.54297 12.4961C7.45443 12.3268 8.4375 12.2422 9.49219 12.2422C10.5599 12.2422 11.543 12.3268 12.4414 12.4961C13.3529 12.6654 14.1732 12.9128 14.9023 13.2383C15.5013 13.4987 16.0417 13.8177 16.5234 14.1953C17.0052 14.5599 17.4219 14.9766 17.7734 15.4453C18.3854 16.2526 18.7435 17.0013 18.8477 17.6914C18.9518 18.3685 19.0039 18.7201 19.0039 18.7461C19.0039 19.1628 18.8542 19.5143 18.5547 19.8008C18.2682 20.1003 17.9167 20.25 17.5 20.25ZM9.49219 13.2578C8.61979 13.2578 7.80599 13.3164 7.05078 13.4336C6.30859 13.5508 5.61849 13.7266 4.98047 13.9609C4.35547 14.1823 3.79557 14.4688 3.30078 14.8203C2.81901 15.1589 2.40234 15.556 2.05078 16.0117C1.54297 16.6888 1.23698 17.3138 1.13281 17.8867C1.04167 18.4596 0.996094 18.7461 0.996094 18.7461C0.996094 18.8893 1.04167 19.0065 1.13281 19.0977C1.23698 19.2018 1.36068 19.2539 1.50391 19.2539H17.5C17.6432 19.2539 17.7604 19.2018 17.8516 19.0977C17.9557 19.0065 18.0078 18.8893 18.0078 18.7461C18.0078 18.7461 17.9557 18.4596 17.8516 17.8867C17.7604 17.3138 17.4544 16.6888 16.9336 16.0117C16.5951 15.556 16.1784 15.1589 15.6836 14.8203C15.1888 14.4688 14.6289 14.1823 14.0039 13.9609C13.3789 13.7266 12.6888 13.5508 11.9336 13.4336C11.1784 13.3164 10.3646 13.2578 9.49219 13.2578Z" fill="#603813" />
                                        </svg>

                                    </span>
                                </div>
                            </div>
                            <div class="form-group  mb-5">
                                <label for="">Last Name</label>
                                <div class="input-group mb-3 djustify-content-center">

                                    <input type="text" name="l_name" class="form-control" placeholder="Enter Last Name" aria-label="Username">
                                    <span class="input-group-text">
                                        <svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.49219 11.2461C8.73698 11.2461 8.02734 11.1029 7.36328 10.8164C6.69922 10.5299 6.11328 10.1393 5.60547 9.64453C5.11068 9.13672 4.72005 8.55078 4.43359 7.88672C4.14714 7.22266 4.00391 6.51302 4.00391 5.75781C4.00391 4.98958 4.14714 4.27344 4.43359 3.60938C4.72005 2.94531 5.11068 2.36589 5.60547 1.87109C6.11328 1.36328 6.69922 0.966146 7.36328 0.679688C8.02734 0.393229 8.73698 0.25 9.49219 0.25C10.2604 0.25 10.9766 0.393229 11.6406 0.679688C12.3047 0.966146 12.8841 1.36328 13.3789 1.87109C13.8867 2.36589 14.2839 2.94531 14.5703 3.60938C14.8568 4.27344 15 4.98958 15 5.75781C15 6.51302 14.8568 7.22266 14.5703 7.88672C14.2839 8.55078 13.8867 9.13672 13.3789 9.64453C12.8841 10.1393 12.3047 10.5299 11.6406 10.8164C10.9766 11.1029 10.2604 11.2461 9.49219 11.2461ZM9.49219 1.24609C8.88021 1.24609 8.30078 1.36328 7.75391 1.59766C7.20703 1.83203 6.72526 2.15755 6.30859 2.57422C5.90495 2.97786 5.58594 3.45312 5.35156 4C5.11719 4.54688 5 5.13281 5 5.75781C5 6.36979 5.11719 6.94922 5.35156 7.49609C5.58594 8.04297 5.90495 8.52474 6.30859 8.94141C6.72526 9.34505 7.20703 9.66406 7.75391 9.89844C8.30078 10.1328 8.88021 10.25 9.49219 10.25C10.1172 10.25 10.7031 10.1328 11.25 9.89844C11.7969 9.66406 12.2721 9.34505 12.6758 8.94141C13.0924 8.52474 13.418 8.04297 13.6523 7.49609C13.8867 6.94922 14.0039 6.36979 14.0039 5.75781C14.0039 5.13281 13.8867 4.54688 13.6523 4C13.418 3.45312 13.0924 2.97786 12.6758 2.57422C12.2721 2.15755 11.7969 1.83203 11.25 1.59766C10.7031 1.36328 10.1172 1.24609 9.49219 1.24609ZM17.5 20.25H1.50391C1.08724 20.25 0.729167 20.1003 0.429688 19.8008C0.143229 19.5143 0 19.1628 0 18.7461C0 18.7201 0.0520833 18.3685 0.15625 17.6914C0.260417 17.0013 0.61849 16.2526 1.23047 15.4453C1.58203 14.9766 1.9987 14.5599 2.48047 14.1953C2.96224 13.8177 3.5026 13.4987 4.10156 13.2383C4.83073 12.9128 5.64453 12.6654 6.54297 12.4961C7.45443 12.3268 8.4375 12.2422 9.49219 12.2422C10.5599 12.2422 11.543 12.3268 12.4414 12.4961C13.3529 12.6654 14.1732 12.9128 14.9023 13.2383C15.5013 13.4987 16.0417 13.8177 16.5234 14.1953C17.0052 14.5599 17.4219 14.9766 17.7734 15.4453C18.3854 16.2526 18.7435 17.0013 18.8477 17.6914C18.9518 18.3685 19.0039 18.7201 19.0039 18.7461C19.0039 19.1628 18.8542 19.5143 18.5547 19.8008C18.2682 20.1003 17.9167 20.25 17.5 20.25ZM9.49219 13.2578C8.61979 13.2578 7.80599 13.3164 7.05078 13.4336C6.30859 13.5508 5.61849 13.7266 4.98047 13.9609C4.35547 14.1823 3.79557 14.4688 3.30078 14.8203C2.81901 15.1589 2.40234 15.556 2.05078 16.0117C1.54297 16.6888 1.23698 17.3138 1.13281 17.8867C1.04167 18.4596 0.996094 18.7461 0.996094 18.7461C0.996094 18.8893 1.04167 19.0065 1.13281 19.0977C1.23698 19.2018 1.36068 19.2539 1.50391 19.2539H17.5C17.6432 19.2539 17.7604 19.2018 17.8516 19.0977C17.9557 19.0065 18.0078 18.8893 18.0078 18.7461C18.0078 18.7461 17.9557 18.4596 17.8516 17.8867C17.7604 17.3138 17.4544 16.6888 16.9336 16.0117C16.5951 15.556 16.1784 15.1589 15.6836 14.8203C15.1888 14.4688 14.6289 14.1823 14.0039 13.9609C13.3789 13.7266 12.6888 13.5508 11.9336 13.4336C11.1784 13.3164 10.3646 13.2578 9.49219 13.2578Z" fill="#603813" />
                                        </svg>

                                    </span>
                                </div>
                            </div>
                            <div class="form-group  mb-5">
                                <label for="">Email Address</label>
                                <div class="input-group mb-3 djustify-content-center">

                                    <input type="text" name="email" class="form-control" placeholder="Enter Email" aria-label="Username">
                                    <span class="input-group-text">
                                        <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.9102 4.79688L10.6055 0.34375C10.4622 0.252604 10.293 0.18099 10.0977 0.128906C9.90234 0.0768229 9.70052 0.0507812 9.49219 0.0507812C9.29688 0.0507812 9.10156 0.0768229 8.90625 0.128906C8.71094 0.18099 8.53516 0.252604 8.37891 0.34375L1.09375 4.79688C0.78125 4.99219 0.520833 5.27865 0.3125 5.65625C0.104167 6.02083 0 6.38542 0 6.75V15.7539C0 16.1706 0.143229 16.5286 0.429688 16.8281C0.729167 17.1146 1.08724 17.2578 1.50391 17.2578H17.5C17.9167 17.2578 18.2682 17.1146 18.5547 16.8281C18.8542 16.5286 19.0039 16.1706 19.0039 15.7539V6.75C19.0039 6.38542 18.8997 6.02083 18.6914 5.65625C18.4831 5.27865 18.2227 4.99219 17.9102 4.79688ZM1.62109 5.65625L8.90625 1.20312C8.98438 1.15104 9.07552 1.11198 9.17969 1.08594C9.28385 1.0599 9.38802 1.04688 9.49219 1.04688C9.60938 1.04688 9.72005 1.0599 9.82422 1.08594C9.92839 1.11198 10.0195 1.15104 10.0977 1.20312L17.3828 5.65625C17.4609 5.70833 17.5326 5.77344 17.5977 5.85156C17.6758 5.92969 17.7409 6.01432 17.793 6.10547L10.0586 11.2812C9.91536 11.3724 9.72656 11.418 9.49219 11.418C9.27083 11.418 9.08854 11.3724 8.94531 11.2812L1.19141 6.10547C1.25651 6.01432 1.32161 5.92969 1.38672 5.85156C1.46484 5.77344 1.54297 5.70833 1.62109 5.65625ZM17.5 16.2422H1.50391C1.36068 16.2422 1.23698 16.1966 1.13281 16.1055C1.04167 16.0013 0.996094 15.8841 0.996094 15.7539V7.17969L8.39844 12.1016C8.55469 12.2057 8.72396 12.2839 8.90625 12.3359C9.10156 12.388 9.29688 12.4141 9.49219 12.4141C9.70052 12.4141 9.89583 12.388 10.0781 12.3359C10.2734 12.2839 10.4492 12.2057 10.6055 12.1016L18.0078 7.17969V15.7539C18.0078 15.8841 17.9557 16.0013 17.8516 16.1055C17.7604 16.1966 17.6432 16.2422 17.5 16.2422Z" fill="#603813" />
                                        </svg>


                                    </span>
                                </div>
                            </div>

                            <div class="form-group  mb-5">
                                <label for="">Password</label>
                                <div class="input-group mb-3 djustify-content-center">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                                    <span class="input-group-text toggle-password" id="togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group checkbox_area ">
                            <label> <input type="checkbox" name="term_check" class="p-4" valuse="yes" required><span>You must accept <a class="text-decoration-none" href="terms-and-conditions.php" target="_blank"><b class="text-green "> Terms and Conditions</b></a> before registering</span></label>
                        </div>
                        <div class="form-group checkbox_area  mb-5">
                            <label> <input type="checkbox" name="newsLetter_check" valuse="yes" class="p-4"><span>Subscribe to our Newsletter</span></label>
                        </div>
                        <button class="submit_button d-block  btn load_more w-100 py-3" name="command" value="sign_up">Sign Up</button>
                        <p class="login_info text-center mt-5">Already have an account? <a href="login.php">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <?php include 'includes/footer.php' ?>
    <script>
        $('.slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            centerMode: true,
            variableWidth: true,
            infinite: true,
            focusOnSelect: true,
            // cssEase: 'linear',
            touchMove: true,
            prevArrow: '<button class="slick-prev"> < </button>',
            nextArrow: '<button class="slick-next"> > </button>',

            //         responsive: [
            //             {
            //               breakpoint: 576,
            //               settings: {
            //                 centerMode: false,
            //                 variableWidth: false,
            //               }
            //             },
            //         ]
        });


        // var imgs = $('.slider img');
        // imgs.each(function(){
        //     var item = $(this).closest('.item');
        //     item.css({
        //         'background-image': 'url(' + $(this).attr('src') + ')',
        //         'background-position': 'center',
        //         '-webkit-background-size': 'cover',
        //         'background-size': 'cover',
        //     });
        //     $(this).hide();
        // });

        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                var passwordInput = $('#password');
                var type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);

                // Change the eye icon based on the password visibility
                $(this).html(type === 'password' ? '<i class="fa fa-eye" aria-hidden="true"></i>' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>');
            });
        });

        $(document).ready(function() {
            $('input[type="text"]').prop('required', true);
        });

        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        <?php
        if (isset($_SESSION['msg']) && $_SESSION['msg'] !== '') {
            echo "toastr.success(" . json_encode($_SESSION['msg']) . ");";
        }

        if (isset($_SESSION['error_msg']) && $_SESSION['error_msg'] !== '') {
            echo "toastr.error(" . json_encode($_SESSION['error_msg']) . ");";
        }
        unset($_SESSION['error_msg']);
        unset($_SESSION['msg']);


        ?>
    </script>
</body>

</html>