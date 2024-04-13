<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include 'includes/config/common-files.php';
// echo $a->get_session_id() ;
// print_r($_SESSION);
// die();

if ($a->get_user_session_id() > 0 || $a->get_user_cookie_id() > 0) {
    if (isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] != "") {
        redirect_header(BASE_URL . $_REQUEST['redirect_url']);
    } else {
        redirect_header(BASE_URL . "index.php");
    }
}
function generate_email($email, $otp)
{
    $htmlContent = "your otp is " . $otp;
    $subject = 'Forget Password';
    $user_email = $email;
    $to = $email;
    $_SESSION['otp_email'] = $to;
    include 'email.php';
    // die('yes');
    
}
if (isset($_POST['cmd']) && $_POST['cmd'] == "new-password") {
    // echo '<pre>';
    // print_r($_REQUEST);
    // print_r($_SESSION);
    // die();
    $arr=array();
    $arr['password']=md5($_REQUEST['newPass']);
    $arr['pass_hint']=$_REQUEST['newPass'];
    $db->update(intval($_SESSION['forget_row_id']),$arr,'user_profile');
    $_SESSION['msg']='Successfully update password';
    header('location:login.php');
}
if (isset($_POST['cmd']) && $_POST['cmd'] == "match-otp") {
    // echo '<pre>';
    // print_r($_SESSION);
    $forget_row = $db->fetch_array_by_query('select * from forget_passwords where email="' . $_SESSION['otp_email'] . '" and otp="' . $_POST['otp'] . '" order by id desc');
    if ($forget_row) {
        $_SESSION['otp_msg'] = 'OTP matched successfully ! Enter new password';
        header('location:forget-password.php?cmd=otp_matched');
    }

    die('no record found');
}
if (isset($_POST['cmd']) && $_POST['cmd'] == "forget-password") {
    // echo '<pre>';
    // print_r($_POST);
    // die();
    $user = $db->fetch_array_by_query('select * from user_profile where email="' . $_POST['username'] . '"');
    if ($user) {
        $_SESSION['forget_row_id'] = intval($user['id']);
        $otp = rand(0000, 9999);
        $arr = array();
        $arr['user_id'] = intval($user['id']);
        $arr['email'] = $user['email'];
        $arr['otp'] = $otp;
        $arr['created_at'] = time();
        $res = $db->insert($arr, 'forget_passwords');
        if ($res) {
            // $email_template = generate_email($user['email'], $otp);
            $_SESSION['otp_email'] = $user['email'];
            send_notification('forget_password',$user);
            $_SESSION['otp_msg'] = 'OTP sent to your email successfully !';
    header('location:forget-password.php?cmd=otp_sent');
        } else {
            $_SESSION['otp_error'] = 'error in insertion';
            header('location:forget-password.php');
        }
    } else {
        // die('here');
        $_SESSION['otp_error'] = 'no record found';
        // print_r($_SESSION);
        // die();
        header('location:forget-password.php');
    }
}
// die('here we are ');
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>forget password</title>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section class="bubble_right main_section position-relative mb-5 pb-5" style="background-position: right">
        <div class="bg_images_area">

            <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

            <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
        </div>
        <div class="container position-relative about account_forms">
            <div class="row " style="max-width: 400px;margin: auto">
                <div class="col-md-12 mt-5">
                    <div class="section_heading_box text-center">
                        <h2 class="main_box_heading font-popinns">Forget Password</h2>
                    </div>
                    <div class="row my-5 text-center" style="max-width: 300px; margin: auto">


                        <div class="col-12 mt-4">
                            <!-- <svg width="204" height="22" viewBox="0 0 204 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M102.545 11.556C102.545 12.522 102.392 13.41 102.086 14.22C101.78 15.024 101.348 15.717 100.79 16.299C100.232 16.881 99.56 17.334 98.774 17.658C97.994 17.976 97.13 18.135 96.182 18.135C95.234 18.135 94.37 17.976 93.59 17.658C92.81 17.334 92.141 16.881 91.583 16.299C91.025 15.717 90.593 15.024 90.287 14.22C89.981 13.41 89.828 12.522 89.828 11.556C89.828 10.59 89.981 9.705 90.287 8.901C90.593 8.091 91.025 7.395 91.583 6.813C92.141 6.225 92.81 5.769 93.59 5.445C94.37 5.121 95.234 4.959 96.182 4.959C97.13 4.959 97.994 5.121 98.774 5.445C99.56 5.769 100.232 6.225 100.79 6.813C101.348 7.395 101.78 8.091 102.086 8.901C102.392 9.705 102.545 10.59 102.545 11.556ZM100.754 11.556C100.754 10.764 100.646 10.053 100.43 9.423C100.214 8.793 99.908 8.262 99.512 7.83C99.116 7.392 98.636 7.056 98.072 6.822C97.508 6.588 96.878 6.471 96.182 6.471C95.492 6.471 94.865 6.588 94.301 6.822C93.737 7.056 93.254 7.392 92.852 7.83C92.456 8.262 92.15 8.793 91.934 9.423C91.718 10.053 91.61 10.764 91.61 11.556C91.61 12.348 91.718 13.059 91.934 13.689C92.15 14.313 92.456 14.844 92.852 15.282C93.254 15.714 93.737 16.047 94.301 16.281C94.865 16.509 95.492 16.623 96.182 16.623C96.878 16.623 97.508 16.509 98.072 16.281C98.636 16.047 99.116 15.714 99.512 15.282C99.908 14.844 100.214 14.313 100.43 13.689C100.646 13.059 100.754 12.348 100.754 11.556ZM106.844 12.618V18H105.107V5.103H108.752C109.568 5.103 110.273 5.187 110.867 5.355C111.461 5.517 111.95 5.754 112.334 6.066C112.724 6.378 113.012 6.756 113.198 7.2C113.384 7.638 113.477 8.13 113.477 8.676C113.477 9.132 113.405 9.558 113.261 9.954C113.117 10.35 112.907 10.707 112.631 11.025C112.361 11.337 112.028 11.604 111.632 11.826C111.242 12.048 110.798 12.216 110.3 12.33C110.516 12.456 110.708 12.639 110.876 12.879L114.638 18H113.09C112.772 18 112.538 17.877 112.388 17.631L109.04 13.023C108.938 12.879 108.827 12.777 108.707 12.717C108.587 12.651 108.407 12.618 108.167 12.618H106.844ZM106.844 11.349H108.671C109.181 11.349 109.628 11.289 110.012 11.169C110.402 11.043 110.726 10.869 110.984 10.647C111.248 10.419 111.446 10.149 111.578 9.837C111.71 9.525 111.776 9.18 111.776 8.802C111.776 8.034 111.521 7.455 111.011 7.065C110.507 6.675 109.754 6.48 108.752 6.48H106.844V11.349Z" fill="#603813" />
                                <line x1="126" y1="12.5" x2="204" y2="12.5" stroke="#FBE50F" />
                                <line y1="12.5" x2="78" y2="12.5" stroke="#FBE50F" />
                            </svg> -->


                        </div>
                    </div>
                    <form action="" method="post">
                        <div class="form-group  mb-3">
                            <?php if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'otp_sent') {
                                $cmd = 'match-otp';
                                $btnText = 'Submit OTP';

                            ?>

                                <label for="">OTP</label>
                                <div class="input-group mb-3 djustify-content-center">

                                    <input type="number" name="otp" class="form-control" aria-label="Username">

                                </div>

                            <?php } else if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'otp_matched') {
                                $cmd = 'new-password';
                                $btnText = 'Update Password';
                            ?>
                                <label for="">New Password</label>
                                <div class="input-group mb-3 djustify-content-center">

                                    <input type="number" name="newPass" class="form-control" aria-label="Username">

                                </div>

                            <?php
                            } else {
                                $cmd = 'forget-password';
                                $btnText = 'Forget Password';

                            ?>
                                <label for="">Email Address</label>
                                <div class="input-group mb-3 djustify-content-center">

                                    <input type="email" name="username" class="form-control" aria-label="Username">
                                    <span class="input-group-text">
                                        <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.9102 4.79688L10.6055 0.34375C10.4622 0.252604 10.293 0.18099 10.0977 0.128906C9.90234 0.0768229 9.70052 0.0507812 9.49219 0.0507812C9.29688 0.0507812 9.10156 0.0768229 8.90625 0.128906C8.71094 0.18099 8.53516 0.252604 8.37891 0.34375L1.09375 4.79688C0.78125 4.99219 0.520833 5.27865 0.3125 5.65625C0.104167 6.02083 0 6.38542 0 6.75V15.7539C0 16.1706 0.143229 16.5286 0.429688 16.8281C0.729167 17.1146 1.08724 17.2578 1.50391 17.2578H17.5C17.9167 17.2578 18.2682 17.1146 18.5547 16.8281C18.8542 16.5286 19.0039 16.1706 19.0039 15.7539V6.75C19.0039 6.38542 18.8997 6.02083 18.6914 5.65625C18.4831 5.27865 18.2227 4.99219 17.9102 4.79688ZM1.62109 5.65625L8.90625 1.20312C8.98438 1.15104 9.07552 1.11198 9.17969 1.08594C9.28385 1.0599 9.38802 1.04688 9.49219 1.04688C9.60938 1.04688 9.72005 1.0599 9.82422 1.08594C9.92839 1.11198 10.0195 1.15104 10.0977 1.20312L17.3828 5.65625C17.4609 5.70833 17.5326 5.77344 17.5977 5.85156C17.6758 5.92969 17.7409 6.01432 17.793 6.10547L10.0586 11.2812C9.91536 11.3724 9.72656 11.418 9.49219 11.418C9.27083 11.418 9.08854 11.3724 8.94531 11.2812L1.19141 6.10547C1.25651 6.01432 1.32161 5.92969 1.38672 5.85156C1.46484 5.77344 1.54297 5.70833 1.62109 5.65625ZM17.5 16.2422H1.50391C1.36068 16.2422 1.23698 16.1966 1.13281 16.1055C1.04167 16.0013 0.996094 15.8841 0.996094 15.7539V7.17969L8.39844 12.1016C8.55469 12.2057 8.72396 12.2839 8.90625 12.3359C9.10156 12.388 9.29688 12.4141 9.49219 12.4141C9.70052 12.4141 9.89583 12.388 10.0781 12.3359C10.2734 12.2839 10.4492 12.2057 10.6055 12.1016L18.0078 7.17969V15.7539C18.0078 15.8841 17.9557 16.0013 17.8516 16.1055C17.7604 16.1966 17.6432 16.2422 17.5 16.2422Z" fill="#603813" />
                                        </svg>


                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- <div class="form-group  mb-3">
                            <label for="">Password</label>
                            <div class="input-group mb-3 djustify-content-center">

                                <div class="input-group mb-3 djustify-content-center">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                                        <span class="input-group-text toggle-password" id="togglePassword"><i class="fa fa-eye" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group checkbox_area ">
                            <input type="hidden" name="cmd" value="<?= $cmd; ?>" />
                        </div>
                        <button class="submit_button d-block  btn load_more w-100 py-3"><?= $btnText; ?></button>
                        <p class="login_info text-center mt-5">have password? <a href="login.php">Login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>


    <?php include 'includes/footer.php' ?>
    <script>
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
        if (isset($_SESSION['otp_msg']) && $_SESSION['otp_msg'] !== '') {
            echo "toastr.success(" . json_encode($_SESSION['otp_msg']) . ");";
        }

        if (isset($_SESSION['otp_error']) && $_SESSION['otp_error'] !== '') {
            echo "toastr.error(" . json_encode($_SESSION['otp_error']) . ");";
        }
        unset($_SESSION['otp_msg']);
        unset($_SESSION['otp_error']);


        ?>
    </script>

</body>

</html>