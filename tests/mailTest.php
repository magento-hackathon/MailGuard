<?php
/**
 * send e-mails for testing
 *
 *
 * @category   Hackathon
 * @package    Hackathon_MailGuard
 * @author     Anna Völkl <a.voelkl@limesoda.com>
 */

//die('uncomment this line and set testing e-mail addresses in this file');
$emails = array('anna@vape.net');// 'andreas.penz@icc.at','andre@pixelperfect.at','dmanners87@gmail.com','admin@matthias-zeis.com');

require_once 'app/Mage.php';
Mage::app();

// core/email
foreach($emails as $email) {
	$mailer = Mage::getModel('core/email')
	            ->setType('text')
	            ->setToName($email)
	            ->setToEmail($email)
                ->setSubject("core email")
                ->setFromName('MailGuard')
	            ->send();
}

echo "Sending Mage_Core_Model_Email Mail: done<br />";

// core/email_template			
/* @var $emailModel Mage_Core_Model_Email_Template */
$emailModel = Mage::getModel('core/email_template');

foreach ($emails as $email) {
    $template = Mage::getStoreConfig('checkout/payment_failed/template', 0);
        $emailModel->sendTransactional(
            Mage::getStoreConfig('wishlist/email/email_template'),
            Mage::getStoreConfig('wishlist/email/email_identity'),
            $email,
            null,
            null
        );
}
echo "Sending Mage_Core_Model_Email_Template Mail: ";
var_dump($emailModel->getSentSuccess());
?>
