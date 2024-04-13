<?php
    include 'includes/config/common-files.php';
    // $a->authenticate();

    define('FILE_URL', 'admin/file_docx/');
    define('FILE_DIR', 'admin/file_docx/');

   $db->select('select * from news order by id desc');
   $data_rows = $db->fetch_all();


?>
<!doctype html>
<html lang="en">
<head>
    <?php include 'includes/site-master.php' ?>
    <title>Blog - list</title>
</head>
<body>
<?php include 'includes/header.php' ?>
<section class="main_section position-relative mb-5 pb-5">
    <div class="bg_images_area">

        <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

        <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
    </div>
    <div class="container position-relative">
        <div class="row">
            <div class="col-lg-6">
                <div class="section_heading_box ">
                    <h4 class="info_heading font-sacramento mb-0">Checkout Our</h4>
                    <h2 class="main_box_heading font-popinns">BLOG UPDATES</h2>
                </div>

            </div>
            <div class="col-lg-6 d-none mt-5">
                <div class="row blog_filter mt-5 d-none">
                    <div class="col-md-6 mt-3">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle " type="button" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                Select Category
                            </button>
                            <ul class="dropdown-menu " data-popper-placement="bottom-start"
                                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 51px);">
                                <li><a class="dropdown-item" href="#">Clarendon</a></li>
                                <li><a class="dropdown-item" href="#">Hanover</a></li>
                                <li><a class="dropdown-item" href="#">Kingston</a></li>
                                <li><a class="dropdown-item" href="#">Manchester</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="dropdown mt-3">
                            <button class="btn btn-secondary dropdown-toggle " type="button" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                Recent
                            </button>
                            <ul class="dropdown-menu " data-popper-placement="bottom-start"
                                style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 51px);">
                                <li><a class="dropdown-item" href="#">Clarendon</a></li>
                                <li><a class="dropdown-item" href="#">Hanover</a></li>
                                <li><a class="dropdown-item" href="#">Kingston</a></li>
                                <li><a class="dropdown-item" href="#">Manchester</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="row g-4 mt-5">
                    <?php
                        foreach($data_rows as $data_row){
                    ?>
                        <div class="col-lg-4 mb-5">
                            <div class="post"  onclick="window.open(<?php echo $data_row['url_path'] ?>,'_blank')">
                                <div class="post_image">
                                    <img  src="<?= FILE_DIR.$data_row['image'] ?>" class="img img-fluid" style="border-radius:25px" alt="">
                                </div>
                                <!-- <h2 onclick="window.location.href='blog_single.php?id=<?php // $data_row['id'] ?>'"  class=" cursor_pointer post_title mt-3 mb-2">
                                    <?php //ucwords($data_row['name']) ?> -->
                                <h2 onclick="window.open('<?php echo $data_row['url_path'] ?>','_blank')"  class=" cursor_pointer post_title mt-3 mb-2">
                                    <?= ucwords($data_row['name']) ?>
                                </h2>
                                <time><i class="fa-solid fa-calendar-days"></i> <?= date('d M Y', $data_row['created_at']) ?></time>
                            </div>
                        </div>
                    <?php } ?>


                    <!-- <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_49.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                J’can-Canadian chef opens culinary doors in Toronto
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_50.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                Jamaican makes success of ‘home restaurant’ in Mexico
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_48.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                Scotch Boyz (4) 5-oz Authentic Jamaican Pepper Sauces on QVC
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_49.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                J’can-Canadian chef opens culinary doors in Toronto
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_50.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                Jamaican makes success of ‘home restaurant’ in Mexico
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_48.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                Scotch Boyz (4) 5-oz Authentic Jamaican Pepper Sauces on QVC
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_49.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                J’can-Canadian chef opens culinary doors in Toronto
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="post">
                            <div class="post_image">
                                <img src="assets/images/img_50.png" class="img img-fluid" alt="">
                            </div>
                            <h2 onclick="window.location.href='blog_single.html'"  class=" cursor_pointer post_title mt-3 mb-2">
                                Jamaican makes success of ‘home restaurant’ in Mexico
                            </h2>
                            <time><i class="fa-solid fa-calendar-days"></i> 03-August-2021</time>
                        </div>
                    </div> -->
                    
                </div>
                <div class="row mt-5 mb-5">
                    <a href="" class="load_more btn btn-link py-3 px-5">&emsp;Load More&emsp;</a>
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
</script>
</body>
</html>
