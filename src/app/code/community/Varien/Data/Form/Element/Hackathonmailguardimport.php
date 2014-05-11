<?php

class Varien_Data_Form_Element_Hackathonmailguardimport extends Varien_Data_Form_Element_Abstract
{
    /**
     * Make this a file upload element.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('file');
    }
}
