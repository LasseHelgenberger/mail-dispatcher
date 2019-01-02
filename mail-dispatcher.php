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

maildispatcher();

function maildispatcher() {
include 'credentials.php';

//open imap stream
$mbox = imap_open($cred_mailbox, $cred_mailuser, $cred_mailpasswd);

//for each message in the inbox...
for($i = 0; $i < imap_num_msg($mbox); $i++) {
  // ...get the header info
  $header = imap_headerinfo($mbox, $i+1);
  $from = $header->fromaddress;
  $subject = $header->Subject;
echo "FROM: ".$from."\n";
echo "SUBJECT: ".$subject."\n";
  // ... get the body
  $body = imap_body($mbox, $i+1);
echo "BODY:".$body."\n\n";

//TODO check for Attachements

  // ... forward email
  forwardemail($from, $subject, $body);
}
imap_close($mbox);

}


function forwardemail($from, $subject, $body) {
//TODO
$recipients = getrecipients();
include 'credentials.php';
$mbox = imap_open($cred_mailbox, $cred_mailuser, $cred_mailpasswd);

for($i = 0; $i < sizeof($recipients); $i++) {
  imap_mail($recipients[$i], $subject, $body);
}
imap_close($mbox);
}

function getrecipients() {
//TODO

$res = array("test1@lasse.cc", "test2@lasse.cc", "test3@lasse.cc");
return $res;
}
?>
