<?php
include 'includes/config/common-files.php';
// $a->authenticate();
// die('here we are ');
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>

    <title>Recipes</title>
    <style>
        
        iframe {
            width: 100%;
            height: 100vh;
            border: none;
            transition: transform 0.5s ease-in-out;
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section class="main_section position-relative mb-5 pb-5">
    <div class="bg_images_area">

        <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

        <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
    </div>
    <div class="container position-relative ">
        <div class="row ">
            <div class="col-md-12">
                <div class="row text-center">
                    <div class="col-md-12 mt-5"><span class="sub_heading fs-60px font-popinns mb-1">TASTE JAMAICA RECIPES</span>
                    </div>

                </div>
            </div>
            <div class="col-md-12 mt-5">
                <!-- <iframe width="100%" height="800" src="https://www.youtube-nocookie.com/embed/DfGYqQzeMZc?si=vnsR9Lzfo3FOCHpt" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->

                    <iframe src="assets/Taste_20Jamaica_20Recepie_20Booklet.pdf" id="pdf-iframe"></iframe>



                <!-- <div class="play_icon" data-fancybox href="https://issuu.com/tourismlinkagesnetwork/docs/taste_jamaica_recepie_booklet">
                    <svg width="49" height="38" viewBox="0 0 49 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M42.8284 0.788971C42.8284 0.788971 36.9443 0 24.3075 0C12.0806 0 5.92616 0.788971 5.92616 0.788971C4.35424 0.789598 2.84691 1.45561 1.7356 2.64056C0.624291 3.8255 3.04601e-07 5.43237 4.14439e-07 7.10783V30.81C-0.000290678 31.6398 0.152763 32.4616 0.450423 33.2283C0.748083 33.9951 1.18452 34.6919 1.73481 35.2788C2.28511 35.8658 2.93849 36.3315 3.65764 36.6494C4.37679 36.9672 5.14764 37.1309 5.92616 37.1313C5.92616 37.1313 11.6484 37.9155 24.3075 37.9155C36.9598 37.9155 42.8284 37.1313 42.8284 37.1313C43.6073 37.1319 44.3786 36.9688 45.0983 36.6513C45.8179 36.3338 46.4718 35.8682 47.0225 35.2811C47.5731 34.6939 48.0097 33.9968 48.3073 33.2296C48.6049 32.4624 48.7576 31.6402 48.7568 30.81V7.1031C48.7568 6.27352 48.6034 5.45207 48.3054 4.6857C48.0074 3.91932 47.5707 3.22305 47.0201 2.63667C46.4695 2.05028 45.816 1.58529 45.0967 1.26825C44.3775 0.951214 43.6067 0.788351 42.8284 0.788971ZM17.8649 28.3463V9.57868L33.6754 18.9566L17.8649 28.3463Z" fill="#E91717" />
                        <path d="M17.5003 9.49984L34.0005 18.9999L17.5 28.5L17.5003 9.49984Z" fill="white" />
                    </svg>
                </div>  -->

            </div>
        </div>
    </div>
</section>

    <?php include 'includes/footer.php' ?>
    <script>
        const iframe = document.getElementById('pdf-iframe');
        let currentPage = 1;

        document.addEventListener('keydown', function (e) {
            if (e.keyCode === 37) { // Left arrow key
                navigatePage(-1);
            } else if (e.keyCode === 39) { // Right arrow key
                navigatePage(1);
            }
        });

        function navigatePage(direction) {
            currentPage += direction;
            if (currentPage < 1) {
                currentPage = 1;
            } else if (currentPage > getTotalPages()) {
                currentPage = getTotalPages();
            }

            const transformValue = `translateX(${-100 * (currentPage - 1)}vw)`;
            iframe.style.transform = transformValue;
        }

        function getTotalPages() {
            // You may need to adjust this based on your PDF document
            return 10; // Replace with the total number of pages in your PDF
        }
    </script>
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
    </script>

</body>

</html>