<?php
  $output = $_REQUEST;
  if ((isset($_REQUEST["email"]) && !empty($_REQUEST["email"])) &&
      (isset($_REQUEST["message"]) && !empty($_REQUEST["message"]))) {

    // the message
    $msg = $_REQUEST['message'];
    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);
    $from = $_REQUEST['email'];

    $phone = "";
    if (isset($_REQUEST["phone"]) && !empty($_REQUEST["phone"])) {
      $phone = $_REQUEST['phone'];
    }

    $name = "";
    if (isset($_REQUEST["name"]) && !empty($_REQUEST["name"])) {
      $name = $_REQUEST['name'];
    }

    // Pear Mail Library
    require_once "Mail.php";

    $to = 'stevenr180@gmail.com';
    $subject = 'CONTACT! ('.$name.')';
    $body = "Sender: (" . $return_email . ")\n" .
            "Phone: (" . $phone . ")\n" .
            "Name: (" . $name . ")\n" .
            "Message: " . $msg;

    $headers = array(
        'From' => $from,
        'To' => $to,
        'Subject' => $subject
    );

    $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'johndoe@gmail.com',
            'password' => getenv('GMAIL_PASS')
        ));

    $mail = $smtp->send($to, $headers, $body);

    if (PEAR::isError($mail)) {
        echo('<p>' . $mail->getMessage() . '</p>');
    } else {
        echo('<p>Message successfully sent!</p>');
    }
    $output['success'] = 'true';
  } else {
    $output['success'] = 'false';
  }
  echo json_encode($output);
  echo $_REQUEST;
?>
