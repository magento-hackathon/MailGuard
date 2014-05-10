<?php

class Hackathon_MailGuard_Block_Adminhtml_Address_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'hackathon_mailguard';
        $this->_controller = 'adminhtml_address';

        parent::__construct();

        $this->_updateButton('save', 'label', $this->__('Save Address'));
        $this->_updateButton('delete', 'label', $this->__('Delete Address'));
    }

    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('hackathon_mailguard_address')->getId()) {
            return $this->__('Edit Address');
        }
        else {
            return $this->__('New Address');
        }
    }
}