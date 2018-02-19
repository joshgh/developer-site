<?php
require dirname(__DIR__). '/vendor/autoload.php';
$siteconfig = parse_ini_file(dirname(__DIR__).'/config/siteconfig.ini');
$smtp_server = $siteconfig['smtp_server'];
$smtp_port = $siteconfig['smtp_port'];
$smtp_username = $siteconfig['smtp_username'];
$smtp_password = $siteconfig['smtp_password'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (isset($_POST['form_email']) && isset($_POST['form_name'])){
       if (isset($_POST['message']) && $_POST['message'] != '') {
           header("Location: index.html");
           die();
       }
       $submitted_email = $_POST['form_email'];
       if ( filter_var($submitted_email, FILTER_VALIDATE_EMAIL)  != TRUE) {
           echo "invalid email address";
           die();
       }
       $submitted_name = $_POST['form_name'];
        $submitted_email = $_POST['form_email'];
        $submitted_message = $_POST['form_message'];

       // Create the Transport
       $transport = Swift_SmtpTransport::newInstance($smtp_server, $smtp_port, 'tls')
         ->setUsername($smtp_username)
         ->setPassword($smtp_password)
         ;

       // Create the Mailer using your created Transport
       $mailer = Swift_Mailer::newInstance($transport);

       // Create a message
       $message = Swift_Message::newInstance('Homepage Contact')
         ->setFrom(array('j.m.huffman@gmail.com' => 'Joshua Huffman'))
         ->setTo(array('j.m.huffman@gmail.com' => 'Joshua Huffman'))
         ->setBody("Someone sent you a message through your portfolio form.".PHP_EOL." It is from ". $submitted_name . " at " . $submitted_email.PHP_EOL.$submitted_message, 'text/plain')
         ;

       // Send the message
       try {
           $result = $mailer->send($message);
       } catch (\Exception $e) {
           die($e->getMessage());
       }

       header("Location: index.html");
       die();
   } else {
       header("Location: index.html");
       die();
   }
 } else {
     header("Location: index.html");
     die();
 }

?>
