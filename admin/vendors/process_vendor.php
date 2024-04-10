<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your configuration file
    require_once('./../../config.php');

    // Check if the email field is set and not empty
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        // Sanitize and validate the email input
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Insert the new vendor into the database
            $query = "INSERT INTO vendor_list (email) VALUES ('$email')";
            if ($conn->query($query) === TRUE) {
                // Vendor added successfully, redirect to the vendor list page
                $message = "Vendor added successfully!";
                $_SESSION['success'] = $message;
                header("Location: vendor_list.php");
                exit();
            } else {
                // Error occurred while adding the vendor
                $error_message = "Error: " . $conn->error;
                $_SESSION['error'] = $error_message;
            }
        } else {
            // Invalid email format
            $_SESSION['error'] = "Invalid email format!";
        }
    } else {
        // Email field is empty
        $_SESSION['error'] = "Email field is required!";
    }

    // Redirect back to the add vendor page with error message
    header("Location: add_vendor.php");
    exit();
} else {
    // If the form is not submitted, redirect to the home page
    header("Location: ../../index.php");
    exit();
}
?>
