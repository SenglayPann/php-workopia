<?php
  namespace Framework;
  require basePath('vendor/autoload.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  class Mail {

    public function __construct() {
    }

    /**
     * Sends an email using the PHPMailer library.
     *
     * @param string $to         The recipient's email address.
     * @param string $subject    The email subject.
     * @param string $body       The email body.
     * @throws Exception         Throws an exception if the email could not be sent.
     */
    public static function sendMail($to, $subject, $body) {
      $mail = new PHPMailer(true);
      try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = $_SERVER['MAIL_HOST']; // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = $_SERVER['MAIL_ADDRESS']; // Your Gmail address
        $mail->Password   = $_SERVER['MAIL_APP_PASSWORD']; // Use App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_SERVER['MAIL_PORT'];
    
        // Email Headers
        $mail->setFrom($_SERVER['MAIL_ADDRESS'], 'Workopia');
        $mail->addAddress($to); // Recipient's email

        // Enable HTML
        $mail->isHTML(true); // ✅ Enables HTML email formatting
    
        // Email Content
        $mail->Subject = $subject;;
        $mail->Body    = $body;
    
        // Send email
        $mail->send();
        // echo 'Email sent successfully!';
      } catch (Exception $e) {
        throw new Exception("Email could not be sent. Error: {$mail->ErrorInfo}");  
      }
    }

    /**
     * Sends a confirmation email to the specified recipient with a verification link.
     *
     * Constructs a verification link using the provided token and the current domain,
     * then composes an HTML email with a link for the recipient to verify their email address.
     * The email includes basic styling for better presentation.
     *
     * @param string $to The recipient's email address.
     * @param string $token The unique verification token to be included in the link.
     */

    public static function sendConfirmationEmail($to, $token) {
      // Get the current domain dynamically
      $domain = $_SERVER['HTTP_HOST']; // Example: localhost:8080 or mywebsite.com
      $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
      $verification_link = "$protocol://$domain/auth/verify/$token";

      // Email content
      $subject = 'Verify your email address';
      $body = "
      <html>
      <head>
        <style>
          .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
          }
          .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
          }
          .content {
            padding: 20px;
          }
          .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
          }
        </style>
      </head>
      <body>
        <div class='container'>
        <div class='header'>
        <h1>Verify Wellcome to Workopia</h1>
        <h2>Verify your email address</h2>
          </div>
          <div class='content'>
            <p>Click the link below to verify your email address:</p>
            <a href='$verification_link' class='button'>Verify Email</a>
          </div>
        </div>
      </body>
      </html>
      ";

      // Send email
      self::sendMail($to, $subject, $body);

    }
  }