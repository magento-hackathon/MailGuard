<?php
/**
 * MailGuard extension for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade
 * the Hackathon MailGuard module to newer versions in the future.
 * If you wish to customize the Hackathon MailGuard module for your needs
 * please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Hackathon
 * @package    Hackathon_MailGuard
 * @copyright  Copyright (C) 2014 Andre Flitsch (http://www.pixelperfect.at)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *
 *
 * @category   Hackathon
 * @package    Hackathon_MailGuard
 * @author     Andre Flitsch <andre@pixelperfect.at>
 */

class Hackathon_MailGuard_Model_Observer {
    const LOGGING_ENABLED = 1;
    /**
     * event observer called before emails are sent
     *
     * @param Varien_Event_Observer $observer
     */
    public function emailSendBefore(Varien_Event_Observer $observer)
    {
        $email = $observer->getEmail();
        $emailTo = $observer->getEmailTo();

        /** @var Hackathon_MailGuard_Model_MailGuard $mailGuard */
        $mailGuard = Mage::getModel('hackathon_mailguard/mailGuard');

        if($mailGuard->canSend($email, $emailTo) !== true) {
            $email->setDoNotSend(TRUE);
        } else {
            $email->setDoNotSend(false);
        }
		$email->setFilter($mailGuard->getFilter());
		$email->setFilterName($mailGuard->getFilterName());
    }
    /**
     * event observer called after emails are sent
     *
     * @param Varien_Event_Observer $observer
     */
    public function emailSendAfter(Varien_Event_Observer $observer)
    {
        if(Mage::getStoreConfig('hackathon_mailguard/settings/logging') == self::LOGGING_ENABLED) {
            $email = $observer->getEmail();
            $email_to = $observer->getEmailTo();

            if(!is_array($email_to)) {
                $email_to = array($email_to);
            }

            if($email->getDoNotSend()) {
                Mage::log($email->getFilterName().
                        ", ".implode(", ",$email_to),
                        null,
                        'mailguard.log');
            }
        }
	}
}