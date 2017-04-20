<?php
  $output = $_REQUEST;

  if ((isset($_REQUEST["email"]) && !empty($_REQUEST["email"])) &&
      (isset($_REQUEST["message"]) && !empty($_REQUEST["message"]))) {

    $requester = $_REQUEST['email'];
    $msg = $_REQUEST['message'];
    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
    $phone = "";
    if (isset($_REQUEST["phone"]) && !empty($_REQUEST["phone"])) { $phone = $_REQUEST['phone']; }
    $name = "";
    if (isset($_REQUEST["name"]) && !empty($_REQUEST["name"])) { $name = $_REQUEST['name']; }



    // Validate the requester email:
    if (!filter_var($requester, FILTER_VALIDATE_EMAIL)) {
        $output['success'] = 'false';
        $output['reason'] = 'Email is invalid';
        echo json_encode($output);
        die();
    }

    $subject = 'stevenr4.com contact request from: name( ' . $name . ' ), email( ' . $requester . ' )';
    $body = "Sender: ( " . $requester . " )\n\n" .
            "Phone: ( " . $phone . " )\n\n" .
            "Name: ( " . $name . " )\n\n" .
            "Message: " . $msg;

    // Require the swift library
    require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';
    // Create the Transport, attach to GMAIL's smtp service
    $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
      ->setUsername("stevenr4@stevenr4.com")
      ->setPassword(getenv('GMAIL_PASS'));
    // Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transporter);

    // Create the message to myself
    $message = Swift_Message::newInstance($subject)
      ->setFrom(array('noreply@stevenr4.com' => 'Info'))
      ->setTo(array('stevenr4@stevenr4.com', 'stevenr180@gmail.com'))
      ->setBody($body)
      ;
    // Send the message to myself
    $result = $mailer->send($message);

    // Create a user-facing message:
    $message = Swift_Message::newInstance("Steven Rogers (automated response)")
      ->setFrom(array('info@stevenr4.com' => 'Info'))
      ->setTo(array($requester))
      ->setBody("Dear " . $name . "Thank you for reaching out to Steven Rogers. This email is an automatic message confirming your contact request has been processed. Steven will get back to you as soon as he is able.\n\n\n---------- Below is a copy of information that was sent to Steven Rogers ----------\n\n" . $body)
      ;
    // Send the user-facing message
    $result = $mailer->send($message);

    $output['success'] = 'true';
  } else {
    $output['success'] = 'false';
    $output['reason'] = "Missing Information";
    $output['request'] = var_export($_REQUEST, true);
    $output['get'] = var_export($_GET, true);
    $output['post'] = var_export($_POST, true);
  }
  echo json_encode($output);
?>
