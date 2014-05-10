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
 * the Pixelperfect DasGastroPortal module to newer versions in the future.
 * If you wish to customize the Pixelperfect DasGastroPortal module for your needs
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

    /**
     * detemines if the mail can be sent, and sets a property to prevent sending if appropriate
     * @param Varien_Object $email
     */
    public function canSend(Varien_Object $email)
    {

    }
}