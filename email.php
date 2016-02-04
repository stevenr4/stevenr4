<?php
  $output = $_REQUEST;
  if ((isset($_REQUEST["email"]) && !empty($_REQUEST["email"])) &&
      (isset($_REQUEST["message"]) && !empty($_REQUEST["message"]))) {

    // the message
    $msg = $_REQUEST['message'];
    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
    $requester = $_REQUEST['email'];

    $phone = "";
    if (isset($_REQUEST["phone"]) && !empty($_REQUEST["phone"])) {
      $phone = $_REQUEST['phone'];
    }

    $name = "";
    if (isset($_REQUEST["name"]) && !empty($_REQUEST["name"])) {
      $name = $_REQUEST['name'];
    }

    $subject = 'CONTACT from name:(' . $name . '), email:(' . $requester . ')';
    $body = "Sender: (" . $requester . ")\n" .
            "Phone: (" . $phone . ")\n" .
            "Name: (" . $name . ")\n" .
            "Message: " . $msg;

    $headers = array(
      'From' => $from,
      'To' => $to,
      'Subject' => $subject
    );

    // Require the swift library
    require_once 'lib/swift_required.php';

    // Create the Transport, attach to GMAIL's smtp service
    $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
      ->setUsername($this->"stevenr4@stevenr4.com")
      ->setPassword($this->getenv('GMAIL_PASS'));

    // Create the Mailer using your created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create a message
    $message = Swift_Message::newInstance($subject)
      ->setFrom(array('info@stevenr4.com' => 'Info'))
      ->setTo(array('stevenr4@stevenr4.com', 'stevenr180@gmail.com'))
      ->setBody($body)
      ;

    // Send the message
    $result = $mailer->send($message);
    $output['success'] = 'true';
  } else {
    $output['success'] = 'false';
  }
  echo json_encode($output);
  echo $_REQUEST;
?>
