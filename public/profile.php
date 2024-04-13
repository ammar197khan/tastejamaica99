<?php
include 'includes/config/common-files.php';
$a->authenticate();
// die('here we are ');
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>

    <title>Profile</title>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section class="main_section position-relative mb-5 pb-5">
        <div class="bg_images_area">

            <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

            <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
        </div>
        <div class="container position-relative ">
            <div class="row g-5">

                <div class="col-lg-3 pt-5">
                    <div class="card border-0 shadow mt-5">
                        <div class="card-body py-5">
                            <div class="profile_image text-center">
                                <svg width="137" height="136" viewBox="0 0 137 136" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <ellipse cx="68.5" cy="68" rx="68.5" ry="68" fill="#D9D9D9" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M70 59.9999C58.9175 59.9999 49.9048 51.0299 49.9048 39.9999C49.9048 28.9699 58.9175 19.9999 70 19.9999C81.0825 19.9999 90.0952 28.9699 90.0952 39.9999C90.0952 51.0299 81.0825 59.9999 70 59.9999ZM88.8795 63.3648C96.8523 56.9798 101.499 46.6547 99.7912 35.3497C97.8068 22.2347 86.8449 11.7399 73.6122 10.2099C55.3506 8.09488 39.8572 22.2449 39.8572 39.9999C39.8572 49.4499 44.258 57.8698 51.1205 63.3648C34.2606 69.6698 21.9523 84.4749 20.0232 104.455C19.7418 107.41 22.0578 110 25.042 110C27.5991 110 29.7794 108.08 30.0055 105.545C32.0201 83.23 49.1864 69.9999 70 69.9999C90.8137 69.9999 107.98 83.23 109.995 105.545C110.221 108.08 112.401 110 114.958 110C117.942 110 120.258 107.41 119.977 104.455C118.048 84.4749 105.739 69.6698 88.8795 63.3648Z" fill="black" />
                                </svg>

                            </div>
                            <div class="profile_name text-center">
                                <?= $auth_row['f_name'] . ' ' . $auth_row['l_name']; ?>
                            </div>
                            <div class="profile_email text-center">
                                <?= $auth_row['email']; ?>

                            </div>
                            <div class="profile_links mt-4">
                                <ul class="list-unstyled px-3">
                                    <li>
                                        <?php
                                        $profile_detail = $db->fetch_Array_by_query('select * from get_listed where user_id=' . intval($auth_row['id']) . ' order by id desc');
                                        if ($profile_detail) {
                                            $edit_url = "signup_2.php?id=" . intval($profile_detail['id']);
                                        } else {
                                            $edit_url = '#';
                                        }
                                        if($auth_row['user_profile']=='business'){
                                        ?>
                                        <a href="<?= $edit_url; ?>">Edit your Business Listing</a>
                                        <?php } ?>
                                    </li>
                                    <li>
                                        <a onclick="event.preventDefault();confirm('Are you sure to delete your profile ? ') ?  window.location.href='delete-profile.php': '' " href="">Delete Profile</a>
                                    </li>
                                    <li>
                                        <a href="logout.php">Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="main_heading font-sacramento pt-5 mt-5">Search. Discover. Experience</h1>
                            <h2 class="sub_heading font-popinns mb-0">Taste Jamaica</h2>
                            <p class="heading_description mt-0">© Product of Tourism Enhancement Fund</p>
                            <p class="product_text fw-bold text_brown mt-5">Recently Added Culinary Experiences near your location</p>
                        </div>
                        <div class="col-lg-9">

                            <div class="searcharea ">
                                <form action="business-listing.php">
                                    <div class="input-group mb-3 djustify-content-center">
                                        <input type="text" style="max-width: 330px;" name="search_keyword" class="form-control" placeholder="What are you looking for" aria-label="Username">
                                        <input type="hidden" class="hidden-parish-keyword" name="parish" value="" />
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="parish-filter-btn">
                                                Parish
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
                                <div class="search_content" style="max-width: 550px">
                                <?php
                                $db->select('select * from get_listed where approve="yes" order by id desc limit 0,4');
                                $results=$db->fetch_all();
                            foreach ($results as $res) {
                            ?>
                                <div class="row mb-4 g-0 shadow rounded-3" onclick="window.location.href='business-detail.php?id=<?php echo $res['id']; ?>'">
                                    <div class="col-4 position-relative">
                                        <?php
                                        $multi_files = $db->fetch_array_by_query('select * from multi_files where detail_id=' . intval($res['id']));
                                        if($multi_files && $multi_files['files']!=''){
                                            $main_files=explode(',',$multi_files['files']);
                                            $img_src='outer_docx/'.$main_files[0];
                                        }else{
                                            $img_src='assets/images/img_37.png';
                                        }

                                        ?>
                                        <img class="img img-fluid searched_image" src="<?php echo $img_src; ?>" alt="">
                                        <img class="img img-fluid position-absolute save_it" src="assets/images/save_it.png" alt="">
                                    </div>
                                    <div class="col-8 px-2 pt-3 pb-3">
                                        <h4 class="search_title"><?php echo $res['name'] ?></h4>
                                        
                                        <?php $b_types=explode(',',$res['business_type']); ?>
                                        <h5 class="search_content"><?php  foreach($b_types as $b_type){  echo ucwords(str_replace('_', ' ', $b_type)).' , ';}   ?></h5>
                                        <?php $cuisine=explode(',',$res['cuisines']);$counter=0; ?>
                                        <h5 class="search_content" style=" word-break: break-all;"><b style="color: #603813;">Cuisine :</b> <?php foreach($cuisine as $cuis){ ++$counter;if($counter==4){echo '<br>';} echo $cuis.' , ';}  ?><br></h5>
                                        <h5 class="search_content"><b style="color: #603813;">Address :</b> <?php echo $res['address']; ?></h5>
                                        <?php 
                                        /*
                                        <h5 class="search_content"><?php  echo ucwords(str_replace('_', ' ', $res['business_type'])); ?></h5>
                                        <h5 class="search_content">Cuisine: <?php echo $res['cuisines']; ?></h5>
                                        <h5 class="search_content">Address: <?php echo $res['address']; ?></h5>
                                        */
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                               
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