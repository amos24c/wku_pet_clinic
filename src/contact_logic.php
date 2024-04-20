<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Normally here you would save the data to a database or send an email
    // For now, let's just display the data back on the page for demonstration

    $confirmationMessage = "Thank you, $name. We have received your message and will get back to you shortly.";
    echo $confirmationMessage;

    // Here you would typically redirect or include a more complex handler
    // This is a simplified example
}
?>