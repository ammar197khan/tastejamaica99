<?php
    include 'includes/config/common-files.php';
    $a->authenticate();

    define('FILE_URL', 'admin/file_docx/');
    define('FILE_DIR', 'admin/file_docx/');

    $data_row = $db->fetch_array_by_query('select * from news where id='.intval($_REQUEST['id']).' order by id desc');


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
    <div class="container position-relative single_post">
        <div class="row " style="max-width: 700px;margin: auto">
            <div class="col-12 post">
                <div class="post_image mt-5 pt-5">
                    <img src="<?= FILE_DIR.$data_row['image'] ?>" alt="" class="img-fluid">
                </div>
                <h2 class="post_title mt-5 text-center mb-4">
                    <?= ucwords($data_row['name']) ?>
                </h2>
                <p class="post_content">
                    <?= ucwords($data_row['content']) ?>
                </p>
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
