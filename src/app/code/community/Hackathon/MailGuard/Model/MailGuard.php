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
 * does stuff
 *
 *
 * @category   Hackathon
 * @package    Hackathon_MailGuard
 * @author     Andre Flitsch <andre@pixelperfect.at>
 */
class Hackathon_MailGuard_Model_MailGuard extends Mage_Core_Model_Abstract
{
	const EMAIL_FILTER_WHITELIST 	= "WHITELIST";
	const EMAIL_FILTER_BLACKLIST 	= "BLACKLIST";
	
	var $_filter = null;
	
    /**
     * detemines if the mail can be sent, and sets a property to prevent sending if appropriate
     * @param Varien_Object $email
     * @param array|string $emailsTo
     */
    public function canSend(Varien_Object $email, $emailsTo)
    {
        $validatedEmails = array();

        foreach ($emailsTo as $emailKey => $emailToCheck) {
            $emailDomain = $this->getDomainFromEmail($emailToCheck);

            /** @var Hackathon_MailGuard_Model_Resource_Address_Collection $emailCollection */
            $emailCollection = Mage::getModel('hackathon_mailguard/address')->getCollection();
            $emailCollection
                ->addFieldToFilter('mailaddress', array('like' => '%' . $emailDomain . '%'))
                ->addFieldToFilter('type', Mage::getStoreConfig('hackathon_mailguard/settings/type'));

            /** @var Hackathon_MailGuard_Model_Address $possibleEmailMatch */
            if ($emailCollection->getSize() > 0) {
                foreach ($emailCollection as $possibleEmailMatch) {
                    if (
                        (
                            $emailToCheck == $possibleEmailMatch->getMailaddress()
                            || $emailDomain == $possibleEmailMatch->getMailaddress()
                        )
                        && Mage::getStoreConfig('hackathon_mailguard/settings/type') == Hackathon_MailGuard_Helper_Data::TYPE_WHITELIST
                    ) {
                        $validatedEmails[] = $emailToCheck;
                    } else if (
                        Mage::getStoreConfig('hackathon_mailguard/settings/type') == Hackathon_MailGuard_Helper_Data::TYPE_BLACKLIST
                        && !(
                            $emailToCheck == $possibleEmailMatch->getMailaddress()
                            || $emailDomain == $possibleEmailMatch->getMailaddress()
                        )
                    ) {
                        $validatedEmails[] = $emailToCheck;
                    }
                }
            } else {
                $validatedEmails[] = $emailToCheck;
            }
        }

        if (!empty($validatedEmails)) {
            if ($email instanceof Mage_Core_Model_Email_Template) {
                $email->setValidatedEmails($validatedEmails);
            } else {
                $email->setToEmail($validatedEmails);
            }

            return true;
        }
        return false;
		//$this->setFilter(Hackathon_MailGuard_Helper_Data::TYPE_WHITELIST)
		//$this->setFilter(Hackathon_MailGuard_Helper_Data::TYPE_BLACKLIST)
    }

    private function getDomainFromEmail ($email)
    {
        if (preg_match('/@(.*)$/', $email, $matches)) {
            return $matches[0];
        }
        return false;
    }
	
	/**
     * sets the applied filter
	 * @param int $filter
     */
    public function setFilter($filter)
    {
		$this->_filter = $filter;
    }
	
	/**
     * returns the applied filter
     */
    public function getFilter()
    {
		return $this->_filter;
    }	
		
	/**
     * returns the applied filter name
     */
    public function getFilterName()
    {
		return $this->getFilter()==Hackathon_MailGuard_Helper_Data::TYPE_WHITELIST ? self::EMAIL_FILTER_WHITELIST : self::EMAIL_FILTER_BLACKLIST;
    }
}