<?php 
    include 'includes/config/common-files.php';
    // die('here we are ');

    define('FILE_URL', 'admin/file_docx/');
    define('FILE_DIR', 'admin/file_docx/');
    
?>
<!doctype html>
<html lang="en">

<head>
   <?php include 'includes/site-master.php' ?>
     
    <title>Homepage</title>
  
</head>

<body>
   <?php include 'includes/header.php' ?>
    
    <section class="main_section position-relative mb-3 pb-0">
        <div class="bg_images_area">

            <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

            <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
        </div>
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="main_heading font-sacramento">Search. Discover. Experience</h1>
                    <h2 class="sub_heading font-popinns mb-1">Taste Jamaica</h2>
                    <p class="heading_description mt-0">© Product of Tourism Enhancement Fund</p>
                    <div class="searcharea mt-5">
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
                                        foreach($parish_dropdown as $parish_option){
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

                        <p class="text_info">Discover Top rated Restaurants, Bars, Street Food <br>
                            & Culinary Trails around Jamaica</p>

                    </div>
                </div>
                <div class="col-lg-6 mt-5 only_pc">
                    <img src="assets/images/header_main.png" class="img img-fluid mt-5" alt="">
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="section_heading_box">
                        <h4 class="info_heading font-sacramento mb-0">Taste the </h4>
                        <h2 class="main_box_heading font-popinns">BEst of Jamaica</h2>
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-3 mb-3">
                            <div class="menu_image_area position-relative">
                                <img class="img img-fluid" src="assets/images/img.png" alt="">
                                <div class="menu_title text-center position-absolute" onclick="window.location.href='business-listing.php?search_keyword=RestaurAnt'">RestaurAnt</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 col-3">
                            <div class="menu_image_area position-relative">
                                <img class="img img-fluid" src="assets/images/img_1.png" alt="">
                                <div class="menu_title text-center position-absolute"  onclick="window.location.href='business-listing.php?search_keyword=BAr'">BAr</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 col-3">
                            <div class="menu_image_area position-relative">
                                <img class="img img-fluid" src="assets/images/img_2.png" alt="">
                                <div class="menu_title text-center position-absolute" onclick="window.location.href='business-listing.php?search_keyword=Street Food'">Street Food</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 col-3">
                            <div class="menu_image_area position-relative">
                                <img class="img img-fluid" src="assets/images/img_3.png" alt="">
                                <div class="menu_title text-center position-absolute" onclick="window.location.href='business-listing.php?search_keyword=CAFE'">CAFE</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg_box pb-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="section_heading_box">
                        <h4 class="info_heading font-sacramento mb-0">Visit</h4>
                        <h2 class="main_box_heading font-popinns">DEVON HOUSE</h2>
                    </div>
                    <p class="section_devon_text mt-5">
                        Devon House has so much in store! Designated as a gastronomy centre in 2017, the Devon House grounds
                        are full of amazing eateries offering up everything from classic Jamaican dishes to a taste of Italy
                        and France. The Devon House mansion is a beautiful blend of Caribbean and Georgian architecture,
                        furnished with an expertly curated collection of Jamaican, English and French antique pieces and
                        reproductions.
                    </p>
                </div>
                <div class="col-md-6">
                    <a target="_blank" href="https://www.devonhouseja.com/"><img src="assets/images/devon.png" class="img img-fluid" alt=""></a>
                </div>
                <div class="col-12 mt-5">
                    <div class="row">
                        <div class="col-md-12"><span class="sub_heading fs-60px font-popinns mb-1">MADE IN JAMAICA PRODUCTS </span><a href="products.php" class="see_more btn">See More</a></div>

                    </div>
                    <div class="row mt-5">
                        <?php 
                        $db->select('select * from jamaica_products order by id desc limit 0,4');
                        $jamaica_products=$db->fetch_all();
                        foreach($jamaica_products as $j_products){
                        ?>
                        <div class="col-lg-3 col-md-6 col-3 mb-3">
                            <div class="position-relative">
                                <img class="img img-fluid" style="border-radius: 15px;" src="admin/file_docx/<?php echo $j_products['image']; ?>" alt="">
                            </div>
                        </div>
                        <?php } ?>
                  
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg_right_tree mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section_heading_box text-center">
                        <h4 class="info_heading font-sacramento mb-0">Quick Access to</h4>
                        <h2 class="main_box_heading font-popinns">Delivery Services</h2>
                    </div>

                </div>

                <div class="col-12 mt-5">
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
    </section>
    <section class=" mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="section_heading_box text-center">
                        <h4 class="info_heading font-sacramento mb-0">Enjoy Culinary action on </h4>
                        <h2 class="main_box_heading font-popinns">TASTE Jamaica TV </h2>
                    </div>

                </div>
                <div class="col-12">
                </div>

            </div>
        </div>


        <div class="wrap">
            <div class="slider">
                <?php 
                    $db->select('select * from jamaica_tv order by id desc limit 0,4');
                    $jamaica_tvs=$db->fetch_all();
                    foreach($jamaica_tvs as $jamaica_tv){
                ?>
                    <div class="item position-relative">
                        <div class="play_icon" data-fancybox href="<?= $jamaica_tv['video_link'] ?>">
                            <svg width="49" height="38" viewBox="0 0 49 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M42.8284 0.788971C42.8284 0.788971 36.9443 0 24.3075 0C12.0806 0 5.92616 0.788971 5.92616 0.788971C4.35424 0.789598 2.84691 1.45561 1.7356 2.64056C0.624291 3.8255 3.04601e-07 5.43237 4.14439e-07 7.10783V30.81C-0.000290678 31.6398 0.152763 32.4616 0.450423 33.2283C0.748083 33.9951 1.18452 34.6919 1.73481 35.2788C2.28511 35.8658 2.93849 36.3315 3.65764 36.6494C4.37679 36.9672 5.14764 37.1309 5.92616 37.1313C5.92616 37.1313 11.6484 37.9155 24.3075 37.9155C36.9598 37.9155 42.8284 37.1313 42.8284 37.1313C43.6073 37.1319 44.3786 36.9688 45.0983 36.6513C45.8179 36.3338 46.4718 35.8682 47.0225 35.2811C47.5731 34.6939 48.0097 33.9968 48.3073 33.2296C48.6049 32.4624 48.7576 31.6402 48.7568 30.81V7.1031C48.7568 6.27352 48.6034 5.45207 48.3054 4.6857C48.0074 3.91932 47.5707 3.22305 47.0201 2.63667C46.4695 2.05028 45.816 1.58529 45.0967 1.26825C44.3775 0.951214 43.6067 0.788351 42.8284 0.788971ZM17.8649 28.3463V9.57868L33.6754 18.9566L17.8649 28.3463Z" fill="#E91717" />
                                <path d="M17.5003 9.49984L34.0005 18.9999L17.5 28.5L17.5003 9.49984Z" fill="white" />
                            </svg>

                        </div>
                        <img class="img img-fluid" style="border-radius: 25px;" src="<?= FILE_DIR.$jamaica_tv['image'] ?>" alt="">
                        <div class="slide_youtube_part">
                            <div class="row">
                                <div class="col-3">
                                    <img class="img img-fluid" src="assets/images/logo.png" alt="">
                                </div>
                                <div class="col-9">
                                    <p><?= $jamaica_tv['title'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>



    </section>
    <section class=" bubble_right mt-5 ">
        <div class="container mt-5">
            <div class=" cuisines row">
                <div class="col-md-12 mb-3 mt-5">
                    <div class="section_heading_box text-center mt-5">
                        <h4 class="info_heading font-sacramento mb-0">Best</h4>
                        <h2 class="main_box_heading font-popinns">Cuisines</h2>
                    </div>

                </div>
                <div class="col-12">
                    <div class="row align-content-center justify-content-center">
                        <div class="col-lg-3 col-md-6 col-3 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=Jamaican'">
                                <img class="img img-fluid" src="assets/images/img_55.png" alt="">
                                <div class="menu_title text-center position-absolute">Jamaican</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-3 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=Chinese'">
                                <img class="img img-fluid" src="assets/images/img_56.png" alt="">
                                <div class="menu_title text-center position-absolute">Chinese</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-3 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=Japanese'">
                                <img class="img img-fluid" src="assets/images/img_57.png" alt="">
                                <div class="menu_title text-center position-absolute">Japanese</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-3 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=VegaN'">
                                <img class="img img-fluid" src="assets/images/img_58.png" alt="">
                                <div class="menu_title text-center position-absolute">VegaN</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-4 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=INTERNATIONAL'">
                                <img class="img img-fluid" src="assets/images/img_59.png" alt="">
                                <div class="menu_title text-center position-absolute">INTERNATIONAL</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-3 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=Indian'">
                                <img class="img img-fluid" src="assets/images/img_60.png" alt="">
                                <div class="menu_title text-center position-absolute">Indian</div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-3 mb-5">
                            <div class="menu_image_area position-relative" onclick="window.location.href='business-listing.php?search_keyword=Mexican'">
                                <img class="img img-fluid" src="assets/images/img_61.png" alt="">
                                <div class="menu_title text-center position-absolute">Mexican</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">

                <div class="col-md-12 mb-3 mt-5">
                    <div class="section_heading_box text-center mt-5" >
                        <h4 class="info_heading font-sacramento mb-2">Culinary &emsp;&emsp;&emsp;&emsp;&emsp;</h4>
                        <h2 class="main_box_heading font-popinns">EXPERIENCES</h2>
                    </div>
                </div>
                <div class="col-12">

                    <div class="row g-5">
                        <div class="col-md-4 text-center" onclick="window.location.href='business-listing.php?search_keyword=Farm to Table'">
                            <img class="img-fluid mb-3" src="assets/images/img_25.png" alt="">
                            <div class="exp_title mb-3">
                                Farm to Table
                            </div>
                            <p class="text_experic mb-3">
                                Experience delightful culinary journey that emphasizes on locally sourced, fresh, and often
                                organic ingredients in the food you eat.
                            </p>
                        </div>
                        <div class="col-md-4 text-center" onclick="window.location.href='business-listing.php?search_keyword=Culinary Trail'">
                            <img class="img-fluid mb-3" src="assets/images/img_26.png" alt="">
                            <div class="exp_title mb-3">
                                Culinary Trails
                            </div>
                            <p class="text_experic mb-3">
                                These trails allow you to explore the island's rich culinary traditions, savor local dishes, and
                                learn about the cultural influences that have shaped Jamaican food. </p>
                        </div>
                        <div class="col-md-4 text-center" onclick="window.location.href='business-listing.php?search_keyword=Blue Mountain Coffee'">
                            <img class="img-fluid mb-3" src="assets/images/img_27.png" alt="">
                            <div class="exp_title mb-3">
                                Blue Mountain Coffee
                            </div>
                            <p class="text_experic mb-3">
                                The Blue Mountain coffee experience in Jamaica is a must for coffee enthusiasts and those
                                seeking a unique culinary adventure. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class=" tree_left mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="section_heading_box text-center">
                        <h4 class="info_heading font-sacramento mb-0">Simple & Easy</h4>
                        <h2 class="main_box_heading font-popinns">How it Works</h2>
                    </div>

                </div>
                <div class="col-12 how_it_works">

                    <div class="row g-5">
                        <div class="col-md-4 text-center">
                            <img class="img-fluid mb-3" src="assets/images/img_28.png" alt="">
                            <div class="exp_title mb-3">
                                Search Locations
                            </div>
                            <p class="text_experic mb-3">
                                You can search for locations near or far. Based on your preference, we will display a list
                                of Jamaican experiences for you to choose. </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <img class="img-fluid mb-3" src="assets/images/img_29.png" alt="">
                            <div class="exp_title mb-3">
                                View Location Info
                            </div>
                            <p class="text_experic mb-3">
                                When you have found your heart's desire, you can click to find out more details on the
                                location.
                        </div>
                        <div class="col-md-4 text-center">
                            <img class="img-fluid mb-3" src="assets/images/img_30.png" alt="">
                            <div class="exp_title mb-3">
                                Scan QR code for Menu
                            </div>
                            <p class="text_experic mb-3">
                                Share the details of the restaurant with your friends.
                            </p>
                        </div>
                    </div>
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

        function getParish(val,parish){
            event.preventDefault();
            console.log(parish);
            $('#parish-filter-btn').html('');
            $('#parish-filter-btn').html(parish);
            if(parish=='Parish'){
                $('#parish-filter-btn').html('All');
            $('.hidden-parish-keyword').val('');
            }else{
            $('.hidden-parish-keyword').val(parish);
            }

        }
    </script>
</body>

</html>