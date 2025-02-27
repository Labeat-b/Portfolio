<?php
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        die("❌ Error: All fields are required!");
    }

    $mail = new PHPMailer(true); 

    try {
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST']; 
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom($email, $name); 
        $mail->addAddress('labeat.bytyqi@gmail.com', 'Labeat Bytyqi');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Message';
        $mail->Body = "<h3>Message from: $name ($email)</h3><p>$message</p>";

        $mail->send();
        echo '✅ Message sent successfully!';
    } catch (Exception $e) {
        echo "❌ Error: {$mail->ErrorInfo}";
    }
} else {
    echo "❌ Error: Invalid request method!";
}
?>
