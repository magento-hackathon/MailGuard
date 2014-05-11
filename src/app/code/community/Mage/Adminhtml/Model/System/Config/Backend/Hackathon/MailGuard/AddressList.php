<?php

class Mage_Adminhtml_Model_System_Config_Backend_Hackathon_MailGuard_AddressList extends Mage_Core_Model_Config_Data
{
    public function _afterSave()
    {
        Mage::getResourceModel('hackathon_mailguard/address')->uploadAndImport($this);
    }
}
