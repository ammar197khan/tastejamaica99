<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Remove Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css"> -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
        }

        ol {
            padding-left: 20px;
        }

        p {
            color: #6c757d;
        }

        /* Custom styles for the primary button */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            padding: 0.5rem 1rem;
            text-decoration: none;
            display: inline-block;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="email-container">


        <p>Dear <?php echo  $user_name ?>,</p>

        <p>
            We are delighted to inform you that your restaurant listing has been approved for inclusion on the Taste Jamaica platform. Congratulations!
        </p>

        <p>
            Your establishment is now part of our vibrant community, where users can discover and savor the unique culinary experiences your restaurant has to offer.
        </p>
        <p>
            If we require any additional information or have any questions regarding your submission, we will reach out to you promptly.
        </p>
        <ol>
            <li><strong>Name of Business: </strong> <?php echo $business_row['name']; ?></li>

            <li><strong>Address: </strong> <?php echo $business_row['address'] ?></li>

            <li><strong>Cuisine Type: </strong> <?php echo $business_row['cuisines'] ?></li>

            <li><strong>Description:</strong> <?php echo $business_row['discription']; ?></li>
            <li><strong>Description:</strong> <?php echo $business_row['discription']; ?></li>
            <?php 
            $businessLink = 'https://' . $domain . '/business-detail.php?id=' . $business_row['id'];
            ?>
            <li><strong>Link to the business: </strong> <a href="<?php echo $businessLink; ?>">Click To See</a> </li>
        </ol>

        <p>
            Your listing is now live on our platform, and users can start exploring your restaurant immediately.
        </p>
        <p>
            We appreciate your commitment to delivering exceptional dining experiences, and we're excited to feature your establishment on Taste Jamaica.
        </p>
        <p>
            If you have any updates or changes to your listing or if you have any questions, please feel free to reach out to our support team at info@tastejamaica.com.
        </p>
        <p>
            Thank you for choosing Taste Jamaica. We look forward to showcasing your culinary delights to our community!
        </p>

        <p class="mt-4">Best regards,<br> Taste Jamaica</p>

        <!-- <a href="#" class="btn btn-primary mt-3">Get Started</a> -->
        <!-- <a href="#" class="btn-primary mt-3">Get Started</a> Use custom button class -->
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>