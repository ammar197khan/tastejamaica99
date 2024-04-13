<?php
include 'includes/config/common-files.php';
$a->authenticate();

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
    $arr['name'] = $_REQUEST['name'];
    $arr['discription'] = $_REQUEST['discription'];
    $arr['business_type'] = $_REQUEST['business_type'];
    $arr['remotely'] = $_REQUEST['remotely'];
    $arr['delivery_services'] = $_REQUEST['delivery_services'];
    $arr['address'] = $_REQUEST['address'];
    $arr['phone_no'] = $_REQUEST['phone_no'];
    $arr['email'] = $_REQUEST['email'];
    $arr['web_site'] = $_REQUEST['web_site'];
    $arr['facebook'] = $_REQUEST['facebook'];
    $arr['instagram'] = $_REQUEST['instagram'];
    $arr['cuisines'] = $_REQUEST['cuisines'];
    $arr['meal'] = $_REQUEST['meal'];
    $arr['payment_method'] = $_REQUEST['payment_method'];

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
    // $arr['user_id'] = getUSerID();
    // $inserted_id = $db->insert($arr, 'get_listed');
    $inserted_id = 1;
    if ($inserted_id > 0) {

        foreach ($_REQUEST['business_day'] as $key => $val) {
            $sec_arr = array();
            $sec_arr['detail_id'] = $inserted_id;
            $sec_arr['day'] = $val;
            $sec_arr['status'] = $_REQUEST['hidden_status'][$key];
            $sec_arr['open_time'] = $_REQUEST['open_time'][$key];
            $sec_arr['close_time'] = $_REQUEST['close_time'][$key];
            $sec_arr['created_at'] = time();
            // $sec_arr['user_id'] = getUSerID();
            print_r($sec_arr);
            // $id = $db->insert($sec_arr, 'business_hours');
        }
        die();
        $imsg->setMessage('Get Listed Added Successfully!');
        redirect_header('signup_2.php');
    } else {
        $imsg->setMessage('Error Occure Try Again', 'error!');
        redirect_header('signup_2.php');
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>
    <title>Signup</title>
</head>

<body>

    <?php include 'includes/header.php' ?>
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
                            <div class="col-lg-12 clearfix">
                                <div class="span12"> <?php echo $imsg->getMessage(); ?></div>
                            </div>
                            <div class="section_heading_box text-center mt-5">
                                <h2 class="main_box_heading font-popinns mb-0">Submit your Culinary Experience </h2>
                                <h3 class="info_heading font-sacramento mb-0 mt-3 text-end position-relative" style="z-index: 100">Get Listed</h3>

                            </div>
                            <h4 class="section_title_with_line" style="margin-top:5px">
                                <span class="bg-white pe-3"> About Us</span>
                            </h4>
                            <p class="product_text">The Tourism Linkages Network, a division of the Tourism Enhancement Fund has created Taste
                                Jamaica, a fully integrated website and mobile app that lists a variety of culinary experiences
                                from street food to fine dining, farm to table and food events across the island. There is no
                                cost to be included on this platform! To have your culinary experience included on Taste Jamaica
                                simply submit your business information below. You must register your profile for data security
                                purposes. Click here to <a href="signup.html">Sign Up</a>.</p>
                        </div>
                        <div class="col-12 blog_filter">
                            <h4 class="section_title_with_line mb-3" style="margin-top:5px">
                                <span class="bg-white pe-3">BUSINESS DETAILS</span>
                            </h4>
                            <div class="form-group mt-2 pt-3">
                                <label>Name of Business</label>
                                <input type="text" name="name" placeholder="Your company name for eg. Taste Jamaica restaurant" class="form-control py-3">
                            </div>
                            <div class="form-group mt-2 pt-3">
                                <label>Description of your business</label>
                                <textarea name="discription" placeholder="Describe your business" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group mt-2 pt-3">
                                <label>Type of Business <small>(You can select more than one option)</small></label>
                                <?php
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
                                <select name="business_type" id="" class="form-control">
                                    <option value="">select Option</option>
                                    <?php
                                    foreach ($business_types as $key => $business_type) {
                                    ?>
                                        <option value="<?= $key ?>"><?= ucwords($business_type) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group mt-2 pt-3">
                                        <label>Do you operate remotely?</label>
                                        <select name="remotely" id="" class="form-control">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group mt-2 pt-3">
                                        <label>Do you offer delivery services?</label>
                                        <select name="delivery_services" id="" class="form-control">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
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
                                <div class="col-md-6">

                                    <div class="form-group mt-2 pt-3">
                                        <label>Address</label>
                                        <input type="text" name="address" placeholder="60 Knutsford Boulevard, Kingston 8" id="addressInput" class="form-control py-3">
                                    </div>
                                    <div class="col-md-6 d-block d-lg-none d-md-none mt-3 mb-3 text-center">

                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAaMAAADQCAYAAACqVA4vAAAAAXNSR0IArs4c6QAAIABJREFUeF7sXQd4HNXVPTPb+656L7bcezfGhWKqaTYG0zEQAgQIEEooIQnVBAKBwE/vhGrTezUGY2Nw77Ysq/ey2l5n5v/uW60sySprGZEA7+YzUnbfvHlzZvTO3C6gB7nrTefidKt0Yo5DnKzIcraiyKqexv6vfC4IAiCIUACIoggBCmRZhiLL/ytL/NnWIYgiREFEvQeodooQ1BoIggiGEReOAEfgN4+AoihQZAmKFEFhigK7EZAVif7zE2MjSKIoVEcVYe32aun9G+anPd/dCfbbme79MLBYkXGbIkt5shSFFI1AUWhD/6kX+BNfL4iHhNiGK4ps8ti6ZRDojKF+QxLHQqVWQ1RpIIgqTkS/ofvPL5UjkAgCMUKKQo5GIUlRKIoE5ad+dycdQRAhqlRQqdQQVOoKBeLfbjrJ0ImUOpHRPz4IPiwAV7DNm+3mMmRFYRrGL2YzF4V9a6VfFUCIX08id+dXNEYRBIht2iJdFteKfkU3l18KR+AnQGC/vX6g9krGNEKbokBKA2OVR/58gv7K+GW0k1GciDpeX/tCfzFMFLvgzvIbU4k6XXwMC05CP8FfLZ+CI/ArRuDn2ev33486EhL7lkxzUITnfsVY80vjCHAEOAIcgf9FBATlghvmGZ6PkdEHwXIAef+L6+Rr4ghwBDgCHIFfNQIVN5ygzxe4VvSrvsn84jgCHAGOwP8+AoJygfCPD4JvCsCC//3V8hVyBDgCHAGOwK8RAQV4S+Amul/jreXXxBHgCHAEflEIVBAZRQH8zye0/qJg5YvlCHAEOAIcgQNBQCIy+i3HPh8IWHwsR4AjwBHgCAwQApyMBghYPi1HgCPAEeAIJI4AJ6PEseIjOQIcAY4AR2CAEOBkNEDA8mk5AhwBjgBHIHEEOBkljhUfyRHgCHAEOAIDhAAnowEClk/LEeAIcAQ4AokjwMkocaz4SI4AR4AjwBEYIAQ4GQ0QsHxajgBHgCPAEUgcAU5GiWPFR3IEOAIcAY7AACHAyWiAgOXTcgQ4AhwBjkDiCHAyShwrPpIjwBHgCHAEBggBTkYDBCyfliPAEeAIcAQSR4CTUeJY8ZEcAY4AR4AjMEAIcDIaIGD5tBwBjgBHgCOQOAKcjBLHio/kCHAEOAIcgQFCgJPRAAHLp+UIcAQ4AhyBxBHgZJQ4VnwkR4AjwBHgCAwQApyMBghYPi1HgCPAEeAIJI4AJ6PEseIjOQIcAY4AR2CAEOBkNEDA8mk5AhwBjgBHIHEEOBkljhUfyRHgCHAEOAIDhAAnowEClk/LEeAIcAQ4AokjwMkocaz4SI4AR4AjwBEYIAQ4GQ0QsHxajgBHgCPAEUgcAU5GiWPFR3IEOAIcAY7AACHAyWiAgOXTcgQ4AhwBjkDiCHAyShwrPpIjwBHgCHAEBggBTkYDBCyfliPAEeAIcAQSR4CTUeJY8ZEcAY4AR4AjMEAIcDIaIGD5tBwBjgBHgCOQOAKcjBLHio/kCHAEOAIcgQFCgJPRAAHLp+UIcAQ4AhyBxBHgZJQ4VnwkR4AjwBHgCAwQApyMBgjYn2NaQQAMWgGiAISjCsJRQC0Ceq3ATh8IK5DkvldCxysAFPpPP0WjAnSa2HlJZCV2/oOZs59L4YdxBDgCv0AEOBn9Am9afMlGnYDJuUG0tjTCkFSANXuiGJopIlXngiRJaAgnYW9972w0KE1Eul1EKKJgU7mUEHl1B9nwLBVsYiO8Hg/7OiM7D5VOFXbXJsCGv+B7wJfOEeAI/DQIcDL6aXD8r8xi0QswtHyNB+6+Bf/33DJsbsrA1MECbrv2XAwZNhonL74JsgxoxQhkqFHtBDJtgEoFCEoUKpUGZl0U3375IQ4/+kTUuETo1LHvQpKaEVlRhgiNEEFUUSMqKWjxCchyCIAcQQRabKmQEAwrGJevwrInbkYoGITZbEVzcwNu/Pt9qPeZYNZJUBQFEtRQZBkRSUCjl9aiwB8WsaNaYpoUF44AR+C3iwAno1/wvY+T0QdvvYrZRx6LQ+YuRF3ZVvznmYeRl5ePq6//C5Ytex3NjQ3Q6w1YdOZZ2LxpM9av/x7RsIRJE8ZCrVHj6SefwLQZs3H+4sV47LFHochA0fAROOqo47Ds9ZdRW1sNnU6L0aPHYeKUaXjxuachS1FkZOZi8uELsGr3PjI68piTMHHqDDzzyH04+7zz4Pb48MnHH0KWJJxw/FFodnqhMdiQnZuP5Z9/gLnHn4YVO6JwBzgb/YIfRb50jsBBI8DJ6KAh/O9NECejH1d/A4vFgosuvx6vvvA4Ro2ZgPWrv8SJC07FC8++iKtuvB2ffvgmhg/OR2VVCQzWbAwdPgZL//M0brzhT7jv/n/h6mtvwIfvLEUgKmDGnKNw+eIFWPKPJXj6qWfx13sew7vLXoZKiSAYDMBotmDe/DNx31034cT556BBHI6cJDXTjFzOFlgdDsiSjCV334UV361GZs5gOFtasOH7L3H8ccfii29WYdbhx+PT99/E6edfgc+2RBCV/ns48jNzBDgC/30EOBn99+9Bv1cQJ6MNa1fDYrFi7nEn46P33sAJpyzCZ+++jMGDi+D0RnHECWeiZPtaeFvKIIgi7KmDkZtfiNdfehLXXH01HnzwQVx3/fW4/757YbRYodMbUFFWjJmHzkJpeTVOP/NsbFz9ISqqndi2aT3+dO3vkZ2RjHc//gYmoxHDcyRoLbm4/5GlmD5lIkaPHYO3334fp8w/HbV19di6fScECGhtacBll16Ge+69B9NmHAZBEJE65AhsreJM1O+HgB/IEfiVIMDJ6Bd8I+NktGn9GsyZeywevvd2HDXvFMw67Gh8/NYLOP6kU/DG0jdx2VW34ItP3kVBdjqam2thT9tHRldffTUeeOCf+NO1N2HZa8/BmpyL6bOORF11BUzqMB59/DH8372X4I2P16G5wYlAMIqCXAPmHzMZN9/1Cs6YfyQm5zYhap2Ea//2DOafcjImT5+EFx5/CIccfiw+fP9TnDF/MrxeFd7/+Btcc+2fsOTeR7Bx/Xr8bcnDWFOdggjnol/wU8iXzhH4aRDgZPTT4PhfmYXIKE+zExWlJTj86BPw6AN3YuFZF8BktmD9mm8w78RTsGzp6/B6XFCrdVh42kJs3bYDVnsKklPT8P23X+HEE4/H22+/zaLgFpxyMp559jmYjDpYTCGcc+4FePP1/6DRFUBleR2GDR2MhYsW4vkXXoKoVsFsNeOweXPQ6lyDTFshvvhsN1yNTmh1ehiNGpyycD52bVqD5d9uglYtw2LV44ILf48133yJV5d9hT/e8Dd8ssP2X8GOn5QjwBH430KAk9H/1v04oNVo1cC4PBH00xcSYNYr8AYFWAwCZFnGnnqgKB0wqCVEFBXKGoC8VAGBEOAJKkizAt6QAJNOgV4twxVUw2FUkK9ZC609F2FPLe7/91IcvWAhHn3wMZx/8XlIH54GjaCGoAiIIIodzhKEpAjSjMkYastHmj4JETmChqATe92VSNJZYdNYIAgC1KIK6gjwj9uW4KpLT8WgJB++27QWG+UbIQk6du1Cw0rUl/6IlJzRELOPOiA8+GCOAEfgl4sAJ6Nf7r37yVdOpHbBhN0wBNcg6ndjk3saGp1elJWXYfCwIuSOzsWW5t0ISeH9zk0+IbPGiOGmwagMVcMXDcAbCUBh6bQAogryzJlwSGbs3VOG6dOHQGxegQxVFLXOALY7c+FMzseGd77GddddiscefR65s0+CL2BBNKSFHJahqNywC14EZRu8SGPTqkUZanUQkhCBXiXBH7JBklQ/OTZ8Qo4AR2BgEeBkNLD4/qJmL0gVcfzYKPyuRrz+5nuw2lMx78Rj8O77H2Hc1DHYLu1FVO7ZwUOEZNWaICkyfG1EJAoCjGo9fPVeqFUq5OflM0w8EQ/kaACZ4QoMk0qgS58Dd+VHeLF6FHw7g9AXmTB+pAXjPd9BDR2gsQM6K7T6FPiatmNtZAb8yXZQzQdRlNg5VYKCcMQAlysVoWgUGq8BUdmAkGBjybyp2Ak1QqjFOLYGlRJEhn4TENaiWpkwIPdKFIEUiwiqUEEVKVq8+4ewF6aJSLWIqHPJqGjqPUlYJQI2w75KF6GoAl8IKEwVEZaA6haeZDwgN5JPOuAIcDLqB8RTBwlQIwi/ZMSmCkro7MckB3hIILwevuAnCR9lNS6CVj044fE0MNMu4OQJUfh9QSxefAGeefFp6PVafPXlCugcBjSlxKor9CYGtZ6Rj0oQoVVpoBZUTJPyBwJkhINGp0aS3gG9WgtfxI/WkBuWcC0G+9cjw5YHVcSFCEQ0R2TYtTqoLEUQBS2crp0IRCMQJT/STGmQoj60wghF8kFSGZClVrHEWlFUUO93oVQyoEaTA1GlR7bUgMFyLZI1akQVDdbWFaAyrMNJORuhU4kISXosrx+KYv8RiMDQ1yV2+l5UwtCL9RChglfJZNcYF6NWwNg8BYGmPWhqrEdmdh5U1gJsKIs9M/EyTFMLJaz64jXMPPZ8rN0rtZdRIk2VZpMUtIe+j8tTQRepRGNdLfsyIysXaelZqCorRmZOAX4oFdHqjz2QFBhC56ESUURiRMhRzlUHdH/54J8PAU5G/cB6Zn4zPnr3DSw450os3x4FBRJkOgQEwrFNw2IAWrz0Riywiga0AeyqlZFhE5BsFtjmUt4kQ6sWkEPVDAA0exX2WU/iDXyEFu8j7GtREOFwFMLjrkY4GmSfqVVGRCV/++Gpttth0E4+oKuzGgRcOEcFn8+Pf97/LwwfPxwTpo7H0heW4Yjjj0S5vg5RpWfNiNY1PmUEWsoamM+KxGgywpbhwPq9m2GwmmDU6zHcMRjPPfwsTrv4DJT6KtvWqCA5XIOM4C5o5TAyVEH4FTU2GacjJ2UiNjXthFuKshDx7Gg9ZkhbobEMRjR5FkRBQYNHg7feX4ELTy6Evnk5ZMdkBFy7ASkAU8oERJs3oD4Uhk0twuQYi2DTegg6M1ZrxmB4ZDeyU8dhy85qfOk5FxabH1I4CMkT29SDmtgaR6lq2O4uSD5oVM0YYW2EoLNDa3KAXk9CzhKsc45GmXIUAoID04rUqCteibXfr8D4yTPx+SfvYP6ii+HIGgmzPkY0dAYx6sUfL16IJ17+FMGIgrpW8v0pGJwusjHBKLChVGJ+vkmFKnz9zv/BbLYgKzsPy794H7fdfhcqqupgT81GUNIykiOhOUoaZIzMVkGritULpOewspkz0gH9YfDBPwsCnIz6AfMhOfV4/aWncOGVf2dkNGOIiIbyTRg5ZiICfh+2bV6PGYceio0bN6GupgrpmdkYMXoCGhqqsWvrFuiNBkyaMgM+H41dh0gkjBFjJqHa58DuPaUQRBW0lkwoghbZDhkqlYCqpo9R1hgjI6spBb+fuwTf7/kcK7e9gSlDjsUxY8/BnW+esx8ZkXnIpBPYWzFtTr0pcfmpEo4YE4In4keDrxlvv/gmGiobcNy84zBk/FBsdO1g2kd3YlDpYNQQ0QzCwsNOxRnnngWDQYe0zDTMPmI2aijKTiPAbDPCoNZh0XGL8Mo7L8MV8UNFFV8pwEGtRsDnh9agQ0OoCVatBWJYgEVnhE8IIhKNgsx+PimAdJUBaQYzPlq+BunZmciwp+C2v96Bux++B2KkFcnODwGtBYrKiKaW7dhlmIBGxQiHGMYh0a1QmUdie7MTLY6h0EkeTPJ+BYdtCODdy9bCylBoLeynoLJAIRLW2gC1FYIuBYi6EFHU8Hor4A25oRNk6KxDYVW8gL8ae32pMOQsxD8feBwLFp0LmAfBVbsNrzxzP+7715N45T8voLauBvakVJy96FScf84ZmHfqIuzdVYwLL7kMdkcalr3+H3jcLuQWFGLK7FOwZq8KY/NU+Oqtf2PM+CmYNPVQvP7SE5g2dSwqyipxxNzjUV5ZhY8/eAuSrGDOkfMwbsxILHvjNZTuLUFaeiYWnPU7rNwNuNq0p348/vwQjsCAIMDJqB+wdiWjaYUS/vPYbbj2liWoranEg0v+jGuv/wtefOElLDjjfLzxn6dx6oL5eOvtN3HKogvx4+qvMXRQDsJRAakpSYiEfXjnvQ9w5VU3oGTPVmSkp+KrLUEk5Y3HqdOBDS0bUVO7BVt2v81WOzhjMkbmz8bIjFF48OOrYDE4MH/aFXjqsz+3X83UIXdgTM40qLQuuKUmGFVmtLSkYmd5K/yKdb+rNqoDGDakDDPyhmGHsxTOoAtGUY9MdRrqpCa4Im7U+ht7RMusMUCn0raT0dKPlsJmt0EjqtHU3IKH/vlvqEQtBg0uxAUXnY15c0/E8688i1tvvg2ZObko3bMH4yaOh8/rgtlixx+uuBjfrvwO3379HeSogosvuggqtYK1mzfg6OOOwtKXl+GIw+bgLzf9FfYkO848cxHuv+9fGDluHGoqK3H9rTfAry1HIBJEWG1DSJYYyZJYZB+8FR5o07NgdljYZxoljIzALiTBB6j05FHC3rAAr9oCkQgJCkQoGJU2HhZ1KkKeGmzxl6MpKsEvGqGlSn2RViQJIWSFyzHUaICUcxau+/uTuOHq8yHVLker6UhcfeX1+PNNN+HLFatx7kWXY+XXn2Pi6MG49k9X46FnlmLLxh/hbqpEKCRBb0nB4XOPx9KXn8L0mUegRT0K2UkiPnvjAbS2tCA7Nw8le7bj9tvvxvPPPoELL7gITz39FGYddQq0Gi0ef/Au3Hbb33H//Q/gkj/eiK2bN2H81EOxrlyNRvfPYFvux98WP+S3iwAno37c+3Yy+uPf8c0OCVMKonjp0Y5kdAPmzz8NssaCKTOOgkELtFQXY8mSJRg3aRpcrU1Ishlx7LwTsWL5Z6irb8SGdWtx4z23oGpPHdJTU7Fxbx3yhs7DkMIqbG7Ziqb6ragoW8FWe+5hf0VTwIlRWRPx5nf3o6J5F86Z81e88NWt7Vczbfy5EI0p7ZFvpFEUmLOx/ZvdOOy4GQgH1GjxmhAK6REOC3Ak74SgkzEqaQh+rN+KNG0y0lUpECGiOlKHqlAdmoOtPaKlV2lh0hjayeiCSy+EwaDH2DHjEJZCqKyuw/ARRbjn1n/goUcewKJTz8AzLz6F319wKV54+wV88cmXaKipx3m/Pw+PPfQk/njpZbh9yd249KpL0Op04pO3v8TCBSdizQ9rcf7ic3DPkntxznln4euvViCvKB+FOfm49JIr8OLSF/HuW+9Cq9ZhyOHD4Yl42ZojchSesL89uk+RFcgtUSSl21l9vq5CkYBdowYtWhNGJRWh2e9CU7AFzrC7RzyIhGelFuK+O57ANVcsRn6KgooWNf5w+a04cf7J0OosmHb4adCpojCq/Djv7NPx1CufYvvWjdi9ZSW2bN6C08//I3IKR2LD6s9Y7ljYPo359b5Y9hBS09JhdySjrHQ3rrryStx///247PcX4d7778WFl94ISTThb1efjf+8/DKWvfs+VnzxGfIGDcEZ5/8B68pUaGwzQfbj8eeHcAQGBAFORv2ANU5Gl193G5xeBVk2Cfcv+RuuuOEOVJbvxaMP3Ipzzv0ddhaX4tSzfocNP3wLs1bC66+9gUuuuRlWnQK1SsK/H3wYZ112Ju2UuPOWO3DXs/dg5eYfkW3OwMTho+EJAXu8O+CJ+NrJyGZOx2VH3YP31z+LJFMW23S/3vbqfmRUNOwEWO2xyLW4UL24qD8Cg9XIcn5ow7RoTBjpGAyzYoIsKAiEQygNVMJIQQGaNKigQpPUgi2e3Qi0+ae6g4wCFWw6czsZPfDYAzBbzEhPSUNxcSm+Wr4ckydPwHtvvoe77r4dZyw8i5HRVVdcg6dffxobftiAmqoazFswD08+9CQuu/gS/OXWv+O6O65HOBDE4/c/ht//7nf4ZtVKnLP4bDzyz0dwxjmL8M3ybxkZ5WRn4/Zb78C/n/o3vvz0S/g8Pgw5YlQ7GZEeEJWj8EeDLCKQzI2BFj+MVgOMhpjpsKO4wt72yEHCicyP9LPUXQ1nyNXnU0P+s0mpI7H83S8hShJOPOZwPPnsKygqSMeQ4ZPx1BOP4tZbb8LTL7yPk06Yi5tvumkfGW1exSIZq2vrseCMxXjq33fhlEWLURMtQk6S0G6mmzB5Oh578E5cfdU1eOF50owuxkv/eR4jJ86GUW/A0leewnXXXo93P/gYx564CPfd8Wdc+IcbUBXKRq2T+436vIl8wM+KACejfsA9M68Jj/7rbvZ2SjJjxqFoaqjGj2vXs2gqWY7gtjvvwfXX/hHZOYVoqKvGPfc+gGeeegLV1RWAIGPBwoUoKd6N1au+h0anQkNtHf7x7L34sWErxqUMw86WUoTkffk8cc1Iq9aD/nmDrRBFFfQaEwIhD0x6G/ssLl3JSI7KCDkDMKSaOl0xBQSMSRmKRk8LRpqGoDxSgxJPOdMgzCojRliK2Ca+0b1jX85QD5jZtWaMSh7CfEYvvvcSapQmpBtSsOyxZSgaUoCJUydhya1344EH/4lFC89kZHT1FX/Cc288h3U/rENtVS2OnX9sOxn9898PYcGiU9DS5MSmHzayChFvvfsu5p85H4/c9wj+dN31+Pbrr6CzGDFh9Bjc/vc78dBTD3VLRvEl03WR1hOWIohSZIAIGPQ6WLXmTlcVjIYZcZE2dEjGeOxy7kWZp+aAnpYkvRXDzIX46I0Pseb7HzB77mwcP/84mFQqrPnyMyx9+0scddihmDf/BDz40FO44JIbUFlZj5rKvThk1hF49T/PYuO6VZh3ypkYNv4IVt18YqEKFVu+QG5eIbRJRWipXI9oqAlKRMLk6XPgdAfw5CP3Q1YiWHzJdcjJSMM7b7+Nlcs/xJRDZuLY+RdgdbHEfUYHdCf54J8DAU5G/UB52mABctjN2iKQGI1GmAx6NDbWQG8wIyoJgNYKkyYKl7Me9qQ0VLWqkW4TYRer4RfdUAzUoVUFX5MHRosJ4WAIEaOCWl8DCq052Npc3Gnzd7dWoKlha8KrzcieAqMptX18NBSFr8EDW66DBTHsC0AGRicPQYmrEqISCw7oKCxPSGVgSay9hz/QnAKmZYzFm88sxYLzFqIsUA2rxgyhWY1vv/oCVpsDohqYf/yJeOmVl3HG2Yvw1tJ3cfo5C1FdWQ23y42ikUVYs/JHzJg2DWUVZfjxxw1Qq1WYMXsGbDYLPvvgS4SiIUSDEhaeuQCeZjc++OgDnHDMCVi7bg2OWzAPu3eWIBwJQszStWtGHa+JrsMZ8qC1ygm1LMCa54BdF/MdxUVWZJa7RJpjviWbJfuShnqgMtSej1R9MlrDbmb2awi0oMiWh0DED4MgITu4CxZjFsK6HGiizaiVxqOkUYN6F1XIiHXxDUaA0kYK+QaLxsywCyxsm6Iv54xQoyhNxXKUdtbK8AUVJJljd5eCFChKk/xM+raoToqkc/q4v+hA7yMfP/AIcDIaeIzbzzA6R4Q9fSt2Oku7PStt5kfkTGPakTsc83X81BJsDaB5Zz0yp+WxEHGSFH0SpmeMwxeVqxCUQgd1yixTGnLMGcykR8RK50gxJCHdmMzmpQ2eggGohBD5o+j/07WSiY+0FTom3ZCKgBRka0kxOFj8c4W3FhToPNiex3KYyNQmKRLzBZk1JmZCU4kq9h1F9hHhBKUwMztGlDDCcoQFYASjIRDREBl1FLvODJXQfeWGbFM66vxNaAw4+yTkjnPSmmZkTsD3dZs6+O5EpvluaNzRNlTBNPeXGD50ISBLiLp2oSH1TNQ2mbGhDPCHAL+7AaHmrTBlHwqdTscSaIdlyhhTIKPMW4JcMQtmkxEQdVi9R8aWyggUmcItOr5y7FsZBQtqVJSTJcCiV2A3ATUtAkIRnod0UA8/P/igEOBkdFDwJX6wwyRg+sgmrGv5gW2G3UmOKR0pxiRsbN+oEp//QEZKwSgEtQhBJbCacfRvkDWHBSBsbtp9IFN1O5b8UUa1gdWos2ktaKlpRXpOTEujz+hfd0LE4g53r30QUZPZqy8hcnMG3QjJEaapOXRW5FsyMciaC/IDeSM+7HDuZeTga/JCo9NBa9EwIrLpTOyYrkLY1PgaGWmShignkOVMGExOG409rgoWbBIXijgcZMvFjpaS9s+GBrdjesGh8NV+hQ1BLcqMoxluyfoU6OUMfPfRJ5h39BzWsmPR6adBJ0SwatNquDKD7FmakzIVJhjZfH51BHXeMCS/DhHoIcsall8kQESDU0J1qwqjcgTYkvdCFoMISwFElSgsVOEilIl1uy1ME+PCEfi5EeBkNECIx7e0uEFkapGEZvV3cIW7r2JAGsTE1JFYewCmuINZurvcCdGohjk1Zp5KMyQh15yOdT8xEWplNZybGjB81qjYZhndl5jbdf2BaIj5aXoSqn2nU2n2+5rIQZKjiCgSyNfj6zAHBVZMTR8DX9SPlmArsozpLB/qh4YtcFY0w2A3QmehUG6w2nrdzT8meTgichg2rRWyIuHr6h+Z1ha7xzEyp+PSDMns/rpCXuRbspgttMxd3Wm9dA7Ceq+7qv3zNN92HJM3Frsqv8EPxhntn5OJdJxlBL56+wvkDMlFU1kDTl1wavv3JaEK7PLsZWRkhBHFwVLs8ZZ3Cx9padMyxjH/H5H+uoZt+40j83BlvRV1tYUH82jxYzkC/UKAk1G/YOv9ILLzzxgRRCgaQTiigUbUwOqoxFbn9h7fqpP1dqQakrDTuXcAVrT/lHJEghSRoDFq2ZepBgcyjKnMN/JTCkWtmRQjkq12thGG24Iy6I0+biaMn4/ygMhU15uQxkEkQAQUkSWmGdBGS6YnRkqKzEyAHYVMfSMchdjYuJONzzClMFNihasGdYEmRiYkpLUk623Qq3XQiVr2k0LWc0yZKPfUoNJXw9ZMONE56HpI6DP63Rvxw661QKPSgO7n93Ub9yNXm9bMNCPyCRIpkJgkD07RlKMqqsG3wmDIQizUPElrwzDTIHi9PjS2NmJS0VjjO3y1AAAgAElEQVRUeOtihIIoPF4PdpfvwTETj0BLqBXFvljgSU9CV0lrJ5Nld2H6RKaifwS2lvK2Hj/l3wCfKzEEOBklhtMBjZo2WI2QaQ1qfA3tb88y5B6rF9Dkx+bNwoqaH3sNnz6gRfQxmLYsX7MX5uRYFFmK3sZCyjc17fopT8PCpxUByM7IZBs7kRH5cvyRIGhjVlEl0TYhP05PJkwaQkRD3xMJdZRYxXA9IwWKlKNxXeWo3BlYXbehfX4iteDuECZNHwWT2gi7zsoILRAJwx3xwB32IBKVMFiXB6vVzMoRtUZcjPBaQx52Ltr42f+6mO3ou2xzGsYnD8c2ZwnK3FXtLyFECGnGFKatLa9awwhMiYZwJtbArR+Ez8OpiIht7TTatC42vwBm9tvStLuTXy8ajiLdmoKWoOuA/Fnd3WQy0w7Vz8Hnm3jV85/0j4BPlhACnIwSgqnvQaQNkW2e6rudMNWNL6pW9rqxdpyxwJLN/DXbWvb0faKfcETTjnokj0hjgQTkj8kzZ2N3aynzi/xUEnD6odapoTfpmR+EzFtkjqNNnAjBrrWyzyiwgPw88Y09TihyN5v9ga6NcohmZIzH+sbtnRJZ/fVe5BXksvX4KVpQUVhUHQVBxEUn6jCOSKW1mBV2JWkJuXt9sYgfS34oMtdRcAaRTq2vkf0kIXMdBXvsbi1DWmAPjskahGZPTScy6nqdlOtEAR7k+4pL0B2EoCjQ2Q6swGt3GNL9mJk2B2+v0kDC/onAB4o7H88ROBAEOBkdCFo9jC3KEDGpUMCXmxswODMF9aqv2jedvqZXi+q26KqeTXh9zZHo91qRnNlye7FTRaK6ayKrsk3lfHLN2Sh1V7DNNlGhDay3thLxOHIin6gsdz+WSsElEBSQ6Jo6jiMiOix7CtP4qEJ4XKgCQzQQgcYUM1PGhcYTHh2lyFaACk81M2+RdFedobe1ESlZtEaMTh6KsBRmQSIUNDDUXoDtLSUYGdqGKfkz0di0ZT/NSKtSMzMkYUwNDEmjbAruC4hwVTqhs+mhtx48GaXoHUg1JGN7YyUizgK4PUX9gZwfwxHoFwKcjPoF276DhmcryMkuRZmnCmOThyEghVDSWs7e8ultvzuTUfuGSH4KUYN0OFDqr4Ygigi4AjDYDaC8INosjckmBFr97DudSQtvnQcGhwFkiAo6/bBk2iBSj4A+hMxDlNhJ5CHJEsJtjuyqDRUYOmkIcm1ZbAZ68+7LXBY/Vbx/ETNvRcPdNt1zFrfAlG2GQsVae4gi7Gvt/f2eiGVCyghUeGrQ0qVqQjQYgafGDcegWMh5XOJljTp+RpF4ld46FgVIhMSaBvaTPCnEPdecBW/Eg617PkNFcwmscivs5IcKu9Eo6yCTrioKULf5jmgtdlsuRg86grXkqPU3sEANwpP8foIoQKQeEQcpQ+z5nbS3iC8NvpYRiEY6JwQf5Gn44RyBbhHgZHSQD8aEIU74NduZQzheXqfNH97uX+jOqUxk4yxpRNrwLDg8dtRKNRB1KvgqXLAMToIUiSISjMCYZGLERE52lUaFiDcMFWUwUnmbYAQasxbhlgD0KZ0rK3S9LPJj2LSmTkEDtC53iwcWqxmH50/Hypq1LBKMiKqvBFean+akqgu0NlZeJxpiZNxRQp4goFdBEn7+8jNUjscZcqOumwKvtF5FUjoROZEr5Rt1DayIkxHlTlHoeSLY9PZY0fw6UYVt25ah1RWLqtNpDDCa0tDqqmgnOq3WinBb/buMtJGYNuZMZt5rCDSzHCsixYA3gPI1e1F0+PCDfJLBSh6VearZS1Rc5KgOgbpxCIT3JVAf9In4BByBbhDgZNQNKOT3UasAX4hChmN+IHoRpox28gt1lNG5XkjWLWgMtDCtgzqd0qZGkVlkniGHt1bUstDixmAL22hoinAgzEq4mGwmTEkbw/xFzJnda5OH/RdL4+s31MOabYbBYYKg6T7Rka1NY2La0WBbHotaI9KJ0pu+L4Di7cUQ87SIiomTRrweXcdVdQzPZomn7iAU48G/tR/oXy9t+Mfnz2JBAt1h2rSnAUmDUpkGEpd4G4yu54qTUUgKwRX2JewL7G3NihxF8c734PXUsmGzx5yJifmz8PhnN8CgNePoiYvh0Frx+Bc3s+9jZHQGLFoz6v1N7VPTM+NudkNnP3gzHYV2kwnQ0yXXS1FUCDQPRcCbC0XeP7T+QO8NH88R6A4BTkZdUCFrx6yiMLxuJwRjFrwhBcmaVhhNZmysUqHB1ZmN8lNEJGetQ5W3FjadhfXbIRlsy8eW7zbi0Bkz8PyzL2Dh706POdCjYdT+WI2MKdlsLG2AVM+tOehEra/pgCsgEPFpyaegSGjc2wglLCF5aFrnej8AG+PQWzE6eRh2O0tZ1F68YgE57EtrKqEyqaGIMY0nEelu8yafVGvIy3J+KAS5/ocqpE7JTmS6n3QMReqNTBrMouC6k/otNUgfEzNNxsXB7t/+105kVOWtazPR+VlYN5E7je0rFL2nizKIamzdtgwudzXUagP+uuAF7Kjfiu93v4/qxh3Iy5mKuUXHdiKjWePPY4Eu1d769mkpL6v4h2JkjaOutondt57WlGFMYdo9mSS7iqAIiAQd8DaMQ1SKJdhy4Qj8lAhwMuqGjPKwDrdeeykeeW4pHBlF+OTNZzBj9pGQjPkwqCVIUgQBScc6co7NFWDUVyMsRqBSqaDIMmsSZxWNePrxF3D6Gafi/DPPx3MfPI/1jTvg8fgQ9YVhbCtYSs7yTFMK8sxZLMeHIqUo/4QIgjQrlldDJrq2EjjksyBti0rjUFtvSrakTdEXCbCQaUmi/B2B+ZkMDmPsWFGFFJ0dI5OKWJhxvC8RHU/zUqg0vWEHnbFSQdmHFCT0jHW3eZNm1NIhRFsOSxCpzejPLHnmDHbdHbWI+BLIz0J+tnh+EX3eXeBCfHyBNZuVA4r7AOkFgDAmjYvCvBOpyNDx8gl3o6jBus2vwuWuwsjc6Th9xnXYXLMWJlGNl1bciYzMsThl1BmdyOj82X/BTmcJi/wjofNSVYjyFSXImX3wiarxFiDdJcR2XL8Y0sLnGgKfN7Hn5Ge+9fx0v1AEOBn1QEavPv8EcvILcelVN+Ht11/AkUfOhc5gwovPP8E2/2mHzMS0adPx7FOPw+93weNz4uLfLcaWTVuxaesOzJg+BR998BFuvvVGnHtGjIyWr/0OillkWf9xoWoApGEUWinEONjunI6TzH5vqBARVSJsDR1L19DbejxsmCLFvPVumNMsgErA9PRxjORI+2oKtHYyWxEZdQyf9td6YMzsXDS0u2e7u/I8RIbNQXe7GStY54WgUUGXfPAmpAP9+6IkV/LjxTHpeHzDjjqmParaNAkyN1p7KAVEx1F4dn2guZMvJT4fvRxQn6REhQiQfHeQ5XYyOmnKZWjyNcLpqcUZM67CQx9fy1qZdyWjYyZfwk5T44tpRuS/oheXSCgCje7gzWe0trk5h7AahX2VUo0EUuCqnZboZfNxHIE+EeBk1AMZffHxu8jMzsWwEWOwd88unHj8Ufjuu1Uw2dORmZ2DpS8/gyv+cAnef/9dXHrl7/DAAw/i6COOxIoV32DuKcdgVOFwzJ4+B6+99QouOOciPPPec/h8+XJYR3WO3iJzEmk/RArDHYNR4q5g2f9UO402dzUr/KlHstoBm9rKQoK3+favkkC+qO5CspvWNaBo2BDUSfVo3FmHjFFZCPlDULwRmPIdCLr9rAqDRqtB2BuCxqiBz+mDKTkWmNCbUG5SnBApQq8u4OzkT2kpboLVYYY6pXOodJ9P5UEOIDwpeIGqWcSrHHScMtTkhy5l3wuBSW2AXt05xLvjeMoDo4rdPTUXJNMkEUMi0YLxjrikXcc1I5POBj/lLkGBxZCEYNgLQRChUWnhawtHz0ofg8MmnB8LvW6JVW+I1/GrWLUX6aOyWIj3wcqktFGsZxOVTupNooEktNYecrCn48dzBNoR4GTUCxldeNmfcPet1yA7pwCXX3YxXnv1VQhaI6x2O/weF+YdezQ2bt2M0047Ac88+xwmjhuPb1esxOIrLmA1y46bdRzeeOtVRkaPvvUUdrj27Bf+3NHU5dDZ4NDbEIwGWTmZ5qCLZdbrBS00goaF+lJgREWgGlTRoatQJBz5jjpKniWTmfCoWCf1NBI1IqJ+KgUUYTXZ/I1eFp2ns+rhqXbBlGaGs7QZSYNTIFIURy9i0RiZqZCE/ETxtt7th1C0R4cAgYH+uyN/B2kdE1JHoMrbwHKDur7hS1GJRSHqzLGNu2NEYE/rI8wLrDlMc6Uw8e6ECIlMlPQC0ZOQ3476I5HIchQlZSvhDzQzEopIsdJA9Hu+4EKTbEdUHcOW1jg8cyLycqaw+0gh5qTxxcseUVQgRV+q9QevHVEAztiUYVjfsL3XOoGCJKKlZhYkHvY90I/1b2Z+Tka9kNG1tyzB3uJtuOris/DmO+9h+YoVSM4owIhR4xHwNMFqUOHdd9/BuRcuwhOPPYWj5x6Jb79ZiQuvuIhtKsfNPA6vt5FR3GfUsZV1X5WoRzqKUONv6JSs2duTSXNTuG9HoTbZJe7Kbk1MPc3lrXXDlG5h+Su9SXwjpzo6RJy0GXeU2i/2InPuoAH7Y6LVkUbDohep/p/OjBGOwSh1V3XrhKeFhD0hBNxB2LJj9dfoGoxqHSPV7ip20xj6nCIQCd9Kbyz6rSfprdgr+WQoj6mj0MuDO+RtJ01ZlrFYswMu1x6sTj4TkqBhBEaVKjqem8yDRI6SHCtJ5K1zQ2vRQ9slibc/4JMPk3D8pmYt80vF/JUU7t9ZVCEtGmqOAEXbceEIHCwCnIy6IaNJadXYtX0LxhxyAugF+utP3sRhhx/O6sx9/PEHgCIjr6AIh82ajk8/+QDNzhps2rAVF15wLlpdLkydPY2Zqx578DH87pKL8OJzL+E0Fk23o10zIhOYWW1o1yy6u5GUU0IJkjuciZUJIlOdO+Jrr3JAZX4mpo3AusbtB5SkGfGF4av1wVZk73GDjm/S8SrX/q5agaLAV+WGKXfgim7GiYR8bkRK41JGML9YcWt5j2/1pEVQ7q3YJQSetCoyoXUXTUf9kijSrIRygPrwphBBEBZdhe43hdaTCbGjUDRcRxKnZ+wkeSPsKeNQVr8B280zkW3NZ7XyXF16MNE8VErJFwki4g8j6ArCktl3m42+XjDGpQxnpY+ocG88WIJMgnvZ9XcWyTUMrc2De+yddLAbFD/+t4MAJ6Mu95qUgTG5Kpj1AkoaZJZrNDZXhYgM1DplDE4XQQUPorICIdSC5V+8hekzxuOJ/3sadz94BzO00OZAyZZENvGE0JawC+VkNlKoJpuaRW/RBtib0Bv5IZkTsKqW2pknJh21IzLRUW21YldZYgd3GNW0ux62LDs05ljRzr5kv2rZ8V2rd+Wqr2l7/Z6IMFlnZVFzhNVhOVOxovpHRKQIWntoTli/oQopozNZAnFXITOaWWvcj4DJfEruMzKZ9iZ0yXTfu6vO0FO/JAos6VpOaapQgxEphQgHnNjmakJmwZnY0LSDJbp2lFg0n7eTny5CJY4M/TfXUZuJRn8L9rormUbEIgUFYLi9EFmmdKyu2wjKt6JrpeukHlBVJTMQDPf/nAf1EPCDfzUIcDLqx60UxTAs9j0oFP1QS1rU1VZi6IgipOWlojXohVoUWSb73oatrPQO7cesE6mgYlWqu3v7ps3UYk6HWt158x+RNJiVaOlYV633DZHCfX2QZBlH5kzHd3Ub+l0JnDa2QLMP1hx7Qih11Ah8dR5oVCpoUwcmJ4Xq7KUYbJ2KmlJEIr3RU4UC0jioZE5XTaZpewNSRqb1eD3kHzJp9J0IKUlnZz663u5BX0EMZAYkH1tXMmkJdq4DSCHjmWIEI6PFSDLYoTVkotnXiu/F/E5t/yi/ifo2da1yXr+jFqlD0/udczQnmwj9h27xoUaFpC0RSREZ0TNNoeVOfxSVpeOh12iRYROQbJXR0CqirJGqrCf06PBBHAFwMurHQ2Cz7UBry/c4NGsyUlJS8UPxBqQPT2EJrSQ6tRZZxjQ8+8m1iCZYAVsUNZg49gzYrTmdVmTRmFn/neLWxLUbemOVFAXkL1pVt6EfV7jvkIZNNUgb1zk5tKcJO5mnaBPqp1ZEG3J8w+uuCKtBrYVNY4ZG1VmzJJIfYi/ArraeUB3D3Q8EhK716ZJ1Saz1hSfScyv4jgEF3Z2LtDgyu3YUuraOFbjpO8o7I62ZspjG+VYhN/8UfNtUgVbsC4+Pm+a6vaaDwJ3mo1Ybn1eu6hMulmytUmNK+lh4wh7kmHJZYEWFtxplnkqMdAyDs7EAP+5NvKJHnyflA37VCHAy6sftVetcEMXPYagDNGo1ImlR2LIdLJItKkVZ3g45vN//+nYE20qrpDsKMG7Qkfhs3TOwGByYOuxk6FR6rNr5Llp9tVCJakwcexbsts5kRMsbmTSEJTv21uun62XkmDJQ429kZYoOVvxOP4yOvjWcjqa6iDsElVHTYxFXeqvWdPGfdLfOeLVv+kkERX4dg5o0l+6FyKjUXdlu+uqoQdSsq0Ta6EzW0qI3oY2WCIH+kVBDOiIbamBHRE/fs3btbcmvFEHXNXij6/x0vRSp1lG6CzihIAcK5yfJC5dgvMWGXU07sNs6h2m4YannuoGECWl2e1fvQdaEXHadROzhaBT+Fh8rwEtV2nuTmVmTsLJmXUKPDJ2LeixRcV13xNte6ooi/ogTRyUNhlZOR0urBYiGUN1cDDFJhbDkg98zCCFvRkLn4YN+GwhwMurHfRaFKGwZa6AIsRph6rbCpR2nos1q09qnEW1rgT1n9CIcPeYsPPzpn5GVlA+zIQMaaKBXS/hww3O9khF1BqUSMB0j8XpbNjWKs+ms2HCAgQtd5yRNg/woFRvKkUJ9j7rxs3Q9ht72qeade08LjDnWbrEhUumuvXdft4I2Vks3QQAdj6NKFs2BVvgkP8OAwuTJZEcaSJiSQ7WJ9+mJaynZpnQ0BFpYNYd9rrA2Okyw/QUFLlBOWVxYkdrwvmCTTs9OG9WmRqpwpN0MMVSP9R4/dhjG9wgRrYai7oj0fB4/tEYt1CoV85811DQiHI7CkmGF7I1AbevZD9iRjKhu3t7iT3o8J92PWJfbmCk6J3MCCgtmoiHQyszEJg2dR2CtQ4QoEN7rwaEzD0GSwQZPKIDl21Twuns2mfb1PPDvf10IcDLq5/202HdAl9R7i/DN655hZERaz7mH344mbyMMKgHLVv8LFkMaTp72B3y67ik0uKt6JSNqkU2RVJR42ZdQIdQCSw4zzyVKXvE5iXjozZx8W7TJxB3m/kAAYSEKqZvcpq7r8Tf6EA5LoMbYciAKU5YFvnI3dGlGFjQQaPbDnu0Aq8cqAKo+tJSO81P7DHuyja2jdU8Lcsflgs5HOTZJObFkYmrgR+V76NppE6RIOwrgcPnccPm8rMp5ohpmrIOsgWm5xa5ylq/VX+lYRJeIiKo2dJeQ23X+At96jLCmIFVvRYOrFD8gGy3q/TfwjqbFoC8IQS2gdncNLMkWlnQcN3c2FTfAnGqBvofCqjMyJ2Bt/VZWh8/jrkLxjnfbl5SXPgYt7mp4Ay1Isxcgy1GIGmcpGtpMyOkZ45BdMJN1y6VrJM23vStv3HkkxjTKXEsG8o0F+G6nDl5PUvs5DFoBBalEcrGP6LAWr4JG9/5FiuMH0TsSFTOWFKDVt89JRZ/lJguISEBpg8x+dhUaQ8d7ggrCsVSvHsWkEzA8OxbAtKNahjvAHWL9/Xvo7jhORv1EUxCjsCRvgc5UB6WHStdxMirKmYrFs25CU6AFGimCZ76+HadMvhQrd3+A3W3OYrVKg8MnXwKtMYX5J+IihBWIVQochWloFps7RWqRCYq9lbb95ZJTf6RjMAvlPlAiovN118vH3+pD1d4apI3K6LHCQDQqoXFjDTIn5yIajAIiIGiIzGQKuYIUlqDVaEDFNqOhCNQGDYJNfnhbvUgtSkfdj5VQZxiQlOFAqCEEXZYeqraEW6oj5650wpaXhKDLD73NCEElQI7IUGvVEMKAXtTEqkWoBBj0eujVOua/IGxsWiuIzL/ftQ6RUBT2bBvDMNZvav8Ah66PA22c5Hvb46o44CK2HefqGE3Xq8+nm+dRo4QxKW00hml9aCh9Bx9rp+w3iq7ZpNbD3eBC9d5aFE0pYi8VZPHbTwPrxa80NW0MtrQUM5NgRzLSqHS4bdHr+GjjS/h+13s4edqV2FS1EdMHzcJr3y5BVAojKW000nOndxv83rimrWBuh9w1qh84KXUsPlgbhMuXwq6pIFWENbwby159jv3/3JwcnHr2xdhaq4XTR5GoYKTiDynQagTQu8zIbBEmdQAarR5rShRGXnSaaUVqVO74BjZHCgT7CGyvkqDTCCDlmL6nuSYOUiEa8MAVtWBdaRQWfYwIiZzop4qeqbZAQbtRQP22d5CZmQt12iTUu8lkG6vu3xeR9XOb+U0dxsnoIG+3Vu2GzlgPlbkBGq27EzHFyeiIsWeh0V2NLWUrMGfUWdCIAganj2Z29lp3Fb7e8AJUKg2OnXYFitLHtFeDpk3r/dc/xXEzj8Q3336P0884CbXBRrhkNwJSzPREb9fkQ2FdOvVJqAs0osbXkNBVxcPO44PjZqmOB7c0tsJkM8InB/eLTPPUeiBqBRgdJoR9VNGh55I6fS2IQojlUBSu6laY0y2IuMPw1nmhT9FDa9DCkGru0U9EWpwYBio2lmPo5CEQRbFTrbbxKSOwrakYYUQ7zUHYUefUrlUrOq6VyGhM8lDsbN3b7wrdNF+8DBD93lewQ3dY0TWenlUIbc2beDtaCI+qc/6Wr8YNo9GAlIzYpk5C2gnrMdUx74nKRhU3wZJnh6abig2kVZrVRmx3lsDlqmjXjCYMPgqTio5BIOjCyyvugE5rwdi8GRiaPRWvfXsPJDkCRxsZdV0/5XYFyl0wDto/KnNcylBk6/JR3iIgGFLDbtCiavtqNDU0YPrMOViz5nN8v2IV/rbkEdQ3NqGxvhYpaRkw29LgaqkDJB/0YgTvvPseRoydjqHjZ2PVrig0agEzioC/XHMOxo6fjHN+dx1a/QoCzXsgqtTwetwYM3IIdpdU4OXnH8UV19wMqy0Z5WUliEYjSM8pgk6rhtfVDLebIh4VDBs2DBWlJTDbU2AwWlBdWYaA34fs/EHYUqNHvUtmrWa49A8BTkb9w22/owQxArXaB4O5Clp7Oft+n5mO2n1LUBQZYpvTPh7ezSLfqEo3tR8fswhGcwbzp+gokVOlxZo312DC5AnYtG47Lv/9YhYa7gsHUBmoYRtGkS0fKXo7S6ZcXbcJgWigzyKX8c2R8p0o4IIa4pEW05WMgp4gPC4v0nLS2ltd+50+OIubkDY2C3JIhtqgguoA/DAHAjdVgtCaddBaEst1Il8UXUP5pnLYk61IzY+Zs/IsWdiyfhfMg4yssnpHIRKMldfp3gRH4diUeLzbVdp7e/UeLowInyo80P2kt+h4pe1E6th1nfKk9ELY3SvRWvcdVhhmokVMR8PmWmSMz4YckWA3W6Btq/DAqjKE/cx/11VI26RdU4nKUBs7v0BQGaqhjkKsqdvUTkZqlRbnH/ZX6PQ2pBhTWSXxQMgNuyEZM0efhmUr70NECnVPRjIQcvqhS+4+AGZO9mQUt1bAG/Gx5z3LlIb6TZUIBsI4Yd48VDVU4Y8X/BH//NfDuGvJXZh38iJ89N5ruOUvt+G1V15BOOzF9EOm45sVKzBo6EQcdvwZ+G5XFOlWEWj6Ad+u+BSRUAiX/+lW6A1GXHnRfBxxzHy4XPXIy86EzZGON994FX++6UaUFBdjd2klrGYbAgE/Fi2cjzvuuA3TDj0SG9evxnnnnIMN69dh6IhRcLs8WPndSgwdMRprV3+Ny274J1YVA4EwZ6MD+Rvv9OJ37wdBjl5/0evlOIvQjPrAZiiIGarVGjfMjkpoVOS817G37FhEFhgRUESW1ZoHtWiDLGugVonQq9XQkxmuTsLw/BEwWQ3wREJolNyw60yw67Uo8VSy8jdpxmRmooslJfZcHy2+5GT9vjdrOj81VKONkt7gKWSaVhYORlCxswKDxhaioaIBUbUMg9kEWUcmjH7GbR8A1pTjpDZoWfHWRIV129UaIUsyM8uZzSZQodP163bCWtRz9XC6dvIJkflODknw1rhgLUiCyqdAp9VBb9Gx2nvdhZp3tzZ6OaDNVSNSi499WMX6PXkSemHoOu8R6SMhVb4CvXkClKYf4FZHsTmYjagjEyGo29qFiNC3PV99+aRaSppYlCS1tqfrpwALKpS6qm4jKx8VN9PZjCk4aerl+LHkcxSmjWHN/9SigHJXFfKt2XhrzcPMTNedZhT1RxCq98NUuH8lDtLoj86dgfdKlzMtjjArtGSjdWs9vvjoCwwZNgRlJaWYfeRhqK2shtkxGLMOPxZrVy9H2FuPXdu3YfYxp2LcuPF445UXMW32XDRE0rG3XsaMIQKe+deNmHfKImzfugEarQ5nnb0YZy88Gg89uRQ6oxWvPXUf/nDVDbjn7r/hllv+irvuvAOLzrsUOqMFd950Oe7/53147qVXcc5FV+KzD99Cik2D2ppajBo3Ciu/WYWTz/wDDEYT7rr5ciw8+2LUCqPh4X6kRP9U93+h52TUb+wO6MAMRxTjhtRDo46FKMfaYTcxP0ooYIHTqUYglAZF0rJumopI9mgZGlUEyWYtChwiKptlNAeAsER9jmQIIhme6M1Xgl7XiGSrBUWpCja0bO+zbE1HMqILIUIi3wJtlvQmTxsFbRDOxlY4km3we4MwmPXwSRReHDmga+/vYHrbp2Z/XbWZvuYjbYaKym77bhtmHXoIc6TXR1t6DDOPz1e6vQxJOUkIKVGE6HqTjAi1BmHWmZjJpqG2CZdhQYYAACAASURBVKZsS6/FX8lPY9TooBFi5NBV+qsZUZHbIUIOSn0bIUgCpksbMThnBEIqGzwtm7EbqSjTD2MhJgfSX6nImocMU2p7sMrW5t3tBW/jZESaEaUjOL31rD26zZiKQNgDuyUTre5aeIJOdpndkZEaIouso/vYVYbY81mkY8dmgQWWLHi3N6GhvhHTZ01Hui0VSXYHHn74UeQPGYZJU47D5rWr4WqqwJ5d23HI3FORUTgOKz54ETMPPwp1oXRGCEW2Bjxy/20YPXYSgsEA1q5egaeffwlnn7GAkZHJbMXzj92HK6+5Af+4+2+4+Za/YsmSO3HGuZdBZ7Dgtj//Hg/c/wBeePlVnHVBd2T0HU49+3JodCbc+/c/4YSFZ6FBNZ6TUV9/nL18z810BwFeooeSk3X20Cg+eedFbNzwAxxJSTj93NOhtRWgpiWJ2ZmjEjlmFbaBkXPWoGMxwyyaiKJ4SMiBq9cIIEsT9asjp2lYUqBWUQIi7ZEK8tJ8UBkr0RR0gfr0+KIBtIb3L1HTlYxofiIZMldRjyV6q3fVt7JeOSl5qe2XGu+hk+i1dx0XS5aMNQWkpFQqwEmbZ3c13zx1bhZxZ0nvu95aPPcn5ikR4NCZGbFS9YTt326HJkuHlKxUhIMh5oMiv1JcwsEw1DoNJElieWOkJXY0b5Hpj/BorG6M9Q5KM4B6Ilmz7dBoVAgFIjAlmyBIgEmlh96k77H9RlfzGZnKqNYQmWuj/jAzSRIBRrxhGDPMqF5TAUOGCfZMO7KiKaiztLK10wtNttSIUeGtSEqdCFWoCV9gKEJizBwWlsLwR8P7lRDqeD+yVSko3VUOXZGJrYGIlO5HXHzeelSUft3pFhIW5MvsTkO0JRUhKWNs+3glIsO3uQn2yRmIUjBLm7BySbKMSemjsKm5uNMa8y2ZCOxyIhQMI3VCFkrdNRhqz4fJqcZjjzyORWedi1effQFXXfdHLHvjTcw9cS5yCobhg6UfIj09C3OPO4SZxLet3Y765hZMPfREEMSvPXc/5h5+GO6++w784+GXYDJZ8PLTD+LSK67BHX+/BZf94XL8uGYV3IEIHHYHtm/biksuWoyXX1vKtKUvP3kPKTY16urqWFuZ+vpGlJSWY/iosVj26jP4y12PYWWxigUzcOkfApyM+ofbAR3lMAlIk7ZgxZcf4YJLrkJTUwOWvvQ0bvnbnVjxzUqU7tmNQ+ccAZtZj8rqBhQOH4fKvTuQbLdAo9Pjs48/RHJKCo48eh5Kdu+A2+PB7p3bMHbCFIwdOxbvvLUURqMZLS2NOOaEk5CbrsOXX36B4j0lmDl3JsI2CeVdWh90R0Z0UWTaidfMC3lDLHGyYx23gyUjiviiyK+OGxNLFpYldm6i3VhnWxWoS6wgipBUco/aGFXr1rR1rCVzGBEbbah0PJkbzWoTtEE1qwzgsDrgrmtFcloS/P4wyivKkDcyDxU7qpAzIovVuCPpWnmbkjvJfElCWw2RVSgUjkX1RSVInijsKTbWD4oUVWuaFa1lTkwYO5YRB0VRUtkcCpUn0qzYU4WQy4/koemo31nLtDFBr0LIGYQpw8JaXJDTX2vt7CublTUZq+s2sMRW0vZYeSkliqFN72CQIx9fiKMREveZIntra0EJvYMNuVhTtokRaSJC56PIwo1NuxKKLJQCEWijKoh2LWuRQSQktyXtatV6jEsdho2NOzqZLDONKSjSZrMXiUq5ERWeOma+G5s8BFJTCDWVtcjPy0PhoAKUl1Yw3JtlN8whPXbu3IXx08ezSMBIawgWkxmKOgU1TUZYVK2wamWUVlQhq2A09Do1aqsrkJmVh+Ld22C3WpCRkYENGzeyTs6FQ8fBatShoaEeSWnZcDsbYTEICIfDUGktEDUG7N29FX6fB0NHjEGZy8rCx3n5o0SepO7HcDLqP3YJH2kzChjhqMUDS27Gyaeeh1FjJyAzLQm7tm3EsqXLcPwpp2HJX6/Fw48+iT/fcB0efe5N3HjVhbjxpltw3z/uxtkXXYmP31uK2bNnobq6Grt27cSJp56FR+67Hc+++CqOPXImbrztXhQXb8XgnFzWFHDdutWYftgUvPrca7jy1iuxzrm9fb0UAk5+ld6E+v74nF5YU/fZ+rtWBU8YgLaBZLqi8/bVtC8+byQYZYmqWouG5eV01Z5YCwsdRdn17L8ih36RNR8bKraiyFzAfHaRcARpWWnY1lLcbWsN8pdQ3be4dK2eQIRHOV9ECOSf6a7WYI42BzvXbkJDbQNOPv1kfF++ASXr9kAlC0idntNtodbe8KQNeVbmZGxp3rUfDkXeNRimk7HWMAetMliOUByrjk34Os5PPZ/I1+gMuBENRRMqrko4kP+NAmfa84d6WDSZFUklsVkszA9HWrcUpZcNATa9FRPSRmCvuwpV3ljX2o4STw7uWCqJcuBSDEnQi1oEZKpU7gM1RYy10gixZGgqt0T3hawBVCGdXnLofEON47GpxIZQKAKDkQJJBISiUUiyCi4/kGETQYpyi1eG3Ujt6MkKIZPyxqwSFOZN+U8UCt7+QhJUkGaNjaUoPR93vR/odrDfeE5GBw1h3xMQGc0ZoUZzYw02rfsBu3duweBBg3DsccfhpZdehsliwWcfLsO//+9p3HnH33HSgrPwztKX8e//exzvvPce6mvrUFtVgaFDixCORJBTMARTZxyOO26+An/5621YdOpJeP2DlaiuLMWODd/gyGNOwTtvvQ6jWYNNGzbhshsvwSZvrDssK8iqNfZZMby2vA5GkwG2lA5k1KYV9OUY7wkR2iC61pPrDT2fywd/cwgpgxzdJomSGdKm21fVoLu56Honpo3G+rqtGGTOxzWLr8DWzVvx4+61sU6wUoRpViT0O0UWBiIhVlk9hhegVWtYlB5VqzaySuwi+z3uO4u1sqD2EwLT7ujNvMiSj2svugZNdY147IXH0WggU6kMf5MfKqsGISHMiJA0LTK5mTRGqFhLeRleKq3T5WJIM5uQOpL5Xyg0nFplkLmMZEhgK4aKzfh/9q4DPMoqa7/T+2RKeu8JvQVEBAUERFgXBBEssIuAoiKKKAqIIiiCdLGLKIqIXbEhotJ7Lymk955M7+V/zh0mhJCQoOiu++f6sCwzXz3fN/e955z3vKdONQU2nhg6twEl9nLGEmwJjOiclCckooe+sA7quMBWtQTJM0oMiEamLr/VGi1bjRlweSELU/qaB7qc8Ho86Bveg5F1KizVvoaPjRimzT4/L0kvUViaz2zD5Jg4HKYM0tYRLNGi9KAeclkATFYdut4YBxU/CDvPV8CkS2XPkwgZLnfLhbVtPVf7dr/fAu1g9Ptt1+Y9qe0Eao/B43ajW6++cDmdmHX/eAweNhwSuQrDRt6BZx6fhvkLl6CithZvrn4J/7p/JpJiIzH3ySew8s1N2L97O3TV5QyMouKS0Pv6QXhx/kzMW/AcA6NPv9/H6h7Sj+9Eba0ekXHxuHP0LXhx2UsYO3lcAxg1VgJo6Qb8P/jmvm/af6etRmgrCDY9nr8+s7lJlSZ/UpJubaSqE1FhqWItEB6c8ADOMTA6xlQtlDyZb6L0eiEQCFBirYRKqIDAw/N5cBywDrnEqOPz+SxM4/V4WcFtjrGQESXildFw2h1sYhXwBTC4TcxbEnj5sFisCNJomQpEjMxHwSaQoKJeOleJuQK9AjuB5+Gy41JYzwI7ztSdvyQ06W/MR9cUIg5EtDKMQSUl/2W1vyKJU4061X3w8JSweK04Y85kZvGxBJuneDe2G4EStxnduvqiOpazY+FaDhfRojDkWoqZKLCHzNMCq9JF4SwqdKbQKek1ejxMQPi2+Jvxdf4v7NRu6m7r9UIqkjZ0rW18TeR5+kPGTVuUEMnmakb9b+W45+4JeHvDBkTemoD+YT0hF8oYWLMaN68HNTopjpWVwOsUwmaMgtvbdsC7mmtp37Z5C7SD0V/wZmjlHKRqavDdlx9BJBLDZrUgPCIcHVI7YvPmDxATm4iTxw/jqQWLoQ2Owqol8/HIk8+xH/GrqxYjKCgEdbW1SE5KYoWN2rBodO3RF6+teB4zZs7EjOn3Y92Gz1BZXoKcc4cQHBqFb7d+iaSEWOQX52L6rAdwzJDB8jI0SVIynggEzYWXyBwV+RXQhGsgFF1exErewGXtxdtoQ/JkKF9EE0xbqOFOqwu6ah2CogN9zD4bUaIv+gx0DAKO1sJ+YbIgRJAWIE+ACWPuQsaZczidewa5OblYvXQNMs6lM5Dp1rM75i+ax7yFxx9+HAKhgJ2tKK8A8cmJ6Ne/P7798hsYjQYMGjYICxYtQE1tDdatXIcjB47AZDAiKTkJM+bMRK+ePfDw1BmwmM1YtnoZOEIeXlv9Kvbs2A1SrOjQMRUPPzkDyR2SseGNDfj+6++hr9chKCQYd0++G32H34BTtZkNd+vT5ZM2eGxkcrIjibgmCpyQ6g/CJOwNPS8cmbZc2NwXw4xkM3puFM5qrr6JPJai3bmIvD7uMnmmmtxqKIIVMFTooY0NgriOC4vSCX2VHh6eF7LQyxcD1gojy3spYomc4/GF5zgcpGoTWJ1cZn3BhdwRoBRJ4SJFjGYYmvSe0vY06NobswQlPGGrz73xa1l5pgwKngwGrxmhnZpXoU9Vx7E8nNvtgccSh/1Zvtb07eOvsUA7GP01dkZ8MBedo6iXke+Edhdgd5Km1sULoFpEq8P3mc0BZJR50C3m4j4Ut6aFKFFXXR6SKfFCIeZCb/WwY4nZ9z5VaWpHHaH2oMZezWLne8uON8usotUusdt8f1MLb7ouBwtNNTfJkwdRZ7+0B8/vNSEdnwCK/tCJfUreF1ejdosTVTnViOoafhmpgM7J8g9CWQPxoLnrkPGl6BHcEQX6EpDg7J2jx7MwXVZeBubPW4CvP/8aL72yHDJ5AB6adB/G3XMnpk69D3ePuwdcHg+z5j6OEydP4bP3P0ZEdCQen/84PnjnA5w6ehI7j+/GT19vw0uLlmDmnEcx8JZBmHT7RISGhuCbbV/jjtvGwWQ04cPNG/HV1q1Y+/IaTH14KtQaLZYvXoZx4+/AnDlz0LtXH4wYdRumPjoFU+6YjAC1Cq9tfA3pzoLLiBtkH59+oG+SjhCFIpHrhYxXCos7FNleHkptl+dh/BM6ebbNDcoRkqxU9g/pUAUHQBWlRsnxYoRfFw1JoAxemxs8iQAd1PE4WZPZkDMynq8jqXAoYnzhXHo/zOVGSLQScIU8BkQ0OgYlMVmmX0sOsXAdPW8KhQaIZTDbqb7r0uJcfw8wAs/mAFR8hcXU730fG+/XWZuEspJUFFWaYfO0XJ92Lc7VfgyfBdrB6C98EygZSmIFFA3pEgW4HRbGzDlZ6GY0baJ2uz1g9G2pCIjUcFnHWZIZKav3IlLDgVbBhdMFZJa52bZsAiAqr9PLdLeIzUO5Y2rQeks3Dg7W/AK7x9EmUU5ipjlr7ZAopBC30OG1OQ+lORMSSYKAk9G2KQxC/7VRK8XfnoGpBDi8kEiJTuwLgzUdvu6ssmYpDEQuoNAcKzR1GJCiisfEsfcyMMopzEZ5TRX27N6LmqoaxqB6e91buOnmmzBr9mMMjJI7pGD5G8uReTYTD//rIdxz3yQ88Ng0bH5vM9YuXYONn25EaqdUHNx/CAX5BXA6nfj8o89Z6OnnvT/jzn/eCZPJhE2bP8BjMx9HWVk5ftj1A7PF5vc/QXx8DIYNHoLdh/chOz0bFqsZX27+goHCm5veQqanqFkWoV/AVSGUo7MkBUpHBiTOs7Cph+JE5SHUCyiEd+lorflf460ppFZxvAThadGXHIQ86RRVLI5VZ1z83OOFucrE2lM4WNsQPvOGeBLfooKePYH6qPib8WPRnkso4SJiOwolTMG7OaWIK/006bmrxQqYHKQ4cu3p1L4C3ChoxAHIyQ1CVtXVhQX/wmnlf+ZU7WD0H3iUBBq9Qivx49bPMW7STOw77wbJhNmcXph9OWl0j+Gh6PQ22O02dO9/O47mudA/yYFN76zB4OH/RC23QwMY6S1eJohJ9UYkVmB1+oQku8dwERCUgXN1OW2+y8Ktheg6tiP4TRrXsZWLj3jdIA3U0kEp1EEsNx9QNpoovFRc62Y9eZjSQRNw8TdsY7RurxdWpw2Fh/IQe33CFa9fLVJcFnKkibOjJhEOow1uB9mByBMCTBxzL86dOYesvEysWr0GG97agK7de6BT1xRs+fATDBoyEE88ORvjx05oAKOscwRGD2PStEmYMmNqAxht/nwzikqLsfCp5xAdH4Pe1/fG9u9+Yp7a9r3bMf6f4xvAaPoDD7NQ4JZvtzDiAcclglwqgNNsx/ChI+BxeTH8tlvwy087WO7qSmDkexZAgEiBWEkkEjzVkJp+BUivkKfCYV4nOHmXsiWJcGFyNu8VNWdcopYTdb3xYKKx2iQcrjxz2S6U79KdrYLX6oYkUQmRSsw04Ng74PFgWMwN+Ln4wGX7MTFXeC+pQ2rLy0pgFCxVs7q4P7MImzzQgaFDsfWIoF3qpy0P5g9s0w5Gf8B4v3dXAqOewRX49svNrAI8r6AExQU5iIiOhVsSjdNFbnSO5OHwT+vxwzefYc27X8LkksFUfhrLFs3BzNnz0LXXAORknYPFbEJq567g8fgoLsyF0+FCYmoX7DjrYeA2sEsl6lDUJvFUksHhiniMqUQhO2ryRpO6P1xHcX0K8/hBhCYnYplR/olCgQQgBDYU628pH9XYZlQPRG0eKC9AP/qm+xCQleWUQRx5kTHna2jno9T6c2AERk0HXXMXTQoWPPYsfvlpO97ZtB4BajUemjwdCoUS333/NaZNmY5jR4/iwy82M5WHiWPvxo2Db2wzGH302Uf4/ocfsPm9j7D8zZXo0CkVM/71MGxW20UwuhCmW7PmFWz77ids+OQ9lvd7ddU6dO3SFVExMZj18KNYsmYpuqd1wyOTZ8BmszEwOu8taZZ67r9Xf48kJV+OAYYv4a09CHfM3cjwRsMgCLzAEvQy9h2RGLiUs7uQa5EKJBByBLB77Cg0ll8yodvrreAJeeDLLs8ZEsAfrTrX7KtPoEPgTw38xHIJuIyh5mZ07LTQzthbfnnXYXqe9OxbEqtlBbLEoGtUpEwnp/sIkqigt/vEglvLG/7e3yrtFyKMAMfcHWeL/8hR2vdtzQLtYNSahf6E7/1gtP3bjzFt6jSsWvsKbhx0K3789nPMeXYZdme6EKXh4vgv76OqohSJKV0w5NbR+HzLehzetxvTpk5BSVk5iorKERIeiaMHd2P2k09h8r3jMeXBxzFkxO0MjKgaXBWYjUGpCpSba1hdib9H0eVLW6A2pxqaxMCGH7Zf1YDCd8TyopYLjclTPiLE71fqbotpqbhUZ9SDLxey3kTEyOJeCMoZnGbmrTXtoOo/brIqHif2ncD8x+aCz+cyNpzJZMaT8+di4r3jMX/+Qnz96efQBgWCcia6+nr06pOGl5cvxZ1jxyMpNZmF6a7kGWWmZ2LRs4ug0qjB5/NQV1PPbHTq/CkWpjMYDXjvo/dQq6vDw/c9zGqcaDuD3oD5i57BkMGDMXTgMIjEIgiFQtTX1UOlVuGdLetRIdKhzqZv0UyNG/aNtGyHwSuCUsCF1a2EJXIStv30EwRCITr378ao4EFcNbZv/Qmx0TEYfNNAzHlyLibNmAy7wnVJUbRVZ2FsQUETEVW6kCuBEX3vMjgQiUB06pjKrpvo20WGcsQGROJEjY/h13gQZZs1BGzGa/N43IyBSgst8q8bq2YohVL2PlCdFD3XP3MQWPYMTMPPR4JYCLx9/DkWaAejP8euVzyqH4x+2voxZs2ahd/2HoXFYsa2b7/A8y+/jr2ZLkRouNj//ZsYMPAW1ttl8vTH8NbaZYzhNvLWYQiLSsK5jAxGmV23fCHe/WALFj47H8+t2IiSOi+yyshT8V2GWFaL1AgHIgK40HvqUGAoYTmYxoP1+NHbWmy6xo7DE0EmaJ5hJBfILsjEtNKh7CrtbXfYkXeuAMEdfGrmVNjoH361BSJgNDfIw4tTxCD7TBaOHzgBi8WEnn16o+cN3VHr0CEAcmz98nvUllWiV//eTO7HZDBg4j33YvOWj6EKVOGmWwfCUGPAj1//iC5pXdC1Z1dknk7Hwb2HMGrcKGi0Gvz8w8/IPJeFhKQ4yKQyFOQXYvJ9/8b33/0Am92GkaNHwiXyojyvDL98t4NNsH1u7IvUXh1YTuX8yUzs/WUPQqPCEBYWirzzebh9/O0o8lSyDrMtDfIoiU1IY6R1B/K8ami8TgR4ylEePAuTJz0ERYASK99dBbfdheXPL8fhA4fx0ool6NmrJx6ePoMRKjSJwQ2eM4XNCOutDjusHivzdn20chFbpFCd0bnaHBZmJcFX6i7LvC0izXjdjBXXRZuEvd/sxPnz5zFj7iMoNVWxOipaDBFpwc/uowLVIImaaSEaHT7VdNY51utmtHvyfCn/xPSyqKtsozb1KqGM1YOR/f5sMKLrCpSoEcvvj+1nfMWw7ePaW6AdjK69TVs9oh+Mfv72Y0yaNAkbNn6EW267A598+A5mPb34EjAaOuJ2/LptK5MQSk7phJzsDAwd3B8H9h9EYueeiEvowGqWCIwWL3wWDz37Lo7nuy9L6XI4HggFNsQHGxAUbEa67tJVak16BTQpwc3WmvhvqKkSAX1OnlGqOoGFSqgPTrG5HBXm6muaVLZabbByHCycoxQRWaF5xQWamAhk3R435BcUJmjyUwjkiFGEM0ke+qN3GFmtD117+clKdO6bykKPftYWTYhEMnC4XKix1YEYecT4o89oAqVqfxq+jq0maMQqqEQKtr+/IJi8N1oLsIJPpvlnYfspRL596d/nsrIg4HARHhvBQNa3P9U8gZ2rylJ3RW05soJarGT2GOnYi2yrA3ZhCDor5Ci2BuG+GesQEBCANza+gXff2oCP3t2E515eiB7X92AAcubUWSQkJbAaqpzcXNYLSV9nQH1NHcJjE2GXGJmSebwiEgXZhbDb7OjasROy83MRFBmMeq8RoSIt8jLyYLVakdw9BQqJHKVFpVi/5h3k5eTh+ZXPMxZikEKDSl01zpw6B6VCgfgO8cgzlrDnUllSydTVCTAJyBM7JsIudONEdSY8pJTgdIEr8nnnvgJhEVuE2Z1O32dN2oK0+gP8nRt01qSgsDAZ+dXtaPQ7TXjF3drB6M+waivH9BEYqrBz2xe45+67sGrtq+iRdh22fr4Fi1a8gfQKETQyDo7+/B4GDR2JspJivL7mRax9+2Ns2vA6Bt3YF8dPnITDxYVYIsYPX3+Kta+9hRXLX8bkJ15pFoz8l0TU8v6pXOj5h1Fq9lGAqa6m6GA+Ym+4MlGgcb8jYsvRJBwi0aLQVAad3cBWzsRAonxEpaUa9XZ9m1suXMlkujo9HDw3awZHVO6W8lEERP7W4Cqh/BLKNzUfpP2qrLWXnMpqs0Es9knENB1+2Z+2tI1o3DyvtVeKAEpvN6OupAYStQzCZsJhrR3D/z2FuUj9YYTzAPik2W0tAyd8JCrNMtz7wMuQyeUYNXYUli1ahvsfnobbJo5GgbEMcZIwjB0yFi+sfgHBgcGYcvcUxCTEwWaxoq6mFmFR4Vj37iusOPf1pa9h+08/QxOogVgoQl5uPla+ugJd0rpi/uPzUVxQzBYxunodXlq5BL/9/Bu2/7gdtIjo1LUTXliyiPX/eWr20wxkLWYLIsLC8ezy5xAeEYZp99zP3uPaqlroDaSUIMeKN1eiVmxETlkBvA4PBGoRZGIJU2IgFQqzzcqeGQFR4/BdW+32e7ajhU2qZAB2nrmylNbvOXb7Pu3U7v/IOyDgAUM6eWEx1CMsLAi5eUUwmfRM7DQ0LBInivkgCaFgUS2UShXsTjeMuhom2KirrUSAUgYOh4/8vGzWT4WKYzskxSKnsAJWYRTOFPl6KLU0iF4+uKsNWeaDbKVPky6HIiGNWkI33bexWKhKpESMIoJJutTadJcoPdN+tC0BVbg0iNWktJinaqP1TfVmuDhueMRg+SHKlTQ3yLuptxvZV+RpUFjPP6glRoQsFDn6gkt2JRZYeXYFwpPDmpXD8fd6aq0ZHgEdXZu//udKt0a6dyQFdK0GnVvjrEIipxZKZw3CooagzBqJf0+ZharqOhbGEovFeP3D11GMakYq6KSMvwyMho4Yion3T8TRA8eweskqrHt7HcxGE+Y+MQ8znpyBfjf1w7ZvtmHjm+/jzTdfB1cuwPR/T8c7m9+BVCHFW6veQkx8DCbcdSfWrlmHk0dPYd2GVxAaGIIJo+9CQmoipj0yleXFHp38KEaO+QeefXYe7h4/EYoABR59+lGY9EY8cM90vLh2CbSdQ5Cel8NycBKtFEp616nOzaxjZAzy1BuH6Pw5zuZKAK6VrRMDYqGr7ILMsnbv6FrZ1H+cds/oWlu0jceTUs0RD4xkQMBDtGyHy8vi0SS8SEMl5bCEKWlmUe0RbUuFr/QttZyg76nWiPbzD5Pdy75rbWjkHHRLKcKpqpOoza5BUEdfV9TmBnlBtPL3M5ZS1fEoMpbD4mq+O6r/GCHSIJbToC6pTGKIha6uviaEtVdwuGH0Wth1NM4R+T0aEswkRXH/aEr3pu2SVLEsz1BqqbiEVl5TWgNtuLZFRhZNbm1prEehPMqhXEldgo6lv9A3quJkCUK7R7b2qK7q+zhnPgaExKHKHoaJ0xaiIK8QsQmxKCkswcOzZ+DmMUORpy9CsjyGgdHi1YsREhjCPKPJ0yej7239UZ9bjbmPzsWy1Utx/OhxfL/1B6xevwbVEj1s6Xo8+/gCvPHma+jRqwdG/XMMhCIRbvnHMPTs2xPR8dGQi2VYu/wVHD5wBO9s3gBddTXG3zYBi5Yugjpai6CoYKxbsIZ5SOvffRt333UvEjonYeKUf7OF1i29h2Hh8ucR2D0cuZUFgIQLr00TNAAAIABJREFUsVDM1BqMNgssDit7B+gzGhSyoz8BYrkvTNtMPdpVGfEKG9NiY3j0YHxxQAxTuzjqtTIrO047GF1Tc/59DkZOUFqCF17paZyvymuWOUV3Q14OtX1oTJ3tEdQJp2oymi1CbWoB0m2j/kgUBKP6oixd3lUbye3yIP9sAWK6RjMtuMaMPlaP5LIz4VI/zDWX26KTEkhEysMAL4e1lGg8airrWKvylpLhLQmONr0ZIk1QmLIlD4kmSkrO07Xa9FaIA65tdb/YbUI3VzbUqqGYdP9itghY8eYKvP/OR9i1YxdWvr0SmuggSL1CHxitWoyQoItglDa8L/QFtZg/az4Do2NHjuPHb3/E6nfXoFJUD3uGgYEReUY33HQDCgsKsWf/fuzdvw/HDhzF2HvHYtoDU7F2xSs4fvg41n+6HoXnCzF5/GQ8s2QBwpIjmGL62mdWMy/ovffXY8KEe9C5W2fc9fC9cFk5GDfoNgZGIWmRyKrNZ6E4EWvdzofeamLvnUQoZtR1AiHqQyUUCFjejhYkfyYY0fMmVfEgzwAcyuay/F77uDYWaAeja2PHv+VR+AIruirSoQ8xswnysomVsdckl+RTyMPoFdwZR6suL3xszgi+OhIeXF4XEgNi2Mq1xFR+1fYy1hgg0VCIjmi8vhmAvCyafBrndAg0SR1cwZfDCSdr++1TqHaz6xBxheigTUChvgwllnI2WdPRqsur4ba4EBIfcklO6ko9ga50E9QvqLl6K58ahImd1+1ws3qeP2N0FkVh7gNzoQmQYvX6lajS2fHEA0/A5XThrU1vMt290TePvgSM7p48Cb1uToNbb8NTM57C0tVLYbKasHjuYsx7YT7S+vbC9u+247XlrzIwyq8oxpEDx/DUvNlw8JyYOXkmFEoFVr26kjXCO7DnAN7+6G1oFWoMvWk4Bt58I6Y9ej/MJjPuHXUvRoweiYXPLcCEO+9GSlIy7p/3IFv0DO/p84wIjLLri5iCA4WRwQgepK/Ig0QoYs+VCokpZyQTSVhotvYKVPhraeeu6m44dDayoUj9Wh77/+ux2sHo/+uTv3DfwZLTSEjlIltf2GAJAhDKt/g8mksT+8RMC5cF/y4PhyYPYt6RAkGZuYq1WmhpBAgVMDkvrnIdTgdqK3VQhihYoS1NWn4iQOOclFasQpI0FgFcJRw8OzgkkUSSNS4LowwTIJGqm5dD8ksOFJsqGoCN+ifxhL7iW1pdE3ASu80vY0Sfk3fVFkKDzxPjsgJiEoele/cx61wwuaxwO92oO1+FwI6hf8ob2EEch3kPPAWtSonFr85BnZuP/KM5WDj7OUy871489NCDGDTg5ksIDP4wXV1OFeY9Ng8vrHoB3Xt1x7IFS3H06DFEREVAX6dHeWkZA6PE1EQ8/OAjrMiVSg6y0rPw4OyHMOr227Bt23a233X9+mDRcwtxNPMUVi1eAW2QFnqdHmKBCM8tW4jU1BRMmvAvJCWk4MEFD7I80M3dB+OZpQsQ2TcOOfoS9g6KSSuRdBNJARxekDadkwQcqb2ESMTydfRsdHYTsyd5TH5iA3lO9L5cS6IDqV90kg3Ad8d8Elzt449boB2M/rgN/9ZHkImAtM45OK/P9dV1wAta1dMqU8ITw+FxsM/8EzABEQ0Ck9871GIVqk6WI/30eSR1SUbf63pA4BUgy5YLEU/EBE1p0qbQWGZ9DgMGApL0XecQ2TeWFb5S6LCpZ0S1MAmKaMRJIiEXSxjgWMw21oDNDTeEXl+BbpmrEpWOaiQGRKHOUo5qmwFujgBVRdVMyFYTqW3I6/h14KgPkx+YKX90tRI0lOMgGzZOrhN54kqkkd9rX9qvV2BHVBdWQsNzo1NwLXYZTAgPGYCqgnK4HE707XkdDhw7hMjYSBbyysw6j+CQIFQYqxGhjkJFaTFi42IRERgOp82OzKws6A1G1FZWY/HzL+Kt9W+wWiUeV4CDhw7CZDSiU49OcEo8yNYVoqM6ARmnM+GyOtC373WoddUDdi9OHjkNrVqNbr2oEFcHtSgAubl5jCmnDFEx0M48nYGoqChUcOuQXVfEGH2UL6JhsltZTywqHnY6HBBLSenBt4AgwLI47Sxs17j+qOm/W7Or/zm3lt/srElCeVkqstrJDK2ZtE3ft4NRm8z0v7sRj+tFp4QiaFR2VktDYQ4+l8vYctRemyROKTZPeZlSUwUTGy0ylsHaqEXB77FO5tZM/Pu+CXjr9Q/w6Iz74eV4UeOsYzVAVLVP3lOIJBDUHp06gtK/SY3BznGykBuF4kgDzs9MI4YdbZ+iiIdWEgCb1QHKNfmH0+tkhZMC8GHwmJBlzUWIJR09PEWotxtwQD2GrXB1VToogpWsmR+NpoQJn8fDQ/UVilHbag9jmR5WoxXBKdfeOyIiBVG+uzgyEaFNRGXJdhwX9wZHFMQ8DAp3khwTI8N4XL5iVK8HlfXVCFYHsnskD7SDIh6zZ85Gt+7dERoajC2bP4XD4cb7H7wDPkcEqUIEF8nNs95JHuQbS5BuzGULGmpv0TUwGaeqM5GjK0KgVA2fgC51TeXB4rQyr5Hr4aA0sxTqBA04fAIWCl16UaWrQWVuJYJSQ8Dn8VghLntIHhIU9oAv4DMdP7oJqkWiom2hWtwARKyX0oUK1cZeUWOvqblnRc9cKVCgzHLlBRfZMVV0C/Zm+BQi2scfs0A7GP0x+/1P7C1RFkAWeI6tLhNV0YhXROFUbUbD6p9Wih00CSxcRRPU6ZoslgP6I+P86RzUHKtC/wGD0at7CvLtJahxXloD5AMDGVtln6zJQHFxKQQiIbxyCiMKGVD4+ytRk71oSThixdTSm8vAqPEoc1ah0lUNGU+KCEEI0i3ZiK77GZ00EQBfiprCH1CQ+AzqbQZWRyMJ8+nhUbI6RhHJuuOSHFKRsRQEbKQGThNphbmmTV4iqRgkq2Ib8lE0IdLETefzi5L+GfpqgfZSjAgNBYcvh6f4CxyrN6Bc0Q06eeqFCfRiGNZQqoNQKYJY4SNV0LMeGNEH50+fx/MLF6GooAiDhg7GkiXLwIELDqsLUlJUtzkYAPhHkaMMGcYcDIvuz+630FCKs3XZlzwPAis6Pg1aXFChMukhEjWf/n9jW1BIsyarEurkQBaa89jc4Ip5EEp8DQ/JSyJgJ1ATh8igK6hjCwqPzYXarGqE94uBPqsaPD4fyg7aVgtlA0SkKiG+ULZwZWpqiuA27Mtqp3n/kbnAv287GF0LK/7Nj8HhOqAQl8ItdMLL9TIPScznQyKwQCCyg4gOXq6HMdFoQiXPpcJazcJnBjupGbQOTP5CVX+YilhxqZJEuOFCsb0cJreZ5XMoV0SrYBomh4XRx+kzqhE6X5kHg80ISKnttxNU2Mo6sRJI8sToIk2FTCJhzev8q3X/o8l2FsDoJFFNZ0O4TeC1oUP5B4iKHQGvrQoVdqAueCQyswugClOyTqwUruwiScTHH3yMsXfdCZ3QwLyIqnOl2LdzHyY+9m8mc0Mrfhp+0U6728HsSPdkcBgRrYhA9p5zqK6qYWEnWt2T1BCFotxWN+rzaqFMUrPVPoWqaD9fuw4DCzM2NwjglDw5quy1LTLI4rg2DFDyAEMWIAoEvA5qXQuv24ZytxBGpx2VkKNGkgKb3ga3CPA3OE2Wh6KzNBQ8iRrgiVj4a+dvO3Hg0FEU5eeisroK48begdGjxl5Giyfgd/EoP2ZBrr55hVF/obDDYkdJejHCOkfC4rGxe2msqkDAbak1weNww2a0MvKFUCUi9w7OOjvcHA+U4SqfiTxeOPR2CANE4Asv7cnFSCMuNwz59axfEyk+UBhXGR5wyfXTwsbfQp6KqFti51EtXaywD349TSHYv/kk8F9w+e1g9F/wEP5bL8HXqI9aYXshFzigDKxG/3gt3CYn9h/eiw7dOkOuluBck1Vv0/sh7yZFHc8+zqrPZVI4BE5yvowBhD82Hx8QzaR3juw5hrDoEMTERjOiBBEdhFwhugWm4lzd+QvK4d5L6nnIe5PxZOgZ3AE2kxMcShg1GmdsWexfFpcv/OYfPI8NN+m+gjThX/AUfYbDgi7I44RgQHgafi09yDbrzI3DM7MW4PpB/XD75DGQcsVYt/w1/PbDDvy0/ycGQNnZ2YgKi4RWqUJZVSWUWiUDSYPOAKvIyfJFX7zyMaiwNKVjCs6dycC5U2cx9YH7UFVTjfLSctYbifTmaurrUF9TD7lMBpFWwlSyG3se/mvXilToo+gGJ8eFTFMuSq2VDbYkz4K8ut6SCASbd4DjMsAQMBbgCCA07IbIfAI8rxlQJMLLFWA3rzs8PDksRhNKyyuQlJyI/iFdAK4PUAn1K6oqMWXKVDz3wkKsenkl5j47D089/hTWv70BUsnlqgQKpRQ/luxmEkwtDQJeMV/I6r9cdhdM9SbIgxQNslQMQNw+78TlcjIAIZeuJqMK2gvyVXyxoCH3xnpnkbgq31cQ29TbpGP5gY5ydpYKI6ShCpTsy4emYzBkWjkLMfq9Nno3ScSVFhdNh1aiQoqiI345oWE1gO3jj1mgHYz+mP3+X+0dF8yFrWg3fv7xSwy4eQDSz5zETYMGoUffLjCYzHDanRAHiFnrCWpl4bC5IBQKoJDLcObYaRYeSenWgeUoDPVGyORS6D1GVFtroSTBzwoX3l73Dm4cMgAlBSWQyWWYOOUe1JkN4LqBAJkK5VXVkGvFEHHEEAp4qNHXs/wCh8NFlDaMASPR1DVCFVRcJTQ8FcxeK/LsRexZUT1SU0WIAHMGbrAfBTdqDHS5H2K3bDDST7oQ3S0WTqETnbix+OyjL1FWXIqnFz8Np9OOLe9/gm1f/4if9/6EFxa+hPjkOBzcfQAPPfIQVixdwajJx44eQ0VZBQbffQurRyEwGjFqBJI7pSDzbAZOHTiJobcOxcb3P0RcUhx01fWYNWsmxo2ZgBGjRyAzIwsTp9yLWrmZhYwumwxFKlyn6N7wsdFjxhH9KQb0pJIRKgxCKC8Qyup3IdQkQ2/Xwint1LB9ubsa7vpd6MyrhsNagXIEQq7PQKlgLJI73ACuh3I01OFVA7dXhIzM83j9zVdRWFyEndt3YOjIWxGgUGLl8pVQq1Xs+ZLcDzwclgOk8VPZHrb4aMsgIKnJroIiNABi5QVBXi81o+QyQovL5fIx6FgBNde34BD5WoqQHBENamNB3g95Rc3p1rHi68aFahcuzOPywGV2sB5OIoWY6Qg2VvpoLDXV+F5i5DEoyO+IWqPv/O3j91ugHYx+v+3+3+2ZEMLFmV/eYqGxSVPuh8ddDrPOBCJLL1++Gi6nF8NHDsU/R92Ke+78NyKj42GzGTFl2r+xYtkKNgksfOE5fPnZl6iq1sFqsWHxqmeRZyhirKqtG7/C0OHDoI7QMCbfbz/+isT4eCx6/kV06NgZXTqlIjYlHl1SOmLTpi9w36QJmLvgWVitZtTV1ePd99/GqfosRuOmc1Hcv6s4FTWeepQ7qliIjv40NwINR3EdvxacsKHIz3wf+5X/RNfgbjhem87AaMv7W9Cxe2doNWqUVlSwIstXX3oFvx38BUdPn8ShXQdYB9nbR42GwW6CxWTBoX2HMHvh4yjl1EIrVjMwOnfyLGOABQYHYfaTs7D+jfUAj4PouGicP5uFRYsWYt6CZ/Hs0gXY8eMviIyKgDOMd5mmHt0DeUaNwajaVYccawFTyKZeRXHCKIg4Qkhqv4I8QAGjQwWbNM03acOLImcZDG4TYut3IF4TBW/FDnjFQajhxkEWPKLBTF5wwZNoUVWjw5RpUzB5xlS8sfJ1PDZ/Ft5Y/io2bvwQEpGkgQLvl+UhQsSOuv3NehUt/XhMVUbW4lwRTcw6UrSQMsKFzWP3KYlbrczrIe/Gr7zgtjshkIjYZw67HW6HCyKZhP37avNw9QW1jAgR3TOmQRDXf61E6GnakZYo3t3UXbH1qBAuR7tm3R+ZFNvB6I9Y7//ZvtTWIjXIiA/Xv8pCJR27xWHkLbfgXHY6zEYrpDIxfvn+F8xf8BTmPDUPC154Bl99uhU39rsepeXl8HI86N0zDb/t3gdtiApfbP4CYyaMhThGBqVAjk9e34wpD05BubMGQVItY9KdT8/Cli2fY9Hi57BxwwdI7pKMmJh4fPLh55gz5xEWvvrsq+9grK/DbXfdhoz6nIYcFk1mabKuKHKVoc6pY15Rc4PCacSo66zfhZ5RaYBTj5Pl51DE/QecWi7i3KH4+L2PMf7fE7D1s2+RcS4dTyyYjen3TMcX336GyROnYOm6ZTi09yC0ai36D+6Pp2fORWhEKB5+ZgaOV6cjWh7OwOjWUbciNjWeEUCI7bZ03hLEJSegU9eOEPKF6Jd2HWY/OQcLXlqAX7b9yoREWwIjoovHS6Og5MrZsQoc1K/Kl7wgEIoTRkLAEUDgrkZA7QY4hTHQqyb4TOB1osq4E4H2HCg5dojtVYC2N7x1R+CKmAqOLAEO80VCCQGSm6/AqlXrsO/gfsQkxyM3PQs3Dx6C++9/sIGYQSDn4XjA8/ryfj/X7W1TTpFt7PZCX6KDMkrVEHajvBjVvFGYjLwuIjc4XS4SUmSQ6nA64bI7IBSLWS6OlMUJBMWSi8oW/lAfo4BzSTXB5x216CVRk0CTHUI7D6owFQR8Xz7QV9dmuiyHlKyKAVwqHMlUwem42Ajy7zY9NBcKvpb34HNIm1fcZ9+8/F27wNK1NPj/8rG6RvMgshchOCQMJpMBRw7ugkzgAHgCVFSXo3fvHtjzy27Mmv0oFi5cjKeeewrff/09unfthqqqakaO6NShI9a99iauv6EfDu3dh5uHD4YsXsXA6It3PsWYO+8EX82DUijHmaOnoRBL8fMvv2Lm7EfwwbsfolP3TtCGhuPbLZ/j8Scew5EjJ/DOG+9jydqFKHfUQu/Qs0mLckwUviHPqNxVhTJ7ZYsMQKIJ6xxGCD1W9C95BZE95sJVfRC7i7gI6zMZjlorNm3YhMfmzsLieS8gLjUWo8eMwoSRE/D99m8xbuxduHFQf5w6fgq3j7sdY+8cixcXvoj+g/ojKa0D0uuyGfmDwGj4qOHwhAtRZ9Ox9gncWjdeW/E6ul7fHW6DA4888hCemPNUm8DI/67RZB0qCWLFoA2fNQIj+kxTsRRceRScpho4+OEQWU+CG9wHXJcJ3vxNgNsKbo8V8OS+g7q4NyCVS8FxG+GxGZFXJ4VcxkNYAA8engTl5eWorKhGgCoAQcHBkEjEsFl8ORWy/UlTOvNsoyRh2F1z5Kp+EsSa0yQEgcv3hb1Y80SRT4CWvCP/hEnkEAJeenYUwvPfu91ma8gXNT6x0+ls8JQo3EeUcPq7qffkp4ITw9FldUIoE6JqfzHCekRDHahibc4b54/oeozFOvRK7IZKtw3FOV3g9Dbf8+uqDPEXbdwAQF7Pxbzkn5H+IgzicC54qv6/L73JdjD6ix76/8JpusXwsPPL1QgODkOXHn1QkHMGPK4Fx46eRu++PREcFoJfvv8ZC56bh+eeW9QARt26dkNtTS2KS4vRN+06fPDhR7ht7D+w5YMtGDHqVmhSg1ltSfnpYuzdtQ+33zGaTXaH9+3HP24bie0/78CMx2fgh++2sTBMVEw0ftz6A55/dgFmPvYk7pp0FwJUMsQnxCPPUAxrIw8oVBAEKU+CLEtuiyE6ymkQO4+GymvEIPNOKBPvRe35r8ENGwxobkBhdRW0gRro6uqhkCsAARfF+UVITEyAUW9gjflIkJQS7MT2+vjjT3HryOHgKYVM2JP6GJl0BghkImSbi1jLDaKnU+Gkrd6CktxipHRLhVoZgMLSYgQEqeG0Ohiz8LypCDqHodlXSMaXMIX0poM8owS+CkKqB3PbITP/AqGrhBEWQAK3NPnUHQbMxeBEjQInsB+8NQdhQCQcqn+ww0lkUmw/7UJBnQD/6MkDz2tEsFIEh9PXvoGZjAMEBMhgMFoYRZ1GmbMSJ/UZv+uVt9SZYTfZoY7WNOzv62EkYTkcIoKQV0mfESPTz9KkPCARSeqMepY/olYXBFD+ydYPPPQ3DT8Y0f/36xH6de6atqUgarnQy4dQJEB5TjlUCVrY6q1w2ZwQBohhqTQiPCECvUI74XBuEaoqO8Pp+XuE7Mg+Er4HPeP4THj5z/SO3F4O0ktcKK6jYu/LZbDaweh3/WT+f+6klXPQNdyO7PSjqCwvQVBIAAYMSIPBZMSuX3chJDyCMaMGDbgRv+3/DWnXpSE/vwDBmkAqFcX2n7Zj+C3DcerMKZSWlCJApUVCUjR4wSKWE4mXR6PwfAEKzudDrgrAdX16MapuQUEhojrFgmPxYtevuyEQSKBWB+Cmfv3x6RefQKbwNay7edjNKDKXX5IwZ9JGXCHsXjsrsmyuqp4KXBvTp8NMp9BbJkChrQcS5efhMeejNGgUSj2+bqc06EfLmvB5PQxUIiVhCOAoIJGKsHLFSsTEx2H0qH/CZnGykKbJa0GFu4oBZbm5qkHRgiZYCrEZ8mohj1Oz66NrpvopOi5NqOZmCAA+koICEp6kWZXwuLptiHCUgCtUwssVgU9N/SiEJ6FWGVyAw2f1VRxxCLzV++Ct2Y9ixQAIgu6CgOsLNXF4AhwvkeBMsRsDO/Cw/7wTWgUHAsshpHWIxZ6du5GUmIzoxFgcO3IGvbp1htVphdVmRR6/rEUAbfrr8TrcrHbIy+eg9mw5pJEBUIQHXLIZ2UTA9amik83pOTSVqqJwK+UEmeTTBbkoFqLzethio7Fqhj9M5w/V+f/tP2lzuSb2XCx2JirsNNrZgoR6bPlHsETDPOBjeVWore7zXz9JMF1GrwcJQcCY66RMfeTPHlaHF2t/NIHrVzRpRCZpB6M/2/r/Y8dXyziID+ZCLuZApqxEubWAhdT8q/N6mx4hkmDYPTbU2OqhEQU0TKi0DcX8aXLwV+CTskKdXQ+H28HaAoTLQhmtlvI71NaawjE0MRCbjBh39IMnJYaq+lokRsSjzlZ7SU6CtvOJqV4+mmPS0VYWp+0Sb4o+6179KSrd/dCl0/Xg8cVQpM9HmSgBZcrecHNFLINAzezExB6DB4FCNQIFcohEEvAEEuJ6ocYhxSdbt7MLSb2uIzhU7wPA7LKyxoONV6GmMj1kQQpwBBdZWS3156H7o1oYkj9qPITOOgRYzyNF/wsEIQPBUXUFHHXABUknOM1wkUafQ8/yYnAaYbOUo0I9EBWqAdDytQjlk0KDb1Yq0IlJRAkksKCSAdtP+yjWFEEb0Y2HUIUNIrGQ3QfViYm8QlTr65CTW8g8hb07d8LOdSCg68X2JAQSfq0//7UbC3Xw8ICAyMs9vMb3R94QATANAmN/q3MGnMSvu6D/11w/I19XXkvb81dNXh//+fwft9SjKy24M05Up6Om6Ea4nb5F0n/rICDyul1IDOFgbN+/Lte15Esd+AIhWxQ1Bv12MPpvfVP+BteV0nFvs1dJStn0p6VBendE776aQS+tiIEA1Zu4QDkAmVTGaNpNiQkS/qVK4zQ5UWiHgLA5z8jisjG5o8aDFLfdRRVICChDJLce3ph/QeLSQag7xHIp5G2I4IaAqQh4AB79zQEICHlSwGXCvqMHIU6Ywybr87W5SO6SAiEEsHrtqHPoGMD6J05DUT2kKin4yosAQww8X2jKxfIU9IdW/RpxwIXaH98Vy9z10FZvQ4hICLk6FRxZHLzVe2A1laJGGI16nuZCE3Qu7FwpXFwROPR8uGKYBRo2iYfwAxkN3icj6xs7sqXwerlMmZp69zQWBJUIgdRwDjQyIEDKg9PtRYUOMNq8MFi9IKZ1mMYFiTQHB84cgTLW12lXKZSyPI+9EauRxFF999g809F/PbS/QiAF1feES0OYuasstai11SNMFszo7GTPAkNJswy+trYBocUV9eGigt06m57VHVEPr8YdhivM1ShtRp+xoyYRebpKlOTceDWv939kWwIjj8uJxGDgjn7KNl8DKaWXlpYyIImMjGyx7UpLB3zxi1rwhSR2fCnbsR2M2vwI2jdsaoHfC0Z0HKur+ZBZS1YmmnbjycBgMkEp963mGns8TDCTAYOP/USTXEt0bv+5KAFucF5szEefk6IC5WOYjpvHgi6FyyENGw5pYA+IvVTESd94ffkXtw0eL6k+UD0NCaVZIQxIgbf+ONZ/Vwmnui/+OWoURJwLYAo3cuwF0DuNzEPyewpet4cpYBMAERCFiLTggYdyYyV4An5DLQ1dH8frhshVjyjDfkSYT4IbNxEQquA2F8NW9CWyNCNQr+zdbDv1xjYmjyJGGA7FhdBcg008PHx89I8n4juGmGEXHoNBYGJ5n8bdd/3nohqf3L3ZCO4X0aoiOj3fLpokHP7xACNS3DN9InL1hYgVRuClZ17E2LvugKZjCDs01SdRDy3yutkCicdnBbgUrqN/00KGFD6oCzCrVQKXvS9JqhjWUoSYjCdqMti7YM3S45vNX7HaN1IenzT1Xyjj1LDzEJgS0BEQkpBwbo0RFSVd2XdUDPvf2vOIwMjNwMiDcf2u7JX6n1V21lkc+ukNJKny4PZwUGjrikGjZyI0NLzNE+QLn9dAKJJQHLjdM2qz1do3bNECfDgRnbKP/cCbjtY8I9qefri2Noqtspoh7qUN/orOliIwVctCeuR5WN2+rrM0uTLRT1CuwKfe3Npg1+JysJYRjT0nd7WLFebK1NQsjwetNQcSZzVIqMcHRh6maACa2MCDmUchJF+Qq5t5L8Sx4+Cu2AmnOA5uRRpconh4vBwmV0Q5qmJnGeqdBjYB07VWZZVBkxzCVv9kQylXwjTZKLRVWVeFuLQIqC0ZkFoKoPDooSbh0YAUcKRR8JZvQ63DhVJRIupknZnn1pZBto0XRkHKubTJX0atC0dyL83btHY8vkgPl/3iPkoJB/EhHmjE5fBKOZCJyEN1Mi+UCd+6HQ1tREgXTxQqBcnvtPbEummTe73eAAAgAElEQVRT8MPGb7H7t714cc0LkAbKkXsyG6tfXI2pD0/BoFsG4eiBoyjIL0Dfm65HbFQM9u3bx9pf9L3uOtSa6rH3lz1I7ZKKXr17ITcvD7W1dSjMysNto27DuTPpWP/Gu7jrvruQ0CcZ5eZqVB0oQlVFFcbfOx7bv98OWjhMuHc8Dhw5gvxz2Rg4eCBkEjnyywoRn5qK/Gw9I7qcrNBCf6Fzc2v2+6u/bwCjIA/G3dA6GOXl5aHiwLO4LuwMuBeKmq1OAfaU98N1oxZDpWr9GHSPL3xWA6G4HYz+6uf9P30+hSwfmvBS1hLd3/DOf8NS/pXZRDTpk0fTXHy/qdFo1UqtJfw5FH9Ow02exIWoEoFRW4DnSg+ENb6zX5Qn8jq9kAslEIt8Eztdg08ap/WhMRxBN5ENHG0avIbzLGwGQya8qm7wBqTBFjgIFhcXuZYqOMiZ4vBRX1QLVZTG13vHY4fMY8PZ/Xm47dbx2PHbb7hTuxoI6geuugcgDWcembNyN1xVe3E6ZCJ00mTGSmzsQTZN8jd35Vq+GuH8i3mdepce+0oMqKtKbdhcwAO4jUQG/E+cRLEpp8Tl26CN3A84NZDYu6NjOB+0T0a5G/lVpLLtO1Sg0gu1wgK1VIBwNQ9ykQ17TuyGJFrp0zp0XF7H0/ia6X66apMZGAVHhcBmtOHOe8bh3dfWo6CwCMOGDGHySL9t+xUT/n0XXlv1Ola/sgKzH30S/W68HmPHjsHaV17H+EnjsOHVdzF/wVx88N6HEKjEjGiTcS4T424fgzWrX8HUR6ZCFhnAhHAJjHKzcjFsxDBs+XALbh8zCsHhYdiyaQsmjB+Ht994G0/MeQILn1+MZWuX4uWFyzH6rgeQZ4mDzkw3/xewA1p/LS/Z4mrBaN0ra3Bf6iZIqZyj0bA4hTjMX4pBg4e06QrawahNZmrf6GotwONboFAUQRNUBwH/olpk07xNc8dtS+6IJlZft1bSSOMiVBbEWGbEMNvz2xEk9vEpYZOX1RZgu9L9UaiFktx+74gmPk+dC4HhPpqxr+mg6JLJvqXjcb0ORNX/ighPFeu/BGkUOLIYgC+H11oK2GoAt4VJ2+gcFiYAW8+LgVsRDYmrFsGuYmhFMpyuC0ZpbSD4PAeGdvUAlmJ4rRUwuoFajhwlwlgYpEnNTnZ0vaSE3RqAEkkkUhQKBeSs79Mhw0mUVkTBqovz3TcHiA3kgsS8SY2HckekZUuScWFqQGfmQCaxQyDSw2RSQ2fio1LvhYVQtpXhtZegbzdAo3KjwFjKvCXq3tvSIJJLB1U8A6MhI4bgq0+/wqT7JmLD2++Bxxfgup5p+Pqrb/DQEw8xVYutn29Fx6RUbNywEbOfeQIhISH48vtvYK4x4tix43hh8fP49pvvcMPQ/kxGaMsHn+CxRx/BsqXL8eizs3CyOoOF4QiMjh48ylqt5+XmISUlBQOHDsQnmz5lNPJTJ09h/ty5ePOdd3DDjTfgkw8/waOLnsHBonpwuU44bRrYjFGtmeMv/f5qwWjlS3PxeN/vm73G7cY5uOWf97bp+tvBqE1mat/o91pAILAhJCwHMrlPQ40mQJoIr7Qyb0o+8FFyuYxswJqjcfkMiPzHIAp0XEAkdDYDSs2VKM4vgTZYC6lMwsI+lLf5I6MpGNGxsr/PRtrtPRp0yshrITr1lQbRj0VcAWsISCKboQIOwmzZENbtAaf8e3DVPcHtMBsunhoCly/vQPHznOzzCHMfhFQiBid6DOAyw1O1G6jaC6/bglxZb+gUXVAl7cAAmYRlKceRoy9s0SukfBSx7sjW/s61/udDtvbZmMfsHCYIQrGtHBXWGhgq0uCw+HIvrY1IDZcBT52pdfBp7lh8vgP9u1VCIxEyBQ09ye5cgczQQR2PHR9uw5CRQ7Bnxx7U6+qRlJSIvPwCdO/UFT//vAN33XcPklMS8dF7m9E3LQ0b1r+HOQvmMJmgd15fj+mzHsDH73+M8ePGXQZGM2c+jOVLV+LxhbNxtjabLXIIjOpr63HX5LtgdzqwYdV6dOzQCQa7AWPGj8H619fj3nvuxomM0/h685cYOHwQ4vqloMBQym6ZiCDGyl5wWC56oK3Z9c/+/mrB6I3XX8OkxPcu94wcQuznLMHQYcPadMntYNQmM7Vv9EctkBy/Hxyxz0NqCyARkcE/KTZewdME0DjcRMcjxQJivvkb25HqstvpAV/EYx1pr5ah1/ReKdlNrc6bTqmk0k2TP5fnC7VcKQQZKQ9FVVEFzh4/i6CQIPTp1wcioRAfbfwIg267GZmWAkSKRIgWhyHjxAl0SvBC4a2FR3MzMnMrkZZAduPjYLYXoRovbEIDQmVd4OKqkW7NZrRwIjWHy4NhL7dAr9dDmahhckZ0/35bErASzZ7h3IVW6Y2FP/0tKhpP+lyvBA6bEl6OE6bqLnA7/zq6r0BgR8cYA2JDXEypvdaqb5b5SPeToIzCka37ccPN/WGsN2LtirVY88ZqfL7lC6QmJkMVpME3X25FWGgI6uvqMXPmDCxdsgzTZz7IatLWLl0DdbAWeedzMXvO4zh84DB69u8Fl9OFrV99iwemTcWSJS+jS6/O6DWoD0pMFTCcrsK+X/chKSUJlZWVuGXIMEjkEnz0wUeIjIlBaVExHpv9KMxWM+bPfgYvv70c5y2FrDzBP4jqrSvtD6+n+dKDP/rbu9r9rxaMSkpKkPPrPAyIJDFe36/E7BDicP0Q9Bz+dHvO6GofQPv2f64FYiJ3QXyhnobO1BYyQ1uuiBrZJQZEswkqT1/MkuDUVK2qqAYRiWFXFEFty/EJgUgSqLneNaYKExQ8KTRR6iuCEWnpEUX7jdfexPSHH8DOn3fBYbPj6Xlz8O9J9+G5l5+DLEDBwj4GnR7btm5Dn9E3sGJDuUWETe99hBnTejHK+LJ1BzBkxAh07dMNwRItO6/BaWT3TewuIm6cOHgMuaWFGDl6JCNBZNXnIUoRBoVAzuxBKg/Uj4lAyN/im+zoq/XyeZHpdbmosPi8M49bDF1pP3hYU6O/XoWay3Whc2IpOoTKsbvsaIs1QcRYSwmIZTpzRAThebggKbwL8yPsHgdEEPq6vPKoDaAbUo4Ydq8DRpcFQUI1HE4HyzcqxQomJ8T6KHlcEEDApIiYUoMHqLDXspxRr6CO8FxIfDGKuUTO6uOEHp8KBBF56FjpWRn49ZedGDVpNGv90ZjJSeQOAqP/lnG1YJSbm4vtm95GqvUYuibUsBrqwzmhOCftidH3TkZSEoWLWx/tnlHrNmrf4hpYQKYsRUREAagXEg1agVOe5Y8MWtlHyUNZcS0NWvXn6321JDaTHWK5CHZP28gQzV0HeWGUp2ipiZrH5YbYKYJC7StibMkzilKEYuuHX+P6/n0RGhcOMV+MF+Yuxvz5czFr1mwsX70Mn332BepqaiGSSCBXyNB79A2MQRbqUuGDtz7AhOl3QylV4pUlazB27O3giPjYu+sgnHYHkpKT0ee6Xljx8nJ06dQVPbp2wkeffYKw0FCIFVLcP2UK9uzdhzOnz7IeQL37piE+KhZ7Du/HyH+OwHfffI9e3Xtg3679qDfq0a17FwR2DmNt3WnQil1XciPcriuHIf/Is2zLvgnRFUgMszMPqaX2E+SpUviW3gVWp8QkgnwNCQlcpFR4zDxConY7GX2bAJxAmMK99E5R40Lan5hx+moDpGophCIhO5bv+FzG9qPwL/07SKJhOUuqxco1FLEaJDoPDWo5ESMNw6a3PsTwMbfCJucgt9IJmykSboccYkUZXA4F7KawtpjgL9nmasAoMzMT6T8/i4FR+TBmecHzinwqJDIHhFE8nDP3RJdbX4BW61s4XWm0g1FrFmr//hpZwAu5vA5hUemoyKyASCpCRHx4m5L+LV1AiETLCj1z9L6eRARz/gLW6uIayMNkLYZ02nJTTcUvm9uHJrKSo2VI6ht3RTD6dtM3GH7bcNgkLmhFQXh16So8OP0BzHt6Pp586gksev4FrH5nNWqqarDntz0MjCg0GOxU4bH7HkVCSiLjXZ3POI8XX1oMZWAYXBwtTIZ8LHv2eby86mUsf3k5Xlj2KoqyjuBUZjH+MWYYNr77Fh68736sWrsW906byNSr31r1Bh599BH8sH0b+2zj2xtxU/8B+G7rD7h7+j0QScVIZzkaX/M7l10NfXlveD0tFyy3xZ5/dBse34rw6NNIC4/F8apzLDTZ0rCYq5Gfsx2eFlqD+PfzMzFjo65HdEQalLww6FylTHmjJr0SvaK74NCZ4wjoEQjOBZFW/7707PuEdGVMv8z6fAZQTYunyftMCohhnlWFyYns/Ei4nDKWK7o4/CUBf9RC12b/qwGjX3dswwDO0+BzPbDVc1Bz1ndfwd08ECq9KDZo4e3yGmLiO7Z6ce1g1KqJ2je4lhbwGI+jf7II9TodrBo7VNqAVgswG5+fVqIkeUPeEDGoaJypPc+SyaybJ4kMeb2oKq4GTyCAKsQnE3M1gyYUi9NX83KlwZSjhTLUFtRBHaqCStl8/Q15Rl+9/wUGDRkEVaQGfI8WqxYtwJNPPI45Tz6NafdPwwebPsSi1Ytg0ptYmK4xGH3y3hbMnPsoW62vXLgCt48ag+y8EuRln0d0XDy++XQLVqxdibWr12DBkrdw8tguVFVWYeCwO/D1J+sw6e5xeOnll/Hgkw+B8mlL57+Ep558goHRPVPvvQSMHnrqIRyvzmChPP+w6uNgru3wX0FDlqqzERJcio6aBBQayxgQUL6w6TCbKpCdsbUBjALkofB63TCYq9mmpJARHJCA0tpz7N+JcQMRF90PCnccUoNUqHJUIeNYBroldMLJ7HMwhzrBk1zM6ZB31T8sDSfKKmGEbzHkH14vz6dswfEAVD/mUMJhDoPVEP0fB/S2/A7aCkYUstz73VrcFLCx4bC1mVzwhIAq3pcf1lnFyJY+iT4Dx7V66nYwatVE7RtcSwtYa7LQK1YHo0kPbxig0MgvCFhyL6MaN0c8oOp59p+/kAi4QC64lF5Aky798bccaOs90FFIOJUYZq0Nn4yNDHBTXsWDAFnz0ilBEjVKzhTgq6+34oHpD2DPzmMozs/Cc88vwP33TcNLy1/EQw88gqeXzsPRnYdIYO0SMNry3scYN/NueF0B2LRiHcaOuQ2bN23BDQOHwsvh4aN338LqV1Zj1apVDIxOHPkN+/fswuTpj+HNtUvw3II5ePONd3D9zdfDarPh8MHDmHjn3Vj32uuY+sT9WL1gBabdP4V5Rs2BUX3R4P94iM7/LDgcD5RhhyCXmRAi1SJEGuhbENj0TGi2xlrPwqpNwWjioIVweZz4eNeL7FB9O9yOtMQRePXbaezfKfGD0St5JJKVqfj+OBck/sv3VMJafhbaiADYNB4YnKYGeSjKTyk8ydh9TghF8EkIpFXsOMQ0NNel+tx0jhc8np2F4Vi+7W8y2gpGdrsdJ76egeuCD8Hl4YHPdYPWBUxR6kLZHRVzf1cyGqMmPd/q3beDUasmat+gqQUosc5vpsbT0UZZOWvteciUdiR0NoLLu1iDROdpqpJ8xbL75uoFqbu1k4OCY4WI7xd9VQ+PqTi7HJeJo7Z0EKpvYhMhNX5Ty6G+QqV5nDIS6afOYddPOxEdG41Rd4yCRCzGt19/h6G3DEFeQQG+/fxbdOrWCSFhwRDHK1nOKE4SgXNHzyAwuR+s5iDU5f6IDsmp4IsU+HjjekQnxMFuMWHkP4Zh74GjuHHwHaiqyMHRA/uQk52F628ciusHpqKuthpbP/kGAoEQo8ePglQuw47vdiArMwtRMVEYfsswZKRnIG1AbxyrOtcQorObw2Cs7HlVdvyzNxaI6yBR5zAyhcclhscph1IQgJggJ9QyHuxOHkp0J7HrxFq4qE2GRI37hiyBTCDDuh9mQikPxR1pj8HKcWP9jw+zy+2dOBHhmgnIreAyDb3GI0LDQbSWi1C1E1oJvWBueLlCbNrHgd0FCKVVEMnLYDdGwmElJfq/92grGJWVFqF6131I0OpQaVQgXnux6SJZYHd+HPrFFOLXnDj0u/sDKBRXjlK0g9Hf+735j1x9z1ge1PLLkaC41oPz5ZeCS0sXSEQGuaIG4RFZlxWhe50cGMzBoL85fC+kIh34YjvJEcBoDoRJp4HLK2q+eJ0iIy7AbrUjIMQJbWAJqF6lteHxeJkOHWOT2WWw2zXgOvlwC30inSKODRz5hdqfCwejBDmBkcvhAl/IvyK1m3IHAUIFCy1SXsvssrFiXdYczm1nCXkidLi9LsaAq7bWU29UH2POy0debmcW4gkJIJ00wOkiu/ieAf0vl0t6exwYLF4ESBs9G0E9LKIjUIokDUQPCsER+y5YqmF0cfJA/6+9M4+OskrT+PPVvqSyVVKELARFRRYhQDCAjYI6Lu3WSjNHxtMNHBwVt56ebkB0nD7YYrecw9g0NnY7IAo2yKCMDqRFbUVaRAYVWVVAodmSkH2rLbXNubeSTAIJfEWoSlXluf+w5Na97/t7P3jq3u/e9w2/6xBjiLlr5eoi6LOgoaIEAV+81eARW2DC3M7PoFg1afVO2NKq0FTjw98rn0Qw5MYNRT/F6EsmQ6fVY8+xnchNyQH0VuSk5mDF355BeeUBpFtnINXyj+d8TAw6wGELYWhuEIcrtTga3vELx0AR28OxP2l4vuf6Qn6uVow2vr0OJdrf4auyHPRLcWJkbkWn6dbtGYaSgrJw4tq8RSgpKTmnORSjC4lWH//M+Es82LTuj6iprkJdTTX69c/DNddOwuhxN+DAyfDRYLFKEv94xX+c1Y0hmMQ+cut/kiInl7gM6UjVIDW1GgZrOQIBLTR+O06eskFnsECUg+n4Wlcklkwz+eEP6dHgDl+kVJFeDlpdC+z2k0hNq4RWF166yWzdohJo0IdQSIESNMHlVuB1ZSPozoC7JbvLCBv0DbDav4bG3ABFCZ++EtuGld9XIm9Qfxh1xm7LVJzrkRH2iMu63bUWV7a8GCneRUTazGlHYbWHC9qFAnooGlGau/ULQ0iDUFALRXtGVuzW9xxNlUUxvVMUqW/n6u/1fYvKhqeg12kxe/Ii/O1YqXyexuddjzd3vwKrKRXXXX4P1u38DTzuWlVidDHti+ex1IrR759/AjNGfohX9t+NSf0/7lKMNDor7hi8C5uqf4ap06ZTjOI58Ilo25W5WmRbW1BfeQTvrH8ds3/+NGxmHb47uB8HDh7B8CsvRUZmNkpLNyI3rxDjJt0Kv9eJdze9AyXoxa133Svrluz9cju+ObAPEyffhMGD8vHlV3sxdGQJKk6dAFoaoTUYUVnrhKepCj+85UasWvPfskDb9TfdgW8qzTK1jNpmMjYjPbMcivWIFKOA2wyfxw63OwdBvxlBnxlBnP8/ew0C0FmqkZpxAva08Ivz5monLJlm6LX6Cz6uXuY83e0RclfdFXDVqburcSYPc9oRKJqgTFQaDBjkdpL4u0CLDa76y+S3+VTHV+0CJe4UeZvy5HwXIn5q4xHtfm1iJOKVbS5Ahet7OWW2tQC1rvA3eJvRgXpPOBOCmpVRtG2Ol/HVitEHmzeh+fQuXFp0J0L750oxOtmQhiyLEya9H2JldPm4B1Bf9hX6D74JQ4cNpxjFS5CTzY4x2cex4Y3XMOPxBXKVsvblhbBaUjDlntuxfOVy3P6jn+Kj9zbinrvvxoH9e5CZMxBlJ4+jvroCN954PZavWIkp987EmldfwjMLnsbSF5dh9r/+Cp998hHqTx+FyWzFXz/8CPOeeBLvvP0mLDY77Nn9cGDvLkyZOR+ffaduS7Ajd5OhBgjo4Qmor9PSXdzsacfQcPILZPY3IWNA+CSdQWO4oNWR2Dar9dbLk4BnHg+uPzURfm/P7RX2KRqffMfhbc6T9oqVksl2Qq6QWlw5UrCSofn8R1HTtESk3VXljs10F1LMt6jqm+yd1IpRG4eamhqc2DxNitHO43kYnF2NNLNXitFts14+77uitnG4TZfsT1YU/TtTjDaufRE333wrbGlp+Pcn/gVDhhehuvI0ri4ejaEjR+Gt9RtgtphRXXUac+bMwUsvvwoE/RhVXIIfXD28SzGy5w7C6KKr8KNbrsP1N98Oo8mE5sZG3PvAU9j+/flXMlF0X5brDgYakOOoQ1pWJTSt24AXkl1CiJDT75LvrMQR7raifqGgAbXHbkia9xFRjQcHvygEIhUjr9eD/evvwui8cnxwaBCKC04hw+yhGF2UaHAQVQS6EqObbr4VRmsGSjesxbSZsxHw+5GXqcfvXngBd947S57qevu/Xsdjjz2KioYgUqxmLJj3KJ5b/GssX/aKXBlt2/I+nHWn5MpIiFHx2LG46x/GY8Ub78KWmgaP2wVPyIKPv1Z5fE+VNz3rZE2phT37GIxGNzSaoLw7JbbtxO1/NeUaRKE3ccO/rYlb/PKYee0VcNVf2BZdzzzip/sqgUjFSHyR2vHabRhXeBKl31yOIY5aebLujd3DMe3na1Rj5MpINSp2PJNASW45Nm96B/f85FG5Tbe19HVcPWEiUjLy8NHmDaiprJC1a34yfQa2b/sYe/fug8FogrO5GQ8/9M9Y8dpaKUZ1tTWYO38Olv9pOfyBIOpqazFm1HAYjBakZhfgssFX4fPtW7B/9+ewpNiQX3g5hoy5AZ8e6lk27osdUXFC0JJSjfyCg+1DywKAWtM5BUmmpgl2PvEnsj94/AHUHZ+cUHdULjZTjhd7Aj0Ro/V7hmJwv1qMyKnAf+4YjQfmv6raAYqRalTseCaBW0bqYNApKK8Xx1qBvEwNWnwhbPk6gOuGaGEyhI/eOj3hgwZWU/jPoq88aRcIn5gTfy6vC8KRJhJLhuvkiJ+L5m4Bdh8LYJBDg9TW03geXwiffBuAy6v+AEMso2e11iGv8Gt5C7+tAKD49ii24IQ46ZSwc+LPIqGn+Md/ZhM58VyuVDSUl/RKctJY8uJc8UXgQsRo40v3YXC/GuyqGAy7sRaFGVX468GBeOTJP6l2jmKkGhU7nklACIZI19USAAoyNci3a2TlTq8vLBKVjUE0e4A6ZwhGPZBiUmThtRa/SFoJKVZGHeD0AkJgrEYFg/trkCaOUNsysOOwXwqZq3XRkGFVoNVAXkpUe8G2V6KmhJCVfRT2rDI5vdim63gooS0fWleHFaR4t2aAcNdfCmetSMPDRgKxI9AuRo4gpk5QVzJcZO4WTavVyqzobdWVBw0apNrwZ9+shsHIsuOqgbFj1wQmXKHDp5tX43+3bYFOr8edU/4Jo8dNwof7ffJyplgT1bTeDWoTFY8PaPYIoVJgM4XHzc1QsHHlAjw+9xnsOxFAhagMGqcroPM9CwWF+2CxhmsHqW1ipSSqyormbc5HU+WIuMgJp9Z+9kt8AkKMgn4fLnOE8OMJXedbjIaXC9+qgd5gkgUlxQ5CW1MWbWrdW4nGrBwz6QgIMdr458UYXTwe/fMKsOyF57Bw8R/hbQng631fwtfixfBR49HsBeorDqGi7JQ8befW2GHTuXBg9w6kpmdhbHERfvvMv2HKtFk4cfwoho0YjW+rbDhVF/kx7t6GLMpK5xZ8A6v1/5OOnssmb8DXqTSC35uOhrLxPEnX24HsY/NLMQr4MdAewtQJNmhF/q8ot3pnAMvea4RWb4SiaChGUead1MNLMXp9MYaNGIXcvAFYtXwp/mPJUqxdsw7Nzma5fFdCPowYORSlpe+hZMJkrHt9BZaveAXz583BmHGTsH/Plxg3cRT27NgFnTkNWdn9sG/3F3joiSXYfsiPYHy+IjpnXLU6L+zZf0dGRofcMV18QpQBFyUbxIXc9hZS4GkaAFftYAR7uXxDUj+8dK4TAbl9HAxACfowJBcQOxmyIKGalCeRsFRETmCR3krBvhN+OH2igKHIxK9QjCLhyL6dCQgx2rDyN/D7RT44h7xfNHfOL7Dot89hzPjJcLmc+OAvb2Px0iXY+sku+L1urFi2GCtfW4WVq9dh1sO/QFNDPZx1Zfift9bioV/+Gk2NDfjlw/dh4Usb8enBxBSjNkoGoxO21CqkZ5yGTndG+h15mCHYqRR1R7oi47OnsRCepnyZLYKNBKJNILw6CiAY8CHg90VNjMQqSKPVQafTQdHqz1oVCT+5TRftaCfZ+EKMSte8gAnX3Ygrh47AqpeX4Nprf4AtH36AW+++T37bSbXo8d23u1FV70VR8TjM/9ksvLjsD1i1ei1mPToPXo8H3qYqrH3t5aQTo7ZwZ9hPwNHv2FnRFyui8Mqo++Vfc9UIeJoKkuzJoTvxSCB8ACEkV0NyVSR/HwVLFXF6VgNFbgV23p5rm41iFAXuyTykEKPN65bCmmKVKXt27fwMTz71NN79SynKKyowcNAV8LjqMTA/Dx9/sh05/fOwYd0qrF67Hn/4/RIMuPwqVJw8grHFY7Dzs22Y8ch8NDc1YcG82Zj3/OqEXxm1xV6n9yJ/wH55OVY0sSIStZN84htoF0e8Oz4zjadHyyJtbCQQKwJtp+Kio0TtciN/0/HQQkf/KEaxinaSzDP2Ui0sqEFzU6N8qNLS7aj32ZBiDMBZe0J+u8rNy4fHr0N91Ql5l0islgry8+HxelFeJjIuWJCTm4+6mkqkZzrgbgmisaYMAVMuPj8SuOhb1r2F3pZejtzc76X4iPtEnd4TncMon9sOZ/Vw+H0pvWU65yWBmBOgGMUceWJPqNcpsHTIsSkutIqyD6IIX266IktJ1DoBUTfIkSqLMsv7Rb7WDDj2FMi7RyITt82sSOER95HEsW8xjhgvmVqm4zA0lmOARl0izzbfQwEDmqtHwOvsl0w46AsJdEuAYsSHgwSiSUAJQmdoQkrWfuiM9RHNxHdHEeFi5wQnQDFK8ADS/MQgIIv0ZR6CyXY8XPjunE1BKKhDY8VY+DwZieEgrSSBHhKgGPUQID9OApEQ0JtqZTGWUnkAAAVcSURBVF0ho+1klx8TpSTcDZdAvDcShfKSpcR1JIzYt28SoBj1zbjT614moNW5YU4/CoOlXBbCCwX1siKrPNId0vSydZyeBGJPgGIUe+ackQTaCYgtO52xIbwKCramMCcfEuiDBChGfTDodJkESIAE4o0AxSjeIkJ7SIAESKAPEqAY9cGg02USIAESiDcCFKN4iwjtIQESIIE+SIBi1AeDTpdJgARIIN4IUIziLSK0hwRIgAT6IAGKUR8MOl0mARIggXgjQDGKt4jQHhIgARLogwQoRn0w6HSZBEiABOKNAMUo3iJCe0iABEigNwiEQlEp8trmSndF9dp/vmiTJxpFZnsDJeckARIgARKIgEB7hVchROepQBzBsF13VZTWKq9tv3buxpVRjwlzABIgARJITAJCjIzaIEYO0CLdGi52Ga0WCAIHTgZwujEERaM9axqKUbTIc1wSIAESiGMCQojEaujSLGBKiQWaGCSLd3pCWPpeMzRaHRSl84QUozh+WGgaCZAACUSLgBSjgA+X9VMwZVxKtKY5a9znNtRDpzcAiqZ12y7chWIUsxBwIhIgARKIHwJiVRT0+3CZA/jxhNSYGbbwrVroDEYoipZiFDPqnIgESIAE4pSAEKOAFKMgpk5Ij5mVz75ZDYPRDFCMYsacE5EACZBA3BJoF6PsIKZeE0MxWl8Ng4liFLcPBg0jARIggVgSoBjFkjbnIgESIAES6JJAT8To8OHDckybzYacnJyICD/LlVFEvNiZBEiABJKaQE/E6JFHHpFsiouLMXPmzIg4UYwiwsXOJEACJJDcBHoiRg8++KCEM3bsWNx///0RgaIYRYSLnUmABEgguQlQjJI7vvSOBEiABBKCAMUoIcJEI0mABEgguQmoFaOtW7eeBWLNmjXy7woLC3HNNdd0+vmwYcOQlZXVLTxu0yX3c0XvSIAESCAiAmrFqO39kNrBZ8+ejaKiIoqRWmDsRwIkQAJ9mQDFqC9Hn76TAAmQQJwQUCtG27ZtO8vi1atXy78bOHAgJk6c2OnnQ4YMgd1u58ooTuJMM0iABEggrgmoFaOunODR7rgOLY0jARIggcQhQDFKnFjRUhIgARJIWgIUo6QNLR0jARIggcQh0BMxevzxx6WjY8aMwfTp0yNymke7I8LFziRAAiSQ3AR6IkZHjhyRcFJSUuBwOCICRTGKCBc7kwAJkEByE+iJGPWEDMWoJ/T4WRIgARJIMgIUoyQLKN0hARIggUQkQDFKxKjRZhIgARJIMgIUoyQLKN0hARIggUQkQDFKxKjRZhIgARJIMgIUoyQLKN0hARIggUQk0J0YOZ3Oi+qOwWCAXq9vH5On6S4qXg5GAiRAAolNoDsxcrvdF9UxIUQ6nY5idFGpcjASIAESSBIC3KZLkkDSDRIgARJIZALxKEZ+ANpEhkrbSYAESIAEIiMQZ2IUUBZt8hwDMCAyN9ibBEiABEggkQnEmRgdV57f5HlLAe5JZKi0nQRIgARIIDIC8SRGIWCDsqjUPQMhZWVkbrA3CZAACZBAIhOIJzGCEpqpCJjcqkvkR4q2kwAJkEDkBOJIjI7Pvd1UGBYjro4ijyQ/QQIkQAIJTCBuxEgJzZx7m/lVKUaiPb/Js1QBHk1gtjSdBEiABEhAJYF4ECMoyovzbjc9JkxuFyMKksoIshsJkAAJJAGB3hcjzYvz7rBIITpLjDps2S3gce8keNroAgmQAAl0Q6AXxei4zmT+1fw7U17taFqnlVHHH4j3SKGQcocCFAPI48VYPtMkQAIkkDwE1IrR+++/H5HTRUVFcDgcHT8TAHAKwBcANiqK0kmE2jr+H1BSO6R1ePNYAAAAAElFTkSuQmCC" alt="">

                                    </div>
                                    <div class="form-group mt-2 ">
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
                                        <select name="" id="" class="form-control">
                                            <option value="">select option</option>
                                            <?php
                                            foreach ($parish_options as $key => $parish_option) {
                                            ?>
                                                <option value="<?= $key ?>"><?= ucwords($parish_option) ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none d-lg-block d-md-block text">
                                <div id="map"></div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group mt-2">
                                        <label for="">Phone number</label>
                                        <div class="input-group mb-3 djustify-content-center">
                                            <input type="text" name="phone_no" class="form-control" aria-label="Username">
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
                                        <div class="input-group mb-3 djustify-content-center">

                                            <input type="text" name="email" class="form-control" aria-label="Username">
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
                                        <div class="input-group mb-3 djustify-content-center">

                                            <input type="text" name="web_site" class="form-control" aria-label="Username">
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
                                        <input type="text" name="facebook" placeholder="https://www.facebook.com/#" class="form-control py-3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2 pt-3">
                                        <label>Instagram</label>
                                        <input type="text" name="instagram" placeholder="https://www.instagram.com/#" class="form-control py-3">
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
                                                <select name="cuisines" id="" class="form-control">
                                                    <option value="business">Business</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>What Meal Type do you offer? <br> <small>(You can select more than one option)</small></label>
                                                <select name="meal" id="" class="form-control">
                                                    <option value="business">Business</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">

                                            <div class="form-group mt-2 pt-3">
                                                <label>Payment Method <small>(You can select more than one option)</small></label>
                                                <select name="payment_method" id="" class="form-control">
                                                    <option value="business">Business</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>Upload Public Health Certificate <small>(optional)</small></label>
                                                <input type="file" name="health_certificate" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group mt-2 pt-3">
                                                <label>Upload Food handlers permit <small>(optional)</small></label>
                                                <input type="file" name="handlers_permit" class="form-control">
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
                                            <tr>
                                                <td>Monday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="monday" onclick="getOpenstatus(this, 'monday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="monday_close_span">Close</span>
                                                    <input type="hidden" class="monday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="close_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="1">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tuseday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="tuseday" onclick="getOpenstatus(this, 'tuseday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="tuseday_close_span">Close</span>
                                                    <input type="hidden" class="tuseday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="close_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="2">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Wednesday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="wednesday" onclick="getOpenstatus(this, 'wednesday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="wednesday_close_span">Close</span>
                                                    <input type="hidden" class="wednesday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="close_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="3">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Thursday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="thursday" onclick="getOpenstatus(this, 'thursday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="thursday_close_span">Close</span>
                                                    <input type="hidden" class="thursday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="close_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="4">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Friday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="friday" onclick="getOpenstatus(this, 'friday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="friday_close_span">Close</span>
                                                    <input type="hidden" class="friday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="clos_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="5">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Saturday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="saturday" onclick="getOpenstatus(this, 'saturday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="saturday_close_span">Close</span>
                                                    <input type="hidden" class="saturday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]en" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="close_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="6">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sunday</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" name="business_day[]" value="sunday" onclick="getOpenstatus(this, 'sunday')">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <span class="sunday_close_span">Close</span>
                                                    <input type="hidden" class="sunday_hidden" name="hidden_status[]">
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="open_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="cs-form">
                                                        <input type="time" class="form-control" name="close_time[]" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hidden_itra[]" value="7">
                                                </td>
                                            </tr>
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
                                    <div id="dropzone1">
                                        <FORM class="dropzone needsclick" id="demo-upload" action="/upload">
                                            <DIV class="dz-message needsclick">
                                                Click here to upload photos<BR>
                                                <SPAN class="note needsclick">File type recommended PNG or JPEG
                                                </SPAN>
                                            </DIV>
                                        </FORM>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="section_title_with_line mb-3 mt-5" style="margin-top:5px">
                                        <span class="bg-white pe-3">Add Menu</span>

                                    </h4>
                                    <section class="container">

                                        <section class="row">
                                            <div class="col-sm-12 mt-4" style="overflow: hidden">
                                                <svg width="858" height="31" viewBox="0 0 858 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1.58523 14V0.909091H6.00852C7.03551 0.909091 7.875 1.09446 8.52699 1.4652C9.18324 1.83168 9.66903 2.32812 9.98438 2.95455C10.2997 3.58097 10.4574 4.27983 10.4574 5.05114C10.4574 5.82244 10.2997 6.52344 9.98438 7.15412C9.6733 7.7848 9.19176 8.28764 8.53977 8.66264C7.88778 9.03338 7.05256 9.21875 6.03409 9.21875H2.86364V7.8125H5.98295C6.68608 7.8125 7.25071 7.69105 7.67685 7.44815C8.10298 7.20526 8.41193 6.87713 8.60369 6.46378C8.79972 6.04616 8.89773 5.57528 8.89773 5.05114C8.89773 4.52699 8.79972 4.05824 8.60369 3.64489C8.41193 3.23153 8.10085 2.90767 7.67045 2.6733C7.24006 2.43466 6.66903 2.31534 5.95739 2.31534H3.17045V14H1.58523ZM17.0508 14H13.011V0.909091H17.2298C18.4996 0.909091 19.5863 1.17116 20.4897 1.69531C21.3931 2.2152 22.0856 2.96307 22.5671 3.93892C23.0487 4.91051 23.2894 6.07386 23.2894 7.42898C23.2894 8.79261 23.0465 9.96662 22.5607 10.951C22.0749 11.9311 21.3675 12.6854 20.4386 13.2138C19.5096 13.7379 18.3803 14 17.0508 14ZM14.5962 12.5938H16.9485C18.0309 12.5938 18.9279 12.3849 19.6396 11.9673C20.3512 11.5497 20.8817 10.9553 21.2312 10.1839C21.5806 9.41264 21.7553 8.49432 21.7553 7.42898C21.7553 6.37216 21.5827 5.46236 21.2376 4.69957C20.8924 3.93253 20.3768 3.34446 19.6907 2.93537C19.0046 2.52202 18.1502 2.31534 17.1275 2.31534H14.5962V12.5938ZM25.9485 14V0.909091H33.7979V2.31534H27.5337V6.73864H33.2099V8.14489H27.5337V14H25.9485ZM45.3596 14.2045C44.4732 14.2045 43.6955 13.9936 43.0265 13.5717C42.3617 13.1499 41.8418 12.5597 41.4668 11.8011C41.0961 11.0426 40.9107 10.1562 40.9107 9.14205C40.9107 8.11932 41.0961 7.22656 41.4668 6.46378C41.8418 5.70099 42.3617 5.10866 43.0265 4.68679C43.6955 4.26491 44.4732 4.05398 45.3596 4.05398C46.2459 4.05398 47.0215 4.26491 47.6863 4.68679C48.3553 5.10866 48.8752 5.70099 49.2459 6.46378C49.6209 7.22656 49.8084 8.11932 49.8084 9.14205C49.8084 10.1562 49.6209 11.0426 49.2459 11.8011C48.8752 12.5597 48.3553 13.1499 47.6863 13.5717C47.0215 13.9936 46.2459 14.2045 45.3596 14.2045ZM45.3596 12.8494C46.0328 12.8494 46.5868 12.6768 47.0215 12.3317C47.4561 11.9865 47.7779 11.5327 47.9867 10.9702C48.1955 10.4077 48.2999 9.7983 48.2999 9.14205C48.2999 8.4858 48.1955 7.87429 47.9867 7.30753C47.7779 6.74077 47.4561 6.28267 47.0215 5.93324C46.5868 5.58381 46.0328 5.40909 45.3596 5.40909C44.6863 5.40909 44.1323 5.58381 43.6976 5.93324C43.263 6.28267 42.9412 6.74077 42.7324 7.30753C42.5236 7.87429 42.4192 8.4858 42.4192 9.14205C42.4192 9.7983 42.5236 10.4077 42.7324 10.9702C42.9412 11.5327 43.263 11.9865 43.6976 12.3317C44.1323 12.6768 44.6863 12.8494 45.3596 12.8494ZM52.1112 14V4.18182H53.5685V5.66477H53.6708C53.8498 5.17898 54.1737 4.7848 54.6424 4.48224C55.1112 4.17969 55.6396 4.02841 56.2276 4.02841C56.3384 4.02841 56.4769 4.03054 56.6431 4.0348C56.8093 4.03906 56.935 4.04545 57.0202 4.05398V5.58807C56.9691 5.57528 56.8519 5.55611 56.6687 5.53054C56.4897 5.50071 56.3001 5.4858 56.0998 5.4858C55.6225 5.4858 55.1964 5.58594 54.8214 5.78622C54.4506 5.98224 54.1566 6.25497 53.9393 6.6044C53.7262 6.94957 53.6197 7.34375 53.6197 7.78693V14H52.1112ZM64.0755 14V0.909091H68.4988C69.5257 0.909091 70.3652 1.09446 71.0172 1.4652C71.6735 1.83168 72.1593 2.32812 72.4746 2.95455C72.79 3.58097 72.9476 4.27983 72.9476 5.05114C72.9476 5.82244 72.79 6.52344 72.4746 7.15412C72.1635 7.7848 71.682 8.28764 71.03 8.66264C70.378 9.03338 69.5428 9.21875 68.5243 9.21875H65.3539V7.8125H68.4732C69.1763 7.8125 69.7409 7.69105 70.1671 7.44815C70.5932 7.20526 70.9022 6.87713 71.0939 6.46378C71.29 6.04616 71.388 5.57528 71.388 5.05114C71.388 4.52699 71.29 4.05824 71.0939 3.64489C70.9022 3.23153 70.5911 2.90767 70.1607 2.6733C69.7303 2.43466 69.1593 2.31534 68.4476 2.31534H65.6607V14H64.0755ZM76.8052 8.09375V14H75.2967V0.909091H76.8052V5.71591H76.9331C77.1632 5.20881 77.5083 4.80611 77.9686 4.50781C78.4331 4.20526 79.051 4.05398 79.8223 4.05398C80.4913 4.05398 81.0772 4.18821 81.5801 4.45668C82.0829 4.72088 82.4728 5.12784 82.7498 5.67756C83.0311 6.22301 83.1717 6.91761 83.1717 7.76136V14H81.6632V7.86364C81.6632 7.08381 81.4608 6.48082 81.0559 6.05469C80.6554 5.62429 80.0993 5.40909 79.3876 5.40909C78.8933 5.40909 78.4501 5.51349 78.0581 5.7223C77.6703 5.93111 77.3635 6.2358 77.1376 6.63636C76.916 7.03693 76.8052 7.52273 76.8052 8.09375ZM89.9201 14.2045C89.0337 14.2045 88.256 13.9936 87.587 13.5717C86.9222 13.1499 86.4023 12.5597 86.0273 11.8011C85.6566 11.0426 85.4712 10.1562 85.4712 9.14205C85.4712 8.11932 85.6566 7.22656 86.0273 6.46378C86.4023 5.70099 86.9222 5.10866 87.587 4.68679C88.256 4.26491 89.0337 4.05398 89.9201 4.05398C90.8065 4.05398 91.582 4.26491 92.2468 4.68679C92.9158 5.10866 93.4357 5.70099 93.8065 6.46378C94.1815 7.22656 94.369 8.11932 94.369 9.14205C94.369 10.1562 94.1815 11.0426 93.8065 11.8011C93.4357 12.5597 92.9158 13.1499 92.2468 13.5717C91.582 13.9936 90.8065 14.2045 89.9201 14.2045ZM89.9201 12.8494C90.5934 12.8494 91.1474 12.6768 91.582 12.3317C92.0167 11.9865 92.3384 11.5327 92.5472 10.9702C92.756 10.4077 92.8604 9.7983 92.8604 9.14205C92.8604 8.4858 92.756 7.87429 92.5472 7.30753C92.3384 6.74077 92.0167 6.28267 91.582 5.93324C91.1474 5.58381 90.5934 5.40909 89.9201 5.40909C89.2468 5.40909 88.6928 5.58381 88.2582 5.93324C87.8235 6.28267 87.5018 6.74077 87.293 7.30753C87.0842 7.87429 86.9798 8.4858 86.9798 9.14205C86.9798 9.7983 87.0842 10.4077 87.293 10.9702C87.5018 11.5327 87.8235 11.9865 88.2582 12.3317C88.6928 12.6768 89.2468 12.8494 89.9201 12.8494ZM100.942 4.18182V5.46023H95.8535V4.18182H100.942ZM97.3365 1.82955H98.845V11.1875C98.845 11.6136 98.9068 11.9332 99.0304 12.1463C99.1582 12.3551 99.3201 12.4957 99.5162 12.5682C99.7164 12.6364 99.9274 12.6705 100.149 12.6705C100.315 12.6705 100.452 12.6619 100.558 12.6449C100.665 12.6236 100.75 12.6065 100.814 12.5938L101.121 13.9489C101.018 13.9872 100.876 14.0256 100.692 14.0639C100.509 14.1065 100.277 14.1278 99.9956 14.1278C99.5694 14.1278 99.1518 14.0362 98.7427 13.853C98.3379 13.6697 98.0012 13.3906 97.7328 13.0156C97.4686 12.6406 97.3365 12.1676 97.3365 11.5966V1.82955ZM107.094 14.2045C106.208 14.2045 105.43 13.9936 104.761 13.5717C104.096 13.1499 103.576 12.5597 103.201 11.8011C102.83 11.0426 102.645 10.1562 102.645 9.14205C102.645 8.11932 102.83 7.22656 103.201 6.46378C103.576 5.70099 104.096 5.10866 104.761 4.68679C105.43 4.26491 106.208 4.05398 107.094 4.05398C107.98 4.05398 108.756 4.26491 109.421 4.68679C110.09 5.10866 110.61 5.70099 110.98 6.46378C111.355 7.22656 111.543 8.11932 111.543 9.14205C111.543 10.1562 111.355 11.0426 110.98 11.8011C110.61 12.5597 110.09 13.1499 109.421 13.5717C108.756 13.9936 107.98 14.2045 107.094 14.2045ZM107.094 12.8494C107.767 12.8494 108.321 12.6768 108.756 12.3317C109.191 11.9865 109.512 11.5327 109.721 10.9702C109.93 10.4077 110.034 9.7983 110.034 9.14205C110.034 8.4858 109.93 7.87429 109.721 7.30753C109.512 6.74077 109.191 6.28267 108.756 5.93324C108.321 5.58381 107.767 5.40909 107.094 5.40909C106.421 5.40909 105.867 5.58381 105.432 5.93324C104.997 6.28267 104.676 6.74077 104.467 7.30753C104.258 7.87429 104.154 8.4858 104.154 9.14205C104.154 9.7983 104.258 10.4077 104.467 10.9702C104.676 11.5327 104.997 11.9865 105.432 12.3317C105.867 12.6768 106.421 12.8494 107.094 12.8494Z" fill="#E70F88" />
                                                    <path d="M134.585 14V0.909091H136.17V12.5938H142.256V14H134.585ZM144.506 14V4.18182H146.014V14H144.506ZM145.273 2.54545C144.979 2.54545 144.725 2.44531 144.512 2.24503C144.303 2.04474 144.199 1.80398 144.199 1.52273C144.199 1.24148 144.303 1.00071 144.512 0.800426C144.725 0.600142 144.979 0.5 145.273 0.5C145.567 0.5 145.818 0.600142 146.027 0.800426C146.24 1.00071 146.347 1.24148 146.347 1.52273C146.347 1.80398 146.24 2.04474 146.027 2.24503C145.818 2.44531 145.567 2.54545 145.273 2.54545ZM150.286 8.09375V14H148.777V4.18182H150.235V5.71591H150.362C150.593 5.21733 150.942 4.81676 151.411 4.5142C151.879 4.20739 152.485 4.05398 153.226 4.05398C153.891 4.05398 154.472 4.19034 154.971 4.46307C155.47 4.73153 155.857 5.14062 156.134 5.69034C156.411 6.2358 156.55 6.92614 156.55 7.76136V14H155.041V7.86364C155.041 7.09233 154.841 6.49148 154.441 6.06108C154.04 5.62642 153.49 5.40909 152.791 5.40909C152.31 5.40909 151.879 5.51349 151.5 5.7223C151.125 5.93111 150.829 6.2358 150.612 6.63636C150.394 7.03693 150.286 7.52273 150.286 8.09375ZM160.713 10.4205L160.687 8.55398H160.994L165.289 4.18182H167.156L162.579 8.80966H162.451L160.713 10.4205ZM159.306 14V0.909091H160.815V14H159.306ZM165.545 14L161.71 9.14205L162.784 8.09375L167.463 14H165.545ZM178.43 4.18182V5.46023H173.342V4.18182H178.43ZM174.825 1.82955H176.333V11.1875C176.333 11.6136 176.395 11.9332 176.519 12.1463C176.646 12.3551 176.808 12.4957 177.004 12.5682C177.205 12.6364 177.416 12.6705 177.637 12.6705C177.803 12.6705 177.94 12.6619 178.046 12.6449C178.153 12.6236 178.238 12.6065 178.302 12.5938L178.609 13.9489C178.507 13.9872 178.364 14.0256 178.181 14.0639C177.997 14.1065 177.765 14.1278 177.484 14.1278C177.058 14.1278 176.64 14.0362 176.231 13.853C175.826 13.6697 175.49 13.3906 175.221 13.0156C174.957 12.6406 174.825 12.1676 174.825 11.5966V1.82955ZM184.582 14.2045C183.696 14.2045 182.918 13.9936 182.249 13.5717C181.584 13.1499 181.064 12.5597 180.689 11.8011C180.319 11.0426 180.133 10.1562 180.133 9.14205C180.133 8.11932 180.319 7.22656 180.689 6.46378C181.064 5.70099 181.584 5.10866 182.249 4.68679C182.918 4.26491 183.696 4.05398 184.582 4.05398C185.469 4.05398 186.244 4.26491 186.909 4.68679C187.578 5.10866 188.098 5.70099 188.469 6.46378C188.844 7.22656 189.031 8.11932 189.031 9.14205C189.031 10.1562 188.844 11.0426 188.469 11.8011C188.098 12.5597 187.578 13.1499 186.909 13.5717C186.244 13.9936 185.469 14.2045 184.582 14.2045ZM184.582 12.8494C185.256 12.8494 185.809 12.6768 186.244 12.3317C186.679 11.9865 187.001 11.5327 187.209 10.9702C187.418 10.4077 187.523 9.7983 187.523 9.14205C187.523 8.4858 187.418 7.87429 187.209 7.30753C187.001 6.74077 186.679 6.28267 186.244 5.93324C185.809 5.58381 185.256 5.40909 184.582 5.40909C183.909 5.40909 183.355 5.58381 182.92 5.93324C182.486 6.28267 182.164 6.74077 181.955 7.30753C181.746 7.87429 181.642 8.4858 181.642 9.14205C181.642 9.7983 181.746 10.4077 181.955 10.9702C182.164 11.5327 182.486 11.9865 182.92 12.3317C183.355 12.6768 183.909 12.8494 184.582 12.8494ZM196.396 14V4.18182H197.854V5.71591H197.982C198.186 5.19176 198.516 4.7848 198.972 4.49503C199.428 4.20099 199.976 4.05398 200.615 4.05398C201.263 4.05398 201.802 4.20099 202.232 4.49503C202.667 4.7848 203.006 5.19176 203.249 5.71591H203.351C203.602 5.20881 203.979 4.80611 204.482 4.50781C204.985 4.20526 205.588 4.05398 206.291 4.05398C207.169 4.05398 207.887 4.32884 208.445 4.87855C209.004 5.42401 209.283 6.27415 209.283 7.42898V14H207.774V7.42898C207.774 6.70455 207.576 6.18679 207.18 5.87571C206.783 5.56463 206.317 5.40909 205.78 5.40909C205.089 5.40909 204.555 5.6179 204.175 6.03551C203.796 6.44886 203.607 6.97301 203.607 7.60795V14H202.072V7.27557C202.072 6.71733 201.891 6.26776 201.529 5.92685C201.167 5.58168 200.7 5.40909 200.129 5.40909C199.737 5.40909 199.371 5.51349 199.03 5.7223C198.693 5.93111 198.42 6.22088 198.212 6.59162C198.007 6.9581 197.905 7.3821 197.905 7.86364V14H196.396ZM216.157 14.2045C215.211 14.2045 214.395 13.9957 213.709 13.5781C213.027 13.1562 212.501 12.5682 212.13 11.8139C211.764 11.0554 211.581 10.1733 211.581 9.16761C211.581 8.16193 211.764 7.27557 212.13 6.50852C212.501 5.73722 213.017 5.13636 213.677 4.70597C214.342 4.27131 215.118 4.05398 216.004 4.05398C216.515 4.05398 217.02 4.1392 217.519 4.30966C218.017 4.48011 218.471 4.7571 218.88 5.14062C219.289 5.51989 219.615 6.02273 219.858 6.64915C220.101 7.27557 220.223 8.04687 220.223 8.96307V9.60227H212.654V8.2983H218.689C218.689 7.74432 218.578 7.25 218.356 6.81534C218.139 6.38068 217.828 6.03764 217.423 5.78622C217.022 5.5348 216.549 5.40909 216.004 5.40909C215.403 5.40909 214.883 5.55824 214.444 5.85653C214.01 6.15057 213.675 6.53409 213.441 7.0071C213.206 7.48011 213.089 7.98722 213.089 8.52841V9.39773C213.089 10.1392 213.217 10.7678 213.473 11.2834C213.733 11.7947 214.093 12.1847 214.553 12.4531C215.013 12.7173 215.548 12.8494 216.157 12.8494C216.554 12.8494 216.912 12.794 217.231 12.6832C217.555 12.5682 217.834 12.3977 218.069 12.1719C218.303 11.9418 218.484 11.6562 218.612 11.3153L220.069 11.7244C219.916 12.2188 219.658 12.6534 219.296 13.0284C218.934 13.3991 218.486 13.6889 217.953 13.8977C217.421 14.1023 216.822 14.2045 216.157 14.2045ZM224.026 8.09375V14H222.517V4.18182H223.975V5.71591H224.103C224.333 5.21733 224.682 4.81676 225.151 4.5142C225.62 4.20739 226.225 4.05398 226.966 4.05398C227.631 4.05398 228.213 4.19034 228.711 4.46307C229.21 4.73153 229.598 5.14062 229.875 5.69034C230.152 6.2358 230.29 6.92614 230.29 7.76136V14H228.782V7.86364C228.782 7.09233 228.581 6.49148 228.181 6.06108C227.78 5.62642 227.23 5.40909 226.532 5.40909C226.05 5.40909 225.62 5.51349 225.24 5.7223C224.865 5.93111 224.569 6.2358 224.352 6.63636C224.135 7.03693 224.026 7.52273 224.026 8.09375ZM239.234 9.9858V4.18182H240.743V14H239.234V12.3381H239.132C238.902 12.8366 238.544 13.2607 238.058 13.6101C237.572 13.9553 236.959 14.1278 236.217 14.1278C235.604 14.1278 235.058 13.9936 234.581 13.7251C234.104 13.4524 233.729 13.0433 233.456 12.4979C233.183 11.9482 233.047 11.2557 233.047 10.4205V4.18182H234.555V10.3182C234.555 11.0341 234.756 11.6051 235.156 12.0312C235.561 12.4574 236.077 12.6705 236.703 12.6705C237.078 12.6705 237.459 12.5746 237.847 12.3828C238.239 12.1911 238.567 11.897 238.831 11.5007C239.1 11.1044 239.234 10.5994 239.234 9.9858Z" fill="#603813" />
                                                    <line x1="122" y1="29.5" x2="858" y2="29.5001" stroke="#E9E0DA" stroke-width="3" />
                                                    <line x1="122" y1="29.5" x2="-1.31134e-07" y2="29.5" stroke="#E70F88" stroke-width="3" />
                                                </svg>
                                                <div id="dropzone1" class="mt-4">
                                                    <FORM class="dropzone needsclick" id="demo-upload" action="/upload">
                                                        <DIV class="dz-message needsclick">
                                                            Drag and drop a PDF, JPG or TIFF<BR>
                                                            <SPAN class="note needsclick">File type recommended PNG or JPEG
                                                            </SPAN>
                                                        </DIV>
                                                    </FORM>
                                                </div>
                                            </div>
                                        </section>
                                    </section>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="form-group checkbox_area  mb-5 mt-5 text-start">
                                        <label> <input type="checkbox" class="p-4 position-absolute"><span style="padding-left: 50px;color: #603813;
font-family: Inter;
font-size: 18px;
font-style: normal;
font-weight: 400;
line-height: normal;
display:block;"> You agree for the Tourism Enhancement Fund an agency of the Ministry of Tourism to use your data to display on www.tastejamaica.com and the Taste Jamaica mobile app.</span></label>
                                    </div>
                                    <button class="submit_button btn load_more d-block ms-auto float-end py-3 px-5 mb-5" name="command" value="insert_preview">Preview Submission</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <?php include 'includes/footer.php' ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
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
    </script>
    <script>
  function initMap() {
    // Initialize the map
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 8
    });

    // Initialize the Places service
    var placesService = new google.maps.places.PlacesService(map);

    // Initialize the autocomplete for the address input
    var autocomplete = new google.maps.places.Autocomplete(document.getElementById('addressInput'));

    // Set the bounds of the map for autocomplete predictions
    autocomplete.bindTo('bounds', map);

    // Listen for the event when a place is selected
    autocomplete.addListener('place_changed', function() {
      var place = autocomplete.getPlace();

      // If the place has a geometry, set the map's center to that location
      if (place.geometry) {
        map.setCenter(place.geometry.location);
        map.setZoom(15); // You can adjust the zoom level as needed
      }
    });

    // Listen for the click event on the map
    map.addListener('click', function(event) {
      // Clear the previous marker
      marker.setMap(null);

      // Create a new marker at the clicked location
      var marker = new google.maps.Marker({
        position: event.latLng,
        map: map
      });

      // Reverse geocode the clicked location to get the address
      var geocoder = new google.maps.Geocoder;
      geocoder.geocode({'location': event.latLng}, function(results, status) {
        if (status === 'OK') {
          if (results[0]) {
            // Set the address input value
            document.getElementById('addressInput').value = results[0].formatted_address;
          } else {
            window.alert('No results found');
          }
        } else {
          window.alert('Geocoder failed due to: ' + status);
        }
      });
    });
  }
</script>

<!-- Include the Google Maps API script with your API key -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHYsfQDOv2XtJLK9riols1AZOfmtGUykM&libraries=places&callback=initMap" async defer></script>
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
    </style>
</body>

</html>