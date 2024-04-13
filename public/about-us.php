<?php
include 'includes/config/common-files.php';
// $a->authenticate();
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
        <div class="container position-relative about">
            <div class="row ">
                <div class="col-md-3 ">
                    <img class="img img-fluid mt-5" src="assets/images/img_35.png" alt="">

                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 mt-5"><span class="sub_heading fs-60px font-popinns mb-1">ABOUT TASTE JAMAICA</span></div>

                        <p>
                            If food is the language of love, then Jamaica's unmistakable flavours in its variety of spices, fruits, beverages and distinctive cuisine will surely win the hearts of locals and visitors alike.
                        </p>
                        <p>

                            It is certainly no easy feat that our small island Caribbean state, when stacked against 195 existing countries, has successfully managed to be counted among the world's best for its expansive palette of tastes. </p>
                        <p>
                            CNN Travel recently listed Jamaica's jerk pork and chicken among the "20 best spicy foods across the globe to try." National Geographic named Kingston's Devon House the fourth-best place in the world to eat ice cream. Our premium Blue Mountain-grown coffee continues to be favourably ranked by connoisseurs as one of the finest to sip. And, with world-famous actors ranging from Sean Connery to Tom Cruise drinking from the red and white glass bottle, our locally brewed Red Stripe remains as iconic for its distinct flavour as it does for cementing its legacy on the big screen. </p>
                    </div>
                </div>
                <div class="col-md-12 mt-5">
                    <div class="row">

                        <div class="col-12">
                            <p>
                                With this favourable reputation in mind, and to build on the great dynamism of our country's culinary offerings through our chefs and restaurants, the Ministry of Tourism has sought to improve the gastronomical experience for our visitors. It is for this reason that the Tourism Linkages Network (TLN), a division of the Tourism Enhancement Fund (TEF), established Taste Jamaica through the Gastronomy Network, led by our irrepressibly forward-thinking Chairperson Nicola Madden-Greig and her team.
                            </p>
                            <p>

                                Envisioned as a catalyst to make the Jamaican dining experience more curated, the aim of both the TLN and its Gastronomy Network is to tap into the wide berth of the island's dining experiences, from four-star epicurean restaurants and riverside dining to authentic farm-to- table and our amazing street food scene. While opportunities exist within related sub-sectors, from agriculture to the culinary arts, the ultimate hope for the industry is one of growth and evolution to meet the changing shifts and tastes of the discerning traveller. </p>
                            <p>
                                Taste Jamaica is eager to meet this challenge and is ready to embrace the changes that come with it. We are, therefore, immensely proud of this initiative, which will make it easier for users to learn more about our island’s culinary offerings. </p>
                            <p class="mb-0">
                                <b>Hon. Edmund Bartlett, CD, MP</b>
                            </p>
                            <p>
                                <b>Minister of Tourism</b>
                            </p>

                        </div>
                        <div class="col-12 text-center">
                            <img class="img img-fluid" src="assets/images/img_36.png" alt="">
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