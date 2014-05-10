<?php

class Hackathon_MailGuard_Block_Adminhtml_Address extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'hackathon_mailguard';
        $this->_controller = 'adminhtml_address';
        $this->_headerText = $this->__('Addresses');

        parent::__construct();
    }
}