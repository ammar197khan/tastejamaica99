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
        It appears that you've requested to reset your password on the Taste Jamaica platform. If you did not make this request, please disregard this email, and your account will remain secure.
        </p>
        <b>OTP : <?php echo intval($otp_row['otp']); ?></b>
        <p>
        If you continue to experience issues or did not request this password reset, please contact our support team immediately at info@tastejamaica.com. Our team will be happy to assist you.
        </p>
    


        <p>Thank you for choosing Taste Jamaica. We appreciate your continued support.</p>

        <p class="mt-4">Best regards,<br> Taste Jamaica</p>

        <!-- <a href="#" class="btn btn-primary mt-3">Get Started</a> -->
        <!-- <a href="#" class="btn-primary mt-3">Get Started</a> Use custom button class -->
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>