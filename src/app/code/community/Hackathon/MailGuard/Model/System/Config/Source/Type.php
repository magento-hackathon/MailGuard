<?php

class Hackathon_MailGuard_Model_System_Config_Source_Type
{
    /**
     * Options array for the source model
     *
     * @var array
     */
    protected $_options;

    public function getOptionArray()
    {
        $helper = Mage::helper('hackathon_mailguard');
        return array(
            $helper::TYPE_WHITELIST => $helper->__('Whitelist'),
            $helper::TYPE_BLACKLIST => $helper->__('Blacklist')
        );
    }

    /**
     * Create an array with all the allowed list types
     *
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            /** @var Hackathon_MailGuard_Helper_Data $helper */
            $helper = Mage::helper('hackathon_mailguard');
            $this->_options = array(
                array(
                    'value' => $helper::TYPE_WHITELIST,
                    'label' => $helper->__('Whitelist')
                ),
                array(
                    'value' => $helper::TYPE_BLACKLIST,
                    'label' => $helper->__('Blacklist')
                ),
            );
        }
        return $this->_options;
    }
}