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

echo "postfächer";
$headers = imap_headers($mbox);

if($headers == false) {
  echo "fehlgeschlagen";
} else {
  foreach($headers as $val) {
    echo $val."\n";
  }
}

imap_close($mbox);
// If new Mail: Send to everyone
}

?>
