<?php
/*

##################################
##	MAIL-DISPATCHER		##
##################################

This file is part of the "mail-dispatcher"-Script by Lasse Helgenberger.
For further information go to
https://github.com/LasseHelgenberger/mail-dispatcher
or contact mail-dispatcher@lasse.cc

*/

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

maildispatcher();

function maildispatcher() {

require('credentials.php');

  //open imap stream
  $mbox = imap_open($cred_in_mailbox, $cred_in_mailuser, $cred_in_mailpasswd);

  //for each message in the inbox...
  for($i = 0; $i < imap_num_msg($mbox); $i++) {
  //for($i = 0; $i < 1; $i++) {
    // ... get the header info
    $header = imap_headerinfo($mbox, $i+1);
    $from = $header->from[0];
    $from_address = $from->mailbox."@".$from->host;
    $from_name = $from->personal;
    $subject = $header->Subject;
    // ... get the body
    $body = imap_body($mbox, $i+1);

//TODO check for Attachements
    // ... forward email
    forwardemail($from_address, $from_name, $subject, $body);
    // ... delete forwarded mail
    imap_delete($mbox, $i+1);
    imap_expunge($mbox);
  }

  imap_close($mbox);

}


function forwardemail($from_address, $from_name, $subject, $body) {
  require('./vendor/autoload.php');
  require('credentials.php');
  $recipients = getrecipients();

  for($i = 1; $i < sizeof($recipients); $i++) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = $cred_out_smtphost;
    $mail->SMTPAuth = true;
    $mail->Username = $cred_out_mailuser;
    $mail->Password = $cred_out_mailpasswd;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

    $mail->setFrom($cred_out_mailfrom, $cred_out_mailname);
    $mail->addAddress($recipients[$i][0], $recipients[$i][1]." ".$recipients[$i][2]);
    $mail->addReplyTo($from_address, $from_name);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    if($mail->send()) {
      echo "DONE";
    } else {
      echo "ERROR";
    }
  }
}

function getrecipients() {
//TODO

  require('credentials.php');

  $db = mysqli_connect($cred_mysqlhost, $cred_mysqluser, $cred_mysqlpasswd, $cred_mysqldb);
  if(!$db) {
    exit("CONNECTION-ERROR: ".mysqli_connect_error());
  }
  $query = "SELECT * FROM test";
  $result = mysqli_query($db, $query);

  $recipients = array(array("mailaddress", "firstname", "lastname"));
  while($row = mysqli_fetch_object($result)) {
    array_push($recipients, array($row->mailaddress, $row->firstname, $row->lastname));
  }

  return $recipients;
}
?>
