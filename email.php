<?php
  $output = Array();
  if ((isset($_POST["email"]) && !empty($_POST["email"])) &&
      (isset($_POST["message"]) && !empty($_POST["message"]))) {

      // the message
      $msg = $_POST['message'];
      // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($msg,70);
      $return_email = $_POST['email'];

      $phone = "";
      if (isset($_POST["phone"]) && !empty($_POST["phone"])) {
        $phone = $_POST['phone'];
      }

      $name = "";
      if (isset($_POST["name"]) && !empty($_POST["name"])) {
        $name = $_POST['name'];
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
?>
