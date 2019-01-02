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
  $mbox = imap_open($cred_mailbox, $cred_mailuser, $cred_mailpasswd);

  //for each message in the inbox...
  //for($i = 0; $i < imap_num_msg($mbox); $i++) {
  for($i = 0; $i < 1; $i++) {
  // ...get the header info
    $header = imap_headerinfo($mbox, $i+1);
//  $from = $header->fromaddress; <-- NOT WORKING HOW I INTENDED TODO
  $from_address = "me@lasse.cc";
  $from_name = "Lasse H";
    $subject = $header->Subject;
echo "FROM: ".$from."\n";
echo "SUBJECT: ".$subject."\n";
    // ... get the body
    $body = imap_body($mbox, $i+1);
echo "BODY:".$body."\n\n";

//TODO check for Attachements
  // ... forward email
    forwardemail($from_address, $from_name, $subject, $body);
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
    $mail->Host = $cred_smtphost;
    $mail->SMTPAuth = true;
    $mail->Username = $cred_mailuser;
    $mail->Password = $cred_mailpasswd;
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;

echo "DEBUG: ".$recipients[$i][0]." ".$recipients[$i][1]." ".$recipients[$i][2];
    $mail->setFrom($cred_mailfrom, $cred_mailname);
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
  $query = "SELECT * FROM recipients";
  $result = mysqli_query($db, $query);

  $recipients = array(array("mailaddress", "firstname", "lastname"));
  while($row = mysqli_fetch_object($result)) {
    array_push($recipients, array($row->mailaddress, $row->firstname, $row->lastname));
  }
for($i = 0; $i < sizeof($recipients); $i++) {
echo "DEBUG: ".$recipients[$i][0]." ".$recipients[$i][1]." ".$recipients[$i][2]; }
  return $recipients;
}
?>
