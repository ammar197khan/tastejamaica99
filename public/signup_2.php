<?php
include 'includes/config/common-files.php';
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'admin_auth') {
    // die('admin');
} else {
    $a->authenticate();

    include 'phpqrcode/qrlib.php';

    if ($auth_row['user_profile'] != 'business') {
        $_SESSION['error_msg'] = 'You must sign up for a business profile to access the Get Listed page';
        redirect_header('profile.php');
    }
}
// print_r($auth_row);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

define('FILE_URL', 'outer_docx/');
define('FILE_DIR', 'outer_docx/');

function check_image($ext)
{
    $image_formate = array('png', 'gif', 'jpg', 'jpeg', 'tiff', 'raw');
    $file_formate = array('doc', 'docm', 'docx', 'xltx', 'xlsx', 'pdf');
    if (in_array($ext, $image_formate)) {
        return 'pic';
    } else if (in_array($ext, $file_formate)) {
        return 'file';
    }
}
function get_array($arr)
{
    foreach ($arr as $key => $all) {
        foreach ($all as $i => $val) {
            $new[$i][$key] = $val;
        }
    }
    return $new;
}

function getExtention($file_name)
{
    $filename = $file_name['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return $ext;
}


if (isset($_REQUEST['command']) && $_REQUEST['command'] == 'insert_preview') {
    $arr = array();
    $arr['user_id'] = intval($auth_row['id']);
    $arr['name'] = $_REQUEST['name'];
    $arr['discription'] = $_REQUEST['discription'];
    $arr['business_type'] = implode(',', $_REQUEST['business_type']);
    $arr['remotely'] = $_REQUEST['remotely'];
    $arr['delivery_services'] = $_REQUEST['delivery_services'];
    $arr['address'] = $_REQUEST['address'];
    $arr['phone_no'] = $_REQUEST['phone_no'];
    $arr['email'] = $_REQUEST['email'];
    $arr['web_site'] = $_REQUEST['web_site'];
    $arr['facebook'] = $_REQUEST['facebook'];
    $arr['instagram'] = $_REQUEST['instagram'];
    $arr['cuisines'] = implode(',', $_REQUEST['cuisines']);
    $arr['meal'] = implode(',', $_REQUEST['meal']);
    $arr['parish_type'] = $_REQUEST['parish_type'];
    $arr['approve'] = 'no';
    $arr['payment_method'] = implode(',', $_REQUEST['payment_method']);
    if ($_FILES['health_certificate']['name'][0] != '') {
        $file_format = check_image(getExtention($_FILES["health_certificate"]));
        $obj_upload = load_class('UploadImage');
        $uploadName = time() . rand();
        if ($file_format == 'pic') {
            $resultFile = $obj_upload->upload_image_with_thumbnail($_FILES["health_certificate"], FILE_DIR, $uploadName, 300, 0, "width");
        } else if ($file_format == 'file') {
            $resultFile = $obj_upload->upload_files($_FILES["health_certificate"], FILE_DIR, $uploadName);
        }
        if ($resultFile) {
            $doc_files_name = $obj_upload->get_image_name();
        }
        $arr['health_certificate'] = $doc_files_name;
    }

    if ($_FILES['handlers_permit']['name'][0] != '') {
        $file_format = check_image(getExtention($_FILES["handlers_permit"]));
        $obj_upload = load_class('UploadImage');
        $uploadName = time() . rand();
        if ($file_format == 'pic') {
            $resultFile = $obj_upload->upload_image_with_thumbnail($_FILES["handlers_permit"], FILE_DIR, $uploadName, 300, 0, "width");
        } else if ($file_format == 'file') {
            $resultFile = $obj_upload->upload_files($_FILES["handlers_permit"], FILE_DIR, $uploadName);
        }
        if ($resultFile) {
            $doc_files_name = $obj_upload->get_image_name();
        }
        $arr['handlers_permit'] = $doc_files_name;
    }

    $arr['created_at'] = time();
    $arr['user_submission'] = 'no';
    // $arr['user_id'] = getUSerID();
    if (intval($_REQUEST['id']) > 0) {
        $db->update($_REQUEST['id'], $arr, 'get_listed');
        $inserted_id = $_REQUEST['id'];
    } else {
        $inserted_id = $db->insert($arr, 'get_listed');

        if (!empty($_REQUEST['link_to_menu'])) {
            $redirect = $_REQUEST['link_to_menu'];
        } else {
            $redirect = 'https://tastejamaica.com/approved_business_qr.php?id=' . $inserted_id;
        }

        $text = $redirect;
        $img_name = 'qr-' . time() . '-' . intval($inserted_id) . ".png";
        $file_name = FILE_DIR . $img_name;
        QRcode::png($text, $file_name);
        $db->query("update get_listed SET qr_code = '" . $img_name . "' WHERE id = " . $inserted_id);
    }
    // $inserted_id =1;
    if ($inserted_id > 0) {
        foreach ($_REQUEST['hidden_itra'] as $itrat => $val) {
            foreach ($_REQUEST['business_day' . $val] as $key => $val1) {
                $sec_arr = array();
                $sec_arr['user_id'] = $auth_row['id'];
                $sec_arr['detail_id'] = $inserted_id;
                $sec_arr['day'] = $val1;
                $sec_arr['status'] = $_REQUEST['hidden_status' . $val][$key];
                $sec_arr['open_time'] = $_REQUEST['open_time' . $val][$key];
                $sec_arr['close_time'] = $_REQUEST['close_time' . $val][$key];
                $sec_arr['created_at'] = time();
                // print_r($sec_arr);
                // $sec_arr['user_id'] = getUSerID();
                if ($_REQUEST['hidden_itra_id' . $val][$key]) {
                    $db->update($_REQUEST['hidden_itra_id' . $val][$key], $sec_arr, 'business_hours');
                    $id = $_REQUEST['hidden_itra_id' . $val][$key];
                } else {
                    $id = $db->insert($sec_arr, 'business_hours');
                }
            }
        }
        $prev_data = $db->fetch_array_by_query('select * from multi_files where detail_id=' . intval($_REQUEST['id']));

        // if($prev_data['id'] > 0){
        //     $db->query('delete from multi_files where id='.$prev_data['id']);
        // }
        //multi file upload
        $multi_file = array();
        $multi_file['detail_id'] = $inserted_id;
        $multi_file['user_id'] = $auth_row['id'];
        if ($_FILES['uploadFile']) {
            $doc_files = get_array($_FILES['uploadFile']);
            $image_string = '';
            if ($doc_files[0]['name'] != '') {
                foreach ($doc_files as $key1) {
                    $obj_upload = load_class('UploadImage');
                    $uploadName = time() . rand();
                    $resultFile = $obj_upload->upload_image_with_thumbnail($key1, FILE_DIR, $uploadName, 300, 0, "width");
                    if ($resultFile) {
                        $doc_files_name = $obj_upload->get_image_name();
                    }
                    $image_string .= ',' . $doc_files_name;
                }
                $multi_file['files'] = ltrim($image_string, ',');
            }
        }
        if ($_FILES['uploadMenu']) {
            $doc_files1 = get_array($_FILES['uploadMenu']);
            $image_string1 = '';
            if ($doc_files1[0]['name'] != '') {
                foreach ($doc_files1 as $key2) {
                    $obj_upload1 = load_class('UploadImage');
                    $uploadName1 = time() . rand();
                    $resultFile1 = $obj_upload1->upload_image_with_thumbnail($key2, FILE_DIR, $uploadName1, 300, 0, "width");
                    if ($resultFile1) {
                        $doc_files_name1 = $obj_upload1->get_image_name();
                    }
                    $image_string1 .= ',' . $doc_files_name1;
                }
                $multi_file['menu'] = ltrim($image_string1, ',');
            }
        }
        $multi_file['link_to_menu'] = $_REQUEST['link_to_menu'];
        // ____________
        $multi_file['created_at'] = time();
        // $multi_file['user_id'] = getUSerID();

        if ($prev_data['id'] > 0) {
            $db->update($prev_data['id'], $multi_file, 'multi_files');
            $ids = $prev_data['id'];
        } else {
            $ids = $db->insert($multi_file, 'multi_files');
        }

        $imsg->setMessage('Get Listed Added Successfully!');
        redirect_header('approved_business.php?id=' . $inserted_id);
    } else {
        $imsg->setMessage('Error Occure Try Again', 'error!');
        redirect_header('signup_2.php');
    }
}

$data_row = $db->fetch_array_by_query('select * from get_listed where id=' . intval($_REQUEST['id']));
if (isset($_REQUEST['cmd']) && $_REQUEST['cmd'] == 'admin_auth') {
    // die('admin');
} elseif ($data_row && $data_row['user_id'] != $auth_row['id']) {
    redirect_header('profile.php');
}
$multi_files = $db->fetch_array_by_query('select * from multi_files where detail_id=' . intval($_REQUEST['id']));

?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>get listed</title>
</head>

<body>

    <?php include 'includes/header.php' ?>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC46_PI75dS4Jv3rIEIeblb3S13bZUFqM0&libraries=places" async defer></script> -->
    <form enctype="multipart/form-data" method="post">
        <section class=" main_section position-relative mb-5 pb-5" style="background-position: right">
            <div class="bg_images_area">

                <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

                <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
            </div>
            <div class="container position-relative about account_forms">
                <div class="get-listed-section spacer_z position-relative">
                    <div class="row " style="max-width: 1000px;margin: auto">
                        <div class="col-12">
                            <!-- <div class="col-lg-12 clearfix">
                                <div class="span12"> <?php //echo $imsg->getMessage(); 
                                                        ?></div>
                            </div> -->
                            <div class="section_heading_box text-center mt-5">
                                <h2 class="main_box_heading font-popinns mb-0">Submit your Culinary Experience </h2>
                                <h3 class="info_heading font-sacramento mb-3 mt-3 text-end position-relative" style="z-index: 100">Get Listed</h3>

                            </div>
                            <h4 class="section_title_with_line" style="margin-top:5px">
                                <span class="bg-white pe-3"> About Us</span>
                            </h4>
                            <p class="product_text">The Tourism Linkages Network, a division of the Tourism Enhancement Fund has created Taste
                                Jamaica, a fully integrated website and mobile app that lists a variety of culinary experiences
                                from street food to fine dining, farm to table and food events across the island. There is no
                                cost to be included on this platform! To have your culinary experience included on Taste Jamaica
                                simply submit your business information below.</p>
                        </div>
                        <div class="col-12 blog_filter">
                            <h4 class="section_title_with_line mb-3" style="margin-top:5px">
                                <span class="bg-white pe-3">BUSINESS DETAILS</span>
                            </h4>
                            <div class="form-group mt-2 pt-3">
                                <label>Name of Business</label>
                                <input type="text" name="name" placeholder="Your company name for eg. Taste Jamaica restaurant" class="form-control py-3" value="<?= ucwords($data_row['name']) ?>">
                            </div>
                            <div class="form-group mt-2 pt-3">
                                <label>Description of your business</label>
                                <textarea name="discription" placeholder="Describe your business" class="form-control" rows="5"><?= ucwords($data_row['discription']) ?></textarea>
                            </div>
                            <div class="form-group mt-2 pt-3">
                                <label>Type of Business <small>(You can select more than one option)</small></label>
                                <br>
                                <?php
                                $explode_business_types = explode(',', $data_row['business_type']);
                                $buss_typ = $explode_business_types;
                                $business_types = array(
                                    "Bar" => "Bar",
                                    "Blue_Mountain_Coffee" => "Blue Mountain Coffee",
                                    "Cafe" => "Cafe",
                                    "Culinary_Trail" => "Culinary Trail",
                                    "Farm_to_Table" => "Farm to Table",
                                    "Restaurant" => "Restaurant",
                                    "Street_Food" => "Street Food"
                                );
                                ?>
                                <select name="business_type[]" class="selectpicker selectReq" id="columnSelector" multiple data-live-search="true">
                                    <option value="">Select Option</option>
                                    <?php
                                    foreach ($business_types as $key => $business_type) {
                                    ?>
                                        <option <?php echo in_array($key, $buss_typ) ? 'selected' : ''; ?> value="<?= $key ?>"><?= ucwords($business_type) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group mt-2 pt-3">
                                        <label>Do you operate remotely?</label>
                                        <select name="remotely" id="" class="form-control">
                                            <option value="">Select Option</option>
                                            <option <?= $data_row['remotely'] == 'yes' ? 'selected' : '' ?> value="yes">Yes</option>
                                            <option <?= $data_row['remotely'] == 'no' ? 'selected' : '' ?> value="no">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group mt-2 pt-3">
                                        <label>Do you offer delivery services?</label>
                                        <select name="delivery_services" id="" class="form-control">
                                            <option value="">Select Option</option>
                                            <option <?= $data_row['delivery_services'] == 'yes' ? 'selected' : '' ?> value="yes">Yes</option>
                                            <option <?= $data_row['delivery_services'] == 'no' ? 'selected' : '' ?> value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="section_title_with_line mb-3 mt-5" style="margin-top:5px">
                                        <span class="bg-white pe-3">CONTACT INFORMATION</span>
                                    </h4>
                                </div>
                               
                                <div class="col-md-12  text">

                                    <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d970742.4280513572!2d-77.93552567561743!3d18.11951781008162!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8eda2a1bc6cf719d%3A0x59a0d1c0b5120efa!2sJamaica!5e0!3m2!1sen!2s!4v1700198401062!5m2!1sen!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                                    <?php include 'map-file.php'; ?>
                                    <!-- <iframe src="https://devproedge.com/map-file.php" width="500" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe> -->
                                    <!-- <div id="map"></div> -->

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                <div class="row" id="addAddressFields">

                                <div class="col-md-6 mt-2 pt-3">
                                <label>Address</label>
                               <!-- <input type="text" name="address" id="addressInput" placeholder="60 Knutsford Boulevard, Kingston 8" class="form-control py-3" value="  -->

                                <!-- ammar code--> 
                              
                                <input type="text" name="address"  placeholder="60 Knutsford Boulevard, Kingston 8" class="form-control py-3" id="addressInput_1" value="<?= ucwords($data_row['address']) ?>">
                               
                                <!-- ammar code -->
                            </div>
<div class="col-md-4 d-block d-lg-none d-md-none mt-3 mb-3 text-center">
    new map
</div>
<div class=" mt-2 pt-3 col-md-6 paris-select">
    <label>Parish</label>
    <?php
    $parish_options = array(
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
    ?>
    <select name="parish_type" id="" class="form-control" style="width: 88%;">
        <option value="">Select Option</option>
        <?php
        foreach ($parish_options as $key => $parish_option) {
        ?>
            <option <?= $data_row['parish_type'] == $key ? 'selected' : '' ?> value="<?= $key ?>"><?= ucwords($parish_option) ?></option>
        <?php } ?>
    </select>
   
</div>
 <!-- 
    Ammar code  -->
    
   
                                </div>
                                <button id="addAddress" class="btn btn-info"><i class="fas fa-plus-circle"></i> Add Addresses</button>
  <!--  
    End Ammar code -->                                
</div>
                                <div class="col-md-6">

                                    <div class="form-group mt-2">
                                        <label for="">Phone number</label>
                                        <div class="input-group mb-3">

                                            <!-- <input type="text" name="phone_no" class="form-control" aria-label="Username"> -->
                                            <input type="text" id="phoneNumber" name="phone_no" class="form-control" pattern="\(\d{3}\) \d{3} - \d{4}" title="Format: (XXX) XXX - XXXX" oninput="formatPhoneNumber(this)" value="<?= ucwords($data_row['phone_no']) ?>" placeholder="(XXX) XXX - XXXX">

                                            <span class="input-group-text">
                                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15.9961 20.25C15.1107 20.25 14.1992 20.1263 13.2617 19.8789C12.3242 19.6315 11.3672 19.2604 10.3906 18.7656C9.94792 18.5312 9.50521 18.2773 9.0625 18.0039C8.61979 17.7305 8.18359 17.4375 7.75391 17.125C7.32422 16.7995 6.90104 16.4609 6.48438 16.1094C6.06771 15.7448 5.66406 15.3672 5.27344 14.9766C4.88281 14.5859 4.51172 14.1823 4.16016 13.7656C3.80859 13.349 3.47005 12.9258 3.14453 12.4961C2.83203 12.0664 2.53255 11.6302 2.24609 11.1875C1.97266 10.7448 1.72526 10.3021 1.50391 9.85938C1.00911 8.88281 0.638021 7.92578 0.390625 6.98828C0.143229 6.05078 0.0195312 5.13932 0.0195312 4.25391C0.0195312 3.68099 0.214844 3.14714 0.605469 2.65234C0.996094 2.14453 1.30859 1.78646 1.54297 1.57812C1.86849 1.26562 2.26562 0.966146 2.73438 0.679688C3.20312 0.393229 3.6263 0.25 4.00391 0.25C4.1862 0.25 4.38802 0.315104 4.60938 0.445312C4.84375 0.5625 5.10417 0.757812 5.39062 1.03125C5.59896 1.22656 5.82031 1.45443 6.05469 1.71484C6.28906 1.97526 6.52995 2.26172 6.77734 2.57422C6.92057 2.75651 7.23958 3.21875 7.73438 3.96094C8.24219 4.70312 8.49609 5.30208 8.49609 5.75781C8.49609 6.1224 8.3138 6.44792 7.94922 6.73438C7.59766 7.00781 7.20052 7.28776 6.75781 7.57422C6.58854 7.67839 6.41927 7.78255 6.25 7.88672C6.08073 7.99089 5.93099 8.09505 5.80078 8.19922C5.65755 8.31641 5.56641 8.40755 5.52734 8.47266C5.48828 8.52474 5.46875 8.55729 5.46875 8.57031C5.70312 9.15625 6.04818 9.76823 6.50391 10.4062C6.95964 11.0443 7.47396 11.6497 8.04688 12.2227C8.61979 12.7826 9.21875 13.2904 9.84375 13.7461C10.4818 14.2018 11.0938 14.5469 11.6797 14.7812C11.6927 14.7812 11.7253 14.7617 11.7773 14.7227C11.8424 14.6836 11.9336 14.5924 12.0508 14.4492C12.1549 14.319 12.2591 14.1693 12.3633 14C12.4674 13.8307 12.5716 13.6615 12.6758 13.4922C12.9492 13.0495 13.2292 12.6523 13.5156 12.3008C13.8021 11.9362 14.1276 11.7539 14.4922 11.7539C14.9479 11.7539 15.5469 12.0078 16.2891 12.5156C17.0312 13.0104 17.4935 13.3294 17.6758 13.4727C17.9883 13.7201 18.2747 13.9609 18.5352 14.1953C18.7956 14.4297 19.0234 14.651 19.2188 14.8594C19.4922 15.1458 19.6875 15.4062 19.8047 15.6406C19.9349 15.862 20 16.0638 20 16.2461C20 16.6237 19.8568 17.0469 19.5703 17.5156C19.2839 17.9844 18.9844 18.3815 18.6719 18.707C18.4635 18.9414 18.1055 19.2539 17.5977 19.6445C17.1029 20.0482 16.569 20.25 15.9961 20.25ZM3.98438 1.24609C3.85417 1.24609 3.6263 1.33073 3.30078 1.5C2.97526 1.66927 2.61719 1.9362 2.22656 2.30078C1.84896 2.65234 1.54948 3.00391 1.32812 3.35547C1.11979 3.69401 1.01562 3.99349 1.01562 4.25391C1.01562 5.93359 1.47786 7.65885 2.40234 9.42969C3.33984 11.2005 4.53125 12.8151 5.97656 14.2734C7.4349 15.7318 9.04948 16.9297 10.8203 17.8672C12.5911 18.7917 14.3164 19.2539 15.9961 19.2539C16.2565 19.2539 16.556 19.1432 16.8945 18.9219C17.2461 18.7005 17.5977 18.4076 17.9492 18.043C18.3008 17.6393 18.5612 17.2747 18.7305 16.9492C18.9128 16.6237 19.0039 16.3958 19.0039 16.2656C18.9909 16.1615 18.8346 15.9336 18.5352 15.582C18.2357 15.2305 17.7279 14.7747 17.0117 14.2148C16.3867 13.7461 15.8464 13.388 15.3906 13.1406C14.9349 12.8802 14.6419 12.75 14.5117 12.75C14.4987 12.75 14.4596 12.7695 14.3945 12.8086C14.3424 12.8477 14.2578 12.9388 14.1406 13.082C14.0495 13.2122 13.9518 13.362 13.8477 13.5312C13.7435 13.6875 13.6393 13.8503 13.5352 14.0195C13.2487 14.4753 12.9622 14.8854 12.6758 15.25C12.3893 15.6016 12.0573 15.7773 11.6797 15.7773C11.6146 15.7773 11.5495 15.7773 11.4844 15.7773C11.4323 15.7643 11.3737 15.7448 11.3086 15.7188C10.6576 15.4583 9.98698 15.0807 9.29688 14.5859C8.60677 14.0911 7.94922 13.5378 7.32422 12.9258C6.71224 12.3008 6.15885 11.6432 5.66406 10.9531C5.16927 10.263 4.79167 9.59245 4.53125 8.94141C4.46615 8.78516 4.45312 8.58984 4.49219 8.35547C4.53125 8.10807 4.70052 7.84115 5 7.55469C5.16927 7.41146 5.35807 7.26823 5.56641 7.125C5.78776 6.98177 6.00911 6.84505 6.23047 6.71484C6.39974 6.61068 6.5625 6.50651 6.71875 6.40234C6.88802 6.29818 7.03776 6.19401 7.16797 6.08984C7.3112 5.98568 7.40234 5.90755 7.44141 5.85547C7.48047 5.79036 7.5 5.7513 7.5 5.73828C7.5 5.60807 7.36979 5.3151 7.10938 4.85938C6.86198 4.40365 6.50391 3.86328 6.03516 3.23828C5.47526 2.52214 5.01953 2.01432 4.66797 1.71484C4.31641 1.41536 4.08854 1.25911 3.98438 1.24609Z" fill="#603813" />
                                                </svg>



                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group mt-2">
                                        <label for="">Email Address</label>
                                        <div class="input-group mb-3">

                                            <input type="text" name="email" class="form-control" aria-label="Username" value="<?= $data_row['email'] ?>" placeholder="Enter Email Address">
                                            <span class="input-group-text">
                                                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.9102 4.79688L10.6055 0.34375C10.4622 0.252604 10.293 0.18099 10.0977 0.128906C9.90234 0.0768229 9.70052 0.0507812 9.49219 0.0507812C9.29688 0.0507812 9.10156 0.0768229 8.90625 0.128906C8.71094 0.18099 8.53516 0.252604 8.37891 0.34375L1.09375 4.79688C0.78125 4.99219 0.520833 5.27865 0.3125 5.65625C0.104167 6.02083 0 6.38542 0 6.75V15.7539C0 16.1706 0.143229 16.5286 0.429688 16.8281C0.729167 17.1146 1.08724 17.2578 1.50391 17.2578H17.5C17.9167 17.2578 18.2682 17.1146 18.5547 16.8281C18.8542 16.5286 19.0039 16.1706 19.0039 15.7539V6.75C19.0039 6.38542 18.8997 6.02083 18.6914 5.65625C18.4831 5.27865 18.2227 4.99219 17.9102 4.79688ZM1.62109 5.65625L8.90625 1.20312C8.98438 1.15104 9.07552 1.11198 9.17969 1.08594C9.28385 1.0599 9.38802 1.04688 9.49219 1.04688C9.60938 1.04688 9.72005 1.0599 9.82422 1.08594C9.92839 1.11198 10.0195 1.15104 10.0977 1.20312L17.3828 5.65625C17.4609 5.70833 17.5326 5.77344 17.5977 5.85156C17.6758 5.92969 17.7409 6.01432 17.793 6.10547L10.0586 11.2812C9.91536 11.3724 9.72656 11.418 9.49219 11.418C9.27083 11.418 9.08854 11.3724 8.94531 11.2812L1.19141 6.10547C1.25651 6.01432 1.32161 5.92969 1.38672 5.85156C1.46484 5.77344 1.54297 5.70833 1.62109 5.65625ZM17.5 16.2422H1.50391C1.36068 16.2422 1.23698 16.1966 1.13281 16.1055C1.04167 16.0013 0.996094 15.8841 0.996094 15.7539V7.17969L8.39844 12.1016C8.55469 12.2057 8.72396 12.2839 8.90625 12.3359C9.10156 12.388 9.29688 12.4141 9.49219 12.4141C9.70052 12.4141 9.89583 12.388 10.0781 12.3359C10.2734 12.2839 10.4492 12.2057 10.6055 12.1016L18.0078 7.17969V15.7539C18.0078 15.8841 17.9557 16.0013 17.8516 16.1055C17.7604 16.1966 17.6432 16.2422 17.5 16.2422Z" fill="#603813"></path>
                                                </svg>


                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">

                                    <div class="form-group mt-2">
                                        <label for="">Website</label>
                                        <div class="input-group mb-3">

                                            <input type="text" name="web_site" class="form-control" aria-label="Username" value="<?= $data_row['web_site'] ?>" placeholder="Enter Website">
                                            <span class="input-group-text">
                                                <svg width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.6021 3.83232C18.094 3.30937 17.5412 2.85366 16.9436 2.46518C16.3459 2.06177 15.7184 1.72559 15.0609 1.45664C14.4185 1.18769 13.7461 0.985986 13.0438 0.851513C12.3416 0.702099 11.6244 0.627392 10.8923 0.627392C10.1751 0.627392 9.46538 0.702099 8.76314 0.851513C8.06089 0.985986 7.38105 1.18769 6.72363 1.45664C6.06621 1.72559 5.43867 2.06177 4.84102 2.46518C4.2583 2.85366 3.70547 3.30937 3.18252 3.83232C2.67451 4.34033 2.2188 4.89316 1.81538 5.49082C1.4269 6.08848 1.09819 6.71602 0.829248 7.37344C0.560303 8.01592 0.351123 8.68828 0.201709 9.39053C0.0672363 10.0928 0 10.81 0 11.5421C0 12.2593 0.0672363 12.969 0.201709 13.6712C0.351123 14.3735 0.560303 15.0533 0.829248 15.7107C1.09819 16.3532 1.4269 16.9733 1.81538 17.5709C2.2188 18.1686 2.67451 18.7214 3.18252 19.2294C3.70547 19.7524 4.2583 20.2156 4.84102 20.619C5.43867 21.0075 6.06621 21.3362 6.72363 21.6051C7.38105 21.8741 8.06089 22.0758 8.76314 22.2103C9.46538 22.3597 10.1751 22.4344 10.8923 22.4344C11.6244 22.4344 12.3416 22.3597 13.0438 22.2103C13.7461 22.0758 14.4185 21.8741 15.0609 21.6051C15.7184 21.3362 16.3459 21.0075 16.9436 20.619C17.5412 20.2156 18.094 19.7524 18.6021 19.2294C19.125 18.7214 19.5807 18.1686 19.9692 17.5709C20.3726 16.9733 20.7088 16.3532 20.9777 15.7107C21.2467 15.0533 21.4484 14.3735 21.5829 13.6712C21.7323 12.969 21.807 12.2593 21.807 11.5421C21.807 10.81 21.7323 10.0928 21.5829 9.39053C21.4484 8.68828 21.2467 8.01592 20.9777 7.37344C20.7088 6.71602 20.3726 6.08848 19.9692 5.49082C19.5807 4.89316 19.125 4.34033 18.6021 3.83232ZM17.2125 10.9594C17.1826 10.3468 17.1303 9.74165 17.0556 9.14399C16.9809 8.54634 16.8838 7.97109 16.7643 7.41826C16.9585 7.50791 17.1527 7.59756 17.347 7.68721C17.5412 7.77686 17.7354 7.87397 17.9297 7.97856C18.6768 8.39692 19.2744 8.86011 19.7227 9.36811C20.1858 9.87612 20.4772 10.4065 20.5967 10.9594H17.2125ZM16.0471 10.9594H11.475V6.3873C12.1772 6.40225 12.8646 6.46201 13.5369 6.5666C14.2093 6.67119 14.8518 6.80566 15.4644 6.97002C15.6287 7.58262 15.7632 8.2251 15.8678 8.89746C15.9724 9.56982 16.0321 10.2571 16.0471 10.9594ZM11.475 5.22187V1.83765C12.0278 1.95718 12.5583 2.24853 13.0663 2.71172C13.5743 3.15996 14.0375 3.75762 14.4558 4.50469C14.5604 4.68398 14.6575 4.87822 14.7472 5.0874C14.8368 5.28164 14.9265 5.47588 15.0161 5.67012C14.4483 5.55059 13.8656 5.45347 13.268 5.37876C12.6853 5.30405 12.0876 5.25176 11.475 5.22187ZM10.332 1.83765V5.22187C9.71939 5.25176 9.11426 5.30405 8.5166 5.37876C7.91895 5.45347 7.3437 5.55059 6.79087 5.67012C6.88052 5.47588 6.97017 5.28164 7.05981 5.0874C7.14946 4.87822 7.24658 4.68398 7.35117 4.50469C7.76953 3.75762 8.23272 3.15996 8.74072 2.71172C9.24873 2.24853 9.77915 1.95718 10.332 1.83765ZM10.332 6.3873V10.9594H5.7375C5.76738 10.2571 5.82715 9.56982 5.9168 8.89746C6.02139 8.2251 6.16333 7.58262 6.34263 6.97002C6.95522 6.80566 7.59771 6.67119 8.27007 6.5666C8.94243 6.46201 9.62974 6.40225 10.332 6.3873ZM4.59448 10.9594H1.21025C1.32979 10.4065 1.61367 9.87612 2.06191 9.36811C2.5251 8.86011 3.13022 8.39692 3.8773 7.97856C4.05659 7.87397 4.24336 7.77686 4.4376 7.68721C4.63184 7.59756 4.83355 7.50791 5.04272 7.41826C4.90825 7.98603 4.80366 8.56875 4.72896 9.16641C4.65425 9.74912 4.60942 10.3468 4.59448 10.9594ZM4.59448 12.1024C4.60942 12.715 4.65425 13.3201 4.72896 13.9178C4.80366 14.5154 4.90825 15.0907 5.04272 15.6435C4.83355 15.5539 4.63184 15.4642 4.4376 15.3746C4.24336 15.2849 4.05659 15.1878 3.8773 15.0832C3.13022 14.6648 2.5251 14.2017 2.06191 13.6937C1.61367 13.1856 1.32979 12.6552 1.21025 12.1024H4.59448ZM5.7375 12.1024H10.332V16.6969C9.62974 16.667 8.94243 16.6072 8.27007 16.5176C7.59771 16.413 6.95522 16.271 6.34263 16.0917C6.16333 15.4792 6.02139 14.8367 5.9168 14.1643C5.82715 13.4919 5.76738 12.8046 5.7375 12.1024ZM10.332 17.8399V21.2241C9.77915 21.1046 9.24873 20.8207 8.74072 20.3725C8.23272 19.9093 7.76953 19.3042 7.35117 18.5571C7.24658 18.3778 7.14946 18.191 7.05981 17.9968C6.97017 17.8025 6.88052 17.6008 6.79087 17.3917C7.3437 17.5261 7.91895 17.6307 8.5166 17.7054C9.11426 17.7801 9.71939 17.825 10.332 17.8399ZM11.475 21.2241V17.8399C12.0876 17.825 12.6927 17.7801 13.2904 17.7054C13.888 17.6307 14.4633 17.5261 15.0161 17.3917C14.9265 17.6008 14.8368 17.8025 14.7472 17.9968C14.6575 18.191 14.5604 18.3778 14.4558 18.5571C14.0375 19.3042 13.5743 19.9093 13.0663 20.3725C12.5583 20.8207 12.0278 21.1046 11.475 21.2241ZM11.475 16.6969V12.1024H16.0471C16.0321 12.8046 15.9724 13.4919 15.8678 14.1643C15.7632 14.8367 15.6287 15.4792 15.4644 16.0917C14.8518 16.271 14.2093 16.413 13.5369 16.5176C12.8646 16.6072 12.1772 16.667 11.475 16.6969ZM17.2125 12.1024H20.5967C20.4772 12.6552 20.1858 13.1856 19.7227 13.6937C19.2744 14.2017 18.6768 14.6648 17.9297 15.0832C17.7504 15.1878 17.5562 15.2849 17.347 15.3746C17.1527 15.4642 16.9585 15.5539 16.7643 15.6435C16.8838 15.0907 16.9809 14.5154 17.0556 13.9178C17.1303 13.3201 17.1826 12.715 17.2125 12.1024ZM20.014 8.02339C19.7899 7.84409 19.5508 7.66479 19.2968 7.4855C19.0428 7.3062 18.7739 7.13437 18.49 6.97002C18.1613 6.79072 17.8176 6.62637 17.459 6.47695C17.1154 6.32754 16.7568 6.1856 16.3833 6.05112C16.2488 5.67759 16.1068 5.31899 15.9574 4.97534C15.808 4.61675 15.6437 4.2731 15.4644 3.94438C15.3 3.6605 15.1282 3.39155 14.9489 3.13755C14.7696 2.88354 14.5903 2.64448 14.411 2.42036C15.0535 2.67436 15.6586 2.98813 16.2264 3.36167C16.7941 3.7352 17.3171 4.16103 17.7952 4.63916C18.2733 5.11728 18.6992 5.64023 19.0727 6.20801C19.4462 6.77578 19.76 7.38091 20.014 8.02339ZM7.396 2.42036C7.20176 2.64448 7.01499 2.88354 6.83569 3.13755C6.67134 3.39155 6.50698 3.6605 6.34263 3.94438C6.16333 4.2731 5.99897 4.61675 5.84956 4.97534C5.70015 5.31899 5.5582 5.67759 5.42373 6.05112C5.0502 6.1856 4.68413 6.32754 4.32554 6.47695C3.98188 6.62637 3.6457 6.79072 3.31699 6.97002C3.03311 7.13437 2.76416 7.3062 2.51016 7.4855C2.25615 7.66479 2.01709 7.84409 1.79297 8.02339C2.04697 7.38091 2.36074 6.77578 2.73428 6.20801C3.10781 5.64023 3.53364 5.11728 4.01177 4.63916C4.48989 4.16103 5.01284 3.7352 5.58062 3.36167C6.14839 2.98813 6.75352 2.67436 7.396 2.42036ZM1.79297 15.0384C2.01709 15.2326 2.25615 15.4194 2.51016 15.5987C2.76416 15.763 3.03311 15.9274 3.31699 16.0917C3.6457 16.271 3.98188 16.4354 4.32554 16.5848C4.68413 16.7342 5.0502 16.8762 5.42373 17.0106C5.5582 17.3842 5.70015 17.7502 5.84956 18.1088C5.99897 18.4525 6.16333 18.7887 6.34263 19.1174C6.50698 19.4013 6.67134 19.6702 6.83569 19.9242C7.01499 20.1782 7.20176 20.4173 7.396 20.6414C6.75352 20.3874 6.14839 20.0736 5.58062 19.7001C5.01284 19.3266 4.48989 18.9007 4.01177 18.4226C3.53364 17.9445 3.10781 17.4215 2.73428 16.8538C2.36074 16.286 2.04697 15.6809 1.79297 15.0384ZM14.411 20.6414C14.5903 20.4173 14.7696 20.1782 14.9489 19.9242C15.1282 19.6702 15.3 19.4013 15.4644 19.1174C15.6437 18.7887 15.808 18.4525 15.9574 18.1088C16.1068 17.7502 16.2488 17.3842 16.3833 17.0106C16.7568 16.8762 17.1154 16.7342 17.459 16.5848C17.8176 16.4354 18.1613 16.271 18.49 16.0917C18.7739 15.9274 19.0428 15.763 19.2968 15.5987C19.5508 15.4194 19.7899 15.2326 20.014 15.0384C19.76 15.6809 19.4462 16.286 19.0727 16.8538C18.6992 17.4215 18.2733 17.9445 17.7952 18.4226C17.3171 18.9007 16.7941 19.3266 16.2264 19.7001C15.6586 20.0736 15.0535 20.3874 14.411 20.6414Z" fill="#9E8879" />
                                                </svg>



                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2 pt-3">
                                        <label>Facebook</label>
                                        <input type="text" name="facebook" placeholder="https://www.facebook.com/#" class="form-control py-3" value="<?= $data_row['facebook'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2 pt-3">
                                        <label>Instagram</label>
                                        <input type="text" name="instagram" placeholder="https://www.instagram.com/#" class="form-control py-3" value="<?= $data_row['instagram'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <h4 class="section_title_with_line mb-3 mt-5" style="margin-top:5px">
                                        <span class="bg-white pe-3">ADDITIONAL Business Details</span>
                                    </h4>
                                </div>
                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>What Cuisines do you offer? <br><small>
                                                        (You can select more than one option)
                                                    </small></label>
                                                <?php
                                                $explode_Cuisines = explode(',', $data_row['cuisines']);
                                                $explode_Cuisine = $explode_Cuisines;
                                                $Cuisines_options = array(
                                                    "Chinese" => "Chinese",
                                                    "Fast_Food" => "Fast Food",
                                                    "Indian" => "Indian",
                                                    "Italian" => "Italian",
                                                    "Jamaican" => "Jamaican",
                                                    "Japanese" => "Japanese",
                                                    "Lebanese" => "Lebanese",
                                                    "Mexican" => "Mexican",
                                                    "Vegan" => "Vegan",
                                                    "International" => "International"
                                                );
                                                ?>
                                                <select name="cuisines[]" class="selectpicker selectReq" id="columnSelector" multiple data-live-search="true">
                                                    <option value="">Select Option</option>
                                                    <?php
                                                    foreach ($Cuisines_options as $key => $Cuisines_option) {
                                                    ?>
                                                        <option <?php echo in_array($key, $explode_Cuisine) ? 'selected' : ''; ?> value="<?= $key ?>"><?= ucwords($Cuisines_option) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>What Meal Type do you offer? <br> <small>(You can select more than one option)</small></label>
                                                <?php
                                                $explode_meal = explode(',', $data_row['meal']);
                                                $explode_meals = $explode_meal;
                                                $meal_options = array(
                                                    "breakfast" => "Breakfast",
                                                    "desserts" => "Desserts",
                                                    "dinner" => "Dinner",
                                                    "lunch" => "Lunch",
                                                    "natural_juices_smoothies" => "Natural Juices / Smoothies"
                                                );
                                                ?>
                                                <select name="meal[]" class="selectpicker selectReq" id="columnSelector" multiple data-live-search="true">
                                                    <option value="">Select Option</option>
                                                    <?php
                                                    foreach ($meal_options as $key => $meal_option) {
                                                    ?>
                                                        <option <?php echo in_array($key, $explode_meals) ? 'selected' : ''; ?> value="<?= $key ?>"><?= ucwords($meal_option) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <div class="form-group mt-2 pt-3">
                                                <label>Payment Method <small>(You can select more than one option)</small></label>
                                                <?php
                                                $explode_payment_method = explode(',', $data_row['payment_method']);
                                                $explode_payment_methods = $explode_payment_method;
                                                $payment_method_options = array(
                                                    "cash" => "Cash",
                                                    "cash_on_delivery" => "Cash on Delivery",
                                                    "debit_card" => "Debit Card",
                                                    "credit_card" => "Credit Card",
                                                    "direct_deposit_bank" => "Direct Deposit / Bank transfer",
                                                    "jamdex" => "JAMDEX",
                                                    "lynk" => "LYNK",
                                                    "paypal" => "Paypal",
                                                    "zelle" => "Zelle"
                                                );
                                                ?>
                                                <select name="payment_method[]" class="selectpicker selectReq" id="columnSelector" multiple data-live-search="true">
                                                    <option value="">Select Option</option>
                                                    <?php
                                                    foreach ($payment_method_options as $key => $payment_method_option) {
                                                    ?>
                                                        <option <?php echo in_array($key, $explode_payment_methods) ? 'selected' : ''; ?> value="<?= $key ?>"><?= ucwords($payment_method_option) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>Upload Public Health Certificate <small>(optional)</small></label>
                                                <input type="file" name="health_certificate" class="form-control">
                                                <?php
                                                if ($data_row['health_certificate'] != '') {
                                                    $src = FILE_URL . $data_row['health_certificate'];
                                                    $extention = substr($data_row['health_certificate'], strpos($data_row['health_certificate'], ".") + 1);
                                                    $file_formate = array('doc', 'docm', 'docx', 'xltx', 'xlsx', 'pdf');
                                                    if (in_array($extention, $file_formate)) {
                                                        $src = ADMIN_URL . "80942.png";
                                                ?>
                                                        <a href="<?php echo FILE_URL . $data_row['health_certificate']; ?>" target="_blank">
                                                            <img class="thumbnail" style="display:inline-block;border:none !important;margin-bottom:0px !important;margin-top: 10px;" src="<?php echo $src; ?>" alt="health_certificate" style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;">
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?= FILE_URL . $data_row["health_certificate"]; ?>" target="_blank">
                                                            <img style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?= FILE_URL . $data_row["health_certificate"]; ?>" alt="health_certificate">
                                                        </a>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>Upload Food handlers permit <small>(optional)</small></label>
                                                <input type="file" name="handlers_permit" class="form-control">
                                                <?php
                                                if (!empty($data_row['handlers_permit'])) {
                                                    $src = FILE_URL . $data_row['handlers_permit'];
                                                    $extention = substr($data_row['handlers_permit'], strpos($data_row['handlers_permit'], ".") + 1);
                                                    $file_formate = array('doc', 'docm', 'docx', 'xltx', 'xlsx', 'pdf');
                                                    if (in_array($extention, $file_formate)) {
                                                        $src = ADMIN_URL . "80942.png";
                                                ?>
                                                        <a href="<?php echo FILE_URL . $data_row['handlers_permit']; ?>" target="_blank">
                                                            <img class="thumbnail" style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?php echo $src; ?>" alt="handlers_permit">
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?= FILE_URL . $data_row["handlers_permit"]; ?>" target="_blank">
                                                            <img style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?= FILE_URL . $data_row["handlers_permit"]; ?>" alt="handlers_permit">
                                                        </a>
                                                <?php }
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="section_title_with_line mb-3 mt-5" style="margin-top:5px">
                                        <span class="bg-white pe-3">Business Hours</span>
                                    </h4>
                                </div>
                                <div class="col-md-12 text-center">
                                    <table class="table">
                                        <thead>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Open</th>
                                            <th>Close</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $db->select('select * from business_hours where detail_id=' . intval($_REQUEST['id']));
                                            $rows = $db->fetch_all();
                                            $days_arr = array('monday', 'thuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
                                            $itrat = 0;
                                            foreach ($days_arr as $day) {
                                                ++$itrat;
                                                $selectedDayInfo = array(
                                                    'day' => $day,
                                                    'status' => 'closed',  // default value
                                                    'open_time' => '',
                                                    'close_time' => ''
                                                );

                                                // Check if the day is in the database result
                                                foreach ($rows as $row) {
                                                    if ($row['day'] === $day) {
                                                        $selectedDayInfo['status'] = $row['status'];
                                                        $selectedDayInfo['open_time'] = $row['open_time'];
                                                        $selectedDayInfo['close_time'] = $row['close_time'];
                                                        break;
                                                    }
                                                }

                                                $checked = ($selectedDayInfo['status'] === 'open') ? 'checked' : '';
                                            ?>
                                                <tr>
                                                    <?php if ($day == 'thuesday') {
                                                        $day = 'Tuesday';
                                                    } ?>
                                                    <td><?= ucwords($day) ?></td>
                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox" <?= $checked ?> name="business_day<?= $itrat ?>[]" value="<?= $day ?>" onclick="getOpenstatus(this, '<?= $day ?>')">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <span class="<?= $day ?>_close_span"><?= $selectedDayInfo['status'] ?></span>
                                                        <input type="hidden" class="<?= $day ?>_hidden" name="hidden_status<?= $itrat ?>[]" value="<?= $selectedDayInfo['status'] ?>">
                                                    </td>
                                                    <td>
                                                        <div class="cs-form">
                                                            <input type="time" class="form-control" name="open_time<?= $itrat ?>[]" value="<?= $selectedDayInfo['open_time'] ?>" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="cs-form">
                                                            <input type="time" class="form-control" name="close_time<?= $itrat ?>[]" value="<?= $selectedDayInfo['close_time'] ?>" />
                                                        </div>
                                                        <input type="hidden" name="hidden_itra_id<?= $itrat ?>[]" value="<?= $row['id'] ?>">
                                                        <input type="hidden" name="hidden_itra[]" value="<?= $itrat ?>">
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="section_title_with_line mb-3 mt-5" style="margin-top:5px">
                                        <span class="bg-white pe-3">Upload Photos</span>
                                    </h4>
                                    <p class="product_text">Bring your profile to life with images of your culinary experience. 5 photos are required. </p>
                                </div>
                                <div class="col-md-12 text-center">
                                    <!-- <div id="dropzone1">
                                        <FORM class="dropzone needsclick" id="demo-upload" action="/upload">
                                            <DIV class="dz-message needsclick">
                                                Click here to upload photos<BR>
                                                <SPAN class="note needsclick">File type recommended PNG or JPEG
                                                </SPAN>
                                            </DIV>
                                        </FORM>
                                    </div> -->
                                    <label for="images" class="drop-container" id="dropcontainer">
                                        <span class="drop-title">Drop files here</span>
                                        or
                                        <input type="file" name="uploadFile[]" id="images" accept="image/*" multiple="multiple" onchange="checkFileCount(this)">
                                    </label>
                                    <div class="col-lg-12 d-flex">

                                        <?php
                                        $exp_multis = explode(',', $multi_files['files']);
                                        foreach ($exp_multis as $exp_multi) {
                                        ?>
                                            <div class="col-lg-2">
                                                <?php
                                                if (!empty($exp_multi)) {
                                                    $src = FILE_URL . $exp_multi;
                                                    $extention = substr($exp_multi, strpos($exp_multi, ".") + 1);
                                                    $file_formate = array('doc', 'docm', 'docx', 'xltx', 'xlsx', 'pdf');
                                                    if (in_array($extention, $file_formate)) {
                                                        $src = ADMIN_URL . "80942.png";
                                                ?>
                                                        <a href="<?php echo FILE_URL . $exp_multi; ?>" target="_blank">
                                                            <img class="thumbnail" style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?php echo $src; ?>" alt="handlers_permit" width="40" height="40">
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?= FILE_URL . $data_row["handlers_permit"]; ?>" target="_blank">
                                                            <img style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?= FILE_URL . $exp_multi; ?>" alt="handlers_permit">
                                                        </a>
                                                <?php }
                                                } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">





                                <div class="col-12">
                                    <h4 class="section_title_with_line mb-3 mt-5" style="margin-top:5px">
                                        <span class="bg-white pe-3">Add Menu</span>

                                    </h4>
                                    <section class="container mt-5">

                                        <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">PDF Or Photo</button>
                                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Link To Menu</button>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active mt-5" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <div class="col-md-12 text-center">
                                                    <!-- <div class="form-group checkbox_area  mb-5 mt-5 text-start">
                                                    <label> <input type="checkbox" class="p-4 position-absolute"><span style="padding-left: 50px;color: #603813;
                                                    font-family: Inter;
                                                    font-size: 18px;
                                                    font-style: normal;
                                                    font-weight: 400;
                                                    line-height: normal;
                                                    display:block;"> You agree for the Tourism Enhancement Fund an agency of the Ministry of Tourism to use your data to display on www.tastejamaica.com and the Taste Jamaica mobile app.</span></label>
                                                </div> -->
                                                    <label for="images" class="drop-container" id="dropcontainer">
                                                        <span class="drop-title">Drop files here</span>
                                                        or
                                                        <input type="file" name="uploadMenu[]" id="images" accept="image/*" multiple="multiple">
                                                    </label>
                                                    <div class="col-lg-12" style="margin-top:30px">
                                                        <div class="col-lg-12 d-flex">
                                                            <?php
                                                            $exp_menu = explode(',', $multi_files['menu']);
                                                            foreach ($exp_menu as $menu) {
                                                            ?>
                                                                <div class="col-lg-2">
                                                                    <?php
                                                                    if (!empty($menu)) {
                                                                        $src = FILE_URL . $menu;
                                                                        $extention = substr($menu, strpos($menu, ".") + 1);
                                                                        $file_formate = array('doc', 'docm', 'docx', 'xltx', 'xlsx', 'pdf');
                                                                        if (in_array($extention, $file_formate)) {
                                                                            $src = ADMIN_URL . "80942.png";
                                                                    ?>
                                                                            <a href="<?php echo FILE_URL . $menu; ?>" target="_blank">
                                                                                <img class="thumbnail" style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?php echo $src; ?>" alt="handlers_permit" width="40" height="40">
                                                                            </a>
                                                                        <?php } else { ?>
                                                                            <a href="<?= FILE_URL . $data_row["handlers_permit"]; ?>" target="_blank">
                                                                                <img style="width: 100px;height: 100px;margin-bottom: 3px;margin-top: 10px;" src="<?= FILE_URL . $menu; ?>" alt="handlers_permit">
                                                                            </a>
                                                                    <?php }
                                                                    } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div class="row mt-5">
                                                    <div class="col-lg-4">
                                                        <label for="">Link</label>
                                                    </div>
                                                    <input type="text" name="link_to_menu" class="form-control" placeholder="Enter Link" value="<?= $multi_files['link_to_menu'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                            <?php
                            if ($_REQUEST['id'] > 0) {
                                $btn_nam = 'Update Preview Submission';
                            } else {
                                $btn_nam = 'Preview Submission';
                            }
                            ?>
                            <button class="submit_button btn load_more d-block ms-auto float-end py-3 px-5 mb-5 mt-5" name="command" value="insert_preview"><?= $btn_nam ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <?php include 'includes/footer.php' ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">
        // Ammar code

function initMap() {
    // Initialize the map with center in Jamaica
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: 18.1096,
            lng: -77.2975
        },
        zoom: 8
    });
    
    // Counter for dynamically generated fields
    var fieldCounter = 1;

    // Function to bind autocomplete and marker to a given field
    function bindField(counter) {
        var input = $('#addressInput_' + counter)[0];
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            if (place.geometry) {
                map.setCenter(place.geometry.location);
                map.setZoom(15);
                marker.setPosition(place.geometry.location);
            }
        });
        
        // Listen for the click event on the map
        map.addListener('click', function (event) {
            var marker = new google.maps.Marker({
                position: event.latLng,
                map: map
            });

            var geocoder = new google.maps.Geocoder;
            geocoder.geocode({
                'location': event.latLng
            }, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        // Assuming there's only one address field
                        document.getElementById('addressInput_' + counter).value = results[0].formatted_address;
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        });
    }

    // Bind the first field on document load
    bindField(fieldCounter);

    // Add address field
    $('#addAddress').click(function () {
        
        event.preventDefault();
        ++fieldCounter;
        var newField = '<div class="row" style="position: relative;"><div class="col-md-6 mt-2 pt-3"> <label>Address</label> <input type="text" id="addressInput_' + fieldCounter + '" name="address" placeholder="60 Knutsford Boulevard, Kingston 8" class="form-control py-3 " value=""> </div> <div class="col-md-4 d-block d-lg-none d-md-none mt-3 mb-3 text-center"> new map </div> <div class=" mt-2 pt-3 col-md-6 paris-select"> <label>Parish</label> <select name="parish_type" id="" class="form-control" style="width: 88%;"> <option value="">Select Option</option>  <option value=""></option></select></div> <i class="fas fa-trash remove-address addAddressDeleteField" style="position: absolute;top: 73px; right: 39px; width: auto;" data-target="addressField_' + fieldCounter + '"></i></div>';
        $('#addAddressFields').append(newField);
        // Bind autocomplete and marker to the new field
        bindField(fieldCounter);
    });

    // Remove address field
    $(document).on('click', '.remove-address', function () {
        var target = $(this).data('target');
        $('#' + target).remove();
    });
}

     $("#addAddressFields").on("click", ".addAddressDeleteField", function(){
    $(this).parent().remove();
  });
  </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTKJ0rBDwKl1Oqv_M_AgFW_lRKkro6a64&libraries=places&callback=initMap" async defer></script>
<!--Ammar Code end -->

<script type="text/javascript">


        $('select').selectpicker();
        var dropzone = new Dropzone('#dropzone1', {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 2,
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 3,
            filesizeBase: 1000,
            thumbnail: function(file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function() {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            }

        });


        // Now fake the file upload, since GitHub does not handle file uploads
        // and returns a 404

        var minSteps = 6,
            maxSteps = 60,
            timeBetweenSteps = 100,
            bytesPerStep = 100000;

        dropzone.uploadFiles = function(files) {
            var self = this;

            for (var i = 0; i < files.length; i++) {

                var file = files[i];
                totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

                for (var step = 0; step < totalSteps; step++) {
                    var duration = timeBetweenSteps * (step + 1);
                    setTimeout(function(file, totalSteps, step) {
                        return function() {
                            file.upload = {
                                progress: 100 * (step + 1) / totalSteps,
                                total: file.size,
                                bytesSent: (step + 1) * file.size / totalSteps
                            };

                            self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                            if (file.upload.progress == 100) {
                                file.status = Dropzone.SUCCESS;
                                self.emit("success", file, 'success', null);
                                self.emit("complete", file);
                                self.processQueue();
                                //document.getElementsByClassName("dz-success-mark").style.opacity = "1";
                            }
                        };
                    }(file, totalSteps, step), duration);
                }
            }
        }

        function getOpenstatus(val, day) {
            if ($(val).prop('checked') == true) {
                $(val).closest('tr').find('.' + day + '_close_span').text('');
                $(val).closest('tr').find('.' + day + '_close_span').text('Open');
                $(val).closest('tr').find('.' + day + '_hidden').val('');
                $(val).closest('tr').find('.' + day + '_hidden').val('open');
            } else {
                $(val).closest('tr').find('.' + day + '_close_span').text('');
                $(val).closest('tr').find('.' + day + '_close_span').text('Close');
                $(val).closest('tr').find('.' + day + '_hidden').val('close');
            }
        }

        const dropContainer = document.getElementById("dropcontainer")
        const fileInput = document.getElementById("images")

        dropContainer.addEventListener("dragover", (e) => {
            // prevent default to allow drop
            e.preventDefault()
        }, false)

        dropContainer.addEventListener("dragenter", () => {
            dropContainer.classList.add("drag-active")
        })

        dropContainer.addEventListener("dragleave", () => {
            dropContainer.classList.remove("drag-active")
        })

        dropContainer.addEventListener("drop", (e) => {
            e.preventDefault()
            dropContainer.classList.remove("drag-active")
            fileInput.files = e.dataTransfer.files
        })

        function formatPhoneNumber(input) {
            // Remove non-digit characters from input value
            var phoneNumber = input.value.replace(/\D/g, '');

            // Check if the input is not empty
            if (phoneNumber.length > 0) {
                // Format the phone number as (XXX) XXX - XXXX
                var formattedPhoneNumber = '(' + phoneNumber.substr(0, 3) + ') ' + phoneNumber.substr(3, 3) + ' - ' + phoneNumber.substr(6, 4);

                // Set the formatted value back to the input field
                input.value = formattedPhoneNumber;
            }
        }
    </script>
 

<?php 

/*
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 18.11951781008162,
                    lng: -77.93552567561743
                },
                zoom: 8,
            });

            const input = document.createElement("input");
            input.setAttribute("id", "pac-input");
            input.setAttribute("type", "text");
            input.setAttribute("placeholder", "Enter a location");
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            const searchBox = new google.maps.places.SearchBox(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            let markers = [];

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length === 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    // Create a marker for each place.
                    markers.push(
                        new google.maps.Marker({
                            map,
                            title: place.name,
                            position: place.geometry.location,
                        })
                    );

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }

        function checkFileCount(input) {
            var files = input.files;
            if (files.length !== 5) {
                alert("Please select exactly 5 images.");
                input.value = '';
            }
        }

        // $(document).ready(function () {
        //     $('input[type="text"]').prop('required', true);
        // });

        $(document).ready(function() {
            $('.selectReq').prop('required', true);
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

        <?php if ($imsg->getMessage()) { ?>
            toastr.danger('Error Occure Please Try Again! "error"');
        <?php } ?>
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC46_PI75dS4Jv3rIEIeblb3S13bZUFqM0&libraries=places&callback=initMap"></script>
    */
    ?>
    <style>
        input,
        textarea,
        select {
            border-radius: 30px;
            border: 1px solid #FBE50F;
            background: #FFFDE8 !important;
        }


        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 19px;
            left: 8px;
            bottom: 5px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #fbe50f;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        label {
            color: #603813 !important;
            font-size: 20px;
            font-weight: 600;
            padding-top: 5px;
        }

        input.form-control {
            padding-top: 4px !important;
            padding-bottom: 8px !important;
            text-align: center !important;
        }

        .table thead tr th,
        .table tbody tr td {
            border: none !important;
        }

        .drop-container {
            position: relative;
            display: flex;
            gap: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 200px;
            padding: 20px;
            border-radius: 10px;
            border: 2px dashed #555;
            color: #444;
            cursor: pointer;
            transition: background .2s ease-in-out, border .2s ease-in-out;
        }

        .drop-container:hover,
        .drop-container.drag-active {
            background: #eee;
            border-color: #111;
        }

        .drop-container:hover .drop-title,
        .drop-container.drag-active .drop-title {
            color: #222;
        }

        .drop-title {
            color: #444;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            transition: color .2s ease-in-out;
        }

        input[type=file] {
            width: 350px;
            max-width: 100%;
            color: #444;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #555;
        }

        input[type=file]::file-selector-button {
            margin-right: 20px;
            border: none;
            background: #084cdf;
            padding: 10px 20px;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
        }

        input[type=file]::file-selector-button:hover {
            background: #0d45a5;
        }

        input.form-control {
            text-align: left !important;
        }
    </style>
</body>

</html>