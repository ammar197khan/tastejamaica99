<?php
include 'includes/config/common-files.php';
$a->authenticate();

define('FILE_URL', 'outer_docx/');
define('FILE_DIR', 'outer_docx/');
$data_row = $db->fetch_array_by_query('select * from get_listed where id='.intval($_REQUEST['id']));


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


?>
<!doctype html>
<html lang="en">

<head>
    <head>
        <?php include 'includes/site-master.php' ?>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <title>Approved Business</title>
    </head>
</head>

<body>
<?php include 'includes/header.php' ?>
    <section class="main_section position-relative mb-5 bubble_right" style="background-position: right">
        <div class="bg_images_area">

            <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

            <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
        </div>
        <div class="container position-relative " style="max-width: 800px;margin: auto">
            <div class="col-12">
                <h1 class="main_heading font-sacramento">Search. Discover. Experience</h1>
                <h2 class="sub_heading font-popinns mb-1">Taste Jamaica</h2>
                <p class="heading_description mt-0">© Product of Tourism Enhancement Fund</p>
                <div class="searcharea mt-5">
                    <form action="business_listing.html">
                        <div class="input-group mb-3 djustify-content-center">
                            <input type="text" style="max-width: 330px;" class="form-control" placeholder="What are you looking for" aria-label="Username">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Parish
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Clarendon</a></li>
                                    <li><a class="dropdown-item" href="#">Hanover</a></li>
                                    <li><a class="dropdown-item" href="#">Kingston</a></li>
                                    <li><a class="dropdown-item" href="#">Manchester</a></li>
                                </ul>
                            </div>
                            <button class="input-group-text" type="submit">
                                <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.6406 23.4922L15.5156 15.7109C16.3125 14.8672 16.9219 13.9141 17.3438 12.8516C17.7812 11.7891 18 10.6719 18 9.5C18 8.29688 17.7734 7.14844 17.3203 6.05469C16.8672 4.96094 16.2188 3.98437 15.375 3.125C14.5156 2.28125 13.5391 1.63281 12.4453 1.17969C11.3516 0.726562 10.2031 0.5 9 0.5C7.79688 0.5 6.64844 0.726562 5.55469 1.17969C4.46094 1.63281 3.49219 2.28125 2.64844 3.125C1.78906 3.98437 1.13281 4.96094 0.679688 6.05469C0.226562 7.14844 0 8.29688 0 9.5C0 10.7031 0.226562 11.8516 0.679688 12.9453C1.13281 14.0391 1.78906 15.0156 2.64844 15.875C3.49219 16.7188 4.46094 17.3672 5.55469 17.8203C6.64844 18.2734 7.79688 18.5 9 18.5C10.0312 18.5 11.0234 18.3359 11.9766 18.0078C12.9453 17.6641 13.8281 17.1719 14.625 16.5312L21.75 24.3125C21.8125 24.375 21.8828 24.4219 21.9609 24.4531C22.0391 24.4844 22.1172 24.5 22.1953 24.5C22.2734 24.5 22.3438 24.4844 22.4062 24.4531C22.4844 24.4375 22.5547 24.3984 22.6172 24.3359C22.7266 24.2266 22.7812 24.0859 22.7812 23.9141C22.7969 23.7578 22.75 23.6172 22.6406 23.4922ZM1.19531 9.5C1.19531 8.42188 1.39844 7.41406 1.80469 6.47656C2.22656 5.52344 2.78906 4.69531 3.49219 3.99219C4.19531 3.28906 5.01562 2.73438 5.95312 2.32812C6.90625 1.90625 7.92188 1.69531 9 1.69531C10.0781 1.69531 11.0859 1.90625 12.0234 2.32812C12.9766 2.73438 13.8047 3.28906 14.5078 3.99219C15.2109 4.69531 15.7656 5.52344 16.1719 6.47656C16.5938 7.41406 16.8047 8.42188 16.8047 9.5C16.8047 10.5781 16.5938 11.5938 16.1719 12.5469C15.7656 13.4844 15.2109 14.3047 14.5078 15.0078C13.8047 15.7109 12.9766 16.2734 12.0234 16.6953C11.0859 17.1016 10.0781 17.3047 9 17.3047C7.92188 17.3047 6.90625 17.1016 5.95312 16.6953C5.01562 16.2734 4.19531 15.7109 3.49219 15.0078C2.78906 14.3047 2.22656 13.4844 1.80469 12.5469C1.39844 11.5938 1.19531 10.5781 1.19531 9.5Z" fill="white"></path>
                                </svg>
                            </button>
                        </div>

                    </form>


                </div>
                <div class="section_heading_box text-center mt-5">
                    <h2 class="main_box_heading font-popinns mt-5">Your BUSINESS application
                        has been submitted</h2>
                </div>

                <p class=" pt-5 mt-5 mb-5 pb-5 text-center product_text font-size-20px">Application # <b><?= '00-'.$data_row['id']; ?></b></p>
                <p class=" pt-5 mt-5 mb-5 pb-5 text-center product_text font-size-20px">
                    The Taste Jamaica team has received your application. Please give us 3 business days to review it. Once
                    it is approved you will receive an email notification which will direct you to your profile.
                    <br>
                    <br>
                    In the mean time, feel free to search for culinary experiences near to you.
                </p>
            </div>

        </div>
    </section>

    <?php include 'includes/footer.php' ?>
<script>
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
      "hideMethod": "fadeOut",
      "toastClass": "custom-toastr"
    };

    <?php if($imsg->getMessage()){ ?>
        toastr.success('Business added successfully');
    <?php } ?>
</script>
</body>

</html>