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

        <p>Welcome to Taste Jamaica! We are thrilled to have you join our community of food enthusiasts who share a passion for exceptional culinary experiences.</p>

        <p>At Taste Jamaica, we understand the joy of discovering new and exciting restaurants that offer a feast for the senses. Whether you're a seasoned foodie or someone looking to explore the vibrant world of Jamaican cuisine, you're in the right place.</p>
        <p>
        As a registered user, you now have access to a diverse array of restaurants that capture the essence of Jamaican flavors. From traditional favorites to hidden gems, our platform is your gateway to a world of culinary delights.
        </p>

        <ol>
            <li><strong>Here are a few things you can do on Taste Jamaica:</strong> </li>

            <li> <strong> Explore Restaurants: </strong> Browse through our curated selection of restaurants, each offering a unique culinary experience.</li>

            <li><strong>Discover Local Gems: </strong> Find hidden gems in your area or explore new neighborhoods to uncover the best flavors Jamaica has to offer.</li>

            <li><strong>Save Favorites: </strong> Save your favorite restaurants to create a personalized list of go-to spots for your next dining adventure.</li>
        </ol>

        <p>We hope you enjoy your journey with Taste Jamaica, and that our platform becomes your go-to resource for finding the perfect dining experiences.</p>

        <p>Thank you for joining us on this culinary adventure. Happy exploring!</p>

        <p class="mt-4">Best regards,<br> Taste Jamaica</p>

        <!-- <a href="#" class="btn btn-primary mt-3">Get Started</a> -->
        <!-- <a href="#" class="btn-primary mt-3">Get Started</a> Use custom button class -->
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>
