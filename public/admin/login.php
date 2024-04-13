<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include 'includes/common-files.php';

if ($a->get_session_id() > 0 || $a->get_cookie_id() > 0) {
  if (isset($_REQUEST['redirect_url']) && $_REQUEST['redirect_url'] != "") {
    redirect_header(ADMIN_URL . $_REQUEST['redirect_url']);
  } else {
    redirect_header(ADMIN_URL . "index.php");
  }
}
if (isset($_POST['cmd']) && $_POST['cmd'] == "Login") {
  // die('hi here wa');
  //if($_SESSION['recaptchaValidation']=="success"){
  if (isset($_POST['type']) && $_POST['type'] == 'cookie') {
    $verify = $a->check_login($_POST['username'], md5($_POST['password']), 'cookie');
  } else {
    $verify = $a->check_login($_POST['username'], md5($_POST['password']));
  }
  if (!$verify) {
    $imsg->setMessage("Invalid Username or Password! Please Give Valid Information.", 'error');
  } else {
    //              unset($_SESSION['recaptchaValidation']);
  }
  // }
}
?>
<!DOCTYPE html>

<html lang="en">



<head>

  <?php include('includes/site-master.php') ?>



</head>

<body class="bg-gradient-login">

  <!-- Login Content -->

  <div class="container-login">
    <div class="row">
      <div class="col-lg-12"><?php echo $imsg->getMessage(true); ?></div>
    </div>

    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-12 col-md-9">

        <div class="card shadow-sm my-5">

          <div class="card-body p-0">

            <div class="row">

              <div class="col-lg-12">

                <div class="login-form">

                  <div class="text-center">

                    <h1 class="h4 text-gray-900 mb-4">Login</h1>

                  </div>

                  <form class="user" method="POST">

                    <div class="form-group">

                      <input type="text" name="username" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address or username">

                    </div>

                    <div class="form-group">

                      <input type="password" name="password" class="form-control" id="exampleInputPassword" placeholder="Password">

                    </div>

                    <div class="form-group">

                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">

                        <input type="checkbox" name="type" value="cookie" class="custom-control-input" id="customCheck">

                        <label class="custom-control-label" for="customCheck">Remember

                          Me</label>

                      </div>

                    </div>

                    <div class="form-group">

                      <button name="cmd" value="Login" class="btn btn-primary btn-block">Login</a>

                    </div>



                  </form>

                  <hr>



                  <div class="text-center">

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

  <!-- Login Content -->

  <?php include('includes/commonjs.php') ?>

</body>



</html>