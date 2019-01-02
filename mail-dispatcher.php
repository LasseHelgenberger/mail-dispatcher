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

// Check for new Mail
$mbox = imap_open($cred_mailbox, $cred_mailuser, $cred_mailpasswd);

for($i = 0; $i < imap_num_msg($mbox); $i++) {
  $header = imap_headerinfo($mbox, $i+1);
  $from = $header->fromaddress;
  $subject = $header->Subject;
echo "FROM: ".$from."\n";
echo "SUBJECT: ".$subject."\n";
  echo "BODY:".imap_body($mbox, $i+1)."\n\n";
}

imap_close($mbox);
// If new Mail: Send to everyone
}

?>
