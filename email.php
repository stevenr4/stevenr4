<?php
  $output = $_REQUEST;
  if ((isset($_REQUEST["email"]) && !empty($_REQUEST["email"])) &&
      (isset($_REQUEST["message"]) && !empty($_REQUEST["message"]))) {

      // the message
      $msg = $_REQUEST['message'];
      // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($msg,70);
      $return_email = $_REQUEST['email'];

      $phone = "";
      if (isset($_REQUEST["phone"]) && !empty($_REQUEST["phone"])) {
        $phone = $_REQUEST['phone'];
      }

      $name = "";
      if (isset($_REQUEST["name"]) && !empty($_REQUEST["name"])) {
        $name = $_REQUEST['name'];
      }

      // send email
      mail(
        "stevenr4@stevenr4.com",
        "CONTACT FROM stevenr4.com",
        "Sender: (" . $return_email . ")\n" .
        "Phone: (" . $phone . ")\n" .
        "Name: (" . $name . ")\n" .
        "Message: " . $msg
      );
      mail(
        "stevenr180@gmail.com",
        "CONTACT FROM stevenr4.com",
        "Sender: (" . $return_email . ")\n" .
        "Phone: (" . $phone . ")\n" .
        "Name: (" . $name . ")\n" .
        "Message: " . $msg
      );
    $output['success'] = 'true';
  } else {
    $output['success'] = 'false';
  }
  echo json_encode($output);
  echo $_REQUEST;
?>
