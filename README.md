# mail-dispatcher
This is a simple script that retreives mails via IMAP from a Mailbox and forwards them to a list of mailadresses that is stored in a MySQL database.

# setup

STEP 1: Clone the repository and run the following command on the terminal while you are in the repositorries folder:

composer require phpmailer/phpmailer

STEP 2: Open the file credentials.php in a texteditor and fill in the Logindata to the mailbox and MySQL server.

STEP 3: Create a cronjob on your system that starts the script once in a while. (php mail-dispatcher.php)
