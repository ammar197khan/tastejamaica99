<?php
include 'includes/config/common-files.php';


?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>

    <title>Business Listings</title>

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
                        <div class="col-md-12 mt-5"><span class="sub_heading fs-60px font-popinns mb-1">MADE IN JAMAICA PRODUCTS</span>
                        </div>

                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <div class="row mb-5">
                        <div class="col-12 section_heading_box">
                            <h2 class="main_box_heading font-popinns">JAMPRO's EXPORT MAX</h2>
                        </div>
                        <div class="col-12">
                            <p class="product_text">
                                The following businesses are participants in the JAMPRO Export Max enterprise development
                                programme, which was launched in 2011. It is designed to develop and support Jamaican
                                high-potential export-ready companies. The current cohort, Export Max III, is being executed
                                under the partnership arrangement between Jamaica Promotions Corporation (JAMPRO) and its
                                partners, the Jamaica Manufacturers and Exporters Association (JMEA), and the Jamaica
                                Business Development Corporation (JBDC).
                            </p>
                        </div>
                        <div class="col-12 products_section">
                            <div class="row mt-5">
                                <?php
                                $db->select('select * from jamaica_products where category="JAMPROS" order by id desc');
                                $j_products = $db->fetch_all();
                                foreach ($j_products as $j_product) {
                                ?>
                                    <div class="col-lg-3 col-md-6 mb-3" onclick="window.open('<?= $j_product['web_site']; ?>','_blank')">
                                        <div class="position-relative">
                                            <img class="img img-fluid" style="border-radius: 15px;" src="admin/file_docx/<?php echo $j_product['image']; ?>" alt="">
                                            <h5 class="product_heading text-center mt-3"><?php echo $j_product['title']; ?></h5>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-12 section_heading_box">
                            <h2 class="main_box_heading font-popinns">CHRISTMAS IN JULY</h2>
                        </div>
                        <div class="col-12">
                            <p class="product_text">
                                This is a collaborative initiative led by the Tourism Linkages Network, a department of the
                                Tourism Enhancement Fund, Jamaica Business Development Corporation (JBDC), Jamaica
                                Manufacturers’ and Exporters Association (JMEA), Jamaica Promotions Corporation (JAMPRO) and
                                the Jamaica Hotel and Tourist Association (JHTA). The programme seeks to provide Jamaican
                                producers of corporate gifts and souvenirs including agro processors, with the opportunity
                                to access alternate market segments specifically tourism.
                            </p>
                        </div>
                        <div class="col-12 products_section">
                            <div class="row mt-5">
                            <?php 
                                $db->select('select * from jamaica_products where category="CHRISTMAS" order by id desc');
                                $c_products=$db->fetch_all();
                                foreach($c_products as $c_product){
                                ?>
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="position-relative" onclick="window.open('<?= $c_product['web_site']; ?>','_blank')">
                                        <img class="img img-fluid" style="border-radius: 15px;" src="admin/file_docx/<?php echo $c_product['image']; ?>" alt="">
                                        <h5 class="product_heading text-center mt-3"><?php echo $c_product['title']; ?></h5>
                                    </div>
                                </div>
                              <?php } ?>
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
    </script>

</body>

</html>