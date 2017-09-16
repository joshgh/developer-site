<?php
require dirname(__DIR__). '/vendor/autoload.php';
// require __DIR__ . '/siteconfig.php';
$siteconfig = parse_ini_file(dirname(__DIR__).'/config/siteconfig.ini');
$smtp_server = $siteconfig['smtp_server'];
$smtp_port = $siteconfig['smtp_port'];
$smtp_username = $siteconfig['smtp_username'];
$smtp_password = $siteconfig['smtp_password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (isset($_POST['form_email']) && isset($_POST['form_name'])){
       if (isset($_POST['message']) && $_POST['message'] != '') {
           header("Location: contactinfo.html");
           die();
       }
       $submitted_email = $_POST['form_email'];
       if ( filter_var($submitted_email, FILTER_VALIDATE_EMAIL)  != TRUE) {
           echo "invalid email address";
           die();
       }
       $submitted_name = $_POST['form_name'];

       // Create the Transport
       $transport = Swift_SmtpTransport::newInstance($smtp_server, $smtp_port, 'tls')
         ->setUsername($smtp_username)
         ->setPassword($smtp_password)
         ;

       // Create the Mailer using your created Transport
       $mailer = Swift_Mailer::newInstance($transport);

       // Create a message
       $message = Swift_Message::newInstance('Contact Info')
         ->setFrom(array('j.m.huffman@gmail.com' => 'Joshua Huffman'))
         ->setTo(array($submitted_email => $submitted_name))
         ->setBody("Thanks for your interest!\r\n\r\nJoshua Huffman\r\nJunior Web Developer\r\nPortland, Oregon\r\nj.m.huffman@gmail.com\r\nLinkedIn: linkedin.com/in/joshua-huffman\r\nGitHub: github.com/joshgh", 'text/plain')
         ;

       // Send the message
       $result = $mailer->send($message);

       header("Location: contact_success.html");
       die();
   } else {
       header("Location: contactinfo.html");
       die();
   }
 } else {
     header("Location: contactinfo.html");
     die();
 }

?>
