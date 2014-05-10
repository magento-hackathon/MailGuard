<?php

class Hackathon_MailGuard_Block_Adminhtml_Address_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId('hackathon_mailguard_address_form');
        $this->setTitle($this->__('Address Information'));
    }

    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $model = Mage::registry('hackathon_mailguard_address');

        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('address_id' => $this->getRequest()->getParam('address_id'))),
            'method'    => 'post'
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Address Information'),
            'class'     => 'fieldset-wide',
        ));

        if ($model->getId()) {
            $fieldset->addField('address_id', 'hidden', array(
                'name' => 'address_id',
            ));
        }

        $fieldset->addField('mailaddress', 'text', array(
            'name'      => 'mailaddress',
            'label'     => Mage::helper('checkout')->__('Mail Address'),
            'title'     => Mage::helper('checkout')->__('Mail Address'),
            'required'  => true,
        ));

        $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'label'     => Mage::helper('checkout')->__('Type'),
            'title'     => Mage::helper('checkout')->__('Type'),
            'required'  => true,
            'options' => Mage::getSingleton('hackathon_mailguard/system_config_source_type')->getOptionArray(),
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}