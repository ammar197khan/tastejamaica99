<?php
    include 'includes/config/common-files.php';
    // $a->authenticate();

    define('FILE_URL', 'outer_docx/');
    define('FILE_DIR', 'outer_docx/');

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    $data_row = $db->fetch_array_by_query('select * from get_listed where id='.intval($_REQUEST['id']));
    $multi_files = $db->fetch_array_by_query('select * from multi_files where detail_id='.intval($_REQUEST['id']));


?>
<!doctype html>
<html lang="en">
    <head>
    <?php include 'includes/site-master.php' ?>
        <title>Approved Business</title>
    </head>
    <body>
        <?php include 'includes/header.php' ?>
        <form enctype="multipart/form-data" method="post">
            <section class="main_section position-relative mb-5">
                <!-- <div class="alert alert-primary text-center" role="alert">
                    Get Listed Data Added Successfully
                </div> -->
                <div class="bg_images_area">
                    <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">
                    <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
                </div>
                <div class="container position-relative ">
                    <div class="row">
                        <!-- <h3>Menu</h3> -->
                        <div class="col-md-4"></div>
                        <!-- <div class="col-md-4"></div> -->
                        <div class="col-md-4">
                            <div class="justify-content-right" style="display: none;">
                                <h5>Link To Menu</h5>
                                <a href="<?= $multi_files['link_to_menu'] ?>"><?= $multi_files['link_to_menu'] ?></a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12 mt-2">
                            <div class="row">
                                <?php
                                    $multi_files_exp = explode(',', $multi_files['menu']);
                                    foreach( $multi_files_exp as  $files_exp){
                                ?>
                                    <div class="col-md-12 col-12 mb-3">
                                        <img class="img img-fluid" src="<?= FILE_URL.$files_exp ?>" alt="" width="100%" height="100%">
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>
        <?php include 'includes/footer.php' ?>
    </body>
</html>
