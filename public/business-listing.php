<?php
include 'includes/config/common-files.php';
// $a->authenticate();
// die('here we are ');
$query = 'select * from get_listed  ';
$where = ' where ';
$and = '  ';
if (isset($_REQUEST['parish']) && $_REQUEST['parish'] != '') {
    $query .= $where . ' parish_type like "%' . $_REQUEST['parish'] . '%"';
    $where = '';
    $and = ' and ';
}
if (isset($_REQUEST['search_keyword']) && $_REQUEST['search_keyword'] != '') {
    $search = str_replace(' ','_',$_REQUEST['search_keyword']);
    $query .= $where . $and . ' ( name like "%' . $search . '%" or discription like "%' . $search . '%" or address like "%' . $search . '%" or business_type like "%' . $search . '%"  )';
    $where = '';
    $and = ' and ';
}

// $query .= $where . $and . ' approve="yes" order by id desc limit 0,10';
$query .= $where . $and . ' approve="yes" order by id desc ';
// echo $query;
// die();
$db->select($query);
$results = $db->fetch_all();

$map_colors = array(
    'red',
    'blue',
    'green',
    'yellow',
    'orange',
    'purple',
    'pink',
    'brown',
    'teal',
    'gray',
);
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>

    <title>Business Listings</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC46_PI75dS4Jv3rIEIeblb3S13bZUFqM0&libraries=places&callback=initMap" async defer></script>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section class="main_section position-relative mb-5 pb-5">
        <div class="bg_images_area">

            <!--        <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">-->

            <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
        </div>
        <div class="container-fluid position-relative ">
            <div class="row">
                <div class="col-lg-4">
                    <div class="searcharea mt-5">
                        <form action="business-listing.php">
                            <div class="input-group mb-3 djustify-content-center">
                                <input type="text" style="max-width: 330px;" name="search_keyword" class="form-control" placeholder="What are you looking for" aria-label="Username" value="<?= $_REQUEST['search_keyword']; ?>">
                                <input type="hidden" class="hidden-parish-keyword" name="parish" value="<?= $_REQUEST['parish']; ?>" />
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="parish-filter-btn">
                                        <?php if (isset($_REQUEST['parish']) && in_array($_REQUEST['parish'], $parish_dropdown)) {
                                            echo $_REQUEST['parish'];
                                        } else {
                                            echo 'Parish';
                                        } ?>

                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="getParish(this,'Parish')">All</a></li>
                                        <?php
                                        foreach ($parish_dropdown as $parish_option) {
                                        ?>
                                            <li><a class="dropdown-item" href="#" onclick="getParish(this,'<?= $parish_option; ?>')"><?= $parish_option; ?></a></li>
                                        <?php } ?>

                                    </ul>
                                </div>
                                <button class="input-group-text" type="submit">
                                    <svg width="23" height="25" viewBox="0 0 23 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22.6406 23.4922L15.5156 15.7109C16.3125 14.8672 16.9219 13.9141 17.3438 12.8516C17.7812 11.7891 18 10.6719 18 9.5C18 8.29688 17.7734 7.14844 17.3203 6.05469C16.8672 4.96094 16.2188 3.98437 15.375 3.125C14.5156 2.28125 13.5391 1.63281 12.4453 1.17969C11.3516 0.726562 10.2031 0.5 9 0.5C7.79688 0.5 6.64844 0.726562 5.55469 1.17969C4.46094 1.63281 3.49219 2.28125 2.64844 3.125C1.78906 3.98437 1.13281 4.96094 0.679688 6.05469C0.226562 7.14844 0 8.29688 0 9.5C0 10.7031 0.226562 11.8516 0.679688 12.9453C1.13281 14.0391 1.78906 15.0156 2.64844 15.875C3.49219 16.7188 4.46094 17.3672 5.55469 17.8203C6.64844 18.2734 7.79688 18.5 9 18.5C10.0312 18.5 11.0234 18.3359 11.9766 18.0078C12.9453 17.6641 13.8281 17.1719 14.625 16.5312L21.75 24.3125C21.8125 24.375 21.8828 24.4219 21.9609 24.4531C22.0391 24.4844 22.1172 24.5 22.1953 24.5C22.2734 24.5 22.3438 24.4844 22.4062 24.4531C22.4844 24.4375 22.5547 24.3984 22.6172 24.3359C22.7266 24.2266 22.7812 24.0859 22.7812 23.9141C22.7969 23.7578 22.75 23.6172 22.6406 23.4922ZM1.19531 9.5C1.19531 8.42188 1.39844 7.41406 1.80469 6.47656C2.22656 5.52344 2.78906 4.69531 3.49219 3.99219C4.19531 3.28906 5.01562 2.73438 5.95312 2.32812C6.90625 1.90625 7.92188 1.69531 9 1.69531C10.0781 1.69531 11.0859 1.90625 12.0234 2.32812C12.9766 2.73438 13.8047 3.28906 14.5078 3.99219C15.2109 4.69531 15.7656 5.52344 16.1719 6.47656C16.5938 7.41406 16.8047 8.42188 16.8047 9.5C16.8047 10.5781 16.5938 11.5938 16.1719 12.5469C15.7656 13.4844 15.2109 14.3047 14.5078 15.0078C13.8047 15.7109 12.9766 16.2734 12.0234 16.6953C11.0859 17.1016 10.0781 17.3047 9 17.3047C7.92188 17.3047 6.90625 17.1016 5.95312 16.6953C5.01562 16.2734 4.19531 15.7109 3.49219 15.0078C2.78906 14.3047 2.22656 13.4844 1.80469 12.5469C1.39844 11.5938 1.19531 10.5781 1.19531 9.5Z" fill="white" />
                                    </svg>
                                </button>
                            </div>

                        </form>

                        <div class="search_content" style="height: 650px;overflow:scroll;">
                            <?php
                            $count_rows = $db->num_rows($results);
                            $addresses = array();
                            foreach ($results as $res) {
                                $colorIndex = $key % count($map_colors);
                                $addresses[] = array(
                                    'address' => $res['address'], 
                                    'color' => $map_colors[$colorIndex],
                                );
                            ?>
                                <div class="row mb-4 g-0 shadow rounded-3" onclick="window.location.href='business-detail.php?id=<?php echo $res['id']; ?>'">
                                    <div class="col-4 position-relative">
                                        <?php
                                        $multi_files = $db->fetch_array_by_query('select * from multi_files where detail_id=' . intval($res['id']));
                                        if ($multi_files && $multi_files['files'] != '') {
                                            $main_files = explode(',', $multi_files['files']);
                                            $img_src = 'outer_docx/' . $main_files[0];
                                        } else {
                                            $img_src = 'assets/images/img_37.png';
                                        }

                                        ?>
                                        <img class="img img-fluid searched_image" style="height:200px" src="<?php echo $img_src; ?>" alt="">
                                        <img class="img img-fluid position-absolute save_it" src="assets/images/save_it.png" alt="">
                                    </div>
                                    <div class="col-8 px-2 pt-3 pb-3">
                                        <h4 class="search_title"><?php echo $res['name'] ?></h4>
                                        <!-- <h5 class="search_content"><?php //echo ucwords(str_replace('_', ' ', $res['business_type'])); 
                                                                        ?></h5> -->
                                        <?php $b_types = explode(',', $res['business_type']); ?>
                                        <h5 class="search_content"><?php foreach ($b_types as $b_type) {
                                                                        echo ucwords(str_replace('_', ' ', $b_type)) . ' , ';
                                                                    }   ?></h5>
                                        <!-- <h5 class="search_content" style=" word-break: break-all;"><b style="color: #603813;">Cuisine :</b> <?php //echo $res['cuisines']; 
                                                                                                                                                    ?><br></h5> -->
                                        <?php $cuisine = explode(',', $res['cuisines']);
                                        $counter = 0; ?>
                                        <h5 class="search_content" style=" word-break: break-all;"><b style="color: #603813;">Cuisine :</b> <?php foreach ($cuisine as $cuis) {
                                                                                                                                                ++$counter;
                                                                                                                                                if ($counter == 4) {
                                                                                                                                                    echo '<br>';
                                                                                                                                                }
                                                                                                                                                echo $cuis . ' , ';
                                                                                                                                            }  ?><br></h5>
                                        <h5 class="search_content"><b style="color: #603813;">Address :</b> <?php echo $res['address']; ?></h5>
                                    </div>
                                </div>
                            <?php }
                            if ($count_rows == 0) {
                            ?>
                                <div class="row mb-4 g-0 ">
                                    <div class="col-4 position-relative">
                                        <?php

                                        $img_src = 'assets/images/img_37.png';


                                        ?>
                                        <img style="display: none;" class="img img-fluid searched_image" src="<?php echo $img_src; ?>" alt="">
                                        <img style="display: none;" class="img img-fluid position-absolute save_it" src="assets/images/save_it.png" alt="">
                                    </div>
                                    <div class="col-8 px-2 pt-3 pb-3">
                                        <h4 class="search_title">No Record Found</h4>

                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                        <!-- <a href="" class="load_more btn">Load More</a> -->
                    </div>
                </div>
                <div class="col-lg-8">
                    <!-- <iframe class=" mt-5" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3793.561130586922!2d-76.83494992481977!3d18.04555988295831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8edb3e24d0b77df9%3A0xf8e2df169e3296fe!2sRed%20Hills%20Rd%2C%20Kingston%2C%20Jamaica!5e0!3m2!1sen!2s!4v1698350158625!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                    <!-- <iframe class="mt-5" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3793.561130586922!2d-76.83494992481977!3d18.04555988295831!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8edb3e24d0b77df9%3A0xf8e2df169e3296fe!2sRed%20Hills%20Rd%2C%20Kingston%2C%20Jamaica!5e0!3m2!1sen!2s!4v1698350158625!5m2!1sen!2s&markers=color:red%7Clabel:A%7C10+Waterloo+Road,+Jamaica&markers=color:blue%7Clabel:B%7CAnother+Location+Address" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                  
                  <iframe width="100%" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php
                                                                                                                                                        foreach ($addresses as $index => $data_row) {
                                                                                                                                                            echo urlencode($data_row['address']);
                                                                                                                                                            echo "&markers=color:" . $data_row['color'] . "%7Clabel:" . ($index + 1);
                                                                                                                                                            if ($index < count($addresses) - 1) {
                                                                                                                                                                echo "&";
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                        ?>&output=embed"></iframe>


                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="section_heading_box text-lg-center">
                                    <h4 class="info_heading font-sacramento mb-0 font-size-40px">Quick Access to</h4>
                                    <h2 class="main_box_heading font-popinns font-size-40px">Delivery Services</h2>
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="row g-0 delivery_section justify-content-center">
                                    <div class="col-lg-3 col-md-6 col-3 mb-3">
                                        <div class="position-relative">
                                            <a href="https://www.7krave.com/" target="_blank"> <img class="img img-fluid" src="assets/images/delivery_service.png" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-3 mb-3">
                                        <div class=" position-relative">
                                            <a href="https://876get.com/" target="_blank"> <img class="img img-fluid" src="assets/images/img_4.png" alt=""></a>
                                        </div>
                                    </div>
                                    <!--                    <div class="col-lg-3 col-md-6 col-3 mb-3">-->
                                    <!--                        <div class=" position-relative">-->
                                    <!--                            <img class="img img-fluid" src="assets/images/img_5.png" alt="">-->
                                    <!--                        </div>-->
                                    <!--                    </div>-->
                                    <div class="col-lg-3 col-md-6 col-3 mb-3">
                                        <div class=" position-relative">
                                            <a href="https://www.quickcartonline.com/" target="_blank"> <img class="img img-fluid" src="assets/images/img_6.png" alt=""></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php' ?>
    <script>
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

        function getParish(val, parish) {
            event.preventDefault();
            console.log(parish);
            $('#parish-filter-btn').html('');
            $('#parish-filter-btn').html(parish);
            if (parish == 'Parish') {
                $('#parish-filter-btn').html('All');
                $('.hidden-parish-keyword').val('');
            } else {
                $('.hidden-parish-keyword').val(parish);
            }

        }
    </script>

</body>

</html>