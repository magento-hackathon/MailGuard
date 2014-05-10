<?php
/**
 * send e-mails for testing
 *
 *
 * @category   Hackathon
 * @package    Hackathon_MailGuard
 * @author     Anna Völkl <a.voelkl@limesoda.com>
 */
 
require_once 'app/Mage.php';
Mage::app();

$emails = array('a.voelkl@limesoda.com');
//, 'andreas.penz@icc.at','andre@pixelperfect.at','dmanners87@gmail.com','admin@matthias-zeis.com');

// core/email
foreach($emails as $email) {
	$mailer = Mage::getModel('core/email')
	            ->setType('text')
	            ->setToName($email)
	            ->setToEmail($email)
	            ->send();
}
echo "core/email sent";
			
// core/email_template			
/* @var $emailModel Mage_Core_Model_Email_Template */
$emailModel = Mage::getModel('core/email_template');

foreach ($emails as $email) {
    $emailModel->sendTransactional(Mage::getStoreConfig(Mage_Sitemap_Model_Observer::XML_PATH_ERROR_TEMPLATE),
        Mage::getStoreConfig('trans_email/ident_general/email'),
        $email,
        null,
        null
    );
}

echo "core/email_template sent";
?>
