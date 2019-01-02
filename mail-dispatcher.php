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

$headers = imap_headers($mbox);

if($headers == false) {
  echo "fehlgeschlagen";
} else {
  for($i = 0; $i < sizeof($headers); $i++) {
    echo $headers[$i]."\n";
    echo "BODY:".imap_body($mbox, $i)."\n\n";
  }
}

imap_close($mbox);
// If new Mail: Send to everyone
}

?>
