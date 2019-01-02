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

// Check for new Mail
$mbox = imap_open($cred_mailbox, $cred_mailuser, $cred_mailpasswd);

echo "postfächer";
$folders = imap_listmailbox($mbox, $cred_mailbox,"*");

if($folders == false) {
  echo "fehlgeschlagen";
} else {
  foreach($folders as $val) {
    echo $val."\n";
  }
}
// If new Mail: Send to everyone
}

?>
