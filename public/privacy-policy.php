<?php
include 'includes/config/common-files.php';
// $a->authenticate();
// die('here we are ');
?>
<!doctype html>
<html lang="en">

<head>
    <?php include 'includes/site-master.php' ?>

    <title>Privacy policy</title>
</head>

<body>
    <?php include 'includes/header.php' ?>

    <section class="main_section position-relative mb-5 pb-5">
    <div class="bg_images_area">

        <img class="right_side_image" src="assets/images/graphic_leafs.png" alt="">

        <img class="left_side_image" src="assets/images/graphic_tree.png" alt="">
    </div>
    <div class="container position-relative ">
        <div class="row text-center">
            <div class="col-md-12 pt-5 mt-5"><span class="sub_heading fs-60px font-popinns mb-1">PRIVACY POLICY</span>
            </div>

        </div>
        <div class="row privacy_pages mt-5">
            <div class="col-12">
                <p>
                    Tourism Enhancement Fund built the Taste Jamaica app as a free app. This SERVICE is provided by
                    Tourism Enhancement Fund at no cost and is intended for use as is. This page is used to inform
                    visitors regarding our policies with the collection, use, and disclosure of Personal Information if
                    anyone decided to use our Service.If you choose to use our Service, then you agree to the collection
                    and use of information in relation to this policy. The Personal Information that we collect is used
                    for providing and improving the Service. We will not use or share your information with anyone
                    except as described in this Privacy Policy.The terms used in this Privacy Policy have the same
                    meanings as in our Terms and Conditions, which is accessible at www.tastejamaica.com unless
                    otherwise defined in this Privacy Policy.
                    Information Collection and Use
                </p>
                <ol type="i">
                    <li>For a better experience, while using our Service, we may require you to provide us with certain
                        personally identifiable information, including but not limited to Email Address and Name. The
                        information that we request will be retained by us and used as described in this privacy policy.
                    </li>
                    <li>The app does use third party services that may collect information used to identify you.</li>
                    <li>Link to privacy policy of third-party service providers used by the app</li>
                </ol>
                <ul>
                    <li>
                        <a href="" class="text-black">Google Play Services</a>
                    </li>
                    <li>
                        <a href="" class="text-black">Firebase Analytics</a>
                    </li>
                </ul>
                <p>Log Data</p>

                <ol type="i">
                    <li>We want to inform you that whenever you use our Service, in a case of an error in the app we
                        collect data and information (through third party products) on your phone called Log Data. This
                        Log Data may include information such as your device Internet Protocol (“IP”) address, device
                        name, operating system version, the configuration of the app when utilizing our Service, the
                        time and date of your use of the Service, and other statistics.
                    </li>
                </ol>
                <p>Cookies</p>

                <ol type="i">
                    <li>Cookies are files with a small amount of data that are commonly used as anonymous unique
                        identifiers. These are sent to your browser from the websites that you visit and are stored on
                        your device's internal memory.
                    </li>
                    <li>
                        This Service does not use these “cookies” explicitly. However, the app may use third party code
                        and libraries that use “cookies” to collect information and improve their services. You have the
                        option to either accept or refuse these cookies and know when a cookie is being sent to your
                        device. If you choose to refuse our cookies, you may not be able to use some portions of this
                        Service.
                    </li>
                </ol>
                <p>APIs</p>

                <ol type="i">
                    <li>We may utilize third-party api due to the following reasons:
                    </li>
                </ol>
                <ul>
                    <li>
                        To facilitate our Service;
                    </li>
                    <li>
                        To provide the Service on our behalf;
                    </li>
                    <li>
                        To perform Service-related services; or
                    </li>
                    <li>
                        To assist us in analyzing how our Service is used.
                    </li>
                </ul>

                <ol type="i">
                    <li>We want to inform users of this Service that these third parties have access to your Personal
                        Information. The reason is to perform the tasks assigned to them on our behalf. However, they
                        are obligated not to disclose or use the information for any other purpose.
                    </li>
                </ol>
                <p>Security</p>

                <ol type="i">
                    <li>We value your trust in providing us your Personal Information, thus we are striving to use
                        commercially acceptable means of protecting it.
                    </li>
                </ol>
                <p>Links to Other Sites</p>

                <ol type="i">
                    <li>
                        This Service may contain links to other sites. If you click on a third-party link, you will be
                        directed to that site. Note that these external sites are not operated by us. Therefore, we
                        strongly advise you to review the Privacy Policy of these websites. We have no control over and
                        assume no responsibility for the content, privacy policies, or practices of any third-party
                        sites or services.
                    </li>
                </ol>
                <p>Children’s Privacy</p>

                <ol type="i">
                    <li>
                        These Services do not address anyone under the age of 13. We do not knowingly collect personally
                        identifiable information from children under 13. In the case we discover that a child under 13
                        has provided us with personal information, we immediately delete this from our servers. If you
                        are a parent or guardian and you are aware that your child has provided us with personal
                        information, please contact us so that we will be able to do necessary actions.
                    </li>
                </ol>
                <p>Changes to This Privacy Policy</p>

                <ol type="i">
                    <li>
                        We may update our Privacy Policy from time to time. Thus, you are advised to review this page
                        periodically for any changes. We will notify you of any changes by posting the new Privacy
                        Policy on this page. These changes are effective immediately after they are posted on this page.
                    </li>
                </ol>
                <p>Contact Us</p>

                <ol type="i">
                    <li>
                        If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us.
                    </li>
                </ol>

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