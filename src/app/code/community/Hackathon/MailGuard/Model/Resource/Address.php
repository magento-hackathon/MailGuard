<?php

class Hackathon_MailGuard_Model_Resource_Address extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('hackathon_mailguard/address', 'address_id');
    }

}